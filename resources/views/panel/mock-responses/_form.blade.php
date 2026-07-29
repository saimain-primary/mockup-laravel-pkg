@php
    $method = old('method', $entry['method'] ?? 'GET');
    $path = old('path', $entry['path'] ?? '');
    $status = old('status', $entry['status'] ?? 200);
    $response = old('response', isset($entry) ? json_encode($entry['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : "{\n    \n}");
    $validationRules = old('validation_rules', ! empty($entry['validation_rules'] ?? null)
        ? json_encode($entry['validation_rules'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        : "{}");
@endphp

<div class="field">
    <label for="method">Method</label>
    <select id="method" name="method" class="input" style="width: 140px;">
        @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $option)
            <option value="{{ $option }}" @selected($method === $option)>{{ $option }}</option>
        @endforeach
    </select>
</div>

<div class="field">
    <label for="path">Path</label>
    <div class="path-row">
        <span class="path-prefix">/{{ config('mock-api.api_prefix') }}/</span>
        <input type="text" id="path" name="path" value="{{ $path }}" placeholder="xpress/trips" class="input">
    </div>
</div>

<div class="field">
    <label for="status">Status code</label>
    <input type="number" id="status" name="status" value="{{ $status }}" class="input input-sm">
</div>

@include('mock-api::panel.mock-responses._json-field', [
    'name' => 'validation_rules',
    'label' => 'Validation rules',
    'hint' => '— optional. Laravel rules per field, e.g. {"email": "required|email"}. Leave as {} to skip validation and always return the response below.',
    'value' => $validationRules,
    'height' => '160px',
])

@include('mock-api::panel.mock-responses._json-field', [
    'name' => 'response',
    'label' => 'Response body',
    'hint' => '— JSON, returned when validation passes (or when no rules are set)',
    'value' => $response,
])

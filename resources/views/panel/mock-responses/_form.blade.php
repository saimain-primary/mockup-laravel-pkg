@php
    $method = old('method', $entry['method'] ?? 'GET');
    $path = old('path', $entry['path'] ?? '');
    $status = old('status', $entry['status'] ?? 200);
    $response = old('response', isset($entry) ? json_encode($entry['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : "{\n    \n}");
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

<div class="field">
    <label for="response">Response body <span class="hint">— JSON</span></label>
    <div class="json-editor">
        <pre class="json-editor__highlight" aria-hidden="true"><code></code></pre>
        <textarea id="response" name="response" class="json-editor__textarea" spellcheck="false">{{ $response }}</textarea>
    </div>
    <div class="json-toolbar">
        <button type="button" class="btn btn-text" data-json-format>Format JSON</button>
        <span data-json-status class="json-status"></span>
    </div>
</div>

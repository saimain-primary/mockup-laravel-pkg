@php
    $method = old('method', $entry['method'] ?? 'GET');
    $path = old('path', $entry['path'] ?? '');
    $status = old('status', $entry['status'] ?? 200);
    $response = old('response', isset($entry) ? json_encode($entry['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : "{\n    \n}");
    $validationRules = old('validation_rules', ! empty($entry['validation_rules'] ?? null)
        ? json_encode($entry['validation_rules'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        : "{}");

    $decodedRules = json_decode($validationRules, true);
    $ruleCount = is_array($decodedRules) ? count($decodedRules) : 0;

    $activeTab = ($errors->has('validation_rules') && ! $errors->has('response')) ? 'validation' : 'response';
    $prefix = '/'.config('mock-api.api_prefix').'/';

    $statusCodes = \Saimain\LaravelMockApi\Support\HttpStatusCodes::grouped();
    $showCustomStatus = ! \Saimain\LaravelMockApi\Support\HttpStatusCodes::isKnown((int) $status);
@endphp

<div class="form-section">
    <h2 class="form-section__title">Request</h2>

    <div class="field" id="method-field">
        <label for="method">Method <span class="required">*</span></label>

        <div class="request-line">
            <select id="method" name="method" class="input method-dropdown method-dropdown--{{ strtolower($method) }}">
                @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $option)
                    <option value="{{ $option }}" @selected($method === $option)>{{ $option }}</option>
                @endforeach
            </select>

            <div class="url-bar @if ($errors->has('path')) url-bar--invalid @endif">
                <span class="url-bar__prefix">{{ $prefix }}</span>
                <input
                    type="text"
                    id="path"
                    name="path"
                    value="{{ $path }}"
                    placeholder="xpress/trips"
                    class="url-bar__input"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    @if ($errors->has('path')) aria-invalid="true" @endif
                >
            </div>
        </div>

        <p class="url-bar__preview">Live at <code data-path-preview data-prefix="{{ $prefix }}">{{ $prefix }}{{ $path }}</code></p>

        @error('path')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="{{ $showCustomStatus ? 'status' : 'status-select' }}" data-status-label>Status code <span class="required">*</span></label>

        <div class="status-field">
            <select
                id="status-select"
                @unless ($showCustomStatus) name="status" @endunless
                class="input status-select @if ($errors->has('status')) is-invalid @endif"
                @if ($errors->has('status')) aria-invalid="true" @endif
            >
                @foreach ($statusCodes as $group => $codes)
                    <optgroup label="{{ $group }}">
                        @foreach ($codes as $code => [$phrase, $description])
                            <option
                                value="{{ $code }}"
                                title="{{ $description }}"
                                @selected(! $showCustomStatus && (int) $status === $code)
                            >{{ $code }} — {{ $phrase }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
                <option value="custom" @selected($showCustomStatus)>Custom code…</option>
            </select>

            <input
                type="number"
                id="status"
                @if ($showCustomStatus) name="status" @endif
                value="{{ $status }}"
                class="input status-custom-input @if ($errors->has('status')) is-invalid @endif"
                min="100"
                max="599"
                required
                @unless ($showCustomStatus) hidden @endunless
                @if ($errors->has('status')) aria-invalid="true" @endif
            >
        </div>

        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-section">
    <h2 class="form-section__title">Response</h2>

    <div class="panel-tabs" data-tabs>
        <div class="panel-tabs__list" role="tablist" aria-label="Response configuration">
            <button
                type="button"
                class="panel-tabs__tab"
                role="tab"
                id="tab-response"
                aria-controls="panel-response"
                aria-selected="{{ $activeTab === 'response' ? 'true' : 'false' }}"
                tabindex="{{ $activeTab === 'response' ? 0 : -1 }}"
            >Response body</button>

            <button
                type="button"
                class="panel-tabs__tab"
                role="tab"
                id="tab-validation"
                aria-controls="panel-validation"
                aria-selected="{{ $activeTab === 'validation' ? 'true' : 'false' }}"
                tabindex="{{ $activeTab === 'validation' ? 0 : -1 }}"
            >
                Validation rules
                @if ($ruleCount > 0)
                    <span class="tab-count">{{ $ruleCount }}</span>
                @endif
            </button>
        </div>

        <div class="panel-tabs__panels">
            @include('mock-api::panel.mock-responses._json-field', [
                'name' => 'response',
                'label' => 'Response body',
                'hint' => '— JSON, returned when validation passes (or when no rules are set)',
                'value' => $response,
                'panel' => ['id' => 'panel-response', 'labelledby' => 'tab-response', 'active' => $activeTab === 'response'],
            ])

            @include('mock-api::panel.mock-responses._json-field', [
                'name' => 'validation_rules',
                'label' => 'Validation rules',
                'hint' => '— optional. Laravel rules per field, e.g. {"email": "required|email"}. Leave as {} to skip validation and always return the response above.',
                'value' => $validationRules,
                'height' => '160px',
                'panel' => ['id' => 'panel-validation', 'labelledby' => 'tab-validation', 'active' => $activeTab === 'validation'],
            ])
        </div>
    </div>
</div>

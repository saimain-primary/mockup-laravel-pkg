@php
    $height = $height ?? '320px';
    $hasError = $errors->has($name);
@endphp

<div
    class="field"
    @isset($panel)
        id="{{ $panel['id'] }}"
        data-tab-panel
        role="tabpanel"
        aria-labelledby="{{ $panel['labelledby'] }}"
        @if (! $panel['active']) hidden @endif
    @endisset
>
    <label for="{{ $name }}">{{ $label }} @isset($hint)<span class="hint">{{ $hint }}</span>@endisset</label>
    <div class="json-editor @if ($hasError) json-editor--invalid @endif" style="height: {{ $height }};">
        <pre class="json-editor__highlight" aria-hidden="true"><code></code></pre>
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="json-editor__textarea"
            spellcheck="false"
            @if ($hasError) aria-invalid="true" @endif
        >{{ $value }}</textarea>
    </div>
    <div class="json-toolbar">
        <button type="button" class="btn btn-text" data-json-format>Format JSON</button>
        <span data-json-status class="json-status"></span>
    </div>
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

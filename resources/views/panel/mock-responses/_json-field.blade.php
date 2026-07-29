@php
    $height = $height ?? '320px';
@endphp

<div class="field">
    <label for="{{ $name }}">{{ $label }} @isset($hint)<span class="hint">{{ $hint }}</span>@endisset</label>
    <div class="json-editor" style="height: {{ $height }};">
        <pre class="json-editor__highlight" aria-hidden="true"><code></code></pre>
        <textarea id="{{ $name }}" name="{{ $name }}" class="json-editor__textarea" spellcheck="false">{{ $value }}</textarea>
    </div>
    <div class="json-toolbar">
        <button type="button" class="btn btn-text" data-json-format>Format JSON</button>
        <span data-json-status class="json-status"></span>
    </div>
</div>

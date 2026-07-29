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
    <label for="{{ $name }}-editor">{{ $label }} @isset($hint)<span class="hint">{{ $hint }}</span>@endisset</label>
    <div
        id="{{ $name }}-editor"
        class="json-editor @if ($hasError) json-editor--invalid @endif"
        contenteditable="true"
        spellcheck="false"
        role="textbox"
        aria-multiline="true"
        data-json-editor="{{ $name }}"
        style="height: {{ $height }};"
        @if ($hasError) aria-invalid="true" @endif
    >{{ $value }}</div>
    <textarea id="{{ $name }}" name="{{ $name }}" hidden>{{ $value }}</textarea>
    <div class="json-toolbar">
        <span data-json-status class="json-status"></span>
    </div>
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

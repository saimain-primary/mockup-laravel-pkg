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
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        class="json-textarea @if ($hasError) json-textarea--invalid @endif"
        style="height: {{ $height }};"
        spellcheck="false"
        @if ($hasError) aria-invalid="true" @endif
    >{{ $value }}</textarea>
    <div class="json-toolbar">
        <span data-json-status class="json-status"></span>
    </div>
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

@extends('mock-api::layout')

@section('title', $entry['method'].' /'.config('mock-api.api_prefix').'/'.$entry['path'].' — Docs')

@section('content')
    @php
        $prefix = '/'.config('mock-api.api_prefix').'/';
        $baseUrl = rtrim(config('app.url'), '/');
        $fullUrl = $baseUrl.$prefix.$entry['path'];
        $responseJson = json_encode($entry['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $rules = $entry['validation_rules'] ?? [];
        $phrase = \Saimain\LaravelMockApi\Support\HttpStatusCodes::phrase((int) $entry['status']);
    @endphp

    <div class="topbar">
        <div>
            <span class="docs-eyebrow">API Documentation</span>
            <h1>
                <span class="method-badge method-badge--{{ strtolower($entry['method']) }} method-badge--lg">{{ $entry['method'] }}</span>
                <code>{{ $prefix }}{{ $entry['path'] }}</code>
            </h1>
            @if (! empty($entry['description']))
                <p class="subtitle">{{ $entry['description'] }}</p>
            @endif
        </div>
        <a href="{{ route('mock-api.panel.mock-responses.edit', $entry['id']) }}" class="btn btn-secondary">Edit endpoint</a>
    </div>

    <div class="docs-grid">
        <section class="docs-card">
            <h2 class="docs-card__title">Request</h2>
            <dl class="docs-meta">
                <div class="docs-meta__row">
                    <dt>Endpoint</dt>
                    <dd><code>{{ $prefix }}{{ $entry['path'] }}</code></dd>
                </div>
                <div class="docs-meta__row">
                    <dt>Live URL</dt>
                    <dd>
                        <a href="{{ $fullUrl }}" target="_blank" rel="noopener noreferrer" class="docs-link">
                            {{ $fullUrl }}
                            <svg class="external-icon" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M8 4H5.5A1.5 1.5 0 0 0 4 5.5v9A1.5 1.5 0 0 0 5.5 16h9a1.5 1.5 0 0 0 1.5-1.5V12M12 4h4v4M16 4l-7 7" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </dd>
                </div>
                <div class="docs-meta__row">
                    <dt>Status</dt>
                    <dd>{{ $entry['status'] }} @if ($phrase)<span class="hint">— {{ $phrase }}</span>@endif</dd>
                </div>
            </dl>
        </section>

        <section class="docs-card">
            <h2 class="docs-card__title">Response body</h2>
            <pre class="docs-code" data-json-view><code>{{ $responseJson }}</code></pre>
        </section>

        <section class="docs-card">
            <h2 class="docs-card__title">Validation rules</h2>
            @if (empty($rules))
                <p class="docs-empty-note">No validation rules set — this endpoint always returns the response above.</p>
            @else
                <div class="docs-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Rules</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rules as $field => $rule)
                                <tr>
                                    <td><code>{{ $field }}</code></td>
                                    <td>{{ is_array($rule) ? implode('|', $rule) : $rule }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="docs-empty-note">On failure, returns <code>422</code> with the validation error base shown for this package (see README).</p>
            @endif
        </section>
    </div>
@endsection

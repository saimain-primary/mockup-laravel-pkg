@extends('mock-api::layout')

@section('title', $entry['method'].' /'.config('mock-api.api_prefix').'/'.$entry['path'])

@section('content')
    <div class="topbar">
        <div>
            <h1>{{ $entry['method'] }} <code>/{{ config('mock-api.api_prefix') }}/{{ $entry['path'] }}</code></h1>
            <p class="subtitle">Update the method, path, or response body.</p>
        </div>
        <a href="{{ route('mock-api.panel.docs.show', $entry['id']) }}" class="btn btn-secondary">View docs</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            <strong>{{ $errors->count() === 1 ? 'Please fix the following:' : 'Please fix ' . $errors->count() . ' issues:' }}</strong>
            <ul>
                @foreach ($errors->keys() as $field)
                    <li><a href="#{{ $field === 'method' ? 'method-field' : $field }}">{{ $errors->first($field) }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel" style="padding: 24px;">
        <form id="mock-response-form" method="POST" action="{{ route('mock-api.panel.mock-responses.update', $entry['id']) }}">
            @csrf
            @method('PUT')
            @include('mock-api::panel.mock-responses._form')
        </form>

        <form
            id="mock-response-delete-form"
            method="POST"
            action="{{ route('mock-api.panel.mock-responses.destroy', $entry['id']) }}"
            onsubmit="return confirm('Delete this mock endpoint?')"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="actions-row">
            <button type="submit" form="mock-response-form" class="btn btn-primary">Save changes</button>
            <a href="{{ route('mock-api.panel.mock-responses.edit', $entry['id']) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" form="mock-response-delete-form" class="btn-danger-text" style="margin-left: auto;">Delete endpoint</button>
        </div>
    </div>
@endsection

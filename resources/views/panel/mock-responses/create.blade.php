@extends('mock-api::layout')

@section('title', 'New Mock Endpoint')

@section('content')
    <div class="topbar">
        <div>
            <h1>New Mock Endpoint</h1>
            <p class="subtitle">Define a method, path, and response body to serve for frontend development.</p>
        </div>
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
        <form method="POST" action="{{ route('mock-api.panel.mock-responses.store') }}">
            @csrf
            @include('mock-api::panel.mock-responses._form')

            <div class="actions-row">
                <button type="submit" class="btn btn-primary">Create endpoint</button>
                <a href="{{ route('mock-api.panel.mock-responses.create') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

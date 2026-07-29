@extends('mock-api::layout')

@section('title', 'API Documentation')

@section('content')
    <div class="topbar">
        <div>
            <span class="docs-eyebrow">API Documentation</span>
            <h1>No endpoints yet</h1>
            <p class="subtitle">Create an endpoint to see its documentation here.</p>
        </div>
        <a href="{{ route('mock-api.panel.mock-responses.create') }}" class="btn btn-primary">New endpoint</a>
    </div>
@endsection

@extends('mock-api::layout')

@section('title', 'New Mock Endpoint')

@section('content')
    <div class="topbar">
        <div>
            <h1>New Mock Endpoint</h1>
            <p class="subtitle">Define a method, path, and response body to serve for frontend development.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel" style="padding: 24px;">
        <form method="POST" action="{{ route('mock-api.panel.mock-responses.store') }}">
            @csrf
            @include('mock-api::panel.mock-responses._form')

            <div class="actions-row">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('mock-api.panel.mock-responses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection

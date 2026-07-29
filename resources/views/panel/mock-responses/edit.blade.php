@extends('mock-api::layout')

@section('title', 'Edit Mock Endpoint')

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Mock Endpoint</h1>
            <p class="subtitle">Update the method, path, or response body.</p>
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
        <form method="POST" action="{{ route('mock-api.panel.mock-responses.update', $entry['id']) }}">
            @csrf
            @method('PUT')
            @include('mock-api::panel.mock-responses._form')

            <div class="actions-row">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('mock-api.panel.mock-responses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection

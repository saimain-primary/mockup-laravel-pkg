@extends('mock-api::layout')

@section('title', 'Mock API Responses')

@section('content')
    <div class="topbar">
        <div>
            <h1>Mock API Responses</h1>
            <p class="subtitle">Endpoints available under <code>/{{ config('mock-api.api_prefix') }}/*</code> for frontend development.</p>
        </div>
        <a href="{{ route('mock-api.panel.mock-responses.create') }}" class="btn btn-primary">+ New endpoint</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Path</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $entry)
                    <tr>
                        <td><span class="method-badge">{{ $entry['method'] }}</span></td>
                        <td><code>/{{ config('mock-api.api_prefix') }}/{{ $entry['path'] }}</code></td>
                        <td>{{ $entry['status'] }}</td>
                        <td style="text-align: right;">
                            <a href="{{ route('mock-api.panel.mock-responses.edit', $entry['id']) }}">Edit</a>
                            &nbsp;·&nbsp;
                            <form method="POST" action="{{ route('mock-api.panel.mock-responses.destroy', $entry['id']) }}" style="display: inline;" onsubmit="return confirm('Delete this mock endpoint?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-text">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No mock endpoints yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

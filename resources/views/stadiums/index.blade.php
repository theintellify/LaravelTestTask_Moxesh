@extends('main')

@section('content')

    <div class="card">
        <div class="card-header">Cricket Stadiums</div>
        <div class="card-body container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('stadiums.create') }}" class="btn btn-success">Add Cricket Stadium</a>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($stadiums as $stadium)
                    <tr>
                        <td>{{ $stadium->name }}</td>
                        <td>{{ $stadium->description ?: 'N/A' }}</td>
                        <td>{{ ucfirst($stadium->status) }}</td>
                        <td>{{ $stadium->file }}</td>
                        <td>
                            <a href="{{ route('stadiums.show', $stadium->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('stadiums.edit', $stadium->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('stadiums.destroy', $stadium->id) }}" method="post"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this stadium?')">Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No stadiums found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{--<div class="d-flex justify-content-center">
                {{ $stadiums->links() }}
            </div>--}}

        </div>
    </div>

@endsection

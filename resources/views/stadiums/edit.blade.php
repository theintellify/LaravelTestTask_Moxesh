@extends('main')

@section('content')

    <div class="card">
        <div class="card-header">Edit Cricket Stadium</div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('stadiums.update', $stadium->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Stadium Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $stadium->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $stadium->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" {{ $stadium->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $stadium->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">3D Object File</label>
                    <input type="file" class="form-control" id="file" name="file">
                    @if($errors->has('file'))
                        <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update Stadium</button>
                </div>
            </form>

        </div>
    </div>

@endsection

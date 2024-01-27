@extends('main')

@section('content')

    <div class="card">
        <div class="card-header">Edit Advertising Section</div>
        <div class="card-body container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('advertising-sections.update', $section->id) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="stadium_id" class="form-label">Select Stadium</label>
                    <select class="form-select" id="stadium_id" name="stadium_id" required>
                        <option value="" disabled>Select Stadium</option>
                        @foreach($stadiums as $stadium)
                            <option
                                value="{{ $stadium->id }}" {{ $section->stadium_id == $stadium->id ? 'selected' : '' }}>{{ $stadium->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $section->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description"
                              name="description">{{ old('description', $section->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="current_file" class="form-label">Current File</label>
                @if ($section->file_type == 1)
                    <!-- Display image -->
                        <img src="{{ asset('sections/' . $section->file) }}"
                             style="height: auto; width: auto; max-height: 200px; max-width: 200px;"
                             alt="Image">
                @elseif ($section->file_type == 2)
                    <!-- Display video -->
                        <video width="320" height="240" controls style="max-width: 100%; max-height: 100%;">
                            <source src="{{ asset('sections/' . $section->file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                @elseif ($section->file_type == 3)
                    <!-- Display audio -->
                        <audio controls>
                            <source src="{{ asset('sections/' . $section->file) }}" type="audio/mp3">
                            Your browser does not support the audio tag.
                        </audio>
                @else
                    <!-- Handle other file types if needed -->
                        Unsupported file type
                    @endif
                </div>

                <div class="mb-3">
                    <label for="update_file" class="form-check-label">
                        <input type="checkbox" id="update_file" name="update_file"> Update File
                    </label>
                    <input type="file" class="form-control" id="file" name="file" accept="image/*, video/*, audio/*"
                           style="display: none;">
                    @error('file')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" {{ old('status', $section->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive" {{ old('status', $section->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <!-- Add other form fields as needed -->

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Advertising Section</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.getElementById('update_file').addEventListener('change', function () {
            const fileInput = document.getElementById('file');
            fileInput.style.display = this.checked ? 'block' : 'none';
        });
    </script>

@endsection

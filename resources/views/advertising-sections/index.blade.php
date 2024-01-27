@extends('main')

@section('content')

    <div class="card">
        <div class="card-header">Advertising Sections</div>
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
                <a href="{{ route('advertising-sections.create') }}" class="btn btn-success">Add Advertising Section</a>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>Stadium Name</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($advertisingSections as $section)
                    <tr>
                        <td>{{ $section->stadium->name }}</td>
                        <td>{{ $section->name }}</td>
                        <td>{{ $section->description ?: 'N/A' }}</td>
                    @if ($section->file_type == 1)
                        <!-- Display image -->
                            <td><img src="{{ asset('sections/' . $section->file) }}"
                                     style="height: auto; width: auto; max-height: 200px; max-width: 200px;"
                                     alt="Image"></td>
                    @elseif ($section->file_type == 2)
                        <!-- Display video -->
                            <td>
                                <video width="320" height="240" controls style="max-width: 100%; max-height: 100%;">
                                    <source src="{{ asset('sections/' . $section->file) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </td>
                    @elseif ($section->file_type == 3)
                        <!-- Display audio -->
                            <td>
                                <audio controls>
                                    <source src="{{ asset('sections/' . $section->file) }}" type="audio/mp3">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                    @else
                        <!-- Handle other file types if needed -->
                            <td>Unsupported file type</td>
                        @endif
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="switch-action-{{ $section->id }}"
                                       {{ $section->status === 'active' ? 'checked' : '' }} onchange="updateStatus(this, {{ $section->id }})">
                                <label class="form-check-label" for="switch-action-{{ $section->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('advertising-sections.edit', $section->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('advertising-sections.destroy', $section->id) }}" method="post"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this advertising section?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No advertising sections found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function updateStatus(checkbox, sectionId) {
            checkbox.disabled = true; // Disable the checkbox during the AJAX request
            axios.patch('/advertising-sections/' + sectionId + '/update-status', {status: 'new-status'})
                .then(response => {
                    console.log(response.data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                });
        }
    </script>

@endsection

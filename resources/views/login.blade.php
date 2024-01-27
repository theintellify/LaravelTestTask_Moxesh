@extends('main')

@section('content')

    @if($message = Session::get('success'))
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-header bg-dark text-white text-center">Login</div>
                <div class="card-body">
                    <form action="{{ route('sample.validate_login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Email"/>
                            @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                   id="password"/>
                            <div class="position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon" style="cursor: pointer;"></i>
                            </div>
                            @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>

@endsection

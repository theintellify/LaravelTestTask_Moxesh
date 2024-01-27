<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cricket Stadium Advertising</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            position: relative;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body::after {
            content: "";
            background: url('https://source.unsplash.com/1920x1080/?cricket stadium') center/cover no-repeat;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5; /* Set opacity to 0.5 */
        }

        .navbar {
            background-color: #343a40 !important;
            color: #fff !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            flex: 1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1976D2;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Cricket Stadium Advertising</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            @guest
                <!-- Guest links -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('registration') ? 'active' : '' }}"
                           href="{{ route('registration') }}">Register</a>
                    </li>
            @else
                <!-- Authenticated links -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logout') ? 'active' : '' }}"
                           href="{{ route('logout') }}">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stadiums.index') || request()->routeIs('stadiums.create') ? 'active' : '' }}"
                           href="{{ route('stadiums.index') }}">Cricket Stadium</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('advertising-sections.index') || request()->routeIs('advertising-sections.create') || request()->routeIs('stadiums.show') ? 'active' : '' }}"
                           href="{{ route('advertising-sections.index') }}">Advertising Section</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@auth
    <!-- Separate navbar for displaying user's name -->
    <nav class="navbar navbar-dark" style="background-color: #1976D2;">
        <div class="container">
            <div class="navbar-text text-light">
                Welcome, {{ auth()->user()->name }}
            </div>
        </div>
    </nav>
@endauth


<div class="container mt-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

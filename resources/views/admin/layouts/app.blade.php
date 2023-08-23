<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-slate-950 shadow-sm sticky-top">
            <div class="container-fluid">
               <div style="width: 20%" class="text-center">
                @yield('nav-title')
               </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item"><a href="{{ route('article.create') }}" class="nav-link text-white">+ New
                                    Article</a></li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="{{ url('/home') }}" class="dropdown-item">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="me-2">
            <div class="d-flex">
                <div class="position-fixed bg-slate-950" style="width: 20%; height: 100vh;">
                    <div class="card border-0 shadow h-100 bg-slate-950">
                        <div class="card-body">
                            <h5 class="text-center">Opeartions</h5>
                            <div class="">
                                @can('view-dashboard')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-sm btn-light w-100 my-1">Users</a>
                                @endcan
                                <a href="{{ url('/log-viewer') }}"
                                    class="btn btn-sm btn-warning w-100 my-1">View Logs</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <input type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800 w-100 my-1"
                                        value="Logout">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 78%" class="ms-auto mt-3">
                    @yield('content')
                </div>
            </div>

    </div>
</body>

</html>

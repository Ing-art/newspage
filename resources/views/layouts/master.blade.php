<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Newspage">

    <!--Title-->
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!--CSS files-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>



</head>

<body class="publication-site">
{{--     @env(['local', 'test'])
    <div class="alert alert-warning text-center">
        <p><b>ATTENTION: </b>in local / test mode </p>
    </div>
    @endenv --}}

    @section('menu')

        {{-- @php($page = $page ?? '') --}}
        @php($page = Route::currentRouteName())

        <header class="site-header">
        <div class="container-xl px-3 px-lg-4">
            <div class="logo-wrapper text-center">
                <p class="masthead-kicker mb-2">Independent stories · Global perspective</p>
                <h1 class="site-title mb-0">
                    <a class="logo" href="{{ route('homepage') }}">MadWorld News</a>
                </h1>
            </div>
            <nav class="navbar navbar-expand-md navbar-dark site-navbar" aria-label="Main navigation">
                <div class="container-fluid px-3 px-md-4">
                    <a class="navbar-brand {{ $page == 'homepage' ? 'active' : '' }}" href="{{ route('homepage') }}">Home</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
{{--                             <li class="nav-item">
                                <a class="nav-link {{ $page == 'review' ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('homepage') }}">Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $page == 'newarticle' ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('articles.create') }}">New Article</a>
                            </li> --}}


                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $page == 'contact' ? 'active' : '' }}"
                                    href="{{ route('contact') }}">Contact</a>
                            </li>

                            <!--FOR GUESTS-->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif

                                <!--FOR REGISTERED USERS-->
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        {{-- <a class="dropdown-item" href="{{ route('homepage') }}">My Articles</a> --}}
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        @if (Auth::user())
                                            <a class="dropdown-item"
                                                href="{{ route('dashboard', Auth::user()->id) }}">Dashboard</a>
                                        @endif
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                        {{--                         <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-warning" type="submit">Search</button>
                        </form> --}}
                    </div>
                </div>
            </nav>
        @show
        </div>
        </header>

        <main class="container-xl px-3 px-lg-4">


            <!--Success and Error messages -->
            <!-- @includeWhen(Session::has('success'), 'layouts.success')
            @includeWhen($errors->any(), 'layouts.error') -->

            <!--Slot component for success / error message -->
            @if (Session::has('success'))
                <x-alert type="success" message="{{ Session::get('success') }}"></x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="danger" message="There are some errors:">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif


            <!--Main Content-->
            @yield('body')

            @section('link')
                <div class="page-links d-flex justify-content-center gap-4">
                    <span>
                        <a href="#">Back to top</a>
                    </span>
                    @if ($page != 'homepage')
                    <span>
                        <a href="{{ url()->previous() }}">Back</a>
                    </span>
                    @endif
                </div>
            @show

            <!--FOOTER SECTION -->

            <footer class="page-footer">
                <p class="small mb-0">
                    Created with <b>Laravel</b> and <b>Bootstrap</b> by <i>{{ $author }}</i>
                    <!--Defined in AppServiceProvider-->
                </p>
            </footer>
        </main>
</body>

</html>

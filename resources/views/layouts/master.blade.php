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

    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

</head>

<body class="m-3">
    @env(['local', 'test'])
    <div class="alert alert-warning text-center"> 
        <p><b>ATTENTION: </b>in local / test mode </p>
    </div>
    @endenv

    @section('menu')

    {{-- @php($page = $page ?? '') --}}
        @php($page = Route::currentRouteName())
        
        <div class="container-fluid ">
            <div class="logo-wrapper ">
                <h1 class="display-1 text-center border">
                    <a class="text-decoration-none logo text-center" href="index.php">MadWorld News</a>
                </h1>
            </div>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand {{$page == 'homepage' ? 'active': ''}}" href="{{ route('homepage') }}">MWN</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{$page == 'review' ? 'active': ''}}" aria-current="page" href="{{ route('homepage') }}">Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$page == 'newarticle' ? 'active': ''}}" aria-current="page" href="{{ route('articles.create') }}">New Article</a>
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
                                        <a class="dropdown-item" href="{{ route('homepage') }}">My Articles</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        @if (!Auth::user()->hasRole('admin'))
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

        <main>


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
            <p class="mb-5 mx-5">
                <a href="#">Back to top</a>
            </p>
            @show
            
            <!--FOOTER SECTION -->

            <footer class="page-footer font-small p-4 bg-light">
                <p class="text-end small">
                    Created with <b>Laravel</b> and <b>Bootstrap</b> by <i>{{$author}}</i> <!--Defined in AppServiceProvider-->
                </p>
            </footer>
        </main>
</body>

</html>

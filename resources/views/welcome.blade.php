<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | MadWorld News</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script src="/js/bootstrap.bundle.js"></script>
</head>

<body class="m-3">

{{--     <div id="loader"></div>

    <div style="display:none;" id="myDiv" class="animate-bottom">
    </div>

    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 5);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }
    </script> --}}

    <div class="container-fluid ">
        <div class="logo-wrapper ">
            <h1 class="display-1 text-center border">
                <a class="text-decoration-none logo text-center" href="index.php">MadWorld News</a>
            </h1>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('homepage') }}">MWN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-warning" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        @if ($articles->currentPage() == 1)
            <!--TOP NEWS-->
            <section class="col-12 mt-4" id="headlines">
                
                <div class="block-title text-center">
                    <h4 class="h4 border-warning">
                        <span class="bg-warning text-black"><b>TOP NEWS</b></span>
                    </h4>
                </div>
                <div class="card-group row row-cols-1 row-cols-md-2 g-4">
                    @foreach($toparticles as $toparticle)
                    <div class="col">
                        <article class="card bg-dark text-white zoom overflow-hidden">
                            <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                                <div class="w-100 p-3 m-0">
                                    <span class="card-text d-none d-md-block">{{$toparticle->subject}}</span>
                                    <h3 class="card-title">{{$toparticle->headline}}</h3>
                                    <div>
                                        <span class="card-text d-none d-md-block">by {{$toparticle->user->name}}</span>
                                        <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                    </div>
                                </div>
                            </div>
                        </article>
 {{--                    </div>
                    <div class="col">
                        <article class="card bg-dark text-white zoom overflow-hidden">
                            <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                                <div class="w-100 p-3 m-0">
                                    <h3 class="card-title ">Bear wants to be the next president</h3>
                                    <div>
                                        <span class="card-text d-none d-md-block">by Author |</span>
                                        <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                    
                </div>
                @endforeach
            </section>
        @endif
        <!--MORE  NEWS SECTION-->

        <section class="col-12 mt-4" id="morenews">

            <div class="block-title text-center">
                <h4 class="h4 border-warning">
                    <span class="bg-info text-black"><b>OTHER NEWS</b></span>
                </h4>
            </div>
            
            <!--MORE NEWS CONTENT BLOCK-->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($articles as $article)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('images/articles/test.jpeg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><b>{{ $article->headline }}</b></h5>
                                <div>
                                    <span class="card-text text-muted small">{{$article->subject}} | </span>
                                    <span class="card-text text-muted small">By {{ $article->user->name }}</span>
                                </div>
                                <p class="card-text">{{ $article->text }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--pagination links-->
            <div class="col-12 d-flex justify-content-center mt-4">{{ $articles->links() }}</div>         
        </section>
    </div>
</body>
</html>

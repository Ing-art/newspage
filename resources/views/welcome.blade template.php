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
    <div class="container-fluid ">
        <div class="logo-wrapper ">
            <h1 class="display-1 text-center border">
                <a class="text-decoration-none logo text-center" href="index.php">MadWorld News</a>
            </h1>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">MWN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
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
        <section id="mainstory" class="row text-center row-cols-1 row-cols-md-1 g-4">
            <div class="col">
                <article class="card bg-dark text-white zoom overflow-hidden">
                    <img class="card-img img-fluid ratio-16x9" src="{{ asset('images/articles/test.jpeg') }}">
                    <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                        <div class="w-100 p-3 m-0">
                            <h2 class="card-title fs-sm-2">Bear says 'see you later alligator' and starts dancing
                            </h2>
                            <div>
                                <span class="card-text d-none d-md-block">By Author |</span>
                                <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <section class="mt-3" id="headlines">
            <div class="card-group row row-cols-sm-2 row-cols-md-2 g-4">
                <div class="col">
                    <article class="card bg-dark text-white zoom overflow-hidden">
                        <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                            <div class="w-100 p-3 m-0">
                                <h3 class="card-title fs-sm-6 d-none d-md-block">Bear walks out from a restaurant'</h3>
                                <div>
                                    <span class="card-text d-none d-md-block">by Author |</span>
                                    <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col">
                    <article class="card bg-dark text-white zoom overflow-hidden">
                        <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                            <div class="w-100 p-3 m-0">
                                <h3 class="card-title fs-sm-6 d-none d-md-block">Bear wants to be the next president</h3>
                                <div>
                                    <span class="card-text d-none d-md-block">by Author |</span>
                                    <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!--MORE  NEWS SECTION-->

        <section class="col-12 mt-4" id="morenews">
            <div class="block-area">
                <div class="block-title">
                    <h4 class="h4 border-warning">
                        <span class="bg-warning text-black">More News</span>
                    </h4>
                </div>
                <!--MORE NEWS CONTENT BLOCK-->
                <div class="border row" style="min-height:20rem; padding:0">
                    <!--big post on the left-->
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                        <article class="card card-full overflow-hidden">
                            <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}"
                                style="max-height:200px; width:auto; object-fit:cover;">
                            <div class="card-body mt-2">
                                <h2 class="card-title fw-bold h3-sm h1-md h3-lg">Bears can now park everywhere</h2>
                                <div class="card-text mb-2 text-muted small">
                                    <!--author-->
                                    <span class="d-none d-sm-inline me-1">Author</span>
                                    <!--date-->
                                </div>
                                <!--text-->
                                <div>
                                    <p class="card-text lateral-article">Lorem ipsum dolor sit amet, consectetur adipiscing
                                        elit. Proin efficitur enim vitae libero rhoncus mattis. Donec tristique laoreet
                                        nisi. Ut pulvinar est ornare nisi iaculis finibus. Donec pharetra finibus erat, at
                                        tincidunt magna fermentum vitae. Phasellus vestibulum tincidunt sapien, eget
                                        ultrices tellus mattis at. Etiam aliquam purus urna, at pharetra massa egestas id.
                                        Ut scelerisque ullamcorper nibh id sollicitudin. Maecenas venenatis rutrum
                                        faucibus. Donec vel leo accumsan, consectetur tortor ut, cursus metus. Praesent eu
                                        dignissim metus. Pellentesque consectetur et enim eu sagittis. Sed nec odio eu risus
                                        mollis pellentesque quis eget mauris. In vitae turpis congue, malesuada nisi quis,
                                        molestie quam. Sed eros sapien, eleifend nec tortor non, rutrum sagittis diam.
                                        Pellentesque hendrerit mauris vel rutrum porttitor. Orci varius natoque penatibus et
                                        magnis dis parturient montes, nascetur ridiculus mus.</p>
                                </div>
                            </div>
                        </article>
                    </div>
        
                    <!--posts on the right-->
                    <div class="col-sm-12 col-md-8 col-lg-8 mb-3 border">
                        <article class="card mb-4">
                            <div class="row align-items-center no-gutters"> <!-- Added align-items-center to vertically center content -->
                                <!--Thumbnail-->
                                <div class="col-3 col-sm-5 col-md-3"> <!-- Set min-width and max-width -->
                                    <img class="img-fluid" src="{{ asset('images/articles/test.jpeg') }}" alt="Thumbnail" style="width: 100%;">
                                </div>
                                <div class="col-9 col-md-9">
                                    <div class="card-body">
                                        <!--title-->
                                        <h3 class="card-title">Bear goes to Hollywood</h3>
                                        <div class="card-text small text-muted">
                                            <time class="news-date d-none d-md-block" date-time="2024-07-07T02:12:03+00:00">
                                                July 7, 2024</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div> <!--END OF RIGHT POSTS-->
                </div> <!--END OF MORE NEWS-->
            </div>
        </section>
        
        


        
    </div>
</body>

</html>

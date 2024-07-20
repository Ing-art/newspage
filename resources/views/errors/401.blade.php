<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <title>401 Error</title>
</head>

<body>
    <main>
        <div class="container-fluid p-5 bg-secondary text-white text-center">
            <h1 class="my-2 text-center">{{config('app.name')}}</h1>
            <h2>{{$exception->getMessage() }}</h2>
        </div>
        <figure class="row mt-2 mb-2 col-10 offset-1">
            <img class="d-bloc w-100" alt="waiting" src="{{asset('images/articles/test.jpeg')}}>
        </figure>

    </main>

</body>

</html>
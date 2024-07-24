<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            @php
                include 'css/bootstrap.css';
            @endphp
        </style>
    </head>
    <body class="container p-3">
        <header class="container row bg-light p-4 my-4">
        </header>
        <main>
            @php
                $baseurl = 'http://localhost:8000/articles/';
                $path = $published->id;
                $url = $baseurl.$path;
            @endphp
            <h1>Your article has been published!</h1>
            <h2>{{$published->headline}}</h2>
            <a href="{{$url}}">Link</a>

        </main>
        <footer class="page-footer font-small p-4 my-4 bg-light">
            <p>App developped by {{$author}} with <b> Laravel </b> and
                <b> Bootstrap </b> </p>
        </footer>
    </body>
</html>
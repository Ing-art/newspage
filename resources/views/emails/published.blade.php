<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body { background: #f7f6f2; color: #171717; font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 32px; }
            main { background: #ffffff; border: 1px solid #dedbd3; margin: 24px auto; max-width: 640px; padding: 32px; }
            h1, h2 { font-family: Georgia, serif; }
            h1 { color: #8f2432; margin-top: 0; }
            a { color: #8f2432; font-weight: bold; }
            footer { color: #696969; font-size: 12px; margin: 0 auto; max-width: 706px; }
        </style>
    </head>
    <body class="container p-3">
        <header class="container row bg-light p-4 my-4">
        </header>
        <main>
            @php
                $url = route('articles.show', $published->id);
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

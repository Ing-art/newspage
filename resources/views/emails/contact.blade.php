<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!--Bootstrap CSS-->
        <style>
            @php
                include 'css/bootstrap.css'
            @endphp

        </style>
    </head>
    <body class="container p-3">
        <h1 class="col-10">{{config('app.name')}}</h1>
        <main>
            <h2>Message recieved: {{$message->subject}}</h2>
            <p>From: {{$message->name}} <a href="mailto: {{ $message->email }}">&lt;
                {{$message->email }}&gt;</a>
            </p>
            <p>{{ $message->msg }}</p>
        </main>
        <footer class="page-footer font-small p-4 my-4 bg-light">
            <p>Created by {{ $author }}. Developped with <b>Laravel</b> and <b>Bootstrap</b>
        </footer>
    </body>
</html>

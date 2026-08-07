<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Editorial theme -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>
    <body class="breeze-body antialiased">
        <div class="auth-shell min-h-screen">
            <aside class="auth-editorial-panel">
                <a class="auth-brand" href="{{ route('homepage') }}">MadWorld News</a>

                <div class="auth-editorial-copy">
                    <p class="auth-eyebrow">Independent digital magazine</p>
                    <h2>Stories worth<br>your attention.</h2>
                    <p>Read beyond the headline. Join a community built around independent voices and thoughtful reporting.</p>
                </div>

                <p class="auth-panel-footer mb-0">Culture · Society · Ideas · Current affairs</p>
            </aside>

            <main class="auth-main">
                <div class="auth-form-wrap">
                    <a class="auth-mobile-brand" href="{{ route('homepage') }}">MadWorld News</a>

                    <div class="auth-intro">
                        <p class="section-kicker mb-2">Member area</p>
                        <h1>{{ $title ?? __('Your account') }}</h1>
                        <p>{{ $subtitle ?? __('Access your account and continue reading.') }}</p>
                    </div>

                    <div class="auth-card">
                        {{ $slot }}
                    </div>

                    <a class="auth-return" href="{{ route('homepage') }}">
                        <span aria-hidden="true">←</span> Back to the publication
                    </a>
                </div>
            </main>
        </div>
    </body>
</html>

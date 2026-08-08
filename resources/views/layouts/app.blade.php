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
        <div class="breeze-shell min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="breeze-page-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="breeze-content">
                <div class="container-xl px-3 px-lg-4 pt-3">
                    @if (session()->has('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if (session()->has('error'))
                        <x-alert type="danger" :message="session('error')" />
                    @endif

                    @if (session()->has('message'))
                        <x-alert type="warning" :message="session('message')" />
                    @endif

                    @if ($errors->any())
                        <x-alert type="danger" message="There are some errors:">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif
                </div>

                {{ $slot }}
            </main>
        </div>
    </body>
</html>

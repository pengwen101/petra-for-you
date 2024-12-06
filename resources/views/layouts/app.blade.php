<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        {{-- jquery --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <style>
            nav{
                transition: all 0.64s ease;
            }
        </style>
    </head>
    <body class="bg-light-cream font-sans antialiased overflow-x-hidden">
        <div class="min-h-screen bg-light-cream dark:bg-gradient-to-r dark:from-blue-900 dark:to-blue-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let lastScrollTop = 0;
            $(window).on('scroll', function() {
                let currentScrollTop = $(this).scrollTop(); 
                if (currentScrollTop > lastScrollTop) {
                    $('nav').attr("style", "transform:translateY(-100%)")
                } else {
                    $('nav').attr("style", "translateY(0)");
                }
                lastScrollTop = currentScrollTop; 
            });
        });
    </script>

    @stack('scripts')
</html>

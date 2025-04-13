<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        @include('includes.head')
    </head>
    <body class="h-100">
        <div class="bg-site-image">
            @if($header)
            <div class="container">
                <header class="d-flex flex-column justify-content-center">
                    @include('includes.header')
                </header>
            </div>
            @endif
            <div class="container">
                <div class="row">
                    @yield('content')
                </div>
            </div>
            @if($footer)
            <div class="container">
                <footer class="mx-auto">
                    @include('includes.footer')
                </footer>
            </div>
            @endif
        </div>
        @include('includes.js')
    </body>
    <style>
        .bg-site-image {
            background-image: url('{{ theme_image('Nissan_Elite_bg.jpg') }}');
        }
    </style>
</html>

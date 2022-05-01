<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        @include('includes.head')
    </head>
    <body class="h-100">
        <div class="container-fluid" id="main">
            @if($header)
                <header class="d-flex flex-column justify-content-center">
                    @include('includes.header')
                </header>
            @endif
            <div class="row">
                @yield('content')
            </div>
            @if($footer)
                <footer class="mx-auto">
                    @include('includes.footer')
                </footer>
            @endif
        </div>
        @include('includes.js')
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        @include('includes.backend.head')
    </head>
    <body class="h-100">
        <div class="admin-main">
            <header class="row">
                @include('includes.backend.header')
            </header>
            <div class="row">
                @yield('content')
            </div>
        </div>
        @include('includes.js')
    </body>
</html>


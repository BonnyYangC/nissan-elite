@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="guild col-11">
            @yield('guild_header')
            @yield('guild_content')
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

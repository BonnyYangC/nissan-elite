@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')

<div align="center">
    <div class="row justify-content-center">
        <div class="col-lg-2 col-md-2 col-xs-3">
            <a href="{{ url('/') }}">
                <img class="img-responsive center-block nissan-logo" style=" margin-bottom: 30%" src="{{ theme_image('nissan/Nissan_logo.png') }}">
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <!--<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 program_logo">-->
            <img class="img-responsive center-block nissan-logo" alt="" src="{{ theme_image('nissan/Nissan_ELITE_Main-Black.png') }}">
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        {{--entry point for Nissan Elite Dealership --}}
        <div id="dealership" class="col-xl-2 col-lg-2 col-md-2 col-sm-5 col-xs-6 pb-3">
            <!--<a href="http://dealership.nessanelite.com.au">-->
            <a href="{{ config('elite.dealExcellenceOverviewUrl','') }}" style="">
                <img id="dealership_static" class="img-fluid mx-auto img-static" src="{{ theme_image('nissan/ELITE_DE_button.png') }}">
                <img id="dealership_active" class="img-fluid mx-auto img-active" src="{{ theme_image('nissan/ELITE_DE_button.png') }}" style="width:90%">
            </a>
        </div>
        {{--entry point for Nissan Elite Individual --}}
        <div id="individule" class="col-xl-2 col-lg-2 col-md-2 col-sm-5 col-xs-6">
            <a href="{{ route('elite_individual') }}">
                <img id="individual_static" class="img-fluid mx-auto img-static" src="{{ theme_image('nissan/ELITE_iELITE_button.png') }}">
                <img id="individual_active" class="img-fluid mx-auto img-active" src="{{ theme_image('nissan/ELITE_iELITE_button.png') }}" style="width:90%">
            </a>
    </div>
</div>

<script>
    (function(){

        $dealerElement = document.getElementById('dealership');
        $dealerStaticElement = document.getElementById('dealership_static');
        $dealerActiveElement = document.getElementById('dealership_active');
        $dealerElement.addEventListener("mouseenter", function() {

            $dealerStaticElement.style.opacity = 0;
            $dealerActiveElement.style.opacity = 1;
        });
        $dealerElement.addEventListener("mouseleave", function() {

            $dealerStaticElement.style.opacity = 1;
            $dealerActiveElement.style.opacity = 0;
        });

        $individualElement = document.getElementById('individule');
        $individualStaticElement = document.getElementById('individual_static');
        $individualActiveElement = document.getElementById('individual_active');
        $individualElement.addEventListener("mouseenter", function() {

            $individualStaticElement.style.opacity = 0;
            $individualActiveElement.style.opacity = 1;
        });
        $individualElement.addEventListener("mouseleave", function() {

            $individualStaticElement.style.opacity = 1;
            $individualActiveElement.style.opacity = 0;
        });
    })();
</script>

@endsection

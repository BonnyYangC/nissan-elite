@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')

    <div class="vh-100 d-flex flex-column">
        <!-- Row 1: 20% height -->
        @include('pages.widgets.logo')

        <!-- Row 2: 60% height -->
        <div class="flex-grow-0 welcome-middle-section">
            <div class="h-100 d-flex justify-content-center align-items-center">
                <img class="nissan-elite-brand img-fluid" src="{{ theme_image('nissan/Nissan_ELITE_Main.png') }}" alt="Nissan Elite Image">    
            </div>
        </div>

        <!-- Row 3: 20% height -->
        <div class="flex-grow-0 welcome-foot-section">
            <div class="h-100 container">
                <div class="row h-100 justify-content-center">
                    {{-- Entry point for Nissan Elite Dealership --}}
                    <div class="col-lg-2 col-md-3 col-sm-5 col-6 d-flex align-items-center justify-content-center p-1">
                        <a href="{{ config('dealership.dealExcellenceOverviewUrl', '') }}"
                            class="w-100 h-100 position-relative dealership-wrapper">
                            <img src="{{ theme_image('nissan/ELITE_DE_button.png') }}" alt="Elite Dealership Button"
                                class="img-fluid h-100 w-100 dealership-img-static" style="object-fit: contain;">

                            <img src="{{ theme_image('nissan/ELITE_DE_button.png') }}"
                                alt="Elite Dealership Active Button" class="img-fluid position-absolute dealership-img-active"
                                style="object-fit: contain; width: 90%; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none;">
                        </a>
                    </div>

                    {{-- Entry point for Nissan Elite Individual --}}
                    <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-5 col-6 d-flex align-items-center justify-content-center p-1">
                        <a href="{{ route('elite_individual') }}" class="w-100 h-100 position-relative individual-wrapper">
                            <img src="{{ theme_image('nissan/ELITE_iELITE_button.png') }}" alt="Elite Individual Button"
                                class="img-fluid h-100 w-100 individual-img-static" style="object-fit: contain;">
                            <img src="{{ theme_image('nissan/ELITE_iELITE_button.png') }}" alt="Elite Individual Active Button"
                                class="img-fluid position-absolute individual-img-active"
                                style="object-fit: contain; width: 90%; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

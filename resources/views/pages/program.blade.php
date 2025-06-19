@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="">
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="" alt="" src="{{ theme_image('program/Nissan_IELITE_Program_header.png') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="center-block elite-program elite-program-1 program-section">
                    <h1 class="text-center text-capitalize">Welcome to <br> {{config('elite.PROGRAM_NAME')}}</h1>

                    <div style="text-align: center;">&nbsp;</div>

                    <h3 class="text-center text-capitalize">Our Annual Nissan Program will:</h3>

                    <p class="text-center">• recognize your high performance and loyalty to the Nissan brand<br>
                        • promote incentives with great rewards and prizes for you<br>
                        • recognize entire dealership team in achieving {{ config('elite.PROGRAM_DEALERSHIP') }} award</p>

                    <p class="text-center">Your contribution counts each and every day and you could be recognized and rewarded as a Nissan {{ config('elite.PROGRAM_I_ELITE') }}.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="" alt="" src="{{ theme_image('program/Nissan_IELITE_Program.png') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                @include(theme_view('program_content'))
            </div>
            <div class="d-flex justify-content-center">
                <div class="center-block elite-program elite-program-4 program-section">
                    <h3 class="text-center text-capitalize">Recognition in front of your peers:</h3>

                    <p class="text-center" style="font-size: 16px;">Whole Team, Dealer Principals and High Achieving Individuals</p>
                    <img src="{{ theme_image('nissan/Nissan_ELITE_Horz-White.png') }}" class="img-responsive center-block" width="80%">
                    <p class="text-center">All {{ config('elite.PROGRAM_I_ELITE') }} status recognition awards including the {{ config('elite.PROGRAM_DEALERSHIP') }} and Nissan Global Awards will be presented at your state Product Challenge event.</p>

                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

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
                <div class="center-block elite-program elite-program-3 program-section">
                    <h3 class="text-center text-capitalize">Who is in the {{ config('elite.PROGRAM_SHORT_NAME') }} program and how do you earn points:</h3>
                    &nbsp;
                    <div class="program_ele_border">
                        <div class="d-flex justify-content-center">
                            <img class="img-responsive center-block" src="{{ theme_image('nissan/Nissan_ELITE_DE-White.png') }}" width="75%">
                        </div>
                        <p class="text-center"><br>
                            <strong>Whole of Dealership</strong>
                        </p>
                        <p class="text-center">Recognized using the {{ config('elite.PROGRAM_DEALERSHIP') }} program and GLOBAL AWARD</p>
                    </div>

                    <div class="program_ele_border">

                        <div style="float:left; width:60%">
                            <img src="{{ theme_image('nissan/Nissan_ELITE_i_ELITE-White.png') }}" class="img-responsive center-block" style="width: 100%">
                            <p class="text-center"><br>
                                Dealer Principal<br>
                                Sales Manager<br>
                                Retail Sales Consultant<br>
                                Fleet Sales Executive<br>
                                Stock Controller<br>
                                F&amp;I Manager<br>
                                Service Manager<br>
                                Service Advisor<br>
                                Technician<br>
                                Parts Manager<br>
                                Parts Sales Rep<br>
                                &nbsp;</p>

                            <p class="text-left">
                                <strong>Dealer Principal:</strong>
                            </p>

                            <ul>
                                <li>Status based on {{ config('elite.PROGRAM_DEALERSHIP') }} ranking</li>
                                <li>Special Recognition</li>
                            </ul>

                            <p class="text-left">
                                <strong>Staff Roles:</strong>
                            </p>

                            <ul>
                                <li>Status based on Metrics</li>
                                <li>Gift Cards</li>
                                <li>Incentives</li>
                                <li>Trophies</li>
                                <li>Certificates &amp; Lapel pins</li>
                                <li>Trips &amp; Experiences</li>
                                <li>The Guild Invitation</li>
                            </ul>
                        </div>
                        <div style="float:right; margin-top:60px;">
                            <img src="{{ theme_image('program/nissan_elite_model.png') }}" class="pull-right img-responsive" width="120">
                        </div>
                        <div style="height:1px; margin-top:­1px;clear: both;overflow:hidden;"></div>
                    </div>
                </div>
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

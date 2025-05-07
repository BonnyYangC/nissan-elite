@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="product-challenge">
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ theme_image('product_challenge/cover.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                @include(theme_view('product_challenge_header'))
            </div>
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ theme_image('product_challenge/footer.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="challenge-section">
                    <table class="table">
                        <thead class="nissan-table-header" align="left">
                            <tr>
                                <td><strong>Event</strong></td>
                                <td><strong>Date</strong></td>
                                <td><strong>Venue</strong></td>
                            </tr>
                        </thead>
                        <tbody class="nissan-table-body-light-grey" align="left">
                            @foreach ($events as $event)
                                <tr class="active">
                                    <td>{{$event->event}}</td>
                                    <td>{{$event->date}}</td>
                                    <td>{{$event->venue}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><small>We are excited to be on the road again. Stay tuned for your region dates coming soon. Awards are currently being prepared and we look forward to recognising our Award winners at each event.</small></p>
                    <br>

                    <a class="edm-link" target="_blank" href="{{config('theme.' . config('app.theme') . '.product_challenge_info_url')}}">
                        Click to VIEW PRODUCT CHALLENGE INFORMATION
                    </a>
                    </br>
                    <span style="color:#c0133c">SALES/SERVICE MANAGER ACCESS ONLY -</span>
                    </br>
                    <a class="edm-link" target="_blank" href="{{config('theme.' . config('app.theme') . '.product_challenge_table_registe_url')}}">Click to REGISTER YOUR PRODUCT CHALLENGE TABLE FOR FY24
                    </a>
                    </br>
                    <span style="color:#c0133c">(1 Table per Dealer with Maximum seating 12)</br>
                    (ELITE Members first preference)</span>
                    </br>
                    <a class="edm-link" target="_blank" href="{{config('theme.' . config('app.theme') . '.product_challenge_photos_url')}}">Click to VIEW PRODUCT CHALLENGE PHOTOS 
                    </a>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="product-challenge">
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ asset('images/product_challenge/cover.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="challenge-section">
                    <p class="header-line">NISSAN ELITE Product Challenge & Award Presentation Events ARE BACK IN 2024!</p>
                    <p class="sub-header">- DATES AND VENUES ARE READY</p>
                    <p class="sub-header">- REGISTRATIONS OPEN SOON</p>
                    <p class="sub-header">- Get your A-Team together!</p>
                    <!--<p class="text-content">After many disruptions encountered over the past two years we are excited to announce the dates for the 2022 Product Challenge events across Australia.</p>-->

                    <p class="text-content">We have once again secured superb venues in each state, and look forward to welcoming back both old and new faces. We will of course ensure COVID safe protocols are followed at all events, and do our very best to ensure all attendees have a great night with their colleagues and peers.</p>

                    <p class="text-content">Ferntree Gully Nissan our 2023 Masters Champion holding tightly onto the Title and Trophy!  We know the competition will be at an all-time high, as each Dealer team attempts to take the title as their own.</p>
                    <p class="sub-header">And our FY24 National Masters Champion - </p>
                    <p class="sub-header">WAVERLEY NISSAN – Southern Region</p>
                    <p class="sub-header">Congratulations on a great win along with ALL our State Champions this year.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ asset('images/product_challenge/footer.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="challenge-section">
                    <!--<p class="postponed-header mb-2">EVENT DATES – CONFIRMED<br>(refer Region edms)</p>-->
                    <table class="table">
                        <thead class="nissan-table-header" align="left">
                            <tr>
                                <td><strong>Event</strong></td>
                                <td><strong>Date</strong></td>
                                <td><strong>Venue</strong></td>
                            </tr>
                        </thead>
                        <tbody class="nissan-table-body-light-grey" align="left">
                            <tr class="active">
                                <td>Brisbane</td>
                                <td>Thursday 18 July</td>
                                <td>Hilton Brisbane</td>
                            </tr>
                            <tr class="active">
                                <td>Townsville</td>
                                <td>Saturday 20 July</td>
                                <td>The Ville</td>
                            </tr>
                            <tr class="active">
                                <td>Launceston</td>
                                <td>Friday 26 July</td>
                                <td>Peppers Silo</td>
                            </tr>
                            <tr class="active">
                                <td>Melbourne</td>
                                <td>Thursday 22 August</td>
                                <td>Grand Hyatt</td>
                            </tr>
                            <tr class="active">
                                <td>Sydney</td>
                                <td>Tuesday 27 August</td>
                                <td>Aqua Luna</td>
                            </tr>
                            <tr class="active">
                                <td>Adelaide</td>
                                <td>Wednesday 18 September</td>
                                <td>The Playford</td>
                            </tr>
                            <tr class="active">
                                <td>Perth</td>
                                <td>Friday 20 September</td>
                                <td>Crown Promenade</td>
                            </tr>
                        </tbody>
                    </table>
                    <p><small>We are excited to be on the road again. Stay tuned for your region dates coming soon. Awards are currently being prepared and we look forward to recognising our Award winners at each event.</small></p>
                    <br>

                    <a class="edm-link" target="_blank" href="https://mailchi.mp/a22a30e38fa1/nissan-dealer-business-development-group-meeting1-3124663?e=6d1ff96e61">
                        Click to VIEW PRODUCT CHALLENGE INFORMATION
                    </a>
                    </br>
                    <span style="color:#c0133c">SALES/SERVICE MANAGER ACCESS ONLY -</span>
                    </br>
                    <a class="edm-link" target="_blank" href="https://mailchi.mp/7a024c21511e/nissan-dealer-business-development-group-meeting1-3124659?e=6d1ff96e61">Click to REGISTER YOUR PRODUCT CHALLENGE TABLE FOR FY24
                    </a>
                    </br>
                    <span style="color:#c0133c">(1 Table per Dealer with Maximum seating 12)</br>
                    (ELITE Members first preference)</span>
                    </br>
                    <a class="edm-link" target="_blank" href="https://nissanevents.pixieset.com/nissanproductchallenge2024/">Click to VIEW PRODUCT CHALLENGE PHOTOS 
                    </a>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

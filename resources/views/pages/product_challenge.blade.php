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
                    <p class="header-line">NISSAN ELITE Product Challenge & Award Presentation Events ARE BACK IN 2023!</p>
                    <p class="sub-header">- DATES AND VENUES ARE READY</p>
                    <p class="sub-header">- REGISTRATIONS OPEN SOON</p>
                    <p class="sub-header">- Get your A-Team together!</p>
                    <!--<p class="text-content">After many disruptions encountered over the past two years we are excited to announce the dates for the 2022 Product Challenge events across Australia.</p>-->

                    <p class="text-content">We have once again secured superb venues in each state, and look forward to welcoming back both old and new faces. We will of course ensure COVID safe protocols are followed at all events, and do our very best to ensure all attendees have a great night with their colleagues and peers.</p>

                    <p class="text-content">Ferntree Gully Nissan our 2022 Masters Champion holding tightly onto the Title and Trophy!  We know the competition will be at an all-time high, as each Dealer team attempts to take the title as their own.</p>
                    <p class="sub-header">Who will be your State Champion and who will take the National Masters Title in 2023?</p>
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
                                <td>Wednesday 9 August</td>
                                <td>Hilton Brisbane</td>
                            </tr>
                            <tr class="active">
                                <td>Townsville</td>
                                <td>Saturday 12 August</td>
                                <td>The Ville</td>
                            </tr>
                            <tr class="active">
                                <td>Adelaide</td>
                                <td>Wednesday 16 August</td>
                                <td>The Playford</td>
                            </tr>
                            <tr class="active">
                                <td>Perth</td>
                                <td>Friday 18 August</td>
                                <td>Crown Promenade</td>
                            </tr>
                            <tr class="active">
                                <td>Melbourne</td>
                                <td>Wednesday 23 August</td>
                                <td>Grand Hyatt</td>
                            </tr>
                            <tr class="active">
                                <td>Sydney</td>
                                <td>Wednesday 6 September</td>
                                <td>Aqua Luna</td>
                            </tr>
                            <tr class="active">
                                <td>Launceston</td>
                                <td>Friday 8 September</td>
                                <td>Peppers Silo</td>
                            </tr>
                        </tbody>
                    </table>
                    <p><small>We are excited to be on the road again. Stay tuned for your region dates coming soon. Awards are currently being prepared and we look forward to recognising our Award winners at each event.</small></p>
                    <br>

                    <a class="edm-link" target="_blank" href="https://mailchi.mp/c155094aed22/nissan-dealer-business-development-group-
meeting1-3123420?e=1dac1983c2">
                        Click to VIEW PRODUCT CHALLENGE INFORMATION
                    </a>
                    </br>
                    <span style="color:#c0133c">SALES/SERVICE MANAGER ACCESS ONLY -</span>
                    </br>
                    <a class="edm-link" target="_blank" href="https://destination.eventsair.com/nissan-product-challenge-
2023/registration/Site/Register">Click to REGISTER YOUR PRODUCT CHALLENGE TABLE FOR FY23
                    </a>
                    </br>
                    <span style="color:#c0133c">(1 Table per Dealer with Maximum seating 12)</br>
                    (ELITE Members first preference)</span>
                    </br>
                    <a class="edm-link" target="_blank" href="https://nissanevents.pixieset.com/nissanproductchallenge2023/">Click to VIEW PRODUCT CHALLENGE PHOTOS 
                    </a>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

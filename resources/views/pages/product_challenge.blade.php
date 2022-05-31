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
                    <p class="header-line">NISSAN ELITE Product Challenge & Award Presentation Events ARE BACK IN 2022!</p>
                    <p class="sub-header">- DATES AND VENUES LISTED BELOW</p>
                    <p class="sub-header">- REGISTRATIONS OPEN 1ST JUNE 2022</p>
                    <p class="sub-header">- Get your A-Team together!</p>
                    <p class="text-content">After a challenging year dealing with COVID-19 we can't wait to resume and welcome back old and new faces to the much loved ELITE Product Challenge events.</p>

                    <p class="text-content">We have been fortunate enough to secure the superb venues used for the 2019 events and will work with each venue to ensure we follow all COVID protocols to ensure a safe and fun event for all.</p>

                    <p class="text-content">Ferntree Gully Nissan are our reigning Masters Champions and we know that there will be fierce competition amongst all Dealers to try and take this title from them!</p>
                    <p class="sub-header">Who will be your State Champion and who will take out the National Masters Title in 2022?</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ asset('images/product_challenge/footer.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="challenge-section">
                    <p class="postponed-header mb-2">EVENT DATES – CONFIRMED<br>(refer Region edms)</p>
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
                                <td>Sydney</td>
                                <td>Wednesday 20 July</td>
                                <td>Aqua Luna</td>
                            </tr>
                            <tr class="active">
                                <td>Launceston</td>
                                <td>Friday 22 July</td>
                                <td>Peppers Silo</td>
                            </tr>
                            <tr class="active">
                                <td>Townsville</td>
                                <td>Saturday 13 August</td>
                                <td>The Ville</td>
                            </tr>
                            <tr class="active">
                                <td>Brisbane</td>
                                <td>Monday 15 August</td>
                                <td>Hilton Brisbane</td>
                            </tr>
                            <tr class="active">
                                <td>Adelaide</td>
                                <td>Wednesday 17 August</td>
                                <td>Adelaide Oval</td>
                            </tr>
                            <tr class="active">
                                <td>Perth</td>
                                <td>Friday 19 August</td>
                                <td>Crown Towers</td>
                            </tr>
                            <tr class="active">
                                <td>Melbourne</td>
                                <td>Thursday 25 August</td>
                                <td>Grand Hyatt</td>
                            </tr>
                        </tbody>
                    </table>
                    <p><small>After a long list of postponed events, we are excited to be on the road again.
                            Check your region date and make sure you book your seat early.  Awards are currently being prepared and we look forward to recognising our Award winners at each event.
                            </small></p>
                    <br>

                    <a class="edm-link" target="_blank" href="#">
                        Click here to view edm content PRODUCT CHALLENGE FY22
                    </a>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

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
                    <p class="header-line">NISSAN ELITE Product Challenge & Award Presentation Events ARE BACK IN 2021!</p>
                    <p class="sub-header">- DATES AND VENUES LISTED BELOW</p>
                    <p class="sub-header">- REGISTRATIONS OPEN 1ST JUNE 2021</p>
                    <p class="sub-header">- Get your A-Team together!</p>
                    <p class="text-content">After a challenging year dealing with COVID-19 we can't wait to resume and welcome back old and new faces to the much loved ELITE Product Challenge events.</p>

                    <p class="text-content">We have been fortunate enough to secure the superb venues used for the 2019 events and will work with each venue to ensure we follow all COVID protocols to ensure a safe and fun event for all.</p>

                    <p class="text-content">Ferntree Gully Nissan are our reigning Masters Champions and we know that there will be fierce competition amongst all Dealers to try and take this title from them!</p>
                    <p class="sub-header">Who will be your State Champion and who will take out the National Masters Title in 2021?</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="program-section">
                    <img class="w-100" alt="" src="{{ asset('images/product_challenge/footer.jpg') }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="challenge-section">
                    <p class="postponed-header mb-2">EVENT DATES – CONFIRMED AND CANCELLED<br>(refer Region edms)</p>
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
                                <td>Adelaide</td>
                                <td>Monday 22 November</td>
                                <td>Stamford Grand Glenelg</td>
                            </tr>
                            <tr class="active">
                                <td>Brisbane</td>
                                <td>Thursday 23th September</td>
                                <td>Hilton Brisbane</td>
                            </tr>
                            <tr class="active">
                                <td>Perth</td>
                                <td>Friday 6th August</td>
                                <td>Crown Towers</td>
                            </tr>
                            <tr class="active canceled-item">
                                <td>Sydney</td>
                                <td>Cancelled</td>
                                <td>Aqua Luna</td>
                            </tr>
                            <tr class="active canceled-item">
                                <td>Launceston</td>
                                <td>Cancelled</td>
                                <td>Peppers Silo</td>
                            </tr>
                            <tr class="active canceled-item">
                                <td>Townsville</td>
                                <td>Cancelled</td>
                                <td>The Ville</td>
                            </tr>
                            <tr class="active canceled-item">
                                <td>Melbourne</td>
                                <td>Cancelled</td>
                                <td>Grand Hyatt</td>
                            </tr>
                        </tbody>
                    </table>
                    <p><small>All awards are currently being distributed to Regional Offices and your DSM will be in contact soon.

                            Another difficult year with COVID-19 but we are now securing dates for 2022 to run Product Challenges Nationally.</small></p>
                    <br>

                    <a class="edm-link" target="_blank" href="https://mailchi.mp/213521dca5a8/nissan-dealer-business-development-group-meeting1-3120642?e=1dac1983c2">
                        Click here to view edm content PRODUCT CHALLENGE FY21
                    </a>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

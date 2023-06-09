@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page loyalty col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>HIGH ACHIEVER AWARDS {{ env('FY_LAST_YEAR') }}</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap awards-section">
                <h2>Platinum National</h2>
                <table class="table mt-1">
                    <thead class="nissan-table-header">
                        <tr class="table-top-row">
                            <td><strong>1<sup>st</sup> Rank Nationally</strong></td>
                            <td><strong></strong></td>
                            <td><strong></strong></td>
                            <td><strong></strong></td>
                        </tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Paul Kyriakou</td>
                            <td>Werribee Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>
                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Andy Wang</td>
                            <td>Liverpool Nissan</td>
                            <td>NSW</td>
                        </tr>
                        <!--<tr class="active">
                            <td>Fleet Sales Executive</td>
                            <td>Sean Hogan</td>
                            <td>Liverpool Nissan</td>
                            <td>NSW</td>
                        </tr>-->
                        <tr class="active">
                            <td>F & I Manager</td>
                            <td>Shelley Winslade</td>
                            <td>North Lakes Nissan</td>
                            <td>QLD</td>
                        </tr>
                        <!--<tr class="active">
                            <td>Stock Controller</td>
                            <td>Molly Peterson</td>
                            <td>McRae Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>-->
                        <tr class="active">
                            <td>Service Manager</td>
                            <td>Sash Milasinovic</td>
                            <td>Ferntree Gully Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>
                    </tbody>
                </table>

                <p><em></em></p>
            </div>
            <div class="page-widget col-3">
                <img src="{{ asset('images/awards/Elite_trophies_National.png') }}" class="w-100" alt="" />
            </div>
        </div>

        <div class="d-flex">
            <div class="col-9 page-section-wrap awards-section">
                <h2>Platinum State</h2>
                <table class="table mt-1">
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - NSW</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Darius Taylor</td>
                            <td>Pennant Hills Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Retail Sales Consultant (N)</td>
                            <td>Andy Wang</td>
                            <td>Liverpool Nissan</td>
                        </tr>
                        <!--<tr class="active">
                            <td>Fleet Sales Executive (N)</td>
                            <td>Sean Hogan</td>
                            <td>Liverpool Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Stock Controller</td>
                            <td>Emma Harris</td>
                            <td>Leo Franco Nissan</td>
                        </tr>-->
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong><strong>1<sup>st</sup> Rank - QLD</strong></strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Tim Overall</td>
                            <td>North Jacklin Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>F & I Manager  (N)</td>
                            <td>Shelley Winslade</td>
                            <td>North Lakes Nissan</td>
                        </tr>
                        <!--<tr class="active"><td>Retail Sales Consultant</td><td>Jeanette Morgan</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Joanne Holmes</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Service Manager</td><td>Jack Scott</td><td>Gladstone Nissan</td></tr>-->
                    </tbody>
                    <!--<thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - SA &amp; NT</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Paul Mckay</td><td>Whyalla Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Prakash Poudel</td><td>Kerry Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Vicki Metcalf</td><td>Main North Nissan</td></tr>
                        <tr class="active"><td>Service Manager</td><td>Sebastian Schmidt</td><td>Lakeside Nissan</td></tr>
                    </tbody>-->
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - VIC &amp; TAS</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager (N)</td>
                            <td>Paul Kyriakou</td>
                            <td>Werribee Nissan</td>
                        </tr>
                        <!--<tr class="active"><td>Retail Sales Consultant (N)</td><td>Moses Boulos</td><td>Mantello Nissan</td></tr>
                        <tr class="active"><td>Stock Controller (N)</td><td>Molly Peterson</td><td>McRae Nissan</td></tr>-->
                        <tr class="active">
                            <td>Service Manager (N)</td>
                            <td>Sash Milasinovic</td>
                            <td>Ferntree Gully Nissan</td>
                        </tr>
                    </tbody>
                    <!--<thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - WA</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Steve Rose</td><td>Total Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Wayne Matau</td><td>Rockingham Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Rachel Ellson</td><td>Northside Nissan</td></tr>
                    </tbody>-->
                </table>

                <p><em></em></p>
            </div>
            <div class="page-widget col-3">
                <img src="{{ asset('images/awards/state_trophy.png') }}" class="w-100" alt="" />
            </div>
        </div>

        <div class="d-flex">
            <div class="col-9 page-section-wrap awards-section">
                <h2>Gold Status</h2>
                <table class="table mt-1">
                    <thead class="nissan-table-header">
                        <tr><td>Sales Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Adrian Gerada</td><td>Essendon Nissan</td></tr>
                        <tr class="active"><td>Damian Keenahan</td><td>Brookvale Nissan</td></tr>
                        <tr class="active"><td>Dylan Barter</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Greg Dennis</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Maciek Finch</td><td>Macarthur Nissan</td></tr>
                        <tr class="active"><td>Shane Duffy</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Stephen Forrest</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Steven Lowe</td><td>Springwood Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Retail Sales Consultant</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Donny Huang</td><td>Pennant Hills Nissan</td></tr>
                    </tbody>

                    <!--<thead class="nissan-table-header">
                        <tr><td>Fleet Sales Executive</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sean Hogan</td><td>Liverpool Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Stock Controller</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Adam Douglass</td><td>Penrith Nissan</td></tr>
                    </tbody>-->

                    <thead class="nissan-table-header">
                        <tr><td>F & I Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Alex Hall</td><td>Southern Vales Nissan</td></tr>
                        <tr class="active"><td>Andrew Debattista</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Arthur Vagionas</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Kathrine Moore</td><td>Springwood Nissan</td></tr>
                        <tr class="active"><td>Kuntal Chokshi</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Paul Whitelaw</td><td>Thompson Nissan</td></tr>
                        <tr class="active"><td>Shelly Lupton</td><td>Peter Stevens Nissan</td></tr>
                    </tbody>

                    <!--<thead class="nissan-table-header">
                        <tr><td>Service Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Ashley Lyons</td><td>Gatton Auto</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Service Advisor</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Julie Renye</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Parts Sales Representative</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Carl Arnold</td><td>Rockingham Nissan</td></tr>
                    </tbody>-->
                </table>

                <p><em></em></p>
            </div>
            <div class="page-widget col-3">
               <!-- <img src="{{ asset('images/awards/Gold_Pin.png') }}" class="w-100" alt="" />-->
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

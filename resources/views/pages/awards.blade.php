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
                            <td>Shane Duffy</td>
                            <td>Western Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>

                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Timothy Cannon</td>
                            <td>Gatton Auto</td>
                            <td>QLD</td>
                        </tr>

                        <tr class="active">
                            <td>Fleet Sales Executive</td>
                            <td>Shane Mifsud</td>
                            <td>Western Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>

                        <tr class="active">
                            <td>Stock Controller</td>
                            <td>Tahlia Yates</td>
                            <td>Western Nissan</td>
                            <td>VIC/TAS</td>
                        </tr>

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
                        <tr class="active"><td>Sales Manager</td><td>Wayne Bultitude</td><td>Great Lakes Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Hannah Plunkett</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Emma Harris</td><td>Leo Franco Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong><strong>1<sup>st</sup> Rank - QLD</strong></strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Tim Overall</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant (N)</td><td>Timothy Cannon</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Fleet Sales Executive</td><td>Ben Maslen</td><td>Westpoint Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Tanaye Zischke</td><td>Gatton Auto</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - SA &amp; NT</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Paul Mckay</td><td>Whyalla Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Andrew Curnow</td><td>Southern Vales Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - VIC &amp; TAS</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager (N)</td><td>Shane Duffy</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Morgan Engel</td><td>Ringwood Nissan</td></tr>
                        <tr class="active"><td>Fleet Sales Executive (N)</td><td>Shane Mifsud</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Stock Controller (N)</td><td>Tahlia Yates</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Service Manager (N)</td><td>Sash Milasinovic</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - WA</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Mat Mitchell</td><td>Total Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Rachel Ellson</td><td>Northside Nissan</td></tr>
                    </tbody>
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
                        <tr class="active"><td>Michael Spice</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Stephen Forrest</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Braith Gartshore</td><td>Gaukroger Nissan</td></tr>
                        <tr class="active"><td>Ben Bilsborow</td><td>Jarrett Nissan</td></tr>
                        <tr class="active"><td>Jamie Eveleigh</td><td>Gunnedah Automotive</td></tr>
                        <tr class="active"><td>Josh Klein</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Andrew Ross</td><td>Leo Franco Nissan</td></tr>
                        <tr class="active"><td>Mitchell Pilbeam</td><td>Ron Doyle Motors Nissan</td></tr>
                        <tr class="active"><td>Stephen Vassel</td><td>Muswellbrook Nissan</td></tr>
                        <tr class="active"><td>Paul Lawson</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Greg Dennis</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Richard Blache</td><td>Southern Vales Nissan</td></tr>
                        <tr class="active"><td>Michael Dexter</td><td>Wyong Nissan</td></tr>
                        <tr class="active"><td>Elias Warde</td><td>Mantello Nissan</td></tr>
                        <tr class="active"><td>Luke Wisniewski</td><td>Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>George Chang</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>Nicholas Shand</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Paul Kok</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Andrew Chao</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Ken Bradley</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Paul Kyriakou</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Gary Dundas</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Paul Wannenmacher</td><td>Bendigo Nissan</td></tr>
                        <tr class="active"><td>Adam Pierscionek</td><td>Broken Hill Nissan</td></tr>
                        <tr class="active"><td>Candice Illingworth</td><td>Motors Nissan Launceston</td></tr>
                        <tr class="active"><td>Emma Martin</td><td>Eagers Windsor Nissan</td></tr>
                        <tr class="active"><td>Pux Phoumirath</td><td>Pennant Hills Nissan</td></tr>
                        <tr class="active"><td>Callum Shave</td><td>Ringwood Nissan</td></tr>
                        <tr class="active"><td>Jerry Ho</td><td>CKD Nissan Chatswood</td></tr>
                        <tr class="active"><td>Jason Jolley</td><td>Lismore Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Retail Sales Consultant</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Craig Scanlan</td><td>Warwick Nissan</td></tr>
                        <tr class="active"><td>Jeanette Morgan</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Joel Dean</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>Derryn Kelly</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Jeremy Mcdougall</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Matthew Waugh</td><td>North Jacklin Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Fleet Sales Executive</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>James Boulton</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Stock Controller</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Toni Carroll</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Emily Simpson</td><td>Westpoint Nissan</td></tr>
                        <tr class="active"><td>Phil Barry</td><td>Motors Nissan Launceston</td></tr>
                        <tr class="active"><td>Kristian Zadro</td><td>Pennant Hills Nissan</td></tr>
                        <tr class="active"><td>Jayde Corcoran</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Charleen Prescilla</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Judith Pike</td><td>Warwick Nissan</td></tr>
                        <tr class="active"><td>Amanda Simpson</td><td>Gaukroger Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Service Advisor</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Julie Renye</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>
                </table>

                <p><em></em></p>
            </div>
            <div class="page-widget col-3">
                <img src="{{ asset('images/awards/Gold_Pin.png') }}" class="w-100" alt="" />
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

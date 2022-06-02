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
                        <tr class="active"><td>Sales Manager</td><td>Tim Overall</td><td>North Jacklin Nissan</td><td>QLD</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Moses Boulos</td><td>Mantello Nissan</td><td>VIC/TAS</td></tr>
                        <tr class="active"><td>Fleet Sales Executive</td><td>Sean Hogan</td><td>Liverpool Nissan</td><td>NSW</td></tr>
                        <tr class="active"><td>F & I Manager</td><td>Arthur Vagionas</td><td>Lakeside Nissan</td><td>SA/NT</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Molly Peterson</td><td>McRae Nissan</td><td>VIC/TAS</td></tr>
                        <tr class="active"><td>Service Manager</td><td>Sash Milasinovic</td><td>Ferntree Gully Nissan</td><td>VIC/TAS</td></tr>
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
                        <tr class="active"><td>Retail Sales Consultant</td><td>Andy Wang</td><td>Liverpool Nissan</td></tr>
                        <tr class="active"><td>Fleet Sales Executive (N)</td><td>Sean Hogan</td><td>Liverpool Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Emma Harris</td><td>Leo Franco Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong><strong>1<sup>st</sup> Rank - QLD</strong></strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                    <tr class="active"><td>Sales Manager (N)</td><td>Tim Overall</td><td>North Jacklin Nissan</td></tr>
                    <tr class="active"><td>Retail Sales Consultant</td><td>Jeanette Morgan</td><td>North Lakes Nissan</td></tr>
                    <tr class="active"><td>Stock Controller</td><td>Joanne Holmes</td><td>Gladstone Nissan</td></tr>
                    <tr class="active"><td>Service Manager</td><td>Jack Scott</td><td>Gladstone Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - SA &amp; NT</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Paul Mckay</td><td>Whyalla Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Prakash Poudel</td><td>Kerry Nissan</td></tr>
                        <tr class="active"><td>Stock Controller</td><td>Vicki Metcalf</td><td>Main North Nissan</td></tr>
                        <tr class="active"><td>Service Manager</td><td>Sebastian Schmidt</td><td>Lakeside Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - VIC &amp; TAS</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Shane Duffy</td><td>Western Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant (N)</td><td>Moses Boulos</td><td>Mantello Nissan</td></tr>
                        <tr class="active"><td>Stock Controller (N)</td><td>Molly Peterson</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Service Manager (N)</td><td>Sash Milasinovic</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - WA</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Sales Manager</td><td>Steve Rose</td><td>Total Nissan</td></tr>
                        <tr class="active"><td>Retail Sales Consultant</td><td>Wayne Matau</td><td>Rockingham Nissan</td></tr>
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
                        <tr class="active"><td>Adrian Gerada</td><td>Essendon Nissan</td></tr>
                        <tr class="active"><td>Andrew Chao</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Andrew Ross</td><td>Leo Franco Nissan</td></tr>
                        <tr class="active"><td>Ben Fiorini</td><td>Lander Nissan</td></tr>
                        <tr class="active"><td>Ben Bilsborow</td><td>Jarrett Nissan</td></tr>
                        <tr class="active"><td>Bradley Lister</td><td>Blackburn Nissan</td></tr>
                        <tr class="active"><td>Braith Gartshore</td><td>Gaukroger Nissan</td></tr>
                        <tr class="active"><td>Brendan Cooper</td><td>DC Motors Nissan</td></tr>
                        <tr class="active"><td>Craig McMennemin</td><td>Rex Gorell Nissan</td></tr>
                        <tr class="active"><td>Damian Keenahan</td><td>Brookvale Nissan</td></tr>
                        <tr class="active"><td>Dan Wood</td><td>Chano Trentin's AWD Centre</td></tr>
                        <tr class="active"><td>Dylan Barter</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Gary Dundas</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>George Bisas</td><td>Hobart Nissan</td></tr>
                        <tr class="active"><td>George Chang</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>Greg Dennis</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Jared Lopez</td><td>Jared Lopez</td></tr>
                        <tr class="active"><td>Jason Jolley</td><td>Lismore Nissan</td></tr>
                        <tr class="active"><td>Josh Klein</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Ken Bradley</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Luke Bailey</td><td>Barton's Wynnum Nissan</td></tr>
                        <tr class="active"><td>Luke Wisniewski</td><td>Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>Maciek Finch</td><td>Macarthur Nissan</td></tr>
                        <tr class="active"><td>Matt Shine</td><td>Parry NQ Nissan</td></tr>
                        <tr class="active"><td>Michael Dexter</td><td>Wyong Nissan</td></tr>
                        <tr class="active"><td>Michael Spice</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Mitchell Pilbeam</td><td>Ron Doyle Motors Nissan</td></tr>
                        <tr class="active"><td>Nicholas Shand</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Paul Kyriakou</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Paul Lawson</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Paul Wannenmacher</td><td>Bendigo Nissan</td></tr>
                        <tr class="active"><td>Pedro Pinto</td><td>Brighton Nissan</td></tr>
                        <tr class="active"><td>Pux Phoumirath</td><td>Pennant Hills Nissan</td></tr>
                        <tr class="active"><td>Richard Davidson</td><td>Motorama Nissan</td></tr>
                        <tr class="active"><td>Samantha Leigh</td><td>Kloster Nissan</td></tr>
                        <tr class="active"><td>Stephen Forrest</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Steven Lowe</td><td>Springwood Nissan</td></tr>
                        <tr class="active"><td>Trevor Studt</td><td>Rod Grittner Nissan</td></tr>
                        <tr class="active"><td>Young Ha</td><td>Liverpool Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Retail Sales Consultant</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Aydrien Skupien</td><td>Lander Nissan</td></tr>
                        <tr class="active"><td>Chris Smedley</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Craig Scanlan</td><td>Warwick Nissan</td></tr>
                        <tr class="active"><td>Derryn Kelly</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Elliott Morgan</td><td>Lennock Motors</td></tr>
                        <tr class="active"><td>Gary Troughton</td><td>Moorooka Nissan</td></tr>
                        <tr class="active"><td>George Andriolo</td><td>Barton's Capalaba Nissan</td></tr>
                        <tr class="active"><td>Hannah Plunkett</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Jayden Costello</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Jazz Wallace</td><td>von Bibra Gold Coast Nissan</td></tr>
                        <tr class="active"><td>Joel Dean</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>Joel Wakefield</td><td>Castle Hill Nissan</td></tr>
                        <tr class="active"><td>Martin Van</td><td>Eeden	Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>Nedaal Raja</td><td>Ringwood Nissan</td></tr>
                        <tr class="active"><td>Paul Dunstan</td><td>Parry NQ Nissan</td></tr>
                        <tr class="active"><td>Sharelle Bailey</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Stephen Blakey</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Timothy Cannon</td><td>Gatton Auto</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
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
                        <tr class="active"><td>Amanda Simpson</td><td>Gaukroger Nissan</td></tr>
                        <tr class="active"><td>Annette Chapman</td><td>Osborne Park Nissan</td></tr>
                        <tr class="active"><td>Charleen Prescilla</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Donna Spink</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Emily Simpson</td><td>Westpoint Nissan</td></tr>
                        <tr class="active"><td>Emma Wilson</td><td>Mandurah Nissan</td></tr>
                        <tr class="active"><td>Jayde Corcoran</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Judith Pike</td><td>Warwick Nissan</td></tr>
                        <tr class="active"><td>Kara Smith</td><td>Traralgon Nissan</td></tr>
                        <tr class="active"><td>Karen Morris</td><td>Broken Hill Nissan</td></tr>
                        <tr class="active"><td>Karen Shepherd</td><td>Suttons Arncliffe Nissan</td></tr>
                        <tr class="active"><td>Kirsty Jensen</td><td>Westco Motors</td></tr>
                        <tr class="active"><td>Leah Gauld</td><td>Huston Nissan</td></tr>
                        <tr class="active"><td>Lucinda Apolloni</td><td>Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>Megan Long</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Meggie Farrell</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>Nathan Glassington</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>Peter Henderson</td><td>City Motors</td></tr>
                        <tr class="active"><td>Phill Barry</td><td>Motors Nissan Launceston</td></tr>
                        <tr class="active"><td>Robin Turner</td><td>Eagers Newstead Nissan</td></tr>
                        <tr class="active"><td>Sarah Adriaens</td><td>Morley City Nissan</td></tr>
                        <tr class="active"><td>Tahlia Yates</td><td>von Bibra Gold Coast Nissan</td></tr>
                        <tr class="active"><td>Tanaye Zischke</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Tanika Mackay</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Toni Carroll</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Tony Martin</td><td>Crick's Nambour Nissan</td></tr>
                        <tr class="active"><td>Tracey Woodbridge</td><td>Barton's Capalaba Nissan</td></tr>
                        <tr class="active"><td>Wendy Parsons</td><td>Lakeside Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                    <tr><td>F & I Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                    <tr class="active"><td>Corinne Henry</td><td>Penrith Nissan</td></tr>
                    <tr class="active"><td>Paul Whitelaw</td><td>Thompson Nissan</td></tr>
                    <tr class="active"><td>Shelley Winslade</td><td>North Lakes Nissan</td></tr>
                    <tr class="active"><td>Shelly Lupton</td><td>Peter Stevens Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                    <tr><td>Service Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                    <tr class="active"><td>Ashley Lyons</td><td>Gatton Auto</td></tr>
                    <tr class="active"><td>Matt Bateman</td><td>Jarrett Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Service Advisor</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Julie Renye</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Meagan Williams</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Rhys Pratt-Linnell</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Robert Colussi</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                    <tr><td>Parts Sales Representative</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                    <tr class="active"><td>Carl Arnold</td><td>Rockingham Nissan</td></tr>
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

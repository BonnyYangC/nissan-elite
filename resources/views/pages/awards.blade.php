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
                        <tr class="active">
                            <td>Fleet Sales Executive</td>
                            <td>Sean Hogan</td>
                            <td>Liverpool Nissan</td>
                            <td>NSW</td>
                        </tr>
                        <tr class="active">
                            <td>F & I Manager</td>
                            <td>Sue Wright</td>
                            <td>North Jacklin Nissan</td>
                            <td>QLD</td>
                        </tr>
                        <tr class="active">
                            <td>Parts Manager</td>
                            <td>Alan Braybrook</td>
                            <td>Lakeside Nissan</td>
                            <td>SA/NT</td>
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
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Darcy Pengelly-Shea</td>
                            <td>Suttons Arncliffe Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Parts Manager</td>
                            <td>Nathan Waters</td>
                            <td>Ryde Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Service Manager</td>
                            <td>Luke Lieschke</td>
                            <td>Lieschke Nissan</td>
                        </tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong><strong>1<sup>st</sup> Rank - QLD</strong></strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Steven Lowe</td>
                            <td>Springwood Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Allan White</td>
                            <td>DC Motors Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Parts Manager</td>
                            <td>David Fruscalzo</td>
                            <td>Cricks Nambour Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Service Manager</td>
                            <td>Roxanne Karlish</td>
                            <td>Dalby Nissan</td>
                        </tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - SA &amp; NT</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Emidio Tarzia</td>
                            <td>Lakeside Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Adnan Azmarli</td>
                            <td>Lakeside Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Service Manager</td>
                            <td>Sebastian Schmidt</td>
                            <td>Lakeside Nissan</td>
                        </tr>
                    </tbody>-->
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - VIC &amp; TAS</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Poppy Brocksopp</td>
                            <td>Ringwood Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Parts Manager</td>
                            <td>Nick Madzoski</td>
                            <td>Ralph D'Silva Nissan</td>
                        </tr>
                    </tbody>
                    <thead class="nissan-table-header">
                        <tr><td><strong>1<sup>st</sup> Rank - WA</strong></td><td></td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active">
                            <td>Sales Manager</td>
                            <td>Stephen Rose</td>
                            <td>Total Nissan</td></tr>
                        <tr class="active">
                            <td>Retail Sales Consultant</td>
                            <td>Wayne Matau</td>
                            <td>Rockingham Nissan</td>
                        </tr>
                        <tr class="active">
                            <td>Fleet Sales Executive</td>
                            <td>Sophie Totham</td>
                            <td>Northside Nissan</td>
                        </tr>
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
                        <tr class="active"><td>Abby Hansen</td><td>Swan Hill Nissan</td></tr>
                        <tr class="active"><td>Adam Papuga</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Adrian Gerada</td><td>Essendon Nissan</td></tr>
                        <tr class="active"><td>Alex Vidales</td><td>Barton's Wynnum Nissan</td></tr>
                        <tr class="active"><td>Andrew Chao</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Andrew Loftus</td><td>Ringwood Nissan</td></tr>
                        <tr class="active"><td>Ben Bilsborow</td><td>Adelaide Hills Nissan</td></tr>
                        <tr class="active"><td>Ben Kerr</td><td>Pennant Hills Nissan</td></tr>
                        <tr class="active"><td>Ben Possamai</td><td>Warragul Nissan</td></tr>
                        <tr class="active"><td>Brendan Cooper</td><td>DC Motors Nissan</td></tr>
                        <tr class="active"><td>Damian Keenahan</td><td>Brookvale Nissan</td></tr>
                        <tr class="active"><td>Dillon Franks</td><td>Augusta Nissan</td></tr>
                        <tr class="active"><td>Dylan Barter</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Gary Dundas</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Greg Dennis</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Jason Jolley</td><td>Lismore Nissan</td></tr>
                        <tr class="active"><td>Jaylen Adlington</td><td>Moorooka Nissan</td></tr>
                        <tr class="active"><td>Jeanette Morgan</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Josh Klein</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Joshua Ferguson</td><td>Brighton Nissan</td></tr>
                        <tr class="active"><td>Justin Bath</td><td>Barton's Capalaba Nissan</td></tr>
                        <tr class="active"><td>Ken Bradley</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Kyle Nettleton</td><td>Southern Vales Nissan</td></tr>
                        <tr class="active"><td>Mason Garrod</td><td>Peter Stevens Nissan</td></tr>
                        <tr class="active"><td>Michael Dexter</td><td>Wyong Nissan</td></tr>
                        <tr class="active"><td>Michael Quinton</td><td>Gosford Nissan</td></tr>
                        <tr class="active"><td>Nicholas Shand</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Paul Lawson</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Stephen Burns</td><td>Adrian Brien Nissan</td></tr>
                        <tr class="active"><td>Stephen Forrest</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Tim Overall</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>Young Ha</td><td>Liverpool Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Retail Sales Consultant</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Abigail Nicholls</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Adam Milne</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Aki Singh</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Alex Santagada</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Anthony Lieschke</td><td>Lieschke Nissan</td></tr>
                        <tr class="active"><td>Ben Umar</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Berny Joson</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Caillan Halliday</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Chris Breen</td><td>Wyong Nissan</td></tr>
                        <tr class="active"><td>Chris Smedley</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Courtney Size</td><td>Adrian Brien Nissan</td></tr>
                        <tr class="active"><td>Craig Scanlan</td><td>Warwick Nissan</td></tr>
                        <tr class="active"><td>Dale Timms</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>Daniel Kelly</td><td>Westco Motors</td></tr>
                        <tr class="active"><td>Darin Marevich</td><td>Bendigo Nissan</td></tr>
                        <tr class="active"><td>Dean Lovell</td><td>Hobart Nissan</td></tr>
                        <tr class="active"><td>Derryn Kelly</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Dion Kolyvas</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Duncan Mclean</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Eddie Sarwari</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Edin Kuhinja</td><td>Morley City Nissan</td></tr>
                        <tr class="active"><td>Emre Corumlu</td><td>von Bibra Robina Nissan</td></tr>
                        <tr class="active"><td>Ethan Latifi</td><td>DC Motors Nissan</td></tr>
                        <tr class="active"><td>Evan Mamonitis</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Filip Talevski</td><td>Northern Nissan</td></tr>
                        <tr class="active"><td>Gary Troughton</td><td>Moorooka Nissan</td></tr>
                        <tr class="active"><td>George Andriolo</td><td>Barton's Capalaba Nissan</td></tr>
                        <tr class="active"><td>Hailey Little</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Hannah Park</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Harrison Kelly</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Jacob Briggs</td><td>Lennock Motors</td></tr>
                        <tr class="active"><td>Jaidyn Lavelle</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>James Petterson</td><td>Essendon Nissan</td></tr>
                        <tr class="active"><td>Jarod Donnelly</td><td>Ipswich Nissan</td></tr>
                        <tr class="active"><td>Jeff Hammond</td><td>Dalby Nissan</td></tr>
                        <tr class="active"><td>Joel Dean</td><td>Keema Nissan</td></tr>
                        <tr class="active"><td>John Andersen</td><td>Townsville Nissan</td></tr>
                        <tr class="active"><td>Kia Perelini</td><td>Motorama Nissan</td></tr>
                        <tr class="active"><td>Lucas Pedley</td><td>Penrith Nissan</td></tr>
                        <tr class="active"><td>Mario Theodoulou</td><td>Essendon Nissan</td></tr>
                        <tr class="active"><td>Mark Holt</td><td>Total Nissan</td></tr>
                        <tr class="active"><td>Martin Van Eeden</td><td>Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>Massimo Tonellato</td><td>von Bibra Gold Coast Nissan</td></tr>
                        <tr class="active"><td>Michael Beattie</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Naveen Perera</td><td>Penrith Nissan</td></tr>
                        <tr class="active"><td>Noah Jackson</td><td>North Jacklin Nissan</td></tr>
                        <tr class="active"><td>Oliver Buckley</td><td>Moorooka Nissan</td></tr>
                        <tr class="active"><td>Omer Sevgi</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Paul Efthymiou</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Rodney El Azzi</td><td>Suttons Arncliffe Nissan</td></tr>
                        <tr class="active"><td>Simon Wise</td><td>Adelaide Hills Nissan</td></tr>
                        <tr class="active"><td>Stephen Blakey</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Stephen Wiltshire</td><td>Springwood Nissan</td></tr>
                        <tr class="active"><td>Tristram Winter</td><td>Kerry Nissan</td></tr>
                        <tr class="active"><td>William Braisby</td><td>Suttons Arncliffe Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Fleet Sales Executive</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Adam Baumgardner</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Ben Maslen</td><td>Westpoint Nissan</td></tr>
                        <tr class="active"><td>Mandy Kerr</td><td>Pennant Hills Nissan</td></tr>
                        <tr class="active"><td>Will Quin</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Parts Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Adam Ellis</td><td>Adelaide Hills Nissan</td></tr>
                        <tr class="active"><td>Adam Waisman</td><td>Burwood Nissan</td></tr>
                        <tr class="active"><td>David Rowe</td><td>Yarra Valley Nissan</td></tr>
                        <tr class="active"><td>Leon Hanna</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Stuart Dundee</td><td>Ferntree Gully Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Service Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Andrew Bing</td><td>Lismore Nissan</td></tr>
                        <tr class="active"><td>Matthew Bateman</td><td>Adelaide Hills Nissan</td></tr>
                        <tr class="active"><td>Paul Richardson</td><td>Adrian Brien Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>Service Advisor</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Bradley Clifton</td><td>Frank Spice Auto Repairs</td></tr>
                        <tr class="active"><td>Daniel Fatchen</td><td>Adelaide Hills Nissan</td></tr>
                        <tr class="active"><td>David Scanlon</td><td>Adrian Brien Nissan</td></tr>
                        <tr class="active"><td>Julie Renye</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Lesley Schimke</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Micheal Woolacott</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Peter Darmody</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Rebecca Kemp</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Rhys Pratt-Linnell</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Ros Sayers</td><td>Lakeside Nissan</td></tr>
                    </tbody>

                    <thead class="nissan-table-header">
                        <tr><td>F & I Manager</td><td></td></tr>
                    </thead>
                    <tbody class="nissan-table-body-light-grey">
                        <tr class="active"><td>Aaron Ha	Morley</td><td>City Nissan</td></tr>
                        <tr class="active"><td>Aiden Stewart</td><td>Gatton Auto</td></tr>
                        <tr class="active"><td>Andrew Wadham</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Arezoo Fatahi Darani</td><td>Springwood Nissan</td></tr>
                        <tr class="active"><td>Arthur Vagionas</td><td>Lakeside Nissan</td></tr>
                        <tr class="active"><td>Bhavin Jani</td><td>Werribee Nissan</td></tr>
                        <tr class="active"><td>Bryan Hansen</td><td>Sunshine Coast Nissan</td></tr>
                        <tr class="active"><td>Carol Wyer</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Corinne Henry</td><td>Penrith Nissan</td></tr>
                        <tr class="active"><td>Craig Mckinnon</td><td>Wyong Nissan</td></tr>
                        <tr class="active"><td>Darryl Currey</td><td>Gladstone Nissan</td></tr>
                        <tr class="active"><td>Emily Williams</td><td>Mantello Nissan</td></tr>
                        <tr class="active"><td>Gaynor Collins</td><td>Dandenong Nissan</td></tr>
                        <tr class="active"><td>Jill Ollier</td><td>Gosford Nissan</td></tr>
                        <tr class="active"><td>Jodi Wilson</td><td>Bendigo Nissan</td></tr>
                        <tr class="active"><td>Julie Blanchett</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Kathrine Moore</td><td>Springwood Nissan</td></tr>
                        <tr class="active"><td>Kristy Williams</td><td>Warragul Nissan</td></tr>
                        <tr class="active"><td>Kymberly Hector</td><td>Northside Nissan</td></tr>
                        <tr class="active"><td>Mehmet Yesilagac</td><td>Berwick Nissan</td></tr>
                        <tr class="active"><td>Michael Frese</td><td>Moorooka Nissan</td></tr>
                        <tr class="active"><td>Nicole Mcdougall</td><td>Dalby Nissan</td></tr>
                        <tr class="active"><td>Paul Whitelaw</td><td>Thompson Nissan</td></tr>
                        <tr class="active"><td>Ray Lu</td><td>Ferntree Gully Nissan</td></tr>
                        <tr class="active"><td>Romina D'angelo</td><td>Rockingham Nissan</td></tr>
                        <tr class="active"><td>Ross De Joodt</td><td>Waverley Nissan</td></tr>
                        <tr class="active"><td>Santo Lo Grande</td><td>Morley City Nissan</td></tr>
                        <tr class="active"><td>Shelley Winslade</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Tammi Hayes</td><td>Peter Stevens Nissan</td></tr>
                        <tr class="active"><td>Tenae Ilias</td><td>North Lakes Nissan</td></tr>
                        <tr class="active"><td>Tony Crawshaw</td><td>McRae Nissan</td></tr>
                        <tr class="active"><td>Tracy Sbrana</td><td>Caboolture Nissan</td></tr>
                        <tr class="active"><td>Troy Johnson</td><td>Macarthur Nissan</td></tr>
                        <tr class="active"><td>Vanessa Schulmeister</td><td>Adrian Brien Nissan</td></tr>
                        <tr class="active"><td>Vid Chandrashekar</td><td>Hobart Nissan</td></tr>
                    </tbody>

                    <!--


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

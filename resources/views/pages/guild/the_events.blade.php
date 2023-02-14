@extends('pages.guild')
@section('guild_header')
    <div class="d-flex flex-column align-items-center guild-event-header">
        @include('pages.guild.buttons')
    </div>
@endsection
@section('guild_content')
    <div class="d-flex">
        <div class="col-10 offset-1">
            <h3>THE GUILD FY22 IS COMING!</h3>
            <p>
                We are currently planning the FY22 GUILD event and will update you in coming months.  Where to you ask?  We have some great ideas in mind and many new Gold and Platinum inductees to recognise at our Mystery Destination.
            </p>
            <!--<a class="edm-link" target="_blank" href="https://mailchi.mp/7c6c496225fb/nissan-dealer-excellence-fy18-results-3120310?e=1dac1983c2">
                Click here to view edm content
            </a>
            <a style="margin-left: 50px" class="edm-link" target="_blank" href="https://mailchi.mp/cfe71f39c4e8/nissan-dealer-excellence-fy18-results-3121409?e=1dac1983c2">
                Click here to view edm update
            </a>
            <a style="margin-left: 50px" class="edm-link" target="_blank" href="http://www.destination.com.au/nissan/ELITE/The_Guild/3695-NIS1018-Nissan_ELITE_Guild_2021.mp4">
                Click here to preview THE GUILD NOOSA
            </a> -->
            <h3>Platinum Members (500,000+)</h3>
            <table class="table table-striped">
                <tbody>
                @foreach($results['PLATINUM'] as $val)
                <tr><td style="width:50%;">{{ $val->member }}</td><td>{{ $val->dealer }}</td></tr>
                @endforeach
                </tbody>
            </table>

            <h3>Gold Members (325,000+)</h3>
            <table class="table table-striped">
                <tbody>
                @foreach($results['GOLD'] as $val)
                <tr><td style="width:50%;">{{ $val->member }}</td><td>{{ $val->dealer }}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex">
        <div class="col-8 offset-1">
            <h3>PAST EVENT</h3>
            <h3>THE GUILD WEEKEND 2022 – NISSAN ELITE FY21</h3>

            <p>THE GUILD headed North to the Top End landing in Darwin for a true Aussie adventure.  Members and partners enjoyed a fun packed weekend with Jumping Crocodiles, Wildlife park and refreshing swim at Berry Springs.  The Gala Presentation Dinner inducting 12 new GOLD GUILD members and 3 GOLD members to PLATINUM GUILD was held at Pee Wee’s on the Point overlooking a true Darwin sunset.</p>

            <p>&nbsp;</p>
            <h3>Past Experiences</h3>

            <table>
                <tbody>
                    <tr style="line-height: 2em;"><td width=13%>2023</td><td>COMING SOON!</td></tr>
                    <tr style="line-height: 2em;"><td width=13%>2022</td><td>DARWIN NORTHERN TOP END – DoubleTree by Hilton, with gala dinner at Pee Wee’s at the Point</td></tr>
                    <tr style="line-height: 2em;"><td width=13%>2021</td><td>NOOSA QUEENSLAND - Sofitel Resort, gala dinner at Bistro C and Catalina Extravaganza</td></tr>
                    <tr style="line-height: 2em;"><td width=13%>2020</td><td>CANCELLED – COVID19, Dealer Trophy presentation and complimentary Travel Voucher</td></tr>
                    <tr style="line-height: 2em;"><td>2019</td><td>HOBART TASMANIA – Hobart Grand Chancellor,  with Gala dinner at Frogmore Creek and MONA Cruise</td></tr>
                    <tr style="line-height: 2em;"><td>2018</td><td>PORT DOUGLAS - Sheraton Grand Mirage Resort with dinner at The Watergate Restaurant</td></tr>
                    <tr style="line-height: 2em;"><td>2017</td><td>HAMILTON ISLAND – Reef View Hotel with dinner on The Bommie Deck pier</td></tr>
                    <tr style="line-height: 2em;"><td>2016</td><td>ULURU RED CENTRE – Sales in the Desert Hotel with dinner Under the Outback Sky experience</td></tr>
                    <tr style="line-height: 2em;"><td>2014</td><td>BAROSSA VALLEY – Novatel Barossa Valley Resort with dinner at Yalumba Signature Cellar and wine tastings </td></tr>
                    <tr style="line-height: 2em;"><td>2013</td><td>MELBOURNE – Langham Hotel with cocktails and Bon Jovi Concert at Etihad stadium</td></tr>
                    <tr style="line-height: 2em;"><td>2012</td><td>SYDNEY HARBOUR – The Sebel Pier One Hotel with dinner on the Blue Room harbour cruise</td></tr>
                    <tr style="line-height: 2em;"><td>2010</td><td>MELBOURNE – The Windsor Hotel with cocktails at the Princess Theatre and Hairspray musical</td></tr>
                    <tr style="line-height: 2em;"><td>2008</td><td>HOBART TASMANIA – Grand Chancellor Hotel and dinner at Marque IV restaurant</td></tr>
                    <tr style="line-height: 2em;"><td>2007</td><td>GOLD COAST – The Sheraton Mirage with dinner at Elysian Fields Estate</td></tr>
                    <tr style="line-height: 2em;"><td>2006</td><td>MELBOURNE – Crown Towers with dinner on Colonial Tramcar Restaurant and The Boy from OZ musical</td></tr>
                    <tr style="line-height: 2em;"><td>2005</td><td>MELBOURNE – Westin Hotel with cocktails at the Regent and The Lion King musical</td></tr>
                    <tr style="line-height: 2em;"><td>2004</td><td>MELBOURNE – Crown Towers with dinner in the Garden Room and river cruise to MCG for Richmond v Sydney   </td></tr>
                    <tr style="line-height: 2em;"><td>2003</td><td>MELBOURNE – Sheraton Towers Southgate with dinner in Yarra Room</td></tr>
                    <tr style="line-height: 2em;"><td>2001</td><td>MELBOURNE – Crown Towers Melbourne with dinner and Mornington Peninsula Golf</td></tr>
                    <tr style="line-height: 2em;"><td>2000</td><td>MELBOURNE – Crown Towers Melbourne with dinner and Mornington Peninsula Golf</td></tr>
                </tbody>
            </table>
        </div>
        <div class="page-widget col-3">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <div class="row">
                <!--<iframe src="https://destination.com.au/nissan/ELITE/The_Guild/3695-NIS1018-Nissan_ELITE_Guild_2021.mp4" frameborder="0" allowfullscreen></iframe>-->
                <a href="https://nissanevents.pixieset.com/nissanelitetheguild2022/">view THE GUILD FY21 DARWIN PHOTOS</a>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <iframe src="https://destination.com.au/nissan/ELITE/The_Guild/3695-NIS1018-Nissan_ELITE_Guild_2021.mp4" frameborder="0" allowfullscreen></iframe>
                <a href="">NOOSA INDUCTEES and more…</a>
                <a href="https://nissanevents.pixieset.com/nissantheguildnoosafy20/">View THE GUILD FY20 NOOSA PHOTOS</a>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <iframe src="https://www.youtube.com/embed/KaBL4Y18oco" frameborder="0" allowfullscreen></iframe>
                <a href="https://mailchi.mp/35dc020024bd/nissan-dealer-excellence-fy18-results-3118361">HOBART INDUCTEES and more…</a>
            </div>
        </div>
    </div>
@endsection

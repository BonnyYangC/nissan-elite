@extends('pages.guild')
@section('guild_header')
    <div class="d-flex flex-column align-items-center guild-event-header">
        @include('pages.guild.buttons')
    </div>
@endsection
@section('guild_content')
    <div class="d-flex">
        <div class="col-10 offset-1">
            <h3>THE GUILD TO CONVENE IN NOOSA</h3>
            <p>
                We have great pleasure in announcing that THE ELITE GUILD will convene in Noosa Heads on Queensland’s Sunshine Coast Friday 18 March till Sunday 20 March 2022. Luxurious accommodation has been reserved at the Sofitel Noosa Pacific Resort and a wonderful weekend is planned for those qualified members and new inductees that are listed below.
            </p>
            <a class="edm-link" target="_blank" href="https://mailchi.mp/7c6c496225fb/nissan-dealer-excellence-fy18-results-3120310?e=1dac1983c2">
                Click here to view edm content
            </a>
            <a style="margin-left: 50px" class="edm-link" target="_blank" href="https://mailchi.mp/cfe71f39c4e8/nissan-dealer-excellence-fy18-results-3121409?e=1dac1983c2">
                Click here to view edm update
            </a>
            <a style="margin-left: 50px" class="edm-link" target="_blank" href="http://www.destination.com.au/nissan/ELITE/The_Guild/3695-NIS1018-Nissan_ELITE_Guild_2021.mp4">
                Click here to preview THE GUILD NOOSA
            </a>
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
            <h3>THE GUILD WEEKEND 2021 – NISSAN ELITE FY20</h3>

            <p>THE GUILD ON CATCHUP!  After many postponements we finally arrived to celebrate our FY20 GUILD event.  A lovely weekend was spent in Noosa, Queensland enjoying the hospitality of the Sofitel Resort, Hastings Street in the midst of all Noosa has to offer.
                 Our GUILD Dinner was enjoyed after a beautiful beach sunset, where we inducted both Gold and Platinum members for their excellent achievements with Nissan loyalty to the Brand.    Guests enjoyed Bistro C, Catalina and time to enjoy a break with fellow members.
            </p>

            <p>&nbsp;</p>

            <h3>THE GUILD WEEKEND 2020 – NISSAN ELITE FY19</h3>

            <p>With COVID-19 forcing the cancellation of our event, our FY19 GOLD and PLATINUM inductees have been congratulated and Trophies awarded along with a Travel Voucher for all eligible trip Lifetime members to celebrate at a destination of their choice.
                Nissan ELITE providing EFTPOS funds to all dealerships for this outstanding Loyalty to the Brand to be recognised at a Celebratory Morning Tea with the whole team.
            </p>

            <p>&nbsp;</p>
            <h3>Past Experiences</h3>

            <table>
                <tbody>
                <tr style="line-height: 2em;"><td width=13%>2021</td><td>NOOSA, QUEENSLAND – Sofitel Resort, sunset dinner at Bistro C and Catalina on the river.</td></tr>
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

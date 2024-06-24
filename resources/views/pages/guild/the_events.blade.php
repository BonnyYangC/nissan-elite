@extends('pages.guild')
@section('guild_header')
    <div class="d-flex flex-column align-items-center guild-event-header">
        <img class="guild-event-banner" src="/images/md_guild/2024/Guild_events_header.png"/>
        @include('pages.guild.buttons')
    </div>
@endsection
@section('guild_content')
    <div class="d-flex">
        <div class="col-10 offset-1" style="padding-top: 2%">
            <h3>
                THE GUILD FY23 WILL CONVENE ON THE GOLD COAST – SATURDAY 14
SEPTEMBER – MONDAY 16 SEPTEMBER 2024
            </h3>
            <p>
                Invitations have been emailed to eligible Foundation members, along with our new inductees in FY23. We have
a great weekend in store for our eligible GUILD MEMBERS in September and below are our new inductees for
FY23 Platinum (500,000+) and new to Gold (325,000+).
            </p>
            <p>
                Congratulations on the excellent achievement and Loyalty to the Brand shown here.
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
        <div class="col-8 offset-1" style="padding-right: 2%; padding-top: 2%">
            <!--<h3>THE GUILD WEEKEND 2023 – NISSAN ELITE FY22</h3>

            <p>
                Arriving in Melbourne Saturday 5 August, our members were welcomed in true Melbourne style as VIP guests at the Hawthorn Presidents function to see the Hawthorn v Collingwood match at the MCG.  And, what a match it was with Hawthorn taking out an outstanding win over the reigning premiers Collingwood.  On Sunday evening hosted by Members of the Nissan Management Operating Committee, in honour of their fine achievement, we inducted our new GOLD inductees to THE GUILD.  Dining at St Telmo restaurant and entertained by Argentinian dancers throughout the night, our GUILD members and partners enjoyed long term catchups, new friendships, and much chatter about their day at THE LUME, shopping, site seeing in Melbourne, or putting the Patrol through its paces.
            </p>-->

            <h3>THE GUILD WEEKEND 2024 – NISSAN ELITE FY23</h3>

            <p>
                Stay tuned for more on our upcoming GUILD event coming soon.
            </p>
            <p>&nbsp;</p>
            <h3>Past Experiences</h3>

            <table>
                <tbody>
                    <tr style="line-height: 2em;"><td width=13%>2023</td><td>MELBOURNE – Sheraton Hotel, VIP at MCG Hawthorns Presidents function, THE LUME and gala dinner</td></tr>
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
                <iframe src="https://destination.com.au/nissan/ELITE/Product%20Challenge/NIS1092%20-%20Nissan%20ELITE%20Product%20Challenge%20Guild%20Video%202023%20-%20Melbourne.mp4" frameborder="0" allowfullscreen></iframe>
                <p class="txt-red">FY22/2023 MELBOURNE</p>
                <a href="https://nissanevents.pixieset.com/nissanelitetheguild2022copy/">View video above and click this link to view photos</a>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <iframe src=" https://destination.com.au/nissan/ELITE/Product%20Challenge/Nissan%20Darwin%20Video.mp4" frameborder="0" allowfullscreen></iframe>
                <p class="txt-red">FY21/2022 DARWIN</p>
                <a href="https://nissanevents.pixieset.com/nissanelitetheguild2022/">View video above and click this link to view photos</a>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <iframe src="https://destination.com.au/nissan/ELITE/The_Guild/3695-NIS1018-Nissan_ELITE_Guild_2021.mp4" frameborder="0" allowfullscreen></iframe>
                <p class="txt-red">FY20/2021 NOOSA</p>
                <a href="https://nissanevents.pixieset.com/nissantheguildnoosafy20/">View video above and click this link to view photos</a>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <iframe src="https://www.youtube.com/embed/KaBL4Y18oco" frameborder="0" allowfullscreen></iframe>
                <p class="txt-red">FY18/2019 HOBART</p>
                <a href="https://nissanevents.pixieset.com/nissaneliteguildevent/">View video above and click this link to view photos</a>
            </div>
        </div>
    </div>
@endsection

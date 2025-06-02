@extends('pages.guild')
@section('guild_header')
    <div class="d-flex flex-column align-items-center guild-event-header">
        <img class="guild-event-banner" src="{{ theme_image('md_guild/Guild_events_header.png') }}"/>
        <div class="guild-buttons" style="margin-top: 4%;">
        @include('pages.guild.buttons')
        </div>
    </div>
@endsection
@section('guild_content')
    <div class="d-flex">
        <div class="col-10 offset-1" style="padding-top: 2%">
            <h3>
                THE GUILD FY24 WILL CONVENE IN 2025 TBA
            </h3>
            <p>
                Invitations will be emailed to eligible Foundation members, along with our new inductees in FY24. A great weekend is in store for our eligible GUILD MEMBERS in 2025 and below are our new inductees for FY24 Platinum (500,000+) and new to Gold (325,000+).
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
            <h3>THE GUILD WEEKEND 2025 – NISSAN ELITE FY24</h3>

            <p>
                Stay tuned for more on our upcoming GUILD event coming soon.
            </p>
            <p>&nbsp;</p>
            <h3>Past Experiences</h3>

            <table>
                <tbody>
                    <tr style="line-height: 2em;"><td width=13%>2024</td><td>GOLD COAST – QT Hotel, gala dinner at The Glasshouse, Jet Skiing experience and La Luna Beach Club </td></tr>
                    @include(theme_view('guild_event_past', 'default'))

                </tbody>
            </table>
        </div>
        <div class="page-widget col-3">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @include(theme_view('guild_event_video', 'default'))
        </div>
    </div>
@endsection

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
            @include(theme_view('guild_event_content'))
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

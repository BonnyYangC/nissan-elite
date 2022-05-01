@extends('pages.guild')
@section('guild_header')
    <div class="d-flex flex-column align-items-center guild-header">
        @include('pages.guild.buttons')
        <div class="mb-5">
            <img class="img-responsive center-block" alt="" src="{{ asset('images/md_guild/The_Guild.png') }}">
        </div>
    </div>
@endsection
@section('guild_content')
    <div class="d-flex justify-content-center">
        <div class="col-10">
            <p>&nbsp;</p>
            <h3>PLATINUM MEMBERS (500,000+)</h3>

            <table class="table table-striped">
                <tbody>
                @foreach($results['PLATINUM'] as $val)
                <tr><td width=30%>{{ $val->member }}</td><td>{{ $val->dealer }}</td></tr>
                @endforeach
                </tbody>
            </table>

            <p>&nbsp;</p>
            <h3>GOLD MEMBERS (325,000+)</h3>

            <table class="table table-striped">
                <tbody>
                @foreach($results['GOLD'] as $val)
                    <tr><td width=30%>{{ $val->member }}</td><td>{{ $val->dealer }}</td></tr>
                @endforeach
                </tbody>
            </table>

            <p>&nbsp;</p>
            <h3>LIFETIME MEMBERS - Retired</h3>

            <table class="table table-striped">
                <tbody>
                <tr><td width=30%></td><td></td><td  align ='center'>inducted</td></tr>
                @foreach($results['LIFETIME'] as $val)
                    <tr><td>{{ $val->member }}</td><td>{{ $val->dealer }}</td><td  align ='center'>{{ $val->retired }}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

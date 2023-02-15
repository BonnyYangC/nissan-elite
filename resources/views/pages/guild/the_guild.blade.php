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
            <p>THE GUILD members are our most valued Loyalty to the Brand members of Nissan ELITE!</p>
            <p>GOLD Induction to The GUILD is awarded in recognition of GOLD LOYALTY level achievement, 325,000+ points achieved in the program for Excellence and Loyalty in their day to day role. </p>
            <p>PLATINUM induction is awarded in recognition of PLATINUM LOYALTY achievement, 500,000+ points achieved.  Truly our best of the best!</p>
            <p>To be invited to annual events members must achieve each program year, the nominated Status Award Level OR  equivalent ELITE Status Average (lifetime points/years of service). Refer Member Guide for full details.</p>
            <p>
                THE GUILD was introduced back in 2000 to award our best of the best with membership steadily growing year after year. Members and their partners are invited to join members of the MOC each year for a Gala weekend. Over the years THE GUILD has formed many a true friendship amongst members!</p>
            <p>See where THE GUILD members have celebrated along with news on our next trip click <a href="{{ route('guild.events') }}" style="color: #c71444; font-weight : bold;">EVENTS</a> tab.</p>
        </div>
    </div>
@endsection

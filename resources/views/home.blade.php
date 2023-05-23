@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')
<div class="justify-content-center">
    <div class="row justify-content-center" style="margin-top:3%">
        <div class="col-2">
            <a href="{{ route('dashboard') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/my_dashboard.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('member_guide') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/member_guide.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('ranking') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/rankings.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('incentives') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/incentives.png') }}" width="332">
            </a>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top:3%;">
        <div class="col-2">
            <a href="{{ route('product_challenge') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/product_challenge.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('guild') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/md_guild.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <!--{% if user.position == 'M' %}
            {% set param = '/api?role=' ~ user.position ~ '&code=' ~ user.company_code %}
            {% else %}
            {% set param = '/api?role=AP'%}
            {% endif %}-->
                <a target="_blank" href="{{ route('jump_to_dealer')}}">
                <img class="tiles-img" src="{{ asset('images/tiles/nissan_doty.png') }}" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('calendar') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/calendar.png')}}" width="332">
            </a>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top:3%;">
        <div class="col-2">
            <a target="_blank" href="http://nissanlearningacademy.com.au/">
                <img class="tiles-img" src="{{ asset('images/tiles/nissan_academy.png') }}" style="margin-bottom:30px;" width="332">
            </a>
        </div>
        <div class="col-2">
            <a href="{{ route('future_sales') }}">
                <img class="tiles-img" src="{{ asset('images/tiles/future_sales_incentive.png') }}" style="margin-bottom:30px;" width="332">
            </a>
        </div>
        <div class="col-2">
            <a target="_blank" href="https://nmacorp.okta.com/app/UserHome">
                <img class="tiles-img" src="{{ asset('images/tiles/ce.png') }}" style="margin-bottom:30px;" width="332">
            </a>
        </div>
        <div class="col-2">
            <a target="_blank" href="https://www.nissan.com.au/about-nissan/news-and-events.html">
                <img class="tiles-img" src="{{ asset('images/tiles/whatsnews_nissannews.png') }}" style="margin-bottom:30px;" width="332">
            </a>
        </div>
    </div>
</div>
@endsection

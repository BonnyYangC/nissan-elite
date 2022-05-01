@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page dashboard col-11">
        <div class="col-9 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>MEMBER GUIDE</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <img src="../images/member_guide/cover.jpg" style="object-fit: fill; width:100%" />

                <br>
                <br>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block">Download/View PDF</button>
                </a>
            </div>
            <div class="page-widget col-3">
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=2') }}">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block mb-1">Introduction</button>
                </a>

                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=5') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">How to Register</button>
                </a>

                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=8') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Sales</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=16') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Fleet</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=22') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Stock Controller</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=26') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">F&amp;I Manager</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=30') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Service</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=37') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Parts</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=42') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Recognition</button>
                </a>
                <a href="{{  asset('files/MEMBERS_GUIDE_2021.pdf#page=49') }}" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Terms &amp; Conditions </button>
                </a>

                <br>
                <br>
                @if (strstr($currentUser, '@nissan.com.au'))
                <a href="{{  asset('files/ELITE_WEBSITE_HOW_TO_HEAD_OFFICE_REGION_STAFF.pdf') }}" target="_blank">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block">Navigating the Site</button>
                </a>
                @else
                <a href="{{  asset('files/ELITE_WEBSITE_HOW_TO_GUIDE_MEMBERS.pdf') }}" target="_blank">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block">Navigating the Site</button>
                </a>
                @endif
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

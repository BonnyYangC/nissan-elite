@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page dashboard col-11">
        <div class="col-9 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>future sales</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <img src="../images/future_sales/2024/cover.png" style="object-fit: fill; width:100%" />
            </div>
            <div class="page-widget col-3">
                <a href="{{ route('future_sales.explanation') }}">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block mb-1">Future Sales</button>
                </a>

                <a href="https://www.nissan.com.au/virtual-showroom.html" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Nissan Virtual Showroom</button>
                </a>

                <a href="{{ route('future_sales.contact_schedule') }}">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Download<br>Customer Contact Schedule</button>
                </a>
                <a href="{{ route('future_sales.postcard') }}">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">View and Order Postcards</button>
                </a>
                <!--<a href="https://mailchi.mp/acee0061149c/nissan-dealer-business-development-group-meeting1-3121262?e=1dac1983c2" target="_blank">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Incentive – ELITE Bonus Points</button>
                </a>-->
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

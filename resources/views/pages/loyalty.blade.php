@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page loyalty col-11">
        <div class="col-9 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>Loyalty {{ config('elite.PROGRAM_AWARD_UNIT') }}</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <div>
                    <h3>Current Status Level</h3>
                    <div class="mt-2">
                        <img src="{{ asset('loyalty_status.png') }}" height=350 />
                    </div>
                    <div class="historical-data">
                        <h3>FY22 YTD : {{ number_format($ytd, 0) }} </h3>
                        <h3>FY21 YTD : {{ number_format(isset($historical['all']['2021-01-01']) ? $historical['all']['2021-01-01'] : 0, 0) }} </h3>
                        <h3>FY20 YTD : {{ number_format(isset($historical['all']['2020-01-01']) ? $historical['all']['2020-01-01'] : 0, 0) }} </h3>
                        <h3>FY19 YTD : {{ number_format(isset($historical['all']['2019-01-01']) ? $historical['all']['2019-01-01'] : 0, 0) }} </h3>

                        <h3>PRIOR HISTORY - Loyalty to the brand: {{ number_format($historical['loyalty_to_brand'], 0) }} </h3>
                    </div>
                </div>
            </div>
            <div class="page-widget col-3">
                @include('pages.widgets.side_panel.loyalty_points', [$ytd, $historical])
                @include('pages.widgets.side_panel.loyalty_legend')
            </div>
        </div>
    </div>
</div>
@endsection

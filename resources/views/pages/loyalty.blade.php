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
                @include(theme_view('loyalty_content'), [$historical])
                </div>
                <div class="page-widget col-3">
                    @include('pages.widgets.side_panel.loyalty_points', [$ytd, $historical])
                    @include(theme_view('loyalty_legend'))
                </div>
            </div>
        </div>
    </div>
@endsection

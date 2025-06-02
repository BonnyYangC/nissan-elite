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
                            <img src="{{ asset('loyalty_status.png') }}" width="100%" />
                        </div>
                        <div class="historical-data">
                            @foreach ($historical['all'] as $key => $value)
                            <h3>{{ $key }} : {{ $value }} </h3>
                            @endforeach
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

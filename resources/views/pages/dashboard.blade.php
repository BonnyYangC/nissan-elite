@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page dashboard col-11">
        <div class="col-9 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>Welcome {{ $currentUser->firstname }} - {{ $currentUser->position->title }} </span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <div class="monthly-point dashboard-section">
                    @include('pages.widgets.monthly_points_chart', [$monthlyPoints])
                </div>
                <div class="leader-board dashboard-section">
                    @include('pages.widgets.leader_board', [$currentUser, $rankings, $rankingsPlatinum])
                </div>
                <div class="current-status-level dashboard-section">
                    @include('pages.widgets.current_states_level', [$currentUser, $status])
                </div>
                <div class="dollar-rewards dashboard-section">
                    @include('pages.widgets.dollar_rewards_table', [$rewards])
                </div>
            </div>
            <div class="page-widget col-3">
                <h1 style="font-size: 100px;">{{ env('FY_WITH_YEAR') }}</h1>
                <h3>RANKINGS &amp; {{ config('elite.PROGRAM_AWARD_UNIT') }}</h3>
                @include('pages.widgets.side_panel.current_ranking', [$currentUser, $rankingStatus])
                @include('pages.widgets.side_panel.year_to_date', [$ytd])
                @include('pages.widgets.side_panel.loyalty_points', [$ytd, $historical])
                @include('pages.widgets.side_panel.dealer_excellence', [$currentUser])
                @include('pages.widgets.side_panel.registered', [$currentUser])
                @include('pages.widgets.side_panel.training_on_track')
                @include('pages.widgets.side_panel.criteria', [$currentUser])
                @include('pages.widgets.side_panel.last_year_elite', [$currentUser])
            </div>
        </div>
        <div class="page-section-wrap">
            <div class="metrics-chart dashboard-section">
                <h3>{{ config('elite.PROGRAM_AWARD_UNIT') }} earned per Month</h3>
                @include('pages.widgets.metrics_chart.single_role', [$currentUser, $metrics])
            </div>
        </div>
    </div>
</div>
@endsection

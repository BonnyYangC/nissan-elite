<h3>Dollar Rewards and {{ config('elite.PROGRAM_AWARD_UNIT') }} <span class="no-transform">(achieve your criteria to be rewarded)</span></h3>
@if (in_array($currentUser->position->code, App\Models\Position::TECHNICIAN_POSITIONS))
    @include('pages.widgets.rewards.technicians', [$rewards])
@else
    @include('pages.widgets.rewards.rewards_table', [$rewards])
@endif


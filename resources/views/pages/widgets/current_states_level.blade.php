<h3>Current Status Level</h3>
<div class="mt-2">
    <img src="{{ asset('current_status.png') }}" width="100%" />
    @if(!in_array($currentUser->position->code, App\Models\Position::TECHNICIAN_POSITIONS))
    <p align="center">
        <b><span style="color:#ff0000;margin-top:20px;">{{ $status->toReach }}</span> {{ $status->colorText }}</b>
    </p>
    @endif
</div>

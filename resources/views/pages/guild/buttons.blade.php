<div class="col-3">
    <a href="{{ route('guild') }}">
        @if ($currentUri_sub=='MDguild')
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_main_gold_button.png?a=1') }}" width="100%">
        @elseif ($currentUri_sub=='MDguild_events')
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_main_outline_button_white.png?a=1') }}" width="100%">
        @else
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_main_outline_button.png?a=1') }}" width="100%">
        @endif
    </a>
</div>

<div class="col-3">
    <a href="{{ route('guild.members') }}">
        @if ($currentUri_sub=='MDguild_members')
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_members_gold_button.png?a=1') }}" width="100%">
        @elseif ($currentUri_sub=='MDguild_events')
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_members_outline_button_white.png?a=1') }}" width="100%">
        @else
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_members_outline_button.png?a=1') }}" width="100%">
        @endif
    </a>
</div>
<div class="col-3">
    <a href="{{ route('guild.events') }}">
        @if ($currentUri_sub=='MDguild_events')
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_events_gold_button.png?a=1') }}" width="100%">
        @else
            <img class="img-responsive" src="{{ asset('images/md_guild/Guild_events_outline_button.png?a=1') }}" width="100%">
        @endif
    </a>
</div>
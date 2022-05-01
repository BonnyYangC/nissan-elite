
    <div class="includes_list top_includes_list text-right text-nowrap">
        <p class="loggedin">
            @if($fromApi)
            <span>
                <a href="{{ url('/api/close') }}">BACK TO DEALER EXCELLENCE</a>
            </span>
            @elseif ($viewLastYear)
            <span style="padding-right:40px">
                <a href="{{ url('/api/close') }}" onclick="window.close();return false;">BACK TO SEARCH</a>
            </span>
            @elseif ($dashboardMenuOnly)
            <span style="padding-right:40px">
                <a href="#" onclick="window.close();return false;">BACK TO SEARCH</a>
            </span>
            @else
            <span style="color:#b58631">{{ $currentUser->firstname.' '.$currentUser->lastname }}</span>

            @if($currentUser->dealer)
            <span>{{ $currentUser->dealer->name }}</span>
            @endif
            <span>
                <a href="{{ url('/elite_individual') }}">HOME</a>
            </span>

            <span>
                <a href="{{ route('logout') }}">LOGOUT</a>
            </span>
            @endif
        </p>
    </div>



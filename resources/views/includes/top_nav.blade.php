
    <div class="includes_list top_includes_list text-right text-nowrap">
        <p class="loggedin">
            @if($fromApi)
                <span style="padding-right:40px;color:#ffffff">
                    @if(!$mock)
                    <a href="#" onclick="window.close();return false;">BACK TO DEALER EXCELLENCE</a>
                    @else
                    <a href="#" onclick="window.close();return false;">BACK TO SEARCH</a>
                    @endif
                </span>
            @elseif ($viewLastYear)
                <span style="padding-right:40px;color:#ffffff">
                    <a href="{{route('api.back_to_current_year')}}">BACK TO FY24</a>
                </span>
            @elseif ($mock)
                <span style="padding-right:40px;color:#ffffff">
                    <a href="#" onclick="window.close();return false;">BACK TO SEARCH</a>
                </span>
            @else
                <span style="color:#b58631">{{ $currentUser->firstname.' '.$currentUser->lastname }}</span>

                @if($currentUser->dealer)
                <span style="color:#ffffff">{{ $currentUser->dealer->name }}</span>
                @endif
                <span style="color:#ffffff">
                    <a href="{{ url('/elite_individual') }}">HOME</a>
                </span>

                <span style="color:#ffffff">
                    <a href="{{ route('logout') }}">LOGOUT</a>
                </span>
            @endif
        </p>
    </div>

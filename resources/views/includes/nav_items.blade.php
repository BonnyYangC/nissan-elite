<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        @if (in_array(\App\Helper\Defination::PAGE_DASHBOARD, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_DASHBOARD?'current':null }}">
            <a class="nav-link" href="{{ route('dashboard') }}">My dashboard</a>
        </li>
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_METRICS, $acls))
            @if ($currentUser->hasMultipleRoles && $allowDropdown)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Metrics</a>
                <ul class="dropdown-menu">
                    @foreach ( $currentUser->positions() as $code => $title)
                    <li><a class="dropdown-item" href="{{ route('metrics', ['asPosition' => $code]) }}">
                        @if ($selectedPosition->get('code') == $code)
                        <span class="text-danger"><i class="fa fa-check-circle"></i>&nbsp;{{ $title }}</span>
                        @else
                        <span>{{ $title }}</span>
                        @endif
                    </a></li>
                    @endforeach
                </ul>
            </li>
            @else
            <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_METRICS?'current':null }}">
                <a class="nav-link" href="{{ route('metrics') }}">Metrics</a>
            </li>
            @endif
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_MY_TEAM, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_MY_TEAM?'current':null }}">
            <a class="nav-link" href="{{ route('my_team') }}">My Team</a>
        </li>
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_RANKING, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_RANKING?'current':null }}">
            <a class="nav-link" href="{{ route('ranking') }}">Rankings</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_INCENTIVES, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_INCENTIVES?'current':null }}">
            <a class="nav-link" href="{{ route('incentives') }}">Incentives</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_MEMBER_GUIDE, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_MEMBER_GUIDE?'current':null }}">
            <a class="nav-link" href="{{ route('member_guide') }}">Member Guide</a>
        </li>
        @endif

        @if (config('theme.'.config('app.theme') . '.feature_further_sales') && in_array(\App\Helper\Defination::PAGE_FUTURE_SALES, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_FUTURE_SALES?'current':null }}">
            <a class="nav-link" href="{{ route('future_sales') }}">Future Sales</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_PROGRAM, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_PROGRAM?'current':null }}">
            <a class="nav-link" href="{{ route('program') }}">Program</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_CALENDAR, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_CALENDAR?'current':null }}">
            <a class="nav-link" href="{{ route('calendar') }}">Calendar</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_PRODUCT_CHALLENGE, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_PRODUCT_CHALLENGE?'current':null }}">
            <a class="nav-link" href="{{ route('product_challenge') }}">P. Challenge</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_AWARDS, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_AWARDS?'current':null }}">
            <a class="nav-link" href="{{ route('awards') }}">Awards</a>
        </li>
        @endif

        @if (in_array(\App\Helper\Defination::PAGE_LOYALTY, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_LOYALTY?'current':null }}">
            <a class="nav-link" href="{{ route('loyalty') }}">Loyalty</a>
        </li>
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_GUILD, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_GUILD?'current':null }}">
            <a class="nav-link" href="{{ route('guild') }}">The Guild</a>
        </li>
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_ACCOUNT, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_ACCOUNT?'current':null }}">
            <a class="nav-link" href="{{ route('account') }}">Account</a>
        </li>
        @endif
        @if (in_array(\App\Helper\Defination::PAGE_HELP, $acls))
        <li class="nav-item {{ isset($menuName) && $menuName==\App\Helper\Defination::PAGE_HELP?'current':null }}">
            <a class="nav-link" href="{{ route('help') }}">Help</a>
        </li>
        @endif
    </ul>
</div>

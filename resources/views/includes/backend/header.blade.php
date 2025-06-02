<div class="admin-header">
    <nav class="navbar is-dark">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ env('SITE_URL') }}">
                <img src="https://destination.com.au/img/DESTINATION_REV_LOGO.png" alt="Nissan {{ config('elite.PROGRAM_SHORT_NAME') }}" width="112" height="32">
            </a>
        </div>
        <div id="menu" class="navbar-menu slideout-menu" >
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Users Manager
                    </a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item" href="{{ route('admin.dealers_users') }}">
                            Dealer's Users
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.region_staff') }}">
                            Region Staff
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.admin_users') }}">
                            Admin Users
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.usage') }}">
                            Site Usage
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.data_export', ['type' => 'historical_export']) }}">
                            Historical Export
                        </a>
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Content Manager
                    </a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item" href="{{ route('admin.calendars') }}">
                            Calendar
                        </a>
                        <a class="navbar-item" href="{{ route('admin.incentives') }}">
                            Incentives
                        </a>
                        <a class="navbar-item" href="{{ route('admin.news') }}">
                            NEWS
                        </a>
                        <a class="navbar-item" href="{{ route('faqs.index') }}">
                            FAQ
                        </a>
                    </div>
                </div>

                <div class="navbar-item">
                    <div id="nav-app-wrap"></div>
                </div>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a href="{{ route('logout') }}" class="button is-link">
                                <i class="fas fa-sign-out-alt"></i>&nbsp;
                                Logout
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </nav>

</div>

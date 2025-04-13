<div class="d-flex justify-content-center">

        <div class="col-2">
            <a href="{{ route('elite_individual') }}">
                <img class="d-block ml-5 nissan-logo-header" src="{{ theme_image('nissan/Nissan_logo.png') }}">
            </a>
        </div>

        <div class="col-3">
            <a href="{{ route('elite_individual') }}">
                <img class="d-block ml-5 w-75" src="{{ theme_image('nissan/Nissan_ELITE_i_ELITE-Black.png') }}">
            </a>
        </div>

        <div class="col-6">
            @include('includes.top_nav')
        </div>
</div>

<div class="d-flex justify-content-center mt-5">

    <div class="div-navbar col-11">
        <nav class="navbar navbar-expand-lg navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @include('includes.nav_items', ['allowDropdown' => true])
        </nav>
    </div>
</div>


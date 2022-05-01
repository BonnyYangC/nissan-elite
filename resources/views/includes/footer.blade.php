<div class="flex-column justify-content-center">
    <div class="col-12">
        <hr>
    </div>

    <div class="d-flex">
        <div class="footer col-lg-3">
            <p>&copy; Nissan {{ config('elite.PROGRAM_SHORT_NAME') }} {{ env('YEAR') }} Program<br>
            <br>
            <br>
            All enquiries: <br>
            <a href="mailto:{{ config('elite.SUPPORT_EMAIL_ADDRESS') }}?subject={{ config('elite.PROGRAM_NAME') }} Online Enquiry">{{ config('elite.SUPPORT_EMAIL_ADDRESS') }}</a> <br>
            <a href="{{ asset('files/MEMBERS_GUIDE.pdf#page=49') }}" target="_blank">Term & Conditions</a></p>
        </div>
        <div class="col-6">
            <nav class="navbar navbar-expand nav-footer">

                @include('includes.nav_items')

            </nav>
        </div>
        <div class="col-lg-3 mt-2">
            <img class="img-fluid" src="{{ asset('/images/nissan/Nissan_ELITE_i_ELITE-Black.png') }}">
        </div>
    </div>
</div>

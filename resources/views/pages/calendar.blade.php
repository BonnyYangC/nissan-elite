@extends('layouts.app', ['header' => true, 'footer' => true])

<script>
    var nissanEvents =  <?php echo $nissanEvents; ?>;
    var calendarEvents = [];
    nissanEvents.forEach((event, i) => {
        calendarEvents.push({
            id:event.id,
            name: event.title,
            startDate: new Date(event.datestamp),
            endDate: new Date(event.dateend)
        });
    });
    //console.log(calendarEvents);
</script>
@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>{{ config('elite.PROGRAM_SHORT_NAME') }} CALENDAR</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class='calendar'></div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection


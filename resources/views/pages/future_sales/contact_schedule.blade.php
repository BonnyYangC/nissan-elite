@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="elite-page">
            <div class="col-12">
                <a href="https://mcusercontent.com/b638801141c7c48ffb9b0915a/files/018e0ac4-028d-156f-16a0-f739332388b3/Nissan_Customer_contact_Schedule.pdf" target="_blank">
                    <img src="{{ theme_image('future_sales/contact_schedule.jpeg') }}"
                         style="width:50%; height:50%; margin-left: auto; margin-right: auto; display: block;" />
                </a>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

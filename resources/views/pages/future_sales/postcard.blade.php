@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="elite-page col-11">
            <a href="mailto:info@nissanelite.com.au?subject=Nissan%20Future%20Sales%20Postcard%20Order&body={{ $mailContent }}">
                <img src="../../images/future_sales/2024/postcard_order.png" style="object-fit: fill; width:100%" />
            </a>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

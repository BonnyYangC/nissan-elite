@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="elite-page">
            <div class="col-12">
                <a href="mailto:info@nissanelite.com.au?subject=Nissan%20Future%20Sales%20Postcard%20Order&body={{ $mailContent }}">
                    <img src="../../images/future_sales/postcard_order.jpg" style="object-fit: fill; width:100%" />
                </a>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

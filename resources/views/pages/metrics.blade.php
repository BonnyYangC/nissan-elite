@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page metrics col-11">
        <div class="page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>MY Metrics - {{ $selectedPosition->get('title') }} </span>
            </h1>
        </div>
        @foreach ($metrics as $metricData)
        <div class="row metrics-section mx-auto">
            <div class="col-12 d-flex">
                @include('pages.metrics.metric', [$currentUser, $metricData])
            </div>
        </div>
        @endforeach
        @if ($training)
        <div class="row metrics-section mx-auto">
            <div class="col-12 d-flex">
                @include('pages.metrics.training', [$currentUser, $training])
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

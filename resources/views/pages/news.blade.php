@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page incentive col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>NEWS</span>
            </h1>
        </div>

        <div id="News" class="page-section-wrap">
            <div>
                @if (count($news))
                <div class="row w-100">
                    @foreach($news as $item)
                    <div class="col-4">
                        <a href="{{ asset('/images/news/pdfs/'.$item->pdf) }}" target="_blank">
                            <img style="height: 280px;max-width: 100%;" src="{{ asset('/images/news/images/'.$item->image) }}" alt="{{ $item->title }}">
                        </a>
                        <p>{{ $item->title }}<br></p><br>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

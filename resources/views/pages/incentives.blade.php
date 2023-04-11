@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page incentive col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>INCENTIVES</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <h3>CURRENT</h3>
                <div class="d-flex justify-content-center p-5">
                @if (count($current))
                    <div class="fotorama" data-nav="thumbs" data-thumbwidth="84" data-thumbheight="60" data-max-width="100%" data-ratio="700/466">
                    @foreach($current as $slide)
                        <div data-img="{{ asset('/images/incentives/images/'.$slide->image) }}">
                            <a href="{{ asset('/images/incentives/images/pdf/'.$slide->pdf) }}" target="_blank"></a>
                        </div>
                    @endforeach
                    </div>
                @else
                    <div class="fotorama" data-click="true" data-autoplay="true" data-allowfullscreen="true">
                        <img src="{{ asset('/images/incentives/cover.png') }}"></img>
                    </div>
                @endif
                </div>
            </div>
            <div class="page-widget col-3">
                <a href="#Current">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block mb-1">Current</button>
                </a>
                <a href="#Finished">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Just Finished</button>
                </a>
                <a href="#Past">
                    <button type="button" class="btn elite-button btn-lg btn-block mb-1">Past</button>
                </a>
                <br><br>
                <a href="#News">
                    <button type="button" class="btn elite-button elite-button-active btn-lg btn-block mb-1">News</button>
                </a>
                <br><br>
                @include('pages.widgets.side_panel.registered', [$currentUser])
            </div>
        </div>
        <div id="Finished" class="page-section-wrap">
            <div class="incentive-section-wrap">
                <h3 class="mb-2">Just Finished</h3>
                @if (count($finished))
                <div class="row w-100">
                    @foreach($finished as $item)
                    <div class="col-4">
                        <a href="{{ asset('/images/incentives/images/pdf/'.$item->pdf) }}" target="_blank">
                            <img style="height: 280px;max-width: 100%;" src="{{ asset('/images/incentives/images/'.$item->image) }}" alt="{{ $item->title }}">
                        </a>
                        <p>{{ $item->start }} to {{ $item->finish }}<br>{{ $item->title }}<br></p><br>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div id="Past" class="page-section-wrap">
            <div class="incentive-section-wrap">
                <h3 class="mb-2">Past</h3>
                @if (count($past))
                    <div class="row w-100">
                        @foreach($past as $item)
                            <div class="col-4">
                                <a href="{{ asset('/images/incentives/images/pdf/'.$item->pdf) }}" target="_blank">
                                    <img style="height: 280px;max-width: 100%;" src="{{ asset('/images/incentives/images/'.$item->image) }}" alt="{{ $item->title }}">
                                </a>
                                <p>{{ $item->start }} to {{ $item->finish }}<br>{{ $item->title }}<br></p><br>
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

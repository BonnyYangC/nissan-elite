@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page loyalty col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>HIGH ACHIEVER AWARDS {{ env('FY_LAST_YEAR') }}</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="page-section-wrap col-9">
                @foreach($awards as $type => $subtypes)
                <div class="awards-section">
                    <h2>{{$type}}</h2>
                    <table class="table mt-1">
                        @foreach($subtypes as $subType => $members)
                        <thead class="nissan-table-header">
                            <tr class="table-top-row">
                                @if($type !== App\Models\AwardsType::GOLD_STATUS)
                                <td><strong>1<sup>st</sup>{{$subType}}</strong></td>
                                <td></td>
                                <td></td>
                                @else
                                <td><strong>{{$subType}}</strong></td>
                                <td></td>
                                @endif
                                @if($type === App\Models\AwardsType::PLATINUM_NATIONAL)
                                <td></td>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="nissan-table-body-light-grey">
                            @foreach($members as $member)
                            <tr class="active">
                                @if($type !== App\Models\AwardsType::GOLD_STATUS)
                                <td>{{$member['position']}}</td>
                                <td>{{$member['member']}}</td>
                                <td>{{$member['dealer']}}</td>
                                @else
                                <td>{{$member['member']}}</td>
                                <td>{{$member['dealer']}}</td>
                                @endif
                                @if($type === App\Models\AwardsType::PLATINUM_NATIONAL)
                                <td>{{$member['state']}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        @endforeach
                    </table>
                    <p><em></em></p>
                </div>
                @endforeach
            </div>
            <div class="page-widget col-3">
                <img src="{{ asset('images/awards/Elite_trophies_National.png') }}" class="w-100" alt="" />
                <img src="{{ asset('images/awards/state_trophy.png') }}" class="w-100" alt="" />
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

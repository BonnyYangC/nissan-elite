@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div id="member-ranking-app">
    <div class="d-flex justify-content-center">
        <div class="elite-page col-11">
            <div class="col-12 page-section-wrap">
                <h1 class="page-header" >
                    <span class='page-header-title'>MEMBER RANKINGS</span>
                </h1>
            </div>
            <div class="d-flex w-100 ranking justify-content-around">
                <div class="col-6 accordion" id="accordionExample">
                    @foreach($userGroups1 as $index => $group)
                    <div class="accordion-item mb-3 mx-3">
                        <div class="accordion-header {{ $group['className'] }}" id="{{ 'heading-' . $group['name'] }}">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{'#collapse' . $group['name']}}" aria-expanded="true" aria-controls="{{'collapse' . $group['name']}}">
                                <div class="squarebutton w-100"></div>
                            </a>
                        </div>
                        <div id="{{'collapse' . $group['name']}}" class="accordion-collapse collapse" aria-labelledby="{{ 'heading-' . $group['name'] }}">
                            <div class="accordion-body d-flex">
                                @foreach($group['members'] as $member)
                                    <div class="col-{{ 12 / count($group['members']) }}">
                                        <h4>{{ $member['name'] }}</h4>
                                        <table class="table">
                                            @if ($group['showAwardType'])
                                                @foreach($awardType as $sh)
                                                    <tr>
                                                        <td><a href="#myPopup" v-if="{{ $member['awardType'][$sh] ? 'true' : 'false' }}" v-on:click.prevent="displayRankingForAll('{{ $member['role'] }}', '{{$sh}}')">{{ strtoupper($sh) }}</a></td>
                                                    </tr>

                                                    @foreach($rankingForAll as $action)
                                                        <tr v-if="{{ $member['className'] . '_' . $sh }}">
                                                            <td> - <a href="#myPopup" v-on:click.prevent="handleClick('{{ $member['role'] }}','{{ $action }}','{{ $sh }}')">{{ $action }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @elseif ($group['forAll'])
                                                @foreach($rankingForAll as $action)
                                                    <tr>
                                                        <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach($rankingForNationalOnly as $action)
                                                    <tr>
                                                        <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-6 accordion" id="accordionExample">
                    @foreach($userGroups2 as $group)
                        <div class="accordion-item mb-3 mx-3">
                            <div class="accordion-header {{ $group['className'] }}" id="{{ 'heading-' . $group['name'] }}">
                                <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{'#collapse' . $group['name']}}" aria-expanded="true" aria-controls="{{'collapse' . $group['name']}}">
                                    <div class="squarebutton w-100"></div>
                                </a>
                            </div>
                            <div id="{{'collapse' . $group['name']}}" class="accordion-collapse collapse" aria-labelledby="{{ 'heading-' . $group['name'] }}">
                                <div class="accordion-body d-flex">
                                    @foreach($group['members'] as $member)
                                        <div class="col-{{ 12 / count($group['members']) }}">
                                            <h4>{{ $member['name'] }}</h4>
                                            <table class="table">
                                                @if ($group['showAwardType'])
                                                    @foreach($awardType as $sh)
                                                        <tr>
                                                            <td><a href="#myPopup" v-if="{{ $member['awardType'][$sh] ? 'true' : 'false' }}" v-on:click.prevent="displayRankingForAll('{{ $member['role'] }}', '{{$sh}}')">{{ strtoupper($sh) }}</a></td>
                                                        </tr>

                                                        @foreach($rankingForAll as $action)
                                                            <tr v-if="{{ $member['className'] . '_' . $sh }}">
                                                                <td> - <a href="#myPopup" v-on:click.prevent="handleClick('{{ $member['role'] }}','{{ $action }}','{{ $sh }}')">{{ $action }}</a></td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @elseif ($group['forAll'])
                                                    @foreach($rankingForAll as $action)
                                                        <tr>
                                                            <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach($rankingForNationalOnly as $action)
                                                        <tr>
                                                            <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="d-flex w-100 ranking">
                <div class="col-12 accordion" id="accordionExample">
                    @foreach($userGroups3 as $index => $group)
                        <div class="accordion-item mb-3 mx-3">
                            <div class="accordion-header {{ $group['className'] }}" id="{{ 'heading-' . $group['name'] }}">
                                <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{'#collapse' . $group['name']}}" aria-expanded="true" aria-controls="{{'collapse' . $group['name']}}">
                                    <div class="squarebutton w-100"></div>
                                </a>
                            </div>
                            <div id="{{'collapse' . $group['name']}}" class="accordion-collapse collapse" aria-labelledby="{{ 'heading-' . $group['name'] }}">
                                <div class="accordion-body d-flex">
                                    @foreach($group['members'] as $member)
                                        <div class="col-{{ 12 / count($group['members']) }}">
                                            <h4>{{ $member['name'] }}</h4>
                                            <table class="table">
                                                @if ($group['showAwardType'])
                                                    @foreach($awardType as $sh)
                                                        <tr>
                                                            <td><a href="#myPopup" v-if="{{ $member['awardType'][$sh] ? 'true' : 'false' }}" v-on:click.prevent="displayRankingForAll('{{ $member['role'] }}', '{{$sh}}')">{{ strtoupper($sh) }}</a></td>
                                                        </tr>

                                                        @foreach($rankingForAll as $action)
                                                            <tr v-if="{{ $member['className'] . '_' . $sh }}">
                                                                <td> - <a href="#myPopup" v-on:click.prevent="handleClick('{{ $member['role'] }}','{{ $action }}','{{ $sh }}')">{{ $action }}</a></td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @elseif ($group['forAll'])
                                                    @foreach($rankingForAll as $action)
                                                        <tr>
                                                            <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach($rankingForNationalOnly as $action)
                                                        <tr>
                                                            <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
            <div class="ranking-dialog">
                <el-dialog title="" :visible.sync="dialogTableVisible" width="70%">
                    <div class="rankings-modal-title-wrap">
                        <h3 class="modal-title">${ tableTitle } ${ modalTitle } </h3>
                        <a class="print-icon" href="#" v-on:click="printThis()"><i class="fa fa-print" aria-hidden="true" title="Print"></i></a>
                    </div>
                    <div class="rankings-table-title-wrap">
                        <h3 class="text-center text-capitalize">${ modalTitle }</h3>
                    </div>
                    <div class="mb-3" v-for="(block, idx) in blocks" :key="idx">
                        <h2 style="padding-left: 6%">${ block.title }</h2>
                        <el-table :data="block . rows" stripe :row-class-name="tableRowClassName">
                            <el-table-column align="center" property="r" label="Rank" width="60"></el-table-column>
                            <el-table-column class-name="bold-text sales-name" property="n" label="Name" width="300"></el-table-column>
                            <el-table-column property="d" label="Dealer" width="400"></el-table-column>
                            <el-table-column align="center" property="c" label="Category" width="90"></el-table-column>
                            <el-table-column align="center" property="s" label="State" width="100"></el-table-column>
                            <el-table-column align="center" v-if="type == 'status'" property="p" label="Points"></el-table-column>
                            <el-table-column align="center" v-if="type == 'platinum'" property="p" label="Points Platinum"></el-table-column>
                            <el-table-column align="center" class-name="reg" property="re" label="Registered" width="100" ></el-table-column>
                        </el-table>
                    </div>
                </el-dialog>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .button-sales{
        background-image: url('{{ theme_image('rankings/Sales.png') }}');
    }
    .button-fleet{
        background-image: url('{{ theme_image('rankings/Fleet.png') }}');
    }
    .button-service{
        background-image: url('{{ theme_image('rankings/Service.png') }}');
    }
    .button-parts{
        background-image: url('{{ theme_image('rankings/Parts.png') }}');
    }
    .button-admin{
        background-image: url('{{ theme_image('rankings/Admin.png') }}');
    }
</style>
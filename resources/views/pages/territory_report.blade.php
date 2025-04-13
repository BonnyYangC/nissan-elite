@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div id="dsm-app">
    <div class="d-flex justify-content-center">
        <div class="d-flex elite-page territory_report col-11">
            <div class="col-3 px-3">
                <h2 class="my-5" >
                    <span class='page-header-title'>Territory Report {{ config('app.theme') }}</span>
                </h2>
            </div>
            <div class="col-9 px-1">
                <p class="my-5 pr-1" style="float: right;">
                    <a href="https://nmacorp.okta.com/app/UserHome" class="btn btn-default" target="_blank" style="background-color: #cccccc;">
                        <i class="fa fa-arrow-circle-o-right"></i>&nbsp;Nissan Academy</a>&nbsp;
                    <a href="{{ route('region.jump_to_dealer') }}" class="btn btn-danger">
                        <i class="fa fa-arrow-circle-o-right"></i>&nbsp;Nissan Dealer Excellence</a>&nbsp;
                    <a href="#" v-on:click="handlerTerritoryReport($event,{{ $currentUser->id }})" class="btn btn-outline-dark">
                        <i class="fa fa-download"></i>Download Territory Report</a>
                    <a href="#" v-on:click="handlerActiveMemberList($event,{{ $currentUser->id }})" class="btn btn-outline-dark">
                        <i class="fa fa-download"></i>Download Active Member List</a>
                </p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="d-flex elite-page territory_report col-11">
            <div class="col-3 px-3">
                <p>
                    <el-select v-model="regionName" placeholder="Select Region .." class="w-100">
                        @foreach($regions as $region)
                        <el-option
                            key="{{ $region->id }}"
                            label="{{ $region->title}} Region"
                            value="{{ $region->code }}">
                        </el-option>
                        @endforeach
                    </el-select>
                </p>
            </div>
            <div class="col-6">
                <p>
                    <el-input
                        placeholder="Find a Dealer ..."
                        v-model="keyword"
                        clearable>
                    </el-input>
                </p>
            </div>
            <div class="col-3 px-3">
                <p>
                    <el-select v-model="dept" placeholder="Department" v-on:change="showOnly" class="w-100">
                        <el-option
                            v-for="(item, idx) in departments"
                            :key="idx"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-11 elite-page pt-5">
            <div class=" loading-text py-3" v-show="isLoadingRemoteData">
                <i class="fa fa-cog fa-spin fa-3x fa-fw margin-bottom txt-red txt-bold"></i>&nbsp;<span class="txt-red txt-bold">Loading Data ... Please wait for a moment!</span>
            </div>

            <el-table
                v-show="tableData.length>0"
                :data="tableData"
                border
                height="800"
                header-row-class-name="dsm-table-header"
                empty-text="Loading data ..."
                :row-class-name="showMe">
                <el-table-column prop="d" fixed sortable label="Dealer" width="180">
                    <template slot-scope="scope">
                        ${ scope.row.d }
                    </template>
                </el-table-column>
                <el-table-column
                    prop="f" fixed sortable
                    label="Name" width="180">
                    <template slot-scope="scope">
                        <a class="txt-black txt-bold" v-on:click="window.open(getMockUserUrl(scope.row.id))" target="_blank">${ scope.row.f }</a>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="c" fixed sortable
                    label="Registered" width="140">
                    <template slot-scope="scope">
                        <p class="text-center txt-bold" :class="{'txt-gr':scope.row.c=='YES','txt-red':scope.row.c=='NO'}">
                            ${ scope.row.c }
                        </p>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="s" fixed
                label="Dept" sortable width="96">
                    <template slot-scope="scope">
                        ${ scope.row.s === 'Administration' ? 'Admin' : scope.row.s }
                    </template>
                </el-table-column>
                <el-table-column
                    prop="p" fixed
                label="Position" sortable width="200">
                    <template slot-scope="scope">
                        ${ scope.row.p }
                    </template>
                </el-table-column>
                <el-table-column
                    prop="y" fixed
                label="YTD" sortable width="100">
                </el-table-column>
                <el-table-column
                    prop="as"
                    label="AWARD STATUS" sortable width="200">
                </el-table-column>
                <el-table-column
                    prop="c04"
                    label="Apr" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c05"
                    label="May" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c06"
                    label="Jun" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c07"
                    label="Jul" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c08"
                    label="Aug" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c09"
                    label="Sep" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c10"
                    label="Oct" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c11"
                    label="Nov" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c12"
                    label="Dec" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c01"
                    label="Jan" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c02"
                    label="Feb" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="c03"
                    label="Mar" sortable width="86">
                </el-table-column>
                <el-table-column
                    prop="pys"
                    label="Point YTD Historical" sortable width="220">
                </el-table-column>
            </el-table>
        </div>
    </div>
</div>
@endsection

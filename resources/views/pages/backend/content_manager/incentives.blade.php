@extends('layouts.backend')
@section('content')

<div class="d-flex justify-content-center">
    <div class="content col-10 mt-5" style="border-bottom: 2px solid #f5f5f5;">
        <div class="columns">
            <div class="column">
                <h1>Incentives Management</h1>
            </div>
            <div class="column">
                <a href="{{ route('admin.incentive.info') }}" class="button is-success is-pulled-right">
                    <i class="fa fa-plus"></i>&nbsp;New Incentive
                </a>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-3 m-5">
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-10">
        <table class="table">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Title</th>
                    <th>Period</th>
                    <th>Feature Image</th>
                    <th>Attachment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6"><h2 class="has-text-link">Current</h2></td>
                </tr>
                @foreach( $incentives['current'] as $incentive)
                <tr>
                    <th>{{ $incentive->region }}</td>
                    <td>{{ $incentive->title }}</td>
                    <td>{{ $incentive->start }} {{ $incentive->finish }}</td>
                    <td>
                        <img width="120" class="thumbnail" src="{{ asset('/images/incentives/images/'.$incentive->image) }}" alt="">
                    </td>
                    <td>
                        <a href="{{ asset('/images/incentives/images/pdf/'.$incentive->pdf) }}" target="_blank">View PDF</a>
                    </td>
                    <td>
                        <a class="button is-small is-link" href="{{ route('admin.incentive.info', ['incentive' => $incentive->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.incentive.delete', ['incentive' => $incentive->id]) }}" title="Delete this incentive" class="button is-small is-danger btn-need-confirm">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="6"><h2 class="has-text-success">Just Finished</h2></td>
                </tr>
                @foreach( $incentives['just_finished'] as $incentive)
                <tr>
                    <th>{{ $incentive->region }}</td>
                    <td>{{ $incentive->title }}</td>
                    <td>{{ $incentive->start }} {{ $incentive->finish }}</td>
                    <td>
                        <img width="120" class="thumbnail" src="{{ asset('/images/incentives/images/'.$incentive->image) }}" alt="">
                    </td>
                    <td>
                        <a href="{{ asset('/images/incentives/images/pdf/'.$incentive->pdf) }}" target="_blank">View PDF</a>
                    </td>
                    <td>
                        <a class="button is-small is-link" href="{{ route('admin.incentive.info', ['incentive' => $incentive->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.incentive.delete', ['incentive' => $incentive->id]) }}" title="Delete this incentive" class="button is-small is-danger btn-need-confirm">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="6"><h2 class="has-text-danger">Past</h2></td>
                </tr>
                @foreach( $incentives['past'] as $incentive)
                <tr>
                    <th>{{ $incentive->region }}</td>
                    <td>{{ $incentive->title }}</td>
                    <td>{{ $incentive->start }} {{ $incentive->finish }}</td>
                    <td>
                        <img width="120" class="thumbnail" src="{{ asset('/images/incentives/images/'.$incentive->image) }}" alt="">
                    </td>
                    <td>
                        <a href="{{ asset('/images/incentives/images/pdf/'.$incentive->pdf) }}" target="_blank">View PDF</a>
                    </td>
                    <td>
                        <a class="button is-small is-link" href="{{ route('admin.incentive.info', ['incentive' => $incentive->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.incentive.delete', ['incentive' => $incentive->id]) }}" title="Delete this incentive" class="button is-small is-danger btn-need-confirm">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

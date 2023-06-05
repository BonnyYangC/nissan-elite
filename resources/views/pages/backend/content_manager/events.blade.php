@extends('layouts.backend')
@section('content')

<div class="d-flex justify-content-center">
    <div class="content col-10 mt-5" style="border-bottom: 2px solid #f5f5f5;">
        <div class="columns">
            <div class="column">
                <h1>Calendar Management</h1>
            </div>
            <div class="column">
                <a href="{{ route('admin.event.info') }}" class="button is-success is-pulled-right">
                    <i class="fa fa-plus"></i>&nbsp;New Event
                </a>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-3 m-5">
        {{ $events->links() }}
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-10">
        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Period</th>
                <th>Region</th>
                <th>Incentive/Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $events as $event)
            <tr>
                <th>{{ $event->title }}</td>
                <td>{{ $event->start }} {{ $event->end }}</td>
                <td>{{ $event->region }}</td>
                <td>{{ $event->incentive_name }}</td>
                <td>
                    <a class="button is-small is-link" href="{{ route('admin.event.info', ['event' => $event->id]) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.event.delete', ['event' => $event->id]) }}" title="Delete this user" class="button is-small is-danger btn-need-confirm">
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

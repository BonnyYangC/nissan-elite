@extends('layouts.backend')
@section('content')

    <div class="d-flex justify-content-center">
        <div class="col-5 m-5">
            {{ $region_staff->links() }}
        </div>
    </div>
<div class="d-flex justify-content-center">
    <div class="col-10">
        <table class="table">
            <thead>
            <tr>
                <th>Region</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Password</th>
                <th>Position</th>
                <th>Active</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $region_staff as $user)
            <tr>
                <th>{{ $user->region->title }}</td>
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->position_code }}</td>
                <td>
                    @if($user->active === 1)
                    <span class="has-text-success">Y</span>
                    @else
                    <span class="has-text-danger">N</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.region_staff.mock', ['user' => $user->id]) }}" target="_blank" title="Mock as this user"
                       class="button is-small is-link">M</a>
                    <a href="{{ route('admin.region_staff.info', ['user' => $user->id]) }}" title="Edit" class="button is-small is-link">E</a>
                    <a href="{{ route('admin.region_staff.delete', ['user' => $user->id]) }}" title="Delete this user" class="button is-small is-danger btn-need-confirm">D</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

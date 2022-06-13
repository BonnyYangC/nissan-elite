@extends('layouts.backend')
@section('content')

<div class="d-flex justify-content-center">
    <div class="content col-10 mt-5" style="border-bottom: 2px solid #f5f5f5;">
        <div class="columns">
            <div class="column">
                <h1>Nissan Admin Users Management</h1>
            </div>
            <div class="column">
                <a href="{{ route('admin.admin_user.info') }}" class="button is-success is-pulled-right">
                    <i class="fa fa-plus"></i>&nbsp;New Admin
                </a>
                <a href="{{ route('admin.data_export', ['type' => 'admin']) }}" class="button is-pulled-right" style="margin-right: 10px;"><i class="fa fa-download"></i>&nbsp;Export All</a>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-5 m-5">
        {{ $admin_users->links() }}
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
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $admin_users as $user)
            <tr>
                <td>All Regions</td>
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>
                    <a class="button is-small is-link" href="{{ route('admin.admin_user.info', ['user' => $user->id]) }}">Edit</a>
                    <a href="{{ route('admin.admin_user.delete', ['user' => $user->id]) }}" title="Delete this user" class="button is-small is-danger btn-need-confirm">Delete</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

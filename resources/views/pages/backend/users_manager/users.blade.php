@extends('layouts.backend')
@section('content')

    <div class="d-flex justify-content-center">
        <div class="col-5 m-5">
            {{ $users->links() }}
        </div>
    </div>
<div class="d-flex justify-content-center">
    <div class="col-10">
        <table class="table">
            <thead>
            <tr>
                <th>Dealer</th>
                <th>State</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Active</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->state }}</td>
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->position_code }}</td>
                <td>
                    @if($user->active === 1)
                    <span class="has-text-success">Y</span>
                    @else
                    <span class="has-text-danger">N</span>
                    @endif
                </td>
                <td>
                    <a class="button is-small is-link" href="{{ route('admin.user.info', ['user' => $user->id]) }}">Edit</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

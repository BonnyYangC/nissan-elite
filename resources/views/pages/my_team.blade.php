@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
    <div class="d-flex justify-content-center">
        <div class="elite-page team-member col-11">
            <div class="col-12 page-section-wrap">
                <h1 class="page-header" >
                    <span class='page-header-title'>Welcome {{ $currentUser->firstname }} - {{ $currentUser->position->title }} </span>
                </h1>
            </div>
            <div class="d-flex flex-column mx-5">
                <div>
                    <h3>
                        My Team Member{{ count($teamMembers)>1 ? 's':null }}
                    </h3>
                </div>
                <div class="mt-3">
                    <table class="table team-member-table">
                        <thead class="team-member-table-header">
                            <tr class="table-top-row">
                                <td></td>
                                <td>Name&nbsp;
                                    <a href="{{ route('my_team', ['sortby'=>'firstname', 'order'=>'ASC'])}}">&uarr;</a>
                                    <a href="{{ route('my_team', ['sortby'=>'firstname', 'order'=>'DESC'])}}">&darr;</a>
                                </td>
                                <td>Position&nbsp;
                                    <a href="{{ route('my_team', ['sortby'=>'title', 'order'=>'ASC'])}}">&uarr;</a>
                                    <a href="{{ route('my_team', ['sortby'=>'title', 'order'=>'DESC'])}}">&darr;</a>
                                </td>
                                <td>Credits&nbsp;
                                    <a href="{{ route('my_team', ['sortby'=>'cr_ytd', 'order'=>'ASC'])}}">&uarr;</a>
                                    <a href="{{ route('my_team', ['sortby'=>'cr_ytd', 'order'=>'DESC'])}}">&darr;</a>
                                </td>
                                <td>Dashboard</td>
                                <td>Metrics</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($teamMembers as $idx => $user)
                        <tr>
                            <td>{{ $idx+1 }}</td>
                            <td>
                                {{ $user->firstname }} {{ $user->lastname }}
                            </td>
                            <td>
                                {{ $user->title }}
                            </td>
                            <td>
                                {{ number_format($user->cr_ytd,0) }}
                            </td>
                            <td>
                                <a href="{{ route('admin.users.mock', ['user' => $user->id, 'directTo' => 'dashboard']) }}" target="_blank">View Details</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.mock', ['user' => $user->id, 'directTo' => 'metrics']) }}" target="_blank">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="page-section-wrap dashboard-section"></div>
        </div>
    </div>
@endsection

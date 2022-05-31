@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page account col-11">
        <div class="col-9 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>My ACCOUNT</span>
            </h1>
        </div>
        <div class="d-flex">
            <div class="col-9 page-section-wrap">
                <h3>Personal Details</h3>
                <div class="table-responsive">
                    <table class="table table-striped mt-2">
                        <thead class="nissan-table-header">
                            <tr class="table-top-row">
                                <td><strong>Details</strong></td>
                                <td><strong>{{ config('elite.PROGRAM_SHORT_NAME') }} Member</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="active">
                                <td><strong>Registration Number</strong></td>
                                <td>{{ $currentUser->employee_code }}</td>
                            </tr>
                            <tr>
                                <td><strong>Title</strong></td>
                                <td>{{ $currentUser->salutation }}</td>
                            </tr>
                            <tr class="active">
                                <td><strong>First</strong></td>
                                <td>{{ $currentUser->firstname }}</td>
                            </tr>
                            <tr>
                                <td><strong>Surname</strong></td>
                                <td> {{ $currentUser->lastname }}</td>
                            </tr>
                            <tr class="active">
                                <td><strong>Date of Birth</strong></td>
                                <td>{{ $currentUser->date_birth }}</td>
                            </tr>
                            <tr class="">
                                <td><strong>Date Created</strong></td>
                                <td>{{ $currentUser->date_created }}</td>
                            </tr>
                            <tr class="active">
                                <td><strong>Mobile</strong></td>
                                <td>{{ $currentUser->mobile }}</td>
                            </tr>
                            <tr class="">
                                <td><strong>Email Address</strong></td>
                                <td>{{ $currentUser->email }}</td>
                            </tr>
                            <tr class="active">
                                <td><strong>Dealership</strong></td>
                                <td>{{ $currentUser->dealer->name }}</td>
                            </tr>
                            <tr class="">
                                <td><strong>Dealer Code</strong></td>
                                <td>{{ $currentUser->dealer->code }}</td>
                            </tr>
                            <tr class="active">
                                <td><strong>Department</strong></td>
                                <td>{{ $currentUser->position->department }}</td>
                            </tr>
                            <tr class="">
                                <td><strong>Position</strong></td>
                                <td>{{ $currentUser->position->title }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        The details above are currently held on the Nissan Dealer User Management Portal.
                        Please check they are correct. If not, please update, ask your Dealership to update,
                        or email <a href="mailto:{{ config('elite.SUPPORT_EMAIL_ADDRESS') }}">{{ config('elite.SUPPORT_EMAIL_ADDRESS') }}</a> immediately.
                        Incorrect details may mean your {{ config('elite.PROGRAM_SHORT_NAME') }} {{ config('elite.PROGRAM_AWARD_UNIT') }} are incorrect.<br>
                    </p>
                </div>
            </div>
        </div>
        <div class="page-section-wrap dashboard-section"></div>
    </div>
</div>
@endsection

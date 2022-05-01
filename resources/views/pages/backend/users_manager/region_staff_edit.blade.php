@extends('layouts.backend')
@section('content')
<div class="d-flex justify-content-center">

    <div class="container mt-5">
        <div class="content mt-20">
            <div class="columns">
                <div class="column">
                    <h1>Region Staff</h1>
                </div>
                <div class="column">
                    <a href="{{ route('admin.region_staff') }}" class="button is-pulled-right is-primary">Go Back</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card  mt-20">
                <div class="card-content">
                    <div class="content">
                        <form action="{{ route('admin.region_staff.edit') }}" method="post" class="form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <h2 class="m-4"> {{ $user->firstname }} {{ $user->lastname }}</h2>
                            <hr>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">First Name</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="firstname" placeholder="First Name" value="{{ $user->firstname }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Surname</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="lastname" placeholder="Surname" value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Email</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="email" name="email" placeholder="Email" value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Password</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="password" placeholder="Password" value="{{ $user->password }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Mobile</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="mobile" placeholder="Optional: mobile" value="{{ $user->mobile }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Position</label>
                                </div>
                                <div class="field-body">
                                    <div class="field is-narrow">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="position">
                                                    @foreach($positions as $position)
                                                    <option value="{{ $position->code }}" {{ $position->code==$user->position_code ? 'selected':null }}>{{ $position->code . ' -- ' . $position->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Region</label>
                                </div>
                                <div class="field-body">
                                    <div class="field is-narrow">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="region">
                                                    @foreach($regions as $region)
                                                    <option value="{{ $region->code }}" {{ ($user->region === $region->code) ? 'selected':null }}>{{ $region->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label">
                                    <label class="label">Active?</label>
                                </div>
                                <div class="field-body">
                                    <div class="field is-narrow">
                                        <div class="control">
                                            <label class="radio">
                                                <input value="1" type="radio" name="active" {{ $user->active==1 ? 'checked':null }}>
                                                Yes
                                            </label>
                                            <label class="radio">
                                                <input value="0" type="radio" name="active" {{ $user->active!=1 ? 'checked':null }}>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="field is-horizontal">
                                <div class="field-label">
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <button class="button is-primary" type="submit">
                                                <i id="submit-btn-waiting" class="fas fa-database"></i>&nbsp;&nbsp;&nbsp;
                                                <span id="submit-btn-txt">Submit</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

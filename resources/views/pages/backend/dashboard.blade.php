<!-- admin home page-->
@extends('layouts.backend')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-10 admin-dashboard">
        @if($message = session()->get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-content">
                <div class="content">
                <h2>CSV file uploader</h2>
                <form method="post" action="{{ route('admin.data_process') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Action</label>
                        </div>
                        <div class="field-body">
                            <div class="field is-narrow">
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="action_type">
                                            <option value="{{ App\Helper\Defination::ACTION_TYPE_VALIDATE }}">Data Validate</option>
                                            <option value="{{ App\Helper\Defination::ACTION_TYPE_SYNC }}">Database Sync</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">For</label>
                        </div>
                        <div class="field-body">
                            <div class="field is-narrow">
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="for" required>
                                            <option value="">Please choose position ...</option>
                                            <optgroup label="By Role">
                                                @foreach($positions as $p)
                                                    <option value="{{ $p->code }}">{{ $p->title }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Summary">
                                                @foreach($summary as $tableName => $label)
                                                    <option value="{{ $tableName }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Users">
                                                @foreach($users_menu as $tableName => $label)
                                                    <option value="{{ $tableName }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">CSV File</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <div class="file has-name">
                                        <label class="file-label">
                                            <input id="csv-file-input" class="file-input" type="file" name="file" required>
                                            <span class="file-cta">
                                                          <span class="file-icon">
                                                            <i class="fas fa-upload"></i>
                                                          </span>
                                                          <span class="file-label">
                                                            Choose a file…
                                                          </span>
                                                    </span>
                                            <span class="file-name" id="csv-file-input-text" style="min-width: 450px;">
                                                        Max file size: 2M
                                                    </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label">
                            <!-- Left empty for spacing -->
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <button class="button is-primary" type="submit" id="submit-import-btn">
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

        <div class="card mt-5">
            <div class="card-content">
                <div class="content">
                    <h2 class="m-4">System Configuration</h2>
                    <hr>

                    <form action="{{ route('admin.system_config') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Program Name</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" name="program_name" placeholder="The name of this website" value="{{ config('elite.PROGRAM_NAME','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">The program's name</p>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Year</label>
                            </div>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input class="input" type="text" name="year" placeholder="Which year you want to display" value="{{ config('elite.YEAR') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">Which year's data the user will see</p>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Program Award Unit</label>
                            </div>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input class="input" type="text" name="program_award_unit" placeholder="Credits or Points" value="{{ config('elite.PROGRAM_AWARD_UNIT','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">What unit the program is using</p>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Challenge Winner</label>
                            </div>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input class="input" type="text" name="product_challenge_winner" placeholder="Product Challenge Winner" value="{{ config('elite.PRODUCT_CHALLENGE_WINNER','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">Product Challenge Winner this year</p>
                            </div>
                        </div>
                        <hr>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Pagination Size</label>
                            </div>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input class="input" type="text" name="page_size" placeholder="Rows/Page" value="{{ config('elite.PAGE_SIZE','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">How many rows per page</p>
                            </div>
                        </div>
                        <hr>
                        <h5>Email Settings</h5>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Support Email</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" name="support_email" placeholder="Support email" value="{{ config('elite.SUPPORT_EMAIL_ADDRESS','') }}">
                                    </div>
                                    <p class="help has-text-grey is-size-6">As the sender's email when user tries to recover the password</p>
                                </div>
                            </div>
                        </div>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Support name</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" name="support_email_name" placeholder="Support's name when sending email" value="{{ config('elite.SUPPORT_EMAIL_NAME','') }}">
                                    </div>
                                    <p class="help has-text-grey is-size-6">As the sender's name when user tries to recover the password</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>System Login</h5>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Admin Username</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" name="admin_user" placeholder="Admin username" value="{{ config('elite.ADMIN_USER','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">As the administrator's login name</p>
                            </div>
                        </div>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Admin Password</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" name="admin_password" placeholder="Admin password" value="{{ config('elite.ADMIN_PASSWORD','') }}">
                                    </div>
                                </div>
                                <p class="help has-text-grey is-size-6">As the administrator's login password</p>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <input type="hidden" name="program_short_name" value="{{ config('elite.PROGRAM_SHORT_NAME','') }}">
                                <input type="hidden" name="program_short_name_with_year" value="{{ config('elite.PROGRAM_SHORT_NAME_WITH_YEAR','') }}">
                                <input type="hidden" name="program_i_elite" value="{{ config('elite.PROGRAM_I_ELITE','') }}">
                                <input type="hidden" name="program_dealership" value="{{ config('elite.PROGRAM_DEALERSHIP','') }}">
                            </div>
                        </div>
                        <hr>

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <!-- Left empty for spacing -->
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
@endsection

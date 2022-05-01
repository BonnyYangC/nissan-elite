@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')
    <div align="center" class="container in_bg_img">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-4 col-md-2 col-xs-3 col-md-offset-4">
                <a href="{{ url('/') }}">
                    <img class="img-responsive center-block nissan-logo" style="margin-left: 60%;" src="{{ asset('images/nissan/Nissan_logo.png') }}">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <img class="img-responsive center-block nissan-logo" alt="" src="{{ asset('images/nissan/Nissan_ELITE_i_ELITE-Black.png?a=1') }}">
            </div>
        </div>
        <div class="row" style="margin-top:1%;margin-bottom:5%;padding-bottom:3%;">
            <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                <form id="login-form" method="post" action="{{ url('user/login') }}" class="form-signin" role="form">
                    <input name="action" type="hidden" value="login">
                    <input autofocus class="form-control" id="email" name="email" placeholder="Email" type="email"/>
                    <input class="form-control" id="password" name="password" placeholder="Password" type="password"/>
                    <button class="btn btn-block bt-login">Submit</button>
                </form>
                <div class="form-footer" style="padding-left:0; padding-right:0">
                    <div class="row text-nowrap">
                        <div class="col-xs-12">
                            <a class="txt-grey9 text-xs-center" href="#forgotpassword">
                                Forgot password?
                            </a>
                        </div>
                        <div class="col-xs-12">
                            <a class="txt-grey9 text-xs-center" href="#eligible">New to Nissan?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <section id="eligible">
                <div class="container">
                    <div style="margin:0 auto; height: 600px; padding-top:200px; text-align: center; font-size:16px; margin-bottom:200px;z-index: 9999;">
                        <span style="font-size:50px; color:#FFFFFF;">New to Nissan?
                        </span>
                        <br><br>
                        <div class="bs-example">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-parent="#accordion" data-toggle="collapse" href="#collapseOne">1. Can I join
                                                {{ config('elite.PROGRAM_NAME') }}?</a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseOne">
                                        <div class="panel-body">
                                            <p>If you are currently employed by Nissan Australia and enrolled on the Dealer User Portal in one of the following job functions at a Nissan Dealership in Australia, you are automatically invited to register and participate in the program:<br>
                                                • Sales Manager<br>
                                                • Retail Sales Consultant<br>
                                                • Fleet Sales Executive<br>
                                                • F&amp;I Manager<br>
                                                • Service Manager<br>
                                                • Service Advisor<br>
                                                • Stock Controller<br>
                                                • Parts Manager<br>
                                                • Parts Sales Representative<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">2. How do I register for
                                                {{ config('elite.PROGRAM_NAME') }}?</a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseTwo">
                                        <div class="panel-body">
                                            <p>Go to
                                                <a href="{{ env('eventRegisterUrl') }}" target="_blank">{{ env('eventRegisterUrl') }}</a>
                                                and successfully complete the
                                                {{ config('elite.YEAR') }}
                                                {{ config('elite.PROGRAM_NAME') }}
                                                registration form including a requirement to accept the program terms and conditions as directed. On completion, you will receive a confirmation e-Mail for your {{ config('elite.PROGRAM_NAME') }} registration.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-parent="#accordion" data-toggle="collapse" href="#collapseThree">3. Further queries?</a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseThree">
                                        <div class="panel-body">
                                            <p>The
                                                {{ config('elite.PROGRAM_NAME') }}
                                                Service Centre can be contacted on:<br><br>
                                                Telephone:  	03 9544 9054<br>
                                                Email:
                                                {{ config('elite.SUPPORT_EMAIL_ADDRESS') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p style="color:#FFFFFF;">
                                <strong>Note:</strong>
                                Click on any of the above tabs to see more information. Go back to
                                <a href="#">login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container">
                    <div class="row" id="forgotpassword">
                        <div class="col-md-6 col-md-offset-3 col-xs-12">
                            <div class="fgp-wrap pt-200">
                                <p class="txt-white">Forgot Password?</p>
                                <p class="txt-white">Please enter your registered email address.</p>
                                <input class="form-control" id="Email" name="Email" placeholder="Email Address" type="email" v-model="email">
                                <el-button :loading="inProgress" class="btn btn-block bt-login fgp-submit-btn" v-on:click="onSubmit($event)">Submit</el-button>
                                <p class="txt-white fs-14 mt-10">
                                    Go back to
                                    <a href="#"><strong class="login-white">login</strong></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

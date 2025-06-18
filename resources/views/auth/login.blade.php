@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')

        <script>
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
            {
                alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
                document.location = "/update_browser"
            }
        </script>
        <div class="vh-100 d-flex flex-column">
            <!-- Row 1: 20% height -->
            @include('pages.widgets.logo')

            <!-- Row 2: 60% height -->
            <div class="flex-grow-0" style="height: 30%;">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <img class="nissan-elite-brand img-fluid" src="{{ theme_image('nissan/Nissan_ELITE_i_ELITE.png') }}" alt="Nissan Elite Individual Image">
                </div>
            </div>

            <!-- Row 3: 20% height -->
            <div class="flex-grow-0" style="height: 20%;">
                <div class="h-100 container">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-10 mt-3">
                            <form id="login-form" method="POST" action="{{ route('login') }}" class="form-signin" role="form">
                                @csrf
                                <input type="hidden" name="action" value="login">

                                <!-- Email -->
                                <input autofocus class="form-control mb-2" id="email" name="email" placeholder="Email"
                                    type="email" />
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif

                                <!-- Password -->
                                <input class="form-control mb-2" id="password" name="password" placeholder="Password"
                                    type="password" />
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif

                                <!-- Other validation errors -->
                                @if($errors->any())
                                    {!! implode('', $errors->all('<span class="text-danger">:message</span>')) !!}
                                @endif

                                <button class="btn w-100 mt-2 bt-login">Submit</button>
                            </form>

                            <!-- Footer Links -->
                            <div class="form-footer mt-2 px-0 text-center">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <a class="text-white d-inline-block" href="#forgot-password">
                                            Forgot password?
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <a class="text-white d-inline-block" href="#eligible">
                                            How to Join Nissan {{ config('elite.PROGRAM_I_ELITE') }}?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="justify-content-center" align="center">
            <div class="row justify-content-center">
                <section id="eligible" class="eligible-section">
                    <div>
                            <span style="font-size:50px; color:#FFFFFF;">New to Nissan?</span>
                        <br><br>
                    </div>

                    <div class="col-10 accordion login-faq" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Can I join {{config('elite.PROGRAM_NAME')}}?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>If you are currently employed by Nissan Australia and enrolled on the Dealer User Portal in one of the following job functions at a Nissan Dealership in Australia, you are automatically invited to register and participate in the program:<br>
                                        • Sales Manager<br>
                                        • Retail Sales Consultant<br>
                                        • Fleet Sales Executive<br>
                                        • F&amp;I Manager<br>
                                        • Service Manager<br>
                                        • Service Advisor<br>
                                        • Master/Advanced Technician<br>
                                        • Stock Controller<br>
                                        • Parts Manager<br>
                                        • Parts Sales Representative<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. How do I register for {{config('elite.PROGRAM_NAME')}}?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Go to
                                        <a href="{{ theme_config('eventRegisterUrl') }}" target="_blank">
                                            {{ theme_config('eventRegisterUrl') }}</a>
                                        and successfully complete the
                                        {{config('app.theme')}}
                                        {{config('elite.PROGRAM_NAME')}}
                                        registration form including a requirement to accept the program terms and conditions as directed. On completion, you will receive a confirmation e-Mail for your {{config('elite.PROGRAM_NAME')}} registration.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. CONTACT Nissan ELITE Service Centre
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>The
                                        {{config('elite.PROGRAM_NAME')}}
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
                </section>
                <section id="forgot-password">
                    <div class="col-10 fgp-wrap">
                        <div id="forgotpassword"></div>
                    </div>
                </section>
            </div>
        </div>
@endsection

<style>
    #register {
        background-image: url('{{ theme_image('login/juke-background.jpg') }}');
    }

    #eligible {
        background-image: url('{{ theme_image('login/gtr-background.jpg') }}');
    }

    .fgp-wrap {
        background-image: url('{{ theme_image('login/red-back.jpg') }}');
    }
</style>

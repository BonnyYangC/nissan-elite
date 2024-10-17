<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('elite.PROGRAM_I_ELITE') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ url('/css/demo.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/style.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/layout.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/header.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/welcome.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/login.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/home.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/dashboard.css?v=100&a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ranking.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/metrics.css?v=100&a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/team_member.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/incentives.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/future_sales.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/program.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/calendar.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/product_challenge.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/awards.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/loyalty.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/guild.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/account.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/faq.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/territory_report.css?a=3') }}" />

<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

<!-- jQuery 1.8 or later, 33 KB -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- Fotorama from CDNJS, 19 KB -->
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ asset('js/dsm_utils.js') }}" defer></script>
<script src="{{ asset('js/dashboard_utils.js') }}" defer></script>
<script src="{{ asset('js/ranking.js') }}" defer></script>
<script src="{{ asset('js/calendar.js') }}" defer></script>
<script src="{{ asset('js/login.js') }}" defer></script>

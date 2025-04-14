<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('elite.PROGRAM_I_ELITE') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

<!-- jQuery 1.8 or later, 33 KB -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- Fotorama from CDNJS, 19 KB -->
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/dsm_utils.js') }}" defer></script>
<script src="{{ asset('js/dashboard_utils.js') }}" defer></script>
<script src="{{ asset('js/ranking.js') }}" defer></script>
<script src="{{ asset('js/calendar.js') }}" defer></script>
<script src="{{ asset('js/login.js') }}" defer></script>

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ url('/css/demo.css?a=3') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/style.css?a=3') }}" />

<link rel="stylesheet" href="{{ mix('css/individual.css') }}" />
{{-- <link rel="stylesheet" href="{{ asset('themes/' . config('app.theme') . '/css/style.css') }}"> --}}

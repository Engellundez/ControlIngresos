<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

	<link rel="icon" href="{{ asset('storage/img_sistem/icon.png')}}">

	{{-- JQuery --}}
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>

	<nav>
		<i class="fa-solid fa-home"></i><a href="">Inicio</a>
		<i class="fa-solid fa-sack-dollar"></i><a href="{{ route('index') }}">Ingresos</a>
		<i class="fa-solid fa-cash-register"></i><a href="">Gastos</a>

		<div class="" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<i class="fa-solid fa-right-from-bracket"></i>{{ __('Cerrar Sesión') }}
			</a>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
		</div>
	</nav>
	<div class="container-fluid">
		@yield('content')
	</div>
</body>
@yield('scrips')
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</html>

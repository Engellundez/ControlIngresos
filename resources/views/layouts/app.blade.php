<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="icon" type="image/jpg" href="{{ asset('img/Money_Flat_Icon.png') }}" />
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
		@include('layouts.navigation')

		<!-- Page Heading -->
		@if (isset($header))
			<header class="bg-white dark:bg-gray-800 shadow sm:hidden">
				<div class="max-w-7xl mx-auto py-2 px-6 lg:px-8">
					<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
						{{ $header }}
					</h2>
				</div>
			</header>
		@endif

		<!-- Page Content -->
		<main>
			{{ $slot }}
		</main>
		<p
			class="
			text-emerald-100 text-emerald-200 text-emerald-300 text-emerald-400 text-emerald-500 text-emerald-600 text-emerald-700 text-emerald-800 text-emerald-900
			text-red-100 text-red-200 text-red-300 text-red-400 text-red-500 text-red-600 text-red-700 text-red-800 text-red-900
			text-sky-300
			text-blue-800 text-blue-400
			text-green-800 text-green-400
			text-yellow-800 text-yellow-300
			text-gray-800 text-gray-300

			border-blue-300 border-blue-800
			border-red-300 border-red-800
			border-green-300 border-green-800
			border-yellow-300 border-yellow-800
			border-gray-300 border-gray-600

			bg-blue-50
			bg-gray-800
			bg-red-50 bg-red-100 bg-red-200 bg-red-300 bg-red-400 bg-red-500 bg-red-600 bg-red-700 bg-red-800 bg-red-900
			bg-green-50
			bg-yellow-100 bg-yellow-200 bg-yellow-300 bg-yellow-400 bg-yellow-500 bg-yellow-600 bg-yellow-700 bg-yellow-800 bg-yellow-900
			bg-gray-50">
		</p>

	</div>
</body>
@stack('scripts')
<script>
	window._TOKEN = '{{ csrf_token() }}';
</script>

</html>

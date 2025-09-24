<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title ?? 'Dashboard' }}</title>
	<link rel="icon" type="image/x-icon" href="{{ asset('images/icons/favicon.ico') }}">

	<!-- Incluir estilos con Vite -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles
</head>
<body class="bg-gray-50 dark:bg-gray-900">

	{{-- Navbar --}}
	@include('partials.navbar-dashboard')

	<div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
		{{-- Sidebar --}}
		@include('partials.sidebar')
		{{-- Main Content --}}
		<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
			{{ $slot }} {{-- Contenido principal --}}
				{{-- Footer --}}
			@include('partials.footer-dashboard')
		</div>
	</div>
  <!-- Incluir scripts de Livewire y Alpine.js -->
	@livewireScripts
	{{-- @livewireVoltScripts --}}
</body>
</html>
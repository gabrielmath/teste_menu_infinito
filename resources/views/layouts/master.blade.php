<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ str_replace('_',' ',config('app.name', 'Laravel')) }}</title>



	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

	<!-- Styles -->
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
	<header id="header">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-color: green;">
			<a class="navbar-brand" href="{{ route('home') }}">Menu Infinito</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown1" aria-controls="navbarNavDropdown1" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown1">

				<ul class="navbar-nav">
					@foreach($menus as $menu)
						<li class="nav-item {{ $menu->isFather() ? 'dropdown' : '' }}">
							<a class="nav-link {{ $menu->isFather() ? 'dropdown-toggle' : '' }}" @if($menu->isFather()) id="navbarDropdownMenuLink{{$menu->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif href="#">{{ $menu->nome }} </a>
							@if($menu->isFather())
								@include('menus.partials.submenus',['submenus' => $menu->menus, 'id' => $menu->id])
							@endif
						</li>
					@endforeach
				</ul>
			</div>
		</nav>
	</header>
	<main id="principal">
		@yield('content')
	</main>
	<footer id="footer">
		<div class="container text-center">
			Olá, {{ Auth::user()->name }}
			(<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>)

			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</div>
	</footer>

	<!-- Scripts -->
	<script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
	<script defer src="{{ asset('assets/js/script.js') }}"></script>
	@yield('script')
</body>
</html>
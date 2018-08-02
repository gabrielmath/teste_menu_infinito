<ul class="dropdown-menu" @if(isset($id))aria-labelledby="navbarDropdownMenuLink{{ $id }}" @endif>
@foreach($submenus as $submenu)
	<li class="{{ $submenu->isFather() ? 'dropdown-submenu' : '' }}">
		<a class="dropdown-item {{ $submenu->isFather() ? 'dropdown-toggle' : '' }}" href="#">{{ $submenu->nome }}</a>
		@if($submenu->isFather())
			@include('menus.partials.submenus',['submenus' => $submenu->menus])
		@endif
	</li>
@endforeach
</ul>

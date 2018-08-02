<ul>
@foreach($filhos as $filho)
	<li>
		{{ $filho->nome }}
		@if($filho->isFather())
			@include('menus.partials.submenusimples',['filhos' => $filho->menus])
		@endif
	</li>
@endforeach
</ul>

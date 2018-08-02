@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="form-group" style="margin-top: 10px;">
			<a href="{{ route('menus.index') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Voltar</a>
		</div>

		<table class="table table-bordered">
			<tbody>
			<tr>
				<th scope="row">ID</th>
				<td>{{ $menu->id }}</td>
			</tr>
			<tr>
				<th scope="row">Nome</th>
				<td><strong>{{ $menu->nome }}</strong></td>
			</tr>
			<tr>
				<th scope="row">Filho/Submenu de:</th>
				<td>{{ $menu->father()->nome ?? 'Raiz' }}</td>
			</tr>
			<tr>
				<th scope="row">Menu Pai de (hierarquia):</th>
				<td>
				@if($menu->isFather())
					<ul>
					@foreach($menu->menus()->get() as $filho)
						<li>
							{{ $filho->nome }}
							@if($filho->isFather())
								@include('menus.partials.submenusimples', ['filhos' => $filho->menus])
							@endif
						</li>
					@endforeach
					</ul>
				@else
					Ninguém
				@endif
				</td>
			</tr>
			</tbody>
		</table>
		<button class="btn btn-outline-danger btn-sm excluir float-right" data-form="#form-delete">
			<i class="fa fa-trash-alt"></i> Excluir Menu
		</button>
		{!! Form::open(["route" => ['menus.destroy', $menu->id], 'method' => 'delete', 'id' => 'form-delete', 'style' => 'display:none;']) !!}
	</div>

@endsection
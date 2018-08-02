@extends('layouts.master')

@section('content')
	@php
		$todosMenus[null] = 'Raiz';
		foreach ($allMenus as $menu):
			$pai = \App\Models\Menu::where('id',$menu->menu_pai)->get(['nome'])->first();
			$todosMenus[$menu->id] = $menu->nome.($menu->isChild() ? " - Submenu de ".$pai->nome : "");
		endforeach
	@endphp

	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="card border-success mb-3">
					<div class="card-header">Inserção de conteúdo</div>
					<div class="card-body text-success">
						<h5 class="card-title">Inserir novo menu/submenu</h5>
						<p class="card-text">Escolha onde deseja cadastrar um novo menu e insira um item.</p>
					</div>
				</div>
			</div>
		</div>
		{!! Form::open(['route' => ['menus.store', (!isset($menu_pai->id) ? '' : $menu_pai->id)]]) !!}
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					{!! Form::label('nome','Nome do Menu:') !!}
					{!! Form::text('nome',(old('nome') ?? null),['id' => 'nome' ,'class' => 'form-control'.($errors->has('nome') ? ' is-invalid' : ''), 'required' => 'required']) !!}
					@if ($errors->has('nome'))
						<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('nome') }}</strong>
				</span>
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					{!! Form::label('menu_pai', 'Selecione onde irá inserir:') !!}
					{!! Form::select('menu_pai', $todosMenus, (!isset($menu_pai->id) ? null : $menu_pai->id),['class' => 'form-control']); !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					{!! Form::submit("Inserir",['class' => 'btn btn-success btn-block']) !!}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

@endsection
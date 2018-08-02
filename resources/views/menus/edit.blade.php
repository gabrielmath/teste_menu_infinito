@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="card border-warning mb-3">
					<div class="card-header">Edição de conteúdo</div>
					<div class="card-body text-warning">
						<h5 class="card-title">Editar menu/submenu</h5>
						<p class="card-text">Faça as alterações que achar necessárias.</p>
					</div>
				</div>
			</div>
		</div>
		{!! Form::model($menu,['route' => ['menus.update', $menu->id ], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					{!! Form::label('nome','Nome do Menu:') !!}
					{!! Form::text('nome', null,['id' => 'nome' ,'class' => 'form-control'.($errors->has('nome') ? ' is-invalid' : ''), 'required' => 'required']) !!}
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
					{!! Form::submit("Atualizar",['class' => 'btn btn-success btn-block']) !!}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

@endsection
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
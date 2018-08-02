@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">@include('menus.partials._check')</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card border-primary mb-3">
					<div class="card-header">Lista de Conteúdo</div>
					<div class="card-body text-primary">
						<h5 class="card-title">Listagem de todos os menus cadastrados</h5>
						<p class="card-text">Cadastre novos menus. Escolha se deseja inseri-los na RAIZ do menu principal ou como submenu.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<a href="{{ route('menus.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Cadastrar novo menu</a>
				</div>
			</div>
			<div class="col-12 col-sm-6">
				{{ $getMenu->links() }}
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nome</th>
							<th scope="col">Menu pai</th>
							<th scope="col">Ações</th>
						</tr>
						</thead>
						<tbody>
						@foreach($getMenu as $menu)
							<tr>
								<th scope="row">{{ $menu->id }}</th>
								<td>{{ $menu->nome }}</td>
								<td><small>{{ $menu->father()->nome ?? 'Raiz' }}</small></td>
								<td class="text-">
									<a href="{{ route('menus.create',$menu->id) }}" class="btn btn-info">
										<i class="fa fa-plus"></i> Criar Submenu
									</a>
									<a href="{{ route('menus.edit',$menu->id) }}" class="btn btn-warning">
										<i class="fa fa-edit"></i> Editar Menu
									</a>
									<a href="{{ route('menus.show',$menu->id) }}" class="btn btn-outline-primary">
										<i class="far fa-eye"></i> Detalhes
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				{{ $getMenu->links() }}
			</div>
		</div>
	</div>

@endsection
@extends('layouts.master')

@section('content')
    {{--@php
		$todosMenus[null] = 'Raiz';
		foreach ($allMenus as $menu):
			/** @var \App\Models\Menu $menu_pai */
			$menu_pai = \App\Models\Menu::where('id',$menu->menu_pai)->get(['nome'])->first();
			$todosMenus[$menu->id] = $menu->nome.($menu->isChild() ? " - Submenu de ".$menu_pai->nome : "");
		endforeach
	@endphp--}}

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Olá. Seja bem-vindo ao teste!</h1>
            <p class="lead">
                Esse teste exige que o desenvolvedor crie um cadastro de menus infinitos.
            </p>
            <hr class="my-4">
            <p>Vamos começar?</p>
            <a class="btn btn-primary btn-lg" href="{{ route('menus.index') }}" role="button">Cadastrar novo menu</a>
        </div>
    </div>

@endsection
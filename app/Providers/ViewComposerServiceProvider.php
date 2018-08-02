<?php

namespace App\Providers;

//use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Iniciando menus (DB) com os templates do CRUD
        view()->composer(['layouts.master','menus.*'], function($view){
            $view->with('menus', \App\Models\Menu::where('menu_pai','=',null)->get());
            $view->with('allMenus', \App\Models\Menu::all());
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

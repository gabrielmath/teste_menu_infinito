<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Primeiro são criados 10 menus da raiz da estrutura
        factory(Menu::class, 10)->create([
            'menu_pai' => null
        ]);

        // Após, são criados mais 50 submenus aleatoriamente (respeitando a quantidade de total cadastrada no banco)
        factory(Menu::class, 50)->create()->each(function (Menu $menu){
            $menu->menu_pai = rand(1, Menu::all()->count());
            $menu->save();
        });

    }
}

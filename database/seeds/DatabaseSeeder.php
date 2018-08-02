<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Alimentando banco de dados em sua criação (Técnica Code First feito com a partir do Eloquent e sua migrations)
        $this->call(UsersTableSeeder::class);
        $this->call(MenuTableSeeder::class);
    }
}

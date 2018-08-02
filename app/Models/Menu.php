<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Menu
 *
 * @mixin \Eloquent
 */
class Menu extends Model
{
    // Permitir atribuição em massa apenas para esses dois campos
    protected $fillable = [
        'nome',
        'menu_pai'
    ];

    // Relacionamento Many-to-Many entre os menus. (Isso facilita a vida de uma maneira sensacional!)
    public function menus()
    {
        return $this->hasMany(Menu::class,'menu_pai','id');
    }

    // Função que verifica se o menu é filho (submenu) de outro
    public function isChild()
    {
        return !is_null($this->menu_pai);
    }

    // Verifica e, caso seja um menu pai, retorna a quantidade de filhos
    public function isFather()
    {
        return parent::where('menu_pai', $this->id)->get()->count();
    }

    // Retorna o nome do elemento Pai do submenu selecionado/listado
    public function father()
    {
        return $this->where('id',$this->menu_pai)->get(['nome'])->first();
    }

    // Retorna o nome de todos os filhos do menu selecionado
    public function childs()
    {
        return $this->where('menu_pai',$this->id)->get(['nome']);
    }

}

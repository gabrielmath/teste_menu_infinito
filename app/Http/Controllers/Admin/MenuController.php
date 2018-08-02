<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{

    /**
     * @var Menu
     */
    private $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // Método de listagem de menus
    {
        // Paginação
        $getMenu = $this->menu::paginate(10);

        // Chamando a view e enviando a ela a variável que contém os dados de paginação
        return view('menus.index', compact('getMenu'));
    }

    /**
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) // Método que exibe o menu selecionado
    {
        // Chamando a view e enviando a ela a variável que contém os dados do menu selecionado
        return view('menus.show', compact('menu'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id = null) // Método que exibe o formulário de cadastro de menu
    {
        // O recebimento deste parâmetro foi de minha opção. Fiz isso para facilitar a inserção de submenus na view
        $menu_pai = $this->menu->find($id);

        // Chamando a view e enviando a ela a variável que contém os dados do menu selecionado
        return view('menus.create', compact( 'menu_pai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request, $id = null) // Método que cria um novo menu/submenu
    {
        // Recebendo os dados do formulário (já validados pela classe "MenuRequest"
        $data = $request->all();

        /*
         * Retirando do array o dado de validação de formulário.
         * Geralmente (falo em relação a experiências anteriores) como este dado não possui um campo com o mesmo nome no
         * DB, é retornado este erro, impossibilitando assim a criação de um novo registro
         */
        unset($data['_token']);

        // Caso o menu a ser criado seja na Raiz, o valor de "menu_pai" será nulo.
        $data['menu_pai'] = ($id === null ? null : $id);

        // Cria o registro no banco de dados
        $this->menu::create($data);

        // Crio uma sessão flash (válida apenas até a próxima requisição - refresh - da página)
        $request->session()->flash('message-success', 'Menu/Submenu criado com sucesso');

        // Retorno para a página de listagem
        return redirect()->route('menus.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) // Método que exibe formulário de edição do menu selecionado
    {
        // Chamando a view e enviando a ela a variável que contém os dados do menu selecionado
        return view('menus.edit', compact( 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu) // Atualizando dados do menu/submenu cadastrado
    {
        // Recebendo dados do formulário
        $data = $request->all();
        unset($data['_token']);

        // Atualizando os dados
        $menu->update($data);

        // Criando uma session flash de mensagem de sucesso
        $request->session()->flash('message-success', 'Menu editado com sucesso');

        // Redirecionando para a página de listagem
        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu) // Método responsável por excluir o menu selecionado (caso seja menu RAIZ)
    {
        //Verifica se é menu_pai
        if($menu->isFather())
            $this->deletaTudo($menu); // Se sim, chama método recursivo que exclui os submenus pertencentes a ele
        else
            $menu->delete(); // Se não, exclui o mesmo

        // Cria uma session flash de mensagem de sucesso
        request()->session()->flash('message-success', 'Menu excluído com sucesso');

        // Redireciona para a listagem de menus
        return redirect()->route('menus.index');
    }

    /**
     * @param Menu $menu
     * @throws \Exception
     */
    public function deletaTudo(Menu $menu) // Método que exclui menus e submenus
    {
        // Recebe os elementos filho (caso exista)
        $menusFilhos = $menu->menus()->get();

        // Cria um laço passando por todos eles
        foreach ($menusFilhos as $filho){
            if($filho->isFather())
                $this->deletaTudo($filho); // Caso o elemento filho também possua submenus (ou seja, menu Pai), este método é chamado novamente
            else
                $filho->delete(); // Caso não tenha elementos filhos, exclui o menu
        }

        // Após terminar todas a iterações, sobrará somente o menu passado como parâmetro. Sendo assim, ele é excluído e retornamos ao método anterior
        $menu->delete();
        return;
    }
}

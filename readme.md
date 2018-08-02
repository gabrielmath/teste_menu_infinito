# Teste: Menu Infinito

###### ___Início do projeto:___ _28/07/2018 - 02:07 - Horário de Brasília_ :point_down:
## Sobre o projeto

Este projeto é feito utilizando como base o framework o [Laravel](https://laravel.com/). A ideia aqui é gerar um menu "infinito" (inclusive submenus), onde o usuário possa cadastrar o menu e visualiza-lo conforme a sua hierarquia.   

Conforme for acontecendo a atualização deste sistema, lançarei o horário + o que há de diferente (de maneira resumida) em relação a versão anterior. Isso serve também para as bibliotecas utilizadas para o auxílio e ganho de produtividade. **Neste último caso, direi qual será usada e deixarei o link com sua documentação.**


##
###### ___Atualização:___ _28/07/2018 - 19:12 - Horário de Brasília_ :point_down:

## Atualização do Laravel e inclusão de pacotes

Nesta etapa foquei na atualização do Laravel, migrando de sua versão **5.5** para a **5.6**.
Como esperado, todo o seu core recebeu o upgrade e então realizei as modificações necessárias para o seu correto funcionamento.


Para que a versão **5.6** do Laravel funcionasse, foram feitas as seguintes modificações:
- Atualização do PHP `7.0.0 => 7.1.6`;
- Atualização do Composer, indicando o caminho da versão atualizada do PHP;
- Atualização dos pacotes listados no `composer.json` da aplicação;
- Realização das alterações necessárias conforme o [Guia de Atualização do Laravel](https://laravel.com/docs/5.6/upgrade);
- Atualização dos pacotes listados no `package.json` da aplicação;
- Realização das alterações relacionadas ao front-end:
    - O arquivo SCSS que está no diretório `resources/assets/sass/app.scss` recebeu o novo core do Bootstrap `v4.0`;
    - O arquivo JS que está no diretório `resources/assets/js/app.js` recebeu a inclusão do **Popper**.
- Criação do Model `app/Models/Menu.php` e de sua migration para a criação dinâmica da tabela  no banco de dados (_code first_);
- Mudança de diretório do Model `app/User.php => app/Models/User.php` para uma melhor organização.

Incluí os arquivos de tradução em `resources/assets/lang/pt-BR`.

Realizei também a instalação dos pacotes de (1) configuração de autocomplete da IDE PHPStorm e (2) de uma biblioteca que auxilia na construção de formulários no Laravel.

#### [Laravel IDE Helper Generation](https://github.com/barryvdh/laravel-ide-helper)
Essa biblioteca é responsável por facilitar o desenvolvimento dentro da IDE PHPStorm.
Ela é instalada como dependência de desenvolvedor: 

```composer log
composer require barryvdh/laravel-ide-helper --dev
```

Após a instalação, é necessário inserir sua instância nos providers.
Como ela será utilizada somente em ambiente de desenvolvimento, ela será iniciada pelo Service Provider:

```php
// app/Providers/AppServiceProvider.php
...
public function register()
{
    if ($this->app->environment() !== 'production') {
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }
    // ...
}
...
``` 
Atualize o `composer.json`:

```json
// composer.json
...
"post-install-cmd": [
    "Illuminate\\Foundation\\ComposerScripts::postInstall",
    "php artisan ide-helper:generate",
    "php artisan ide-helper:meta",
    "php artisan ide-helper:models",
    "php artisan optimize"
],
"post-update-cmd": [
    "Illuminate\\Foundation\\ComposerScripts::postUpdate",
    "php artisan ide-helper:generate",
    "php artisan ide-helper:meta",
    "php artisan ide-helper:models",
    "php artisan optimize"
]
...
```

Sempre quando um novo pacote for instalado, essa biblioteca criará ou atualizará seus arquivos de configuração da IDE
na raiz do projeto (`.phpstorm.meta.php` e `_ide_helper.php`), incluindo as classes e métodos desse novo pacote para o autocomplete.
Sugiro então incluir estes arquivos no `.gitignore`, já que quando o projeto estiver em produção não fique com arquivo "sobrando".


#### [Laravel Collective - HTML e Form](https://laravelcollective.com/docs/master/html)
**Laravel Collective** é uma comunidade de desenvolvedores que estão dando continuidade a bibliotecas que faziam parte do core do Laravel e não fazem mais.
Aqui eu instalo o pacote "html" e utilizo os helpers para criação de HTML e Formulários.
Segue a instalação:

```
composer require laravelcollective/html
```

Após, inserimos sua classe nos `providers` em `config/app.php`:

```php
'providers' => [
    // ...
    Collective\Html\HtmlServiceProvider::class,
    // ...
  ],
```
Em seguida, no mesmo arquivos, atualize o array de Alias:

```php
'aliases' => [
    // ...
      'Form' => Collective\Html\FormFacade::class,
      'Html' => Collective\Html\HtmlFacade::class,
    // ...
  ],
```
Dessa forma, a aplicação está pronta para utilizar estes recursos.

##
###### ___Finalização:___ _02/08/2018_  :point_down:

## Iniciando o projeto - Model, migration e Seeder
###### (Nesta seção explicarei apenas o funcionamento do sistema. Caso tenha interesse um pouco mais técnico, basta navegar ao código fonte do arquivo. Todos estão comentados.)
Criei o Model `app/Models/Menu.php` e sua migration usando o comando:

```
php artisan make: model Models\Menu -m
```

Com o parâmetro adicional `-m` ,a migration deste model também foi criada. Nela,fiz um auto-relacionamento
para que fosse identificado o 'item pai' do menu (`database/migrations/2018_07_28_162451_create_menus_table.php`).

No model, além de habilitar a atribuição em massa (`$fillable`) para a inserção de dados através de `array` e criar a relação Many-to-Many, criei também
alguns métodos de auxílio como: Verificação de "item pai", "filhos" e se o item selecionado é pai ou não.

Após a criação e configuração do model e migration, vi que seria necessário alguns dados pré-cadastrados no DB para a realização dos testes.
Criei então uma Factory onde pré-configurei o padrão de cadastro utilizado nos campos da tabela `menus`.
Para isso usei o comando:

```
php artisan make:factory MenuFactory
``` 

O próximo passo foi criar uma Seeder do model `Menu` e configura-la para criar os campos de acordo com o que foi definido em sua Factory.
Então rodei o comando:

```
php artisan make:seeder MenuTableSeeder
```

Com a pré-configuração (total) pronta, configurei o banco de dados no arquivo `.env` e, após, 
fiz a criação da tabela da seguinte forma:

```
php artisan migrate --seed
```

Quando passamos o parâmetro opcional `--seed`, a tabela é criada e e preenchida com o padrão que definimos anteriormente. Caso esse parâmetro não seja passado, a tabela é criada, porém vazia.


#### Controller

Para ganhar em produtividade, criei o `app/Http/Controllers/Admin/MenuController.php` de uma forma que ele já traz os métodos necessários para o CRUD com a tabela do banco.
Fiz dessa forma:

```
php artisan make:controller Admin\MenuController --resource --model=Models\Menu
``` 

Com o parâmetro `--resource`, a estrutura de métodos vem pronta. Caso seja passado o model de base para as operações, o controller vem pré-configurado, bastando apenas usar a sua própria lógica para realizar o CRUD.


#### ViewComposer

Como sabemos, o menu será exibido a todo momento, em todas as telas do CRUD. Então seria necessário em todos os métodos (de carregamento de view) enviar a collection com os dados do banco.
Porém, se houver qualquer mudança no método ou na view, todos os lugares deverão ser alterados.

Uma outra alternativa seria injetar essa collection diretamente no componente da view, através do método do `blade`:
```blade
@injection(Model::class)
```
Porém, a chance de se "esquecer" de trazer ou de tirar essa injeção no componente é grande e, dependendo do tamanho da aplicação, poderá causar transtornos (não tão complexos, mas desagradáveis de se lidar).

Neste projeto utilizei um Service Provider para fazer essa injeção de dados:

```
php artisan make:provider ViewComposerServiceProvider
```

Com ele, é possível criar um método onde eu escolho em qual pasta/conjunto de views eu quero executar algo ou carregar dados essencias para todo o projeto.
Então configurei todas as views do CRUD receberam a collection de menus do banco de dados e assim tirei essa responsabilidade dos métodos do controller, automatizando essa parte de exibição e criação do menu.

OBS: será preciso registrar esse provider nas configurações do Laravel. Abra o arquivo `config/app.php` e insira em seu array de providers:


```php
'providers' => [
    //...
    App\Providers\ViewComposerServiceProvider::class,
    //...
]
```


#### Front-end

Antes de qualquer coisa, instale as dependêndias do projeto:

```
npm install
```

Após configurar o arquivo `webpack.mix.js`, executei o comando:

```
npm run watch
```

O comando `watch` "assiste" os arquivos configurados no webpack e re-compila tudo de acordo com as alterações realizadas.

Em relação ao layout do sistema:
- SCSS: `resources/assets/sass/style.scss`;
- JS: `resources/assets/js/script.js`;

Em relação aos templates:
- `resources/views/menus`: diretório com as telas de CRUD e partial views da mesmo;
- `resources/views/layout`: diretório que contém a master page do layout da aplicação;
- `resources/views/auth`: diretório que contém o layout da tela de autenticação e login de usuários.

Criei uma master pager e fiz com que todas as páginas de extensão `blade` herdassem o layout dela. Também é nessa master page que crio a lógica de exibição do menu.

Resumindo:
- Na `index.blade.php`, temos uma listagem paginada com todos os menus e controle sobre eles (Cadastrar novo menu/submenu, editar nome de menu, ver detalhes de um menu específico e excluí-lo);
- `create.blade.php` é um formulário que recebe (opcional) o `id` do "menu pai" caso o usuário queira cadastrar um submenu. Caso não queira dessa forma, basta selecionar no campo dropdown a opção "Raiz";
- `edit.blade.php` traz a edição do menu;
- `show.blade.php` exibe o menu/submenu e toda a sua listagem de "menus filhos" caso este possua. Nessa página encontra-se também o botão de excluir menu (que, consequentemente, acaba excluindo toda a cadeia de submenus abaixo deste).

Na barra de navegação superior, a exibição funciona da seguinte forma:
1. Executo um `foreach` na variável que contém a collection de menus. Vale lembrar que nessa primeira etapa são selecionados somente os menus que estão no topo da hierarquia (raiz);
2. Para cada repetição, executo um método criado no model, chamado `isFather()`. Este método retorna o número de elementos filhos que o menu atual possui. Caso ele possua filho:
    - O mesmo é passado por parâmetro para uma partial view `resources/views/menus/partials/submenus.blade.php`, onde a mesma verificação é feita;
    - Se esse submenu também possuir filhos, o passo **2** se repete, mostrando assim que ele funciona de forma recursiva.
    

E assim está feito o teste de menu infinito, desde a exibição, funcionamento, cadastro, edição e exclusão do mesmo.

Para finalizar, o usuário precisa estar autenticado para visualizar o sistema.
Caso tenha interesse, criei uma seeder para usuário também. Os dados de acesso são:

Login: `admin@user.com`

Senha: `infinito`

Resumindo:
1. Clone o projeto;
2. Dentro do diretório do projeto, abra seu terminal e rode o comando: `composer install`;
3. Caso o arquivo `.env` não seja criado manualmente, faça uma cópia do arquivo exemplo e rode o comando: `php artisan key:generation` para gerar a chave de criptografia;
4. Configure o banco de dados neste mesmo arquivo;
5. Caso queira iniciar o banco de dados com menus cadastrados, digite: `php artisan migrate --seed`
6. Instale os pacotes de front-end com: `npm install`;
7. Compile os arquivos: `npm run production`;
8. Inicie o servidor: `php artisan serve` e acesse a url `http://localhost:8000`;
9. Efetue o login com os dados informados acima;
10. Curta o sistema!

Qualquer dúvida, estarei a disposição. Obrigado!
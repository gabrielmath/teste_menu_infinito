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

```composer require barryvdh/laravel-ide-helper --dev```

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

```php
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


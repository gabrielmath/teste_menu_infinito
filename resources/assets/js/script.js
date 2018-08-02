// JS do jQuery + Popper + Bootstrap -> Configuração padrão do Laravel Mix
require('./bootstrap');

// Função que mantém rodapé na parte baixa da tela  mesmo que não haja conteúdo em seu meio.
function sticky_footer() {
    let mFoo = $("footer");
    if ((($(document.body).height() + mFoo.outerHeight()) < $(window).height() && mFoo.css("position") == "fixed") || ($(document.body).height() < $(window).height() && mFoo.css("position") != "fixed")) {
        mFoo.css({ position: "fixed", bottom: "0" });
    } else {
        mFoo.css({ position: "static" });
    }
}

//============================== INÍCIO ================================


// Inicializando com rodapé lá em baixo, independente da alçao do usuário com a janela do navegador
sticky_footer();
$(window).scroll(sticky_footer);
$(window).resize(sticky_footer);
// $(window).load(sticky_footer);



// Exibindo/Ocultando toda a hierarquia de menus/submenus aninhados =======================
let linkMenu = $('.dropdown-menu a.dropdown-toggle');
linkMenu.on('click', function(e) {
    if (!$(this).next().hasClass('show'))
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");

    let subMenu = $(this).next(".dropdown-menu");
    subMenu.toggleClass('show');

    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
    });


    return false;
});


// Evento que redireciona o usuário para a exclusão do menu após sua confirmação
$('.excluir').click(function () {
    console.log($(this).attr('data-form'));
    if(confirm('Deseja realmente deletar esse menu? Todos os seus submenus serão excluídos! Confirmar a ação?')){
        let form = $(this).attr('data-form');
        $(form).trigger('submit');
        return true;
    }
    return false;
});

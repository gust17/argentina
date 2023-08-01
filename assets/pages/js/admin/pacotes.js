$(document).ready(function(){

    $(document).on('click', '.addNivel', function(){

        let nextNivel = parseInt($(this).attr('data-next-nivel'));

        $(this).before('<input type="text" name="niveis['+nextNivel+']" class="form-control mb-2" data-nivel="'+nextNivel+'" data-plugin="moneymask" placeholder="Porcentagem do nível '+nextNivel+'" />');

        $(this).attr('data-next-nivel', (nextNivel+1));
        $('[data-last-nivel]').attr('data-last-nivel', nextNivel);

        initMaskMoney();
    });

    $(document).on('click', '.deleteNivel', function(){

        let lastNivel = parseInt($(this).attr('data-last-nivel'));
        let nextLevel = parseInt($('.addNivel').attr('data-next-nivel'));

        if(lastNivel > 1){

            $('[data-nivel="'+lastNivel+'"]').remove();

            $(this).attr('data-last-nivel', (lastNivel-1));
            $('.addNivel').attr('data-next-nivel', (nextLevel-1));

        }else{

            createNotification('Erro!', 'Você não pode excluir mais campos!', 'times', 'danger');
        }
    });

    initMaskMoney();
});
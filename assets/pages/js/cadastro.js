$(document).ready(function(){

    var current_fs, next_fs;
    var opacity;

    $(".next").click(function(){

        let tipo_cadastro = $('[name="tipo_cadastro"] option:selected').val();
        let documento = $('[name="documento"]').val();
        let proximo = 1;
        let _this = $(this);
        let textButtonOri = _this.html();

        current_fs = $(this).parent().parent();
        next_fs = $(this).parent().parent().next();

        proximo = 1;

        // if(tipo_cadastro == 1){

        //     $.ajax({
        //         url: baseURL+'ajax/consultar_documento',
        //         type: 'POST',
        //         data: {documento: documento},
        //         dataType: 'json',
        //         async: false,
                
        //         beforeSend: function(){

        //             _this.html('<i class="fa fa-pulse fa-spinner"></i> Verificando documento...');

        //             proximo = 0;
        //         },

        //         success: function(callback){

        //             if(callback.status == 1){

        //                 proximo = 1;

        //             }else{

        //                 createNotification('Documento inválido', 'O documento digitado não existe ou é inválido.', 'times', 'danger');
        //                 proximo = 0;
        //             }
        //         },

        //         complete: function(){

        //             _this.html(textButtonOri)
        //         },

        //         error: function(error){
        //             proximo = 0;
        //             console.log('Error: ', error.messageText);
        //         }
        //     });

        // }

        if(proximo == 1){

            console.log('Próximo....');

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            next_fs.show();
            
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    
                    opacity = 1 - now;

                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        }
    });


    $(document).on('change', '[name="tipo_cadastro"]', function(){

        let tipo_cadastro = $('[name="tipo_cadastro"] option:selected').val();

        if(tipo_cadastro == 1){
            $('[name="documento"]').val('');
            $('[name="documento"]').mask('999.999.999-99');
            $('[name="celular"]').mask('999 999 999');
        }else{
            $('[name="documento"]').val('');
            $('[name="documento"]').unmask();
            $('[name="celular"]').unmask();
        }
    });

    $('[name="celular"]').mask('999 999 9999');
    $('[name="documento"]').mask('99999999');
    $('[name="data_nascimento"]').mask('99/99/9999');
    $('[name="login"]').keyup(function() {
        $(this).val(this.value.replace(/[^a-zA-Z0-9]+/g, ''));
    });

});
$(document).ready(function(){

    $("[name^='valor_']").maskMoney({allowNegative: true, thousands:'', decimal:'.', affixesStay: false});

    $(document).on('click', '.select_account', function(){
        
        let account = $(this).attr('data-account');

        $('[name="conta"]').val(account);
        $('[name="submit"]').removeAttr('disabled');
    });

    $('.countdown').each(function(){

        let _this = this;
        let data_final = $(_this).attr('data-final');

        $(_this).countdown(data_final, function(event) {
            $(this).html(event.strftime('%D '+__TRANS_DIAS__+' %H:%M:%S'));
        });
    });

    $(document).on('click', '.gerarSMS', function(){

        let _this = $(this);
        let meio_saque = $(this).attr('data-meio');
        let tipo_saque = $(this).attr('data-tipo');
        let textoOriginal = $(this).html();

        $.ajax({
            url: baseURL+'ajax/envio_codigo_saque',
            type: 'POST',
            data: {tipo_saque: tipo_saque, meio_saque: meio_saque},
            dataType: 'json',

            beforeSend: function(){

                _this.html('<i class="fa fa-spinner fa-pulse"></i> Enviando...');
                _this.attr('disabled', 'disabled');
                _this.addClass('disabled');
            },

            success: function(callback){

                if(callback.status == 1){

                    createNotification('Código enviado!', 'Código de confirmação enviado para o celular cadastrado.', 'check', 'success');

                }else{

                    createNotification('Erro ao enviar o código', 'O código não pode ser enviado pelo nosso sistema. Tente novamente mais tarde.', 'times', 'danger');
                }
            },

            complete: function(){

                _this.html(textoOriginal);
                _this.removeAttr('disabled');
                _this.removeClass('disabled');
            },

            error: function(error){
                console.log('Error: ', error);
                console.log(error.messageText);
            }
        });
    });
});
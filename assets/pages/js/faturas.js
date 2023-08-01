$(document).ready(function () {

    /* Fechando collapse ao clicar em outro */
    $(document).on('click', '[data-toggle="collapse"]', function (e) {
        if (!$(e.target).is('.panel-body')) {
            $('.collapse').collapse('hide');
        }
    });

    $(document).on('click', '.copiarCC', function () {

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#cc').val()).select();
        document.execCommand("copy");
        $temp.remove();


        createNotification('Copiado!', 'Chave Pix copiado com sucesso!', '', 'success');

    });


    /* Gerando carteira de crypto */
    $(document).on('click', '.gerarCarteira', function () {

        let _this = $(this);
        let textButton = $(this).html();
        let idPlan = $('[name="id_plano"]').val();
        let crypto = $(this).attr('data-crypto');

        $.ajax({
            url: baseURL + 'ajax/generate_new_wallet',
            type: 'POST',
            data: { id_plano: idPlan, crypto: crypto },
            dataType: 'json',

            beforeSend: function () {

                $('.crypto_carteira').html(__TRANS_GERANDO_CARTEIRA__);
                $('.crypto_fracao').html(__TRANS_GERANDO_FRACAO__);
                $('.crypto_qrcode').removeAttr('src');

                _this.attr('disabled', 'disabled');
                _this.html(__TRANS_GERANDO_BUTTON__);
            },

            success: function (callback) {

                if (callback.success == 1) {

                    $('.crypto_carteira').html(callback.wallet);
                    $('.crypto_fracao').html(callback.fracao);
                    $('.crypto_qrcode').attr('src', callback.qrcode);

                    $('.instrucoes_crypto[data-crypto="' + crypto + '"]').fadeOut(400, function () {
                        $('.pagamento_crypto[data-crypto="' + crypto + '"]').fadeIn();
                    });

                } else {

                    Swal.fire(__TRANS_ERRO__, callback.error, 'error');
                }
            },

            complete: function () {

                _this.removeAttr('disabled');
                _this.html(textButton);
            },

            error: function (callback) {

                console.log('[Erro ao gerar carteira de cryptomoedas:]');
                console.log(callback.responseText);
            }
        });
    });
});
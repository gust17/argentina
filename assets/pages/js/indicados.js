$(document).ready(function(){

    if($('.btpesquisa')[0]){
        
        $('.btpesquisa').click();
    }

    $(document).on('click', '.copiarLink', function(){

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#linkIndicacao').val()).select();
        document.execCommand("copy");
        $temp.remove();

        // Swal.fire('Copiado!', 'Link de indicação copiado com sucesso!', 'success');

        createNotification(__TRANS_LINK_COPIADO_TITLE__, __TRANS_LINK_COPIADO_CONTENT__, '', 'success');

    });

    $(document).on('click', '.showAffiliate', function(){

        let id_patrocinador = $(this).attr('data-sponsor');

        $.ajax({
            url:baseURL+'ajax/show_affiliate_network',
            data: {id_patrocinador: id_patrocinador},
            type: 'POST',
            dataType: 'json',

            beforeSend: function(){

                $('.loading_block').css('display', 'block');
                $('.content_affiliate_block').css('display', 'none');

                $('.affiliateSponsorDirect').html('');
                $('.affiliatePhoto').attr('src', '');
                $('.affiliateStatusAccount').html('');
                $('.affiliateStatusBinary').html('');
                $('.affiliateName').html('');
                $('.affiliateMobile').html('');
                $('.affiliateSignup').html('');
                $('.affiliateLastLogin').html('');
                $('.affiliateDirect').html('');
                $('.affiliateLeft').html('');
                $('.affiliateRight').html('');

                $('affiliateStatusAccount').removeClass('badge-success');
                $('affiliateStatusAccount').removeClass('badge-danger');
                $('affiliateStatusBinary').removeClass('badge-success');
                $('affiliateStatusBinary').removeClass('badge-danger');
            },

            success: function(callback){

                var labelStatusAccount = __TRANS_CADASTRO_INATIVO__;
                var labelStatusBinary = __TRANS_BINARIO_INATIVO__;
                var colorStatusAccount = 'badge-danger';
                var colorStatusBinary = 'badge-danger';
                
                if(callback.success == 'ok'){

                    if(callback.data.cadastro_ativo == 1){
                        
                        labelStatusAccount = __TRANS_CADASTRO_ATIVO__;
                        colorStatusAccount = 'badge-success';
                    }

                    if(callback.data.binario_ativo == 1){
                        
                        labelStatusBinary = __TRANS_BINARIO_ATIVO__;
                        colorStatusBinary = 'badge-success';
                    }

                    $('.affiliateStatusAccount').addClass(colorStatusAccount);
                    $('.affiliateStatusBinary').addClass(colorStatusBinary);

                    $('.affiliateSponsorDirect').html(callback.data.patrocinador);
                    $('.affiliatePhoto').attr('src', callback.data.avatar);
                    $('.affiliateStatusAccount').html(labelStatusAccount);
                    $('.affiliateStatusBinary').html(labelStatusBinary);
                    $('.affiliateName').html(callback.data.nome);
                    $('.affiliateMobile').html(callback.data.celular);
                    $('.affiliateSignup').html(callback.data.data_cadastro);
                    $('.affiliateLastLogin').html(callback.data.ultimo_login);
                    $('.affiliateDirect').html(callback.data.indicados_diretos+' '+__TRANS_CADASTROS_P__);
                    $('.affiliateLeft').html(callback.data.indicados_esquerda+' '+__TRANS_CADASTROS_P__);
                    $('.affiliateRight').html(callback.data.indicados_direita+' '+__TRANS_CADASTROS_P__);

                    $('.affiliateActivePlan').html(callback.data.plano_ativo);

                    if(callback.data.plano_ativo_ativacao != ''){

                        $('.affiliateActivePlanDate').html(new Date(callback.data.plano_ativo_ativacao).toLocaleDateString());

                    }

                }else{

                    $('.close').click();
                    Swal.fire(__TRANS_ERRO_TITLE__, __TRANS_ERRO_REQUISICAO__+' '+callback.error, 'error');
                }
            },

            complete: function(){

                $('.loading_block').css('display', 'none');
                $('.content_affiliate_block').css('display', 'block');
            },

            error: function(message){

                console.log('[Erro ao fazer requisição das informações do indicado]');
                console.log(message.responseText);
            }


        });

        $('.network-access-btn').attr('href', baseURL+urlBinario+'?patrocinador='+id_patrocinador);
    });

    $(document).on('click', '.saveBinaryKey', function(){

        var label = '';

        let binary = $('.binaryKeySelect option:selected').val();

        if(binary == 1){
            label = __TRANS_BIN_LADO_ESQUERDO__;
        }else{
            label = __TRANS_BIN_LADO_DIREITO__;
        }

        // $('#ladoAtual').html(label);

        $.ajax({
            url: baseURL+'ajax/save_key_binary',
            type: 'POST',
            data: {chave_binaria: binary},

            success: function(callback){

                Swal.fire(__TRANS_TUDO_CERTO__, __TRANS_CHAVE_BINARIA_OK__, 'success');
            },

            error: function(message){
                
                console.log(message.responseText);
            }
        });
    });
});
$(document).ready(function(){

    $('.page_blocks').select2({
        width:'100%'
    });

    let tipo_cadastro_load  = $('[name="tipo_cadastro"] option:selected').val();

    if(tipo_cadastro_load == 1){
        $('[name="celular"]').mask('+99 (99) 9.9999-9999');
        $('[name="documento"]').mask('999.999.999-99');
    }

    
    $('[name="data_nascimento"]').mask('99/99/9999');
    $('[name="login"]').keyup(function() {
        $(this).val(this.value.replace(/[^a-zA-Z0-9]+/g, ''));
    });


    $(document).on('change', '[name="tipo_cadastro"]', function(){

        let tipo_cadastro = $('[name="tipo_cadastro"] option:selected').val();

        if(tipo_cadastro == 1){
            $('[name="celular"]').mask('+99 (99) 9.9999-9999');
            $('[name="documento"]').mask('999.999.999-99');
        }else{
            $('[name="celular"]').unmask();
            $('[name="documento"]').unmask();
        }
    });
    
    /* Extrato edit */

    /* *** Define ID do Usuário no botão de criar registro *** */
    $(document).on('click', '.clickAddRecordExtract', function(){

        let id_usuario = $(this).attr('data-userid');

        $('.saveRecordExtract').attr('data-userid', id_usuario);
    });

    /* *** Adicionar Registro no extrato *** */
    $(document).on('click', '.saveRecordExtract', function(){

        let id_usuario = $(this).attr('data-userid');
        let descricao = $('[name="edit_descricao"]').val().trim();
        let valor = $('[name="edit_valor"]').val().trim();
        let tipo_saldo = $('[name="edit_tipo_saldo"] option:selected').val();
        let categoria = $('[name="edit_categoria"] option:selected').val();
        let liberado = $('[name="edit_liberado"] option:selected').val();
        let referencia = $('[name="edit_referencia"]').val();
        let data_criacao = $('[name="edit_data_criacao"]').val().trim();

        $.ajax({

            url: baseURL+'ajax/admin_user_extract_add',
            type: 'POST',
            data: {id_usuario: id_usuario, descricao: descricao, valor: valor, tipo_saldo: tipo_saldo, categoria: categoria, liberado: liberado, referencia: referencia, data_criacao: data_criacao},
            dataType: 'json',

            beforeSend: function(){

                $('[name="edit_descricao"]').val('');
                $('[name="edit_valor"]').val('');
                $('[name="edit_tipo_saldo"] option:selected').val('');
                $('[name="edit_categoria"] option:selected').val('');
                $('[name="edit_liberado"] option:selected').val('');
                $('[name="edit_referencia"]').val('');
                $('[name="edit_data_criacao"]').val('');

                $('.saveRecordExtract').attr('disabled', 'disabled');
            },

            success: function(callback){
                
                if(callback.status == 1){

                    let estruture = 
                    `<tr data-extract-block-ref="`+callback.id+`">`+
                    `<td>`+callback.id+`</td>`+
                    `<td>`+
                        `<a href="javascript:void(0)" data-ref="`+callback.id+`" class="btn btn-danger excluirExtrato">Excluir</a>`+
                        `<a href="javascript:void(0)" data-ref="`+callback.id+`" data-toggle="modal" data-target=".editar-extrato" class="btn btn-info editarExtrato">Editar</a>`+
                    `</td>`+
                    `<td class="descricao_extrato text-`+callback.cor_descricao+`">`+callback.descricao+`</td>`+
                    `<td class="valor_extrato">`+MOEDA_ATUAL+` `+callback.valor+`</td>`+
                    `<td class="tipo_extrato">`+callback.tipo_saldo+`</td>`+
                    `<td class="categoria_extrato">`+callback.categoria+`</td>`+
                    `<td class="data_criacao_extrato">`+callback.data_criacao+`</td>`+
                    `</tr>`;
                    
                    $('#extrato .table > tbody').prepend(estruture);

                    createNotification('Sucesso!', 'Registro do adicionado com sucesso!', 'check', 'success');

                    $('.add-extrato .close').click();

                }else{

                    createNotification('Erro!', 'Ocorreu um erro: '+callback.error, 'times', 'danger');
                }
                
            },

            complete: function(){

                $('.saveRecordExtract').removeAttr('disabled');
            },

            error: function(message){

                console.log(message.responseText);
            }

        });
    });

    
    /* *** Excluir Registro do extrato *** */
    $(document).on('click', '.excluirExtrato', function(){

        let id = $(this).attr('data-ref');

        Swal.fire({
            title: 'Tem certeza?',
            text: "Você tem certeza que deseja deletar esse registro? Essa ação é irreversível!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, tenho certeza!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (!result.isConfirmed) {
              return false;
            }

            $.ajax({
                url: baseURL+'ajax/admin_user_extract_delete',
                type: 'POST',
                dataType: 'json',
                data: {idExtract: id},

                success: function(callback){

                    if(callback.status == 1){

                        $('tr[data-extract-block-ref="'+id+'"]').fadeOut(400);

                        createNotification('Sucesso!', 'Registro excluído com sucesso!', 'check', 'success');
                    }else{
                        createNotification('Erro!', 'Ocorreu um erro interno ao tentar excluir. Tente novamente.', 'times', 'danger');
                        
                    }
                },

                error: function(message){

                    console.log(message.responseText);
                }
            });
        });
    });

    /* *** Carregar Registro do extrato *** */
    $(document).on('click', '.editarExtrato', function(){

        let id = $(this).attr('data-ref');

        $.ajax({
            url: baseURL+'ajax/admin_user_extract_edit',
            type: 'POST',
            data: {idExtract: id, action: 'info'},
            dataType: 'json',

            beforeSend: function(){

                $('.load_info_edit').css('display', 'none');
                $('.pre_loading').css('display', 'block');

                $('.saveChangesExtract').removeAttr('disabled');

                $('[name="id_record_extract"]').val(id);

                $('[name="descricao"]').val('');
                $('[name="valor"]').val('');
                $('[name="tipo_saldo"]').val('');
                $('[name="categoria"]').val('');
                $('[name="liberado"]').val('');
                $('[name="referencia"]').val('');
                $('[name="data_criacao"]').val('');
            },

            success: function(callback){

                if(callback.status == 1){

                    $('[name="descricao"]').val(callback.descricao);
                    $('[name="valor"]').val(callback.valor);
                    $('[name="tipo_saldo"]').val(callback.tipo_saldo);
                    $('[name="categoria"]').val(callback.categoria);
                    $('[name="liberado"]').val(callback.liberado);
                    $('[name="referencia"]').val(callback.referencia);
                    $('[name="data_criacao"]').val(callback.data_criacao);

                }else{

                    setTimeout(function(){
                        $('.editar-extrato .close').click();
                    },500);

                    createNotification('Erro!', 'Não foi possível localizar as informações do extrato a editar. Atualize página e tente novamente.', 'times', 'danger');
                }
            },

            complete: function(){

                $('.load_info_edit').css('display', 'block');
                $('.pre_loading').css('display', 'none');
            },

            error: function(message){

                console.log(message.responseText);
            }
        });
    });

    /* *** Salvar alterações no extrato *** */
    $(document).on('click', '.saveChangesExtract', function(){

        let id = $('[name="id_record_extract"]').val();
        let descricao = $('[name="descricao"]').val();
        let valor = $('[name="valor"]').val();
        let tipo_saldo = $('[name="tipo_saldo"] option:selected').val();
        let categoria = $('[name="categoria"] option:selected').val();
        let liberado = $('[name="liberado"] option:selected').val();
        let referencia = $('[name="referencia"]').val();
        let data_criacao = $('[name="data_criacao"]').val();

        $.ajax({

            url: baseURL+'ajax/admin_user_extract_edit',
            type: 'POST',
            data: {idExtract: id, action: 'save', descricao: descricao, valor: valor, tipo_saldo: tipo_saldo, categoria: categoria, liberado: liberado, referencia: referencia, data_criacao: data_criacao},
            dataType: 'json',

            beforeSend: function(){

                $('.saveChangesExtract').attr('disabled', 'disabled');

                $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').removeClass('text-success');
                $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').removeClass('text-danger');
                $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').removeClass('text-info');
                $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').removeClass('text-warning');
            },

            success: function(callback){
                
                if(callback.status == 1){

                    if(tipo_saldo == 1){
                        $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').addClass('text-success');
                    }else{
                        $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').addClass('text-danger');
                    }

                    $('tr[data-extract-block-ref="'+id+'"] .descricao_extrato').html(callback.descricao);
                    $('tr[data-extract-block-ref="'+id+'"] .valor_extrato').html(callback.valor);
                    $('tr[data-extract-block-ref="'+id+'"] .tipo_extrato').html(callback.tipo_saldo);
                    $('tr[data-extract-block-ref="'+id+'"] .categoria_extrato').html(callback.categoria);
                    $('tr[data-extract-block-ref="'+id+'"] .data_criacao_extrato').html(callback.data_criacao);

                    createNotification('Sucesso!', 'Registro do extrato alterado com sucesso!', 'check', 'success');

                    $('.editar-extrato .close').click();

                }else{

                    createNotification('Erro!', 'Ocorreu um erro: '+callback.error, 'times', 'danger');
                }
                
            },

            complete: function(){

                $('.saveChangesExtract').removeAttr('disabled');
            },

            error: function(message){

                console.log(message.responseText);
            }

        });
    });

    /* Fatura edit */

    /* *** Carregar Fatura *** */
    $(document).on('click', '.editarFaturaLoad', function(){

        let id = $(this).attr('data-ref');

        $.ajax({
            url: baseURL+'ajax/admin_user_fatura_edit',
            type: 'POST',
            data: {idFatura: id, action: 'info'},
            dataType: 'json',

            beforeSend: function(){

                $('.load_info_edit_fatura').css('display', 'none');
                $('.pre_loading_fatura').css('display', 'block');

                $('.saveChangesFatura').removeAttr('disabled');

                $('[name="id_record_fatura"]').val(id);

                $('[name="fatura_edit_plano"]').val('');
                $('[name="fatura_edit_valor"]').val('');
                $('[name="fatura_edit_fds"]').val('');
                $('[name="fatura_edit_porcentagem"]').val('');
                $('[name="fatura_edit_dias_pagos"]').val('');
                $('[name="fatura_edit_dias_totais"]').val('');
                $('[name="fatura_edit_liberado"]').val('');
                $('[name="fatura_edit_cortesia"]').val('');
                $('[name="fatura_edit_meio"]').val('');
                $('[name="fatura_edit_detalhes_interno"]').val('');
                $('[name="fatura_edit_status"]').val('');
                $('[name="fatura_edit_raiz_paga"]').val('');
                $('[name="fatura_edit_gerada"]').val('');
                $('[name="fatura_edit_pago_em"]').val('');
                $('[name="fatura_edit_recebimento"]').val('');
                $('[name="fatura_edit_ultimo_pagamento"]').val('');
                $('[name="fatura_edit_expirado"]').val('');
            },
            
            success: function(callback){

                if(callback.statusRequest == 1){

                    $('[name="fatura_edit_plano"]').val(callback.id_plano);
                    $('[name="fatura_edit_valor"]').val(callback.valor);
                    $('[name="fatura_edit_fds"]').val(callback.dia_util);
                    $('[name="fatura_edit_porcentagem"]').val(callback.percentual_pago);
                    $('[name="fatura_edit_dias_pagos"]').val(callback.quantidade_pagamentos_realizados);
                    $('[name="fatura_edit_dias_totais"]').val(callback.quantidade_pagamentos_fazer);
                    $('[name="fatura_edit_liberado"]').val(callback.valor_liberado);
                    $('[name="fatura_edit_cortesia"]').val(callback.cortesia);
                    $('[name="fatura_edit_meio"]').val(callback.meio_pagamento);
                    $('[name="fatura_edit_detalhes_interno"]').val(callback.meio_pagamento_detalhes);
                    $('[name="fatura_edit_status"]').val(callback.status);
                    $('[name="fatura_edit_raiz_paga"]').val(callback.status_saque_raiz);
                    $('[name="fatura_edit_gerada"]').val(callback.data_criacao);
                    $('[name="fatura_edit_pago_em"]').val(callback.data_pagamento);
                    $('[name="fatura_edit_recebimento"]').val(callback.data_primeiro_recebimento);
                    $('[name="fatura_edit_ultimo_pagamento"]').val(callback.data_ultimo_pagamento_feito);
                    $('[name="fatura_edit_expirado"]').val(callback.data_expiracao);

                }else{

                    setTimeout(function(){
                        $('.editar-extrato .close').click();
                    },500);

                    createNotification('Erro!', 'Não foi possível localizar as informações da fatura a editar. Atualize página e tente novamente.', 'times', 'danger');
                }
            },

            complete: function(){

                $('.load_info_edit_fatura').css('display', 'block');
                $('.pre_loading_fatura').css('display', 'none');
            },

            error: function(message){

                console.log(message.responseText);
            }
        });
    });

    /* *** Salvar alterações na fatura *** */
    $(document).on('click', '.saveChangesFatura', function(){

        let id = $('[name="id_record_fatura"]').val();
        let id_plano = $('[name="fatura_edit_plano"]').val();
        let valor = $('[name="fatura_edit_valor"]').val();
        let final_semana = $('[name="fatura_edit_fds"]').val();
        let porcentagem = $('[name="fatura_edit_porcentagem"]').val();
        let dias_pagos = $('[name="fatura_edit_dias_pagos"]').val();
        let dias_totais_pagar = $('[name="fatura_edit_dias_totais"]').val();
        let valor_liberado = $('[name="fatura_edit_liberado"]').val();
        let cortesia = $('[name="fatura_edit_cortesia"]').val();
        let meio_pagamento = $('[name="fatura_edit_meio"]').val();
        let meio_pagamento_detalhes = $('[name="fatura_edit_detalhes_interno"]').val();
        let status = $('[name="fatura_edit_status"]').val();
        let status_raiz = $('[name="fatura_edit_raiz_paga"]').val();
        let data_geracao = $('[name="fatura_edit_gerada"]').val();
        let data_pagamento = $('[name="fatura_edit_pago_em"]').val();
        let data_primeiro_recebimento = $('[name="fatura_edit_recebimento"]').val();
        let data_ultimo_pagamento = $('[name="fatura_edit_ultimo_pagamento"]').val();
        let data_expirado = $('[name="fatura_edit_expirado"]').val();

        $.ajax({

            url: baseURL+'ajax/admin_user_fatura_edit',
            type: 'POST',
            data: {idFatura: id, action: 'save', id_plano: id_plano, valor: valor, final_semana: final_semana, porcentagem: porcentagem, dias_pagos: dias_pagos, dias_totais_pagar: dias_totais_pagar, valor_liberado: valor_liberado, cortesia: cortesia, meio_pagamento: meio_pagamento, meio_pagamento_detalhes: meio_pagamento_detalhes, status: status, status_raiz: status_raiz, data_geracao: data_geracao, data_pagamento: data_pagamento, data_primeiro_recebimento: data_primeiro_recebimento, data_ultimo_pagamento: data_ultimo_pagamento, data_expirado: data_expirado},
            dataType: 'json',

            beforeSend: function(){

                $('.saveChangesFatura').attr('disabled', 'disabled');
            },

            success: function(callback){
                
                if(callback.status == 1){

                    $('tr[data-invoice-block-ref="'+id+'"] .nome_plano').html(callback.plano);
                    $('tr[data-invoice-block-ref="'+id+'"] .valor').html(callback.valor);
                    $('tr[data-invoice-block-ref="'+id+'"] .dia_util').html(callback.dia_util);
                    $('tr[data-invoice-block-ref="'+id+'"] .percentual_pago').html(callback.percentual_pago);
                    $('tr[data-invoice-block-ref="'+id+'"] .pagamentos').html(callback.pagamentos);
                    $('tr[data-invoice-block-ref="'+id+'"] .valor_liberado').html(callback.valor_liberado);
                    $('tr[data-invoice-block-ref="'+id+'"] .cortesia').html(callback.cortesia);
                    $('tr[data-invoice-block-ref="'+id+'"] .meio_pagamento').html(callback.meio_pagamento);
                    $('tr[data-invoice-block-ref="'+id+'"] .meio_pagamento_detalhes').html(callback.meio_pagamento_detalhes);
                    $('tr[data-invoice-block-ref="'+id+'"] .status_raiz').html(callback.status_raiz);
                    $('tr[data-invoice-block-ref="'+id+'"] .status_fatura').html(callback.status_fatura);
                    $('tr[data-invoice-block-ref="'+id+'"] .data_criacao').html(callback.data_criacao);
                    $('tr[data-invoice-block-ref="'+id+'"] .data_pagamento').html(callback.data_pagamento);
                    $('tr[data-invoice-block-ref="'+id+'"] .data_primeiro_recebimento').html(callback.data_primeiro_recebimento);
                    $('tr[data-invoice-block-ref="'+id+'"] .data_ultimo_pagamento').html(callback.data_ultimo_pagamento);
                    $('tr[data-invoice-block-ref="'+id+'"] .data_expiracao').html(callback.data_expiracao);

                    createNotification('Sucesso!', 'Fatura alterada com sucesso!', 'check', 'success');

                    $('.editar-fatura .close').click();

                }else{

                    createNotification('Erro!', 'Ocorreu um erro: '+callback.error, 'times', 'danger');
                }
                
            },

            complete: function(){

                $('.saveChangesFatura').removeAttr('disabled');
            },

            error: function(message){

                console.log(message.responseText);
            }

        });
    });

    /* Códigos */

    /* *** Excluir código de transação *** */

    $(document).on('click', '.excluirCodigo', function(){

        let id_registro = $(this).attr('data-id');

        Swal.fire({
            title: 'Tem certeza?',
            text: "Você tem certeza que deseja deletar esse registro? Essa ação é irreversível!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, tenho certeza!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (!result.isConfirmed) {
              return false;
            }

            $.ajax({
                url: baseURL+'ajax/admin_user_code_delete',
                type: 'POST',
                dataType: 'json',
                data: {id: id_registro},

                success: function(callback){

                    if(callback.status == 1){

                        $('tr[data-block-code-id="'+id_registro+'"]').fadeOut(400);

                        createNotification('Sucesso!', 'Registro excluído com sucesso!', 'check', 'success');
                    }else{
                        createNotification('Erro!', 'Ocorreu um erro interno ao tentar excluir. Tente novamente.', 'times', 'danger');
                        
                    }
                },

                error: function(message){

                    console.log(message.responseText);
                }
            });
        });
    });

    $(document).on('click', '.gerarCadastroAuthy', function(e){
        
        e.preventDefault();

        let _this = $(this);
        let id_usuario = _this.attr('data-id');

        $.ajax({
            url: baseURL+'ajax/admin_user_create_authy',
            type: 'POST',
            data: {id_usuario: id_usuario},
            dataType: 'json',

            beforeSend: function(){

                _this.html('<i class="fa fa-spinner fa-pulse"></i> Aguarde, solicitando cadastro...');
            },

            success: function(callback){

                if(callback.status == 1){

                    Swal.fire({
                        title: 'Tudo Certo!',
                        icon: 'success',
                        text: 'Essa conta foi cadastrada com sucesso no Authy. Baixe o aplicativo no mesmo número do cadastro.'
                    });

                }else{

                    Swal.fire({
                        title: 'Opps...',
                        icon: 'error',
                        text: 'Ocorreu um erro ao solicitar o cadastro dessa conta: '+callback.error
                    });
                }
            },

            complete: function(){
                
                _this.html('<i class="fa fa-plus"></i> Gerar cadastro Authy para essa conta');
            },

            error: function(message){

                console.log('[Erro ao gerar cadastro Authy]');
                console.log(message.responseText);
            }
        });
    });

    initMaskMoney();
});
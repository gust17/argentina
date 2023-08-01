$(document).ready(function(){

    $(document).on('click', '[name="modal_backoffice_status"]', function(){

        let modalStatus = $(this).val();

        if(modalStatus == 1){

            $('.ck-editor').removeClass('d-none');
            $('.ck-editor').addClass('d-block');

        }else{

            $('.ck-editor').removeClass('d-block');
            $('.ck-editor').addClass('d-none');
        }
    });

    if(typeof $('.modal_backoffice_editor')[0] != 'undefined'){
        ClassicEditor
                .create( document.querySelector( '.modal_backoffice_editor' ), {
                    
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            'fontSize',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'imageInsert',
                            'blockQuote',
                            'insertTable',
                            'mediaEmbed',
                            'undo',
                            'redo',
                            'htmlEmbed',
                            'code'
                        ]
                    },
                    language: 'pt-br',
                    licenseKey: '',
                    
                    
                    
                } )
                .then( editor => {
                    window.editor = editor;
                    
                    let modalStatus = $('[name="modal_backoffice_status"]:checked').val();

                    if(modalStatus == 0){
                        $('.ck-editor').addClass('d-none');
                    }
                    
                } )
                .catch( error => {
                    console.error( 'Oops, something went wrong!' );
                    console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                    console.warn( 'Build id: mkuxr2iby1r2-jxokvrak3u0h' );
                    console.error( error );
                } );
            }
    

    

    if(typeof $(".coinpayments_criptos")[0] != 'undefined'){
        $(".coinpayments_criptos").select2({
            placeholder: "Selecione uma ou mais cryptos",
            width: '100%'
        });
    }

    if(typeof $(".cadastros_liberados_manutencao")[0] != 'undefined'){
        $(".cadastros_liberados_manutencao").select2({
            placeholder: "Selecione um ou mais logins",
            width: '100%'
        });
    }

    if(typeof $('[data-plugin="maskinput_hour"]')[0] != 'undefined'){
        $('[data-plugin="maskinput_hour"]').mask('99');
    }

    if(typeof $('[name="rendimento_hora"]')[0] != 'undefined'){
        $('[name="rendimento_hora"]').mask('99:99');
    }

    /* Rendimento */
    let modelBlockRendimentoTaxaSaque = $('.rendimento_block_taxa_saque').html();
    let modelBlockRendimentoMinSaque = $('.rendimento_block_minimo_saque').html();
    let modelBlockRendimentoLiberacao = $('.rendimento_block_horario_liberacao').html();

    /* Rede */
    let modelBlockRedeTaxaSaque = $('.rede_block_taxa_saque').html();
    let modelBlockRedeMinSaque = $('.rede_block_minimo_saque').html();
    let modelBlockRedeLiberacao = $('.rede_block_horario_liberacao').html();

    /* Rendimento */

    $(document).on('click', '.addRendimentoTaxaSaque', function(){

        $('.rendimento_block_taxa_saque:last').append(modelBlockRendimentoTaxaSaque);

    });

    $(document).on('click', '.addRendimentoMinimo', function(){

        $('.rendimento_block_minimo_saque:last').append(modelBlockRendimentoMinSaque);

    });

    $(document).on('click', '.addRendimentoHorarioLiberacao', function(){

        $('.rendimento_block_horario_liberacao:last').append(modelBlockRendimentoLiberacao);

    });

    /* Rede */

    $(document).on('click', '.addRedeTaxaSaque', function(){

        $('.rede_block_taxa_saque:last').append(modelBlockRedeTaxaSaque);

    });

    $(document).on('click', '.addRedeMinimo', function(){

        $('.rede_block_minimo_saque:last').append(modelBlockRedeMinSaque);

    });

    $(document).on('click', '.addRedeHorarioLiberacao', function(){

        $('.rede_block_horario_liberacao:last').append(modelBlockRedeLiberacao);

    });

    /* Grupos de Afiliados */

    let modelBlackGrupo = $('.grupoHTMLForm').html();

    $(document).on('click', '.addGrupos', function(){

        $('.grupoHTMLForm:last').append(modelBlackGrupo);

    });

    initMaskMoney();
});
$(document).ready(function(){

    $(document).on('click', '.visualizarComprovante', function(){

        let id = $(this).attr('data-id');
        let login = $(this).attr('data-login');

        $.ajax({
            url: baseURL+'ajax/admin_see_receipt',
            type: 'POST',
            data: {id: id, login: login},
            dataType: 'json',

            success: function(callback){
                
            },

            error: function(message){

                console.log('[Erro ao gravar log de visualização de comprovante]');
                console.log(message.responseText);
            }
        });
    });

    $(document).on('click', '.rejeitarComprovante', function(e){

        e.preventDefault();
        
        let url = $(this).attr('href');

        Swal.fire({
            title: 'Qual o motivo?',
            text: 'Informe o motivo da rejeição do comprovante. Esse motivo será informado para o usuário.',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Rejeitar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                
                window.location.href=url+'?motivo='+result.value;
            }
        })
    });
});
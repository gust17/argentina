$(document).ready(function(){

    $(document).on('click', '.estornarSaque', function(e){

        e.preventDefault();
        
        let url = $(this).attr('href');

        Swal.fire({
            title: 'Qual o motivo do estorno?',
            text: 'Informe o motivo do estorno. Esse motivo será informado para o usuário.',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Estornar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                
                window.location.href=url+'?motivo='+result.value;
            }
        })
    });
    
});
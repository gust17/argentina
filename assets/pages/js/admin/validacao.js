$(document).ready(function(){

    $(document).on('click', '.rejeitar', function(e){

        e.preventDefault();
        
        let url = $(this).attr('href');

        Swal.fire({
            title: 'Qual motivo da rejeição?',
            text: 'Informe o motivo da rejeição dos documentos para o usuário.',
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
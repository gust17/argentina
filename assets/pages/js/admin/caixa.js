$(document).ready(function(){
    initMaskMoney();

    $(document).on('click', '.addRegistro', function(){

        Swal.fire({
            title: 'Deseja continuar?',
            icon: 'question',
            text: 'Caso continue não será mais possível editar ou excluir o novo registro',
            showCancelButton: true,
            confirmButtonText: `Adicionar Registro`,
            cancelButtonText: `Cancelar`,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
          }).then((result) => {
              
            if (result.isConfirmed) {

                $(".formAddCaixa").submit(); 
            }
        })
    });
});
$(document).ready(function(){

    $(document).on('click', '.renovarContrato', function(){

        let id_plano = $(this).attr('data-id');

        Swal.fire({
            title: __TRANS_RENOVAR_CONTRATO_TITLE__,
            html: __TRANS_RENOVAR_CONTRATO_DESC__,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: __TRANS_RENOVAR_CONTRATO_CONFIRM__,
            cancelButtonText: __TRANS_RENOVAR_CONTRATO_CANCEL__
          }).then((result) => {
              
            if (result.isConfirmed) {

                $.ajax({
                    url: baseURL+'ajax/renovation_contract',
                    type: 'POST',
                    data: {id:id_plano},
                    dataType: 'json',

                    success: function(callback){

                        if(callback.status == 1){

                            createNotification(__TRANS_SUCESSO__, __TRANS_RENOVAR_OK__, 'check', 'success');

                        }else{
                            createNotification(__TRANS_ERRO__, __TRANS_RENOVAR_ERRO__+' '+callback.error, 'times', 'danger');
                        }

                        setTimeout(function(){
                            window.location.reload(1);
                         }, 2000);
                    },

                    error: function(message){

                        console.log(message.responseText);
                    }
                });
            }
        });

    });


    function atropos3d(elemento){
		const myAtropos = Atropos({
		el: elemento,
		activeOffset: 40,
		shadowScale: 1.05
		});
	}
	
	$('div[id^="label_"]').each(function(){

		var splitItem = $(this).attr('id').split('_');
		var nItem = splitItem[1];

		var elementoName = $(this).attr('id');
		$('#'+elementoName+' img').attr('src', baseURL+'assets/cliente/default/assets/images/icons/64px/'+nItem+'.svg');

		$('#'+elementoName+' .level').html('Level '+nItem);
		
		atropos3d('#'+elementoName);
	})

    $(document).on('click', '.btn-menu-adesao', function(){

        let idRef = $(this).attr('data-ref-id');

        $('.btn-menu-adesao').removeClass('active');
        $('.btn-menu-adesao[data-ref-id="'+idRef+'"]').addClass('active');

        $('.blockPlans').removeClass('d-block');
        $('.blockPlans').addClass('d-none');

        $('.blockPlans[data-ref-id="'+idRef+'"]').addClass('d-block');
        $('.blockPlans[data-ref-id="'+idRef+'"]').removeClass('d-none');
    });
});
$(document).ready(function(){

    if(tipo_cadastro == 1){
        $('[name="celular"]').mask('(99) 9.9999-9999');
        $('[name="documento"]').mask('999.999.999-99');
    }

    $("[name='cep']").blur(function() {

        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {

            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {

                $("[name='endereco']").val("...");
                $("[name='endereco']").attr('disabled', 'disabled');

                $("[name='bairro']").val("...");
                $("[name='bairro']").attr('disabled', 'disabled');

                $("[name='cidade']").val("...");
                $("[name='cidade']").attr('disabled', 'disabled');

                $("[name='estado']").val("...");
                $("[name='estado']").attr('disabled', 'disabled');

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        $("[name='endereco']").val(dados.logradouro);
                        $("[name='endereco']").removeAttr('disabled');

                        $("[name='bairro']").val(dados.bairro);
                        $("[name='bairro']").removeAttr('disabled');

                        $("[name='cidade']").val(dados.localidade);
                        $("[name='cidade']").removeAttr('disabled');
                        
                        $("[name='estado']").val(dados.uf);
                        $("[name='estado']").removeAttr('disabled');

                        $("[name='endereco']").focus();
                    }else{
                        
                        $("[name='endereco']").val("")
                        $("[name='endereco']").removeAttr('disabled');

                        $("[name='bairro']").val("");
                        $("[name='bairro']").removeAttr('disabled');

                        $("[name='cidade']").val("");
                        $("[name='cidade']").removeAttr('disabled');

                        $("[name='estado']").val("");
                        $("[name='estado']").removeAttr('disabled');

                        $("[name='cep']").focus();
                    }
                });
            }
        }
    });

    $('[name="nascimento"]').mask('99/99/9999');
});
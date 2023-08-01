<?php
function ListaBancos(){

    $bancos = array(
        '001'=>'Banco do Brasil',
        '033'=>'Banco Santander',
        '077'=>'Banco Inter',
        '104'=>'Caixa Econômica Federal',
        '121'=>'Agibank',
        '208'=>'BTG Pactual',
        '212'=>'Banco Original',
        '218'=>'Banco BS2',
        '237'=>'Banco Bradesco',
        '260'=>'Nu Pagamentos (Nubank)',
        '336'=>'C6 Bank',
        '341'=>'Banco Itaú',
        '422'=>'Banco Safra',
        '655'=>'Banco Votorantim',
        '735'=>'Neon Pagamentos',
        '748'=>'Sicredi',
        '756'=>'Bancoob',
        '000'=>'Outro'
    );

    return $bancos;
}

function BancoID($id){

    $bancos = ListaBancos();

    foreach($bancos as $codigo=>$nome){

        if($codigo == $id){

            return $nome;
        }
    }
}
<?php
function InverseDate($data, $dividerDate = '/', $newDivider = '-'){

    return implode($newDivider, array_reverse(explode($dividerDate, $data)));
}

function DiasSemana(){

    $dias = array(
        0=>'Domingo',
        1=>'Segunda-Feira',
        2=>'Terça-Feira',
        3=>'Quarta-Feira',
        4=>'Quinta-Feira',
        5=>'Sexta-Feira',
        6=>'Sábado'
    );

    return $dias;
}

function DiasUteis($data, $dias){

    $add = 0;

    $lastDay = date('Y-m-d', (strtotime($data)+(60*60*24*$dias)));
    $lastDayInTime = strtotime($lastDay);

    if(date('w', $lastDayInTime) == 6){
        $add += 2;
    }elseif(date('w', $lastDayInTime) == 0){
        $add += 1;
    }

    return date('Y-m-d', (strtotime($data)+(60*60*24*($add+$dias))));
}

function LiberacaoDiasUteis($data, $dias){

    $add = 0;

    for($i = 0; $i<=$dias-1; $i++){

        $dataAtual = date('Y-m-d', (strtotime($data)+(60*60*24*$i)));
        $dataSemanaAtual = date('w', strtotime($dataAtual));

        if($dataSemanaAtual == 0 || $dataSemanaAtual == 6){
            $add++;
        }

        $add++;
    }

    return date('Y-m-d', (strtotime($data)+(60*60*24*$add)));
}

function MesExtenso($mes, $abv = false){

    $meses = array(
        1 => 'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );

    $meses_abv = [1=>'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    if(!$abv){
        return $meses[$mes];
    }

    return $meses_abv[$mes];

}

function SemanaExtenso($semana, $abv = false){
    
    $dias_da_semana = array(
        'Domingo',
        'Segunda-Feira',
        'Terça-Feira',
        'Quarta-Feira',
        'Quinta-Feira',
        'Sexta-Feira',
        'Sábado'
    );

    $dias_da_semana_abv = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];

    if(!$abv){
        return $dias_da_semana[$semana];
    }

    return $dias_da_semana_abv[$semana];
}
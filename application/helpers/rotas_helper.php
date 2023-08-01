<?php
function MinhasRotas($resultado = 'ALL', $identificador = ''){

    $_this=& get_instance();

    if($resultado == 'ALL'){

        $arr = [];

        $query = $_this->db->get('configuracoes_rotas');

        foreach($query->result() as $result){

            $arr[$result->link_identificacao] = $result->route;
        }

        return (object)$arr;
    
    }else{

        $_this->db->where('link_identificacao', $identificador);
        $query = $_this->db->get('configuracoes_rotas');

        return $query->row()->route;
    }
}

function CheckInitializeRoutes($funcao, $classe, $admin = false){

    $real = '';

    if($admin){
        $real .= 'admin/';
    }

    $rota = rtrim(strtolower(uri_string()), '/');

    $real .= strtolower($classe);
    
    if($funcao != 'index'){
        $real .= '/'.strtolower($funcao);
    }

    if($rota == $real){
        show_404();
    }
}
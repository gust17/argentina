<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bankon{

    public $token_consulta;
    public $token_transacao;

    public function __construct(){

        $this->token_consulta = SystemInfo('token_bankon_consulta');
        $this->token_transacao = SystemInfo('token_bankon_transferencia');
    }

    public function ConsultarUsuario($usuario){

        $usuario = trim($usuario);
        $usuario = preg_replace('/[^a-zA-Z0-9]/', '', $usuario);

        $curl = curl_init();
        curl_setopt_array($curl, array(    
            CURLOPT_URL => "https://api.bankon.com.br/v1/consultas/usuario/".$usuario,    
            CURLOPT_RETURNTRANSFER => true,    
            CURLOPT_ENCODING => "",    
            CURLOPT_MAXREDIRS => 10,    
            CURLOPT_TIMEOUT => 0,    
            CURLOPT_FOLLOWLOCATION => false,    
            CURLOPT_HTTP_VERSION => 
            CURL_HTTP_VERSION_1_1,    
            CURLOPT_CUSTOMREQUEST => "GET",    
            CURLOPT_HTTPHEADER => array(      
            "Content-Type: application/json",      
            "Authentication: ".$this->token_consulta    
            ),  
        ));    
        $response = curl_exec($curl);  
        $err = curl_error($curl);    
        curl_close($curl);    

        if ($err) {
            return false;
        }

        return json_decode($response);
    }

    public function ConsultarTransacao($transacao){

        $transacao = trim($transacao);
        $transacao = preg_replace('/[^a-zA-Z0-9]/', '', $transacao);

        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.bankon.com.br/v1/consultas/transferencias/".$transacao,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authentication: ".$this->token_consulta
        ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return false;
        }

        return json_decode($response);
    }

    public function FazerTransferencia($usuario, $valor, $idTransacao){

        $data_string = json_encode(
        array(
            'beneficiario'=> $usuario ,
            'valor'=> $valor,
            'id_transferencia'=> $idTransacao
        )
        );
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.bankon.com.br/v1/financeiro/transferencia',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            'Content-Length: ' . strlen( $data_string ),
            "Authentication: ".$this->token_transacao
        ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return false;
        }
    
        $decodeResponse = json_decode($response);
    
        if($decodeResponse->sucesso){
            return true;
        }
        return false;
    }
}
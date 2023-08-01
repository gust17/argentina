<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simplepay{

    public $token;
    public $token_transacao;

    public function __construct(){

        $this->token = SystemInfo('token_simplepay');
    }

    function ConsultarUsuario($usuario){

        $_this =& get_instance();
      
        $token = $this->token;
      
        $usuario = trim($usuario);
        $usuario = preg_replace('/[^a-zA-Z0-9]/', '', $usuario);
      
        $curl = curl_init();
        curl_setopt_array($curl, array(    
          CURLOPT_URL => "https://api.simplepay.credit/v1/conta/validar",    
          CURLOPT_RETURNTRANSFER => true,    
          CURLOPT_ENCODING => "",    
          CURLOPT_MAXREDIRS => 10,    
          CURLOPT_TIMEOUT => 0,    
          CURLOPT_FOLLOWLOCATION => true,    
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,    
          CURLOPT_CUSTOMREQUEST => "POST",   
          CURLOPT_POSTFIELDS => array('conta' => $usuario,'documento' => '123.456.789-10')  
        ));    
        $response = curl_exec($curl);  
        
      
        $err = curl_error($curl);    
        curl_close($curl);    
      
        if ($err) {    
          
          return false;
      
        }
      
        return json_decode($response);
      
    }
      
    function ConsultarTransacao($transacao){
      
        $transacao = trim($transacao);
        $transacao = preg_replace('/[^a-zA-Z0-9]/', '', $transacao);
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.simplepay.credit/v1/conta/consulta_transacao",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('api_key' => $this->token,'transacao' => $transacao)
        ));
        
        $response = curl_exec($curl);
    
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return false;
        }
    
        return json_decode($response);
    }
      
    function FazerTransferencia($usuario, $valor){
      
        $data_string = array(
            'api_key'=>$this->token,
            'conta' => $usuario,
            'valor' => $valor
        );
      
        $curl = curl_init();
      
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.simplepay.credit/v1/transferencia/automatica',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $data_string
        ));
        
        $response = curl_exec($curl);
      
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          
          return false;
      
        }else{
      
          $decodeResponse = json_decode($response);
      
          if(isset($decodeResponse->success) &&  $decodeResponse->success == 'true'){
      
            return true;
          }
      
          return false;
        }
    }
}
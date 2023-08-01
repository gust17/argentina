<?php
class Pix{

    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_POINT_OF_INITIATION_METHOD = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_ACCOUNT_INFORMATION_URL = '25';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    private $pixKey;
    private $merchantName;
    private $merchantCity;
    private $description;
    private $txid;
    private $amount;
    private $uniquePayment = false;
    private $urlDynamicPayload;

    private $baseURL;
    private $clientID;
    private $clientSecret;
    private $certificate;

    public function __construct(){

        $this->baseURL = 'https://api-pix.gerencianet.com.br';
        $this->clientID = SystemInfo('gerencianet_client_id');
        $this->clientSecret = SystemInfo('gerencianet_client_secret');
        $this->certificate = APPPATH.'third_party/pix/gerencianet.pem';
    }

    private function getAccessToken(){

        $endpoint = $this->baseURL.'/oauth/token';

        $headers = [
            'Content-type: application/json'
        ];

        $request = [
            'grant_type'=>'client_credentials'
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_USERPWD => $this->clientID.':'.$this->clientSecret,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_SSLCERT => $this->certificate,
            CURLOPT_SSLCERTPASSWD => '',
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $responseArray = json_decode($response, true);

        return $responseArray['access_token'] ?? '';
    }

    private function sendRequest($method, $resource, $request = []){

        $endpoint = $this->baseURL.$resource;

        $headers = [
            'Cache-control: no-cache',
            'Content-type: application/json',
            'Authorization: Bearer '.$this->getAccessToken()
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSLCERT => $this->certificate,
            CURLOPT_SSLCERTPASSWD => '',
            CURLOPT_HTTPHEADER => $headers
        ]);

        switch($method){

            case 'POST':
            case 'PUT':
                curl_setopt_array($curl, [
                    CURLOPT_POSTFIELDS => json_encode($request)
                ]);
            break;
        }

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function setPixKey($key){

        $this->pixKey = $key;

        return $this;
    }

    public function setUniquePayment($uniquePayment){

        $this->uniquePayment = $uniquePayment;

        return $this;
    }

    public function setUrlDynamicPayload($url){

        $this->urlDynamicPayload = $url;

        return $this;
    }

    public function setMerchantName($merchantName){

        $this->merchantName = $merchantName;

        return $this;
    }

    public function setMerchantCity($merchantCity){

        $this->merchantCity = $merchantCity;

        return $this;
    }

    public function setTxid($txid){

        $this->txid = $txid;

        return $this;
    }

    public function setDescription($description){

        $this->description = $description;

        return $this;
    }

    public function setAmount($amount){

        $this->amount = number_format($amount, 2, '.', '');

        return $this;
    }

    private function constructCode($id, $value){

        $size = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);

        return $id.$size.$value;
    }

    private function getUniquePayment(){

        return $this->uniquePayment ? $this->constructCode(self::ID_POINT_OF_INITIATION_METHOD, '12') : '';
    }

    private function getMerchantAccountInformation(){

        $gui = $this->constructCode(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'br.gov.bcb.pix');
        $key = strlen($this->pixKey) ? $this->constructCode(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixKey) : '';

        $description = strlen($this->description) ? $this->constructCode(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->description) : '';

        $urlDynamicPayload = strlen($this->urlDynamicPayload) ? $this->constructCode(self::ID_MERCHANT_ACCOUNT_INFORMATION_URL, preg_replace('/ˆhttps?\:\/\//', '', $this->urlDynamicPayload)) : '';
        
        return $this->constructCode(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui.$key.$description.$urlDynamicPayload);
    }

    private function getAdditionalDataFieldTemplate(){

        $txid = $this->constructCode(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->txid);

        return $this->constructCode(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    private function getCRC16($payload) {
        
        $payload .= self::ID_CRC16.'04';
  
        $polinomio = 0x1021;
        $resultado = 0xFFFF;
  
        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }
  
        return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
    }

    public function getCode(){

        $payload = $this->constructCode(self::ID_PAYLOAD_FORMAT_INDICATOR, '01').
                   $this->getUniquePayment().
                   $this->getMerchantAccountInformation().
                   $this->constructCode(self::ID_MERCHANT_CATEGORY_CODE, '0000').
                   $this->constructCode(self::ID_TRANSACTION_CURRENCY, '986').
                   $this->constructCode(self::ID_TRANSACTION_AMOUNT, $this->amount).
                   $this->constructCode(self::ID_COUNTRY_CODE, 'BR').
                   $this->constructCode(self::ID_MERCHANT_NAME, $this->merchantName).
                   $this->constructCode(self::ID_MERCHANT_CITY, $this->merchantCity).
                   $this->getAdditionalDataFieldTemplate();

        return $payload.$this->getCRC16($payload);
    }

    public function createCharge($txID, $request){

        return $this->sendRequest('PUT', '/v2/cob/'.$txID, $request);
    }

    public function consultCharge($txID){

        return $this->sendRequest('GET', '/v2/cob/'.$txID);
    }
}
<?php
class Asaas
{

    protected $token;
    protected $url;
    protected $userid;
    public $ci;

    public function __construct()
    {

        $this->ci = &get_instance();

        $this->userid = $this->ci->session->userdata('myuserid');

        $this->url = 'https://www.asaas.com';
        $this->token = SystemInfo('asaas_token');
    }

    public function sendRequest($uri, $data = [], $post = TRUE)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, $post);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . $this->token
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public function createClient($data)
    {

        $clientID = UserInfo('code_client_asaas');

        if (is_null($clientID)) {

            $create = $this->sendRequest('/api/v3/customers', $data, true);

            if (isset($create->id)) {

                $this->ci->db->where('id', $this->userid);
                $this->ci->db->update('usuarios_cadastros', array(
                    'code_client_asaas' => $create->id
                ));

                return $create->id;
            }

            return $create->errors;
        }

        return $clientID;
    }

    public function createBilling($data)
    {

        $create = $this->sendRequest('/api/v3/payments', $data, true);

        if (isset($create->id)) {

            return $create;
        }

        return $create->errors ?? false;
    }

    public function createQRCodePix($idBilling)
    {

        $qrcode = $this->sendRequest('/api/v3/payments/' . $idBilling . '/pixQrCode', [], false);

        if (isset($qrcode->encodedImage)) {

            return [
                'base64' => $qrcode->encodedImage,
                'cc' => $qrcode->payload,
            ];
        }

        return false;
    }

    public function transferPix($key, $type, $value)
    {

        if ($type == 'CPF' || $type == 'CNPJ' || $type == 'PHONE') {
            $key = preg_replace('/[^0-9]/', '', $key);
        }

        $transfer = $this->sendRequest('/api/v3/transfers', [
            'value' => $value,
            'pixAddressKey' => $key,
            'authorized' => true,
            'scheduleDate' => null,
            'pixAddressKeyType' => $type,
            'description' => 'Meu Pagamento para o Pix ' . $key
        ]);

        return $transfer;
    }
}

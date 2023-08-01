<?php (! defined('BASEPATH')) and exit('No direct script access allowed');

class Telegram{

    public function SendMessageTelegram($message){

        $habilitar = SystemInfo('habilitar_telegram');

        if($habilitar){

            $chatID = SystemInfo('chatid_telegram');
            $token = SystemInfo('token_telegram');

            $message = '['.$_SERVER['HTTP_HOST'].'] '.PHP_EOL.$message;
        
            $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
            $url = $url . "&text=" . urlencode($message);
            $ch = curl_init();
            $optArray = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true
            );
            curl_setopt_array($ch, $optArray);
            $result = curl_exec($ch);
            $result = json_decode($result);
            curl_close($ch);
            
            if(isset($result->ok) && $result->ok == 'true'){

                return true;
            }

            return false;
        }

        return false;
    }
}
<?php
class Push
{

    public function __construct()
    {

        $this->url = 'https://api.pushalert.co';
        $this->token = '2aeb1d5f520c84c627e8124191b01f0e';
    }

    public function _request($endpoint, $data, $post = true)
    {

        $url = $this->url . $endpoint;

        $headers = array();
        $headers[] = "Authorization: api_key=" . $this->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        $output = json_decode($result, true);
        if ($output["success"]) {
            echo $output["id"];
        } else {
            return false;
        }
    }

    public function send($title, $message, $url, $subscriber = false)
    {

        $post = array(
            "title" => $title,
            "message" => $message,
            "url" => $url
        );

        if ($subscriber !== false) {

            $post['subscriber'] = $subscriber;
        }

        $request = $this->_request('/rest/v1/send', $post);

        return $request;
    }
}

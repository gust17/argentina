<?php (! defined('BASEPATH')) and exit('No direct script access allowed');

/**
 * CodeIgniter Recaptcha library
 *
 * @package CodeIgniter
 * @author  Bo-Yi Wu <appleboy.tw@gmail.com>
 * @link    https://github.com/appleboy/CodeIgniter-reCAPTCHA
 */
class Recaptcha
{
    /**
     * ci instance object
     *
     */
    private $_ci;

    /**
     * reCAPTCHA site up, verify and api url.
     *
     */
    const sign_up_url = 'https://www.google.com/recaptcha/admin';
    const site_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    const api_url = 'https://www.google.com/recaptcha/api.js';
    const useCURL = true;

    /**
     * constructor
     *
     * @param string $config
     */
    public function __construct()
    {
        $this->_ci = & get_instance();
        $this->_siteKey = SystemInfo('recaptcha_site_key');
        $this->_secretKey = SystemInfo('recaptcha_secret_key');

        if (empty($this->_siteKey) or empty($this->_secretKey)) {
            die("To use reCAPTCHA you must get an API key from <a href='"
                .self::sign_up_url."'>".self::sign_up_url."</a>");
        }
    }

    /**
     * Submits an HTTP GET to a reCAPTCHA server.
     *
     * @param array $data array of parameters to be sent.
     *
     * @return array response
     */
    private function _submitHTTPGet($data)
    {
        $url = self::site_verify_url;
        
        if( self::useCURL === false ) {
            $response = file_get_contents($url);
        } else {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

            $response = curl_exec($ch);
            curl_close($ch);
        }

        return $response;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param string $response response string from recaptcha verification.
     * @param string $remoteIp IP address of end user.
     *
     * @return ReCaptchaResponse
     */
    public function verifyResponse($token, $action, $remoteIp = null)
    {
        $remoteIp = (!empty($remoteIp)) ? $remoteIp : $this->_ci->input->ip_address();

        // // Discard empty solution submissions
        // if (empty($response)) {
        //     return array(
        //         'success' => false,
        //         'error-codes' => 'missing-input',
        //     );
        // }

        $getResponse = $this->_submitHttpGet(
            array(
                'secret' => $this->_secretKey,
                'response' => $token,
            )
        );

        // get reCAPTCHA server response
        $responses = json_decode($getResponse, true);

        if ($responses["success"] == true && $responses["action"] == $action && $responses["score"] >= 0.5) {
            $status = true;
        } else {
            $status = false;
            $error = (isset($responses['error-codes'])) ? $responses['error-codes']
                : 'invalid-input-response';
        }

        return array(
            'success' => $status,
            'error-codes' => (isset($error)) ? $error : null,
        );
    }

    /**
     * Render Script Tag
     *
     * onload: Optional.
     * render: [explicit|onload] Optional.
     * hl: Optional.
     * see: https://developers.google.com/recaptcha/docs/display
     *
     * @param array parameters.
     *
     * @return scripts
     */
    public function getScriptTag(array $parameters = array())
    {
        $default = array(
            'render' => $this->_siteKey,
        );

        $result = array_merge($default, $parameters);

        $scripts = sprintf('<script src="%s?%s"></script>',
            self::api_url, http_build_query($result));

        return $scripts;
    }

    /**
     * render the reCAPTCHA widget
     *
     * data-theme: dark|light
     * data-type: audio|image
     *
     * @param array parameters.
     *
     * @return scripts
     */
    public function getWidget($form)
    {
        return "<script>grecaptcha.ready(function() { grecaptcha.execute('".$this->_siteKey."', {action: '".$form."'}).then(function(token) { $('#".$form."').prepend(\"<input type='hidden' name='token' value=\"+ token + \">\"); $('#".$form."').prepend(\"<input type='hidden' name='action' value='".$form."'>\")}); });</script>";

        // $default = array(
        //     'data-sitekey' => $this->_siteKey,
        //     'data-theme' => 'light',
        //     'data-type' => 'image',
        //     'data-size' => 'normal',
        // );

        // $result = array_merge($default, $parameters);

        // $html = '';
        // foreach ($result as $key => $value) {
        //     $html .= sprintf('%s="%s" ', $key, $value);
        // }

        // return '<div align="'.$this->_align.'"><div class="g-recaptcha" '.$html.'></div></div> <br />';
    }
}
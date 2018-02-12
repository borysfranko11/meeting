<?php
//require_once '$this->Https.php';
//include_once("Error.php");
namespace App\Libs;

use App\Libs\Http;

class EveClient {

    const REDIRECT_URL = "http://www.yii.com/sdk/test.php";
    
    private $_access_token_url;
    private $_authorize_url;
    private $client_id;
    private $client_secret;
    private $access_token;
    private $refresh_token;
    private $security_code;
    public  $Http;

    public function __construct($client_id = '', $client_secret = '', $security_code = '') {
        if (empty($client_id) || empty($client_secret) || empty($security_code)) {
            return false;
        }
        //$this->CI =& get_instance();
        //$this->CI->config->load('links', true);
        $openApiUrl = config('links.open_api_url');
        $this->_access_token_url = $openApiUrl . '/oauth2/token';
        $this->_authorize_url    = $openApiUrl . '/oauth2/authorize';
        $this->client_id         = $client_id;
        $this->client_secret     = $client_secret;
        $this->security_code     = $security_code;
        $this->Http = new Http();
    }

    public function getToken() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "response_type" => 'code',
            "state"         => 'fdsafdsaf',
            'redirect_uri'  => self::REDIRECT_URL,
        );
        $result    = $this->Http->get($this->_authorize_url, $parameter);
        return $result;
    }

    /**
     * 通过code获取token
     */
    public function getTokenByCode($code) {
        $parameter           = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => 'authorization_code',
            "state"         => 'fdsafdsaf',
            'code'          => $code,
            'redirect_uri'  => self::REDIRECT_URL,
        );
        $result              = $this->Http->httppost($this->_access_token_url, $parameter);
        $result              = json_decode($result, true);
        $this->access_token  = $result['access_token'];
        $this->refresh_token = $result['refresh_token'];
        return $this->access_token;
    }

    //获取刷新token
    public function getRefreshToken() {
        return $this->refresh_token;
    }

    /**
     * 简单模式授权
     */
    public function getTokenImplicit() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "response_type" => 'token',
            "state"         => 'fdsafdsaf',
            'redirect_uri'  => self::REDIRECT_URL,
        );
        try {
            $result             = $this->Http->get($this->_authorize_url, $parameter);
            $result             = $this->LocationParseUrlFragment($result);
            $this->access_token = $result['access_token'];
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $this->access_token;
    }

    public function authorize() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "response_type" => 'code',
            "state"         => 'fdsafdsaf',
            'redirect_uri'  => self::REDIRECT_URL,
        );
        $result    = $this->Http->get($this->_authorize_url, $parameter);
        return $result;
    }

    public function getCode() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "response_type" => 'code',
            "state"         => 'fdsafdsaf',
            'redirect_uri'  => self::REDIRECT_URL,
        );
        try {
            $result = $this->Http->get($this->_authorize_url, $parameter);
            $result = $this->LocationParseUrlQuery($result);
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $result['code'];
    }

    /**
     *
     * 解析Query
     */
    public function LocationParseUrlQuery($result) {
        try {
            $headArr = explode("\r\n", $result);
            foreach ($headArr as $loop) {
                if (strpos($loop, "Location") !== false) {
                    $edengUrl = trim(substr($loop, 10));
                }
            }
            $urlarr = parse_url($edengUrl);
            parse_str($urlarr['query'], $parr);
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $parr;
    }

    /**
     *
     * 解析Fragment
     */
    public function LocationParseUrlFragment($result) {
        try {
            $headArr = explode("\r\n", $result);
            foreach ($headArr as $loop) {
                if (strpos($loop, "Location") !== false) {
                    $edengUrl = trim(substr($loop, 10));
                }
            }
            $urlarr = parse_url($edengUrl);
            parse_str($urlarr['fragment'], $parr);
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $parr;
    }

    private function getAccessToken() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => 'token',
        );
        try {
            $result = json_decode($this->Http->post($this->_access_token_url, $parameter));
            if (isset($result->error)) {
                $error = $result->error;
                throw new EveException($error->description, $error->code);
            }
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $result;
    }

    public function refreshToken($refresh_token) {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => 'refresh_token',
            //"refresh_token" => $this->refresh_token
            "refresh_token" => $refresh_token,
        );
        try {
            $result = json_decode($this->Http->httppost($this->_access_token_url, $parameter));

            if (isset($result->error)) {
                $error = $result->error;
                throw new EveException(0, 0);
            }
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        return $result->access_token;
    }


    public function credentials() {
        $parameter = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => 'client_credentials',
            //"refresh_token" => $this->refresh_token
        );
        try {
            $result = json_decode($this->Http->httppost($this->_access_token_url, $parameter));
            if (isset($result->error)) {
                $error = $result->error;
                throw new EveException($error->description, $error->code);
            }
        } catch (EveException $e) {
            echo $e->getError();
            exit;
        }
        $this->access_token  = $result->access_token;
        $this->refresh_token = $result->refresh_token;
        return $this->access_token;
    }


    /**
     * 签名
     *
     * @param $params 业务参数
     *
     * @return void
     */
    public function generateSign($params = null) {
        if ($params != null) {
            ksort($params);
            $stringToBeSigned = $this->client_id;
			/**
            foreach ($params as $k => $v) {
                $stringToBeSigned .= "$k$v";
            }*/
			$stringToBeSigned .= json_encode($params);
            unset($k, $v);
            $stringToBeSigned .= $this->client_secret;
            $stringToBeSigned .= $this->security_code;
        } else {
            $stringToBeSigned = $this->client_id;
            $stringToBeSigned .= $this->client_secret;
            $stringToBeSigned .= $this->security_code;
        }
        return strtoupper(md5($stringToBeSigned));
        //return $this->mhash($stringToBeSigned);
    }

    private function mhash($string) {
        return base64_encode(hash_hmac('sha1', $this->getBaseString(), $string, true));
    }

    /**
     *
     */
    private function getBaseString() {
        return "huitang";
    }
}

?>

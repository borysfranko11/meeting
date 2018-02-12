<?php
namespace App\Libs;
class Http
{
	/**
	 * GET
	 * @param $url 目标URL
	 * @param $parameters 参数(key=>value)
	 * return string
	 */
	 public function get($url,$parameters=array()) {
		return self::request('GET',$url,$parameters);
	}
	/**
	 * POST
	 * @param $url 目标URL
	 * @param $parameters 参数(key=>value)
	 * return string
	 */
	 public function post($url,$parameters=array()) {
		return self::request('POST',$url,$parameters);
	}

	public  function request($method, $url, $params =  array()) {
		$str_params = http_build_query($params);
		$ch = curl_init();
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $str_params);
		} else
			$url .= '?' . $str_params;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);    //表示需要response header
		//curl_setopt($ch, CURLOPT_NOBODY, 0); //表示需要response body
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		if (!$output){
			return (false);
		}else {
			curl_close($ch);
			return $output;
		}
	}
	public function httpget($reurl='',$rearray=array(),$access_token=null) {
		if (empty($reurl)) {
			return (false);
		}
		$restring = http_build_query($rearray);
		$ch = curl_init() ;
		if($access_token!=''){
			$header[] = 'Authorization: OAuth '.$access_token;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		curl_setopt($ch, CURLOPT_HEADER, false);    //表示需要response header
		//curl_setopt($ch, CURLOPT_NOBODY, 0); //表示需要response body
		curl_setopt($ch, CURLOPT_URL, $reurl.$restring);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//curl_setopt($ch, CURLOPT_USERAGENT, 'LightPass/X1 (With CURL)');
		$output = curl_exec($ch);
		if (!$output){
			return (false);
		}else {
			curl_close($ch);
			return $output;
		}
	}
	public function httppost($reurl='',$rearray=array(''),$access_token=null){
		if (empty($reurl) || empty($rearray)) {
			return (false);
		}
		$post_data = $rearray;
		$ch = curl_init();
		if($access_token!=''){
			$header[] = 'Authorization: OAuth '.$access_token;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		curl_setopt($ch, CURLOPT_URL, $reurl);
		//curl_setopt($ch, CURLOPT_HEADER, 1);    //表示需要response header
		//curl_setopt($ch, CURLOPT_NOBODY, 0); //表示需要response body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($ch, CURLOPT_USERAGENT, 'LightPass/X1 (With CURL)');
		$output = curl_exec($ch);
		if (!$output){
			return (false);
		}else {
			curl_close($ch);
			return $output;

		}
	}

	/**
	 * GET
	 * @param $url 目标URL
	 * @param $parameters 参数(key=>value)
	 * return string
	 */
	 public function z_get($url,$parameters=array()) {
		return self::z_request('GET',$url,$parameters);
	}
	/**
	 * POST
	 * @param $url 目标URL
	 * @param $parameters 参数(key=>value)
	 * return string
	 */
	 public function z_post($url,$parameters=array()) {
		return self::z_request('POST',$url,$parameters);
	}

	public  function z_request($method, $url, $params =  array()) {
		$str_params = http_build_query($params);
		$ch = curl_init();
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $str_params);
		} else
			$url .= '?' . $str_params;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($ch, CURLOPT_HEADER, 1);    //表示需要response header
		//curl_setopt($ch, CURLOPT_NOBODY, 0); //表示需要response body
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		if (!$output){
			return (false);
		}else {
			curl_close($ch);
			return $output;
		}
	}


}
?>

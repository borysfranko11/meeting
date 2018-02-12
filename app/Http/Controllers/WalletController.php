<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use DB;

class WalletController extends Controller
{
    /**
     * 钱包首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $this -> _Wallet   = new Wallet();
        $card = $this -> _Wallet -> getDatas();

        return view( '/wallet/index', ['card'=> $card]);
    }

    public function binding(){
        $url = config( 'system.wallet' );
        $uri = 'api/Area';
        $url = $url.$uri;

        $searchData = [];
        $header = $this->setHeader($searchData);
        $area = doCurlPostRequest($url, $searchData, $header);
        $area = json_decode($area, true);

        $areaArr = isset($area['data']) && !empty($area['data']) ? $area['data'] : [];

        $url = config( 'system.wallet' );
        $uri = 'api/Bank';
        $url = $url.$uri;

        $searchData = [];
        $header = $this->setHeader($searchData);
        $bank = doCurlPostRequest($url, $searchData, $header);
        $bank = json_decode($bank, true);

        $bankArr = isset($bank['data']) && !empty($bank['data']) ? $bank['data'] : [];

        return view( '/wallet/binding', [
            'area' => $areaArr,
            'bank' => $bankArr,
        ]);
    }

    public function bindingCard( Request $request ){
        $this -> _Wallet   = new Wallet();
        $reqs = $request -> except('_token');
        $paramStr = $reqs['param']['data'];
        $paramArr = explode('&', $paramStr);
        $params = [];
        foreach($paramArr AS $key => $value){
            $ex = explode('=', $value);
            $params[$ex[0]] = $ex[1] ? urldecode($ex[1]) : '';
        }
        $params['account_id']   = config( 'system.account_id' );
        $params['account_type'] = 1;
        $params['id_type'] = 0;
        $params['create_time'] = time();

        $inParams = $params;

        $url = config( 'system.wallet' );
        $uri = 'api/Bind';
        $url = $url.$uri;
        $header = $this->setHeader($params);
        $bank = doCurlPostRequest($url, $params, $header);

        $bankRes = json_decode($bank, true);

        if($bankRes['data'] === true ){
            $this -> _Wallet->insertDatas($inParams);
        }

        echo $bank;exit;
    }

    public function getArea( Request $request ){

        $reqs = $request -> except('_token');

        $url = config( 'system.wallet' );
        $uri = 'api/Area';
        $url = $url.$uri;

        $searchData['cityId'] = $reqs['cityId'];
        $header = $this->setHeader($searchData);
        $res = doCurlPostRequest($url, $searchData, $header);

        echo $res;
        exit();
    }
    public function getBank( Request $request ){

        $reqs = $request -> except('_token');

        $url = config( 'system.wallet' );
        $uri = 'api/Bank';
        $url = $url.$uri;

        $data = [];
        $header = $this->setHeader($data);
        $res = doCurlPostRequest($url, $data, $header);

        echo $res;
        exit();
    }
    //public function resetting( Request $request ){
    public function resetting( Request $request  ){
        $reqs   = $request -> except('_token');
        $url    = config( 'system.wallet' );
        $uri    = 'api/deposit';
        $url    = $url.$uri;

        $data   = [];
        $data['type']               = 1;
        $data['money']              = isset($reqs['money'])?$reqs['money']:0;
        $data['payer_id']           = config( 'system.account_id' );
        $data['product_name']       = '大企业充值';
        $data['product_desc']       = '大企业充值'.$reqs['money'];
        $data['receive_url']        = 'http://qa.meetingv2.eventown.com/Wallet/callback';
        $data['pickup_url']         = 'http://qa.meetingv2.eventown.com/Wallet/callback';

        $header = $this->setHeader($data);

        $res = doCurlPostRequest($url, $data, $header);
        print_r($res);exit;
    }
    public function callBack(){
        return view( '/wallet/callback');
    }
    public function getMoney(){
        $url    = config( 'system.wallet' );
        $uri    = 'api/account/getMoney';
        $url    = $url.$uri;

        $data['account_id'] = config( 'system.account_id' );
        $header = $this->setHeader($data);
        $res = doCurlPostRequest($url, $data, $header);
        echo $res;exit;
    }

    public function withdrawals( Request $request ){
        $reqs   = $request -> except('_token');

        $url    = config( 'system.wallet' );
        $uri    = 'api/withdrawals';
        $url    = $url.$uri;

        $data['money']      = $reqs['param'];
        $data['launch_account_id'] = config( 'system.account_id' );

        $header = $this->setHeader($data);
        $res    = doCurlPostRequest($url, $data, $header);
        echo $res;exit;
    }

    /*private function setHeader( $data ){
        $secret = 'aea9857bd96b712f7777292aa493cecd'; // API分配的秘钥
        $token = '';
        $appName = 'eventown.com';  // 在API分配的APP名字
        if($data){
            foreach ($data as $d) {
                $token .= $d; // 拼接请求参数
            }
        }

        $token .= $appName; // 拼接请求APP名字
        $token .= $secret;  // 拼接API分配的秘钥
        $token = hash('SHA256', $token);
        $header = array(
            'token:'.$token,
            'app:'.$appName,

        );

        return $header;
    }*/
    public function checkPass( Request $request ){
        $reqs       = $request -> except('_token');
        $passWord   = config( 'system.account_pass' );
        $pass       =  $reqs['param'];
        if($passWord == $pass){
            echo 1;exit;
        }else{
            echo 0;exit;
        }
    }
    public function pay( Request $request ){
        $reqs       = $request -> except('_token');

        if($reqs['password'] != config( 'system.account_pass' )){
            echo '{ "errorno": 10102,"msg": "交易密码不正确", "data": []}';exit;
        }
        //if($reqs['type'] == 1){
            $url    = config( 'system.wallet' );
            $uri    = 'api/payment';
            $url    = $url.$uri;

            $data['money']          = $reqs['money'];
            $data['payer_id']       = config( 'system.account_id' );
            $data['order_no']       = $reqs['order_no'];
            $data['recieve_id']     = 1000001;//$reqs['recieve_id'];
            $data['product_name']   = $reqs['product_name'];
            $data['product_desc']   = $reqs['product_desc'];

            $header = $this->setHeader($data);
            $res    = doCurlPostRequest($url, $data, $header);
            echo $res;exit;
        //}

    }

}

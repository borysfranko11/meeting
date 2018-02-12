<?php
/**
 * des: 询单逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Log;
use App\Models\Servers;
use App\Models\RfpLink;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\EveClient;
use App\Libs\Http;
use App\Libs\Dinner;
use QrCode;
//use Illuminate\Support\Facades\DB;

class BookdinnerController extends Controller
{

    private $privateKeyPathWJ = '/rsa_private_key.txt';
    private $publicKeyPathWJ = '/rsa_public_key.txt';
    public function __construct()
    {
        parent::__construct();

        $this -> EveClient      = new EveClient();
        $this -> _Logs          = new Logs();
        $this -> Http           = new Http();
        $this -> Dinner         = new Dinner();

    }

    public function userAdd( Request $request ){
        $reqs = $request -> except( '_token' );

        $timer = time();
        $content = [
            "entId" => 23072,
            "staffInfos" => [
                0 => [
                    "phone" => "15201013730",
                    "name" => "老王",
                    "email" => "liying_wang@eventown.com",
                    "entStaffNum" => "Eventown001",
                    "department" => "研发",
                    "budgetOrgName" => "北京总部",
                    "useEntBalance" => 0,
                    "baseCredit" => "10000",
                    "tripBaseCredit" => "10000",
                    "applyTempCredit" => 0,
                    "confirmPay" => 0,
                    "notifyPay" => 0,
                    "authEntStaffNum" => "A00001",
                    "notifyPhone" => "15201013730",
                    "notifyMail" => "liying_wang@eventown.com",
                    "city" => "北京"
                ],
            ],
            "sign" => "oHQvlciB7N9A09LUwHxt6A==",
            "ts" => $timer
        ];
        $content = json_encode( $content );
        $token = 'ZHONGQINGLV-POS';
        $version = '1.0';
        $key = 'Z52ajDgwUjWt5FQMc4kbqQ==';
        $contentEn = $this -> Dinner -> encrypt( $content,  $key);

        $param = [
            'content' => $contentEn,
            'token' => $token,
            'version' => $version
        ];
        $url = 'http://b.51ping.com/openapi/addStaff?token='.$token.'&content='.$contentEn.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        dd($request);

    }
    public function userEdit( Request $request ){
        $reqs = $request -> except( '_token' );

        $timer = time();
        $content = [
            "entId" => 23072,
            "supportUpsert" => 0,
            "staffType" => 10,
            "staffInfos" => [
                0 => [
                    "staffSerialNum" => "T5001T4LD",
                    "phone" => "15201013730",
                    "name" => "老王",
                    "email" => "liying_wang@eventown.com",
                    "entStaffNum" => "Eventown001",
                    "department" => "研发",
                    "budgetOrgName" => "北京总部",
                    "useEntBalance" => 0,
                    "baseCredit" => "9999",
                    "tripBaseCredit" => "10000",
                    "applyTempCredit" => 0,
                    "confirmPay" => 0,
                    "notifyPay" => 0,
                    "authEntStaffNum" => "Eventown001",
                    "notifyPhone" => "15201013730",
                    "notifyMail" => "liying_wang@eventown.com",
                    "city" => "北京"
                ],
            ],
            "sign" => "oHQvlciB7N9A09LUwHxt6A==",
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = 'ZHONGQINGLV-POS';
        $version = '1.0';
        $key = 'Z52ajDgwUjWt5FQMc4kbqQ==';
        $contentEn = $this -> Dinner -> encrypt( $content,  $key);

        $param = [
            'content' => $contentEn,
            'token' => $token,
            'version' => $version
        ];
        $url = 'http://b.51ping.com/openapi/updateStaff?token='.$token.'&content='.$contentEn.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        dd($request);
    }
    public function userDel( Request $request ){
        $reqs = $request -> except( '_token' );

        $timer = time();
        $content = [
            "entId" => 23072,
            "staffType" => 30,
            "staffContents" => [
                    "Eventown001",
            ],
            "sign" => "oHQvlciB7N9A09LUwHxt6A==",
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = 'ZHONGQINGLV-POS';
        $version = '1.0';
        $key = 'Z52ajDgwUjWt5FQMc4kbqQ==';
        $contentEn = $this -> Dinner -> encrypt( $content,  $key);

        $param = [
            'content' => $contentEn,
            'token' => $token,
            'version' => $version
        ];
        $url = 'http://b.51ping.com/openapi/deleteStaff?token='.$token.'&content='.$contentEn.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        dd($request);
    }


    public function businessOrderIdsQuery( Request $request ){
        $reqs = $request -> except( '_token' );
        $fromTime = strtotime('2017-11-30 00:00:00');
        $toTime = strtotime('2017-12-02');
        $timer = time();
        $content = [
            "entId" => config('system.staff_info.entId'),
            "fromTime" => $fromTime,//开始时间
            "toTime" => $toTime,//结束时间
            "sign" => config('system.staff_info.sign'),
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = config('system.staff_info.token');
        $version = config('system.staff_info.version');
        $param = [
            'content' => $content,
            'token' => $token,
            'version' => $version
        ];
        $url = 'https://b.dianping.com/openapi/businessOrderIdsQuery?token='.$token.'&content='.$content.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        echo $request;
    }
    public function businessOrderQuery( Request $request ){

        $reqs = $request -> except( '_token' );
        $orderId = '1004255610';//1003819233
        $orderInfo = $this->businessOrderInfo($orderId);
         dd($orderInfo);
    }

    public function businessOrderInfo($orderId){
        $timer = time();
        $content = [
            "entId" => config('system.staff_info.entId'),
            "orderId" => $orderId,
            "sign" => config('system.staff_info.sign'),
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = config('system.staff_info.token');
        $version = config('system.staff_info.version');

        $param = [
            'content' => $content,
            'token' => $token,
            'version' => $version
        ];
        $url = 'https://b.dianping.com/openapi/businessOrderQuery?token='.$token.'&content='.$content.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        $rs = json_decode($request,true);
        $orderInfo = array();
        if(isset($rs['code']) && $rs['code'] == '2770'){//调用成功状态
            $orderInfo =  json_decode($rs['content'],true);
            $orderInfo['bookingTime'] = date('Y-m-d H:i:s',$orderInfo['bookingTime']);
            $orderInfo['orderUpdateTime'] = date('Y-m-d H:i:s',$orderInfo['orderUpdateTime']);
            $orderInfo['gender'] = config('system.staff_gender.'.$orderInfo['gender']);
            $orderInfo['platform'] = config('system.staff_platform.'.$orderInfo['platform']);
            $orderInfo['position'] = config('system.staff_position.'.$orderInfo['position']);
            $orderInfo['payStatus'] = config('system.staff_payStatus.'.$orderInfo['payStatus']);
            $orderInfo['status'] = config('system.staff_status.'.$orderInfo['status']);
        }
        return $orderInfo;
    }
    public function orderPayInfo( Request $request ){

        $reqs = $request -> except( '_token' );
        $orderId = '1004255744';//1003819233
        $orderInfo = $this->orderPayInfos($orderId);
        dd($orderInfo);
    }
    //支付状态
    public function orderPayInfos($orderId){
        $timer = time();
        $content = [
            "entId" => config('system.staff_info.entId'),
            "channelOrderId" => $orderId,
            "sign" => 'oHQvlciB7N9A09LUwHxt6A==',//config('system.staff_info.sign'),
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = config('system.staff_info.token');
        $version = config('system.staff_info.version');
        $key = 'oHQvlciB7N9A09LUwHxt6A==';
        $contentEn = $this -> Dinner -> encrypt( $content,  $key);
        $param = [
            'content' => $contentEn,
            'token' => 'HUITANG-POS',//$token,
            'version' => $version
        ];
        $url = 'https://api-sqt.meituan.com/openapi/channelOrder/channelOrderQueryByChannelOrderId?token='.$token.'&content='.$content.'&version='.$version;
        //echo $url;exit;
        $request = $this -> Http -> httppost( $url, $param );
        $rs = json_decode($request,true);dd($rs);
        $orderpayInfo = array();
        if(isset($rs['status']) && $rs['status'] == '0'){//调用成功状态
            $orderpayInfo_all =  json_decode($rs['content'],true);
            $orderpayInfo['originAmount'] = $orderpayInfo_all['data']['originAmount'];//原价
            $orderpayInfo['payAmount'] = $orderpayInfo_all['data']['payAmount'];//支付金额
            $orderpayInfo['staffSN'] = $orderpayInfo_all['data']['staffSN'];//员工号
            $orderpayInfo['refundAmount'] = $orderpayInfo_all['data']['refundAmount'];//退款金额
            $orderpayInfo['payTime'] = date('Y-m-d H:i:s',$orderpayInfo_all['data']['payTime']);//时间
        }
        return $orderpayInfo;
    }


    public function sellerJoin( Request $request ){
        $reqs = $request -> except( '_token' );
        if(!isset($reqs['rfp_id']) || empty($reqs['rfp_id'])){
            $url= 'https://m.dianping.com/openAccess/access';
            header("Location: ".$url);
            exit;
        }
        $rfp_info = DB::table('rfp')->whereRaw('rfp_id='.$reqs['rfp_id'])->first();
        if(empty($rfp_info)){
            $url= 'https://m.dianping.com/openAccess/access';
            header("Location: ".$url);
            exit;
        }
        //获取城市
        $array = array('北京','上海','重庆','天津');
        if(in_array($rfp_info['provincedesc'],$array)){
            $city = $rfp_info['provincedesc'];
        }else{
            $city = $rfp_info['citydesc'];
        }
        $city_id = DB::table('dianping_city')->where('city_name', $city)->pluck('city_id');

        $token = config('system.staff_info.token');
        $staff = array(
            'staffNo' => 'Eventown002',//'Eventown'.session('user')['id'],
            'staffPhoneNo' => '15810690342',//session('user')['phone'],
        );
        $str = json_encode($staff);
        $entToken = $this->encrypt($str,$token);
       // dd($entToken);
        $content = array(
            "productType" => 'dp_canyin',
            "nounce" => $this->randomkeys(36),
            "appId" => config('system.staff_info.app_id'),
            "requestTime" => date('YmdHis',time()),
            "cityId" => $city_id,
            "thirdOrderId" => $reqs['rfp_id'],
            "entId" => config('system.staff_info.entId'),
            "staffNo" => 'Eventown002',//'Eventown'.session('user')['id'],
            "staffPhoneNo" => '15810690342',//session('user')['phone'],
            "entToken" => $entToken,
        );

        //序列化签名字符串
        ksort($content);
        $restring = http_build_query($content);
        //签名
        $contentEn = $this -> wjSign($restring);

        $url= 'https://m.dianping.com/openAccess/access?'.$restring.'&signature='.urlencode($contentEn);

        header("Location: ".$url);
     //   echo $url;exit;

    }

    public function orderPay( Request $request ){
        $reqs = $request -> except( '_token' );
        if(!isset($reqs['order_id']) || empty($reqs['order_id'])){
            return json_encode(array('rs'=>'0','msg'=>'order_id为空'));
        }
        //$reqs['order_id'] = '1004050278';
        $orderInfo = $this->businessOrderInfo($reqs['order_id']);
        if(empty($orderInfo)){
            return json_encode(array('rs'=>'0','msg'=>'点评无此订单信息'));
        }
      /*  if(!isset($orderInfo['status']) || $orderInfo['status'] != '50'){//已到店的状态才能申请支付
             return json_encode(array('rs'=>'0','msg'=>'已到店的状态才能申请支付'));
        }*/

      //查看是否确认过金额
        $price = DB::table('rfp_dporder')->where('order_id', $reqs['order_id'])->pluck('price');
        if((empty($price) || $price == 0) && ($reqs['price'] == 0 || empty($reqs['price']))){
            return json_encode(array('rs'=>'0','msg'=>'price为空'));
        }

        if(!empty($price) && $price != 0){
            $payPrice = $price;
        }else{
            $payPrice = $reqs['price'];
            DB::table('rfp_dporder')->where('order_id', $reqs['order_id'])->update(array('price'=>$payPrice));
        }

        $content = array(
            "amount" => $payPrice,
            "bizType" => '11',
            "channelOrderId" => $orderInfo['orderId'],
            "dpShopId" => $orderInfo['shopId'],
            "entId" => config('system.staff_info.entId'),
            "nounce" => $this->randomkeys(24),
            "platformId" => config('system.staff_info.app_id'),
            "requestTime" => date('YmdHis',time()),
            "bizOrderId" => $orderInfo['orderId'],
            "phone" => '15810690342',//session('user')['phone'],
        );

        //序列化签名字符串
        ksort($content);
        $restring = http_build_query($content);
        //签名
        $contentEn = $this -> wjSign($restring);
        $file_name = 'DP'.date('Y-m-d H_i_s',time()).rand(1111,9999).'.png';
        $url= 'https://m.dianping.com/epay/thirdchannel/orderPayGate?'.$restring.'&signature='.urlencode($contentEn);
        QrCode::format('png')->size(200)->generate( $url , public_path('assets/qr_code/'.$file_name));

        return json_encode(array('rs'=>'1','data'=>url('assets/qr_code/'.$file_name)));
      //  header("Location: ".$url);
        //   echo $url;exit;

    }


    public function validateStatus( Request $request ){
        $reqs = $request -> except( '_token' );//entToken
        if(!isset($reqs['entToken']) || empty($reqs['entToken'])){
            $return['status'] = '0';
            $return['message'] = '调用失败';
            $return['data'] = array(
                'loginStaus' => '0',
                'jumpUrl' => '',
                'staffPhoneNo' => '',
                'staffNo' => '',
            );
            return json_encode($return);
        }

        $return['status'] = '1';
        $return['message'] = '调用成功';
        $token = config('system.staff_info.token');
        $loginInfo  = json_decode($this->decrypt($reqs['entToken'],$token),true);
        if(!isset($loginInfo['staffNo']) || empty($loginInfo['staffNo']) || !isset($loginInfo['staffPhoneNo']) || empty($loginInfo['staffPhoneNo'])){
            $return['data'] = array(
                'loginStaus' => '0',
                'jumpUrl' => '',
                'staffPhoneNo' => '',
                'staffNo' => '',
            );
            return json_encode($return);
        }

        $return['data'] = array(
            'loginStaus' => '1',
            'jumpUrl' => '',
            'staffPhoneNo' => $loginInfo['staffPhoneNo'],
            'staffNo' => $loginInfo['staffNo'],
        );
        return json_encode($return);

    }


    public function randomkeys($length)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern[mt_rand(0,61)];    //生成php随机数
        }
        return $key;
    }
    //签名
    public function wjSign($data){

      /*  $str=file_get_contents($_SERVER['DOCUMENT_ROOT'].$this->privateKeyPathWJ);
        $str        = chunk_split($str, 64, "\n");
        $key = "-----BEGIN RSA PRIVATE KEY-----\n$str-----END RSA PRIVATE KEY-----\n";
        $signature = '';
        if (openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1)) {
            return base64_encode($signature);
        }
        return '';*/

        $sign = '';
        $key = openssl_pkey_get_private(file_get_contents($_SERVER['DOCUMENT_ROOT'].$this->privateKeyPathWJ));
        openssl_sign($data, $sign, $key, OPENSSL_ALGO_SHA1);
        $sign = base64_encode($sign);
        return $sign;
    }
    //验签
    public function wjVerify($data, $sign){
        $sign = base64_decode($sign);
        $key = openssl_pkey_get_public(file_get_contents($_SERVER['DOCUMENT_ROOT'].$this->publicKeyPathWJ));
        $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;
        return $result;
    }

    public function encrypt($data, $key)
    {
        $key = md5($key);
        $x  = 0;
        $len = strlen($data);
        $l  = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    public function decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
            {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }
            else
            {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }

    //加密函数
    public function passport_encrypt($txt, $key) {
        srand((double)microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for($i = 0;$i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
        }
        return base64_encode($this->passport_key($tmp, $key));
    }
//解密函数
    public function passport_decrypt($txt, $key) {
        $txt = $this->passport_key(base64_decode($txt), $key);
        $tmp = '';
        for($i = 0;$i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }

    public function passport_key($txt, $encrypt_key) {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }
}

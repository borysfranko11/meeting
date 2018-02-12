<?php
/**
 * des: 订单逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Libs\Dinner;
use App\Models\OrderOrigin;
use App\Models\Rfp;
use App\Models\RfpBudget;
use App\Models\RfpEquipment;
use App\Models\RfpFood;
use App\Models\RfpPerform;
use App\Models\RfpPicFile;
use App\Models\RfpPicInvoiceFile;
use App\Models\RfpPlace;
use App\Models\RfpRoom;
use App\Models\RfpUser;
use Illuminate\Http\Request;
use App\Libs\EveClient;
use App\Libs\Http;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use Illuminate\Support\Facades\DB;
use App\Libs\Image;
class OrderController extends Controller
{
    private $_Rfp;
    private $_RfpPlace;
    private $_RfpEquipment;
    private $_RfpFood;
    private $_RfpRoom;
    private $_RfpUser;
    private $_RfpPerform;
    private $_RfpPicFile;
    public function __construct()
    {
        parent::__construct();
        $this -> _Rfp           = new Rfp();
        $this -> _RfpPlace      = new RfpPlace();
        $this -> _RfpEquipment  = new RfpEquipment();
        $this -> _RfpFood       = new RfpFood();
        $this -> _RfpRoom       = new RfpRoom();
        $this -> _RfpUser       = new RfpUser();
        $this -> _RfpPerform    = new RfpPerform();
        $this -> _RfpPicFile    = new RfpPicFile();
        $this -> _RfpPicInvoiceFile    = new RfpPicInvoiceFile();
        $this -> _RfpBudget     = new RfpBudget();
        $this -> _Order         = new OrderOrigin();
        $this -> EveClient      = new EveClient();
        $this -> Http           = new Http();
        $this -> Dinner         = new Dinner();
    }

    public function index( Request $request )
    {
        $reqs       = $request -> except( '_token' );$this->wineOrder($reqs);
        $data       = $this -> orderList($reqs);
        $provinces  = $this->getProvinces();

        return view( '/order/order', ["data" =>  $data, 'provinces' => $provinces ] );
    }

    public function preview( Request $request )
    {
        $reqs = $request->except('_token');
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        $rfpData    = $this->_Rfp->getRfpByRfpid($rfp_id);
        $place_id = $rfpData[0]['place_id'];
        if($rfpData[0]['place_id'] == '0'){
            $order                  = $this->_Order->getDetail($rfp_id);
            $sinopec_order          = isset($order[0]['sinopec_order'])?$order[0]['sinopec_order']:'';
            $orderRfp               = json_decode($sinopec_order, true);
            $place_id = $orderRfp['place_order']['place_id'];
        }
        
        $hotelInfo  = $this->getPlaceDetail($place_id);

        $url    = config( 'system.wallet' );
        $uri    = 'api/transactionFlow/selectTransactionFlow';
        $url    = $url.$uri;

        $data['launch_account_id']  = config( 'system.account_id' );
        $data['business_order_no']  = $rfpData[0]['order_no'];

        $header = $this->setHeader($data);
        $res    = doCurlPostRequest($url, $data, $header);
        $res    = json_decode($res, true);
        $flow   = [];
        if( !$res['errorno'] ){
            $flow = $res['data']['result'];
        }
        //获取点评订单信息
        $dporder = $this->getDPOrder($rfp_id);

        return view( '/order/detail',[ 'data' => $rfp_id, 'rfp' => $rfpData[0], 'hotel' => $hotelInfo, 'flow' => $flow ,'dporder' => $dporder]);
    }
    public function getPayInstrument( Request $request ){
        $reqs       = $request->except('_token');
        $flow_id    = $reqs['flow_id'];
        $url        = config( 'system.wallet' );
        $uri        = 'api/transactionFlow/selectTransactionFlow';
        $url        = $url.$uri;

        $data['launch_account_id']  = config( 'system.account_id' );
        $data['flow_id']            = $flow_id;

        $header = $this->setHeader($data);
        $res    = doCurlPostRequest($url, $data, $header);
        $res    = json_decode($res, true);
        $flowInfo = $res['data']['result'][0];

        $url        = config( 'system.wallet' );
        $uri        = 'api/bankcard/getInfoByAccountId';
        $url        = $url.$uri;

        //$data['launch_account_id']  = config( 'system.account_id' );
        $datas['aid']            = $flowInfo['recieve_account_id'];

        $header = $this->setHeader($datas);
        $res    = doCurlPostRequest($url, $datas, $header);
        $res    = json_decode($res, true);
        $band = $res['data']['bank_account_no'];

        $image = new Image();

        $image->setImgUrl($_SERVER['DOCUMENT_ROOT'] .'/assets/img/ibackground.jpg');
        $image->setTtf($_SERVER['DOCUMENT_ROOT'] .'/assets/img/msyh.ttf');
        $image->setUrl($_SERVER['DOCUMENT_ROOT'] .'/assets/payImage/'.$flowInfo['business_order_no'].'.jpg');
        //交易类型
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 160, 'text' =>'钱包支付'));
        //交易类型
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 190, 'text' =>'北京会唐世纪科技有限公司'));
        //通联通商户号
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 220, 'text' => '200222000008786'));
        //付款方
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 255, 'text' => $flowInfo['payer_account_name']));
        //银行
        //$image->addPositionAndText(array('position_x' => 486, 'position_y' => 255, 'text' => $companyBankInfo['bank_name']));
        //银行
        //$image->addPositionAndText(array('position_x' => 486, 'position_y' => 250, 'text' => '招商银行'));
        //金额
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 280, 'text' => $flowInfo['money']));
        //订单状态
        $status = '支付成功';
        if($flowInfo['status'] == 0){
            $status = '操作中';
        }elseif($flowInfo['status'] == 2){
            $status = '操作失败';
        }
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 340, 'text' => $status));
        //订单号
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 400, 'text' => $flowInfo['business_order_no']));
        //额外信息
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 430, 'text' => $flowInfo['message']));
        //币种
        $image->addPositionAndText(array('position_x' => 486, 'position_y' => 280, 'text' => 'CNY'));
        //交易时间

        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 370, 'text' => date('Y年m月d日 H时i分i秒', time())));
        $image->addPositionAndText(array('position_x' => 486, 'position_y' => 340, 'text' => time()));


        //收款方
        $image->addPositionAndText(array('position_x' => 170, 'position_y' => 315, 'text' => $flowInfo['recieve_account_name']));
        //收款账号
        $image->addPositionAndText(array('position_x' => 486, 'position_y' => 315, 'text' => $band));
        $image->outPutImage();

        $len = filesize ($_SERVER['DOCUMENT_ROOT'] .'/assets/payImage/'.$flowInfo['business_order_no'].'.jpg');
        ob_clean();
        header ( "Pragma: public" );
        header ( "Expires: 0" );
        header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header ( "Cache-Control: public" );
        header ( "Content-Description: File Transfer" );
        Header ( "Content-type: image/jpg");
        header ( 'Content-Disposition: attachment;filename="'.$flowInfo['business_order_no'].'.jpg"');
        header ( "Content-Transfer-Encoding: binary" );
        header ( "Content-Length: " . $len );
        echo file_get_contents($_SERVER['DOCUMENT_ROOT'] .'/assets/payImage/'.$flowInfo['business_order_no'].'.jpg');
        unlink($_SERVER['DOCUMENT_ROOT'] .'/assets/payImage/'.$flowInfo['business_order_no'].'.jpg');
        exit;

    }
    //酒水订单
    public function wine( Request $request )
    {
        $reqs = $request -> except( '_token' );
        $data = $this -> wineOrder($reqs);
        return view( '/order/wineOrder', ["data" =>  json_encode($data) ] );
    }
    //酒水订单详情
    public function winePreview( Request $request ){
        $reqs = $request -> except( '_token' );
        $data = $this -> wineDetail($reqs);
        return view( '/order/winePreview', ["data" =>  json_encode($data) ] );
    }

    public function confirm()
    {
        dd('确认下单');
        return view( '/order/confirm');
    }

    public function ordermemo( Request $request ){
        $reqs = $request -> except( '_token' );
        $rfp_id     = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );
        if(empty($rfp_id)){
            return returnJson(false,'','参数缺失');
        }
        //获取水单信息
        $data['picFile']        = $this->_RfpPicFile->getDetail($rfp_id);
        $data['invoice']        = $this->_RfpPicInvoiceFile->getDetail($rfp_id);
        return view( '/order/ordermemo', ["data" =>  json_encode($data) ,'rfp_id'=>$rfp_id] );
    }

    //订单列表
    public function orderList($reqs){
        //格式化参数
        $begin_date                 = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        $end_date                   = date('Y-m-d 23:59:59', time());// 获取当前月份最后一天
        //$where['startTime']         = empty($reqs['start_time'])?strtotime($begin_date):strtotime($reqs['start_time']);
        //$where['endTime']           = empty($reqs['end_time'])?strtotime($end_date):strtotime($reqs['end_time']);
        //$begin_date                 = date('Y-01-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
       // $end_date                   = date('Y-m-d 23:59:59', time());// 获取当前月份最后一天
        $where['startTime']         = empty($reqs['start_time'])?'':strtotime($reqs['start_time']);
        $where['endTime']           = empty($reqs['end_time'])?'':strtotime($reqs['end_time']);
        $where['provincedesc']    = empty($reqs['provincedesc'])?'':filterParam( $reqs['provincedesc'] );//会议城市
        $where['key']               = empty($reqs['keyword'])?'':filterParam( $reqs['keyword'] );//关键字
        $page                       = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                      = empty($reqs['limit'])?10:(int)$reqs['limit'];
        $info['page']               = $page;
        $info['limit']              = $limit;
        $info['filter'] = array(
            "start"     =>  $where['startTime'],
            "end"       =>  $where['endTime'],
            "keyword"   =>  $where['key'],
            "provincedesc"   =>  $where['provincedesc'],
        );
        $where          = array_filter($where);//去空
        $data           = array('where'=>$where,'page'=>$page,'limit'=>$limit);
        //构造sql语句
        $sql            = $this->formatSql($data);

        try
        {
            $count  = DB::select($sql['sql_count']);
            $datas   = DB::select($sql['sql']);
            $info['count'] = $count[0]['count'];
            if(empty($datas))return json_encode($info);

            $list = array();
            foreach ($datas as $key=>$val){
                $list[$key]['rfp_id']                   = $val['rfp_id'];
                $list[$key]['meeting_code']             = $val['meeting_code'];
                $list[$key]['meeting_name']             = $val['meeting_name'];
                $list[$key]['meeting_type_desc']                = $val['meeting_type_desc'];
                $list[$key]['clientele_num']            = $val['clientele_num'];
                $list[$key]['within_num']            = $val['within_num'];
                $list[$key]['nonparty_num']            = $val['nonparty_num'];
                $list[$key]['provincedesc']            = $val['provincedesc'];
                $list[$key]['citydesc']            = $val['citydesc'];
                $list[$key]['people_num']            = $val['people_num'];

                $list[$key]['start_time']               = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
                $list[$key]['end_time']                 = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
                $list[$key]['start_time_val']   = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
                $list[$key]['end_time_val']     = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
                $time_extend = json_decode($val['time_extend'],true);
                $list[$key]['time_extend']      = '';
                $time_extend_list = array();
                if(!empty($val['time_extend']) && !empty($time_extend)){
                    $list[$key]['time_extend']  = $time_extend;
                    foreach ($time_extend as $k=>$v){
                        $time_extend_list[$k]['start_time_val'] = empty($v['start_time'])?'':date('Y-m-d',$v['start_time']);
                        $time_extend_list[$k]['end_time_val']   = empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
                    }
                }
                $list[$key]['time_extend_val']          = $time_extend_list;
                $list[$key]['budget_total_amount']      = $val['budget_total_amount'];
                $list[$key]['ht_settlement_amount']     = $val['ht_settlement_amount'];
                $list[$key]['real_attendance_number']   = $val['real_attendance_number'];
                $list[$key]['people_num']               = $val['people_num'];
                $list[$key]['status']                   = $val['status'];
                $list[$key]['order_total_amount']       = $val['order_total_amount'];

            }

            $info['data']  = $list;
            return json_encode($info);
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "我的订单列表,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array();
        }

    }

    private function formatSql($data){
        $where = $data['where'];
        $field = 'rfp_id,meeting_code,meeting_name,meeting_type_desc,start_time,end_time,time_extend,budget_total_amount,clientele_num,within_num,nonparty_num,provincedesc,citydesc,people_num,status,real_attendance_number,ht_settlement_amount,order_total_amount';
        $sql   = 'SELECT [*] FROM rfp WHERE 1=1';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $where1 = '';$where2 = '';
        if (!in_array('超级管理员',$roles)) {
            if (in_array('会议发起人', $roles)) {
                $where1 = ' user_code = ' . session('user')['id'];
            }
            if (in_array('费用审核员', $roles)) {
                $where2 = ' marketorgcode = "' . session('user')['marketorgcode'] . '"';
            }
        }
        // 根据角色进行搜索
        if(!empty($where1) && !empty($where2)){
            $sql .= ' and '.($where1 .' or '.$where2);
        }elseif (!empty($where1)){
            $sql .= ' and '.$where1;
        }elseif (!empty($where2)){
            $sql .= ' and '.$where2;
        }
        // 根据会议状态查询
        $sql .= ' AND status >= 40 AND status < 60';
        if (isset($where['key'])) {
            $sql .= ' AND (meeting_name like "%' . $where['key'] . '%" OR meeting_code LIKE "%'. $where['key']. '%")';
        }
        // 根据会议开始时间结束时间查询
        if (isset($where['startTime'])) {
            $sql .= sprintf(' AND create_time >= "%d" ',$where['startTime']);
        }
        if (isset($where['endTime'])) {
            $sql .= sprintf(' AND create_time <= "%d"',$where['endTime']);
        }

        if (isset($where['provincedesc'])) {
            $sql .= ' AND provincedesc = "' . $where['provincedesc'] . '"';
        }
        //计算总条数
        $arr['sql_count'] = str_replace('[*]', 'COUNT(rfp_id) AS count', $sql);
        //查询sql
        $limit  = $data['limit'] ? $data['limit'] : 10;
        $offset = $data['page'] ? ($data['page'] - 1) * $limit : 0;
        $sql .= ' ORDER BY create_time DESC, rfp_id DESC';
        if (!isset($data['isExport'])) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }
        $arr['sql']  = str_replace('[*]', $field, $sql);
        return $arr;
    }

    public function orderDetail(Request $request){
        $reqs       = $request -> except( '_token' );
        $rfp_id     = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );
        if(empty($rfp_id)){
            return returnJson(false,'','参数缺失');
        }
        //获取会议信息
        $rfpData                = $this->_Rfp->getRfpByRfpid($rfp_id);
        $data['meeting']        = isset($rfpData[0])?$rfpData[0]:array();
        //会议预算信息
        $equipment = $this -> _RfpEquipment->getRfpEquipment($rfp_id);
        $budget                 = $this ->_RfpBudget->getBudget($rfp_id);
        $T04 = array(0.00);
        $T05 = array(0.00);
        $T01 = array(0.00);
        $T02 = array(0.00);
        $T03= array(0.00);
        if(!empty($budget)){
            foreach ($budget as $val){
                if($val['fundtypecode'] == 'T04'){
                    $T04[]  = $val['budgetamount'];
                }elseif ($val['fundtypecode'] == 'T05'){
                    $T05[]  = $val['budgetamount'];
                }elseif ($val['fundtypecode'] == 'T01'){
                    $T01[]  = $val['budgetamount'];
                }elseif ($val['fundtypecode'] == 'T02'){
                    $T02[]  = $val['budgetamount'];
                }elseif ($val['fundtypecode'] == 'T03'){
                    $T03[]  = $val['budgetamount'];
                }
            }
        }
        $data['budget']['T01'] = sprintf('%.2f',array_sum($T01));
        $data['budget']['T02'] = sprintf('%.2f',array_sum($T02));
        $data['budget']['T03'] = sprintf('%.2f',array_sum($T03));
        $data['budget']['T04'] = sprintf('%.2f',array_sum($T04));
        $data['budget']['T05'] = sprintf('%.2f',array_sum($T05));
        $data['budget']['equipment'] = isset($equipment[0]['budget_account']) ? $equipment[0]['budget_account'] : 0.00;

        //获取费用信息
        $data['perform']        = $this->_RfpPerform->getDetail($rfp_id);
        //获取水单信息
        $picFile        = $this->_RfpPicFile->getDetail($rfp_id);
        $invoice        = $this->_RfpPicInvoiceFile->getDetail($rfp_id);
        $data['picFile']        = array_merge($picFile,$invoice);
        //获取订单信息
        $order                  = $this->_Order->getDetail($rfp_id);
        $sinopec_order          = isset($order[0]['sinopec_order'])?$order[0]['sinopec_order']:'';
        $orderRfp               = json_decode($sinopec_order, true);
        $data['order']          = $this->getOrderInfo($orderRfp);
        //会议场地付款情况
        $data['transferList']   = $this->transferList($data['meeting']);
        //京东付款情况
        $data['jd']             = $this->jdInfo($data['meeting']);
        //获取房间信息
        $rfp['room']            = $this->getroom($rfp_id);
        //获取食物信息
        $food                   = $this->getfood($rfp_id);
        $rfp['food']            = $food[0];
        $data['rfp']            = $rfp;

        return returnJson(true,$data,'');
    }
    //获取点评订单信息
    public function getDPOrder($rfp_id){
        $dporder = DB::table('rfp_dporder')->where('rfp_id',$rfp_id)->get();
        $order = array();
        foreach ($dporder as $key=>$val){
            $order[] = $this->businessOrderInfo($val['order_id'],$val['price']);
        }
        return array_filter($order);
    }
    public function businessOrderInfo($orderId,$price){
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
            $orderInfo['status_name'] = config('system.staff_status.'.$orderInfo['status']);
            $orderInfo['pay_price'] = $price;
            $orderInfo['orderPay'] = $this->orderPayInfos($orderInfo['orderId']);
        }
        return $orderInfo;
    }

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
        $rs = json_decode($request,true);
        $orderpayInfo = array();
        if(isset($rs['status']) && $rs['status'] == '0'){//调用成功状态
            $orderpayInfo['originAmount'] = $rs['data']['originAmount'];//原价
            $orderpayInfo['payAmount'] = $rs['data']['payAmount'];//支付金额
            $orderpayInfo['staffSN'] = $rs['data']['staffSN'];//员工号
            $orderpayInfo['refundAmount'] = $rs['data']['refundAmount'];//退款金额
            $orderpayInfo['payTime'] = date('Y-m-d H:i:s',$rs['data']['payTime']);//时间
        }
        return $orderpayInfo;
    }


    public function rfpDetail(Request $request){
        $reqs       = $request -> except( '_token' );
        $rfp_id     = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );
        if(empty($rfp_id)){
            return returnJson(false,'','参数缺失');
        }
        //获取会议信息
        $rfpData                = $this->_Rfp->getRfpByRfpid($rfp_id);
        $data['meeting']        = isset($rfpData[0])?$rfpData[0]:array();
        $data['budget']         = $this->_RfpBudget->getBudget($rfp_id);
        //获取场地及会议需求信息
        $place                  = $this -> _RfpPlace->getRfpPlace($rfp_id);
        $equipment              = $this -> _RfpEquipment->getRfpEquipment($rfp_id);
        $palce_equ_list         = $this->getPlaceAndEqu($place,$equipment);
        $rfp['place']           = $palce_equ_list[0];
        $rfp['equipment_arr']   = $palce_equ_list[1];
        //获取房间信息
        $rfp['room']            = $this->getroom($rfp_id);
        //获取食物信息
        $food                   = $this->getfood($rfp_id);
        $rfp['dining']          = $food[1];
        $rfp['wine']            = $food[2];
        $data['rfp']            = $rfp;

        return returnJson(true,$data,'');
    }

    //获取场地和会议需求
    private function getPlaceAndEqu($place,$equipment){
        if(empty($place))return array('','');
        //场地
        $palce_list['place_type_name']     = isset($place[0]['place_type_name']) && !empty($place[0]['place_type_name'])?$place[0]['place_type_name']:'不限';
        $palce_list['place_location_name'] = isset($place[0]['place_location_name']) && !empty($place[0]['place_location_name'])?$place[0]['place_location_name']:'不限';
        $palce_list['place_star_name']     = isset($place[0]['place_star_name']) && !empty($place[0]['place_star_name'])?$place[0]['place_star_name']:'不限';
        //酒店
        $place_id_and_name_json       = isset($place[0]['place_id_and_name_json']) && !empty($place[0]['place_id_and_name_json']) ? $place[0]['place_id_and_name_json'] : '';
        $hotel_arr      = json_decode($place_id_and_name_json, true);
        if(!empty($hotel_arr)){
            foreach ($hotel_arr as $k=>$v){
                $hotel_arr[$k] = $this->getPlaceDetail($v['place_id']);
            }
        }
        $palce_list['hotel_arr'] = $hotel_arr;
        //设施
        $equipment_arr = array();
        $i = 0;
        $equipment_key_arr = $this->formEquipment($equipment);
        foreach ($place as $key=>$val){
            if($val['meeting_people']){
                $equipment_arr[$i]['start_date']            = $val['start_date'];
                $equipment_arr[$i]['end_date']              = $val['end_date'];
                $equipment_arr[$i]['meeting_people']        = $val['meeting_people'];
                $equipment_arr[$i]['date_note']             = $val['date_note'];
                $equipment_arr[$i]['table_decoration_name'] = config('system.table_type.'.$val['table_decoration']);
                $equipment_formkey                          = $this->getInfoByFormkey($equipment_key_arr,$val['form_key']);
                $equipment_arr[$i]['equipment']             = $equipment_formkey[0];
                $equipment_arr[$i]['equipment_description'] = $equipment_formkey[1];
                $i++;
            }
        }
        return array($palce_list,$equipment_arr);
    }

    //获取酒店信息
    public function getPlaceDetail( $id ){
        if(empty($id))return array();

        $searchData     = [ 'id' => $id ];
        if($id > 6000000){
            $url            = config('links.palce_api').'/q/v2';
        }else{
            $url            = config('links.palce_api').'/q';
        }
        $res            = json_decode(doCurlGetRequest($url, $searchData), true);
        $hotel_arr = array();
        if(!isset($res["ok"])){
            $hotel_arr['main_pic_url']  = isset($res['main_pic_url'])?config('links.upy_img_url').$res['main_pic_url']:'';
            $hotel_arr['place_name']    = isset($res['place_name'])?$res['place_name']:'';
            $hotel_arr['address']       = isset($res['address'])?$res['address']:'';

            $place_type = isset($res['place_type'])?config('system.place_type.'.$res['place_type']):config('system.place_type.'.$res['new_place_type']);
            $hotel_arr['place_type']    = isset($place_type)?$place_type:'';
        }


        return $hotel_arr;

    }

    //会议需求数据格式化
    private function formEquipment($equipment){
        if(empty($equipment))return array();
        $arr = array();
        foreach ($equipment as $key=>$val){
            $arr[$val['form_key']] = $val;
        }
        return $arr;
    }
    //获取单个会议需求的会议设施
    private function getInfoByFormkey($equipment_key_arr,$form_key){
        if(empty($equipment_key_arr) || !isset($equipment_key_arr[$form_key]) || empty($equipment_key_arr[$form_key]))return array('','');
        $equ_list = array();
        $equ_type = config('system.equipment_type');
        foreach ($equipment_key_arr[$form_key] as $key=>$val){
            if(isset($equ_type[$key])){
                $equ_list[] = array('code'=>$key,'name'=>$equ_type[$key]['name'],'num'=>$val);
            }
        }
        $desc = $equipment_key_arr[$form_key]['equipment_description'];
        return array($equ_list,$desc);
    }

    //获取房间信息
    private function getroom($rfp_id){
        $rooms = $this->_RfpRoom->getRfpRoom($rfp_id);
        if(empty($rooms))return array();
        $room_type = config('system.room_type');
        foreach ($rooms as $key => $val) {
            $type_name    = isset($room_type[$val['type']]) ? $room_type[$val['type']] : '';
            $rooms[$key]['breakfast_name'] = '不提供早餐';
            if ($val['breakfast']) {
                $rooms[$key]['breakfast_name'] = '提供早餐';
            }
            $rooms[$key]['type_name'] = $type_name;
        }
        return $rooms;
    }
    //获取食物信息
    private function getfood($rfp_id){
        $food = $this->_RfpFood->getRfpFood($rfp_id);
        if(empty($food))return array('','','');
        $riceType       = config('system.food_type');
        $diningType     = config('system.dining_type');
        $wineType       = config('system.wine');
        $dining_list = array();
        $wine_list = array();
        foreach ($food as $key => $val) {
            $rice_type_name                         = isset($riceType[$val['rice_type']]) ? $riceType[$val['rice_type']] : '';
            $dining_type_name                       = isset($diningType[$val['dining_type']]) ? $diningType[$val['dining_type']] : '';
            $wineType_name                          = isset($wineType[$val['dining_type']]) ? $wineType[$val['dining_type']] : '';
            $food[$key]['food_menu_name']           = '不提供菜单';
            $food[$key]['rice_type_name']           = $rice_type_name;
            $food[$key]['dining_type_name']         = $dining_type_name;
            if ($val['food_menu']) {
                $food[$key]['food_menu_name']       = '提供菜单(以实际与酒店沟通情况为准)';
            }
            $food[$key]['food_water_name']          = '不提供酒水';
            if ($val['food_water']) {
                $food[$key]['food_water_name']      = '提供酒水';
                $food[$key]['dining_type_name']     = $wineType_name;
                $wine_list[]                        = $food[$key];
            }else{
                $dining_list[]                      = $food[$key];
            }
        }
        return array($food,$dining_list,$wine_list);
    }

    private function transferList($meeting){
        if(!isset($meeting['order_no']) || empty($meeting['order_no']))return array();
        $data = array();
        $transferList = $this->gettransfer($meeting['order_no']);
        if (!empty($transferList)) {
            $data = $transferList['data'];
        }
        return $data;
    }
    private function gettransfer($orderNo){
        $this->open_api();
        $data['order_no']   = $orderNo;
        $array['signature'] = $this->eveClient->generateSign($data);
        $array['param']     = json_encode($data);
        $result             = $this->http->httppost(config( 'links.open_api_url' ) . '/Monarch/transferList', $array, $this->token);
        $result             = json_decode($result, true);
        if ($result['errorno'] < 0) {
            return array();
        }
        return $result;
    }
    private function jdInfo($meeting){
        if(!isset($meeting['meeting_code']))return array();
        $param['from']  = 2;
        $param['m_id']  = $meeting['meeting_code'];
        $url            = config('link.jd_order');
        $dataJson       = $this->Http->z_get($url, $param);
        $data           = json_decode($dataJson, true);
        $wineOrder      = array();
        if(isset($data[$meeting['meeting_code']]) && count($data[$meeting['meeting_code']]['order'])){
            $wineOrder  = $data[$meeting['meeting_code']]['order'];
        }
        return $wineOrder;
    }

    private function getOrderInfo($orderRfp){
        if(empty($orderRfp))return array();
        $orderinfo['order_no']          = $orderRfp['place_order']['order_no'];
        $orderinfo['place_name']        = $orderRfp['place_order']['place_name'];
        $orderinfo['place_address']     = $orderRfp['place_order']['place_address'];
        $orderinfo['start_time']        = $orderRfp['place_order']['start_time'];
        $orderinfo['end_time']          = $orderRfp['place_order']['end_time'];
        $orderinfo['total_money']       = $orderRfp['place_order']['total_money'];
        $orderPlaceRoom         = 0.00;
        $orderFood              = 0.00;
        $orderRoom              = 0.00;
        foreach ($orderRfp['place_order']['orderPlaceRoom'] as $val){
            $orderPlaceRoom += $val['fee'];
        }
        foreach ($orderRfp['place_order']['orderFood'] as $val){
            $orderFood += $val['fee'];
        }
        foreach ($orderRfp['place_order']['orderRoom'] as $val){
            $orderRoom += $val['fee'];
        }
        $orderinfo['orderPlaceRoom']    = sprintf("%.2f",$orderPlaceRoom);
        $orderinfo['orderFood']         = sprintf("%.2f",$orderFood);
        $orderinfo['orderRoom']         = sprintf("%.2f",$orderRoom);
        return $orderinfo;
    }

    //酒水订单
    public function wineOrder($reqs){
        //格式化参数
        $begin_date                 = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        $end_date                   = date('Y-m-d 23:59:59', strtotime("$begin_date +1 month -1 day"));// 获取当前月份最后一天
        $date['startTime']          = empty($reqs['start_time'])?strtotime($begin_date):strtotime($reqs['start_time']);
        $date['endTime']            = empty($reqs['end_time'])?strtotime($end_date):strtotime($reqs['end_time']);
        $key                        = empty($reqs['keyword'])?'':filterParam( $reqs['keyword'] );//关键字
        $page                       = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                      = empty($reqs['limit'])?10:(int)$reqs['limit'];
        $info['page']               = $page;
        $info['limit']              = $limit;
        $info['filter'] = array(
            "start"     =>  $date['startTime'],
            "end"       =>  $date['endTime'],
            "keyword"   =>  $key,
        );
        $info['data'] = $this->getData($date,$key,$limit,$page,true);

       return $info;
    }

    private function getData($date=array(), $meetingCode='', $limit=10, $pageNo=1, $pages=false, $meetingName='', $orderNo='', $orderStatus=0){
        $companyCode     = '';
        $meetingUserName = '';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        if (!in_array('超级管理员',$roles)) {
            if (in_array('费用审核员', $roles)) {
                $companyCode        = session('user')['marketorgcode'];
            }elseif (in_array('会议发起人', $roles)) {
                $meetingUserName    = session('user')['id'];
            }
        }

        $param['company']       = $companyCode;
        $param['from']          = 2;
        $param['start_time']    = isset($date[0])? $date[0]:'';
        $param['end_time']      = isset($date[1])? $date[1]:'';
        $param['m_id']          = $meetingCode;
        $param['m_name']        = $meetingName;
        $param['m_user']        = $meetingUserName;
        $param['order_id']      = $orderNo;
        $param['state']         = $orderStatus;
        $param['per-page']      = $limit;
        if($pages){
            $param['page']      = $pageNo;
            return $this->getDataPage($param);
        }
        $param['expload']       = 1;
        return $this->getOrderListPage($param);
    }
    private function getDataPage($param){
        $data = $this->getOrderListPage($param);
        $returnData['totalRows'] = $data['pages']['totalCount'];
        unset($data['pages']);
        if($returnData['totalRows']>0){
            foreach ($data as $key=>$val){
                $data[$key]['orderPrice_total'] = 0;
                $orderPrice_total = array();
                foreach ($val['order'] as $k=>$v){
                    $data[$key]['order'][$k]['orderPrice']  = sprintf("%.2f",$v['price'] + $v['luggage']);
                    $data[$key]['order'][$k]['state_name']  = config('system.order_status.'.$v['state']);
                    $data[$key]['order'][$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
                    $orderPrice_total[]         = sprintf("%.2f",$v['price'] + $v['luggage']);
                }
                $data[$key]['orderPrice_total'] = sprintf("%.2f",array_sum($orderPrice_total));
            }
        }
        $returnData['list'] = $data;
        return $returnData;
    }

    //酒水详情
    public function wineDetail($reqs){
        if(empty($reqs['etID']))return array();
        $data = $this->getwineOrderInfo($reqs['etID']);
        if(empty($data)){
            return array();
        }
            $data['orderPrice']         = sprintf("%.2f",$data['price'] + $data['luggage']);
            $data['state_name']         = config('system.order_status.'.$data['state']);
            $data['create_time']        = date('Y-m-d H:i:s',$data['create_time']);
            $data['start_time']         = date('Y-m-d', strtotime($data['start_time']));
            $data['end_time']           = date('Y-m-d', strtotime($data['end_time']));
            $data['realy_time']         = date('Y-m-d', $data['m_realy_time']);
            $data['products']           = json_decode($data['products'], true);
            if(!empty($data['products'])){
                foreach ($data['products'] as $key=>$val){
                    $data['products'][$key]['p_price_total'] = sprintf("%.2f",$val['num']*$val['price']);
                }
            }
        return $data;
    }


    public function getOrderListPage($param){
        $url        = config('links.jd_order');
        $dataJson   = $this->Http->z_get($url, $param);
        $data       = json_decode($dataJson, true);
        return $data;
    }

    public function getwineOrderInfo($etID){
        $url        = config('links.jd_order_info');
        $dataJson   = $this->Http->z_get($url, array('order_id'=>$etID));
        $data       = json_decode($dataJson, true);
        return $data;
    }

    public function getProvinces(){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign('');
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getProvinces?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }

}

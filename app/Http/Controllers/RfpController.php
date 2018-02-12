<?php
/**
 * des: 询单逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Rfp;
use App\Models\RfpFood;
use App\Models\RfpRoom;
use App\Models\RfpPlace;
use App\Models\RfpEquipment;
use App\Models\RfpUser;
use App\Models\User;
use App\Models\RfpTimeline;
use App\Models\OrderOrigin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Log;
use App\Models\Servers;
use App\Models\RfpLink;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\EveClient;
//use Illuminate\Support\Facades\DB;

class RfpController extends Controller
{
    private $_Rfp;
    private $_RfpLink;
    private $_Servers;
    public $return = ['Success' => true,'Msg'=> '', 'Data' => ''];

    public function __construct()
    {
        parent::__construct();

        $this -> _Rfp           = new Rfp();
        $this -> _RfpFood       = new RfpFood();
        $this -> _RfpRoom       = new RfpRoom();
        $this -> _RfpPlace      = new RfpPlace();
        $this -> _RfpEquipment  = new RfpEquipment();
        $this -> _User          = new User();
        $this -> _RfpTimeline   = new RfpTimeline();
        $this -> _OrderOrigin   = new OrderOrigin();

        $this -> EveClient      = new EveClient();
        $this -> _Logs           = new Logs();

        $this -> _RfpLink   = new RfpLink();
        $this -> _Servers   = new Servers();

        $this -> _Rfp_user = new RfpUser();

    }


    // 询单快照
    public function preview(Request $request)
    {
        $reqs = $request -> except( '_token' );
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        return view( '/rfp/preview' ,[ 'data' => $rfp_id ]);
    }

    public function confimPreview(Request $request)
    {
        $reqs = $request -> except( '_token' );
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        return view( '/rfp/preview_confim' ,[ 'data' => $rfp_id ]);
    }

    // 取消询单
    public function cancel(Request $request)
    {
        $reqs = $request -> except( '_token' );
        if(!isset($reqs['rfp_id'])){
            return returnJson(false,'','参数缺失');
        }
        $rfpDetail      = $this -> _Rfp -> getRfpDetail( $reqs['rfp_id'] );//获取会议基本信息
        if(!isset($rfpDetail[0]) || empty($rfpDetail[0]['rfp_no'])){
            return returnJson(false,'','询单信息有误');
        }
        //调用会唐接口取消订单
        $res = $this->cancelRfp($rfpDetail[0]['rfp_no'],'');
        if($res['errorno'] != 0){
            return returnJson(false,'',$res['msg']);
        }
        $updateData = [
            'status' => 60,
            'rfp_no' => '',
        ];

        DB::beginTransaction();
        try
        {
            $this -> _Rfp -> updateDatas( $reqs['rfp_id'], $updateData );
            $this -> _RfpTimeline -> addTimeline( $reqs['rfp_id'], 108);
            $this -> _Logs -> addLog($rfpDetail[0],$reqs['rfp_id'],'会议'.$rfpDetail[0]['meeting_code'].'已经取消询单',$this-> __url);
            DB::commit();
            return returnJson(true,'','取消询单成功');
        }
        catch(\Exception $e)
        {
            //写入文本日志
            $message = "取消询单,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            DB::rollBack();
            return returnJson(false,'','会唐取消成功，本地取消询单失败');
        }


    }
    public function cancelRfp($rfpNo, $supplierRfpNo) {
        $this->open_api();
        $data['rfpNo']         = $rfpNo;
        $data['supplierRfpNo'] = $supplierRfpNo;
        $array['signature']    = $this->eveClient->generateSign($data);
        $array['param']        = json_encode($data);
        $result                = $this->http->httppost(config( 'links.open_api_url' ) . '/Monarch/cancelRfp', $array, $this->token);
        $result                = json_decode($result, true);
        return $result;
    }

    // 我的询单
    public function index(Request $request)
    {
        $reqs       = $request -> except( '_token' );
        $data       = $this->getRfpList($reqs);
        $provinces  = $this->getProvinces();
        $status     = config('system.meeting_status');
        $bitTypes =  config('system.bit_type');

        //分配服务商时的服务商数据
        $servers = DB::table('servers')
            ->select('s_id','name')
            ->where('status','!=',0)
            ->where('status','!=',3)
            ->get();

            //dd($data);
        return view( '/rfp/index' , ["data" =>  $data, 'provinces' => $provinces, 'status' => json_encode($status),'bitTypes'=>json_encode($bitTypes), 'servers' => $servers]);
    }

    //询单列表
    public function rfpList(Request $request){
        $reqs = $request -> except( '_token' );
        return $this->getRfpList($reqs);
    }
    public function getRfpList($reqs){
        //格式化参数
        //$begin_date                 = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        //$end_date                   = date('Y-m-d 23:59:59', strtotime("$begin_date +1 month -1 day"));// 获取当前月份最后一天
        $begin_date                 = date('Y-01-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        $end_date                   = date('Y-m-d 23:59:59', time());// 获取当前月份最后一天
        //$where['startTime']         = empty($reqs['start_time'])?strtotime($begin_date):strtotime($reqs['start_time']);
        //$where['endTime']           = empty($reqs['end_time'])?strtotime($end_date):strtotime($reqs['end_time']);
        $where['startTime']         = empty($reqs['start_time'])?'':strtotime($reqs['start_time']);
        $where['endTime']           = empty($reqs['end_time'])?'':strtotime($reqs['end_time']);
        $where['status']            = empty($reqs['status'])?'':filterParam( $reqs['status'] );//会议状态
        $where['key']               = empty($reqs['keyword'])?'':filterParam( $reqs['keyword'] );//关键字
        $where['provincedesc']      = empty($reqs['provincedesc'])?'':filterParam( $reqs['provincedesc'] );//省份
        $_bit_type          = (!isset($reqs['bitType']) || $reqs['bitType'] == '')?'':filterParam( $reqs['bitType'] );//竞标类型
        $page                       = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                      = empty($reqs['limit'])?10:(int)$reqs['limit'];
        $info['page']               = $page;
        $info['limit']              = $limit;
        $info['filter'] = array(
            "start"     =>  $where['startTime'],
            "end"       =>  $where['endTime'],
            "provincedesc"       =>  $where['provincedesc'],
            "keyword"   =>  $where['key'],
            'status'    =>  $where['status'],
            'bit_type'    =>  $_bit_type,
        );
        $where          = array_filter($where);//去空
        if($_bit_type !== ''){
            $where['bit_type'] = $_bit_type;
        }
        $data           = array('where'=>$where,'page'=>$page,'limit'=>$limit);
        //构造sql语句
        $sql            = $this->formatSql($data);

        try
        {
            $count      = DB::select($sql['sql_count']);
            $list       = DB::select($sql['sql']);
            //查看已分配服务商的rfp
            $head_id = $this -> _RfpLink ->getHeadId();
            $rfta = [];
            foreach($list as $rft) {
                $rft['flag']=0;
                foreach($head_id as $head){

                    if($rft['rfp_id'] == $head['rfp_id']){
                        $rft['flag']=1;
                    }
                }
                array_push($rfta,$rft);
            }
            $info['count'] = $count[0]['count'];
            if(empty($rfta))return json_encode($info);
            $info += $rfta;
            $bit_type =  config('system.bit_type');
            foreach ($rfta as $key=>$val){
                $type = 0;
                $info[$key]['start_time_val']   = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
                $info[$key]['end_time_val']     = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
                $time_extend = json_decode($val['time_extend'],true);
                $info[$key]['time_extend']      = '';
                $time_extend_list = array();
                if(!empty($val['time_extend']) && !empty($time_extend)){
                    $info[$key]['time_extend']  = $time_extend;
                    foreach ($time_extend as $k=>$v){
                        $time_extend_list[$k]['start_time_val'] = empty($v['start_time'])?'':date('Y-m-d',$v['start_time']);
                        $time_extend_list[$k]['end_time_val']   = empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
                    }
                }
                $info[$key]['time_extend_val']  = $time_extend_list;
                if(!empty($val['deposit_code']))$type=1;
                $info[$key]['timeline']         = $this->getTimeLine($val['rfp_id'],$type,$val['status']);
                $info[$key]['bit_type_desc'] = isset($bit_type[$val['bit_type']]) ? $bit_type[$val['bit_type']] : '';

            }
            return json_encode($info);
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "我的询单列表,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array();
        }
    }

    public function formatSql($data){
        $where = $data['where'];
        $field = 'rfp_id,meeting_code,meeting_name,meeting_type_desc,bit_type,start_time,end_time,time_extend,budget_total_amount,clientele_num,within_num,nonparty_num,provincedesc,citydesc,people_num,status,rfp_no, order_no';
        $sql   = 'SELECT [*] FROM rfp WHERE 1=1';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $where_role = array();
        if (!in_array('超级管理员',$roles)) {
            if (in_array('会议发起人', $roles)) {
                $where_role[] = ' (user_code = ' . session('user')['id'].' or deposit_code= '. session('user')['id'] .')';
            }
            if (in_array('会议授权人', $roles) ) {
                $where_role[] = ' user_code = ' . session('user')['id'];
            }
            if (in_array('费用审核员', $roles)) {
                $where_role[] = ' marketorgcode = "' . session('user')['marketorgcode'] . '"';
            }
        }
        if(!empty($where_role)){
            $sql .= ' and '.implode(' and ',$where_role);
        }
        // 根据会议状态查询
        if (isset($where['status'])) {
            $sql .= sprintf(' AND status = %d', $where['status']);
        }
        // 根据竞标类型查询
        if (isset($where['bit_type'])) {
            $sql .= sprintf(' AND bit_type = %d', $where['bit_type']);
        }
        if (isset($where['key'])) {
            $sql .= sprintf(' AND (user_name LIKE "%s" OR meeting_code LIKE "%s" OR meeting_name LIKE "%s" OR meeting_type_desc LIKE "%s" )', '%'.$where['key'].'%', '%'.$where['key'].'%', '%'.$where['key'].'%', '%'.$where['key'].'%');
        }
        if (isset($where['provincedesc'])) {
            $sql .= ' AND provincedesc = "' . $where['provincedesc'] . '"';
        }
        // 根据会议开始时间结束时间查询
        if (isset($where['startTime'])) {
            $sql .= sprintf(' AND create_time >= %d ',$where['startTime']);
        }
        if (isset($where['endTime'])) {
            $sql .= sprintf(' AND create_time <= %d ',$where['endTime']);
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

    public function getTimeLine($rfp_id,$type,$status)
    {
        if(empty($rfp_id))return '';
        //获取会议基本信息
        $timeline = DB::table('rfp_timeline')->where('rfp_id', $rfp_id)->orderby('id','desc')->get();
        if(empty($timeline)){
            return json_encode(array());
        }
        //构造参数
        $notice_list = array();
        $notice_type = array();
        foreach ($timeline as $k=>$v){
            if(!in_array($v['step'],$notice_type)) {
                $step = $v['step']-1;
                $notice_list[$k]['notice_ctime']        = date('Y-m-d H:i', $v['completed_time']);
                $notice_list[$k]['notice_type']         = $step;
                $notice_list[$k]['notice_type_name']    = config('timeline.timeline.' . $step);
                $notice_list[$k]['url']                 = $this->getRoles($step,$timeline[0]['step'],$type,$status);
                $notice_type[]                          = $v['step'];
            }
        }
        $notice_list[] = array(
            'notice_ctime'          => date('Y-m-d H:i'),
            'notice_type'           => $timeline[0]['step'],
            'notice_type_name'      => config('timeline.timeline.' . $timeline[0]['step']),
            'url'                   =>$this->getRoles($timeline[0]['step'],$timeline[0]['step'],'0',$status),
        );
        return array(
            'current' => $timeline[0]['step'],
            'step' => array_values($notice_list)
        );

    }

    /**
     * @param $step
     * @param $currentStep
     * @param int $type 托管会议1，普通0
     * @return array|mixed
     */
    private function getRoles($step,$currentStep,$type=0,$status){
        //TODO 用于测试10001
      /*  if(session('user')['id'] == '10001'){
            if(($step == 103 && in_array($currentStep,array('108','104'))) || ($currentStep == 103 && $step == 103 && $status == 21) || ($currentStep == 102 && $step == 101)){
                return config('timeline.timelinktest.'.$step.'_'.$currentStep);
            }else if($step<$currentStep){
                return config('timeline.timelinkindex.' . $step);
            }else{
                return config('timeline.timelinktest.' . $step);
            }
        }*/
        //TODO end
        $roles = array_column(session('user')['role'], 'name');//取出用户所有角色名称重新组成数组
        $create = array();
        $check = array();
        $admin = array();
        $deposit = array();
        if (in_array('会议发起人', $roles)) {
            $create = $this->createRole($step,$currentStep,$type,$status);
        }
        if (in_array('费用审核员', $roles) || in_array('超级管理员', $roles)){
            if($currentStep == '102'){
                $check = config('timeline.timelinkcheck.' . $step);
            }
            $admin = config('timeline.timelinkindex.' . $step);
        }
        if (in_array('会议授权人', $roles)){
            $deposit = $this->depositRole($step,$currentStep,$status);
        }
        if(!empty($check))return $check;
        if(!empty($create))return $create;
        if(!empty($deposit))return $deposit;
        if(!empty($admin))return $admin;

        return array();
    }
    private function createRole($step,$currentStep,$type=0,$status){
        if($type == 1){//托管会议权限
            if($currentStep == '107'){
                return config('timeline.timelinkcreate.' . $step);
            }else{
                return config('timeline.timelinkindex.' . $step);
            }
        }else{
            if(($step == 103 && in_array($currentStep,array('108','104'))) || ($currentStep == 103 && $step == 103 && $status == 21) || ($currentStep == 102 && $step == 101)){
                return config('timeline.timelinkcreate.'.$step.'_'.$currentStep);
            }else if($step<$currentStep){
                return config('timeline.timelinkindex.' . $step);
            }else{
                return config('timeline.timelinkcreate.' . $step);
            }
        }
    }

    private function depositRole($step,$currentStep,$status){
        if(($step == 103 && in_array($currentStep,array('108','104'))) || ($currentStep == 103 && $step == 103 && $status == 21) || ($currentStep == 102 && $step == 101)){
            return config('timeline.timelinkdeposit.'.$step.'_'.$currentStep);
        }else if($step<$currentStep){
            return config('timeline.timelinkindex.' . $step);
        }else{
            return config('timeline.timelinkdeposit.' . $step);
        }
    }

    // 创建询单
    public function create( Request $request )
    {
        $placeType  = config( 'system.place_type' );
        $star       = config( 'system.star' );
        $area       = config( 'system.area' );

        $data = $request->except('_token');
        $rfpId = isset($data['rfp_id']) ? $data['rfp_id'] : 0;

        $data = $this->getRfp($rfpId);
        //获取参会人
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfpId
            ]
        ] ];
        $join_user = $this -> _Rfp_user ->getDatas($conditions);
        $user_ids = array();
        if(!empty($join_user)){
            foreach ($join_user as $val){
                $user_ids[] = $val['join_id'];
            }
        }
        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }

        return view( '/rfp/create', [
            'placeType' => $placeType,
            'star'      => $star,
            'area'      => $area,
            'ids_str'      => $ids_str,
            'rfpId'      => $rfpId,
            'data'      => json_encode($data),
        ]);
    }

    // 智能推荐
    public function recommend( Request $request )
    {
        $reqs = $request -> except('_token');
        $rfp_id     = !empty( $reqs["rfp_id"] ) ? $reqs["rfp_id"] : 0;
        $city_id    = !empty( $reqs["city_id"] ) ? $reqs["city_id"] : 1;

        $place      = $this -> _RfpPlace->getRfpPlace($rfp_id);
        $rfpDetail  = $this -> _Rfp -> getRfpDetail( $rfp_id );//获取会议基本信息
        //转换格式，前端识别
        $rfpDetail[0]['time_extend'] = isset($rfpDetail[0]['time_extend'])?json_decode($rfpDetail[0]['time_extend']):'';

        $equipment  = $this -> _RfpEquipment->getRfpEquipment($rfp_id);
        //搜索价格范围
        $priceNum      = isset($equipment[0]['budget_account'])?$equipment[0]['budget_account']:0;
        $priceConfig    = config('system.price');
        $price_select   = 0;
        foreach($priceConfig AS $key => $value){
            if($priceNum >= $value['min'] && $priceNum <= $value['max']){
                $price_select = $key;
            }
        }

        //获取参会人数,并且为客户推荐人数方面数据
        $peopleNum      = $rfpDetail[0]['people_num'];
        $peoleConfig    = config('system.place_people_num');
        $peopleSelect   = 0;
        foreach($peoleConfig AS $key => $value){
            if($peopleNum >= $value['min'] && $peopleNum <= $value['max']){
                $peopleSelect = $key;
            }
        }


        $searchData['city_id']              = $city_id;
        $searchData['place_type']           = isset($place[0]['place_type']) ? $place[0]['place_type'] : '';
        $searchData['place_star']           = isset($place[0]['place_star']) ? $place[0]['place_star'] : '';
        $searchData['position']             = isset($place[0]['place_location']) ? $place[0]['place_location'] : '';
        //$searchData['is_window']            = isset($place[0]['place_type']) ? $place[0]['place_type'] : '';
        $searchData['layout']               = isset($place[0]['table_decoration']) ? $place[0]['table_decoration'] : '';
        //$searchData['is_column']            = isset($reqs['is_column']) ? $reqs['is_column'] : '';
        if($price_select){
            $searchData['meeting_room_min_price'] = $priceConfig[$price_select]['min'];
            $searchData['meeting_room_max_price'] = $priceConfig[$price_select]['max'];
        }
        if($peopleSelect){
            $searchData['place_people_num'] = $peoleConfig[$peopleSelect]['min'];
            $searchData['place_people_max'] = $peoleConfig[$peopleSelect]['max'];
        }
        $searchData['place_people_num']     = isset($reqs['meeting_people']) ? $reqs['meeting_people'] : '';

        $searchData['key_words']            = isset($reqs['key_words']) ? $reqs['key_words'] : '';
        $searchData['page']                 = isset($reqs['page']) ? $reqs['page'] : '1';

        $searchData = self::clearNull($searchData);


        $url = config('links.palce_api').'/search';
        $res = doCurlGetRequest($url.'/v2', $searchData);

        //排除协议酒店
        $notInIds = '';
        $res = json_decode($res, true);
        if(!empty($res['rows'])) foreach($res['rows'] AS $key => $value){
            $notInIds .= $value['old_place_id'].',';
        }

        $searchData['display_place_ids'] = $notInIds ? substr($notInIds, 0, -1) : '';

        $res = doCurlGetRequest($url, $searchData);



        $get_back = [
            'rfp_id'            => $rfp_id,
            'city_id'           => $city_id,
            'place_type'        => $place[0]['place_type'],
            'place_star'        => $place[0]['place_star'],
            'place_location'    => $place[0]['place_location'],
            'people_select'     => $peopleSelect,
            'area_select'       => 0,
            'price_select'       => $price_select,
        ];// 带回参数

        if(!empty($place[0]['place_location'])){
            $selectArr = explode('-', $place[0]['place_location']);
            $selectOne = $selectArr[0];
            if($selectOne == 'area_id'){
                $areaArr = $this -> _RfpPlace->getAreaCity($city_id);
                $areaArr = json_decode($areaArr, true);
                foreach($areaArr AS $key => $value){
                    $areaArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $areaArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['area'] = $areaArr;
            }elseif($selectOne == 'business_id'){
                $businessArr = $this -> _RfpPlace->getHotBusinessDistrict( $city_id );
                $businessArr = json_decode($businessArr, true);
                foreach($businessArr AS $key => $value){
                    $businessArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $businessArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['business'] = $businessArr;
            }elseif($selectOne == 'airport_id'){
                $airportArr = $this -> _RfpPlace->getDisplayAirport( $city_id );
                $airportArr = json_decode($airportArr, true);
                foreach($airportArr AS $key => $value){
                    $airportArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $airportArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['airport'] = $airportArr;
            }elseif($selectOne == 'train_station_id'){
                $trainArr = $this -> _RfpPlace->getDisplayTrainStation( $city_id );
                $trainArr = json_decode($trainArr, true);
                foreach($trainArr AS $key => $value){
                    $trainArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $trainArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['train'] = $trainArr;
            }elseif($selectOne == 'metro'){
                $metroArr = $this -> _RfpPlace->getMetroLines( $city_id );
                $metroArr = json_decode($metroArr, true);

                foreach($metroArr AS $key => $value){
                    $metroArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $metroArr[$key]['selected'] = true;
                        foreach($value['stations'] AS $vkey => $vv){
                            $metroArr[$key]['stations'][$vkey]['selected'] = false;
                           // echo $selectArr[2];exit;
                            if($vkey == $selectArr[2]){
                                $metroArr[$key]['stations'][$vkey]['selected'] = true;
                            }

                        }
                    }else{
                        foreach($value['stations'] AS $vkey => $vv){
                            $metroArr[$key]['stations'][$vkey]['selected'] = false;
                        }
                    }

                }
                $get_back['select']['metro'] = $metroArr;
            }
        }else{
            $get_back['select'] = '';
        }

        $res = json_decode($res, true);



        $mapJson = [];
        if($res['total'] > 0){
            foreach($res['rows'] AS $key => $value){
                $map                                = [];
                $location                           = [];
                $map['place_id']                    = $value['place_id'];
                $map['place_name']                  = $value['place_name'];
                $location                           = explode(',', $value['location']);
                $map['lat']                         = isset($location[0]) ? $location[0] : '';
                $map['lng']                         = isset($location[1]) ? $location[1] : '';
                $mapJson[]                          = $map;
                $res['rows'][$key]['place_desc']    = $this->rehtml($value['place_desc']);
                $res['rows'][$key]['address']    = $this->rehtml($value['address']);
                if(isset($res['rows'][$key]['wed_content'])){
                    unset($res['rows'][$key]['wed_content']);
                }
                if(isset($res['rows'][$key]['policy'])){
                    unset($res['rows'][$key]['policy']);
                }

                $res['rows'][$key]['main_pic_url']  = get_img_url($value['main_pic_url']).$value['main_pic_url'];
            }
        }else{
            $mapJson = [];
        }

        return view( '/rfp/recommend', ['rfp' => json_encode($rfpDetail[0]), 'data' => $get_back, 'mapJson' => json_encode($mapJson), 'placeData' => json_encode($res)] );
    }


    // 智能推荐
    public function mainRecommend( Request $request )
    {
        $reqs = $request -> except('_token');
        $rfp_id     = !empty( $reqs["rfp_id"] ) ? $reqs["rfp_id"] : 0;
        $city_id    = !empty( $reqs["city_id"] ) ? $reqs["city_id"] : 1;

        $place      = $this -> _RfpPlace->getRfpPlace($rfp_id);
        $rfpDetail  = $this -> _Rfp -> getRfpDetail( $rfp_id );//获取会议基本信息
        //转换格式，前端识别
        $rfpDetail[0]['time_extend'] = isset($rfpDetail[0]['time_extend'])?json_decode($rfpDetail[0]['time_extend']):'';

        $equipment  = $this -> _RfpEquipment->getRfpEquipment($rfp_id);
        //搜索价格范围
        $priceNum      = isset($equipment[0]['budget_account'])?$equipment[0]['budget_account']:0;
        $priceConfig    = config('system.price');
        $price_select   = 0;
        foreach($priceConfig AS $key => $value){
            if($priceNum >= $value['min'] && $priceNum <= $value['max']){
                $price_select = $key;
            }
        }

        //获取参会人数,并且为客户推荐人数方面数据
        $peopleNum      = $rfpDetail[0]['people_num'];
        $peoleConfig    = config('system.place_people_num');
        $peopleSelect   = 0;
        foreach($peoleConfig AS $key => $value){
            if($peopleNum >= $value['min'] && $peopleNum <= $value['max']){
                $peopleSelect = $key;
            }
        }


        $searchData['city_id']              = $city_id;
        $searchData['place_type']           = isset($place[0]['place_type']) ? $place[0]['place_type'] : '';
        $searchData['place_star']           = isset($place[0]['place_star']) ? $place[0]['place_star'] : '';
        $searchData['position']             = isset($place[0]['place_location']) ? $place[0]['place_location'] : '';
        //$searchData['is_window']            = isset($place[0]['place_type']) ? $place[0]['place_type'] : '';
        $searchData['layout']               = isset($place[0]['table_decoration']) ? $place[0]['table_decoration'] : '';
        //$searchData['is_column']            = isset($reqs['is_column']) ? $reqs['is_column'] : '';
        if($price_select){
        $searchData['meeting_room_min_price'] = $priceConfig[$price_select]['min'];
        $searchData['meeting_room_max_price'] = $priceConfig[$price_select]['max'];
        }
        if($peopleSelect){
            $searchData['place_people_num'] = $peoleConfig[$peopleSelect]['min'];
            $searchData['place_people_max'] = $peoleConfig[$peopleSelect]['max'];
        }
        $searchData['place_people_num']     = isset($reqs['meeting_people']) ? $reqs['meeting_people'] : '';

        $searchData['key_words']            = isset($reqs['key_words']) ? $reqs['key_words'] : '';
        $searchData['page']                 = isset($reqs['page']) ? $reqs['page'] : '';

        $searchData = self::clearNull($searchData);

        $url = config('links.palce_api').'/search/v2';

        $res = doCurlGetRequest($url, $searchData);



        $get_back = [
            'rfp_id'            => $rfp_id,
            'city_id'           => $city_id,
            'place_type'        => $place[0]['place_type'],
            'place_star'        => $place[0]['place_star'],
            'place_location'    => $place[0]['place_location'],
            'people_select'     => $peopleSelect,
            'area_select'       => 0,
            'price_select'       => $price_select,
        ];// 带回参数

        if(!empty($place[0]['place_location'])){
            $selectArr = explode('-', $place[0]['place_location']);
            $selectOne = $selectArr[0];
            if($selectOne == 'area_id'){
                $areaArr = $this -> _RfpPlace->getAreaCity($city_id);
                $areaArr = json_decode($areaArr, true);
                foreach($areaArr AS $key => $value){
                    $areaArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $areaArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['area'] = $areaArr;
            }elseif($selectOne == 'business_id'){
                $businessArr = $this -> _RfpPlace->getHotBusinessDistrict( $city_id );
                $businessArr = json_decode($businessArr, true);
                foreach($businessArr AS $key => $value){
                    $businessArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $businessArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['business'] = $businessArr;
            }elseif($selectOne == 'airport_id'){
                $airportArr = $this -> _RfpPlace->getDisplayAirport( $city_id );
                $airportArr = json_decode($airportArr, true);
                foreach($airportArr AS $key => $value){
                    $airportArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $airportArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['airport'] = $airportArr;
            }elseif($selectOne == 'train_station_id'){
                $trainArr = $this -> _RfpPlace->getDisplayTrainStation( $city_id );
                $trainArr = json_decode($trainArr, true);
                foreach($trainArr AS $key => $value){
                    $trainArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $trainArr[$key]['selected'] = true;
                    }
                }
                $get_back['select']['train'] = $trainArr;
            }elseif($selectOne == 'metro'){
                $metroArr = $this -> _RfpPlace->getMetroLines( $city_id );
                $metroArr = json_decode($metroArr, true);

                foreach($metroArr AS $key => $value){
                    $metroArr[$key]['selected'] = false;
                    if($key == $selectArr[1]){
                        $metroArr[$key]['selected'] = true;
                        foreach($value['stations'] AS $vkey => $vv){
                            $metroArr[$key]['stations'][$vkey]['selected'] = false;
                            // echo $selectArr[2];exit;
                            if($vkey == $selectArr[2]){
                                $metroArr[$key]['stations'][$vkey]['selected'] = true;
                            }

                        }
                    }else{
                        foreach($value['stations'] AS $vkey => $vv){
                            $metroArr[$key]['stations'][$vkey]['selected'] = false;
                        }
                    }

                }
                $get_back['select']['metro'] = $metroArr;
            }
        }else{
            $get_back['select'] = '';
        }

        $res = json_decode($res, true);


        $mapJson = [];
        if($res['total'] > 0){
            foreach($res['rows'] AS $key => $value){
                $map                                = [];
                $location                           = [];
                $map['place_id']                    = $value['place_id'];
                $map['place_name']                  = $value['place_name'];
                $location                           = explode(',', $value['location']);
                $map['lat']                         = $location[0];
                $map['lng']                         = $location[1];
                $mapJson[]                          = $map;
                $res['rows'][$key]['place_desc']    = $this->rehtml($value['place_desc']);
                if(isset($res['rows'][$key]['wed_content'])){
                    unset($res['rows'][$key]['wed_content']);
                }
                if(isset($res['rows'][$key]['policy'])){
                    unset($res['rows'][$key]['policy']);
                }
                if(isset($res['rows'][$key]['address_en'])){
                    unset($res['rows'][$key]['address_en']);
                }
                if(isset($res['rows'][$key]['telephone'])){
                    unset($res['rows'][$key]['telephone']);
                }
                //if(is_string($value))

                foreach($value AS $keys => $values){
                    if(is_string($values)){
                        $res['rows'][$key][$keys] = $this->rehtml($values);
                    }
                }

                foreach($value['meetings'] AS $m => $mv){
                    if(is_string($mv['meeting_name'])){
                        $res['rows'][$key]['meetings'][$m]['meeting_name'] = $this->rehtml($mv['meeting_name']);
                    }
                }
                $res['rows'][$key]['main_pic']  = get_img_url($value['main_pic']).$value['main_pic'];
            }
        }else{
            $mapJson = [];
        }
//dd(json_encode($res));
        return view( '/rfp/main_recommend', ['rfp' => json_encode($rfpDetail[0]), 'data' => $get_back, 'mapJson' => json_encode($mapJson), 'placeData' => json_encode($res)] );
    }



    static private function clearNull ( array $searchData ){

        foreach($searchData AS $key => $value){
            if(!$value){
                unset($searchData[$key]);
            }
        }
        return $searchData;
    }

    // 编辑询单
    public function edit( Request $request )
    {
        $data = $request->except('_token');
        $rfpId = isset($data['rfp_id']) ? $data['rfp_id'] : 0;

        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }

        $data = $this->getRfp($rfpId);
        //获取参会人
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfpId
            ]
        ] ];
        $join_user = $this -> _Rfp_user ->getDatas($conditions);
        $user_ids = array();
        if(!empty($join_user)){
            foreach ($join_user as $val){
                $user_ids[] = $val['join_id'];
            }
        }
        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }

        return view( '/rfp/edit', ["data" => json_encode($data), 'base' => $data, 'ids_str'=>$ids_str,'rfpId'=>$rfpId ] );
    }
    public function downOrder( Request $request ){
        $data               = $request->except('_token');

        $rfpId              = isset($data['rfp_id']) ? $data['rfp_id'] : 0;
        $placeId            = isset($data['place_id']) ? $data['place_id'] : 0;
        $placeMapId         = isset($data['place_map_id']) ? $data['place_map_id'] : 0;
        $placeRfpId         = isset($data['place_rfp_id']) ? $data['place_rfp_id'] : 0;
        $orderTotalAmount   = isset($data['order_total_amount']) ? $data['order_total_amount'] : 0;

        $this->checkParam( $rfpId, $placeId, $placeMapId, $placeRfpId, $orderTotalAmount );


        $param = [
            'place_offer' => [
                'map_id'    => $placeMapId,
                'rfp_id'    => $rfpId,
                'place_id'  => $placeId,
            ],
        ];

        $res        = $this->downOrderToOpenApi( $param );
        $localRes   = $this->downOrderToLocal( $data, $res );

    }
    private function downOrderToLocal( $data, $res ){
        $placeMpId              = $data['place_map_id'];// 会唐场地报价id
        $rfpId                  = $data['rfp_id'];// 本地询单主键id
        $htOrderNo              = $res['place_order']['order_no'];// 服务端返回的场地订单号
        $placeId              = $data['place_id'];
        $placeOrderTotalMoney   = !empty($res['place_order']['total_money']) ? $res['place_order']['total_money'] : 0;

        $originOrderTotalAmount = !empty($rfp_info['order_total_amount']) ? $rfp_info['order_total_amount'] : 0;

        $update = [];
        $update['status']                   = 40;
        $update['order_total_amount']       = $placeOrderTotalMoney;
        $update['order_no']                 = $htOrderNo;
        $update['place_id']                 = $placeId;
        $update['selected_place_map_id']    = $placeMpId;
        $update['create_order_time']        = time();

        $this -> _Rfp -> updateDatas($rfpId, $update);

        $insert = [];
        $insert['rfp_id']               = $rfpId;
        $insert['sinopec_order']        = json_encode($res);
        $insert['sinopec_big_order']    = 0;

        $this ->_OrderOrigin -> insertDatas($insert);

        $this -> _RfpTimeline -> addTimeline( $rfpId, 105);
        $this -> _RfpTimeline -> addTimeline( $rfpId, 106);

        $this->return['Success'] = true;
        $this->return['Data']    = '';
        $this->return['Msg']     = '下单成功';
        echo json_encode($this->return);
        exit;

    }
    private function downOrderToOpenApi( $param ){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign($param);
        $array['param']     = json_encode($param);
        $result             = $this->http->httppost(config( 'links.open_api_url' ) . '/MonarchOrder/create_sinopec_order?', $array, $this->token);

        $result             = json_decode($result, true);

        if ($result['errorno'] != 0 || empty($result['data'])) {
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '创建订单失败,请稍候再试';
            echo json_encode($this->return);
            exit;
        }

        return $result['data'];
    }
    private function checkParam( $rfpId, $placeId, $placeMapId, $placeRfpId, $orderTotalAmount ){
        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }
        if(!$placeId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少场地信息';
            echo json_encode($this->return);
            exit;
        }
        if(!$placeMapId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少报价信息';
            echo json_encode($this->return);
            exit;
        }
        if(!$placeRfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少场地方询单询单信息';
            echo json_encode($this->return);
            exit;
        }
        if(!$orderTotalAmount){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少订单总金额';
            echo json_encode($this->return);
            exit;
        }
    }
    private function getRfp( $rfpId ){
        $rfpDetail      = $this -> _Rfp -> getRfpDetail( $rfpId );//获取会议基本信息
        $rfpPlace       = $this -> _RfpPlace -> getRfpPlace( $rfpId );//获取场地需求
        $rfpEquipment   = $this -> _RfpEquipment -> getRfpEquipment( $rfpId );//获取住宿需求
        $rfpFood        = $this -> _RfpFood -> getRfpFood( $rfpId );//获取餐饮需求
        $rfpRoom        = $this -> _RfpRoom -> getRfpRoom( $rfpId );//获取住宿需求

        $data['detail']                     = $rfpDetail[0];
        $data['detail']['time_extend']      = !empty($data['detail']['time_extend'])?str_replace(array('"'), '\"', $data['detail']['time_extend']):'';
        $data['detail']['start_time']       = !empty($data['detail']['start_time']) ? date('Y-m-d', $data['detail']['start_time']) : '';
        $data['detail']['end_time']         = !empty($data['detail']['end_time']) ? date('Y-m-d', $data['detail']['end_time']) : '';
        $data['detail']['trip_start_time']  = !empty($data['detail']['trip_start_time']) ? date('Y-m-d', $data['detail']['trip_start_time']) : '';
        $data['detail']['trip_end_time']    = !empty($data['detail']['trip_end_time']) ? date('Y-m-d', $data['detail']['trip_end_time']) : '';

        $data['area']       = self::clearArea($rfpPlace);
        $data['equip']      = self::clearEquipentAndPlace( $rfpPlace, $rfpEquipment );
        $data['food']       = self::clearFood($rfpFood)['food'];
        sort($data['food']);
        $data['wine']       = self::clearFood($rfpFood)['wine'];
        sort($data['wine']);
        $data['room']       = self::clearRooms($rfpRoom);

        $data['detail']['citycode'] = in_array($data['detail']['provincecode'], config('system.city')) ? $data['detail']['provincecode'] : $data['detail']['citycode'];

        return $data;
    }

    private static function clearRooms($rfpRoom){

        foreach( $rfpRoom as $key => $value){
            $rfpRoom[$key]['type'] = isset(config('system.room_type')[$value['type']]) ? config('system.room_type')[$value['type']] : '';
            $rfpRoom[$key]['type_id'] = $value['type'];
        }
        return $rfpRoom;
    }

    private static function clearEquipentAndPlace( $place, $equipment ){

        $newPlace = [];
        foreach( $place AS $key => $value ){
            $newPlace[$value['form_key']] = $value;
        }
        $equipmentArr = config('system.equipment_type');
        foreach( $equipment AS $key => $value ){
            if(isset($newPlace[$value['form_key']])){
                $equipment[$key]['table_decoration'] = isset(config('system.table_type')[$newPlace[$value['form_key']]['table_decoration']]) ? config('system.table_type')[$newPlace[$value['form_key']]['table_decoration']] : '';
                $equipment[$key]['table_decoration_id'] = $newPlace[$value['form_key']]['table_decoration'];
                $equipment[$key]['meeting_people'] = $newPlace[$value['form_key']]['meeting_people'];
                $equipment[$key]['start_date'] = $newPlace[$value['form_key']]['start_date'];
                $equipment[$key]['end_date'] = $newPlace[$value['form_key']]['end_date'];
                $equipment[$key]['date_note'] = $newPlace[$value['form_key']]['date_note'];
                $equipment[$key]['domain_note'] = $newPlace[$value['form_key']]['domain_note'];
                $equipment[$key]['place_star'] = $newPlace[$value['form_key']]['place_star'];
                $equipment[$key]['str_e'] = '';
                foreach( $value AS $vkey => $vv ){
                    if( isset($equipmentArr[$vkey]) && $vv > 0 ){
                        $equipment[$key][$vkey]     = $equipmentArr[$vkey]['name'].'×'.$vv;
                        $equipment[$key]['str_e']   .= $equipmentArr[$vkey]['name'].'×'.$vv.'  ';
                        $equipment[$key]['v_'.$vkey]     = $vv;
                    }
                }

            }
        }
        return $equipment;
    }

    private static function clearFood ( $food ){
        $foodClear = [];
        $wineClear = [];
        if(!empty( $food )){
            $i = 0;
            foreach( $food AS $key => $value ){
                if(!$value['food_water']){
                    $foodClear[$i]['type']      = isset(config('system.food_type')[$value['rice_type']]) ? config('system.food_type')[$value['rice_type']] : '';
                    $foodClear[$i]['style']     = isset(config('system.dining_type')[$value['dining_type']]) ? config('system.dining_type')[$value['dining_type']] : '';
                    $foodClear[$i]['type_id']   = $value['rice_type'];
                    $foodClear[$i]['style_id']  = $value['dining_type'];
                    $foodClear[$i]['amount']    = $value['people'];
                    $foodClear[$i]['price']     = $value['unit_price'];
                    $foodClear[$i]['budget']    = $value['budget_account'];
                    $foodClear[$i]['desc']      = $value['food_description'];
                    $foodClear[$i]['time']      = $value['food_time'];
                    $foodClear[$i]['menu']      = $value['food_menu'];
                    $foodClear[$i]['food_id']   = $value['food_id'];
                }else{
                    $wineClear[$i]['type']      = isset(config('system.wine')[$value['rice_type']]) ? config('system.food_type')[$value['rice_type']] : '';
                    $wineClear[$i]['style']     = isset(config('system.dining_type')[$value['dining_type']]) ? config('system.dining_type')[$value['dining_type']] : '';
                    $wineClear[$i]['type_id']   = $value['rice_type'];
                    $wineClear[$i]['style_id']  = $value['dining_type'];
                    $wineClear[$i]['amount']    = $value['people'];
                    $wineClear[$i]['price']     = $value['unit_price'];
                    $wineClear[$i]['budget']    = $value['budget_account'];
                    $wineClear[$i]['desc']      = $value['food_description'];
                    $wineClear[$i]['time']      = $value['food_time'];
                    $wineClear[$i]['menu']      = $value['food_menu'];
                    $wineClear[$i]['food_id']   = $value['food_id'];
                }

                $i ++ ;
            }
        }
        $clear['food'] = $foodClear;
        $clear['wine'] = $wineClear;

        return $clear;
    }

    private static function clearArea ( $place ){
        $area = [];
        if(!empty( $place )){
            $area['type']           = isset(config('system.place_type')[$place[0]['place_type']]) ? config('system.place_type')[$place[0]['place_type']] : '';
            $area['type_id']           = $place[0]['place_type'];
            $area['location'] = $place[0]['place_location'];
            $area['star']           = isset(config('system.star')[$place[0]['place_star']]) ? config('system.star')[$place[0]['place_star']] : '';
            $area['star_id']           = $place[0]['place_star'];
            $area['rfp_place_id']   = $place[0]['rfp_place_id'];

            $area['hotel']          = json_decode( $place[0]['place_id_and_name_json'], TRUE );

        }
        return $area;
    }

    public function rfpSubmit( Request $request ){

        if( !$request -> isMethod( 'POST' ) ){
            $this->return['Success'] = false;
            $this->return['Msg']     = '不支持的传参方式';
            $this->return['Data']    = '';
            echo json_decode($this->return);exit;
        }

        $data       = $request->except('_token');
        $rfpDetail  = $this -> _Rfp ->getRfpDetail( $data['rfp_id'] );//获取会议基本信息
        $param      = $this->rfpDataClear( $data, $rfpDetail );
    }

    public function rfpDataClear( $data, $rfpDetail ){
        //$clearData
    }

    public function confirmMemo( Request $request )
    {
        $reqs   = $request -> except( '_token' );
        $rfpId  = $reqs['rfp_id'];
        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }

        $rfpData = $this->getRfp($rfpId);

        if($rfpData['detail']['bit_type'] == 1){
            $data = $this->getRfpAndOfferList(['rfp_no' => $rfpData['detail']['rfp_no']]);
            $data = json_decode($data, true);
            return view( '/rfp/confirmMemoAuction', [ 'data' =>  json_encode($data['data']), 'baseRfpInfo' => json_encode($rfpData) ]);
        }

        $data = $this->getOfferList($rfpId);
        if(!empty($data)){
            $data = $this->arraySequence($data, 'total_price', 'SORT_ASC');
        }

        return view( '/rfp/confirmMemo', [ 'data' =>  json_encode($data), 'baseRfpInfo' => json_encode($rfpData) ]);
    }
    private function arraySequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        foreach($array as $key => $va){
            if($key == 0){
                $array[$key]['beast'] = 1;
            }else{
                $array[$key]['beast'] = 0;
            }
        }
        return $array;
    }

    public function confirmMemoAuction( Request $request )
    {
        $reqs   = $request -> except( '_token' );
        $rfpId  = $reqs['rfp_id'];
        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }

        $data = $this->getOfferList($rfpId);

        $rfpData = $this->getRfp($rfpId);

        return view( '/rfp/confirmMemoAuction', [ 'data' =>  json_encode($data), 'baseRfpInfo' => json_encode($rfpData) ]);
    }

    public function getAllCitiesOrderbyAbcd(){
        $this->open_api();
        $array['signature'] = $this->EveClient->generateSign();
        $array = [];
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getAllCitiesOrderbyAbcd?', $array, $this->token);
        print_r($result);exit;
    }


    public function getAreaCity( Request $request ){
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $this->open_api();
        $array['signature'] = $this->EveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getAreaCity?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }

    public function getProvinces(){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign();
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
    public function getCityNameById( Request $request ){
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $this->open_api();
        $array['signature'] = $this->EveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = [$cityId];
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getCityNameById?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }

    public function getHotBusinessDistrict( Request $request ){
        $this->open_api();
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getHotBusinessDistrict?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }
    public function getDisplayAirport( Request $request ){
        $this->open_api();
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getDisplayAirport?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }
    public function getDisplayTrainStation(  Request $request  ){
        $this->open_api();
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getDisplayTrainStation?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }
    public function getMetroLines(  Request $request  ){
        $this->open_api();
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getMetroLines?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }

    public function createRfp( Request $request ){
        $data       = $request->except('_token');
        //print_r($data);exit;
        $data = $data['param']['data'];
        parse_str( urldecode ( $data ), $array );
        $data = json_encode( $array );
        $data = json_decode($data, true);

        if(!isset($data['rfp_id'])){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }
        //$rfpDetail  = $this -> _Rfp ->getRfpDetail( $data['rfp_id'] );//获取会议基本信息
        $rfpDetail  = $this -> _Rfp ->getRfpDetail( $data['rfp_id'] );//获取会议基本信息
        if(!$rfpDetail){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '未知询单';
            echo json_encode($this->return);
            exit;
        }

        $res = $this -> parseRfpPostData( $data, $rfpDetail );

        $this -> _Rfp -> updateDatas( $data['rfp_id'], ['status' => 21] );

        $this->return['Success'] = true;
        $this->return['Data']    = '';
        $this->return['Msg']     = '成功';
        echo json_encode($this->return);

    }

    private function parseRfpPostData( $data, $rfpDetail ){
        $foodData           = isset($data['food']) ? $data['food'] : [];
        $wineData           = isset($data['wine']) ? $data['wine'] : [];
        $roomData           = isset($data['room']) ? $data['room'] : [];
        $areaData           = isset($data['area']) ? $data['area'] : [];
        $areaData['place']  = isset($data['place']) ? $data['place'] : [];
        $areaData['rfp_place_id']  = isset($data['rfp_place_id']) ? $data['rfp_place_id'] : [];
        $equipData          = isset($data['equip']) ? $data['equip'] : [];
        $otherData          = isset($data['other']) ? $data['other'] : [];



        //DB::beginTransaction();
        //try {
            $isEquipData    = !empty($equipData) ? $this->editEquip($rfpDetail[0]['rfp_id'], $equipData) : true;//设施
            $isAreaData     = !empty($areaData) ? $this->editArea($rfpDetail[0]['rfp_id'], $areaData) : true;//场地
            $isFoodData     = !empty($foodData) ? $this->editFood($rfpDetail[0]['rfp_id'], $foodData) : true;//餐饮
            $isWineData     = !empty($wineData) ? $this->editWine($rfpDetail[0]['rfp_id'], $wineData, $foodData['desc']) : true;//酒水
            $isRoomData     =  !empty($roomData) ? $this->editRoom($rfpDetail[0]['rfp_id'], $roomData) : true;//住宿

        /*} catch (Exception $e) {
            return $e->getMessage();
        }*/
       // DB::commit();
        return true;
    }

    private function editEquip ( $rfpId, $equipData ){
        //try {
            $i                  = 0;
            $equipDataInsert    = [];

            foreach( $equipData AS $key => $value){
                if( !empty($value['equipment_id']) && $value['equipment_id'] ){
                    //修改
                    if(is_numeric($key)) {
                        $equipDataUpdate['rfp_id'] = $rfpId;
                        $equipDataUpdate['key95'] = isset($value['95']) && $value['95'] ? $value['95'] : 0;
                        $equipDataUpdate['key96'] = isset($value['96']) && $value['96'] ? $value['96'] : 0;
                        $equipDataUpdate['key97'] = isset($value['97']) && $value['97'] ? $value['97'] : 0;
                        $equipDataUpdate['key98'] = isset($value['98']) && $value['98'] ? $value['98'] : 0;
                        $equipDataUpdate['key99'] = isset($value['99']) && $value['99'] ? $value['99'] : 0;
                        $equipDataUpdate['key100'] = isset($value['100']) && $value['100'] ? $value['100'] : 0;
                        $equipDataUpdate['key101'] = isset($value['101']) && $value['101'] ? $value['101'] : 0;
                        $equipDataUpdate['key102'] = isset($value['102']) && $value['102'] ? $value['102'] : 0;
                        $equipDataUpdate['key103'] = isset($value['103']) && $value['103'] ? $value['103'] : 0;
                        $equipDataUpdate['key104'] = isset($value['104']) && $value['104'] ? $value['104'] : 0;
                        $equipDataUpdate['key105'] = isset($value['105']) && $value['105'] ? $value['105'] : 0;
                        $equipDataUpdate['key106'] = isset($value['106']) && $value['106'] ? $value['106'] : 0;
                        $equipDataUpdate['key107'] = isset($value['107']) && $value['107'] ? $value['107'] : 0;
                        $equipDataUpdate['key108'] = isset($value['108']) && $value['108'] ? $value['108'] : 0;
                        $equipDataUpdate['budget_account'] = isset($value['budget_account']) && $value['budget_account'] ? $value['budget_account'] : 0;
                        $equipDataUpdate['equipment_description'] = isset($value['desc']) && $value['desc'] ? $value['desc'] : 0;
                        $equipDataUpdate['form_key'] = $key;
                    }
                    $this -> _RfpEquipment -> updateDatas( $value['equipment_id'], $equipDataUpdate );
                }else{
                    //添加
                    if(is_numeric($key)){
                        $equipDataInsert[$i]['rfp_id']                  = $rfpId;
                        $equipDataInsert[$i]['key95']                   = isset($value['95']) && $value['95'] ? $value['95'] : 0;
                        $equipDataInsert[$i]['key96']                   = isset($value['96']) && $value['96'] ? $value['96'] : 0;
                        $equipDataInsert[$i]['key97']                   = isset($value['97']) && $value['97'] ? $value['97'] : 0;
                        $equipDataInsert[$i]['key98']                   = isset($value['98']) && $value['98'] ? $value['98'] : 0;
                        $equipDataInsert[$i]['key99']                   = isset($value['99']) && $value['99'] ? $value['99'] : 0;
                        $equipDataInsert[$i]['key100']                  = isset($value['100']) && $value['100'] ? $value['100'] : 0;
                        $equipDataInsert[$i]['key101']                  = isset($value['101']) && $value['101'] ? $value['101'] : 0;
                        $equipDataInsert[$i]['key102']                  = isset($value['102']) && $value['102'] ? $value['102'] : 0;
                        $equipDataInsert[$i]['key103']                  = isset($value['103']) && $value['103'] ? $value['103'] : 0;
                        $equipDataInsert[$i]['key104']                  = isset($value['104']) && $value['104'] ? $value['104'] : 0;
                        $equipDataInsert[$i]['key105']                  = isset($value['105']) && $value['105'] ? $value['105'] : 0;
                        $equipDataInsert[$i]['key106']                  = isset($value['106']) && $value['106'] ? $value['106'] : 0;
                        $equipDataInsert[$i]['key107']                  = isset($value['107']) && $value['107'] ? $value['107'] : 0;
                        $equipDataInsert[$i]['key108']                  = isset($value['108']) && $value['108'] ? $value['108'] : 0;
                        $equipDataInsert[$i]['budget_account']          = isset($value['budget_account']) && $value['budget_account'] ? $value['budget_account'] : 0;
                        $equipDataInsert[$i]['equipment_description']   = isset($value['desc']) && $value['desc'] ? $value['desc'] : 0;
                        $equipDataInsert[$i]['form_key']                = $key;
                    }
                }
            }
            if( !empty($equipDataInsert) ){
                $equipDataInsert = $this->checkNull($equipDataInsert);
                if(!empty($equipDataInsert)){
                    $this -> _RfpEquipment -> insertDatas( $equipDataInsert );
                }

            }
            return true;
       /* } catch (Exception $e) {
            //DB::rollback();
            return $e->getMessage();
        }*/

    }
    private function checkNull($data){
        foreach($data AS $key => $value){
            $nulls = 0;
            foreach($value AS $vk => $vv){
                if( !empty( $vv ) && $vk != 'rfp_id' && $vk != 'form_key' && $vk != 'food_water' ){
                    $nulls  = 1;
                    break;
                }
            }
            if($nulls == 0){
                unset($data[$key]);
            }
        }
        return $data;
    }

    private function editArea ( $rfpId, $areaData ){
       // try {
        $i                  = 0;
        $areaDataInsert     = [];
        $placeData = isset($areaData['place']) ? $areaData['place'] : [];

        //if( !empty($placeData) ){
            foreach( $placeData AS $key => $value){
                if(is_numeric($key)){
                    if( isset($areaData['rfp_place_id']) && $areaData['rfp_place_id'] ){

                        $placeDataUpdate['rfp_id'] = $rfpId;
                        $placeDataUpdate['place_location'] = isset($areaData['location']) ? $areaData['location'] : '';
                        $placeDataUpdate['place_type'] = isset($areaData['type']) ? $areaData['type'] : 0;
                        $placeDataUpdate['place_type_name'] = isset($areaData['type']) ? config('system.place_type')[$areaData['type']] : '';
                        $placeDataUpdate['place_star'] = isset($areaData['star']) ? $areaData['star'] : 0;
                        $placeDataUpdate['place_description'] = isset($value['desc']) ? $value['desc'] : '';
                        $placeDataUpdate['start_date'] = isset($value['start_time']) ? $value['start_time'] : '';
                        $placeDataUpdate['end_date'] = isset($value['end_time']) ? $value['end_time'] : '';
                        $placeDataUpdate['date_note'] = isset($value['time_desc']) ? $value['time_desc'] : '';
                        $placeDataUpdate['meeting_people'] = isset($value['amount']) ? $value['amount'] : '';
                        $placeDataUpdate['place_id_and_name_json'] = isset($areaData['hotel']) ? '['.$areaData['hotel'].']' : '';
                        $placeDataUpdate['day'] = $value['end_time'] && $value['end_time'] ? (strtotime($value['end_time']) - strtotime($value['start_time']))/86400+1 : '';
                        $placeDataUpdate['table_decoration'] = isset($value['shape']) ? $value['shape'] : 0;
                        $placeDataUpdate['form_key']                = $key;

                        $this -> _RfpPlace -> updateDatas( $areaData['rfp_place_id'], $placeDataUpdate );

                    }else{
                        $placeDataInsert[$i]['place_type_name'] = '';
                        $placeDataInsert[$i]['rfp_id'] = $rfpId;
                        $placeDataInsert[$i]['place_location'] = isset($areaData['location']) ? $areaData['location'] : '';
                        $placeDataInsert[$i]['place_type'] = isset($areaData['type']) ? $areaData['type'] : 0;
                        $placeDataInsert[$i]['place_type_name'] = isset($areaData['type']) &&  isset(config('system.place_type')[$areaData['type']])? config('system.place_type')[$areaData['type']] : '';
                        $placeDataInsert[$i]['place_star'] = isset($areaData['star']) ? $areaData['star'] : 0;
                        $placeDataInsert[$i]['place_description'] = isset($value['desc']) ? $value['desc'] : '';
                        $placeDataInsert[$i]['start_date'] = isset($value['start_time']) ? $value['start_time'] : '';
                        $placeDataInsert[$i]['end_date'] = isset($value['end_time']) ? $value['end_time'] : '';
                        $placeDataInsert[$i]['date_note'] = isset($value['time_desc']) ? $value['time_desc'] : '';
                        $placeDataInsert[$i]['meeting_people'] = isset($value['amount']) ? $value['amount'] : '';
                        $placeDataInsert[$i]['place_id_and_name_json'] = isset($areaData['hotel']) ? '['.$areaData['hotel'].']' : '';
                        $placeDataInsert[$i]['day'] = $value['end_time'] && $value['end_time'] ? (strtotime($value['end_time']) - strtotime($value['start_time']))/86400+1 : '';
                        $placeDataInsert[$i]['table_decoration'] = isset($value['shape']) ? $value['shape'] : 0;
                        $placeDataInsert[$i]['form_key']                = $key;

                    }
                }

            }

            if( !empty($placeDataInsert) ){
                $placeDataInsert = $this->checkNull($placeDataInsert);
                if(!empty($placeDataInsert)){
                    $this -> _RfpPlace -> insertDatas( $placeDataInsert );
                }

            }
            return true;
        /*} catch (Exception $e) {
            //DB::rollback();
            return $e->getMessage();
        }*/
        /*}else{

        }*/
    }

    private function editRoom( $rfpId, $roomData ){
        //try {
            $i                  = 0;
            $roomDataInsert     = [];
            $roomDescription    = isset($roomData['desc']) ? $roomData['desc'] : '';
            if(isset($roomData['desc'])){
                unset($roomData['desc']);
            }

                foreach($roomData AS $key => $value){
                    if(is_numeric($key)){
                    if( isset($value['room_id']) && $value['room_id'] ){
                        $roomDataUpdate['rfp_id']               = $rfpId;
                        $roomDataUpdate['room_in_start_date']   = isset($value['start_time']) ? $value['start_time'] : '';
                        $roomDataUpdate['room_out_end_date']    = isset($value['end_time']) ? $value['end_time'] : '';
                        $roomDataUpdate['room_count']           = isset($value['amount']) ? $value['amount']: '';
                        $roomDataUpdate['type']                 = isset($value['type']) ? $value['type'] : '';
                        $roomDataUpdate['day']                  = isset($value['day']) ? $value['day'] : 0;
                        $roomDataUpdate['breakfast']            = isset($value['breakfast']) ? $value['breakfast'] : 0;
                        $roomDataUpdate['budget_account']       = isset($value['budget_account']) ? $value['budget_account'] : 0;
                        $roomDataUpdate['room_description']     = $roomDescription;

                        $this -> _RfpRoom -> updateDatas( $value['room_id'], $roomDataUpdate );
                    }else{
                        $roomDataInsert[$i]['rfp_id']               = $rfpId;
                        $roomDataInsert[$i]['room_in_start_date']   = isset($value['start_time']) ? $value['start_time'] : '';
                        $roomDataInsert[$i]['room_out_end_date']    = isset($value['end_time']) ? $value['end_time'] : '';
                        $roomDataInsert[$i]['room_count']           = isset($value['amount']) ? $value['amount']: '';
                        $roomDataInsert[$i]['type']                 = isset($value['type']) ? $value['type'] : '';
                        $roomDataInsert[$i]['day']                  = isset($value['day']) ? $value['day'] : 0;
                        $roomDataInsert[$i]['breakfast']            = isset($value['breakfast']) ? $value['breakfast'] : 0;
                        $roomDataInsert[$i]['budget_account']            = isset($value['budget_account']) ? $value['budget_account'] : 0;
                        $roomDataInsert[$i]['room_description']     = $roomDescription;
                        $i++;
                    }
                }
            }

            if( !empty($roomDataInsert) ){
                $roomDataInsert = $this->checkNull($roomDataInsert);
                if(!empty($roomDataInsert)){
                    $this -> _RfpRoom -> insertDatas( $roomDataInsert );
                }

            }
            return true;
        /*} catch (Exception $e) {
            //DB::rollback();
            return $e->getMessage();
        }*/
    }

    private function editFood( $rfpId, $foodData ){
        //try {
            $i = 0;

            $foodDataDesc = isset($foodData['desc']) && $foodData['desc'] ? $foodData['desc'] : '';
            if(isset($foodData['desc'])){
                unset($foodData['desc']);
            }
            $foodParamInsert = [];
            foreach($foodData AS $key => $value){

                if(is_numeric($key)){
                    if( isset($value['food_id']) && $value['food_id'] ){
                        //修改
                        $foodParamUpdate['rfp_id']            = $rfpId;
                        $foodParamUpdate['rice_type']         = isset($value['type']) ? $value['type'] : '';
                        $foodParamUpdate['dining_type']       = isset($value['style']) ? $value['style'] : '';
                        $foodParamUpdate['people']            = isset($value['amount']) ? $value['amount'] : '';
                        $foodParamUpdate['unit_price']        = isset($value['price']) ? $value['price'] : '';
                        $foodParamUpdate['food_time']         = isset($value['time']) ? $value['time'] : '';
                        $foodParamUpdate['budget_account']    = isset($value['budget']) ? $value['budget'] : '';
                        $foodParamUpdate['food_menu']         = isset($value['menu']) ? $value['menu'] : '';
                        $foodParamUpdate['food_description']  = $foodDataDesc;

                        $this -> _RfpFood -> updateDatas( $value['food_id'], $foodParamUpdate );
                    }else{
                        //新增
                        $foodParamInsert[$i]['rfp_id']            = $rfpId;
                        $foodParamInsert[$i]['rice_type']         = isset($value['type']) ? $value['type'] : '';
                        $foodParamInsert[$i]['dining_type']       = isset($value['style']) ? $value['style'] : '';
                        $foodParamInsert[$i]['people']            = isset($value['amount']) ? $value['amount'] : '';
                        $foodParamInsert[$i]['unit_price']        = isset($value['price']) ? $value['price'] : '';
                        $foodParamInsert[$i]['food_time']         = isset($value['time']) ? $value['time'] : '';
                        $foodParamInsert[$i]['budget_account']    = isset($value['budget']) ? $value['budget'] : '';
                        $foodParamInsert[$i]['food_menu']         = isset($value['menu']) ? $value['menu'] : '';
                        $foodParamInsert[$i]['food_description']  = $foodDataDesc;
                    }
                }


                $i++;
            }

            if( !empty($foodParamInsert) ){
                $foodParamInsert = $this->checkNull($foodParamInsert);
                if(!empty($foodParamInsert)){
                    $this -> _RfpFood -> insertDatas( $foodParamInsert );
                }
            }
            return true;
        /*} catch (Exception $e) {
            //DB::rollback();
            return $e->getMessage();
        }*/
    }

    private function editWine( $rfpId, $wineData, $wineDataDesc = '' ){
        //try {
            $i = 0;
            $wineParamInsert = [];
            foreach($wineData AS $key => $value){
                if(is_numeric($key)){
                    if( isset($value['food_id']) && $value['food_id'] ){
                        //修改
                        $wineParamUpdate = [];
                        $wineParamUpdate['rfp_id']            = $rfpId;
                        $wineParamUpdate['rice_type']         = isset($value['type']) ? $value['type'] : '';
                        $wineParamUpdate['dining_type']       = isset($value['style']) ? $value['style'] : '';
                        $wineParamUpdate['people']            = isset($value['amount']) ? $value['amount'] : '';
                        $wineParamUpdate['food_time']         = isset($value['time']) ? $value['time'] : '';
                        $wineParamUpdate['budget_account']    = isset($value['budget_account']) ? $value['budget_account'] : '';
                        $wineParamUpdate['food_description']  = $wineDataDesc;
                        $wineParamUpdate['food_water']        = 1;

                        $this -> _RfpFood -> updateDatas( $value['food_id'], $wineParamUpdate );
                    }else{
                        //新增
                        $wineParamInsert[$i]['rfp_id']            = $rfpId;
                        $wineParamInsert[$i]['rice_type']         = isset($value['type']) ? $value['type'] : '';
                        $wineParamInsert[$i]['dining_type']       = isset($value['style']) ? $value['style'] : '';
                        $wineParamInsert[$i]['people']            = isset($value['amount']) ? $value['amount'] : '';
                        $wineParamInsert[$i]['food_time']         = isset($value['time']) ? $value['time'] : '';
                        $wineParamInsert[$i]['budget_account']    = isset($value['budget_account']) ? $value['budget_account'] : '';
                        $wineParamInsert[$i]['food_description']  = $wineDataDesc;
                        $wineParamInsert[$i]['food_water']        = 1;
                    }
                }


                $i++;
            }

            if( !empty($wineParamInsert) ){
                $wineParamInsert = $this->checkNull($wineParamInsert);
                if(!empty($wineParamInsert)){
                    $this -> _RfpFood -> insertDatas( $wineParamInsert );
                }

            }
            return true;
        /*} catch (Exception $e) {
            //DB::rollback();
            return $e->getMessage();
        }*/
    }

    public function sendRfp( Request $request ){
        $data = $request->except('_token');
        $rfpId = isset($data['rfp_id']) ? $data['rfp_id'] : 0;

        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }

        $rfpDetail      = $this -> _Rfp -> getRfpDetail( $rfpId );//获取会议基本信息
        $rfpPlace       = $this -> _RfpPlace -> getRfpPlace( $rfpId );//获取场地需求
        $rfpEquipment   = $this -> _RfpEquipment -> getRfpEquipment( $rfpId );//获取住宿需求
        $rfpFood        = $this -> _RfpFood -> getRfpFood( $rfpId );//获取餐饮需求
        $rfpRoom        = $this -> _RfpRoom -> getRfpRoom( $rfpId );//获取住宿需求

        $data                       = self :: sendClearDetail($rfpDetail[0]);
        $data['origin_rfp_detail']  = self :: sendClearDetail($rfpDetail[0]);
        $data['equipment_arr']      = self :: sendClearEquipment($rfpEquipment);
        $data['room']               = self :: sendClearRoom($rfpRoom);
        $data['food']               = self :: sendClearFood($rfpFood);
        $data['linkman']            = $this -> linkMan( $rfpDetail[0]['user_code'] );
        $data['place_meeting_arr']  = self :: sendClearPlace($rfpPlace);
        $data['rfp_from']           = 'children';
        $data['rfp_mapping_type_arr']['tableDecoration'] = self :: clearTable(config('system.table_type'));
        $data['rfp_mapping_type_arr']['foodType']['riceType'] = self :: clearRice(config('system.food_type'));
        $data['rfp_mapping_type_arr']['foodType']['diningType'] = self :: clearDining(config('system.dining_type'));
        $data['rfp_mapping_type_arr']['roomType'] = self :: clearRoom(config('system.room_type'));
        $data['rfp_mapping_type_arr']['equipmentType'] = config('system.equipment_type');
        $data['rfp_mapping_type_arr']['wine']['diningType'] = self :: clearWine(config('system.wine'));
        $data['rfp_mapping_type_arr']['wine_and_foodType'] = array_merge(config('system.food_type'), config('system.equipment_type'));

        $res = $this->send($data);
        $res = json_decode($res, true);

        if($res['errorno'] != 0){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = $res['msg'];
            echo json_encode($this->return);
            exit;
        }

        $updateData = [
            'status' => 30,
            'rfp_no' => $res['data']['rfpNo'],
        ];
        $this -> _Rfp -> updateDatas( $rfpId, $updateData );
        $this -> _RfpTimeline -> addTimeline( $rfpId, 104);

        $this->return['Success'] = true;
        $this->return['Data']    = '';
        $this->return['Msg']     = '成功';
        echo json_encode($this->return);
        exit;
    }

    public function getOfferList( $rfpId ){

        if(!$rfpId){
            $this->return['Success'] = false;
            $this->return['Data']    = '';
            $this->return['Msg']     = '缺少会议主键';
            echo json_encode($this->return);
            exit;
        }
        $rfpDetail      = $this -> _Rfp -> getRfpDetail( $rfpId );//获取会议基本信息

        $param = ['rfp_no' => $rfpDetail[0]['rfp_no']];
        $offerList = $this->getOfferByRfpId($param);
        $offerListArr = json_decode($offerList, true);
        $clear = [];
        if(isset($offerListArr['data']) && !empty($offerListArr['data'])){
            foreach($offerListArr['data'] AS $key => $value){
                $clear[$key]['total_price'] = $value['total_price'];
                $meet_equi_price = '';
                $food_info_price = '';
                $meet_equi_price = json_decode($value['meet_equi_price'], true);
                $food_info_price = json_decode($value['food_info_price'], true);
                $room_info_price = json_decode($value['room_info_price'], true);
                //餐饮相关计算
                $clear[$key]['food_info_price']     = !empty($food_info_price) ? self :: foodClassify($food_info_price) : [];
                $clear[$key]['wine_info_price']     = !empty($food_info_price) ? self :: wineClassify($food_info_price) : [];
                $clear[$key]['food_split_price']    = isset($clear[$key]['food_info_price']['food_split_price']) ? $clear[$key]['food_info_price']['food_split_price'] : 0;
                $clear[$key]['wine_split_price']    = isset($clear[$key]['wine_info_price']['wine_split_price']) ? $clear[$key]['wine_info_price']['wine_split_price'] : 0;
                $clear[$key]['food_total_price']    = $clear[$key]['food_split_price']+$clear[$key]['wine_split_price'];
                //设施相关计算
                $clear[$key]['meet_equi_price'] = !empty($meet_equi_price['data']) ? self::eClassify($meet_equi_price['data']) : [];
                $clear[$key]['equi_equi_price'] = isset($clear[$key]['meet_equi_price']['equi_equi_price']) ? $clear[$key]['meet_equi_price']['equi_equi_price'] : 0;
                $clear[$key]['meeting_price'] = isset($clear[$key]['meet_equi_price']['meeting_price']) ? $clear[$key]['meet_equi_price']['meeting_price'] : 0;
                unset($clear[$key]['meet_equi_price']['equi_equi_price']);
                unset($clear[$key]['meet_equi_price']['meeting_price']);
                //住宿相关计算

                $clear[$key]['room_info_price'] = !empty($room_info_price['data']) ? $room_info_price['data'] : [];
                $clear[$key]['room_info_price'] = !empty($room_info_price['data']) ? self :: roomClassify($room_info_price) : [];
                $clear[$key]['room_total_price']= isset($clear[$key]['room_info_price']['total_price']) ? $clear[$key]['room_info_price']['total_price'] : 0;

                //场地相关
                $clear[$key]['place_name']          = $value['place_name'] ? $value['place_name'] : '';
                $clear[$key]['map_id']              = $value['map_id'] ? $value['map_id'] : 0;
                $clear[$key]['place_id']            = $value['place_id'] ? $value['place_id'] : 0;
                $clear[$key]['place_type']          = $value['place_type'] ? $value['place_type'] : '';
                $clear[$key]['star_rate']           = $value['place_info']['star_rate'] ? $value['place_info']['star_rate'] : 0;
                $clear[$key]['address']             = $value['place_info']['address'] ? $value['place_info']['address'] : '';
                $clear[$key]['place_desc']          = $value['place_info']['place_desc'] ?  $this->rehtml($value['place_info']['place_desc']) : '';
                $clear[$key]['show_offer_time']     = $value['show_offer_time'] ? $value['show_offer_time'] : '';
                $clear[$key]['rfp_id']              = $rfpId;

                $searchData     = [ 'id' => $clear[$key]['place_id'] ];
                $url            = config('links.palce_api').'/q';
                $resp           = json_decode(doCurlGetRequest($url, $searchData), true);
                $clear[$key]['main_pic_url']        = $resp['main_pic_url'];
                $clear[$key]['place_rfp_id']        = $value['rfp_id'] ? $value['rfp_id'] : 0;;
                $clear[$key]['place_map_id']        = $value['map_id'];
            }
        }
        return $clear;
    }
    public function rehtml($data){
        $data = preg_replace("/<em([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/em>/i", "", $data);
        $data = preg_replace("/<img([^>]+)?>/i", "", $data);
        $data = preg_replace("/<div([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/div>/i", "", $data);
        $data = preg_replace("/<table([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/table>/i", "", $data);
        $data = preg_replace("/<tr([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/tr>/i", "", $data);
        $data = preg_replace("/<td([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/td>/i", "", $data);
        $data = preg_replace("/<tbody([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/tbody>/i", "", $data);
        $data = preg_replace("/<strong([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/strong>/i", "", $data);
        $data = preg_replace("/<br([^>]+)?>/i", "", $data);
        $data = preg_replace("/<p([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/p>/i", "", $data);
        $data = preg_replace("/<span([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/span>/i", "", $data);
        $data = preg_replace("/<h1([^>]+)?>.*<\/h1>/i", "", $data);
        $data = preg_replace("/<h2([^>]+)?>.*<\/h2>/i", "", $data);
        $data = preg_replace("/<font([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/font>/i", "", $data);
        $data = preg_replace("/<center([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/center>/i", "", $data);
        $data = preg_replace("/<b ([^>]+)?>.*?<\/b>/i", "", $data);
        $data = preg_replace("/<a [^>]*>.*?<\/a>/i", "", $data);
        $data = preg_replace("[^ \f\n\r\t\v]",'',$data);
        $data = preg_replace("/\s+/",'',$data);
        $data = str_replace(array("\r\n","\n\r", "\r", "\f","\v", "\n", "\t", "<p>", "</p>", " ","'",'"',"	"), "", $data);
        $data = str_replace(PHP_EOL, '', $data);
        return $data;
    }
    private static function eClassify($e_info_price){
        $count = 0;
        $mCount = 0;

        foreach($e_info_price As $key => $value){
            $str = '';
            if(isset($value['data'])){
                foreach($value['data'] as $vk => $vv) {
                    if ($vv['count'] > 0){
                        $str .= $vv['name'] . '×' . $vv['count'] . '  ';
                    }
                }
                $e_info_price[$key]['str_e'] = $str;
            }

            $count  += $value['equi_price'];
            $mCount += $value['meetingroom_price'];
        }
        $e_info_price['equi_equi_price'] = $count;
        $e_info_price['meeting_price'] = $mCount;
        return $e_info_price;

    }
    private static  function roomClassify($room_info_price){
        $countMany = 0;
        $newRoom = [];

        if(isset($room_info_price['data'])){
            foreach($room_info_price['data'] AS $key => $value){
                $countMany += $value['room_info_price'][0]['total_price'];
                $room_info_price['data'][$key]['offer_note']    = $room_info_price['offer_note'];
                $room_info_price['data'][$key]['price']         = $value['room_info_price'][0]['price'];
                $room_info_price['data'][$key]['total_price']   = $value['room_info_price'][0]['total_price'];
            }
            $room_info_price['total_price'] = $countMany ? $countMany : 0;
        }

        return $room_info_price;
    }
    private  static function foodClassify($food_info_price){
        $countMany = 0;
        $foodPrice = 0;
        $winePrice = 0;
        if(isset($food_info_price['data'])){


        foreach($food_info_price['data'] AS $key => $value){
            $countMany += isset($value['total_price']) ? $value['total_price'] : 0;
            $foodPrice += isset($value['total_price']) ? $value['total_price'] : 0;
        }

        $food_info_price['food_split_price']  = $foodPrice;
        unset($food_info_price['water_data']);
        }
        return $food_info_price;
    }
    private static function wineClassify($food_info_price){
        $countMany = 0;
        $foodPrice = 0;
        $winePrice = 0;
        if(isset($food_info_price['water_data'])) {
            foreach ($food_info_price['water_data'] AS $key => $value) {
                $countMany += isset($value['total_price']) ? $value['total_price'] : 0;
                $winePrice += isset($value['total_price']) ? $value['total_price'] : 0;
            }
            $food_info_price['wine_split_price'] = $winePrice;
            unset($food_info_price['data']);
        }
        return $food_info_price;
    }
    private function getOfferByRfpId($param){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign($param);
        $array['param']     = json_encode($param);
        $result             = $this->http->httppost(config( 'links.open_api_url' ) . '/Monarch/getOfferList?', $array, $this->token);

        return $result;
    }
    private static function sendClearDetail($rfpDetail){
        $rfpDetail['meetingname']               = $rfpDetail['meeting_name'];
        $rfpDetail['executprojectcode']         = $rfpDetail['meeting_code'];
        $rfpDetail['meetingtypecode']           = $rfpDetail['meeting_type_code'];
        $rfpDetail['meetingtypedesc']           = $rfpDetail['meeting_type_desc'];
        $rfpDetail['begindate']                 = date('Y-m-d H:i:s', $rfpDetail['start_time']);
        $rfpDetail['enddate']                   = date('Y-m-d H:i:s', $rfpDetail['end_time']);
        $rfpDetail['plannedattendance']         = $rfpDetail['people_num'];
        $rfpDetail['ht_rfp_no']                 = $rfpDetail['rfp_no'];
        $rfpDetail['ht_order_no']               = date('Y-m-d H:i:s', $rfpDetail['order_no']);
        $rfpDetail['rfp_ctime']                 = date('Y-m-d H:i:s', $rfpDetail['create_time']);
        $rfpDetail['selected_place_map_id']     = $rfpDetail['place_id'];
        $rfpDetail['travel_start_time']         = date('Y-m-d H:i:s', $rfpDetail['trip_start_time']);
        $rfpDetail['travel_end_time']           = date('Y-m-d H:i:s', $rfpDetail['trip_end_time']);
        $rfpDetail['customer_num']              = $rfpDetail['clientele_num'];
        $rfpDetail['company_num']               = $rfpDetail['within_num'];
        $rfpDetail['third_party_num']           = $rfpDetail['nonparty_num'];
        $rfpDetail['responsiblename']           = $rfpDetail['user_name'];
        $rfpDetail['responsiblead']             = $rfpDetail['phone'];
        $rfpDetail['contact_mobile']            = $rfpDetail['end_time'];
        //$rfpDetail['user_addition_ctime']       = date('Y-m-d H:i:s', $rfpDetail['create_time']);
        return $rfpDetail;

    }

    private function send($data){
        $data['source'] = $data;
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign($data);
        $array['param']     = json_encode($data);
        $result             = $this->http->httppost(config( 'links.open_api_url' ) . '/Monarch/sendRfp?', $array, $this->token);

        return $result;
    }
    private  static  function clearWine ($wineType) {
        $wineClear = [];
        foreach ( $wineType AS $key => $value) {
            $wineClear[$key]['code'] = $key;
            $wineClear[$key]['name'] = $value;
        }
        return $wineClear;
    }
    private  static  function clearRoom ($roomType) {
        $diningTypeClear = [];
        foreach ( $roomType AS $key => $value) {
            $diningTypeClear[$key]['code'] = $key;
            $diningTypeClear[$key]['name'] = $value;
        }
        return $diningTypeClear;
    }
    private  static  function clearDining ($roomType) {
        $diningTypeClear = [];
        foreach ( $roomType AS $key => $value) {
            $diningTypeClear[$key]['code'] = $key;
            $diningTypeClear[$key]['name'] = $value;
        }
        return $diningTypeClear;
    }

    private  static  function clearRice ($foodType) {
        $foodTypeClear = [];
        foreach ( $foodType AS $key => $value) {
            $foodTypeClear[$key]['code'] = $key;
            $foodTypeClear[$key]['name'] = $value;
        }
        return $foodTypeClear;
    }

    private  static  function clearTable ($tableType) {
        $tableTypeClear = [];
        foreach ( $tableType AS $key => $value) {
            $tableTypeClear[$key]['code'] = $key;
            $tableTypeClear[$key]['name'] = $value;
        }
        return $tableTypeClear;
    }
    private static function sendClearPlace( $rfpPlace ){
        if( !empty( $rfpPlace ) ){
            foreach( $rfpPlace AS $key => $value){
                $rfpPlace[$key]['table_decoration_name'] = isset(config('system.table_type')[$value['table_decoration']]) ? config('system.table_type')[$value['table_decoration']] : '';

            }
        }
        return $rfpPlace;
    }

    private function linkMan( $userCode ){
        $conditions = [ 'where' => [
            'id' => [
                'symbol'    => '=',
                'value'     => $userCode
            ]
        ] ];
        $linkMan    = $this -> _User -> getDatas($conditions);
        $linkMans   = [];
        foreach($linkMan AS $key => $value){
            $linkMans[$key]['name']     = $value['username'];
            $linkMans[$key]['phone']    = $value['phone'];
        }
        return $linkMans;
    }
    private static  function sendClearFood($rfpFood){
        if( !empty( $rfpFood ) ){
            foreach( $rfpFood AS $key => $value){
                $rfpFood[$key]['food_menu_name']    = !$value['food_menu'] ? '不提供菜单' : '提供菜单';
                $rfpFood[$key]['food_water_name']   = !$value['food_water'] ? '不提供酒水' : '提供酒水';
                $rfpFood[$key]['rice_type_name']    = isset(config('system.food_type')[$value['rice_type']]) ? config('system.food_type')[$value['rice_type']] : '';
                $rfpFood[$key]['dining_type_name']  = isset(config('system.dining_type')[$value['dining_type']]) ? config('system.dining_type')[$value['dining_type']] : '';
            }
        }
        return $rfpFood;
    }
    private static function sendClearRoom( $rfpRoom ){
        if( !empty( $rfpRoom ) ){
            foreach( $rfpRoom AS $key => $value){
                $rfpRoom[$key]['breakfast_name'] = isset(config('system.breakfast')[$value['breakfast']]) ? config('system.breakfast')[$value['breakfast']] : '';
                $rfpRoom[$key]['type_name'] = isset(config('system.room_type')[$value['type']]) ? config('system.room_type')[$value['type']] : '' ;
            }
        }
        return $rfpRoom;
    }
    private static function sendClearEquipment( $rfpEquipment ){
        $equipmentArr = [];

        if( !empty( $rfpEquipment ) ){
            $i = 101;
            foreach( $rfpEquipment AS $key => $value){

                $equipmentArr[$i] = $value;
                $equipmentArr[$i]['key95_name']     = config('system.equipment_type')['key95']['name'].'×'.$value['key95'];
                $equipmentArr[$i]['key96_name']     = config('system.equipment_type')['key96']['name'].'×'.$value['key96'];
                $equipmentArr[$i]['key97_name']     = config('system.equipment_type')['key97']['name'].'×'.$value['key97'];
                $equipmentArr[$i]['key98_name']     = config('system.equipment_type')['key98']['name'].'×'.$value['key98'];
                $equipmentArr[$i]['key99_name']     = config('system.equipment_type')['key99']['name'].'×'.$value['key99'];
                $equipmentArr[$i]['key100_name']    = config('system.equipment_type')['key100']['name'].'×'.$value['key100'];
                $equipmentArr[$i]['key101_name']    = config('system.equipment_type')['key101']['name'].'×'.$value['key101'];
                $equipmentArr[$i]['key102_name']    = config('system.equipment_type')['key102']['name'].'×'.$value['key102'];
                $equipmentArr[$i]['key103_name']    = config('system.equipment_type')['key103']['name'].'×'.$value['key103'];
                $equipmentArr[$i]['key104_name']    = config('system.equipment_type')['key104']['name'].'×'.$value['key104'];
                $equipmentArr[$i]['key105_name']    = config('system.equipment_type')['key105']['name'].'×'.$value['key105'];
                $equipmentArr[$i]['key106_name']    = config('system.equipment_type')['key106']['name'].'×'.$value['key106'];
                $equipmentArr[$i]['key107_name']    = config('system.equipment_type')['key107']['name'].'×'.$value['key107'];
                $equipmentArr[$i]['key108_name']    = config('system.equipment_type')['key108']['name'].'×'.$value['key108'];
                $equipmentArr[$i]['form_key']       = $i;
                $i ++;
            }
        }
        return $equipmentArr;
    }


    public function getOfferRank( Request $request ){
        $reqs   = $request -> except( '_token' );
        $rfp_no  = $reqs['rfp_no'];
        $offerList = $this->getOfferByRfpId(['rfp_no' => $rfp_no]);
        $offerListArr = json_decode($offerList, true);
        $offerRanks = [];
        if(isset($offerListArr['data']) && !empty($offerListArr['data'])){
            $offerRanks = $this->formatOffer($offerListArr['data']);
        }
        return json_encode($offerRanks);
    }


    /**
     * 格式化报价信息数据
     */
    private function formatOffer($data)
    {
        $response = [];

        $totalQuotationTimes = 0;
        foreach ($data as $key => $value) {
            $totalQuotationTimes += $value['update_total'];

            $hotelName = $value['place_name'];

            $response['total_price'][] = [
                'hotel_name'      => $hotelName,
                'quotation_times' => $value['update_total'],
                'total_price'     => $value['total_price'],
            ];

            // 会场报价信息
            $meet = json_decode($value['meet_price'], true);
            if (isset($meet['data']) && $meet['data']) {
                $_total_price = 0;
                $_num = 0;
                foreach ($meet['data'] as $meetOffer) {
                    $_total_price += $meetOffer['price'];
                    $_num++;
                }
                $response['meet']['data'][] = [
                    'hotel_name'  => $hotelName,
                    'num'         => $_num,
                    'price'       => $_total_price / $_num,
                    'total_price' => $_total_price,
                ];
                $response['meet']['total_price'][] = [
                    'hotel_name'  => $hotelName,
                    'total_price' => $_total_price
                ];
            }

            //设备报价
            $equi = json_decode($value['meet_equi_price'], true);
            if (isset($equi['data']) && $equi['data']) {
                $_total_price = 0;
                foreach ($equi['data'] as $equiOffer) {
                    $_total_price += $equiOffer['equi_price'] + $equiOffer['meetingroom_price'];
                }
                $response['equi']['data'][] = [
                    'hotel_name'  => $hotelName,
                    'num'         => 1,
                    'price'       => $_total_price,
                    'total_price' => $_total_price,
                ];
                $response['equi']['total_price'][] = [
                    'hotel_name'  => $hotelName,
                    'total_price' => $_total_price
                ];
            }

            // 餐饮报价信息
            $food = json_decode($value['food_info_price'], true);
            if (isset($food['data']) && $food['data']) {
                $_total_price = 0;
                foreach ($food['data'] as $_k => $foodOffer) {
                    $foodKey = ($_k+1) . '.' . $foodOffer['select1'] . $foodOffer['select2'];
                    $response['food']['data'][$foodKey][] = [
                        'hotel_name'  => $hotelName,
                        'num'         => $foodOffer['people'],
                        'price'       => $foodOffer['price'],
                        'total_price' => $foodOffer['total_price'],
                    ];
                    $_total_price += $foodOffer['total_price'];
                }
                $response['food']['total_price'][] = [
                    'hotel_name'  => $hotelName,
                    'total_price' => $_total_price
                ];
            }

            //酒水信息
            if (isset($food['water_data']) && $food['water_data']) {
                $_total_price = 0;
                foreach ($food['water_data'] as $_k => $_v) {
                    $key = ($_k+1) . '.' . $_v['water_food_time'] . $_v['water_dining_type_name'];
                    $response['water']['data'][$key][] = [
                        'hotel_name'  => $hotelName,
                        'num'         => $_v['water_people'],
                        'price'       => $_v['price'],
                        'total_price' => $_v['total_price'],
                    ];
                    $_total_price += $_v['total_price'];
                }
                $response['water']['total_price'][] = [
                    'hotel_name'  => $hotelName,
                    'total_price' => $_total_price
                ];
            }

            // 住宿报价信息
            $room = json_decode($value['room_info_price'], true);
            if (isset($room['data']) && $room['data']) {
                $_total_price = 0;
                foreach ($room['data'] as $_k => $roomOffer) {
                    $roomKey =  ($_k+1) . '.' . $roomOffer['startTime'] . '至' . $roomOffer['endTime'] . $roomOffer['type'];
                    $response['room']['data'][$roomKey][] = [
                        'hotel_name'  => $hotelName,
                        'num'         => $roomOffer['room'],
                        'price'       => $roomOffer['room_info_price'][0]['price'],
                        'total_price' => $roomOffer['room_info_price'][0]['total_price'],
                    ];
                    $_total_price += $roomOffer['room_info_price'][0]['total_price'];
                }
                $response['room']['total_price'][] = [
                    'hotel_name'  => $hotelName,
                    'total_price' => $_total_price
                ];
            }

        }

        if ($response) {
            $response['summary'] = [
                'total_quotation_times' => $totalQuotationTimes
            ];

            $response = $this->offerSort($response);
        }

        return $response;
    }


    /**
     * 对数组进行排序
     */
    private function offerSort($array)
    {
        $array['total_price'] = $this->myUsort($array['total_price']);

        if (isset($array['meet'])) {
            $array['meet']['total_price'] = $this->myUsort($array['meet']['total_price']);
            $array['meet']['data'] =$this->myUsort($array['meet']['data']);
        }

        if (isset($array['food'])) {
            $array['food']['total_price'] = $this->myUsort($array['food']['total_price']);

            foreach ($array['food']['data'] as $key => $value) {
                $array['food']['data'][$key] = $this->myUsort($value);
            }
        }

        if (isset($array['water'])) {
            $array['water']['total_price'] = $this->myUsort($array['water']['total_price']);

            foreach ($array['water']['data'] as $key => $value) {
                $array['water']['data'][$key] = $this->myUsort($value);
            }
        }


        if (isset($array['equi'])) {
            $array['equi']['total_price'] = $this->myUsort($array['equi']['total_price']);
            $array['equi']['data'] = $this->myUsort($array['equi']['data']);
        }

        if (isset($array['room'])) {
            $array['room']['total_price'] = $this->myUsort($array['room']['total_price']);

            foreach ($array['room']['data'] as $key => $value) {
                $array['room']['data'][$key] = $this->myUsort($value);
            }
        }

        return $array;
    }

    /**
     * 二维数组排序
     */
    private function myUsort(array $array, $field = 'total_price')
    {
        usort($array, function ($a, $b) use ($field) {
            if ($a[$field] === $b[$field]) {
                return 0;
            }

            return ($a[$field] < $b[$field]) ? -1 : 1;
        });

            return $array;
    }

    private function getRfpAndOfferList($param){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign($param);
        $array['param']     = json_encode($param);
        $result             = $this->http->httppost(config( 'links.open_api_url' ) . '/Monarch/getRfpAndOfferList?', $array, $this->token);
        return $result;
    }

}

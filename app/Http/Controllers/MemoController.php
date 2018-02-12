<?php
/**
 * des: 水单部分逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Rfp;
use App\Models\RfpBudget;
use App\Models\RfpPerform;
use App\Models\RfpPicFile;
use App\Models\RfpTimeline;
use App\Models\UserNotice;
use Log;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemoController extends Controller
{
    private $_Rfp;
    private $_Logs;
    private $_Rfp_pic_file;
    private $_Rfp_perform;
    private $_Rfp_timeline;
    private $_User_notice;
    public function __construct()
    {
        parent::__construct();
        $this -> _Rfp = new Rfp();
        $this -> _Logs = new Logs();
        $this -> _Rfp_pic_file = new RfpPicFile();
        $this -> _Rfp_perform = new RfpPerform();
        $this -> _Rfp_timeline = new RfpTimeline();
        $this -> _User_notice = new UserNotice();
        $this -> _Rfp_budget = new RfpBudget();
    }

    public function confirmMemo(Request $request)
    {
        $reqs = $request->except('_token');
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        return view( '/meeting/myorder' ,[ 'data' => $rfp_id ]);
    }
    public function preview(Request $request)
    {
        $reqs = $request->except('_token');
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        return view( '/meeting/sured' ,[ 'data' => $rfp_id ]);
    }

    //确认水单页面展示
    public function confirm_memo(Request $request)
    {
        $reqs = $request->except('_token');
        if(empty($reqs['rfp_id'])){
           return returnJson(false,'','参数缺失');
        }
        //获取会议信息
       $rfp_info = $this-> _Rfp ->getRfpByRfpid($reqs['rfp_id']);
        if(!isset($rfp_info[0]) || empty($rfp_info[0]) || ($rfp_info[0]['user_code'] != session('user')['id'])){
            return returnJson(false,'','您不是此会议的负责人,不能进行此操作!');
        }
        return returnJson(true,$rfp_info[0],'');
    }

    //水单详细信息
    public function memo_detail(Request $request){
        $reqs = $request->except('_token');
        if(empty($reqs['rfp_id'])){
            return returnJson(false,'','参数缺失');
        }
        //获取rpf详细信息
        $rfp_info = $this -> _Rfp -> getRfpByRfpid($reqs['rfp_id']);
        if(empty($rfp_info))$rfp_info[0] = array();
        //获取perform详细信息
        $perform_info = $this-> _Rfp_perform ->getDetail($reqs['rfp_id']);
        if(empty($perform_info))$perform_info[0] = array();
        //获取pic_file详细信息
        $files = $this -> _Rfp_pic_file -> getDetail($reqs['rfp_id']);
        $data = array(
            'rfp_info'      => $rfp_info[0],
            'perform_info'  => $perform_info[0],
            'files'         => $files,
        );
        return returnJson(true,$data,'');
    }

    //确认水单提交
    public function save_memo(Request $request){
            $reqs = $request->except('_token');
            //构造入库参数
            $data = $this->format_post_data($reqs);
            if(empty($data['rfp_id']) || intval($data['perform']['signed_number'])<1 || empty($data['files'])){
                return returnJson(false,'','参数缺失');
            }
            //检查会议是否存在
            $rfp_info = $this->_Rfp->getRfpByRfpid($data['rfp_id']);
            if(empty($rfp_info) || $rfp_info[0]['status'] !='40'){
                return returnJson(false,'','会议信息有误，请核查');
            }
            //水单pic数据
            $pic_list = $this->memo_file_db($data['rfp_id'],$data['files']);
            //入库
            DB::beginTransaction();
            try
            {
                //1.添加rfp_perform数据
                $data['perform']['rfp_id'] = $data['rfp_id'];
                $this -> _Rfp_perform -> insertDatas($data['perform']);
                //2.添加rfp_pic_file数据
                $this -> _Rfp_pic_file -> insertDatas($pic_list);
                //3.更新rfp
                $this -> _Rfp ->updateDatas($data['rfp_id'],$data['payamount']);

                //添加项目进度
                $this->addTimeline($data['rfp_id'],'107');
                //添加消息通知创建人 106上传水单
                //$this->addNotice($rfp_info[0],$data['rfp_id'],'1','106','会议'.$rfp_info[0]['meeting_code'].'水单已确认');
                //添加操作日志
                $this->addLog($rfp_info[0],$data['rfp_id'],'会议'.$rfp_info[0]['meeting_code'].'水单已确认');
                DB::commit();
                return returnJson(true,array('rfp_id'=>$data['rfp_id']),'');
            }catch (\Exception $e)
            {
                //写入文本日志
                $message = "确认水单,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                DB::rollBack();
                return returnJson(false,'','水单确认失败');
            }

    }

    /**
     * 构造参数
     *
     * @return array
     */
    private function format_post_data($reqs) {
        //基本信息
        $rfp_id                         = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );
        $data['signed_number']          = empty($reqs['signed_number'])?'0':filterParam( $reqs['signed_number'] );  //签到人数
        $data['up_name']                = empty($reqs['up_name'])?'':config('system.up_name.'.$reqs['up_name'].'.value');    //上会人
            //各项费用及说明
        $data['meeting_room_fees']      = empty($reqs['meeting_room_fees'])?'0':filterParam( $reqs['meeting_room_fees'] );//场地费用
        $data['food_fees']              = empty($reqs['food_fees'])?'0':filterParam( $reqs['food_fees'] );//餐饮费用
        $data['room_fees']              = empty($reqs['room_fees'])?'0':filterParam( $reqs['room_fees'] );//住宿费用
        $data['equipment_fees']         = empty($reqs['equipment_fees'])?'0':filterParam( $reqs['equipment_fees'] );//会务费用
        $data['wine_drinks']            = (empty($reqs['wine_drinks'])||$reqs['wine_drinks']<0)?'0.00':filterParam( $reqs['wine_drinks'] );//易捷酒水
        $data['jd_fees']                = (empty($reqs['jd_fees'])||$reqs['jd_fees']<0)?'0.00':filterParam( $reqs['jd_fees'] );//京东代采费用
        $data['other_fees']             = empty($reqs['other_fees'])?'0':filterParam( $reqs['other_fees'] );//其他费用
        $data['meeting_room_note']      = empty($reqs['meeting_room_note'])?'':filterParam( $reqs['meeting_room_note'] );//会议室费用说明
        $data['meeting_food_note']      = empty($reqs['meeting_food_note'])?'':filterParam( $reqs['meeting_food_note'] );//餐饮费用说明
        $data['meeting_hotel_note']     = empty($reqs['meeting_hotel_note'])?'':filterParam( $reqs['meeting_hotel_note'] );//住宿费用说明
        $data['meeting_note']           = empty($reqs['meeting_note'])?'':filterParam( $reqs['meeting_note'] );//会务费说明
        $data['meeting_yijie_note']     = empty($reqs['meeting_yijie_note'])?'':filterParam( $reqs['meeting_yijie_note'] );//易捷费用说明
        $data['meeting_eventown_note']  = empty($reqs['meeting_eventown_note'])?'':filterParam( $reqs['meeting_eventown_note'] );//会唐采购说明
        $data['meeting_other_note']     = empty($reqs['meeting_other_note'])?'':filterParam( $reqs['meeting_other_note'] );//其他费用说明
        $data['remark']                 = empty($reqs['remark'])?'':filterParam( $reqs['remark'] );//备注
        //评价
        $data['place_star']             = empty($reqs['place_star'])?'':filterParam( $reqs['place_star'] );//场地评星
        $data['food_star']              = empty($reqs['food_star'])?'':filterParam( $reqs['food_star'] );//
        $data['room_star']              = empty($reqs['room_star'])?'':filterParam( $reqs['room_star'] );
        $data['serve_star']             = empty($reqs['serve_star'])?'':filterParam( $reqs['serve_star'] );
        $data['appraise_serve']         = empty($reqs['appraise_serve'])?'':filterParam( $reqs['appraise_serve'] );//评价服务

        $data['create_time']            = time();
        $isMobile = isset($reqs['isMobile'])?true:false;
        if($isMobile){
            $files      = empty($reqs['files'])?'':explode(",", $reqs['files']);
        }else{
            $files      = empty($reqs['files'])?'':json_decode($reqs['files'],true);
        }
        $payamount         = $data['meeting_room_fees'] + $data['food_fees'] + $data['room_fees'] + $data['equipment_fees'] + $data['other_fees'] + $data['wine_drinks'] + $data['jd_fees'];
        $arr = array(
            'perform'=>$data,
            'payamount'=>array(
                'ht_payamount'           => $payamount,
                "ht_settlement_amount"   => $payamount,
                'real_attendance_number' => $data['signed_number'],
                'status'             => 50,//订单完成
                'update_time'       => time()
            ),
            'files'=>$files,
            'rfp_id'=>$rfp_id,
        );
        return $arr;

    }

    /**
     * 水单图片入库数据
     *
     * @return array
     */
    private function memo_file_db($rfp_id,$files) {
        // 根据询单id先查询出原有图片列表,进行比对确定出哪些图片是新增的然后进行保存
        $new_file_url_arr_unique = array_unique($files);// 去重后
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfp_id
            ]
        ] ];
        $memo_file_list             = $this -> _Rfp_pic_file -> getDatas($conditions);
        if (empty($memo_file_list)) {
            $to_save_file_arr       = $new_file_url_arr_unique;
        } else {
            $origin_url_arr         = array_column($memo_file_list, 'pic_url');// 原有图片url数组
            $origin_url_unique      = array_unique($origin_url_arr);// 去重后
            $to_save_file_arr       = array_diff($new_file_url_arr_unique, $origin_url_unique);
        }
        $save_rfp_pic_file_res = array();
        if ($to_save_file_arr) {
            foreach ($to_save_file_arr as $key => $v) {
                if (!empty($v)) {
                    $save_rfp_pic_file_res[] = array(
                        'rfp_id'        =>  $rfp_id,
                        'pic_url'       =>  $v,
                        'creat_time'    =>  $_SERVER['REQUEST_TIME'],
                    );
                }
            }
        }
        return $save_rfp_pic_file_res;
    }

    //上传水单
    public function uploadFile(Request $request) {
        // 文件上传
        if($request -> isMethod( 'POST' ) ) {
            $reqs = $request -> except( '_token' );
            if(empty($reqs['name'])){
                return array('status' => '0', "error" => '没有获取到文件信息');
            }
                $type = array('jpg','JPG', 'jpeg', 'JPEG','png','PNG','gif','GIF');
                $size = 1024*2;//kb
            echo upload_upanyun_file('file',$type,$size);
            exit;
        }
        echo returnJson(false,'','上传有误');
        exit;
    }

    //添加项目进度
    public function  addTimeline($rfp_id,$step){
        $timeline = array(
            'rfp_id'            => $rfp_id,
            'step'              => $step,
            'step_name'         => config('timeline.timeline.'.$step),
            'completed_time'    => time(),
        );
        $this -> _Rfp_timeline->insertDatas($timeline);
    }
    //添加消息
    public function  addNotice($basic,$rfp_id,$type,$notice_type,$content){
        if($type == '1'){
            $responsiblead = $basic['user_code'];
        }elseif ($type == '2'){
            $responsiblead = $basic['auditor_no'];
        }else{
            $responsiblead = '';
        }
        $data = array(
            'notice_ctime'      => time(),
            'notice_content'    => $content,
            'meetingname'       => $basic['meeting_name'],
            'executprojectcode' => $basic['meeting_code'],
            'notice_status'     => '0',
            'responsiblead'     => $responsiblead,
            'rfp_id'            => $rfp_id,
            'notice_type'       => $notice_type,
        );
        $this -> _User_notice->insertDatas($data);
    }

    //添加操作日志
    public function addLog($basic,$rfp_id,$content){
        $log_data = array(
            'content'       => $content,
            'node'          => $this-> __url,
            'extend'        => json_encode(array('rfp_id'=>$rfp_id)),
            'read'          => '0',
            'type'          => '1',
            'ip'            => $_SERVER["REMOTE_ADDR"],
            'belong'        => $basic['user_code'],
            'create_time'   => time(),
        );
        $this -> _Logs->insert($log_data);
    }

    //获取上会人信息
    public function getUpname(){
        $up_name =  config('system.up_name');
        $up_name = array_values($up_name);
        return json_encode($up_name);
    }

}

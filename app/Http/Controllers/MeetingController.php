<?php
/**
 * des: 会议部分逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\JoinDot;
use App\Models\Logs;
use App\Models\Rfp;
use App\Models\RfpBudget;
use App\Models\RfpTimeline;
use App\Models\RfpUser;
use App\Models\UserNotice;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MeetingController extends Controller
{
    private $_Rfp;
    private $_Rfp_budget;
    private $_Rfp_timeline;
    private $_User_notice;
    private $_Logs;
    private $_Rfp_user;
    private $_Join_dot;
    public function __construct()
    {
        parent::__construct();
        $this -> _Rfp = new Rfp();
        $this -> _Rfp_budget = new RfpBudget();
        $this -> _Rfp_timeline = new RfpTimeline();
        $this -> _User_notice = new UserNotice();
        $this -> _Logs = new Logs();
        $this -> _Rfp_user = new RfpUser();
        $this -> _Join_dot = new JoinDot();
    }

    public function create()
    {
        return view( '/meeting/index');
    }
    //编辑会议
    public function edit(Request $request)
    {
        $reqs = $request->except( '_token' );
        $rfp_id = isset($reqs['rfp_id'])?$reqs['rfp_id']:'';
        return view( '/meeting/edit',[ 'data' => $rfp_id ]);
    }
    public function editajax(Request $request){
        $reqs = $request->except( '_token' );
        $data = $this->meetingDetail( $reqs );
        if(empty($data)){
            return returnJson(false,'','会议信息有误');
        }
        return returnJson(true,$data,'');
    }
    //审核会议
    public function check(Request $request)
    {
        $reqs = $request->except( '_token' );
        $data = $this->meetingDetail( $reqs );
        return view( '/meeting/check', [ 'data' => $data ] );
    }
    //查看会议
    public function preview(Request $request)
    {
        $reqs = $request->except( '_token' );
        $data = $this->meetingDetail( $reqs );

        return view( '/meeting/preview', [ 'data' => $data ] );
    }

    private function meetingDetail($reqs){

        if(empty($reqs['rfp_id'])){
            return array();
        }
        //获取rpf详细信息
        $rfp_info = $this -> _Rfp -> getRfpByRfpid($reqs['rfp_id']);
        if(empty($rfp_info) || !isset($rfp_info[0]))return array();
        $info = $rfp_info[0];
        //格式竞标类型
        $bit_type =  config('system.bit_type');
        $info['bit_type_desc'] = isset($bit_type[$info['bit_type']]) ? $bit_type[$info['bit_type']] : '';
        //转化时间格式
        $info['start_time']             = empty($info['start_time'])?'':date('Y-m-d',$info['start_time']);
        $info['end_time']               = empty($info['end_time'])?'':date('Y-m-d',$info['end_time']);
        $info['trip_start_time']        = empty($info['trip_start_time'])?'':date('Y-m-d',$info['trip_start_time']);
        $info['trip_end_time']          = empty($info['trip_end_time'])?'':date('Y-m-d',$info['trip_end_time']);
        $info['create_time']            = empty($info['create_time'])?'':date('Y-m-d',$info['create_time']);
        $time_extend = array();
        if(!empty($info['time_extend'])){
            $time_extend = json_decode($info['time_extend'],true);
            foreach ($time_extend as $k=>$v){
                $time_extend[$k]['start_time']      = empty($v['start_time'])?'':date('Y-m-d',$v['start_time']);
                $time_extend[$k]['end_time']        = empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
            }
        }
        $count = count($time_extend);
        if(!empty($info['start_time']) || !empty($info['end_time'])){
            $time_extend[$count] = array('start_time'=>$info['start_time'],'end_time'=>$info['end_time']);
        }
        $info['time_extend'] = $time_extend;
        //用户信息
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $reqs['rfp_id']
            ]
        ] ];
        $base        = array($info);
        $humans = $this -> _Rfp_user ->getDatas($conditions);
        //预算信息
        $budget = $this -> _Rfp_budget ->getDatas($conditions);
        //获取参会人
        $join_user = $this -> _Rfp_user ->getDatas($conditions);
        //获取签到点
        $dot = $this -> _Join_dot -> getDot($reqs['rfp_id']);

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
        return array('base'=>$base,'humans'=>$humans,'budget'=>$budget,'ids_str'=>$ids_str, 'dot' => $dot);
    }

    public function createSubmit( Request $request){

        if( $request -> isMethod( 'POST' ) ){
            $reqs   = $request -> except( '_token' );
            $data   = $this->format_post_data($reqs);
            $basic  = $data['basic'];//基础信息
            //print_r($data);exit;
            if (
                empty($basic['meeting_name']) || ($basic['bit_type'] == '') || empty($basic['start_time']) ||
                empty($basic['end_time']) || empty($basic['people_num']) || empty($basic['provincedesc']) ||
                empty($basic['citydesc']) || empty($basic['meeting_type_desc']) ||
                empty($basic['meeting_type_code']) || empty($basic['marketorgdesc']) || empty($basic['marketorgcode'])
            ) {
                return json_encode(array('status'=>'0','data'=>'','error'=>'创建失败,参数缺失'));
            }
            //查看会议是否有审核人
            $author = $this->getAuthor();
            if(empty($author)){
                return json_encode(array('status'=>'0','data'=>'','error'=>'您还没有审核员，请先去创建审核员'));
            }
            $basic['auditor_no']        = $author['id'];//审核人
            $basic['auditor']           = $author['username'];//审核名称
            $step                       = '102';//当前timeline
            //验证会议是否存在
            $rfp_info                   = $this->is_meeting($data['rfp_id'],$basic['meeting_code']);
            $basic['status']            = '10';//会议保存成功待审核状态


            DB::beginTransaction();
            try
            {
                if(empty($rfp_info)){//插入
                    $basic['create_time']           = time();
                    //添加会议信息
                    $rfp_id = $this -> _Rfp -> insertDatas( $basic );
                    //添加会议预算信息
                    $this->addBudget($data['budget'],$rfp_id);
                    //添加参会人员
                    $this->addPerson($data['meeting_file'],$rfp_id);

                    $content = '创建';
                }else{//更新
                    $rfp_id = $rfp_info['rfp_id'];
                    $basic['update_time']   = time();
                    //更新会议信息
                    DB::table('rfp')->where('rfp_id',$rfp_id)->update($basic);
                    //更新会议预算信息
                    $this->updateBudget($data['budget'],$rfp_id);
                    //更新参会人员
                    if(!empty($data['meeting_file'])) {
                        $this->updatePerson($data['meeting_file'], $rfp_id);
                    }
                    $content = '更新';
                }
                //添加签到点
                $this->addDot($data['dot'],$rfp_id);
                //添加项目进度
                $this -> _Rfp_timeline->addTimeline($rfp_id,$step);
                //添加消息通知创建人
              //  $this->addNotice($basic,$rfp_id,'1','101','会议'.$basic['meeting_code'].'已经'.$content.'成功');
                //添加消息通知审核人
                $this->addNotice($basic,$rfp_id,'2','101','会议'.$basic['meeting_code'].'已经'.$content.'成功，请及时去审核');
                //添加操作日志
                $this->addLog($basic,$rfp_id,'会议'.$basic['meeting_code'].'已经'.$content.'成功');

           DB::commit();
                return json_encode(array('status'=>'1','data'=>array('rfp_id'=>$rfp_id,'meeting_code'=>$basic['meeting_code'])));
            }
            catch(\Exception $e)
            {
                //写入文本日志
                $message = "会议创建失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );echo $e -> getMessage();
                DB::rollBack();
                return json_encode(array('status'=>'0','data'=>'','error'=>'创建失败'));
            }
        }
        return json_encode(array('status'=>'0','data'=>'','error'=>'创建失败'));
    }

    //保存草稿
    public function saveSubmit( Request $request){

        if( $request -> isMethod( 'POST' ) ){
            $reqs       = $request -> except( '_token' );
            $data       = $this->format_post_data($reqs);
            $basic      = $data['basic'];//基础信息
            $step       = '101';//当前timeline
            if (
                empty($basic['meeting_code']) || empty($basic['meeting_name'])
            ) {
                return json_encode(array('status'=>'0','data'=>'','error'=>'创建失败,参数缺失'));
            }
            //查看会议是否存在
            $rfp_info           = $this->is_meeting($data['rfp_id'],$basic['meeting_code']);
            $basic['status']    = '9';//保存会议草稿状态
            DB::beginTransaction();
            try
            {
                if(empty($rfp_info)){//插入
                    $basic['create_time']           = time();
                    //添加会议信息
                    $rfp_id = $this -> _Rfp -> insertDatas( $basic );
                    //添加会议预算信息
                    $this->addBudget($data['budget'],$rfp_id);
                    //添加参会人员
                    $this->addPerson($data['meeting_file'],$rfp_id);
                }else{//更新
                    $rfp_id                 = $rfp_info['rfp_id'];
                    $basic['update_time']   = time();
                    //更新会议信息
                    DB::table('rfp')->where('rfp_id',$rfp_id)->update($basic);
                    //更新会议预算信息
                    $this->updateBudget($data['budget'],$rfp_id);
                    //更新参会人员
                    if(!empty($data['meeting_file'])){
                        $this->updatePerson($data['meeting_file'],$rfp_id);
                    }
                }
                //添加签到点
                $this->addDot($data['dot'],$rfp_id);
                //添加项目进度
                $this -> _Rfp_timeline->addTimeline($rfp_id,$step);
                //添加消息通知创建人
              //  $this->addNotice($basic,$rfp_id,'1','101','会议'.$basic['meeting_code'].'已经保存草稿');
                //添加操作日志
                $this->addLog($basic,$rfp_id,'会议'.$basic['meeting_code'].'已经保存草稿');

                DB::commit();
                return json_encode(array('status'=>'1','data'=>array('rfp_id'=>$rfp_id,'meeting_code'=>$basic['meeting_code'])));
            }
            catch(\Exception $e)
            {
                //写入文本日志
                $message = "会议保存失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                DB::rollBack();
                return json_encode(array('status'=>'0','data'=>'','error'=>'会议保存失败'));
            }
        }
        return json_encode(array('status'=>'0','data'=>'','error'=>'会议保存失败'));
    }

    public function is_meeting($rfp_id,$meeting_code){
        if(!empty($rfp_id)){
            return DB::table('rfp')->whereRaw('rfp_id='.$rfp_id.' and meeting_code="'.$meeting_code.'"')->first();
        }else{
            return array();
        }
    }

    public function format_post_data($reqs){
        /**
         * 会议创建第一步基础信息
         */
        $data['rfp_id']                 = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );//会议id
        $param['status']                = empty($reqs['status'])?0:filterParam( $reqs['status'] );//会议状态
        $param['meeting_name']          = empty($reqs['meeting_name'])?'':filterParam( $reqs['meeting_name'] );//会议名称
        $param['bit_type']              =  (!isset($reqs['bit_type']) || $reqs['bit_type'] == '')?'':filterParam( $reqs['bit_type'] );//竞标类型
        $param['meeting_code']          = empty($reqs['meeting_code'])?$this->generate_executprojectcode(1):$reqs['meeting_code'];//会议编码
        $param['meeting_type_code']     = empty($reqs['meeting_type_code'])?'':filterParam( $reqs['meeting_type_code'] );//会议类型编码
        $param['meeting_type_desc']     = config('system.meeting_type.'.$reqs['meeting_type_code'].'.value');//会议类型名称
        $param['trip_start_time']       = empty($reqs['trip_start_time'])?0:filterParam( $reqs['trip_start_time'] );//行程开始时间int
        $param['trip_end_time']         = empty($reqs['trip_end_time'])?0:filterParam( $reqs['trip_end_time'] );//行程结束时间int
        $param['provincedesc']          = empty($reqs['provincedesc'])?'':filterParam( $reqs['provincedesc'] );//会议省份
        $param['provincecode']          = empty($reqs['provincecode'])?'':filterParam( $reqs['provincecode'] );//省份编码
        $param['citydesc']              = empty($reqs['citydesc'])?'':filterParam( $reqs['citydesc'] );//会议城市
        $param['citycode']              = empty($reqs['citycode'])?'':filterParam( $reqs['citycode'] );//城市编码
        $param['abroad_site']           = empty($reqs['abroad_site'])?'':filterParam( $reqs['abroad_site'] );//海外会议地址
        $param['marketorgcode']         = empty($reqs['marketorgcode'])?'':$reqs['marketorgcode'] ;//成本中心编码
        $param['marketorgdesc']         = $this->getDatasByCode($param['marketorgcode']);//成本中心名称
        $param['department']            =empty($reqs['department'])?'':$reqs['department'];//部门
        $param['department_name']            =config('system.department.'.$reqs['department'].'.value');//部门
        $param['abroad_file']           = empty($reqs['abroad_file'])?'':filterParam( $reqs['abroad_file'] );//会议日程上传文件地址
        //会议时间
        $meeting_time_arr               = empty($reqs['meeting_time'])?array():json_decode($reqs['meeting_time'],true);// 会议时间
        $param['start_time']            ='0';//会议开始时间int
        $param['end_time']              = '0';//会议结束时间int
       // $param['dot']                   = $reqs['dot'];
        $time_extend    = array();
        foreach ($meeting_time_arr as $k=>$t){
            if($k == 0){
                $param['start_time']    = strtotime($t['value1']);
                $param['end_time']      = strtotime($t['value2']);
            }else{
                $time_extend[] = array(
                    'start_time' => strtotime($t['value1']),
                    'end_time' => strtotime($t['value2'])
                );
            }
        }
        $param['time_extend']           = json_encode($time_extend);
        /**
         * 会议创建第二步会议预算
         */
        //各类预算明细
        $fundtypecode_arr               = empty($reqs['fundtypecode_arr'])?array():json_decode($reqs['fundtypecode_arr'],true);// 费用类型编码=>费用预算金额
        $budget_total_amount = 0;
        $budget_list = array();
        foreach ($fundtypecode_arr as $v) {
                if($v['checked'] == true){
                    $budget_list[] = $v;
                    $budget_total_amount  = $budget_total_amount + $v['num'];
                }
        }
        $data['budget']                 = $budget_list;
        $param['budget_total_amount']   = $budget_total_amount;//总预算
        $param['look_budget']           = $reqs['look_budget']?1:0;//预算是否可见
        /**
         * 会议创建第三步参会信息
         */
        $param['clientele_num']         = empty($reqs['clientele_num'])?0:intval($reqs['clientele_num']); //客户参会人数
        $param['within_num']            = empty($reqs['within_num'] )?0:intval($reqs['within_num'] ); //客户参会人数
        $param['nonparty_num']          = empty($reqs['nonparty_num'] )?0:intval($reqs['nonparty_num'] ); //客户参会人数
        $param['people_num']            = $param['clientele_num']+$param['within_num']+$param['nonparty_num']; //参会总人数
        $data['meeting_file']           = empty($reqs['meeting_file'])?array():json_decode( $reqs['meeting_file'],true );//参会人员上传文件地址

        $param['update_time']           = time();
        $param['user_code']             = session('user')['id'];//发起人id
        $param['user_name']             = session('user')['username'];//发起人名称
        $data['basic']                  = $param;

        //签到点
        $data['dot'] = [];
        if($reqs['dot']){
            $dotArr = explode(',', $reqs['dot']);
            $data['dot'] = $dotArr;
        }
        return $data;
    }

    // 生成会议编码
    private function generate_executprojectcode($type) {
        //当前会议的最大编码
          $number_part  = DB::select("select meeting_code from rfp where meeting_code like '".config('system.meeting.'.$type)."%' order by meeting_code desc limit 1");
          $number       = empty($number_part)?'0':$number_part[0]['meeting_code'];
         $paddedNum     = sprintf("%05d", substr($number, -5)+1);
        //  组合拼接新会议编码
        return config('system.meeting.'.$type)."-" . date('Y') . "-SC-" . $paddedNum;

    }

    public function uploadFile(Request $request) {
        // 文件上传
        if($request -> isMethod( 'POST' ) ) {
            $reqs = $request -> except( '_token' );
            if(empty($reqs['name'])){
                return array('status' => '0', "error" => '没有获取到文件信息');
            }
            if($reqs['type'] == '1'){//上传日程
                echo upload_upanyun_file($reqs['name']);
                exit;
            }elseif($reqs['type'] == '2'){//参会人员
                $type = array('xls','xlsx');
                $size = 500;
                $this->backJsonPerson($reqs['name'],$type,$size);
            }elseif($reqs['type'] == '3'){//托管
                $type = array('jpg','jpeg','png');
                $size = 1024*2;//kb
            }else{
                return array('status' => '0', "error" => '上传失败');
            }
            echo upload_upanyun_file($reqs['name'],$type,$size);
            exit;
        }
        return array('status' => '0', "error" => '上传失败');
    }
    //返回参加人员json数据
    public function backJsonPerson($name,$type,$size){
        //返回json格式文件
        if (!empty($_FILES[$name])) {
            $file_name = $_FILES[$name]['name'];
            $file_size = $_FILES[$name]["size"];
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            if(!in_array($file_ext,$type)){
                echo  json_encode(array('status' => '0', "error" => '上传文件类型有误'));
                exit;
            }
            if($file_size > $size*1024){
                echo  json_encode(array('status' => '0', "error" => '上传文件超过大小限制'));
                exit;
            }
            $path = $_FILES[$name]['tmp_name'];
            Excel::load($path, function($reader) use( &$res ) {
                $reader = $reader->getSheet(0); //获取文件内容为一个对象
                $res = $reader->toArray();  //将文件内容转换成数组
            });
            if(empty($res))$res = '';
            $array = array('status'=>'1','data'=>$res,'name'=>$_FILES[$name]['name']);
            echo json_encode($array);
            exit;
        }else{
            echo  json_encode(array('status' => '0', "error" => '上传失败'));
            exit;
        }
    }

    public function getDatasByCode( $code )
    {
        $data = DB::table('marketorg')->where('marketorgcode', $code)->first();
        return $data['marketorgdesc'];
    }
    /**
     * 会议托管
     */
    public function createDeposit( Request $request){
        if( $request -> isMethod( 'POST' ) ) {
            $reqs = $request->except('_token');
            $step = '101';
            $param['status']            = '9';//会议状态
            $param['meeting_name']      = empty($reqs['meeting_name'])?'':filterParam( $reqs['meeting_name'] );//会议名称
            $param['meeting_code']      = $this->generate_executprojectcode(1);//会议编码
            $param['deposit_code']         = session('user')['id'];//发起人id
            $param['deposit_name']         = session('user')['username'];//发起人名称
            $param['create_time']       = time();
            $param['update_time']       = time();
            $param['user_code']      = empty($reqs['deposit_code'])?0:filterParam( $reqs['deposit_code'] );//会议托管人编码
            $param['user_name']      = empty($reqs['deposit_name'])?'':filterParam( $reqs['deposit_name'] );//会议托管人名称
            $param['deposit_proof']     = empty($reqs['deposit_proof'])?'':filterParam( $reqs['deposit_proof'] );//托管凭证
            if(empty($param['meeting_name']) || empty($param['deposit_code']) || empty($param['deposit_proof'])){
                return json_encode(array('status'=>'0','data'=>'','error'=>'托管失败,参数缺失'));
            }
            DB::beginTransaction();
            try
            {
                $rfp_id = $this->_Rfp-> insertDatas( $param );
                //添加项目进度
                $this -> _Rfp_timeline->addTimeline($rfp_id,$step);
                //添加操作日志
                $this->addLog($param,$rfp_id,'会议'.$param['meeting_code'].'已经授权成功');

                DB::commit();
                return json_encode(array('status'=>'1','data'=>array('rfp_id'=>$rfp_id,'meeting_code'=>$param['meeting_code'])));
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "会议授权,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                DB::rollBack();
                return json_encode(array('status'=>'0','data'=>'','error'=>'授权失败'));
            }

        }
        return json_encode(array('status'=>'0','data'=>'','error'=>'授权失败'));
    }

    //获取会议类型
    public function getMeetingType(){
        $meeting_type =  config('system.meeting_type');
        $meeting_type = array_values($meeting_type);
        return json_encode($meeting_type);
    }
    //获取预算类目
    public function getRfpBudget(){
        $consume_type =  config('system.consume_type');
        $consume_type = array_values($consume_type);
        return json_encode($consume_type);
    }
    //获取托管人员
    public function getDepositPerson(){
        $sql ='SELECT u.id,u.username as `value` FROM  users AS u
               LEFT JOIN user_role AS r ON u.id = r.user_id
               LEFT JOIN roles AS s ON s.id = r.role_id
               WHERE s.name="会议授权人" and u.status=1';
        $data = DB::select($sql);
        return json_encode($data);
    }
    //获取部门
    public function getDepartment(){
        $deposit_person =  config('system.department');
        $deposit_person = array_values($deposit_person);
        return json_encode($deposit_person);
    }
    //获取成本中心
    public function getMarketorg(  )
    {
        $data = DB::table('marketorg')->select('marketorgcode as id','marketorgdesc as value')->get();
        if(!$data)return json_encode(array());
        return json_encode($data);
    }

    //添加预算
    public function addBudget($budget,$rfp_id){
        if(!empty($budget) && !empty($rfp_id)){
            $insert_rfp_budget_data = array();
            foreach ($budget as $v){
                $insert_rfp_budget_data[] = array(
                    'fundtypecode'      =>  $v['id'],
                    'fundtypedese'      =>  config('system.consume_type.'.$v['id'].'.value'),
                    'budgetamount'      =>  $v['num'],
                    'rfp_id'            =>  $rfp_id,
                );
            }
            $this -> _Rfp_budget -> insertDatas( $insert_rfp_budget_data );
        }
    }
    //更新预算
    public function updateBudget($budget,$rfp_id){
        if(!empty($rfp_id)){
            //查看表中是否有预算信息
            $where = array(
                'where' => array(
                    'rfp_id' => array(
                        'symbol'=> '=',
                        'value' => $rfp_id
                    )
                )
            );
            $rfp_budget = $this -> _Rfp_budget -> getDatas( $where );
            if(!empty($rfp_budget)){
                //删除原预算信息
                DB::table('rfp_budget')->where(array('rfp_id'=>$rfp_id))->delete();
            }
            if(!empty($budget)){
                $this->addBudget($budget,$rfp_id);
            }
        }
    }
    /*
      * `name`  '参会人姓名',
     * `spelling`  '参会人姓名拼音',
     * `sex`  '性别 0女 / 1 男',
     * `phone`  '手机号',
     * `city`  '所在城市',
     * `company`  '单位名称',
     * `duty`  '职称/职位',
     * `id_card`  '身份证号',
     * `email`  '邮箱',
     * `room_type`  '意向房间',
     * `status`  '数据状态0失效/1正常/2变更',
      * */
    //添加参会人员
    public function addPerson($meeting_file,$rfp_id){

            if(!empty($meeting_file)){
                $arr = array();
                foreach ($meeting_file as $k=>$v){
                    if ($k < 1) {
                        continue;
                    }

                    $arr[] = array(
                        'name'      => trim($v[0]),
                        //'sex'       => in_array($v[1],array('男','女'))?($v[2]=='男'?1:0):'',
                        'sex'       => $v[1] == '男' ? 1 :0,
                        'city'      => trim($v[2]),
                        'company'   => trim($v[3]),
                        'duty'      => trim($v[4]),
                        'phone'     => trim($v[5]),
                        'id_card'   => trim($v[6]),
                        'email'     => trim($v[7]),
                        'room_type' => trim($v[8]),
                        'rfp_id'    => $rfp_id,
                        'create_user' => session('user')['id'],
                        'create_time' => date('Y-m-d H:i:s', time()),
                        'status'            => '1',
                    );
                }
                $this -> _Rfp_user ->insertDatas($arr);
            }

    }

    function addDot( $dotArr, $rfp_id ){
        $arr = $this -> _Join_dot -> getDot( $rfp_id );

        if( $arr ){
            $this -> _Join_dot -> del($rfp_id);
        }
        $cleanDotArr    = [];
        $allDotArr      = [];
        foreach($dotArr AS $key => $value){
            $cleanDotArr['rfp_id']    = $rfp_id;
            $cleanDotArr['dot_name']  = $value;
            $allDotArr[] = $cleanDotArr;
        }
        if($allDotArr){
            $this -> _Join_dot -> insertDatas($allDotArr);
        }
    }

    //更新参会人员
    public function updatePerson(){
        //查看表中是否有参会人员信息
        $where = array(
            'where' => array(
                'rfp_id' => array(
                    'symbol'=> '=',
                    'value' => $rfp_id
                )
            )
        );
        $rfp_user = $this -> _Rfp_user -> getDatas( $where );
        if(!empty($rfp_user)){
            //删除原参会人员信息
            DB::table('join_users')->where(array('rfp_id'=>$rfp_id))->delete();
        }
        $this->addPerson($meeting_file,$rfp_id);
    }

    //添加消息
    public function  addNotice($basic,$rfp_id,$type,$notice_type,$content){
        if($type == '1'){
            $responsiblead = $basic['user_code'];
        }elseif ($type == '2'){
            $responsiblead = $basic['auditor_no'];
        }elseif ($type == '3'){
            $responsiblead = $basic['deposit_code'];
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

    //会议审核
    /*   status:    '11' => '审核失败（程序报错）',
                    '12' => '审核未通过',//人为
                    '20' => '待发询单',
    */
    public function checkMeeting( Request $request){
            $reqs               = $request->except('_token');
            $rfp_id             = empty($reqs['rfp_id'])?'':filterParam($reqs['rfp_id']);
            $is_pass            = empty($reqs['is_pass'])?'0':filterParam($reqs['is_pass']);//是否审核通过0未通过1通过
            $data['reason']     = empty($reqs['reason'])?'':filterParam($reqs['reason']);//审核未通过原因
            $data['update_time'] = time();
            if(empty($rfp_id) || (!$is_pass && empty($data['reason']))){
                return returnJson(false,'','参数缺失');
            }
            //获取会议详细信息
            $rfp_info = $this->_Rfp->getRfpByRfpid($rfp_id);
            if(empty($rfp_info) || ($rfp_info[0]['status'] !='11' && $rfp_info[0]['status']!='10')){
                return returnJson(false,'','会议信息有误，请核查');
            }
            $rfp_info = $rfp_info[0];
            DB::beginTransaction();
            try
            {
                if($is_pass){
                    $data['status'] = '20';
                    $content = '审核通过';
                    //添加项目进度
                    $this -> _Rfp_timeline->addTimeline($rfp_id,'103');
                }else{
                    $data['status'] = '12';
                    $content = '审核未通过';
                }
                $this->_Rfp->updateDatas($rfp_id,$data);
                //添加消息通知创建人
                    $this->addNotice($rfp_info,$rfp_id,'1','102','会议'.$rfp_info['meeting_code'].$content);
                if(!empty($rfp_info['deposit_code'])){//如果是托管会议，通知托管人
                    $this->addNotice($rfp_info,$rfp_id,'3','102','会议'.$rfp_info['meeting_code'].$content);
                }
                //添加操作日志
                $this->addLog($rfp_info,$rfp_id,'会议'.$rfp_info['meeting_code'].$content);

                DB::commit();
                return returnJson(true,$content,'');
            }
            catch(\Exception $e)
            {
                //写入文本日志
                $message = "会议审核失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                DB::rollBack();
                $this->_Rfp->updateDatas($rfp_id,array('status'=>'11'));
                return returnJson(false,'','审核失败(程序报错)');
            }
    }

    //提醒审核人
    public function noticeAuthor(Request $request){
        $reqs = $request->except('_token');
        if(!isset($reqs['rfp_id']) || empty($reqs['rfp_id'])){
            return returnJson(false,'','参数缺失');
        }
        //获取会议信息
        $rfp = $this->_Rfp->getRfpByRfpid($reqs['rfp_id']);
        if(!isset($rfp[0]) || empty($rfp[0])){
            return returnJson(false,'','会议信息有误');
        }
        //验证当日是否已提醒审核人
        if($this->checkNotice($reqs['rfp_id'])){
            return returnJson(false,'','已经发送通知, 无需重复执行');
        }
        try
        {
            //添加消息通知审核人
            $this->addNotice($rfp[0],$reqs['rfp_id'],'2','101','会议'.$rfp[0]['meeting_code'].'已经创建成功，请及时去审核.');
            //添加操作日志
            $this->addLog($rfp[0],$reqs['rfp_id'],session('user')['id'].'提醒会议'.$rfp[0]['meeting_code'].'的审核人');
            return returnJson(true,array('rfp_id'=>$reqs['rfp_id'],'meeting_code'=>$rfp[0]['meeting_code']),'审核人已通知');
        }
        catch(\Exception $e)
        {
            //写入文本日志
            $message = "会议创建失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return returnJson(false,'','提醒失败');
        }

    }
    public function checkNotice($rfp_id){
        if(empty($rfp_id))return true;
        $startTime = strtotime(date('Y-m-d 00:00:00',time()));
        $endTime = strtotime(date('Y-m-d 23:59:59',time()));
        $sql = 'select count(*) as count from user_notice where rfp_id = '.$rfp_id.' and notice_ctime>= '.$startTime.' and notice_ctime<= '.$endTime.' and notice_type=101 and notice_status=0';
        $sum = DB::select($sql);
        if($sum[0]['count'] > 0){
            return true;
        }
        return false;
    }

    //获取会议审核人
    public function getAuthor(){
        $user_marketorgcode = session('user')['marketorgcode'];

        $sql ='SELECT u.id,u.username FROM  users AS u
               LEFT JOIN user_role AS r ON u.id = r.user_id
               LEFT JOIN roles AS s ON s.id = r.role_id
               WHERE u.marketorgcode='.$user_marketorgcode.' and s.name="费用审核员" and u.status=1';
        $data = DB::select($sql);
        if(isset($data[0]) && !empty($data[0])){
            return $data[0];
        }
        return array();

    }

    //获取会议竞标类型
    public function getMeetingBitTypes(){
        $bit_type =  config('system.bit_type');
        $data = [];
        foreach($bit_type as $k => $v){
            $data[] = ['id' => $k, 'value' => $v];
        }
        return json_encode($data);
    }

    }

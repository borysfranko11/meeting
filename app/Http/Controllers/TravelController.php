<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\22 0022
 * Time: 10:48
 */
namespace App\Http\Controllers;

use App\Models\ConfirmUserInfo;
use App\Models\JoinUsers;
use App\Models\ParticipantLog;
use App\Models\TravelInfo;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Excel;

class TravelController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> __Confirm = new ConfirmUserInfo();
        $this -> __Join = new JoinUsers();
        $this -> __Log = new ParticipantLog();
        $this -> __Travel = new TravelInfo();
    }

    //出行信息列表
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $url = array();
            $url['rfp_id'] = $request->input('rfp_id');
            $url['name'] = $request->input('name');
            $url['phone'] = $request->input('phone');
            $url['status'] = $request->input('status');
        }
        if ($request->isMethod('GET')) {
            $rfp_id = $request->get('rfp_id');
            $rfp_id = (intval($rfp_id) == null || intval($rfp_id) < 0) ? abort('503') : intval($rfp_id);   // TODO : where I go ?
            $url['rfp_id'] = $rfp_id;
            $url['name'] = $request->get('name');
            $url['phone'] = $request->get('phone');
            $url['status'] = $request->get('status');
        }
        $where_str = [];
        if (!empty($url['status'])) {
            $where_str[0] = "join_users.status = '$url[status]' ";
        }
        // 姓名
        if (!empty(trim($url['name']))) {
            $where_str[1] = " join_users.name like '%$url[name]%' ";
        }

        // 电话号
        if (!empty(trim($url['phone']))) {
            $where_str[2] = " join_users.phone like '%$url[phone]%' ";
        }
        $where_arr = implode('and', $where_str);
        if (empty($where_arr)) {
            $users = DB::table('join_users')
                ->join('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.join_id', 'join_users.name', 'join_users.status', 'join_users.sex', 'join_users.phone', 'join_users.id_card',
                    'confirm_user_info.come_time', //去程日期
                    'confirm_user_info.come_type', //去程出行方式
                    'confirm_user_info.come_code', //去程航班车次
                    'confirm_user_info.come_begin_city', //去程出发地
                    'confirm_user_info.come_end_city', //去程目的地
                    'confirm_user_info.leave_time',     //返程出发日期
                    'confirm_user_info.leave_type', //返程出行方式
                    'confirm_user_info.leave_code', //返程意向航班、车次
                    'confirm_user_info.leave_begin_city', //返程出发地
                    'confirm_user_info.leave_end_city', //返程目的地
                    'confirm_user_info.confirm_type' //信息确认状态  与意向是否相符
                )
                ->where('join_users.rfp_id', $url['rfp_id'])
                ->where('join_users.status','!=','0')
                ->whereRaw('(confirm_user_info.is_come_ticket = ? or confirm_user_info.is_leave_ticket = ?)',[1,1])
                ->paginate(20, ['*'], 'user');
        } else {
            $users = DB::table('join_users')
                ->join('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.join_id', 'join_users.name', 'join_users.status', 'join_users.sex', 'join_users.phone', 'join_users.id_card',
                    'confirm_user_info.come_time', //去程日期
                    'confirm_user_info.come_type', //去程出行方式
                    'confirm_user_info.come_code', //去程航班车次
                    'confirm_user_info.come_begin_city', //去程出发地
                    'confirm_user_info.come_end_city', //去程目的地
                    'confirm_user_info.leave_time',     //返程出发日期
                    'confirm_user_info.leave_type', //返程出行方式
                    'confirm_user_info.leave_code', //返程意向航班、车次
                    'confirm_user_info.leave_begin_city', //返程出发地
                    'confirm_user_info.leave_end_city', //返程目的地
                    'confirm_user_info.confirm_type' //信息确认状态  与意向是否相符
                )
                ->whereRaw($where_arr)
                ->where('join_users.rfp_id', $url['rfp_id'])
                ->whereRaw('(confirm_user_info.is_come_ticket = ? or confirm_user_info.is_leave_ticket = ?)',[1,1])
                ->paginate(20, ['*'], 'user');
            }
            $travel_info = DB::table('travel_info')
                ->select('join_id','t_way','t_type','begin_time','begin_city','end_city','t_code')
                ->where('t_way','!=',0)
                ->get();
            //获取参会人id
        $user_ids = DB::table('join_users')
            ->join('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
            ->where('join_users.rfp_id', $url['rfp_id'])
            ->where('join_users.status','!=','0')
            ->whereRaw('(confirm_user_info.is_come_ticket = ? or confirm_user_info.is_leave_ticket = ?)',[1,1])
            ->lists('join_users.join_id');

        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }
            //日志列表
            $where = array(
                'rfp_id' => $url['rfp_id'],
                'type' => 3,
            );
            $logs = $this->get_participant_log($where, 'desc', 'create_time', 10);
            $logs = $logs ? $logs : array();

            $url_str = url('/Confirm/index') . '/?';
            foreach ($url as $v => $k) {
                $url_str .= $v . '=' . $k . '&';
            }
            return view('rfp/travel', ['users' => $users, 'url' => $url, 'logs' => $logs, 'url_str' => $url_str,'travel_info'=>$travel_info,'ids_str'=>$ids_str]);
        }

    //与意向不符时信息浏览
    public function actual_travel(Request $request)
    {
        $join_id = $request['join_id'];
        $travel = DB::table('travel_info')
            ->select('t_way', //出行方向
                't_type', //出行方式
                'begin_time', //出行时间
                'begin_city', //出发地
                'end_city', //目的地
                't_code', //航班车次
                't_level', //座舱等级
                't_money' //机票价格
            )->where('join_id','=',$join_id)
            ->where('status','!=',0)
            ->get();
        return view("join.actualTravel" ,["travel"=>$travel]);
    }

    //出行信息下载模板
    public function template(Request $request)
    {
        $rfp_id = $request->get('rfp_id'); //询单id
        if(!is_numeric($rfp_id)){
            abort('503');
        }
        $user = DB::table('join_users') //需要去程机票的参会人
            ->join('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id' )
            ->select('join_users.join_id', //用户id
                'join_users.name', //姓名
                'join_users.sex', //性别
                'join_users.phone', //手机号
                'join_users.id_card', //身份证号
                'confirm_user_info.come_time', //去程日期
                'confirm_user_info.come_type', //去程出行方式
                'confirm_user_info.come_code', //去程航班车次
                'confirm_user_info.come_begin_city', //去程出发地
                'confirm_user_info.come_end_city' , //去程目的地
                'confirm_user_info.leave_time',     //返程出发日期
                'confirm_user_info.leave_type', //返程出行方式
                'confirm_user_info.leave_code', //返程意向航班、车次
                'confirm_user_info.leave_begin_city', //返程出发地
                'confirm_user_info.leave_end_city' //返程目的地
            )
            ->where('join_users.rfp_id',$rfp_id)
            ->where('join_users.status','!=',0)
            ->whereRaw('(confirm_user_info.is_come_ticket = ? or confirm_user_info.is_leave_ticket = ?)',[1,1])
            ->get();
        if(empty($user)){ //判断数据数量
            die ("暂无参会人员");
        }
        foreach($user as $key=>$v){

            $user[$key]['sex']==0?$user[$key]['sex']='女':$user[$key]['sex']='男'; //改变性别字段的显示
            $user[$key]['come_type'] ==0?$user[$key]['come_type'] ='火车':$user[$key]['come_type'] ='飞机';
            $user[$key]['leave_type'] == 0?$user[$key]['leave_type'] = '火车':$user[$key]['leave_type'] = '飞机';
        }

        //添加日志
        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '出行信息下载成功',
                'node' => $this-> __url,
                'rfp_id' => $request['rfp_id'],
                'type' => '3',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}出行信息下载模板,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H:i:s',time());
        Excel::create($file_name, function($excel) use($user){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($user){ //创建表格
                $sheet->fromArray($user,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->setWidth(array(
                    'A'=>12,'B'=>15,'C'=>15,'D'=>20,'E'=>20,'F'=>15,'G'=>20,'H'=>20,'I'=>20,'J'=>20,'K'=>20,'L'=>20,'M'=>20,'N'=>20,'O'=>20,'P'=>25,'Q'=>25,'R'=>25,'S'=>25,'T'=>25,'U'=>25
                ));
                $sheet->row(1, array(  //改变表头
                    '用户id','姓名','性别','手机号','身份证号／护照号','去程日期','出行方式','意向航班号／车次号','出发地','目的地','返航日期','出行方式','意向航班号／车次号','出发地','目的地','去程出行方式（火车/飞机）','去程实际航班号／车次号','去程仓位级别／座位等级','去程机票／火车票价格（元）','返程出行方式（火车/飞机）','返程实际航班号／车次号','返程仓位级别／座位等级','返程机票／火车票价格（元）'
                ));
            });
        })->download('xlsx');
    }

    //出行信息数据导入
    public function import(Request $request)
    {
        if($request['rfp_id']<0 || !is_numeric($request['rfp_id'])){
            abort( 503 );
        }
        if(!$request->hasFile('file')){
            return ['num'=>'1'];//文件为空
        }
        $file = $_FILES;  //文件属性 name  type  tmp_name  error  size
        if($file['file']['type'] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
            return ['num'=>'1'];//文件格式不对
        }
        if($file['file']['size'] > 1024*1024*2){
            return ['num'=>'2'];//文件过大
        }
        $excel_file_path = $file['file']['tmp_name']; //获取上传后文件的路径
        $res = [];
        Excel::load($excel_file_path, function($reader) use( &$res ) {
            $reader = $reader->getSheet(0); //获取文件内容为一个对象
            $res = $reader->toArray();  //将文件内容转换成数组
        });
        if(count($res) > 60001){
            return ['num'=>'3' ];
        }

        if( count($res) <= 1 )
        {
            return fasle;  // todo  数据导入错误
        }

        $s_id = [];
        $id = DB::table('confirm_user_info')
            ->select('join_id')
            ->where('confirm_type','!=',0)
            ->whereRaw('is_leave_ticket = ? or is_come_ticket = ?',[1,1])
            ->get();
        foreach($id as $k=>$v){
            array_push($s_id,$v['join_id']);
        }

        //dd($s_id);

        $trip = array();   //导入的去程信息
        $return_trip = array(); //导入的回程信息

        //  拼接数据
        foreach ( $res as $k => $v) {
            if ($k < 1) {
                continue;
            }
            $trip[$k] = array(
                'join_id'      => trim($v[0]),                          //用户id
                'begin_time'   => trim($v[5]),                          //去程日期
                't_type'       => empty(trim($v[15]))? 0 :(trim($v[15]) == '火车' ? 2 : 1),                          //去程出行方式
                'begin_city'   => trim($v[8]),                          //去程出发地
                'end_city'     => trim($v[9]),                          //去程目的地
                't_code'       => trim($v[16]),                         //去程航班车次
                't_level'      => trim($v[17]),                         //去程仓位/座位等级
                't_money'      => trim($v[18]),                         //去程机票/车票价格
                't_way'        => 1,                                    //去程
                'create_user'  => session::get("user.id"),              //执行添加人
                'create_time'  => date('Y-m-d H:i:s', time()),   //添加时间
            );
            if(empty(trim($v[15]))){
                unset($trip[$k]);
            }
            $return_trip[$k] = array(
                'join_id'      => trim($v[0]),                          //用户id
                'begin_time'   => trim($v[10]),                         //返程出发日期
                't_type'       => empty(trim($v[19]))? 0 :(trim($v[19]) == '火车' ? 2 : 1),                         //返程出行方式
                'begin_city'   => trim($v[13]),                         //返程出发地
                'end_city'     => trim($v[14]),                         //返程目的地
                't_code'       => trim($v[20]),                         //去程航班车次
                't_level'      => trim($v[21]),                         //去程仓位/座位等级
                't_money'      => trim($v[22]),                         //去程机票/车票价格
                't_way'        => 2,                                    //返程
                'create_user'  => session::get("user.id"),              //执行添加人
                'create_time'  => date('Y-m-d H:i:s', time()),   //添加时间
            );
            if(empty(trim($v[19]))){
                unset($return_trip[$k]);
            }
        }
        // 错误类型
        $t_t_money        =array( 0=>'第' ,   1=>array()  ,   2=>'行机票价格必须是数字'); //机票价格验证
        $t_join_id        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户无确认信息，请重新下载模板确认用户id信息'); //机票价格验证

        $r_join_id        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户id信息格式不正确,请重新下载模板确认id信息'); //用户id验证
        //$r_join_ids       =array( 0=>'第' ,   1=>array()  ,   2=>'行用户id信息不存在');
        $r_t_money        =array( 0=>'第' ,   1=>array()  ,   2=>'行机票价格必须是数字'); //机票价格验证

        // 错误结果
        $error = array();
        // 验证数据
        foreach ($trip as $k=> $v)
        {
            //id
            if(!in_array($v['join_id'],$s_id)){ $t_join_id[1][] = $k; }
            //机票价格验证
            if(!empty($v['t_money'])) {
                if (!is_numeric($v['t_money'])) {
                    $t_t_money[1][] = $k;
                }
            }
        }
        foreach ($return_trip as $k=> $v)
        {
            //id
            if(!preg_match('/^[0-9]*$/',$v['join_id'])){ $r_join_id[1][]=$k; }
            if($v['join_id'] == 0){ $r_join_id[1][]=$k; }
            //机票价格验证
            if(!empty($v['t_money'])) {
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $v['t_money'])) {
                    $r_t_money[1][] = $k;
                }
            }
        }

        // 错误集体处理
        if( !empty($t_t_types[1])){ $error[] = $t_t_types[0].implode(',',$t_t_types[1]).$t_t_types[2];}
        if( !empty($t_t_type[1])){ $error[] = $t_t_type[0].implode(',',$t_t_type[1]).$t_t_type[2];}
        if( !empty($t_t_money[1])){ $error[] = $t_t_money[0].implode(',',$t_t_money[1]).$t_t_money[2];}
        if( !empty($t_join_id[1])){ $error[] = $t_join_id[0].implode(',',$t_join_id[1]).$t_join_id[2];}
        
        if( !empty($r_join_id[1])){ $error[] = $r_join_id[0].implode(',',$r_join_id[1]).$r_join_id[2];}
        if( !empty($r_t_types[1])){ $error[] = $r_t_types[0].implode(',',$r_t_types[1]).$r_t_types[2];}
        if( !empty($r_t_type[1])){ $error[] = $r_t_type[0].implode(',',$r_t_type[1]).$r_t_type[2];}
        if( !empty($r_t_money[1])){ $error[] = $r_t_money[0].implode(',',$r_t_money[1]).$r_t_money[2];}


        if(empty($error)){
            DB::beginTransaction();
            try {
                DB::table('travel_info')->insert($trip);
                DB::table('travel_info')->insert($return_trip);
                DB::commit();
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '批量导入参会人出行信息成功',
                    'node' => $this-> __url,
                    'rfp_id' => $request['rfp_id'],
                    'type' => '3',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                DB::table('participant_log') -> insert( $param );
                DB::commit();
                $count = count($res)-1;
                return ['msg'=>'数据导入成功'.$count.'条数据','num'=>'5'];
            }catch ( \Exception $e){
                DB::rollback();
                //写入文本日志
                $message = "{session('user')['id']}批量导入参会人出行信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                return $e;
            }
        }else{
            return $error;   // todo  json 方法导出
        }
    }


    //出行信息数据导出
    public function export(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if (!preg_match('/^\d$/', $rfp_id)) {
            abort('503');
        }

        $str = $request->input('join_id'); //主键id
        $join_id = explode(',', $str);
            $user = DB::table('confirm_user_info')
                ->leftJoin('join_users', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.name','join_users.join_id','join_users.sex', 'join_users.phone', 'join_users.id_card', 'join_users.status', 'confirm_user_info.is_come_ticket', 'confirm_user_info.is_leave_ticket', 'confirm_user_info.come_time', 'confirm_user_info.come_type', 'confirm_user_info.come_code', 'confirm_user_info.come_begin_city', 'confirm_user_info.come_end_city', 'confirm_user_info.leave_time', 'confirm_user_info.leave_type', 'confirm_user_info.leave_code','confirm_user_info.leave_begin_city','confirm_user_info.leave_end_city')
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $rfp_id)
                ->whereIn('join_users.join_id', $join_id)
                ->whereRaw('( confirm_user_info.is_come_ticket = ? or confirm_user_info.is_leave_ticket = ? )', [1, 1])
                ->get();
        $travel = DB::table('join_users')
            ->leftJoin('travel_info', 'join_users.join_id', '=', 'travel_info.join_id')
            ->select('travel_info.join_id', 'travel_info.t_way', 'travel_info.t_code', 'travel_info.t_level', 'travel_info.t_money')
            ->where('join_users.rfp_id', '=', $rfp_id)
            ->where('join_users.status', '!=', 0)
            ->where('travel_info.status', '!=', 0)
            ->where('travel_info.t_way', '!=', 0)
            ->get();

        $user_tra = array();
        if( !empty($user) )
        {
            foreach ($user as $k => $value) {
                if( !isset($value['join_id'])){ continue; }  //  如果已经确认的用户没有住房信息 直接跳出循环
                $user_tra[$value['join_id']] = array(
                    'join_id'=> $value['join_id'],
                    'name'=> $value['name'],                   //姓名
                    'status' => $value['status'],              //信息状态
                    'sex' => $value['sex'],                    //性别
                    'phone' => $value['phone'],                //电话
                    'id_card' => $value['id_card'],            //身份证号
                    'is_true'=>0,                              // 是否与意向相符
                    'come_time' => $value['come_time'],        //去程时间
                    'come_type' => $value['come_type'],        //出行方式
                    'come_code' => $value['come_code'],        //意向航班
                    'come_begin_city' => $value['come_begin_city'], //出发地
                    'come_end_city' => $value['come_end_city'], //目的地
                    'leave_time' => $value['leave_time'],      //返航日期
                    'leave_type' => $value['leave_type'],      //返航出行方式
                    'leave_code' => $value['leave_code'],      //返航意向航班
                    'leave_begin_city' => $value['leave_begin_city'],//返航出发地
                    'leave_end_city' => $value['leave_end_city'], //返航目的地
                    'is_come_ticket' => $value['is_come_ticket'], //是否预定去程车、机票
                    'is_leave_ticket' => $value['is_leave_ticket'], //是否预定返程车、机票
                    'come_true'=>0,                            // 是否与意向相符
                    'leave_true'=>0,                           // 是否与意向相符
                    'come_arr' => array(),                     //去程实际信息
                    'leave_arr' => array(),                    //返程实际信息
                );
            }
        }

        if( !empty($travel))
        {
            foreach ( $travel as $k => $v)
            {
                $join_id = $v['join_id'];
                if( !isset($user_tra[$join_id])){ continue; }  //  如果已经确认的用户没有住房信息 直接跳出循环
                // 去程意向
                if( $user_tra[$join_id]['is_come_ticket'] == 1 && $v["t_way"] == 1)
                {
                    if( $user_tra[$join_id]['come_code'] == $v['t_code'])
                    {
                        $user_tra[$join_id]['come_true'] = 1;
                    }
                }
                // 返程意向
                if( $user_tra[$v['join_id']]['is_leave_ticket'] == 2 && $v["t_way"] == 2)
                {
                    if( $user_tra[$join_id]['leave_code'] == $v['t_code'])
                    {
                        $user_tra[$join_id]['leave_true'] = 1;
                    }
                }

                if( $v['t_way'] == 1 )
                {
                    unset($v['join_id']);
                    unset($v['t_way']);   // 实际出行方式
                    $user_tra[$join_id]['come_arr'][] = $v;

                }elseif( $v['t_way'] == 2) {
                    unset($v['join_id']);
                    unset($v['t_way']);   // 实际出行方式
                    $user_tra[$join_id]['leave_arr'][] = $v;
                }else{
                    continue;
                }
            }
        }


        $max = 0;
        foreach ( $user_tra as $k => $v )
        {
            $come =  count( $v['come_arr']) ;
            $leave = count( $v['leave_arr']) ;
            $this_max = ($come > $leave)?$come:$leave;
            $max =  ($this_max> $max) ? $this_max : $max;
        }

        $empty_arr  = array(
            "t_code" => "",
            "t_level" => "",
            "t_money" => "",
        );

        foreach ( $user_tra as $k => $v)
        {
            $come_num = count($v['come_arr']);
            $leave_num = count($v['leave_arr']);
            //  补齐
            if( $come_num < $max)
            {
                for( $i = 0 ; $i< $max - $come_num ; $i ++ )
                {
                    $user_tra[$k]['come_arr'][] = $empty_arr;
                }
            }
            if( $leave_num < $max)
            {
                for( $i = 0 ; $i< $max - $leave_num ; $i ++ )
                {
                    $user_tra[$k]['leave_arr'][] = $empty_arr;
                }
            }

            // 判断意向
            if( ($v['is_come_ticket'] + $v['is_leave_ticket']) == (['leave_true'] + ['come_true']))
            {
                $user_tra[$k]['is_true'] = 1;
            }else{
                $user_tra[$k]['is_true'] = 0;
            }

            unset($user_tra[$k]['is_come_ticket']);
            unset($user_tra[$k]['is_leave_ticket']);
            unset($user_tra[$k]['leave_true']);
            unset($user_tra[$k]['come_true']);
        }

        $excel_title =  '姓名,信息状态,性别,手机号,身份证号,与意向是否相符,去程日期,出行方式,意向航班号／车次号,出发地,目的地,返程日期,出行方式,意向航班号／车次号,出发地,目的地,';
        $loop_title = '去程实际航班号／车次号,去程仓位级别／座位等级,去程机票／火车票价格（元）,返程实际航班号／车次号,返程仓位级别／座位等级,返程机票／火车票价格（元）,';
        $temp_title = '';

        for ( $i = 0; $i< $max ;$i ++)
        {
            $temp_title .= $loop_title ;
        }
        $temp_title = substr($temp_title,0,-1);
        $excel_title.= $temp_title;
        $excel_title = explode(',',$excel_title);

        $excel_info = array();
        foreach ($user_tra as $k=>$v)
        {
            $user_info = '';
            $loop_info = '';

            for( $i = 0 ; $i< $max ; $i ++ )
            {
                $loop_info .= implode(',',$v['come_arr'][$i]).','.implode(',',$v['leave_arr'][$i]).',';
            }

            $loop_info = substr($loop_info,0,-1);
            unset($v['join_id']);
            unset($v['come_arr']);
            unset($v['leave_arr']);

            $user_info = implode(',',$v);

            $excel_info[$k] = explode(',',$user_info.','.$loop_info);
            //dd($excel_info);
            if($excel_info[$k][1] == 1){
                $excel_info[$k][1] = '正常';
            }elseif($excel_info[$k][1] == 2){
                $excel_info[$k][1] = '变更';
            }else{
                $excel_info[$k][1] = '失效';
            }
            //改变显示
            $excel_info[$k][2] == 0 ? $excel_info[$k][2] = '女' : $excel_info[$k][2] = '男';
            $excel_info[$k][5] == 0 ? $excel_info[$k][5] = '否' : $excel_info[$k][5] = '是';
            $excel_info[$k][7] == 0 ? $excel_info[$k][7] = '火车' : $excel_info[$k][7] = '飞机';
            $excel_info[$k][12] == 0 ? $excel_info[$k][12] = '火车' : $excel_info[$k][12] = '飞机';
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '批量导出参会人出行信息成功',
                'node' => $this-> __url,
                'rfp_id' => $rfp_id,
                'type' => '3',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}批量导出参会人出行信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H:i:s',time());
        Excel::create($file_name, function($excel) use($excel_info,$excel_title){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($excel_info,$excel_title){ //创建表格
                $sheet->fromArray($excel_info,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->row(1,$excel_title); //改变表头
            });
        })->download('xlsx');


    }
}

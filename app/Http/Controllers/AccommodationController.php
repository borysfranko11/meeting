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
use Illuminate\Http\Request;
use App\Models\AccommodationInfo;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Excel;

class AccommodationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> __Join = new ConfirmUserInfo();
        $this -> __Join = new JoinUsers();
    }


    //  参会人住宿信息列表
    public function index(Request $request)
    {
        if( $request->isMethod('POST') )
        {
            $url = array();
            $url['rfp_id']   = $request->input('rfp_id');
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['status']   = $request->input('status');
        }
        if( $request->isMethod('GET') )
        {
            $rfp_id = $request->get('rfp_id');
            $rfp_id = (intval($rfp_id) == null || intval($rfp_id) < 0 ) ? abort('503') : intval($rfp_id) ;   // TODO : where I go ?
            $url['rfp_id']   = $rfp_id;
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['status']   = $request->get('status');
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

        if(empty($where_arr)){
            $users = DB::table('confirm_user_info')
                ->leftJoin('join_users','confirm_user_info.join_id','=','join_users.join_id')
                ->select(
                    'join_users.join_id',
                    'join_users.name',
                    'join_users.status',
                    'join_users.sex',
                    'join_users.phone',
                    'join_users.id_card', //身份证号
                    'confirm_user_info.room_type',
                    'confirm_user_info.hotel',
                    'confirm_user_info.check_in_time',
                    'confirm_user_info.check_out_time'
                )->where('confirm_user_info.is_hotel','!=',0)
                ->where('join_users.status','!=',0)
                ->where('join_users.rfp_id','=',$url['rfp_id'])
                ->paginate(20, ['*'], 'user');
        }else {
            $users = DB::table('confirm_user_info')
                ->leftJoin('join_users','confirm_user_info.join_id','=','join_users.join_id')
                ->select(
                    'join_users.join_id',
                    'join_users.name',
                    'join_users.status',
                    'join_users.sex',
                    'join_users.phone',
                    'join_users.id_card', //身份证号
                    'confirm_user_info.room_type',
                    'confirm_user_info.hotel',
                    'confirm_user_info.check_in_time',
                    'confirm_user_info.check_out_time')
                ->whereRaw($where_arr)
                ->where('confirm_user_info.is_hotel','!=',0)
                ->where('join_users.status','!=',0)
                ->where('join_users.rfp_id','=',$url['rfp_id'])
                ->paginate(20, ['*'], 'user');
        }

        //获取参会人id
        if(!empty($url['status']) || !empty(trim($url['name']) || !empty(trim($url['phone'])))){
            $user_ids = DB::table('accommodation_info')
                ->leftJoin('join_users', 'accommodation_info.join_id', '=', 'join_users.join_id')
                ->where('accommodation_info.status', '!=', 0)
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $url['rfp_id'])
                ->whereRaw($where_arr)
                ->lists('join_users.join_id');
        }else{
            $user_ids = DB::table('accommodation_info')
                ->leftJoin('join_users', 'accommodation_info.join_id', '=', 'join_users.join_id')
                ->where('accommodation_info.status', '!=', 0)
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $url['rfp_id'])
                ->lists('join_users.join_id');
        }
        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }


        //获取酒店名称

        $select_id = DB::table('rfp')->select('place_id')->where('rfp_id','=',$url['rfp_id'])->get();
        if(empty($select_id)){
            return '酒店信息不存在';
        }

        if($select_id[0]['place_id'] > 6000000){
            $urls = 'http://api.eventown.com/q/v2?id='.$select_id[0]['place_id'];
        }else{
            $urls = 'http://api.eventown.com/q?id='.$select_id[0]['place_id'];
        }

        $data = file_get_contents($urls);
        $information = json_decode($data,true);
        $hotole_name = isset($information['place_name'])?$information['place_name']:'';
        //日志信息
        $where  = array(
            'rfp_id' => $url['rfp_id'],
            'type' => 4,
        );
        $logs = $this->get_participant_log($where,'desc','create_time',10);
        $logs = $logs ? $logs  : array();

        $url_str = url('/Confirm/index').'/?';
        foreach ( $url as $v=>$k){
            $url_str .= $v.'='.$k.'&';
        }

        //return view('rfp/accommodation',['users'=>$users,'url'=>$url,'logs'=>$logs,'url_str'=>$url_str,'ids_str'=>$ids_str]);
        return view('rfp/accommodation',['users'=>$users,'url'=>$url,'logs'=>$logs,'url_str'=>$url_str,'hotole_name'=>$hotole_name,'select_id'=>$select_id,'ids_str'=>$ids_str]);

    }

    //住宿信息下载模板
    public function template(Request $request)
    {
        $rfp_id = $request->get('rfp_id'); //询单id
        if(!is_numeric($rfp_id)){
            abort('503');
        }
        $user = DB::table('join_users')
            ->join('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id' )
            ->select('join_users.join_id', //用户id
                'join_users.name', //用户姓名
                'join_users.sex', //性别
                'join_users.phone', //电话
                'join_users.id_card' //身份证号
            )->where('join_users.rfp_id',$rfp_id)
            ->where('join_users.status','!=',0)
            ->where('confirm_user_info.is_hotel',1)
            ->get();
        if(empty($user)){ //判断数据数量
            die ("暂无参会人员");
        }
        foreach($user as $key=>$v){
            $user[$key]['sex']==0?$user[$key]['sex']='女':$user[$key]['sex']='男'; //改变性别字段的显示
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '参会人住宿信息下载模板成功',
                'node' => $this-> __url,
                'rfp_id' => $request['rfp_id'],
                'type' => '4',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}参会人住宿信息下载模板,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H-i-s',time());
        Excel::create($file_name, function($excel) use($user){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($user){ //创建表格
                $sheet->fromArray($user,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->setWidth(array(
                    'A'=>12,'B'=>15,'C'=>15,'D'=>20,'E'=>20,'F'=>15,'G'=>35,'H'=>35,'I'=>20
                ));
                $sheet->row(1, array(  //改变表头
                    '用户id','姓名','性别','手机号码','身份证号／护照号','入住房型','入住日期（请设置单元格格式为：日期2001/3/7 0:00格式）','退房日期（请设置单元格格式为：日期2001/3/7 0:00格式）','房间号','单价'
                ));
            });
        })->download('xlsx');

    }

    //住宿信息数据导入
    public function import(Request $request)
    {

        if($request['rfp_id']<0 || !preg_match('/^\d$/',$request['rfp_id'])){
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
        if(empty($request['select_id'])){
            return ['num'=>'酒店信息不存在'];
        }
        if($request['select_id'] > 6000000){
            $urls = 'http://api.eventown.com/q/v2?id='.$request['select_id'];
        }else{
            $urls = 'http://api.eventown.com/q?id='.$request['select_id'];
        }

        $data = file_get_contents($urls);
        $information = json_decode($data,true);
        $hotole_name = $information['place_name']; //酒店名称
        $ation = array();   //导入的住宿信息
        $s_id = [];
        $id = DB::table('confirm_user_info')
            ->select('join_id')
            ->where('confirm_type','!=',0)
            ->where('is_hotel','=',1)
            ->get();
        foreach ($id as $k=>$v){
            array_push($s_id,$v['join_id']);
        }
        //  拼接数据
        foreach ( $res as $k => $v) {
            if ($k < 1) {
                continue;
            }
            $in_time = explode(' ',trim($v[6]))[0];
            $out_time = explode(' ',trim($v[7]))[0];
            $ation[$k] = array(
                'join_id'      => trim($v[0]),                          //用户id
                'a_name'       => $hotole_name,                         //酒店名称
                'a_type'       => trim($v[5]),                          //酒店房型
                'in_time'      => trim($v[6]),                          //入住时间
                'out_time'     => trim($v[7]),                          //退房时间
                'days'         => (strtotime($out_time) - strtotime($in_time))/86400+1, //天数
                'total_price'  => ((strtotime($out_time) - strtotime($in_time))/86400+1) * trim($v[9]),
                'room_num'     => trim($v[8]),                          //房间号
                'price'        => trim($v[9]),                          //单价
                'create_user'  => session::get("user.id"),              //执行添加人
                'create_time'  => date('Y-m-d H:i:s', time()),   //添加时间
            );
        }
        // 错误类型
        $t_join_id        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户id信息格式不正确,请重新下载模板确认id信息'); //用户id验证
        $t_join_idc        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户住宿信息已存在'); //用户id验证
        $t_join_ids        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户无确认信息，请重新下载模板确认用户id信息'); //用户id验证
        //$t_join_ids       =array( 0=>'第' ,   1=>array()  ,   2=>'行用户id信息不存在');
        $t_in_time     =array( 0=>'第' ,   1=>array()  ,   2=>'行入住时间格式不正确，符号必须是英文输入或将文件单元格设置为日期的 2001/3/7 0:00 格式'); //入住时间验证
        $t_in_times    =array( 0=>'第' ,   1=>array()  ,   2=>'行入住时间不存在');
        $t_out_time     =array( 0=>'第' ,   1=>array()  ,   2=>'行退房时间格式不正确，符号必须是英文输入或将文件单元格设置为日期的 2001/3/7 0:00 格式'); //退房时间验证
        $t_out_times    =array( 0=>'第' ,   1=>array()  ,   2=>'行退房时间不存在');
        $t_room_num     =array( 0=>'第' ,   1=>array()  ,   2=>'行房间号信息不存在');
        $t_price        =array( 0=>'第',    1=>array() ,    2=>'行单价格式不正确');
        $t_prices        =array( 0=>'第',    1=>array() ,    2=>'行单价格式不正确');
        $join_id = [];
        $idc = DB::table('accommodation_info')
            ->select('join_id')
            ->where('status','!=',0)
            ->get();
        foreach($idc as $k=>$v){
            array_push($join_id,$v['join_id']);
        }
        // 错误结果
        $error = array();
        // 验证数据
        foreach ($ation as $k=> $v)
        {
            //dd(!strtotime($v['in_time'])?$v['in_time']:$v['in_time']);
            if(!in_array($v['join_id'],$s_id)){
                $t_join_ids[1][] = $k;
            }
            //id
            if(!preg_match('/^[0-9]*$/',$v['join_id'])){ $t_join_id[1][]=$k; }
            if(in_array($v['join_id'],$join_id)){$t_join_idc[1][] = $k;}
            //日期正则验证
            if(empty($v['in_time'])){ $t_in_times[1][]=$k; }
            if(!strtotime($v['in_time'])){$t_in_time[1][]=$k;}
            $v['in_time'] = date('Y-m-d H:i:s ',strtotime($v['in_time']));
            if(empty($v['out_time'])){ $t_out_times[1][]=$k; }
            if(!strtotime($v['out_time'])){$t_out_time[1][]=$k;}
            $v['out_time'] = date('Y-m-d H:i:s ',strtotime($v['in_time']));
            if(empty($v['room_num'])){ $t_begin_city[1][]=$k; }
            if(empty($v['price'])){ $t_prices[1][] = $k; }
            if(!preg_match('/^[0-9]*$/',$v['price'])){$t_price[1][] = $k;}

        }

        // 错误集体处理
        if( !empty($t_join_idc[1])){ $error[] = $t_join_idc[0].implode(',',$t_join_idc[1]).$t_join_idc[2];}
        if( !empty($t_join_ids[1])){ $error[] = $t_join_ids[0].implode(',',$t_join_ids[1]).$t_join_ids[2];}
        //if( !empty($t_join_ids[1])){ $error[] = $t_join_ids[0].implode(',',$t_join_ids[1]).$t_join_ids[2];}
        if( !empty($t_join_id[1])){ $error[] = $t_join_id[0].implode(',',$t_join_id[1]).$t_join_id[2];}
        if( !empty($t_in_time[1])){ $error[] = $t_in_time[0].implode(',',$t_in_time[1]).$t_in_time[2];}
        if( !empty($t_in_times[1])){ $error[] = $t_in_times[0].implode(',',$t_in_times[1]).$t_in_times[2];}
        if( !empty($t_out_time[1])){ $error[] = $t_out_time[0].implode(',',$t_out_time[1]).$t_out_time[2];}
        if( !empty($t_out_times[1])){ $error[] = $t_out_times[0].implode(',',$t_out_times[1]).$t_out_times[2];}
        if( !empty($t_room_num[1])){ $error[] = $t_room_num[0].implode(',',$t_room_num[1]).$t_room_num[2];}
        if( !empty($t_price[1])){ $error[] = $t_price[0].implode(',',$t_price[1]).$t_price[2]; }
        if( !empty($t_prices[1])){ $error[] = $t_prices[0].implode(',',$t_prices[1]).$t_prices[2]; }

        if(empty($error)){
            DB::beginTransaction();
            try {
                DB::table('accommodation_info')->insert($ation);
                DB::commit();
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '批量导入参会人住宿信息成功',
                    'node' => $this-> __url,
                    'rfp_id' => $request['rfp_id'],
                    'type' => '4',
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
                $message = "{session('user')['id']}批量导入参会人住宿信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                return $e;
            }
        }else{
            return $error;   // todo  json 方法导出
        }
    }
    //住宿信息数据导出
    public function export(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if(!preg_match('/^[0-9]*$/',$rfp_id)){
            abort('503');
        }

        $str = $request->input('join_id'); //主键id
        $join_id = explode(',',$str);

            $user = DB::table('accommodation_info')
                ->leftJoin('join_users','accommodation_info.join_id','=','join_users.join_id')
                ->join('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id' )
                ->select(
                    'join_users.name',
                    'accommodation_info.status',
                    'join_users.sex',
                    'join_users.phone',
                    'join_users.id_card', //身份证号
                    'accommodation_info.a_name', //酒店名称
                    'accommodation_info.a_type', //房型
                    'accommodation_info.in_time', //入住时间
                    'accommodation_info.out_time', //退房时间
                    'accommodation_info.days', //天数
                    'accommodation_info.room_num' //房间号
                )->where('accommodation_info.status','!=',0)
                ->where('join_users.status','!=',0)
                ->where('join_users.rfp_id','=',$rfp_id)
                ->whereIn('join_users.join_id',$join_id)
                ->where('confirm_user_info.is_hotel',1)
                ->get();
        if(empty($user)){ //判断数据数量
            die ("暂无参会人员住宿信息");
        }
        foreach($user as $key=>$v){

            $user[$key]['sex']==0?$user[$key]['sex']='女':$user[$key]['sex']='男'; //改变性别字段的显示

            $user[$key]['status']==1?$user[$key]['status']='正常':$user[$key]['status']='变更';
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '批量导出参会人用车信息成功',
                'node' => $this-> __url,
                'rfp_id' =>$rfp_id,
                'type' => '4',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}批量导出参会人用车信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H-i-s',time());
        Excel::create($file_name, function($excel) use($user){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($user){ //创建表格
                $sheet->fromArray($user,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->setWidth(array(
                    'A'=> 12,'B'=>15,'C'=>15,'D'=>25,'E'=>20,'F'=>15,'G'=>20,'H'=>20,'I'=>20,'J'=>20,'K'=>20
                ));
                $sheet->row(1, array(  //改变表头
                    '姓名','信息状态','性别','手机号','身份证号','酒店名称','入住房型','入住日期','退房日期','天数','房间号'
                ));
            });
        })->download('xlsx');

    }
}
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
use App\Models\UseCarInfo;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Excel;

class UserCarController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> __Join = new ConfirmUserInfo();
        $this -> __Join = new JoinUsers();
    }

    //用车信息列表
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
        if (empty($where_arr)) {
            $users = DB::table('join_users')
                ->join('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.name', 'join_users.status', 'join_users.sex', 'join_users.phone', 'join_users.id_card',
                    'confirm_user_info.join_id', //参会人id
                    'confirm_user_info.come_begin_city', //去程出发城市
                    'confirm_user_info.come_end_city', //去程目的城市
                    'confirm_user_info.leave_begin_city', //返程出发城市
                    'confirm_user_info.leave_end_city', //返程目的城市
                    'confirm_user_info.confirm_type' //信息确认状态  与意向是否相符
                )
                ->where('join_users.rfp_id',$url['rfp_id'])
                ->where('join_users.status','!=',0)
                ->whereRaw('(confirm_user_info.is_connet = ? or confirm_user_info.is_send = ?)',[1,1])
                ->paginate(20, ['*'], 'user');
        }else {
            $users = DB::table('join_users')
                ->join('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.name', 'join_users.status', 'join_users.sex', 'join_users.phone', 'join_users.id_card',
                    'confirm_user_info.join_id', //参会人id
                    'confirm_user_info.come_begin_city', //去程出发城市
                    'confirm_user_info.come_end_city', //去程目的城市
                    'confirm_user_info.leave_begin_city', //返程出发城市
                    'confirm_user_info.leave_end_city', //返程目的城市
                    'confirm_user_info.confirm_type' //信息确认状态  与意向是否相符
                )
                ->whereRaw($where_arr)
                ->where('join_users.rfp_id',$url['rfp_id'])
                ->where('join_users.status','!=',0)
                ->whereRaw('(confirm_user_info.is_connet = ? or confirm_user_info.is_send = ?)',[1,1])
                ->paginate(20, ['*'], 'user');
        }

        //获取参会人id
        if(!empty($url['status']) || !empty(trim($url['name'])) || !empty(trim($url['phone']))) {
            $user_ids = DB::table('join_users')
                ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
                ->where('join_users.rfp_id', $url['rfp_id'])
                ->where('join_users.status', '!=', 0)
                ->whereRaw($where_arr)
                ->whereRaw('(confirm_user_info.is_connet = ? or confirm_user_info.is_send = ?)', [1, 1])
                ->distinct()
                ->lists('join_users.join_id');
        }else{
            $user_ids = DB::table('join_users')
                ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
                ->where('join_users.rfp_id', $url['rfp_id'])
                ->where('join_users.status', '!=', 0)
                ->whereRaw('(confirm_user_info.is_connet = ? or confirm_user_info.is_send = ?)', [1, 1])
                ->distinct()
                ->lists('join_users.join_id');
        }
        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }

        //日志列表
        $where  = array(
            'rfp_id' => $url['rfp_id'],
            'type' => 5,
        );
        $logs = $this->get_participant_log($where,'desc','create_time',10);
        $logs = $logs ? $logs  : array();

        $url_str = url('/Confirm/index').'/?';
        foreach ( $url as $v=>$k){
            $url_str .= $v.'='.$k.'&';
        }
        return view('rfp/user_car',['users'=>$users,'url'=>$url,'logs'=>$logs,'url_str'=>$url_str,'ids_str'=>$ids_str]);
    }

    //用车信息下载模板
    public function template(Request $request)
    {
        $rfp_id = $request->get('rfp_id'); //询单id
        //dd($rfp_id);
        if(!preg_match('/^[0-9]*$/',$rfp_id)){
            abort('503');
        }

        $user = DB::table('join_users') //需要接机的参会人
            ->join('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id' )
            ->select('join_users.join_id', //用户id
                'join_users.name',//姓名
                'join_users.sex',//性别
                'join_users.phone',//手机号
                'join_users.id_card' //身份证号
            )
            ->where('join_users.rfp_id','=',$rfp_id)
            ->where('join_users.status','!=',0)
            ->whereRaw('(confirm_user_info.is_connet = ? or confirm_user_info.is_send = ?)',[1,1])
            ->get();

        if(empty($user)){ //判断数据数量
            die ("暂无参会人员用车信息");
        }

        foreach($user as $key=>$v){

            $user[$key]['sex']==0?$user[$key]['sex']='女':$user[$key]['sex']='男'; //改变性别字段的显示
            $user[$key]['0'] = '接机';
            $user[$key]['1'] = '';
            $user[$key]['2'] = '';
            $user[$key]['3'] = '';
            $user[$key]['4'] = '';
            $user[$key]['5'] = '';
            $user[$key]['6'] = '送机';
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '用车信息模板下载成功',
                'node' => $this-> __url,
                'rfp_id' => $rfp_id,
                'type' => '5',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}用车信息模板下载,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H-i-s',time());
        Excel::create($file_name, function($excel) use($user){ //创建文件并将数据传入

            $excel->sheet('sheet', function($sheet) use($user){ //创建表格
                $sheet->setWidth(array( //设置列宽
                    'A'=>12,'B'=>15,'C'=>15,'D'=>20,'E'=>20,'F'=>10,'G'=>10,'H'=>10,'I'=>10,'J'=>10,'K'=>10,'L'=>10,'M'=>10,'N'=>10,'O'=>10
                ));
                $sheet->fromArray($user,null,'',true,false);//将数据写入文件并使 0 能正常显示 第五个参数可去除键输出
                $sheet->prependRow(1, array(  //前置第三行并改变表头
                    '用户id','姓名','性别','手机号','身份证号／护照号','行程','去程出发城市','去程出发时间（请设置单元格格式为：日期2001/3/7 0:00格式）','去程出发地','去程目的地','去程价格','行程','返程出发城市','返程出发时间（请设置单元格格式为：日期2001/3/7 0:00格式）','返程出发地','返程目的地','返程价格'
                ));

            });
        })->download('xlsx');

    }

    //用车信息数据导入
    public function import(Request $request)
    {
        if($request['rfp_id']<0 || !preg_match('/^\d$/',$request['rfp_id'])){
            abort( 503 );
        }
        if(!$request->hasFile('file')){
            return ['num'=>'1'];//文件为空
        }
        $file = $_FILES;  //文件属性 name  type  tmp_name  error  size
        //dd($file);
        //application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
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

        $trip = array();   //导入的去程信息
        $return_trip = array(); //导入的回程信息
        //  拼接数据
        foreach ( $res as $k => $v) {
            if ($k < 1) {
                continue;
            }
            $trip[$k] = array(
                'join_id'      => trim($v[0]),                          //用户id
                'begin_city'   => trim($v[6]),                          //出发城市
                'begin_time'   => trim($v[7]),                          //出发时间
                'begion_address'=> trim($v[8]),                         //出发地
                'end_address'  => trim($v[9]),                          //目的地
                'price'        => trim($v[10]),                          //价格
                'uci_way'      => 1,
                'create_user'  => session::get("user.id"),              //执行添加人
                'create_time'  => date('Y-m-d H:i:s', time()),   //添加时间
            );
            $return_trip[$k] = array(
                'join_id'      => trim($v[0]),                          //用户id
                'begin_city'   => trim($v[12]),
                'begin_time'   => trim($v[13]),
                'begion_address'=> trim($v[14]),
                'end_address'  => trim($v[15]),
                'price'        => trim($v[16]),
                'uci_way'      => 2,
                'create_user'  => session::get("user.id"),              //执行添加人
                'create_time'  => date('Y-m-d H:i:s', time()),   //添加时间
            );
        }
        // 错误类型
        $t_begin_time     =array( 0=>'第' ,  1=>array()  ,   2=>'行去程出发时间格式不正确，符号必须是英文输入或将文件单元格设置为日期的 2001/3/7 0:00 格式');
        $t_join_id        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户无确认信息，请重新下载模板确认用户id信息');

        $r_join_id        =array( 0=>'第' ,   1=>array()  ,   2=>'行用户id信息格式不正确,请重新下载模板确认id信息'); //用户id验证
        $r_begin_time     =array( 0=>'第' ,  1=>array()  ,   2=>'行返程出发时间格式不正确，符号必须是英文输入或将文件单元格设置为日期的 2001/3/7 0:00 格式');
        $s_id = [];
        $id = DB::table('confirm_user_info')
            ->select('join_id')
            ->where('confirm_type','!=',0)
            ->whereRaw('is_send = ? or is_hotel = ?',[1,1])
            ->get();
        foreach($id as $k=>$v){
            array_push($s_id,$v['join_id']);
        }
        // 错误结果
        $error = array();
        // 验证数据
        foreach ($trip as $k=> $v)
        {
            if(!in_array($v['join_id'],$s_id)){ $t_join_id[1][] = $k; }
            if(!empty($v['begin_time'])) {
                if(!strtotime($v['begin_time'])){$t_begin_time[1][] = $k;}
            }
            $trip[$k]['begin_time'] = trim(date('Y-m-d H:i:s ',strtotime($v['begin_time'])));

        }
        foreach ($return_trip as $k=> $v)
        {
            if(!preg_match('/^[0-9]*$/',$v['join_id'])){ $r_join_id[1][]=$k; }
            if($v['join_id'] == 0){$r_join_id[1][]=$k;}
            if(!empty($v['begin_time'])) {
                if(!strtotime($v['begin_time'])){$r_begin_time[1][] = $k;}
            }
            $return_trip[$k]['begin_time'] = trim(date('Y-m-d H:i:s ',strtotime($v['begin_time'])));
        }

        // 错误集体处理
        if( !empty($t_begin_time[1])){ $error[] = $t_begin_time[0].implode(',',$t_begin_time[1]).$t_begin_time[2];}
        if( !empty($r_join_ids[1])){ $error[] = $r_join_ids[0].implode(',',$r_join_ids[1]).$r_join_ids[2];}

        if( !empty($r_join_id[1])){ $error[] = $r_join_id[0].implode(',',$r_join_id[1]).$r_join_id[2];}
        if( !empty($r_begin_time[1])){ $error[] = $r_begin_time[0].implode(',',$r_begin_time[1]).$r_begin_time[2];}

        if(empty($error)){
            DB::beginTransaction();
            try {
                DB::table('use_car_info')->insert($trip);
                DB::table('use_car_info')->insert($return_trip);
                DB::commit();
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '批量导入参会人用车信息成功',
                    'node' => $this-> __url,
                    'rfp_id' => $request['rfp_id'],
                    'type' => '5',
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
                $message = "{session('user')['id']}批量导入参会人用车信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                return $e;
            }
        }else{
            return $error;   // todo  json 方法导出
        }
    }

    //用车信息数据导出
    public function export(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if (!preg_match('/^[0-9]*$/', $rfp_id)) {
            abort('503');
        }

        $str = $request->input('join_id'); //主键id
        $join_id = explode(',', $str);

            $user = DB::table('join_users')
                ->leftJoin('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.join_id', //参会人id
                    'join_users.name', //姓名
                    'join_users.sex', //性别
                    'join_users.phone', //电话
                    'join_users.id_card', //身份证
                    'join_users.status', //状态
                    'confirm_user_info.come_begin_city', //去程出发城市
                    'confirm_user_info.come_end_city',  //去程目的城市
                    'confirm_user_info.leave_begin_city', //返程出发城市
                    'confirm_user_info.leave_end_city' //返程目的城市
                )
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $rfp_id)
                ->whereIn('join_users.join_id',$join_id)
                ->whereRaw('( confirm_user_info.is_connet = ? or confirm_user_info.is_send = ? )', [1, 1])
                ->get();

        $travel = DB::table('join_users')
            ->leftJoin('use_car_info', 'join_users.join_id', '=', 'use_car_info.join_id')
            ->select('use_car_info.join_id',//参会人id
                'use_car_info.uci_way',  //用车类型
                'use_car_info.begin_city', //出发城市
                'use_car_info.begin_time', //出发时间
                'use_car_info.begion_address', //出发地
                'use_car_info.end_address', //目的地
                'use_car_info.price' //价格
            )
            ->where('join_users.rfp_id', '=', $rfp_id)
            ->where('join_users.status', '!=', 0)
            ->where('use_car_info.status', '!=', 0)
            ->where('use_car_info.uci_way', '!=', 0)
            ->get();

        $user_tra = array();
        foreach ($user as $key => $value) {
            $user_tra[$value['join_id']] = array(
                'join_id'=> $value['join_id'],
                'name'=> $value['name'],                   //姓名
                'status' => $value['status'],              //信息状态
                'sex' => $value['sex'],                    //性别
                'phone' => $value['phone'],                //电话
                'id_card' => $value['id_card'],            //身份证号
                'come_begin_city'=>$value['come_begin_city'], //去程出发城市
                'come_end_city'=>$value['come_end_city'],  //去程目的城市
                'leave_begin_city'=>$value['leave_begin_city'],  //返程出发城市
                'leave_end_city'=>$value['leave_end_city'],  //返程目的城市
                'come_arr' => array(),                     //去程用车信息
                'leave_arr' => array(),                    //返程用车信息
            );
            foreach($travel as $k=>$v){
                $join_id = $v['join_id'];
                if($value['join_id'] == $join_id){
                    if($v['uci_way'] ==1) {
                        unset($v['join_id']);
                        unset($v['uci_way']);
                        $user_tra[$value['join_id']]['come_arr'][] = $v;
                    }elseif($v['uci_way'] ==2){
                        unset($v['join_id']);
                        unset($v['uci_way']);
                        $user_tra[$value['join_id']]['leave_arr'][] = $v;
                    }else{
                        continue;
                    }
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
            "begin_city" => "",
            "begin_time" => "",
            "begion_address" => "",
            "end_address" => "",
            "price" => "",
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
            unset($user_tra[$k]['join_id']);
        }

        $excel_title =  '姓名,信息状态,性别,手机号,身份证号,去程意向出发城市,去程意向目的城市,返程意向出发城市,返程意向目的城市,';
        $loop_title = '去程出发城市,去程出发时间,去程出发地,去程目的地,去程价格,返程出发城市,返程出发时间,返程出发地,返程目的地,返程价格,';
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
            $loop_info = '';
            for( $i = 0 ; $i< $max ; $i ++ )
            {
                $loop_info .= implode(',',$v['come_arr'][$i]).','.implode(',',$v['leave_arr'][$i]).',';
            }

            $loop_info = substr($loop_info,0,-1);
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
            //$excel_info[$k][5] == 0 ? $excel_info[$k][5] = '否' : $excel_info[$k][5] = '是';
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '批量导出参会人用车信息成功',
                'node' => $this-> __url,
                'rfp_id' => $rfp_id,
                'type' => '5',
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
        Excel::create($file_name, function($excel) use($excel_info,$excel_title){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($excel_info,$excel_title){ //创建表格
                $sheet->fromArray($excel_info,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->row(1,$excel_title); //改变表头
            });
        })->download('xlsx');
    }
}
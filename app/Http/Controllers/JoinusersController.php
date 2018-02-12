<?php
namespace App\Http\Controllers;
use App\Models\OftenLink;
use App\Models\OftenUsers;
use App\Models\ParticipantLog;
use App\Models\Rfp;
use App\Models\JoinUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Excel;
use Illuminate\Http\RedirectResponse;
use Overtrue\Pinyin\Pinyin;
use \Maatwebsite\Excel\Files\NewExcelFile;


class JoinusersController extends Controller
{
    private $_pinyin;   //  拼音类
    private $__Join;
    private $__PLogs;
    private $__Rfp;
    private $__Often;

    public function __construct()
    {
        parent::__construct();
        $this -> __Join = new JoinUsers();
        $this -> __PLogs  = new ParticipantLog();
        $this -> __Rfp = new Rfp();
        $this ->__Often = new OftenUsers();
        $this -> _pinyin = new Pinyin();
    }

    /**
     * 列表页
     * @author Wind
     * @time   2017-8-28
     */
    public function index(Request $request)
    {

        if( $request->isMethod('POST') )
        {
            $url = array();
            $url['rfp_id']   = $request->input('rfp_id');
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['status']   = $request->input('status');
            $url['sign']     = $request->input('sign');
            $url['confirm']  = $request->input('confirm');
            $url['is_send_invitation'] = $request->input('is_send_invitation');
            $url['page'] = 0 ;
        }
        if( $request->isMethod('GET') )
        {
            $rfp_id = $request->get('rfp_id');
            $rfp_id = (intval($rfp_id) == null || intval($rfp_id) < 0 ) ? abort('503') : intval($rfp_id) ;
            $url['rfp_id']   = $rfp_id;
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['status']   = $request->get('status');
            $url['sign']     = $request->get('sign');
            $url['confirm']  = $request->get('confirm');
            $url['is_send_invitation'] = $request->get('is_send_invitation');
            $url['page'] = $request->get('page');
        }
        $url['page'] = $url['page'] == null ? 0 : intval( $url['page']);
        // 询单id
        $where_str = 'join_users.rfp_id = ? ';
        $where_arr[] = $url['rfp_id'];

        // 状态
        $where_str .= 'and status ';
        if( empty($url['status']) )
        {
            $where_str .= ' != ?';
            $where_arr[] = 0;
        }else{
            $where_str .= ' = ?';
            $where_arr[] = $url['status'];
        }

        // 姓名
        if( trim($url['name']))
        {
            $where_str .= " and name like '%$url[name]%' ";
        }

        // 电话号
        if( trim($url['phone']))
        {
            $where_str .= " and phone = '$url[phone]' ";
        }

        // 签到
        if( empty($url['sign'])){
            $where_str .= '';
        }elseif($url['sign'] == 1){
            $where_str .= ' and sign_in_type is not null ';
        }elseif($url['sign'] == 2) {
            $where_str .= ' and sign_in_type is null ';
        }

        // 确认
        if( empty($url['confirm']))
        {
            $where_str  .= '';
        }elseif($url['confirm'] == 1){
            $where_str .= ' and confirm_type is not null ';
        }elseif($url['confirm'] == 2){
            $where_str .= ' and confirm_type is null ';
        }

        $page = $url['page'];
        $num  = 20;
       // $page = ($page - 1 < 0) ? 0 :$page - 1;
        $begin = $page * $num ;
//        dd($url);
        if( $url['is_send_invitation'] )
        {
            // 参会人列表
            $users_list = DB::table('join_users')
                ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
                ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
                ->leftJoin('invitation_send', 'invitation_send.join_id', '=', 'join_users.join_id')
                ->select('join_users.join_id as join_id', 'join_users.rfp_id','name','join_users.status','join_users.sex','phone',
                    'city','company','duty','id_card','email','join_users.room_type','sign_in_type','confirm_type','invitation_send.join_id as send_id')
                ->whereRaw($where_str,$where_arr)
                ->groupBy('join_users.join_id')
                ->orderBy('join_users.join_id','asc')
                ->skip($begin)
                ->take($num)
                ->get();
        }else{
            // 参会人列表
            $users_list = DB::table('join_users')
                ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
                ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
                ->leftJoin('invitation_send', 'invitation_send.join_id', '=', 'join_users.join_id')
                ->select('join_users.join_id as join_id', 'join_users.rfp_id','name','join_users.status','join_users.sex','phone',
                    'city','company','duty','id_card','email','join_users.room_type','sign_in_type','confirm_type','invitation_send.join_id as send_id')
                ->whereRaw($where_str,$where_arr)
                ->groupBy('join_users.join_id')
                ->orderBy('join_users.join_id','asc')
                ->skip($begin)
                ->take($num)
                ->get();
        }
        //dd($users_list);
        $all_data = DB::table('join_users')
            ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
            ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
            ->leftJoin('invitation_send', 'invitation_send.join_id', '=', 'join_users.join_id')
            ->select('join_users.join_id as join_id', 'join_users.rfp_id','name','join_users.status','join_users.sex','phone',
                'city','company','duty','id_card','email','join_users.room_type','sign_in_type','confirm_type','invitation_send.join_id as send_id')
            ->whereRaw($where_str,$where_arr)
            ->groupBy('join_users.join_id')
            ->get();
        $all_data = count($all_data);
        $pagers = ceil($all_data / $num);
        $rfp_status = DB::table('rfp')
            ->select('status')
            ->where('rfp_id','=',$url['rfp_id'])
            ->get();

        //获取所有的参会人id
        $user_ids = DB::table('join_users')
            ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
            ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
            ->leftJoin('invitation_send', 'invitation_send.join_id', '=', 'join_users.join_id')
            ->whereRaw($where_str,$where_arr)
            ->distinct()
            ->lists('join_users.join_id');
        $ids_str = '';
        if( count($user_ids) > 0 )
        {
            $ids_str = implode(',',$user_ids);
        }
        // 会议状态
        $Rpf = new Rfp();
        $rfp_type = $Rpf -> where('rfp_id',$url['rfp_id'])->pluck('status');   // 9 草稿 10 待审核  11 审核失败  12 审核未通过 20 审核成功

        //  log 列表
        $where  = array(
            'rfp_id' => $url['rfp_id'],
            'type' => 1,
        );
        $logs = $this->get_participant_log($where,'desc','create_time',10);
        $logs = $logs ? $logs  : array();

        $url_str = url('/join/index').'/?';
        foreach ( $url as $v=>$k){
            $url_str .= $v.'='.$k.'&';
        }

        return view('join/list',['logs'=>$logs,'user_list'=>$users_list,'rfp_type'=>$rfp_type,'url' => $url,'ids_str' => $ids_str ,'url_str'=>$url_str,'rfp_status'=>$rfp_status,'pagers'=>$pagers]);
    }


    /**
     * 李晓康
     * 2017-8-29
     * 文件模板下载
     */
    public function template()
    {
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=gbk');
        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '参会人信息下载模板成功',
                'node' => $this-> __url,
                'rfp_id' => $_GET['rfp_id'],
                'type' => '1',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );

            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}参会人信息下载模板,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }

        //$filename = iconv('UTF-8', 'gb2312', '批量导入参会人信息表格');
        //$filename = getFilename('批量导入参会人信息表格');

       /* $Rpf = new Rfp();
        $aaa = $Rpf->select("meeting_name") -> where('rfp_id',16)->get()->toArray();
        $filename = $aaa[0]['meeting_name'];*/

        //$filename = iconv('UTF-8', 'gb2312', $filename);
        //$filename = urlencode($filename);
        //$encoded_filename = str_replace("+", "%20", $filename);
        $file_name = date('Y-m-d H:i:s',time());
        Excel::create($file_name, function($excel){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet){ //创建表格
                $sheet->setWidth(array(
                    'A'=>12,'B'=>7,'C'=>15,'D'=>25,'E'=>15,'F'=>15,'G'=>20,'H'=>20,'I'=>20,
                ));
                $sheet->row(1, array(  //改变表头
                    '姓名', '性别','所在城市','单位名称','职称／职位','手机号码','身份证号／护照号','邮箱','意向房型'
                ));
            });
        })->download('xlsx');


    }

    /**
     *
     * 李晓康
     * 2017-8-29
     * 导入excel
     */
    public function import(Request $request)
    {
        if($request['rfp_id']<0 || !preg_match('/^[0-9]*$/',$request['rfp_id'])){
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
//dd($res);
        if(empty($res[1][0]) && empty($res[1][1]) && empty($res[1][2]) && empty($res[1][3]) && empty($res[1][4]) && empty($res[1][5]) && empty($res[1][6]) && empty($res[1][7]) && empty($res[1][8])){
            return ['num'=>'9','msg'=>'文件内没有任何信息'];
        }

        if(count($res) > 60001){
            return ['num'=>'3' ];
        }
        $data = [];

        if( count($res) <= 1 )
        {
            return fasle;  //
        }

        $line = 0 ;  // 行号
        $insert_batch_data = array();   // 导入的数据
        $rfp_phones = $this -> __Join->whereRaw('rfp_id = ? and status != ?',[$request['rfp_id'],0])->lists('phone')->toArray();          // 询单已存在的参会人手机号
        $ins_phones = '';          // 将导入的参会人手机号
        $rfp_id_cards = $this-> __Join->whereRaw('rfp_id = ? and status != ? ',[$request['rfp_id'],0] )->lists('id_card')->toArray();         // 询单已存在的参会人证件号
        $ins_id_cards = '';        // 将导入的参会人证件号

        //  拼接数据
        foreach ( $res as $k => $v) {
            if ($k < 1) {
                continue;
            }
            $insert_batch_data[$k] = array(
                /*'name'      => trim($v[0]),
                'sex'       => trim($v[1]),
                'city'      => trim($v[2]),
                'company'   => trim($v[3]),
                'duty'      => trim($v[4]),
                'phone'     => trim($v[5]),
                'id_card'   => trim($v[6]),
                'email'     => trim($v[7]),
                'room_type' => trim($v[8]),
                'rfp_id'    => $request['rfp_id'],
                'create_user' => session::get("user.id"),
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s'),
                'update_user' => session::get("user.id"),*/
                'name'      => trim($v[0]),
                'sex'       => trim($v[1]),
                //'city'      => trim($v[2]),
                'company'   => trim($v[2]),
                'duty'      => trim($v[3]),
                'phone'     => trim($v[4]),
                //'id_card'   => trim($v[6]),
               // 'email'     => trim($v[7]),
                //'room_type' => trim($v[8]),
                'rfp_id'    => $request['rfp_id'],
                'create_user' => session::get("user.id"),
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s'),
                'update_user' => session::get("user.id"),
            );
            $ins_phones  .= ','.trim($v[4]);
            //$ins_id_cards  .= ','.trim($v[6]);
        }
//dd($ins_phones,$ins_id_cards);
        // 错误类型

        $e_name    =array( 0=>"第" ,   1=>array()  ,   2=>'行姓名信息未填写');
        $e_sex     =array( 0=>'第' ,   1=>array()  ,   2=>'行性别信息未填写');
        $f_sex     =array( 0=>'第' ,   1=>array()  ,   2=>'行性别信息填写不正确，只能输入【男/女】');
        //$e_city    =array( 0=>'第' ,   1=>array()  ,   2=>'行城市信息未填写');
        $e_company =array( 0=>'第' ,   1=>array()  ,   2=>'行单位名称信息未填写');
        $e_duty    =array( 0=>'第' ,   1=>array()  ,   2=>'行职称/职位信息未填写');
        $e_phone   =array( 0=>'第' ,   1=>array()  ,   2=>'行手机号码信息未填写');
        $in_execl_phone    =array( 0=>'第' ,   1=>array()  ,   2=>'行手机号码相同');
        $in_db_phone       =array( 0=>'第' ,   1=>array()  ,   2=>'行手机号码已存在于该会议中，无法导入');
       // $e_id_card         =array( 0=>'第' ,   1=>array()  ,   2=>'行身份证号/护照信息未填写');
        //$in_excel_id_card    =array( 0=>'第' ,  1=>array()  ,   2=>'行身份证号/护照信息相同，无法导入');
        //$in_db_id_card       =array( 0=>'第' ,  1=>array()  ,   2=>'行身份证号/护照信息已存在于该会议中');
        //$f_email           =array( 0=>'第' ,  1=>array()  ,    2=>'行邮箱格式错误');

        // 错误结果
        $error = array();
        // 验证数据
        foreach ($insert_batch_data as $k=> $v)
        {
            // 姓名
            if( empty($v['name']))
            {
                $e_name[1][] = $k;
            }else{
                $spelling =  $this->_pinyin ->convert($v['name']);
                //dd($spelling);
                $insert_batch_data[$k]['spelling'] =   implode(' ',$spelling);

            }
            // 城市
            if( empty($v['city'])){ $e_city[1][] = $k; }
            //  公司
            if( empty($v['company'])){ $e_company[1][] = $k; }
            // 职位
            if( empty($v['duty'])){ $e_duty[1][] = $k; }
            //  邮箱
            if(!empty($v['email'])) {
                if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $v['email'])) {
                    $f_email[1][] = $k;
                }
            }
//            //  性别
            //dd($v['sex']);
            if( empty($v['sex']))
            {
                $e_sex[1][] = $k;
            }elseif($v['sex']!="男" && $v['sex']!="女"){
                $f_sex[1][] = $k;
            }else{
                $insert_batch_data[$k]['sex'] = ($v['sex'] == '男') ? 1 : 0 ;
            }

            //  手机号 验证
            if( empty($v['phone']))
            {
                $e_phone[1][] = $k;
            }else{
                if( strlen($ins_phones) > 0  ){
                    if(substr_count($ins_phones,$v['phone']) > 1 )
                    {
                        $in_execl_phone[1][] = $k;
                    }
                }
            }


            if( count($rfp_phones) > 0){
                if(in_array($v['phone'],$rfp_phones))
                {
                    $in_db_phone[1][] = $k;
                }
            }

            // 证件号 验证
            if( empty($v['id_card']))
            {
                $e_id_card[1][] = $k;
            }else{
                if( strlen($ins_id_cards) > 0  ){
                    if(substr_count($ins_id_cards,$v['id_card']) > 1 )
                    {
                        $in_excel_id_card[1][] = $k;
                    }
                }
            }

            if( count($rfp_id_cards) > 0){
                if(in_array($v['id_card'],$rfp_id_cards)  )
                {
                    $in_db_id_card[1][] = $k;
                }
            }
        }


        // 错误集体处理
        if( !empty($e_name[1])){ $error[] = $e_name[0].implode(',',$e_name[1]).$e_name[2];}
        if( !empty($e_sex[1])){ $error[] = $e_sex[0].implode(',',$e_sex[1]).$e_sex[2];}
        if( !empty($f_sex[1])){ $error[] = $f_sex[0].implode(',',$f_sex[1]).$f_sex[2];}
        //if( !empty($e_city[1])){ $error[] = $e_city[0].implode(',',$e_city[1]).$e_city[2];}
        if( !empty($e_company[1])){ $error[] = $e_company[0].implode(',',$e_company[1]).$e_company[2];}
        if( !empty($e_duty[1])){ $error[] = $e_duty[0].implode(',',$e_duty[1]).$e_duty[2];}
        if( !empty($e_phone[1])){ $error[] = $e_phone[0].implode(',',$e_phone[1]).$e_phone[2];}
        /*if( !empty($in_execl_phone[1])){ $error[] = $in_execl_phone[0].implode(',',$in_execl_phone[1]).$in_execl_phone[2];}
        if( !empty($in_db_phone[1])){ $error[] = $in_db_phone[0].implode(',',$in_db_phone[1]).$in_db_phone[2];}
        if( !empty($e_id_card[1])){ $error[] = $e_id_card[0].implode(',',$e_id_card[1]).$e_id_card[2];}
        if( !empty($in_excel_id_card[1])){ $error[] = $in_excel_id_card[0].implode(',',$in_excel_id_card[1]).$in_excel_id_card[2];}
        if( !empty($in_db_id_card[1])){ $error[] = $in_db_id_card[0].implode(',',$in_db_id_card[1]).$in_db_id_card[2];}
        if( !empty($f_email[1]))      { $error[] = $f_email[0].implode(',',$f_email[1]).$f_email[2];}*/

        if(empty($error)){
            DB::beginTransaction();
            try {
                DB::table('join_users')->insert($insert_batch_data);
                DB::commit();
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '批量导入参会人成功',
                    'node' => $this-> __url,
                    'rfp_id' => $request['rfp_id'],
                    'type' => '1',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s')
                );
                // 写入日志

                DB::table('participant_log') -> insert( $param );
                DB::commit();
                $count = count($res)-1;
                return ['msg'=>'数据导入成功'.$count.'条数据','num'=>'5'];
            }catch ( \Exception $e){
                DB::rollback();
                //写入文本日志
                $message = "{session('user')['id']}批量导入参会人,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                return $e;
            }
        }else{
            //dd($error);
            return $error;   // todo  json 方法导出
        }
    }

    /**
     * 2017-8-30
     * 导出参会人
     * 李晓康
     */
    public function export(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if(!preg_match('/^[0-9]*$/',$rfp_id)){
            abort('503');
        }

        $str = $request->input('join_id'); //主键id
        $join_id = explode(',',$str);

//        if(empty($join_id)) {
//            $user = DB::table('join_users')
//                ->leftJoin('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id')
//                ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
//                ->select('join_users.rfp_id','name','status','sex','city','company','duty','phone','id_card','email','join_users.room_type','confirm_type','sign_in.join_id')
//                ->where('rfp_id', '=', $rfp_id)
//                ->get();
//        }else{
            $user = DB::table('join_users')
                ->leftJoin('confirm_user_info','join_users.join_id','=','confirm_user_info.join_id')
                ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
                ->select('join_users.rfp_id','join_users.name','join_users.status','join_users.sex','join_users.city','join_users.company','join_users.duty','join_users.phone','join_users.id_card','join_users.email','join_users.room_type','confirm_user_info.confirm_type','sign_in.join_id')
                ->whereIn('join_users.join_id',$join_id)
                ->where('rfp_id','=',$rfp_id)
                ->get();
        //}

        if(empty($user)){ //判断数据数量
            //return ['msg'=>'暂无参会人员'];
            die ("暂无参会人员");
        }
        foreach($user as $key=>$v){

            $user[$key]['sex']==0?$user[$key]['sex']='女':$user[$key]['sex']='男'; //改变性别字段的显示 //

            empty($user[$key]['confirm_type'])?$user[$key]['confirm_type']='未确认':$user[$key]['confirm_type']='已确认';

            empty($user[$key]['join_id'])?$user[$key]['join_id']='未签到':$user[$key]['join_id']='已签到';

            if($user[$key]['status'] ==0){
                $user[$key]['status'] = "失效";
            }else if($user[$key]['status'] ==1){
                $user[$key]['status'] = "正常";
            }else{
                $user[$key]['status'] = "修改";
            }

            if($user[$key]['rfp_id'] != $rfp_id){
                unset($user[$key]);
            }else{
                if($user[$key]['rfp_id']){
                    unset($user[$key]['rfp_id']); //删除type字段
                }
            }
        }

        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '批量导出参会人信息成功',
                'node' => $this-> __url,
                'rfp_id' => $rfp_id,
                'type' => '1',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}批量导出参会人信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }
        $file_name = date('Y-m-d H:i:s',time());
        Excel::create($file_name, function($excel) use($user){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($user){ //创建表格
                $sheet->fromArray($user,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->setWidth(array(
                    'A'=>12,'B'=>15,'C'=>15,'D'=>25,'E'=>15,'F'=>15,'G'=>20,'H'=>20,'I'=>20,'J'=>20,'K'=>20,'L'=>20
                ));
                $sheet->row(1, array(  //改变表头
                    '姓名','信息状态','性别','所在城市','单位名称','职称／职位','手机号码','身份证号／护照号','邮箱','意向房型','确认状态','签到状态'
                ));
            });
        })->download('xlsx');


    }


    /*
     *  删除参会人
     *  @author Wind
     *  @time   2017年8月29日
     */
    public function  delJoinUser(Request $request)
    {

        if($request->ajax())
        {
            $join_id = $request->input('join_id');
            $join_name = $request->input('join_name');
            $rfp_id = $request->input('rfp_id');
            //  返回值类型
            $return = array(
                'type'  => false,
                'error' => 0,
                'msg'   => '操作失败',
            );
        }else{
            abort('503');
        }
        $rs = $this->__Join->where('join_id', $join_id)->count();
        $del = null;
        if( $rs )
        {
            $del = $this->__Join->where('join_id',$join_id)->update(['status' => '0','update_time'=>date('Y-m-d H:i:s'),'update_user'=>session('user')['id']]);
            if( $del)
            {
                //返回json
                $return = array(
                    'type'  => true,
                    'error' => 1,
                    'msg'   => '删除成功！',
                );
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '删除参会人'.$join_name.'成功',
                    'node' => $this-> __url,
                    'rfp_id' => $rfp_id,
                    'type' => '1',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try
                {
                    $this -> __PLogs -> insert( $param );
                }
                catch (\Exception $e)
                {
                    //写入文本日志
                    $message = "{session('user')['id']}删除用户,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert( $message );
                }
            }
        }elseif( $rs == 0 ) {
            $return = array(
                'type'  => false,
                'error' => 2,
                'msg'   => '该用户已不存在，请刷新列表！',
            );
        }
        return  response()->json($return);
    }

    /***
     * 新增参会人  view
     * @author Wind
     * @time   2017-8-29
     */
    public function  addJoinUser(Request $request)
    {

        if($request->method('GET'))
        {
            $rfp_id = $request->get('rfp_id');
        }else{
            abort('503');
        }

        if(intval($rfp_id) <= 0 )
        {
            abort('503');
        }
       /* $rs = $this -> __Rfp ->where('rfp_id',$rfp_id)
            ->wherein('status',[40,50])
            ->count();
        if( $rs )
        {
            return view('join/add',['rfp_id' => $rfp_id]);
        }else{
            abort('503');
        }*/
        return view('join/add',['rfp_id' => $rfp_id]);
    }

    /**
     * 参会人新增  逻辑层
     * @author  Wind
     * @time    2017-8-29
     */
    public function userInsert( Request $request)
    {
        if( !$request->method('POST'))
        {
            abort('503');
        }
        $validator = \Validator::make($request->input(),[
            'JoinUsers.rfp_id'  =>  'required',
            'JoinUsers.name'    =>  'required|string|min:2|max:50',
            'JoinUsers.sex'     =>  'required|boolean',
            'JoinUsers.phone'   =>  'required|numeric|min:7',
            'JoinUsers.city'    =>  'required|string|min:2|max:50',
            'JoinUsers.company' =>  'required|min:2|max:50',
            'JoinUsers.duty'    =>  'required|min:2|max:50',
            'JoinUsers.id_card' =>  'required|min:2|max:50',
            'JoinUsers.email'   =>  'email',
        ],[
            'required'  => ':attribute 为必填项',
            'min'       => ':attribute 不符合长度最短要求',
            'max'       => ':attribute 字符长度过长',
            'integer'   => ':attribute 必须是一个整数',
            'string'    => ':attribute 必须为字符串类型',
            'numeric'   => ':attribute 必须为一串数字',
            'email'     => ':attribute 必须为有效Email格式',
        ],[
            'JoinUsers.rfp_id'  =>  '归属会议',
            'JoinUsers.name'    =>  '参会人姓名',
            'JoinUsers.sex'     =>  '性别',
            'JoinUsers.phone'   =>  '手机号',
            'JoinUsers.city'    =>  '所属城市',
            'JoinUsers.company' =>  '公司名称',
            'JoinUsers.duty'    =>  '职位/职务',
            'JoinUsers.id_card' =>  '身份证号/护照号',
            'JoinUsers.email'   =>  'Email',

        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->input('JoinUsers');
        $spelling =  $this-> _pinyin -> convert($data['name']);
        $data['spelling'] =implode(' ',$spelling);
        $data['create_user'] = session('user')['id'];
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['status'] = '1';

        if( $this->__Join->insert($data) )
        {
            // 日志信息

            $param = array(
                'belong' => session('user')['id'],
                'content' => '新增参会人'.$data['name'].'成功',
                'node' => $this-> __url,
                'rfp_id' => $data['rfp_id'],
                'type' => '1',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> __PLogs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "{session('user')['id']}新增用户,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            return redirect('/join/index'.'?rfp_id='.$data['rfp_id']);
        }else{
            return redirect()->back()->with('error','false');
        }
    }

    /**
     * 批量导出常用参会人至当前参会人
     * @author Wind
     * @time   2017-8-30
     */
    public  function addOftenToJoin( Request $request)
    {

        if($request->ajax())
        {
            $ids = $request->input('ids');
            $rfp_id = $request->input('rfp_id');
        }else{
            return response()->json(array('type'=>'2','error'=>false,'msg'=>'错误的请求方式！'));
        }
        if( empty($ids))
        {
            return response()->json(array('type'=>'1','error'=>false,'msg'=>'请至少选择一个常用参会人！'));

        }

        $ids = explode(',',$ids);
        if( count($ids) == 0 || !is_array($ids) )
        {
            return response()->json(array('type'=>'1','error'=>false,'msg'=>'请至少选择一个常用参会人！'));
        }

        // 数据查询
        $often_users = $this-> __Often -> select('often_id','name','sex','phone','city','company','duty','id_card','email','room_type','status')
            -> where('status', '>', 0)
            -> whereIn('often_id',$ids)
            -> get()
            -> toarray();
        if( count($often_users) == 0)
        {
            return response()->json(array('type'=>'2','error'=>false,'msg'=>'不存在的常用参会人，请重新选择！'));
        }
        // 初始数据
        foreach ( $often_users as $k => $v )
        {

            $spelling = $this -> _pinyin ->convert($v['name']);
            $often_users[$k]['spelling'] = implode(' ',$spelling);
            $often_users[$k]['status'] = 1;
            $often_users[$k]['rfp_id'] = $rfp_id;
            $often_users[$k]['create_time'] = date('Y-m-d H:i:s');
            $often_users[$k]['create_user'] = session('user')['id'];
            $often_users[$k]['update_time'] = date('Y-m-d H:i:s');
            $often_users[$k]['update_user'] = session('user')['id'];
        }

        $bool = $this-> __Join->insert($often_users);
        if( $bool )
        {
            $param = array(
                'belong'    => session('user')['id'],
                'content'   => '常用参会人导入至会议参会人成功',
                'node'      => $this-> __url,
                'rfp_id'    => $rfp_id,
                'type'      => '1',
                'ip'        => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> __PLogs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "{session('user')['id']}新增用户,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            return response()->json(array('type'=>'0','error'=>true,'msg'=>'新增成功'));
        }else{
            return response()->json(array('type'=>'3','error'=>false,'msg'=>'新增失败'));
        }
    }

}

















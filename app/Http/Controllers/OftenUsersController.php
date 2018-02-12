<?php

namespace App\Http\Controllers;

use App\Models\JoinUsers;
use App\Models\OftenUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\ParticipantLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OftenUsersController extends Controller
{

    private $__Often;
    private $__Join;
    private $__Log;


    public function __construct()
    {
        parent::__construct();
        $this -> __Often = new OftenUsers();
        $this -> __Join = new JoinUsers();
        $this -> __Log = new ParticipantLog();
    }
    /**
     *  常用参会人列表  【添加参会人的iframe】
     *  @author  Wind
     *  @time    2017-8-29
     */
    public  function indexIframe(Request $request)
    {
        $url = array();
        if( $request->isMethod('POST') )
        {
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['rfp_id']   = $request->input('rfp_id');
        }
        if( $request->isMethod('GET') )
        {
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['rfp_id']   = $request->get('rfp_id');
        }

        // 状态
        $where_str = 'often_users.status = ? ';
        $where_arr[] = 1;

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

        $users = $this-> __Often ->select('often_id','name','sex','phone','city','company','duty','id_card','email','room_type','status')
            ->whereRaw($where_str,$where_arr)
            ->paginate(10);
        // 已存在的常用参会人
        $exists = $this-> __Join ->whereRaw('rfp_id = ? and status != ? ',[$url['rfp_id'],0])->lists('often_id')->toArray();
        $user_ids = $this -> __Often->whereRaw($where_str,$where_arr)->lists('often_id')->toArray();
        // 去重
        $select_all = array_diff($user_ids,$exists);
        $user_ids = implode(',',$select_all);

        return view('/often/iframe',['users'=>$users,'url' => $url,'user_ids'=>$user_ids,'exists'=>$exists]);

    }


    /**
     *  常用参会人列表  【修改参会人的iframe】
     *  @author  Wind
     *  @time    2017-09-04
     */
    public  function updateIframe(Request $request)
    {
        $url = array();
        if( $request->isMethod('POST') )
        {
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['rfp_id']   = $request->input('rfp_id');
        }
        if( $request->isMethod('GET') )
        {
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['rfp_id']   = $request->get('rfp_id');
        }

        // 状态
        $where_str = 'often_users.status = ? ';
        $where_arr[] = 1;

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

        $users = $this-> __Often ->select('often_id','name','sex','phone','city','company','duty','id_card','email','room_type','status')
            ->whereRaw($where_str,$where_arr)
            ->paginate(10);
        // 已存在的常用参会人
        $exists = $this-> __Join ->whereRaw('rfp_id = ? and status != ? ',[$url['rfp_id'],0])->lists('often_id')->toArray();
        $user_ids = $this -> __Often->whereRaw($where_str,$where_arr)->lists('often_id')->toArray();
        // 去重
        $select_all = array_diff($user_ids,$exists);
        $user_ids = implode(',',$select_all);

        return view('/often/iframeOfUpdate',['users'=>$users,'url' => $url,'user_ids'=>$user_ids,'exists'=>$exists]);
    }



    /**
     *  常用参会人列表
     *   2017年9月1日
     *   LiXiaoKang
     */
    public function index(Request $request)
    {
        if( $request->isMethod('POST') )
        {
            $url = array();
            $url['often_id'] = $request ->input('often_id');
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['city']   = $request->input('city');
        }
        if( $request->isMethod('GET') )
        {
            $url = array();
            $url['often_id'] = $request ->get('often_id');
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['city']   = $request->get('city');
        }

        $where_str = [];

        // 姓名
        if( trim($url['name']))
        {
            $where_str['name'] = " name like '%$url[name]%' ";
        }

        // 电话号
        if( trim($url['phone']))
        {
            $where_str['phone'] = " phone like '%$url[phone]%' ";
        }

        //城市
        if( trim($url['city']))
        {
            $where_str['city'] = " city like '%$url[city]%' ";
        }
        $where_str = implode('and',$where_str);

        if(empty($where_str))
        {
            $users = DB::table('often_users')
                ->select('often_id', 'name', 'status', 'sex', 'city', 'company', 'duty', 'phone', 'id_card', 'email', 'room_type')
                ->where('status',1)
                ->orderBy('update_time','desc')
                ->orderBy('create_time','desc')
                ->paginate(20, ['*'], 'user');
        }else {
            $users = DB::table('often_users')
                ->select('often_id', 'name', 'status', 'sex', 'city', 'company', 'duty', 'phone', 'id_card', 'email', 'room_type')
                ->whereRaw($where_str)
                ->where('status',1)
                ->orderBy('update_time','desc')
                ->orderBy('create_time','desc')
                ->paginate(20, ['*'], 'user');
        }


        $where = array(
            'type' => 6,
        );

        $logs = $this->get_participant_log($where, 'desc', 'create_time', 10);
        $logs = $logs ? $logs : array();

        $url_str = url('/Often/index') . '/?';
        foreach ($url as $v => $k) {
            $url_str .= $v . '=' . $k . '&';
        }

        return view('/often/oftenUser',['users'=>$users,'url'=>$url,'logs'=>$logs]);
    }

    /**
     * Store a newly created resource in storage.
     * 常用参会人添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['name']    = $request->input('name'); //用户名
        if(empty($data['name'])){
            return ['key'=>'name','num'=>'请填写姓名'];
        }
        $data['sex']     = $request->input('sex'); //性别
        $data['phone']   = $request->input('phone'); //电话
        if(empty($data['phone'])){
            return ['key'=>'phone','num'=>'请填写手机号'];
        }
        if(!preg_match('/^1[34578]\d{9}$/',$data['phone'])){
            return ['key'=>'phone','num'=>'请填写正确的手机号格式'];
        }
        if(DB::table('often_users')->select('phone')->where('phone','=',$data['phone'])->where('often_id','!=',$request->input('id'))->count()!=0){
            return ['key'=>'phone','num'=>'手机号已存在'];
        }
        $data['city']    = $request->input('city'); //所在城市
        if(empty($data['city'])){
            return ['key'=>'city','num'=>'请填写城市信息'];
        }
        $data['company'] = $request->input('company'); //单位名称
        if(empty($data['company'])){
            return ['key'=>'company','num'=>'请填写单位名称'];
        }
        $data['duty']    = $request->input('duty'); //职务职称
        if(empty($data['duty'])){
            return ['key'=>'duty','num'=>'请填写职务职称'];
        }
        $data['id_card'] = $request->input('id_card'); //身份证号
        if(empty($data['id_card'])){
            return ['key'=>'id_card','num'=>'请填写证件号'];
        }
        if(strlen($data['id_card']) <8 && strlen($data['id_card']) >30){
            return ['key'=>'id_card','num'=>'请填写正确的证件号格式'];
        }
        if(DB::table('often_users')->select('id_card')->where('id_card','=',$data['id_card'])->where('often_id','!=',$request->input('id'))->count()!=0){
            return ['key'=>'id_card','num'=>'身份证号已存在'];
        }
        $data['email']   = $request->input('email'); //邮箱
        if(!empty($data['email'])){
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $data['email'])) {
                return ['key'=>'email','num'=>'请填写正确的邮箱格式'];
            }
        }
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['create_user'] = session::get("user.id");
        $data['update_time']  = date('Y-m-d H:i:s');
        $data['update_user']  = session::get("user.id");
        DB::table('often_users')->insert($data);
        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '添加常用参会人信息成功',
                'node' => $this-> __url,
                'rfp_id' => $request['rfp_id'],
                'type' => '6',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
            $count = count($data)-1;
            return ['num'=>'添加成功'];
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}添加常用参会人信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return $e;
        }
    }

    /**
     *  Ajax 获取常用参会人详细信息
     *  Wind 2017-9-4
     */
    public function  getOftenInfo( Request $request )
    {
        if( !$request->ajax())
        {
            return response()->json(array('type'=>'false','msg'=>'错误的访问方式'));
        }
        $often_id = $request->input('often_id');
        if( empty(intval($often_id)))
        {
            return response()->json(array('type'=>'false','msg'=>'请选择常用参会人'));
        }
        $info = $this-> __Often -> whereRaw('often_id = ? and status != ? ' , [$often_id,0])->first();
        if( empty($info))
        {
            return response()->json(array('type'=>'false','msg'=>'您选择的常用参会人已失效或删除，请重新选择'));
        }else{
            return response()->json(array('type'=>'true','msg'=>'','info'=>$info));
        }

    }

    /**
     *  更新常用参会人
     *  LiXiaoKang
     *  2017-9-1
     */
    public function update(Request $request)
    {
        $data['name']    = $request->input('name'); //用户名
        if(empty($data['name'])){
            return ['key'=>'name','num'=>'请填写姓名'];
        }
        $data['sex']     = $request->input('sex'); //性别
        $data['phone']   = $request->input('phone'); //电话
        if(empty($data['phone'])){
            return ['key'=>'phone','num'=>'请填写手机号'];
        }
        if(!preg_match('/^1[34578]\d{9}$/',$data['phone'])){
            return ['key'=>'phone','num'=>'请填写正确的手机号格式'];
        }
        if(DB::table('often_users')->select('phone')->where('phone','=',$data['phone'])->where('often_id','!=',$request->input('id'))->count()!=0){
            return ['key'=>'phone','num'=>'手机号已存在'];
        }

        $data['city']    = $request->input('city'); //所在城市
        if(empty($data['city'])){
            return ['key'=>'city','num'=>'请填写城市信息'];
        }
        $data['company'] = $request->input('company'); //单位名称
        if(empty($data['company'])){
            return ['key'=>'company','num'=>'请填写单位名称'];
        }
        $data['duty']    = $request->input('duty'); //职务职称
        if(empty($data['duty'])){
            return ['key'=>'duty','num'=>'请填写职务职称'];
        }
        $data['id_card'] = $request->input('id_card'); //身份证号
        if(empty($data['id_card'])){
            return ['key'=>'id_card','num'=>'请填写证件号'];
        }
        if(!preg_match('/^[0-9a-zA-Z]{8,30}$/',$data['id_card'])){
            return ['key'=>'id_card','num'=>'证件号：数字或字母8-30个字符'];
        }
        if(DB::table('often_users')->select('id_card')->where('id_card','=',$data['id_card'])->where('often_id','!=',$request->input('id'))->count()!=0){
            return ['key'=>'id_card','num'=>'身份证号已存在'];
        }
        $data['email']   = $request->input('email'); //邮箱
        if(!empty($data['email'])){
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $data['email'])) {
                return ['key'=>'email','num'=>'请填写正确的邮箱格式'];
            }
        }
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $data['update_user'] = session::get("user.id");
        DB::table('often_users')->where('often_id','=',$request->input('id'))->update($data);
        DB::beginTransaction();
        try {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '修改常用参会人信息成功',
                'node' => $this-> __url,
                'rfp_id' => $request['rfp_id'],
                'type' => '6',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            DB::table('participant_log') -> insert( $param );
            DB::commit();
            $count = count($data)-1;
            return ['num'=>'修改成功'];
        }catch ( \Exception $e){
            DB::rollback();
            //写入文本日志
            $message = "{session('user')['id']}修改常用参会人信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return $e;
        }
    }

    //删除参会人
    public function  delJoinUser(Request $request)
    {

        if($request->ajax())
        {
            $often_id = $request->input('often_id');
            $often_name = $request->input('often_name');
            //  返回值类型
            $return = array(
                'type'  => false,
                'error' => 0,
                'msg'   => '操作失败',
            );
        }else{
            abort('503');
        }
        $rs = DB::table('often_users')->where('often_id', $often_id)->count();
        $del = null;
        $date = [];
        if( $rs )
        {
            $del = DB::table('often_users')->where('often_id',$often_id)->update(['status' =>0,'update_time'=>date('Y-m-d H:i:s'),'update_user'=>session('user')['id']]); // todo 数据库bit类型数据无法修改

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
                    'content' => '删除参会人'.$often_name.'成功',
                    'node' => $this-> __url,
                    'type' => '6',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try
                {
                    DB::table('participant_log') -> insert( $param );
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Staff;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\ParticipantLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ServersController extends Controller
{
    private $_Servers;
    private $_Staff;
    private $_Role;
    private $_User;
    private $_UserRole;
    private $_PLog;
    public function __construct()
    {
        parent::__construct();
        $this->_Servers   = new Servers();     
        $this->_Staff     = new Staff();
        $this->_Role      = new Role();
        $this->_User      = new User();
        $this->_UserRole  = new UserRole();
        $this->_PLogs     = new ParticipantLog();
    }

    /**
     *  服务商列表
     *　@author Willa
     *  @time   2017-8-31
     */
    public function index( Request $request)
    {
        $url = array();
        if( $request->isMethod('POST') )
        {
            
            $url['name']   = $request->input('name');            
            $url['phone']    = $request->input('phone');
            $url['status']     = $request->input('status');           
        }
        if( $request->isMethod('GET') )
        {
            
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['status']   = $request->get('status');            
        }
       
        // 询单id
        $where_str = '';
        $where_arr[] = array();

        // 状态
        if( empty($url['status']) ) //全部
        {
            $where_str .= ' status != ?';
            $where_arr[] = 0;
        }else{                      //停用、启动
            $where_str .= ' status = ?';
            $where_arr[] = $url['status'];
        }

        // 姓名,模糊搜索
        if( trim($url['name']))
        {
            $where_str .= " and name like '%$url[name]%' ";
        }

        // 电话号，精确搜索
        if( trim($url['phone']))
        {
            $where_str .= " and phone = '$url[phone]' ";
        }  

        // 服务商列表
        $server_list = DB::table('servers')                  
                ->select('servers.s_id','servers.name', 'servers.head','servers.phone','servers.email','servers.prov','servers.prov_name','servers.city','servers.city_name','servers.area','servers.area_name','servers.adderss','servers.status',
                    (DB::raw("(select count(*) from seavers_staff where s_id = servers.s_id and status != 0) as staff_num"))  )
                ->whereRaw($where_str,$where_arr)
                ->orderBy('servers.update_time','desc')
                ->orderBy('servers.create_time','desc')
                //->orderBy('servers.s_id','desc')
                ->paginate(20,['*'],'ServerList');         


        $logs = $this-> get_participant_log(array('type'=>7),'desc','create_time',10)->toarray();  // 服务商
        
        $logs = $logs ? $logs  : array();      
        return view('/servers/index',['server_list'=>$server_list,'url' => $url,'logs'=>$logs]);
    }

    /**
     *  服务商添加
     *　 @author Willa
     *  @time   2017-9-1
    */
    public function create(Request $request)
    {    
        if(!$request->method('GET'))
        {
            abort('503');
        }
        //省份
        $province_json = file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getProvinces");
        $province = json_decode($province_json,true);
        $city = array();
        $area = array();
       // print_r($province);die();
        //新增
        if(empty($request ->get('s_id')))
        {
            return view('/servers/create',['province'=>$province['Data']]);
        }
        
        //修改
        $server_id = intval($request ->get('s_id')) ;
        
        if(empty($server_id))
        {
            abort('503');            
        }
        
        // 基础信息
        $server_info = $this-> _Servers      
        ->select('s_id','name', 'head','phone','email','prov','city','area','adderss','status')
        ->whereRaw('status != ? and s_id = ?',[0,$server_id])
        ->distinct()
        ->first()
        ->toArray();
        if(empty($server_info))
        {
            abort('503');
        }
        //市        
        if(!empty($server_info['prov']))
        {
            $city_json = file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getAreaCity?cityId=".$server_info['prov']);
            $city = json_decode($city_json,true);
        }
       
        //区
        if(!empty($server_info['city']))
        {
            $area_json = file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getAreaCity?cityId=".$server_info['city']);
            $area = json_decode($area_json,true);
        }      
        
        return view('/servers/create',['server_info'=>$server_info,'province'=>$province['Data'],'city'=>$city['Data'],'area'=>$area['Data']]);
    }
    
    /**
     * 创建服务商
     * @author  Willa
     * @time    2017-9-1
     */
    public function insert( Request $request)
    {
        if( !$request->method('POST'))
        {
            abort('503');
        }
        $validator = \Validator::make($request->input(),[          
            'Server.name'       =>  'required|string|min:1|unique:servers,name,0,status',   
            'Server.head'       =>  'required|string|min:1',
            'Server.phone'      =>  'required|regex:[1[34578]\d{9}]',      
            'Server.email'      =>  'required|email',
            'Server.prov'       =>  'required|not in:0',
            'Server.city'       =>  'required|not in:0',
            'Server.area'       =>  '',
            'Server.adderss'    =>  'required|string|min:1',
        ],[
            'required'          => '请填写 :attribute',
            'min'               => ':attribute 不符合长度最短要求',
            'max'               => ':attribute 字符长度过长',
            'integer'           => ':attribute 必须是一个整数',
            'string'            => ':attribute 必须为字符串类型',
            'numeric'           => ':attribute 必须为一串数字',
            'email'             => ':attribute 必须为有效Email格式',
            'regex'             => ':attribute 格式不正确',
            'unique'            => ':attribute 已经存在',
            'not in'            => ':attribute 请选择'
        ],[
            'Server.name'       =>  '服务商名称', 
            'Server.head'       =>  '负责人',
            'Server.phone'      =>  '手机号',            
            'Server.email'      =>  '邮箱',
            'Server.adderss'    =>  '公司地址',
            'Server.prov'       =>  '省',
            'Server.city'       =>  '市',
            'Server.area'       =>  '区',         
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $request->input('Server');           
        
        $data['create_user'] = session('user')['id'];
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['status'] = '1';
        
        $p = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$data['prov']),true);
        $c = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$data['city']),true);
        $a = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$data['area']),true);
        
        $data['prov_name'] = !empty($p['Data'][0]) ? $p['Data'][0]['name'] : "";
        $data['city_name'] = !empty($c['Data'][0]) ? $c['Data'][0]['name'] : "";
        $data['area_name'] = !empty($a['Data'][0]) ? $a['Data'][0]['name'] : "";
    
        $insert_id = $this->_Servers->insertGetId($data);  
        if( $insert_id)
        {
             // 日志信息    
            $param = array(
                'belong'        => session('user')['id'],
                'table_name'    => 'servers',
                'table_id'      => $insert_id,
                'content'       => '新增服务商'.$data['name'].'成功',
                'node'          => $this-> __url,                
                'type'          => '7',
                'ip'            => $_SERVER["REMOTE_ADDR"],
                'create_time'   => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> _PLogs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = session('user')['id']."新增服务商,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            return redirect('/Servers/index');
        }else{
            return redirect()->back()->with('error','false');
        }
    }
    
    /**
     * 修改服务商
     * @author  Willa
     * @time    2017-9-1
     */
    public function update( Request $request)
    {
        $type = $request['type'];

        if( !$request->method('POST'))
        {
            abort('503');
        }
        //接收修改数据
        $data = $request->input('Server');       
        if(!isset($data['s_id']))
        {
            abort('503');
        }
        $server_id = intval($data['s_id']);
        
        // 判断修改的服务商是否存在
        $bool = $this->_Servers->whereRaw('status != ? and s_id = ?',[0,$server_id])->count();
        if( $bool == 0 )
        {
            abort('503');
        }
       
        $validator = \Validator::make($request->input(),[
            'Server.name'       =>  "required|string|min:1|unique:servers,name,$server_id,s_id",   
            'Server.head'       =>  'required|string|min:1',
            'Server.phone'      =>  'required|regex:[1[34578]\d{9}]',      
            'Server.email'      =>  'required|email',
            'Server.prov'       =>  'required|not in:0',
            'Server.city'       =>  'required|not in:0',
            'Server.area'       =>  '',
            'Server.adderss'    =>  'required|string|min:1',
        ],[
            'required'          => ':attribute 为必填项',
            'min'               => ':attribute 不符合长度最短要求',
            'max'               => ':attribute 字符长度过长',
            'integer'           => ':attribute 必须是一个整数',
            'string'            => ':attribute 必须为字符串类型',
            'numeric'           => ':attribute 必须为一串数字',
            'email'             => ':attribute 必须为有效Email格式',
            'regex'             => ':attribute 格式不正确',
            'unique'            => ':attribute 已经存在',
            'not in'            => ':attribute 请选择'
        ],[
            'Server.name'       =>  '服务商名称',
            'Server.head'       =>  '负责人',
            'Server.phone'      =>  '手机号',
            'Server.email'      =>  '邮箱',
            'Server.adderss'    =>  '公司地址',
            'Server.prov'       =>  '省',
            'Server.city'       =>  '市',
            'Server.area'       =>  '区',
    
        ]);
        
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        unset($data['s_id']);       
        if( $this->_Servers->where('s_id', $server_id)->update($data))
        {
            // 日志信息
            $param = array(
                'belong'        => session('user')['id'],
                'table_name'    => 'servers',
                'table_id'      => $server_id,
                'content'       => '修改服务商'.$data['name'].'成功',
                'node'          => $this-> __url,
                'type'          => '7',
                'ip'            => $_SERVER["REMOTE_ADDR"],
                'create_time'   => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> _PLogs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = session('user')['id']."修改服务商{$server_id},日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            if($type == 2) {
                return redirect('/Servers/info'.'?s_id='.$server_id);
            }else{
                return redirect('/Servers/index');
            }
        }else{
            return redirect()->back()->with('error','false');
        }
    }
    
    /**
     *  停用启用服务商
     *  @author Willa
     *  @time  2017-9-1
    */
    public function changeStatus(Request $request)
    {
    
        if($request->ajax())
        {
            $server_id  = intval($request->input('s_id')); 
            $old_status = intval($request->input('status'));
            $name       = trim($request->input('name'));
            //  返回值类型
            $return = array(
                'type'  => false,
                'error' => 0,
                'msg'   => '操作失败',
            );
        }else{
            abort('503');
        }
        $server = $this-> _Servers      
                ->select('status')
                ->whereRaw('status != ? and s_id = ?',[0,$server_id])
                ->distinct()
                ->first()
                ->toArray();
      
        if( $server )
        {
            if($server['status'] != $old_status) //传递的服务商原状态与数据库不一致
            {
                $return = array(
                    'type'  => true,
                    'error' => 0,
                    'msg'   => '数据错误！',
                );
            }
            else{                
                $new_status = $server['status'] == 1 ? 3 : 1 ;
                $change = $this->_Servers->where('s_id',$server_id)->update(['status' => $new_status,'update_time'=>date('Y-m-d H:i:s'),'update_user'=>session('user')['id']]);
                if( $change)
                {
                    //返回json
                    $return = array(
                        'type'  => true,
                        'error' => 1,
                        'msg'   => '修改成功！',
                    );
                    // 日志信息
                    $param = array(
                        'belong'        => session('user')['id'],
                        'table_name'    => 'servers',
                        'table_id'      => $server_id,
                        'content'       => '修改服务商状态'.$name.'成功',
                        'node'          => $this-> __url,                        
                        'type'          => '7',
                        'ip'            => $_SERVER["REMOTE_ADDR"],
                        'create_time'   => date('Y-m-d H:i:s'),
                    );
                    // 写入日志
                    try
                    {
                        $this -> _PLogs -> insert( $param );
                    }
                    catch (\Exception $e)
                    {
                        //写入文本日志
                        $message = session('user')['id']."修改服务商状态{$server_id},日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                        Log::alert( $message );
                    }
                }
                else{
                    //返回json
                    $return = array(
                        'type'  => true,
                        'error' => 0,
                        'msg'   => '修改失败！',
                    );
                }
            }
        }
        else{
            $return = array(
                'type'  => false,
                'error' => 0,
                'msg'   => '该服务商已不存在，请刷新列表！',
            );
        }
        return  response()->json($return);
    }
    
    /**
     *  服务商信息查看
     *　 @author Willa
     *  @time   2017-9-3
     */
    public function info(Request $request)
    {
        if(!$request->method('GET'))
        {
            abort('503');
        }
        $server_id = intval($request ->get('s_id')) ; //接收服务商ID
        
        if(empty($server_id))
        {
            abort('503');
        }
        
        // 查看服务商是否存在
        $server_info = $this-> _Servers
                        ->select('servers.s_id','servers.name', 'servers.head','servers.phone','servers.email','servers.prov','servers.city','servers.area','servers.adderss','servers.status',
                           (DB::raw("(select count(*) from seavers_staff where s_id = servers.s_id and status != 0) as staff_num")) )
                        ->whereRaw('status != ? and s_id = ?',[0,$server_id])
                        ->distinct()
                        ->first()
                        ->toArray();
       
        if(empty($server_info))
        {
            abort('503');
        }
        //省市区
        $p = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$server_info['prov']),true);
        $c = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$server_info['city']),true);
        $a = json_decode(file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getCityName?cityId=".$server_info['area']),true);
        
        $server_info['prov'] = !empty($p['Data'][0]) ? $p['Data'][0]['name'].'省' : "";
        $server_info['city'] = !empty($c['Data'][0]) ? $c['Data'][0]['name'] : "";
        $server_info['area'] = !empty($a['Data'][0]) ? $a['Data'][0]['name'] : "";       
        
        //查看员工信息
        $staffs =  DB::table( "seavers_staff" )
                    ->leftJoin('users', 'seavers_staff.users_id', '=', 'users.id')
                    ->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
                    ->leftJoin('roles', 'user_role.role_id', '=', 'roles.id')
                    ->select('seavers_staff.id','s_id','seavers_staff.name','sex','seavers_staff.phone','id_card','seavers_staff.email','company','seavers_staff.status','users.username','roles.name as rolename')
                    ->whereRaw('seavers_staff.status != ? and s_id = ? ',[0,$server_id])
                    ->orderBy('seavers_staff.update_time','desc')
                    ->orderBy('seavers_staff.id','desc')
                    ->get();        
       
        
        //查看登录用户是否为服务商员工      
        $admin_num =  DB::table( "seavers_staff" )->whereRaw('status != ? and users_id = ? ',[0, session('user')['id']])->count();
        $is_server = $admin_num > 0 ? 1 : 0;
        return view('/servers/info',['staffs'=>$staffs,'server_info'=>$server_info,'is_server'=>$is_server]);
    }
    /**
     *  服务商添加/修改员工页面
     *　 @author Willa
     *  @time   2017-9-3
     */
    public function staff(Request $request)
    {
        if(!$request->method('GET'))
        {
            abort('503');
        }
        $server_id = intval($request ->get('s_id')) ; //接收服务商ID        
        $staff_id = intval($request ->get('staff_id')) ;  //接收服务商员工ID
        
        //系统角色
        $roles = $this->_Role->select('id','name')->whereRaw('status =  ?',[1])->get();
      
        //添加页面
        if(empty($staff_id)) 
        {
            return view('servers/staff',['server_id'=>$server_id,'roles'=>$roles]);
        }
        
        //修改页面
        if(empty($server_id) || empty($staff_id) )
        {
            abort('503');
        }
    
        // 查看服务商是否存在
        $server_info = $this-> _Servers->whereRaw('status != ? and s_id = ?',[0,$server_id])->count();
        
        if(empty($server_info))
        {
            abort('503');
        }
        //查看员工信息
        $staff = DB::table( "seavers_staff" )
                ->leftJoin('users', 'seavers_staff.users_id', '=', 'users.id')
                ->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
                ->select('seavers_staff.id','seavers_staff.s_id','seavers_staff.name','seavers_staff.sex','seavers_staff.phone','seavers_staff.id_card','seavers_staff.email','seavers_staff.company','seavers_staff.status','seavers_staff.users_id',
                        'users.username','users.password','user_role.role_id')
                ->whereRaw('seavers_staff.status != ? and seavers_staff.id = ? and seavers_staff.s_id = ? ',[0,$staff_id,$server_id])  
                ->first();
       
        if(empty($staff))
        {
            abort('503');
        }
        return view('/servers/staff',['staff'=>$staff,'server_id'=>$server_id,'roles'=>$roles]);
    }
    
    /**
     * 创建某个服务商的员工
     * @author  Willa
     * @time    2017-9-1
     */
    public function staffInsert( Request $request)
    {
       
        if( !$request->method('POST'))
        {
            abort('503');
        }
        //接收参数
        $data = $request->input('Staff');        
        if(!isset($data['s_id']) || empty($data['s_id']))
        {
            abort('503');
        }
        $server_id = intval($data['s_id']);
        // 查看服务商是否存在
        $server_info = $this-> _Servers->whereRaw('status != ? and s_id = ?',[0,$server_id])->count();
        
        if(empty($server_info))
        {
            abort('503');
        }
        $validator = \Validator::make($request->input(),[
            'Staff.name'        =>  'required|string|min:1',
            'Staff.sex'         =>  'required|bool',
            'Staff.phone'       =>  'required|regex:[1[34578]\d{9}]|unique:seavers_staff,phone,0,id,status,1',
            'Staff.id_card'     =>  'required|string|min:15|max:18|unique:seavers_staff,id_card,0,id,status,1',
            'Staff.email'       =>  'required|email',
            'Staff.company'     =>  'required|string|min:1',           
            //'User.login_name'   =>  'required|string|min:1|unique:users,login_name,0,id,status,1',
            'User.password'     =>  'required|string|between:6,12|confirmed',
            'UserRole.role_id'  =>  'required|numeric|not in:0',
        ],[
            'required'          => '请填写 :attribute ',
            'min'               => ':attribute 不符合长度最短要求',
            'max'               => ':attribute 字符长度过长',
            'integer'           => ':attribute 必须是一个整数',
            'string'            => ':attribute 必须为字符串类型',
            'numeric'           => ':attribute 必须为一串数字',
            'email'             => ':attribute 必须为有效Email格式',
            'regex'             => ':attribute 格式不正确',
            'confirmed'         => '密码和确认密码不匹配 ',
            'between'           => ':attribute 在6-12个字符之间',
            'not in:0'          => '请选择 :attribute',
            'unique'            => ':attribute 已存在'
        ],[
            'Staff.name'        =>  '姓名',
            'Staff.sex'         =>  '性别',
            'Staff.phone'       =>  '手机号码',
            'Staff.id_card'     =>  '身份证号',
            'Staff.email'       =>  '邮箱',
            'Staff.company'     =>  '职位名称',            
            //'User.login_name'   =>  '用户名',
            'User.password'     =>  '密码', 
            'UserRole.role_id'  =>  '系统角色',
            
        ]);
      
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $login_name = $this->rand_num(); //生成随机的用户名
        DB::beginTransaction();  //事务开始
        //将用户关联添加到Users表
        $user = $request->input('User');
        $user['login_name']   = $login_name;
        $user['username']     = $login_name;
        $user['password']     = Hash::make($user['password']);
        $user['created_time'] = date('Y-m-d H:i:s');
        $user['updated_time'] = date('Y-m-d H:i:s');
        $user['status'] = '1'; //状态正常
        
        unset($user['password_confirmation']);
        $user_insert_id = $this->_User->insertGetId($user);
        
        
        //添加后台用户-角色关联关系
        $user_role = $request->input('UserRole');
        $user_role['user_id'] = $user_insert_id;
        DB::table( "user_role" )->insert($user_role);
        
        
        //添加员工
        $data['users_id']    = $user_insert_id;
        $data['create_user'] = session('user')['id'];
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['status'] = '1';
        
        $insert_id = DB::table( "seavers_staff" )->insertGetId($data);
        DB::commit(); //事务提交
        if( $insert_id)
        {            
            // 日志信息
            $param = array(
                'belong'        => session('user')['id'],
                'table_name'    => 'seavers_staff',
                'table_id'      => $insert_id,
                'content'       => '新增服务商员工'.$data['name'].'成功',
                'node'          => $this-> __url,
                'type'          => '7',
                'ip'            => $_SERVER["REMOTE_ADDR"],
                'create_time'   => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> _PLogs -> insert( $param );                
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "{session('user')['id']}新增服务商员工,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            return redirect('/Servers/info?s_id='.$server_id);
        }
        else
        {
            return redirect()->back()->with('error','false');
        }
              
               
    }
    
    /**
     * 修改某个服务商的员工
     * @author  Willa
     * @time    2017-9-1
     */
    public function staffUpdate( Request $request)
    {
        if( !$request->method('POST'))
        {
            abort('503');
        }
        //接收参数
        $data = $request->input('Staff');
        if(!isset($data['s_id']) || empty($data['s_id']))
        {
            abort('503');
        }
        $server_id = intval($data['s_id']);
        $staff_id  = intval($data['id']);
        // 查看服务商下的员工是否存在
        $server_info = DB::table( "seavers_staff" )->whereRaw('status != ? and s_id = ? and id = ? ',[0,$server_id,$staff_id])->count();
    
        if(empty($server_info))
        {
            abort('503');
        }
        $validator = \Validator::make($request->input(),[    
            'Staff.name'        =>  'required|string|min:1',
            'Staff.sex'         =>  'required|bool',
            'Staff.phone'       =>  "required|unique:seavers_staff,phone,$staff_id,id,status,1|regex:[1[34578]\d{9}]",
            'Staff.id_card'     =>  "required|unique:seavers_staff,id_card,$staff_id,id,status,1|string|min:15|max:18",
            'Staff.email'       =>  'required|email',
            'Staff.company'     =>  'required|string|min:1',           
            //'User.login_name'   =>  'required|string|min:1',
            'User.password'     =>  'string|between:6,12|confirmed',
            'UserRole.role_id'  =>  'required|numeric|not in:0',
        ],[
            'required'          => '请填写 :attribute ',
            'min'               => ':attribute 不符合长度最短要求',
            'max'               => ':attribute 字符长度过长',
            'integer'           => ':attribute 必须是一个整数',
            'string'            => ':attribute 必须为字符串类型',
            'numeric'           => ':attribute 必须为一串数字',
            'email'             => ':attribute 必须为有效Email格式',
            'regex'             => ':attribute 格式不正确',
            'confirmed'         => '密码和确认密码不匹配 ',
            'between'           => ':attribute 在6-12个字符之间',
            'not in'            => '请选择 :attribute',
            'unique'            => ':attribute 已存在'
        ],[           
            'Staff.name'        =>  '姓名',
            'Staff.sex'         =>  '性别',
            'Staff.phone'       =>  '手机号码',
            'Staff.id_card'     =>  '身份证号',
            'Staff.email'       =>  '邮箱',
            'Staff.company'     =>  '职位名称',            
            //'User.login_name'   =>  '用户名',
            'User.password'     =>  '密码', 
            'UserRole.role_id'  =>  '系统角色',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');       
        
        DB::beginTransaction();  //事务开始
        //修改后台用户密码
        $user = $request->input("User");
        if(!empty($user['password']))
        {
            DB::table( "users" ) ->where('id', $data['users_id'])->update(array('password'=> Hash::make($user['password']),'updated_time'=>date('Y-m-d H:i:s')));
        }        
        
        //修改后台用记角色
        $role = $request->input("UserRole");
       
        DB::table( "user_role" )->where('user_id', $data['users_id'])->update(array('role_id'=>$role['role_id']));
       
        //员工修改
        unset($data['s_id']);
        unset($data['id']);
        unset($data['users_id']);
        $staff_update = DB::table( "seavers_staff" )->where('id', $staff_id)->update($data); 
        DB::commit(); //事务提交
        if( $staff_update )
        {
            // 日志信息
            $param = array(
                'belong'        => session('user')['id'],
                'table_name'    => 'seavers_staff',
                'table_id'      => $staff_id,
                'content'       => '修改服务商员工成功',
                'node'          => $this-> __url,
                'type'          => '7',
                'ip'            => $_SERVER["REMOTE_ADDR"],
                'create_time'   => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try
            {
                $this -> _PLogs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "{session('user')['id']}修改服务商员工{$staff_id},日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }
            return redirect('/Servers/info?s_id='.$server_id);
        }else{
            return redirect()->back()->with('error','false');
        }
    }
    
    /*
     *  删除某个服务商员工
     *  @author Wind
     *  @time   2017年8月29日
     */
    public function  delStaff(Request $request)
    {
    
        if(!$request->ajax())
        {
            abort('503');               
        }
        $server_id = null != $request->input('server_id') ? $request->input('server_id') : 0;
        $staff_id  = null != $request->input('staff_id')  ? $request->input('staff_id')  : 0;
        //  返回值类型
        $return = array(
            'type'  => false,
            'error' => 0,
            'msg'   => '删除员工失败',
        );
        $rs = DB::table("seavers_staff")->select("users_id")->whereRaw('id = ? and s_id = ?', [$staff_id,$server_id])->first();
              
        if( !empty($rs) )
        {
            DB::beginTransaction();  //事务开始
            $del_staff = DB::table("seavers_staff")->where('id',$staff_id)->update(['status' => 0 ,'update_time'=>date('Y-m-d H:i:s'),'update_user'=>session('user')['id']]); //删除服务商员工
            $del_user = DB::table("users")->where('id',$rs['users_id'])->update(['status' => 2 ,'updated_time'=>date('Y-m-d H:i:s')]);   //删除服务商对应的员工，员工删除后异常用户
            DB::commit(); //事务提交
            if( $del_staff && $del_user)
            {
                
                $staff_num = DB::table("seavers_staff")->whereRaw('status = ? and s_id = ?', [1,$server_id])->count(); //剩余有效员工的个数
                //返回json
                $return = array(
                    'type'  => true,
                    'error' => 1,
                    'msg'   => '删除成功！',
                    'num'   => $staff_num
                );
                // 日志信息
                $param = array(
                    'belong'        => session('user')['id'],
                    'table_id'      => $staff_id,
                    'table_name'    => 'seavers_staff',
                    'content'       => '删除员工成功',
                    'node'          => $this-> __url,                    
                    'type'          => '7',
                    'ip'            => $_SERVER["REMOTE_ADDR"],
                    'create_time'   => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try
                {
                    $this -> _PLogs -> insert( $param );
                }
                catch (\Exception $e)
                {
                    //写入文本日志
                    $message = "{session('user')['id']}删除服务商员工{$staff_id},日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert( $message );
                }
            }
        }
        return  response()->json($return);
    }
    /**
     *  查询市、区
     *  @author Willa
     *  @time  2017-9-8
     */
    public function SearchCity(Request $request)
    {
        if(!$request->ajax())
        {
           abort('503');
        }
        $prov = intval($request->input('prov'));
        
        $city_json = file_get_contents("http://qa.meetingv2.eventown.com/Rfp/getAreaCity?cityId=".$prov);
        $city = json_decode($city_json,true);
        $city_arr = array();
        if($city['Success'])
        {
            $city_arr = $city['Data'];
        }
        return  response()->json($city_arr);;       
    }
    
    protected function rand_num()
    {
        $number = rand(pow(10,(6-1)), pow(10,6)-1);       
        //查询用户名是否已存在（不管用户删除还是未删除状态）
        $user_num = $this->_User->whereRaw('login_name = ? ',['SA'.$number])->count();
        if($user_num > 0)
        {
            $this->rand_num();
        }
        return 'SA'.$number;
    }
}

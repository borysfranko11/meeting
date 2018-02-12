<?php

namespace App\Http\Controllers;

use App\Models\ParticipantLog;
use Log;
use App\Models\Resource;
use App\Models\RoleResource;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;                            // 获取当前路由中的一些信息 link: https://laravel.com/api/5.1/Illuminate/Support/Facades/Route.html

use App\Libs\EveClient;
use App\Libs\Http;


use Illuminate\Database\Eloquent\Model;
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    # _ 单下划线变量为私有类型

    # __ 双下划线变量为保护类型
    protected $__controller;
    protected $__action;
    protected $__url;

    # __ 双下划线 + 并首字母大写的变量为保护类型模型层
    protected $__User_role;
    protected $__Role_resource;
    protected $__Resource;
    protected $__Participant_log;

    public $client;
    public static $clients = array();

    public function __construct()
    {
        $this -> __User_role     = new UserRole();
        $this -> __Role_resource = new RoleResource();
        $this -> __Resource      = new Resource();
        $this -> __ResourceHttp  = new Request();
        $this -> __Participant_log = new ParticipantLog();

        # refer https://laravel-china.org/api/5.1/Illuminate/Contracts/Logging/Log.html#method_error
        $dir = storage_path('logs/meeting');
        Log::useDailyFiles( $dir, env('DAY'), env('LEVEL') );

        // 获取时区
        if( !empty( app( 'session' ) -> get( 'time_zone' ) ) )
        {
            $time_zone = app( 'session' ) -> get( 'time_zone' );
        }
        else
        {
            //$time_zone = $_ENV['TIME_ZONE'];
            $time_zone = config('timezone');
            app( 'session' ) -> set( 'time_zone', $time_zone );
        }

        $time_zone = config('app.timezone');

        // 设置默认时区
        date_default_timezone_set( $time_zone );

        // 获取控制器和方法的名称
        $path = Route::getCurrentRoute() -> getActionName();
        list( $controller, $method ) = explode( '@', $path );
        // 控制器名称以及方法名称获取
        $this -> __controller = str_replace( 'Controller', '', preg_replace( '/.*\\\/', '', $controller ) );
        $this -> __action = preg_replace( '/.*\\\/', '', $method );
        $this -> __url = '/'.$this -> __controller.'/'.$this -> __action;

        // 进载入框架基础页面下执行
        if( ($this -> __controller == 'Main' && $this -> __action == 'index') || ($this -> __controller == 'Wap' && $this -> __action == 'index') )
        {
            $this -> mainPageMsg();
        }

        // 页面公用参数渲染
        $this -> commonPageMsg();

        $special_ctl = array( 'Jump' );
        if( !in_array( $this -> __controller, $special_ctl ) )
        {
            $this -> visitIllegality();
            $this -> forbidRelogin();
        }
    }

    /**
     * des: 限制非法访问
     */
    protected function visitIllegality()
    {
        // 判断是否登录
        if( !empty( session('user') ) )
        {
            // 组装节点
            $url  = $_SERVER['REQUEST_URI'];
            if( strpos($url, '?') !== false )
            {
                $uriArr = explode('?', $url );
                $url    = $uriArr[0];
            }

            if( $url == '/' )
            {
                $url = $this -> __url;
            }
            $url = str_replace('index.php','',$url);
            $urls = array_column( session() -> get('resource'), 'url' );
            //dd(session('resource'));
            // 公用控制器
            $common = array(
                '/Dashboard/index',
                '/Login/index',
                '/Login/out',
                '/Main/index',
                '/h5/index',
                '/h5/confirm',
                '/h5/qr_code'
            );

            if( !preg_in_array( $url, $urls ) && !in_array( $url, $common ) )
            {
                abort( 401 );
                exit();
            }
        }
    }

    /**
     * des: 避免重复登录
     */
    protected function forbidRelogin()
    {
        if( !empty( session('user') ) && $this -> __url === '/Login/index' )
        {
            redirect() -> action( 'MainController@index' ) -> send();
        }
    }

    /**
     * des: 框架页面公用输出变量
     * refer: https://docs.golaravel.com/docs/5.1/views/ 共享试图
     */
    protected function mainPageMsg()
    {
        # 用户数据
        $user = array(
            "id"    => session('user')['id'],
            "name"  => session('user')['username'],
            "role"  => "超级管理员",
            "icon"  => "/assets/img/profile_small.jpg"
        );

        # 导航数据
        $user_id = session('user')['id'];                                  // 获取用户id

        // 获取该用户的角色组
        try {
            $role_goup = $this -> __User_role -> getDataByKey( array(
                'where' => array(
                    'user_id'   => array(
                        'symbol'    => '=',
                        'value'     => $user_id
                    )
                )
            ), 'role_id');

            // 通过角色获取资源的节点集合
            $resource_group = $this-> __Role_resource -> getDataByKey( array(
                'wherein'   => array(
                    'role_id'   => array(
                        'value' => $role_goup
                    )
                )
            ), 'resource_id');

            // 获取节点信息
            $resource = $this -> __Resource -> getDatas( array(
                'wherein' => array(
                    'id' => array(
                        'value' => $resource_group
                    )
                )
            ) );

            // 仅取出导航
            $nav_part = [];
            foreach( $resource as $key => $res )
            {
                if( $res["is_navigation"] === 1 || $res["is_navigation"] === '1' || $res["is_navigation"] == 1)
                {
                    array_push( $nav_part, $res );
                }
            }
        }
        catch( \Exception $e )
        {
            $resource = [];
            $message = "显示导航失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
        }

        session() -> put( ['resource' => $resource] );
        $navs = fetchTree( $nav_part, 0 );          // 导航数据树状合成,缺少一个通知功能

        view()->share( 'user', $user );
        view()->share( 'navs', $navs );
        view()->share( 'title', '会议采购平台' );
    }

    /**
     * des: 公用页面公用输出变量
     */
    protected function commonPageMsg()
    {
        view()->share( 'copyright', [
                "skip"  => !empty( $_ENV['COPYRIGHT_SKIP'] ) ? $_ENV['COPYRIGHT_SKIP'] : 'javascript: void(0);',        // 读取配置文件中版权信息
                "limit" => !empty( $_ENV['COPYRIGHT_LIMIT'] ) ? $_ENV['COPYRIGHT_LIMIT'] : '2016-2017',
                "desc"  => !empty( $_ENV['COPYRIGHT_DESC'] ) ? $_ENV['COPYRIGHT_DESC'] : '北京会唐世纪科技有限公司'
            ]
        );
    }

    public function open_api() {
        set_time_limit(0);
        ini_set('memory_limit', '128M');
        config('links.client_id');
        $client_id          = config('links.client_id');  //OpenAPI client_id
        $client_secret      = config('links.client_secret'); //OpenAPI client_secret
        $security_code      = config('links.security_code'); //OpenAPI security_code
        $this->open_api_url = config('links.open_api_url');
        $this->eveClient    = new EveClient($client_id, $client_secret, $security_code);
        $this->token        = $this->eveClient->getTokenImplicit();
        $this->http         = new Http();
    }


    /**
     *  参会人员管理，服务商管理，常用参会人管理等模块的日志读取公共方法
     *  @param $where        array    where 条件  k=>v
     *  @param $order_buy   desc/asc 排序方式
     *  @param $colume      string   排序字段
     *  @param $num         int     一次要取出来的数量
     *  @param $page        T/F     是否分页
     *  @return collection
     *  @author Wind 2017-8-23 10:45:17
     */
    public function get_participant_log($where = array(),$order_buy = 'desc',$colume = 'id' ,$num = 10, $page = false)
    {

        $log_colume = ['id','rfp_id','belong','ip','type','content','node','create_time','join_id'];
        $where_str = ' 1=1 ';
        $where_arr = array();
        if( !empty($where))
        {
            foreach ($where as $col => $value)
            {
                if( in_array($col,$log_colume))
                {
                    $where_str .= " and ".$col.' = ? ';
                    $where_arr[] = $value;
                }else{
                    return false;
                }
            }
        }
       
   
        if( !is_string($order_buy) || (strtolower($order_buy) != 'desc' && strtolower($order_buy) != 'asc'))
        {
            return false;
        }
        if( !in_array($colume,$log_colume))
        {
            return false;
        }
        if( $page )
        {
            return $this ->  __Participant_log
                            -> leftJoin('users', 'participant_log.belong', '=', 'users.id')
                            -> select('participant_log.id','participant_log.content','users.login_name','participant_log.create_time')
                            -> whereRaw($where_str, $where_arr)
                            -> limit($num)
                            ->orderBy($colume,$order_buy)
                            -> paginate($num);

        }else {

            return $this->__Participant_log
                            -> leftJoin('users', 'participant_log.belong', '=', 'users.id')
                            -> select('participant_log.id','participant_log.content','users.login_name','participant_log.create_time')
                            -> whereRaw($where_str, $where_arr)
                            -> orderBy($colume, $order_buy)
                            -> limit($num)
                            ->get();
        }

    }
    public function setHeader( $data ){
        $secret = 'aea9857bd96b712f7777292aa493cecd'; // API分配的秘钥
        $token = '';
        $appName = 'eventown.com';  // 在API分配的APP名字
        if($data){
            foreach ($data as $d) {
                $token .= $d; // 拼接请求参数
            }
        }

        $token .= $appName; // 拼接请求APP名字
        $token .= $secret;  // 拼接API分配的秘钥
        $token = hash('SHA256', $token);
        $header = array(
            'token:'.$token,
            'app:'.$appName,

        );

        return $header;
    }
}

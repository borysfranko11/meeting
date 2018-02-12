<?php
/**
 * des: 有关系统访问逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

use Log;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;

// use Illuminate\Support\Facades\Session;     // 载入 session 组件(暂未使用,预留) Session::put( 'key', 'value' ); Session::all()


class LoginController extends Controller
{
    private $_User;
    private $_Logs;

    public function __construct()
    {
        parent::__construct();
        $this -> _User          = new User();
        $this -> _Logs    = new Logs();
    }

    // 登录
    public function index( Request $request )
    {
        // 分支判断
        if( $request -> isMethod( 'POST' ) )
        {
            $reqs = $request -> except( '_token' );

            // 过滤参数
            $reqs['name'] = filterParam( $reqs['name'] );

            // 获取所有用户的数据
            $user_group = $this -> _User -> getDatas( array(
                'where' => array(
                    'status' => array(
                        'symbol'=> '=',
                        'value' => 1
                    )
                )
            ) );

            $user_info = array();
            foreach( $user_group as $key => $value )
            {
                if( $value['login_name'] == $reqs['name'] && Hash::check( $reqs['password'], $value['password'] ) )
                {
                    $user_info = $value;
                    break;
                }
            }

            // 判断账号密码是否正确
            if( empty($user_info ) )
            {
                return back() -> with('error', 'error');
            }
            //获取用户权限role
            $user_info['role'] = $this -> _User ->getUserRole($user_info['id']);//二维数组，单个用户可能有多个分组

            $param = array(
                'content' => '用户【'.$user_info['id'].'】登录成功',
                'node' => $this-> __url,
                'extend' => json_encode(array('user_id'=>$user_info['id'])),
                'read' => '0',
                'type' => '0',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'belong' => $user_info['id'],
                'create_time' => time(),
            );
            // 写入登录日志
            try
            {
                $this -> _Logs -> insert( $param );
            }
            catch (\Exception $e)
            {
                //写入文本日志
                $message = "{$user_info['id']}登录,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
            }

            // 存储登录数据
            session( ["user" => $user_info] );

            $user_wap_url = $request->session()->pull('user_wap_url');
            if(!empty($user_wap_url)){
                return redirect($user_wap_url);
            }

            return redirect( '/' );
        }
        else
        {
            return view( '/login/index' );
        }
    }

    // 退出
    public function out( Request $request )
    {
        $param = array(
            'content' => '用户【'.session('user')['id'].'】退出登录',
            'node' => $this-> __url,
            'extend' => json_encode(array('user_id'=>session('user')['id'])),
            'read' => '0',
            'type' => '0',
            'ip' => $_SERVER["REMOTE_ADDR"],
            'belong' => session('user')['id'],
            'create_time' => time(),
        );
        try
        {
            // 添加退出日志
            $this -> _Logs -> insert( $param );
            $request -> session() -> flush();
            $request -> session() -> save();

            redirect() -> action( 'LoginController@index' ) -> send();
            exit();
        }
        catch( \Exception $e )
        {
            //写入文本日志
            $message = "{".session('user')['id']."}退出,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );

            return redirect( '/Login/index' );
        }
    }

    // demo 
    public function qrcode()
    {
        return view('qrcode');
    }

    //设置语言包
    public function ins(Request $request){

        $data = $request->all();

        if(isset($data['language']) && !empty($data['language'])){
            App::setLocale($data['language']);
            session( [ 'language' => $data['language'] ] );
        }else {
            App::setLocale(config('app.fallback_locale'));
            session( [ 'language' => config('app.fallback_locale') ] );
        }
        return json_encode(array('status'=>true));
    }


        }

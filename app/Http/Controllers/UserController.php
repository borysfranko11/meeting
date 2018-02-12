<?php
/**
 * des: 有关用户逻辑处理的控制器
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Log;
use Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Marketorg;
use App\Models\Role;
use App\Models\UserRole;

class UserController extends Controller
{
    private $_User;
    private $_User_role;
    private $_Role;
    private $_Marketong;

    public function __construct()
    {
        parent::__construct();

        $this -> _User = new User();
        $this -> _User_role = new UserRole();
        $this -> _Role = new Role();
        $this -> _Marketong = new Marketorg();
    }

    /**
     * des: 用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @refer: About json response
     *          https://laravel.com/docs/5.1/responses#json-responses
     *          About {{}} and {!! !!} explain
     *          https://laravel.com/docs/5.1/blade#displaying-data
     */
    public function index( Request $request )
    {
        // 分支判断
        if( $request -> isMethod( 'POST' ) )
        {
            $reqs = $request -> except( '_token' );
        }

        //获取所有用户数据
        $user       = $this -> _User -> getDatas();
        $userRole   = $this -> _User_role -> getDataByKey();
        $role       = $this -> _Role -> getDatas();
        $marketorg  = $this -> _Marketong -> getDatas();

        //组装用户数据
        /**
         * eg: [
                "id" => "100102",
                "login_name" => "Ht_wang",
                "name" => "wang",
                "status" => "2",
                "role" => [
                    ["id"=>"2","name" => "会议发起员"],
                    ["id"=>"5","name" => "角色管理员"]
                ],
                "center" => ["id"=>"10001","name" => "成本中心1"],
                "phone" => "18614066666",
                "email" => "liying_wang@eventown.com"
                ],
         */
        foreach( $user as $keys => $values )
        {
            foreach( $userRole as $key => $value )
            {
                if( $values['id'] == $value['user_id'] )
                {
                   foreach( $role as $k => $v )
                   {
                       if( $value['role_id'] == $v['id'] )
                       {
                           $user[$keys]['role'][] = [ 'id' => $v['id'], 'name' => $v['name'] ];
                       }
                   }
                }
            }
            //成本中心
            $user[$keys]['center'] = array(
                'id' => $user[$keys]['marketorgcode'],
                'name' => $user[$keys]['marketorgdesc']
            );
        }

        return view( '/user/index', ["user_list" => json_encode( $user ), 'role_list' => $role,  'marketorg_list' => $marketorg] );
    }

    /**
     * des: 用户添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function increase( Request $request )
    {
        // 分支判断
        if( $request -> isMethod( 'POST' ) )
        {
            $reqs = $request -> except( '_token' );
            $user_params = [
                "login_name" => $reqs["account"],
                "username" => $reqs["username"],
                "password" => Hash::make( $reqs["password"] ),
                "status" => 1,
                "phone" => $reqs["mobile"],
                "email" => $reqs["email"],
                "created_time" => date( 'Y-m-d H:i:s', time() ),
                "marketorgcode" => $reqs["code"],
                "marketorgdesc" => $reqs["code_name"],
            ];

            try
            {
                $user_added = $this -> _User -> insertDatas( $user_params );
            }
            catch( \Exception $e )
            {
                // 写入文本日志
                $message = "{$user_params['account']}用户修改失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );

                return back() -> with( 'error', 'error' );
            }

            // 用户添加成功
            if( $user_added )
            {
                $relation_params = [
                    "user_id"   => $user_added,
                    "role_id"   => $reqs["role"]
                ];

                try
                {
                    $relationed = $this -> _User_role -> insertDatas( $relation_params );
                }
                catch( \Exception $e )
                {
                    // 写入文本日志
                    $message = "{$user_params['account']}用户修改失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert( $message );

                    return back() -> with( 'error', 'error' );
                }

                return returnJson(true,'','用户添加成功' );
            }
        }
        else
        {
            $roles = $this -> _Role -> getDatas( [
                'where' => array(
                    'status' => array(
                        'symbol'    => '=',
                        'value'     => 1
                    )
                )
            ] );

            $data = [
                "roles" => $roles
            ];

            return view( '/user/increase', ["data" => json_encode( $data )] );
        }
    }

    /**
     * des: 用户验证方法
     * @param Request $request
     * @return string
     */
    public function verify( Request $request )
    {
        $reqs = $request -> except( '_token' );
        $action = $reqs["action"];
        $value = $reqs[$action];
        $result = 'false';

        $oper = array(
            "account" => function ( $name ) use ( $value )
            {
                return $this -> verifyAccount( $name );
            }
        );

        // 避免因键值不存在的报错
        if( !empty( $oper[$action] ) )
        {
            if( ( boolean )$oper[$action]( $value ) )
            {
                $result = 'true';
            }
        }

        return $result;
    }

    /**
     * des: 检查用户名是否已经使用
     * @param $name
     * @return bool
     */
    private function verifyAccount( $name )
    {
        $result = false;

        if( !empty( $name ) )
        {
            $if_existed = $this -> _User -> getDatas( [
                'where' => array(
                    'login_name' => array(
                        'symbol'    => '=',
                        'value'     => $name
                    )
                )
            ] );

            // 未使用过返回
            if( count( $if_existed ) == 0 )
            {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * des: 编辑用户基本信息
     * @param Request $request
     * @return mixed
     */
    public function editMsg( Request $request )
    {
        // 分支判断
        if( $request -> isMethod( 'POST' ) )
        {
            $reqs = $request -> except( '_token' );
            // 过滤参数
            $param['user_id']           = filterParam( $reqs['user_id'] );
            $param['edit_user_status']  = filterParam( $reqs['edit_user_status'] );
            $param['edit_user_role']    = filterParam( $reqs['edit_user_role'] );
            $param['edit_user_center']  = filterParam( $reqs['edit_user_center'] );
            $param['edit_center_name']  = filterParam( $reqs['edit_center_name'] );

            $param['updated_time']= date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME'] );
            // 修改数据  开启事务 refer:http://blog.csdn.net/sanbingyutuoniao123/article/details/54342086
            DB::beginTransaction();
            try
            {
                // 修改用户信息 <==============用户修改信息如果不修改成本中心则失败=================>
                $this -> _User -> updateDatas( array(
                    'where' => array(
                        'id' => array(
                            'symbol'    => '=',
                            'value'     => $param['user_id']
                        )
                    )
                ), array(
                    'status'        => $param['edit_user_status'],
                    'marketorgcode' => $param['edit_user_center'],
                    'marketorgdesc' => $param['edit_center_name'],
                    'updated_time'  => $param['updated_time']
                ) );

                // 删除角色信息
                $this -> _User_role -> deleteDatas(array(
                    'where' => array(
                        'user_id' => array(
                            'symbol'    => '=',
                            'value'     => $param['user_id']
                        )
                    )
                ));

                // 插入新的角色信息
                foreach( $param['edit_user_role'] as $k => $v )
                {
                    $this -> _User_role -> insertDatas( array(
                        'user_id' => $param['user_id'],
                        'role_id' => $v
                    ) );
                }

                DB::commit();
                return redirect( '/User/index' ) -> with( 'success', 'success' );
            }
            catch( \Exception $e )
            {
                // 写入文本日志
                $message = "{$param['user_id']}用户修改失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert( $message );
                DB::rollBack();
                return back() -> with( 'error', 'error' );
            }
        }
    }

    public function profile()
    {
        dd( '修改头像(名片操作)' );
    }

    public function personal()
    {
        dd( '个人资料' );
    }
}

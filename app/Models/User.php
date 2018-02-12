<?php
/**
 * Created by PhpStorm.
 * User: ChanningWay
 * Date: 2017/7/7
 * Time: 10:24
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class User extends Base
{

    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'users';
        $this -> _link = DB::table( $this -> _table );
    }

    /**
     * des:获取所有用户信息
     * @param $conditions
     * @return mixed
     */
    public function getDatas( $conditions=[] )
    {
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();
    }

    public function updateDatas( $conditions, $param )
    {
        $this -> parseRouter( $conditions );
        return $this -> _link -> update( $param );
    }

    //多表连接查询用户权限
    public function getUserRole($userid){
      return  DB::table( $this -> _table )
                    ->leftJoin('user_role as r', 'users.id', '=', 'r.user_id')
                    ->leftJoin('roles as s', 'r.role_id', '=', 's.id')
                    ->select('r.role_id','s.name')
                    ->where('users.id','=',$userid)
                    ->get();
    }

    /**
     * des:添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        $result = $this -> _link -> insertGetId( $params );

        return $result;
    }

    public function getDemoDatas()
    {
        $result = array(
            [
                "id" => "100101",
                "login_name" => "Ht_pu",
                "name" => "pu",
                "status" => "1",
                "role" => [
                    ["id"=>"2","name" => "会议发起员"]
                ],
                "center" => "4",
                "phone" => "18614055555",
                "email" => "hongjie_pu@eventown.com"
            ],
            [
                "id" => "100102",
                "login_name" => "Ht_wang",
                "name" => "wang",
                "status" => "2",
                "role" => [
                    ["id"=>"2","name" => "会议发起员"],
                    ["id"=>"5","name" => "角色管理员"]
                ],
                "center" => "3",
                "phone" => "18614066666",
                "email" => "liying_wang@eventown.com"
            ],
            [
                "id" => "100103",
                "login_name" => "Ht_yan",
                "name" => "yan",
                "status" => "3",
                "role" => [
                    ["id"=>"2","name" => "会议发起员"],
                    ["id"=>"3","name" => "费用审核员"],
                    ["id"=>"4","name" => "日志管理员"],
                    ["id"=>"5","name" => "角色管理员"]
                ],
                "center" => "2",
                "phone" => "18614077777",
                "email" => "congwei_yan@eventown.com"
            ],
            [
                "id" => "100104",
                "login_name" => "Ht_other",
                "name" => "other",
                "status" => "4",
                "role" => [
                    ["id"=>"6","name" => "超级管理员"]
                ],
                "center" => "1",
                "phone" => "18614088888",
                "email" => "people_other@eventown.com"
            ]
        );

        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: channingWay
 * Date: 2017/7/11
 * Time: 15:23
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserRole extends Base
{

    public function __construct()
    {
        parent::__construct();

        $this -> _table = "user_role";

        $this -> _link = DB::table( $this ->_table );
    }

    /**
     * des:根据字段获取数据
     * @param $conditions [type|array] 条件
     * @param string $key [type|string] 字段名
     * @return array
     */
    public function getDataByKey( $conditions=[], $key="" )
    {
        $this -> parseRouter( $conditions );

        if( empty( $key ) )
        {
            return $this -> _link -> get();
        }
        else
        {
            return  $this -> _link -> lists( $key );
        }
    }

    /**
     * des:添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insertGetId( $params );
    }

    /**
     * des:删除数据
     * notice: 不能执行循环删除   <==================================>
     * @param $conditions [type|array] 条件
     * @return mixed
     */
    public function deleteDatas( $conditions )
    {
        $this -> parseRouter( $conditions );
        return $this -> _link -> delete();
    }



}
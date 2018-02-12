<?php
/**
 * Created by PhpStorm.
 * User: channingWay
 * Date: 2017/7/11
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class RoleResource extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "role_resource";

        $this -> _link  = DB::table( $this -> _table );
    }

    /**
     * des:根据字段获取数据
     * @param $conditions [type|array] 条件
     * @param string $key [type|string] 字段名
     * @return array
     */
    public function getDataByKey( $conditions, $key="" )
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

}
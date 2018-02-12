<?php
/**
 * Created by PhpStorm.
 * User: channingWay
 * Date: 2017/7/7
 * Time: 18:47
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class LoginLogs extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'login_logs';
        $this -> _link  = DB::table( $this -> _table );
    }

    /**
     * des 写入日志
     * @param $param [type|array] 参数
     * @return mixed
     */
    public function insert( $param )
    {
        return $this -> _link -> insert( $param );
    }
}
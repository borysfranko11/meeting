<?php
/**
 * Created by PhpStorm.
 * User: channingWay
 * Date: 2017/7/7
 * Time: 18:47
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Logs extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'log';
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
    //添加操作日志
    public function addLog($basic,$rfp_id,$content,$url){
        $log_data = array(
            'content'       => $content,
            'node'          => $url,
            'extend'        => json_encode(array('rfp_id'=>$rfp_id)),
            'read'          => '0',
            'type'          => '1',
            'ip'            => $_SERVER["REMOTE_ADDR"],
            'belong'        => $basic['user_code'],
            'create_time'   => time(),
        );
        $this -> _link->insert($log_data);
    }
}
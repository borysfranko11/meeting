<?php
    /**
     * Created by PhpStorm.
     * User: ChaningWay
     * Date: 2017/7/5
     * Time: 14:56
     */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class ParticipantLog extends Base
{

    protected $table = 'participant_log';
    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'participant_log';
        $this -> _link  = DB::table( $this -> _table );
    }

    /**
     * des 写入 参会人管理/服务商/常用参会人 日志
     * @param $param [type|array] 参数
     * @return mixed
     */
    public function insert( $param )
    {
        return $this -> _link -> insert( $param );
    }
}



<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserNotice extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "user_notice";
        $this -> _link  = DB::table( $this->_table );
    }

    /**
     * des:获取所有询单信息
     * @param $conditions
     * @return mixed
     */
    public function getDatas( $conditions )
    {
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();

    }

    /**
     * des:添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insert( $params );
    }


}
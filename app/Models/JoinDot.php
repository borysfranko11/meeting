<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\23 0023
 * Time: 14:53
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class JoinDot extends Base
{
    protected  $table = 'join_dot';
    public function __construct()
    {

        parent::__construct();

        $this -> _table = "join_dot";
        $this -> _link  = DB::table( $this->_table );
    }
    /**
     * des:获取所有询单信息
     * @param $conditions
     * @return mixed
     */
    public function getDatas( )//$conditions )
    {
        //$this -> parseRouter( $conditions );
        $rfps = $this -> _link -> get();
        return $rfps;

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

    public function getDot( $rfpId )
    {
        //数据逻辑
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfpId
            ]
        ] ];
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();

    }
    public function del( $rfp_id ){
        return $this -> _link -> where('rfp_id', '=', $rfp_id )->delete();
    }

}
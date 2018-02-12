<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class RfpPerform extends Base
{

    protected  $table = 'rfp_perform';
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "rfp_perform";
        $this -> _link  = DB::table( $this->_table );
    }

    /**
     * des:获取所有信息
     * @param $conditions
     * @return mixed
     */
    public function getDatas( $conditions )
    {
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();

    }

    /**
     * des:获取一条信息
     * @param $conditions
     * @return mixed
     */
    public function getDetail( $rfpId )
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

    /**
     * des:添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insert( $params );
    }

    /**
     * des:更新数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function updateDatas( $conditions,$params )
    {
        $this -> parseRouter( $conditions );
        return $this -> _link -> update( $params );
    }



}
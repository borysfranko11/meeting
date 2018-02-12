<?php
    /**
     * Created by PhpStorm.
     * User: ChaningWay
     * Date: 2017/7/5
     * Time: 14:56
     */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Rfp extends Base
{
    protected  $table = 'rfp';
    public function __construct()
    {

        parent::__construct();

        $this -> _table = "rfp";
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
     * des:获取一条询单信息
     * @param $conditions
     * @return mixed
     */
    public function getRfpDetail( $rfpId )
    {
        //数据逻辑
        /*$conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfpId
            ]
        ] ];
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();*/

        return DB::table($this -> _table)
            ->leftJoin('users', 'users.id', '=', $this -> _table.'.user_code')
            ->where($this -> _table.'.rfp_id', '=', $rfpId)
            ->get();

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
     * des:更新数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function updateDatas( $conditions,$params )
    {
        /*$this -> parseRouter( $conditions );
        return $this -> _link -> update( $params );*/
        return DB::table( $this->_table ) -> where('rfp_id', $conditions) ->update($params);

    }
    /**
     * des:获取一条询单信息
     * @param $conditions
     * @return mixed
     */
    public function getRfpByRfpid( $rfpId )
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

}
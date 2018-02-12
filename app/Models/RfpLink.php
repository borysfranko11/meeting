<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class RfpLink extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "rfp_link";
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

    //询单服务商关联时添加
    public function getNameId($rfp_id,$s_id,$head_id)
    {
        $this -> _link -> insert(['s_id'=>$s_id,'rfp_id'=>$rfp_id,'role_id'=>session("user")['id'],'create_time'=>date('Y-m-d H:i:s',time()),'seavers_staff_id'=>$head_id]);
    }

    //查询询单是否关联服务商
    public function getHeadId()
    {
        $rfp_id = $this->_link->get();
        return $rfp_id;
    }

    /**
     * des:获取一条询单信息
     * @param $conditions
     * @return mixed
     */
    public function getRfpDetail( $rfpId )
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
        return $this -> _link -> insertGetId( $params );
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
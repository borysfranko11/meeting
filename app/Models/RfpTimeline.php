<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class RfpTimeline extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "rfp_timeline";
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

    //添加项目进度
    public function  addTimeline($rfp_id,$step){
        $timeline = array(
            'rfp_id'            => $rfp_id,
            'step'              => $step,
            'step_name'         => config('timeline.timeline.'.$step),
            'completed_time'    => time(),
        );
        return $this -> _link->insert($timeline);
    }

}
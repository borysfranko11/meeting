<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class RfpRoom extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "rfp_room";
        $this -> _link  = DB::table( $this->_table );
    }

    public function updateDatas( $conditions,$params )
    {
        /*$this -> parseRouter( $conditions );
        return $this -> _link -> update( $params );*/
        return DB::table( $this->_table ) -> where('room_id', $conditions) ->update($params);

    }

    /**
     * des:批量添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insert( $params );
    }

    public function getRfpRoom( $rfpId )
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

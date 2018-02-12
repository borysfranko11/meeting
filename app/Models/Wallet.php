<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Wallet extends Model
{
    protected  $table = 'bind_card';
    public function __construct()
    {

        parent::__construct();

        $this -> _table = "bind_card";
        $this -> _link  = DB::table( $this->_table );
    }
    public function getDatas( )//$conditions )
    {
        //$this -> parseRouter( $conditions );
        $rfps = $this -> _link -> get();
        return $rfps;

    }
    //
    /**
     * des:添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insertGetId( $params );
    }
}

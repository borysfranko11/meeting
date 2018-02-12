<?php

namespace App\Models;

use App\Models\Base;
use Illuminate\Support\Facades\DB;

class Resource extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this -> _table = "resources";
        $this -> _link  = DB::table( $this -> _table );

    }

    /**
     * des:获取数据
     * @param $conditions [type|array] 条件
     * @return mixed
     */
    public function getDatas( $conditions )
    {
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();
    }
}

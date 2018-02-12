<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Role extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'roles';
        $this -> _link  = DB::table( $this -> _table );
    }

    /**
     * des:获取数据
     * @param $condition [type|array] 条件
     * @return mixed
     */
    public function getDatas( $condition=[] )
    {
        $this -> parseRouter( $condition );

        return $this -> _link -> get();
    }
}

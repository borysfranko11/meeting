<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UseCarInfo extends Base
{
    //
    protected  $table = 'use_car_info';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();
        $this -> _table = $this->table;
        $this -> _link  = DB::table( $this->table );
    }
}






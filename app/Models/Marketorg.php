<?php
/**
 * Created by PhpStorm.
 * User: ChanningWay
 * Date: 2017/7/14
 * Time: 14:23
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Marketorg extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = 'marketorg';
        $this -> _link  = DB::table( $this -> _table );
    }

    public function getDatas( $condition=[] )
    {
        $this -> parseRouter( $condition );

        return $this -> _link -> get();
    }
}
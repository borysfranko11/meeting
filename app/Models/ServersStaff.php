<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
class ServersStaff extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "servers_staff";
        $this -> _link  = DB::table( $this->_table );
    }
}

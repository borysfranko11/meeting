<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
class Staff extends Base
{
    protected $primaryKey = 'id';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "seavers_staff";
        $this -> _link  = DB::table( $this->_table );
    }

    public function getDatas()//$conditions )
    {
        //$this -> parseRouter( $conditions );
        $servers = $this -> _link -> get();
        return $servers;
    }

    public function getHead()
    {
        $head = $this->_link->get();
        return $head;
    }
}

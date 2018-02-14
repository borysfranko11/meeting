<?php
/**
 * Created by PhpStorm.
 * User: Borys
 * Date: 2/13/2018
 * Time: 7:45 PM
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Mobileloginlog extends Base
{
    protected  $table = 'mobile_login_log';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();
        $this -> _table = $this->table;
        $this -> _link  = DB::table( $this->table );
    }

    public  function insertDatas($params) {
        return $this -> _link -> insert( $params );
    }

    public  function updateDatas($param) {

    }

}
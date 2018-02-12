<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\23 0023
 * Time: 14:53
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class JoinUsers extends Base
{
    protected $primaryKey = 'join_id';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();
//        $this -> _parimaryKey = $this->parimaryKey;
        $this -> _table = "join_users";
        $this -> _link  = DB::table( $this->table );
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\23 0023
 * Time: 15:32
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ConfirmUserInfo extends Base
{

    protected  $table = "confirm_user_info";
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();

        $this -> _table = $this->table;
        $this -> _link  = DB::table( $this->table );
    }
    public function join_users()
    {
        return $this->belongsTo('App\Models\JoinUsers','join_id');
    }


}
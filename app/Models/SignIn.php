<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\23 0023
 * Time: 15:34
 */

namespace App\Models;



use Illuminate\Support\Facades\DB;
class SignIn extends Base
{
    protected  $table = 'sign_in';
    public function __construct()
    {
        parent::__construct();
        $this -> _table = $this->table;
        $this -> _link  = DB::table( $this->table );
    }

    /**
     * 获取签到人对应的用户信息
     */
    public function join_users()
    {
        return $this->belongsTo('App\Models\JoinUsers','join_id');
    }


    public function signin()
    {
        return $this->hasOne('App\Models\JoinUsers','join_id'); //('App\Phone', 'foreign_key', 'local_key');
    }


}
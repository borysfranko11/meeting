<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class InvitationTpl extends Base
{
    protected  $table = 'invitation_tpl';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();
        $this -> _table = "invitation_tpl";
        $this -> _link  = DB::table( $this->table );
    }


}
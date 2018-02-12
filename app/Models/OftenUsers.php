<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;
use Illuminate\Support\Facades\DB;
class OftenUsers extends Base
{
    protected $primaryKey = 'often_id';
    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    public function __construct()
    {
        parent::__construct();
//        $this -> _parimaryKey = $this->parimaryKey;
        $this -> _table = "often_users";
        $this -> _link  = DB::table( $this->table );
    }

    /**
     * des:获取所有询单信息
     * @param $conditions
     * @return mixed
     */
    public function getDatas( $where = array() )
    {        

        return $this -> _link -> select('select * from users where id = ?', [1]);;

    }

 
}


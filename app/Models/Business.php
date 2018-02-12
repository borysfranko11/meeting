<?php
/**
 * Created by PhpStorm.
 * User: ChaningWay
 * Date: 2017/7/5
 * Time: 14:56
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Business extends Base
{
    protected $connection = 'mysql_business';

    public function __construct()
    {
        parent::__construct();
        $this -> _link  =DB::connection($this->connection)->table( 'yrfp_offer' );
        $this -> _link_map  = DB::connection($this->connection)->table( 'yrfp_map' );
    }

    public function get_yrfp_offer_Datas( $map_id )
    {

        return $this -> _link -> where('map_id', $map_id) -> first();

    }
    public function get_yrfp_map_Datas( $place_id )
    {

        return $this -> _link_map -> where( [ 'invite_id' => 118 , 'place_id' => $place_id ] ) -> first();

    }

}
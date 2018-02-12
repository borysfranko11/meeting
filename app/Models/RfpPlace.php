<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;
use App\Libs\EveClient;
use App\Libs\Http;
class RfpPlace extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this -> _table = "rfp_place";
        $this -> _link  = DB::table( $this->_table );
        $this -> EveClient      = new EveClient();
    }

    public function updateDatas( $conditions,$params )
    {
        return DB::table( $this->_table ) -> where('rfp_place_id', $conditions) ->update($params);
    }

    public function updateDatasBySet( $key, $value, $params )
    {
        return DB::table( $this->_table ) -> where($key, $value) ->update($params);
    }

    /**
     * des:批量添加数据
     * @param $params [type|array] 参数
     * @return mixed
     */
    public function insertDatas( $params )
    {
        return $this -> _link -> insert( $params );
    }

    public function getRfpPlace( $rfpId )
    {
        //数据逻辑
        $conditions = [ 'where' => [
            'rfp_id' => [
                'symbol'    => '=',
                'value'     => $rfpId
            ]
        ] ];
        $this -> parseRouter( $conditions );

        return $this -> _link -> get();

    }

    public function getAreaCity( $cityId ){

        $this->open_api();
        $array['signature'] = $this->EveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = $cityId;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getAreaCity?', $array, $this->token);


        return $result;
    }

    public function getProvinces(){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign();
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getProvinces?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }
    public function getCityNameById( Request $request ){
        $reqs = $request -> except( '_token' );
        $cityId = isset($reqs['cityId'])?$reqs['cityId']:'1';
        $this->open_api();
        $array['signature'] = $this->EveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = [$cityId];
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getCityNameById?', $array, $this->token);
        if($result){
            $result = json_decode($result, true);
            $this->return['Success'] = true;
            $this->return['Data']    = $result;
            $this->return['Msg']     = '';
            $result = json_encode($this->return, true);
        }

        return $result;
    }

    public function getHotBusinessDistrict( $cityId ){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign(array( 'cityId'=>$cityId ));
        $array['cityId'] = 1;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getHotBusinessDistrict?', $array, $this->token);
        return $result;
    }
    public function getDisplayAirport( $cityId ){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = 1;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getDisplayAirport?', $array, $this->token);

        return $result;
    }
    public function getDisplayTrainStation( $cityId ){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = 1;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getDisplayTrainStation?', $array, $this->token);

        return $result;
    }
    public function getMetroLines( $cityId ){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign(array('cityId'=>$cityId));
        $array['cityId'] = 1;
        $result             = $this->http->httpget(config( 'links.open_api_url' ) . '/place/getMetroLines?', $array, $this->token);

        return $result;
    }
    public function open_api() {
        set_time_limit(0);
        ini_set('memory_limit', '128M');
        config('links.client_id');
        $client_id          = config('links.client_id');  //OpenAPI client_id
        $client_secret      = config('links.client_secret'); //OpenAPI client_secret
        $security_code      = config('links.security_code'); //OpenAPI security_code
        $this->open_api_url = config('links.open_api_url');
        $this->eveClient    = new EveClient($client_id, $client_secret, $security_code);
        $this->token        = $this->eveClient->getTokenImplicit();
        $this->http         = new Http();
    }
}

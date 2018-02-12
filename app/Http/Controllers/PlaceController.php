<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Yar_Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RfpPlace;

class PlaceController extends Controller
{
    public $return = ['Success' => true,'Msg'=> '', 'Data' => ''];
    public function __construct()
    {
        parent::__construct();

        $this -> _RfpPlace      = new RfpPlace();
        $this -> _Business      = new Business();

    }
    /*public function getPlaceBySearch( Request $request ){
        $reqs = $request -> except( '_token' );

        $searchData['city_id']     = isset($reqs['area']['city_id']) ? $reqs['area']['city_id'] : 1;
        $searchData['place_type']  = isset($reqs['area']['type']) ? $reqs['area']['type'] : '';
        $searchData['place_star']  = isset($reqs['area']['star']) ? $reqs['area']['star'] : '';
        $searchData['position']    = isset($reqs['area']['location']) ? $reqs['area']['location'] : '';
        $searchData['key_words']   = isset($reqs['key_words']) ? $reqs['key_words'] : '';
        $searchData['page']        = isset($reqs['page']) ? $reqs['page'] : '';

        $searchData = self::clearNull($searchData);

        $url = config('links.palce_api').'/search';

        $res = doCurlGetRequest($url, $searchData);
        //$res = self::localClear( json_decode( $res, true ) );
        $this->return['Data'] = $res;

        echo json_encode($this->return);
    }*/

    public function getPlaceBySearch( Request $request ){
        $reqs = $request -> except( '_token' );

        $searchData['city_id']              = $reqs['cityId'] ? $reqs['cityId'] : 1;
        $searchData['place_type']           = $reqs['type'] ? $reqs['type'] : '';
        $searchData['place_star']           = $reqs['star'] ? $reqs['star'] : '';
        $searchData['position']             = isset($reqs['location']) ? $reqs['location'] : '';
        $searchData['location']             = $reqs['lct'] ? $reqs['lct'] : '';
        $searchData['is_window']            = $reqs['is_window'] ? $reqs['is_window'] : '';
        $searchData['layout']               = $reqs['layout'] ? $reqs['layout'] : '';
        $searchData['is_column']            = $reqs['is_column'] ? $reqs['is_column'] : '';
        $searchData['people_num']           = $reqs['place_people_num'] ? $reqs['place_people_num'] : '';
        $searchData['price']                = isset($reqs['price']) ? $reqs['price'] : '';
        $searchData['area']                 = $reqs['area'] ? $reqs['area'] : '';

        $searchData['place_people_num']     = $searchData['people_num'] ? config('system.place_people_num')[$searchData['people_num']]['min'] : '';
        $searchData['place_people_max']     = $searchData['people_num'] ? config('system.place_people_num')[$searchData['people_num']]['max'] : '';
        $searchData['meeting_room_min_price']     = $searchData['price'] ? config('system.price')[$searchData['price']]['min'] : '';
        $searchData['meeting_room_max_price']     = $searchData['price'] ? config('system.price')[$searchData['price']]['max'] : '';

        $searchData['area_min']             = $searchData['area'] ? config('system.area')[$searchData['area']]['min'] : '';
        $searchData['area_max']             = $searchData['area'] ? config('system.area')[$searchData['area']]['max'] : '';

        //$searchData['sort']                 = isset($reqs['sort']) ? $reqs['sort'] : '';
        $searchData['key_words']            = isset($reqs['keyword']) ? $reqs['keyword'] : '';
        $searchData['page']                 = isset($reqs['page']) ? $reqs['page'] : '';
        $searchData['key_words']            = urldecode($searchData['key_words']);
        unset($searchData['area']);
        unset($searchData['people_num']);
        $searchData = self::clearNull($searchData);

        $url = config('links.palce_api').'/search';

        $res = doCurlGetRequest($url.'/v2', $searchData);

        //排除协议酒店
        $notInIds = '';
        $res = json_decode($res, true);
        if(!empty($res['rows'])) foreach($res['rows'] AS $key => $value){
            $notInIds .= $value['old_place_id'].',';
        }

        $searchData['display_place_ids'] = $notInIds ? substr($notInIds, 0, -1) : '';


        $res = doCurlGetRequest($url, $searchData);
        $res = json_decode($res, true);
        $mapJson = [];
        if($res['total'] > 0){
            foreach($res['rows'] AS $key => $value){
                $map                = [];
                $location           = [];
                $map['place_id']    = $value['place_id'];
                $map['place_name']  = $value['place_name'];
                $location           = explode(',', $value['location']);
                $map['lat']         = isset($location[0])?$location[0]:'';
                $map['lng']         = isset($location[1])?$location[1]:'';
                $mapJson[]          = $map;
                $res['rows'][$key]['main_pic_url']  = isset($value['main_pic_url'])?get_img_url($value['main_pic_url']).$value['main_pic_url']:'';
            }
            $res['mapJson'] = $mapJson;
        }else{
            $res['mapJson'] = [];
            $res['total']   = 0;
        }

        $res = json_encode($res);



        $this->return['Data'] = $res;

        echo json_encode($this->return);
    }

    public function getPlaceBySearchMain( Request $request ){
        $reqs = $request -> except( '_token' );

        $searchData['city_id']              = isset($reqs['cityId']) ? $reqs['cityId'] : 1;
        $searchData['place_type']           = isset($reqs['type']) ? $reqs['type'] : '';
        $searchData['place_star']           = isset($reqs['star']) ? $reqs['star'] : '';
        $searchData['position']             = isset($reqs['location']) ? $reqs['location'] : '';
        $searchData['location']             = isset($reqs['lct']) ? $reqs['lct'] : '';
        $searchData['is_window']            = isset($reqs['is_window']) ? $reqs['is_window'] : '';
        $searchData['layout']               = isset($reqs['layout']) ? $reqs['layout'] : '';
        $searchData['is_column']            = isset($reqs['is_column']) ? $reqs['is_column'] : '';
        $searchData['people_num']           = isset($reqs['place_people_num']) ? $reqs['place_people_num'] : '';
        $searchData['price']                = isset($reqs['price']) ? $reqs['price'] : '';
        $searchData['area']                 = isset($reqs['area']) ? $reqs['area'] : '';

        $searchData['place_people_num']     = $searchData['people_num'] ? config('system.place_people_num')[$searchData['people_num']]['min'] : '';
        $searchData['place_people_max']     = $searchData['people_num'] ? config('system.place_people_num')[$searchData['people_num']]['max'] : '';
        $searchData['meeting_room_min_price']     = $searchData['price'] ? config('system.price')[$searchData['price']]['min'] : '';
        $searchData['meeting_room_max_price']     = $searchData['price'] ? config('system.price')[$searchData['price']]['max'] : '';

        $searchData['area_min']             = $searchData['area'] ? config('system.area')[$searchData['area']]['min'] : '';
        $searchData['area_max']             = $searchData['area'] ? config('system.area')[$searchData['area']]['max'] : '';

        //$searchData['sort']                 = isset($reqs['sort']) ? $reqs['sort'] : '';
        $searchData['key_words']            = isset($reqs['keyword']) ? $reqs['keyword'] : '';
        $searchData['page']                 = isset($reqs['page']) ? $reqs['page'] : '';
        $searchData['key_words']            = urldecode($searchData['key_words']);
        unset($searchData['area']);
        unset($searchData['people_num']);
        $searchData = self::clearNull($searchData);

        $url = config('links.palce_api').'/search/v2';


        $res = doCurlGetRequest($url, $searchData);
        $res = json_decode($res, true);
        $mapJson = [];
        if($res['total'] > 0){
            foreach($res['rows'] AS $key => $value){
                $map                = [];
                $location           = [];
                $map['place_id']    = $value['place_id'];
                $map['place_name']  = $value['place_name'];
                $location           = explode(',', $value['location']);
                $map['lat']         = $location[0];
                $map['lng']         = $location[1];
                $mapJson[]          = $map;
                $res['rows'][$key]['main_pic']  = $value['main_pic']?get_img_url($value['main_pic']).$value['main_pic']:'';
                if(isset($value['pics'][0]) && $res['rows'][$key]['main_pic'] == ''){
                    $res['rows'][$key]['main_pic'] = $value['pics'][0]['pic_url'];
                }

            }

            $res['mapJson'] = $mapJson;
        }else{
            $res['mapJson'] = [];
            $res['total']   = 0;
        }

        $res = json_encode($res);



        $this->return['Data'] = $res;

        echo json_encode($this->return);
    }

    /*private static function localClear( $res ){
        if( $res['count'] >0 ){
            foreach( $res['count'] AS $key => $value ){

            }
        }
    }*/

    public function setHotel( Request $request ){
        $reqs = $request -> except( '_token' );
        $placeInfo = json_decode($reqs['place'], true);
        if(!empty($placeInfo)){
            $reqs['place'] = $this->checkPlace($placeInfo);
            //print_r($reqs['place']);exit;
        }
        $this -> _RfpPlace -> updateDatasBySet( 'rfp_id', $reqs['rfp_id'], ['place_id_and_name_json' => $reqs['place']] );
        $this->return['Success'] = true;
        $this->return['Data']    = '';
        $this->return['Msg']     = '成功';
        echo json_encode($this->return);
    }
    private function checkPlace(array $placeInfo){
        foreach($placeInfo as $key => $value){
            $url            = config('links.palce_api').'/q/v2?id='.$value['place_id'];
            $res            = json_decode(doCurlGetRequest($url), true);
            $oid            = isset($res['old_place_id']) && $res['old_place_id'] ? $res['old_place_id'] : $value['place_id'];
            $placeInfo[$key]['place_id'] = $oid;

        }
        return json_encode($placeInfo);
    }
    public function rehtml($data){
        $data = preg_replace("/<em([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/em>/i", "", $data);
        $data = preg_replace("/<img([^>]+)?>/i", "", $data);
        $data = preg_replace("/<div([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/div>/i", "", $data);
        $data = preg_replace("/<table([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/table>/i", "", $data);
        $data = preg_replace("/<tr([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/tr>/i", "", $data);
        $data = preg_replace("/<td([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/td>/i", "", $data);
        $data = preg_replace("/<tbody([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/tbody>/i", "", $data);
        $data = preg_replace("/<strong([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/strong>/i", "", $data);
        $data = preg_replace("/<br([^>]+)?>/i", "", $data);
        $data = preg_replace("/<p([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/p>/i", "", $data);
        $data = preg_replace("/<span([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/span>/i", "", $data);
        $data = preg_replace("/<h1([^>]+)?>.*<\/h1>/i", "", $data);
        $data = preg_replace("/<h2([^>]+)?>.*<\/h2>/i", "", $data);
        $data = preg_replace("/<font([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/font>/i", "", $data);
        $data = preg_replace("/<center([^>]+)?>/i", "", $data);
        $data = preg_replace("/<\/center>/i", "", $data);
        $data = preg_replace("/<b ([^>]+)?>.*?<\/b>/i", "", $data);
        $data = preg_replace("/<a [^>]*>.*?<\/a>/i", "", $data);
        $data = preg_replace("/\s+/",'',$data);
        $data = str_replace(array("\r\n", "\r", "\n", "\t"), "", $data);
        return $data;
    }

    public function getPlaceDetail( Request $request ){
        $reqs = $request -> except( '_token' );
        if(!isset($reqs['place_id']) || !$reqs['place_id']){
            $this->return['Success']    = false;
            $this->return['Msg']        = '场地编号不可为空';

            echo json_encode($this->return);exit;
        }

        $searchData     = [ 'id' => $reqs['place_id'] ];
        $url            = config('links.palce_api').'/q';
        $res            = json_decode(doCurlGetRequest($url, $searchData), true);

        $this->return['Data'] = $res;

        echo json_encode($this->return);

    }

    static private function clearNull ( array $searchData ){

        foreach($searchData AS $key => $value){
            if(!$value){
                unset($searchData[$key]);
            }
        }
        return $searchData;
    }

    public function place_view(Request $request)
    {
        $reqs       = $request -> except( '_token' );
        $place_id   = isset($reqs['place_id'])?$reqs['place_id']:'';

        //获取位置详情
        $place_info = $this->getPlaceDetailById($place_id);//dd($place_info);

        //组装数据
        $data       = $this->fromatData($place_info,$place_id);

        $system_info = array(
          'services_others' => config('system.services_others'),
          'media_technology' => config('system.media_technology'),
          'food_beverages' => config('system.food_beverages'),
          'convenient_facilities' => config('system.convenient_facilities'),
          'outdoors_views' => config('system.outdoors_views'),
          'bathroom' => config('system.bathroom'),
        );

        return view('/rfp/place_view', [ 'data' => $data , 'system_info' => $system_info ,'place_id' => $place_id]);
    }
    public function place_view_roominfo(Request $request)
    {
        $reqs       = $request -> except( '_token' );
        $place_id   = isset($reqs['place_id'])?$reqs['place_id']:'';
        $key   = isset($reqs['key'])?$reqs['key']:'0';

        //获取位置详情
        $place_info = $this->getPlaceDetailById($place_id);//dd($place_info);

        //组装数据
        $data       = $this->fromatData($place_info,$place_id);

            $services_others = config('system.services_others');
            $media_technology = config('system.media_technology');
            $food_beverages = config('system.food_beverages');
            $convenient_facilities = config('system.convenient_facilities');
            $outdoors_views = config('system.outdoors_views');
            $bathroom = config('system.bathroom');

        $html = '';
            if (!empty($data['meeting_rooms_info'][$key]['facility']['media_technology'])) {
                $html .= '<dl>';
                $html .= '<dt class="rooms_color">媒体/科技</dt>';
                $html .= '<dd>';
                foreach ($data['meeting_rooms_info'][$key]['facility']['media_technology'] as $item) {
                    $html .= "<span class=\"success\">" . $media_technology[$item] . "</span>";
                }
                $html .= '</dd>';
                $html .= '</dl>';
            }
          if (!empty($data['meeting_rooms_info'][$key]['facility']['food_beverages'])) {
              $html .= '<dl>';
              $html .= '<dt class="rooms_color">食品/饮品</dt>';
              $html .= '<dd>';
              foreach ($data['meeting_rooms_info'][$key]['facility']['food_beverages'] as $item) {
                  $html .= "<span class=\"success\">" . $food_beverages[$item] . "</span>";
              }
              $html .= '</dd>';
              $html .= '</dl>';
          }
        if (!empty($data['meeting_rooms_info'][$key]['facility']['outdoors_views'])){
            $html .= '<dl>';
            $html .= '<dt class="rooms_color">室外/景观</dt>';
            $html .= '<dd>';
            foreach ($data['meeting_rooms_info'][$key]['facility']['outdoors_views'] as $item) {
                $html .= "<span class=\"success\">" . $outdoors_views[$item] . "</span>";
            }
            $html .= '</dd>';
            $html .= '</dl>';
        }

        if (!empty($data['meeting_rooms_info'][$key]['facility']['services_others'])){
            $html .= '<dl>';
            $html .= '<dt class="rooms_color">服务及其他</dt>';
            $html .= '<dd>';
            foreach ($data['meeting_rooms_info'][$key]['facility']['services_others'] as $item) {
                $html .= "<span class=\"success\">" . $services_others[$item] . "</span>";
            }
            $html .= '</dd>';
            $html .= '</dl>';
        }

        if (!empty($data['meeting_rooms_info'][$key]['facility']['convenient_facilities'])){
            $html .= '<dl>';
            $html .= '<dt class="rooms_color">便利设施</dt>';
            $html .= '<dd>';
            foreach ($data['meeting_rooms_info'][$key]['facility']['convenient_facilities'] as $item) {
                $html .= "<span class=\"success\">" . $convenient_facilities[$item] . "</span>";
            }
            $html .= '</dd>';
            $html .= '</dl>';
        }

         if (!empty($data['meeting_rooms_info'][$key]['facility']['bathroom'])){
             $html .= '<dl>';
             $html .= '<dt class="rooms_color">浴室</dt>';
             $html .= '<dd>';
             foreach ($data['meeting_rooms_info'][$key]['facility']['bathroom'] as $item) {
                 $html .= "<span class=\"success\">" . $bathroom[$item] . "</span>";
             }
             $html .= '</dd>';
             $html .= '</dl>';
        }

      return $html;
    }



    private function getPlaceDetailById( $place_id ){

        if(!$place_id){
            return array();
        }

        $searchData     = [ 'id' => $place_id ];
        $url            = config('links.palce_api').'/q/v2';

        $res            = json_decode(doCurlGetRequest($url, $searchData), true);
        //if(isset($res['ok']) && !$res['ok']){
            /*$url            = config('links.palce_api').'/q';
            $res            = json_decode(doCurlGetRequest($url, $searchData), true);*/
            //header("Location: http://www.eventown.com/place".$place_id.".html");exit;
        //}
        return $res;

    }

    private function fromatData($ret,$place_id){
        if(empty($ret))return array();
        $data['wwwUrl'] = config('system.eventown_com');
        $meetingRoomCount = 0;
        $meetings = [];
        if(!isset($ret['meetings']) && isset($ret['meetingrooms'])){
            $meetingRoomCount = count($ret['meetingrooms']['MeetingRoomList']);
            $meetings         = isset($ret['meetingrooms']['MeetingRoomList']) ? $ret['meetingrooms']['MeetingRoomList'] : [];
        }elseif(isset($ret['meetings']) && !isset($ret['meetingrooms'])){
            $meetingRoomCount = isset($ret['meetingRoomCount']) ? $ret['meetingRoomCount'] : '0';
            $meetings = isset($ret['meetings']) ? $ret['meetings'] : [];
        }
        $data['main_info']  = array(
            'place_id'      => $ret['place_id'], // 场地ID
            'place_name'    => $ret['place_name'], // 场地名
            'location'      => $ret['location'], // 坐标
            'address'       => $ret['address'], // 地址
            'star_rate'     => $ret['star_rate'], // 星级
            'place_desc'    => $ret['place_desc'], // 详情

            'province_id'   => $ret['province_id'],
            'city_id'       => $ret['city_id'],
            'area_id'       => $ret['area_id'],

            'feature'       => $ret['feature'], // 功能

            'metro_station'     => isset($ret['metro_station']) ? str_replace(array('[', ']', '"'), array('{', '}', ''), json_encode($ret['metro_station'])) : '',
            'train_distance'    => array(), // 火车
            'airport_distance'  => array(), // 飞机

            'found_time'        => isset($ret['found_time'])&&$ret['found_time'] ? $ret['found_time'] : '--', // 开业时间
            'last_repair_time'  => isset($ret['repair_time'])&&$ret['repair_time'] ? $ret['repair_time'] : '--', // 装修时间
            'meetingRoomCount'  => isset($ret['meetingRoomCount'])&&$ret['meetingRoomCount'] ? $ret['meetingRoomCount'] : '--', // 会议室数量
            'area'              => isset($ret['area'])&&$ret['area'] ? $ret['area'] : '--', // 会议室面积
            'roomCount'         => isset($ret['roomCount'])&&$ret['roomCount'] ? $ret['roomCount'] : '--', // 客房数量
            'maxCapacity'       => isset($ret['max_capacity'])&&$ret['max_capacity'] ? $ret['max_capacity'] : '--', // 最大容量
            'new_place_type'    => isset($ret['new_place_type']) ? str_replace(array('[', ']'), array('{', '}'), json_encode($ret['new_place_type'])) : '',
        );
        $data['meetings']       = $meetings;
        $data['meeting_basic']  = isset($ret['meeting_basic']) ? $ret['meeting_basic'] : '';
        $data['roomCounts']	    = 0;
        $data['roomRongna']     = 0;
        if(!empty($ret['rooms']))foreach($ret['rooms'] AS $rk => $rv){
            $data['roomCounts'] += isset($rv['count']) ? $rv['count'] : 1 ;
            $data['roomRongna'] += isset($rv['count'])?$rv['count']:1*isset($rv['max_capacity'])?$rv['max_capacity']:1;
        }

        $params= array(
            'area' => array(
                $data['main_info']['province_id'],
                $data['main_info']['city_id'],
                $data['main_info']['area_id'],
            ),
            'place_type'    => !empty($data['main_info']['new_place_type'])?[ trim($this->pg_array_to_array($data['main_info']['new_place_type'])[0],'"') ]:'',
            'tags'          => '',
        );
        $hotel_service = config('system.hotel_service');
        $meeting_service = config('system.meeting_service');

        $data['place_options']                  = [];
        $data['place_options']                  = $this->get_name_by_type_and_id($params);
        $data['place_options']['room_equi']     = isset($data['main_info']['feature']['accomodations'])?$data['main_info']['feature']['accomodations']:'';
        $data['place_options']['hotel_service'] = isset($data['main_info']['feature']['general'])?$data['main_info']['feature']['general']:'';
        $data['place_options']['meeting_equi']  = isset($data['main_info']['feature']['services'])?$data['main_info']['feature']['services']:'';
        $data['place_options']['room_equi']     = isset($data['main_info']['feature']['accomodations'])?$data['main_info']['feature']['accomodations']:'';
        $data['place_options']['hotel_service'] = isset($data['main_info']['feature']['general'])?$data['main_info']['feature']['general']:array();
        $data['place_options']['meeting_equi']  = isset($data['main_info']['feature']['services'])?$data['main_info']['feature']['services']:array();

        $map_info   = $this -> _Business -> get_yrfp_map_Datas($place_id);
        $map_id     = $map_info['id'];
        $yrfp_offer = $map_id?$this -> _Business -> get_yrfp_offer_Datas($map_id):[];
        $data['hotel_service'] = [];
        if($data['place_options']['hotel_service'])foreach($data['place_options']['hotel_service'] AS $key => $value){
            $data['hotel_service'][] = isset($hotel_service[$value])?$hotel_service[$value]:'';
        }
        $data['meeting_service'] = [];
        if($data['place_options']['meeting_equi'])foreach($data['place_options']['meeting_equi'] AS $key => $value){
            $data['meeting_service'][] = isset($meeting_service[$value])?$meeting_service[$value]:'';
        }

        $data['yrfp_meeting_price'] = isset($yrfp_offer['meeting_price'])?json_decode($yrfp_offer['meeting_price'], true):'';
        $data['yrfp_room_price']    = isset($yrfp_offer['room_price'])?json_decode($yrfp_offer['room_price'], true):'';
        $data['yrfp_food_price']    = isset($yrfp_offer['food_price'])?json_decode($yrfp_offer['food_price'], true):'';
        $data['yrfp_package_price'] = isset($yrfp_offer['meeting_package_price'])?json_decode($yrfp_offer['meeting_package_price'], true):'';
        $data['yrfp_equip_price']   = isset($yrfp_offer['equip_price'])?json_decode($yrfp_offer['equip_price'], true):'';
        $data['place_pic']          = $ret['pics'];

        @$data['meeting_rooms_info'] = isset($ret['rooms']) && !empty($ret['rooms']) ? $ret['rooms'] : [];

        return $data;
    }

    public function pg_array_to_array($pg_array) {
        $array = array();
        $pg_array = str_replace('}', '', $pg_array);
        $pg_array = str_replace('{', '', $pg_array);
        $pg_array = str_replace('"', '', $pg_array);
        if (!empty($pg_array)) {
            $array = explode(',', $pg_array);
        }
        return $array;
    }

    public function get_name_by_type_and_id($params) {
        $url =config('links.links_pic');
        $url = rtrim($url, '/');
        $url .= '/rpc?';
        $param = array(
            'svc' => 'Common_service',
            'app_name' => 'new_eventown',
            'token' => '63942ca4cbf603ee1d57500c69f72f24'
        );

        $url .= http_build_query($param);

        $yarClient = new Yar_Client($url);

        return $yarClient->get_name_by_type_and_id($params);
    }

    /**
     * 场地模糊检索(包含联想及关联逻辑)
     */

    public function placeFuzzyRetrieval( Request $request ){
        $reqs = $request -> except( '_token' );
        $city_name = $reqs['city_name']; // 城市名
        $key_words = $reqs['key_words']; //检索词
        $baidu_keywords_suggest_data = $this->getBaiduSuggestion($city_name,$key_words);

        $this->return['Success'] = true;
        $this->return['Data']    = $baidu_keywords_suggest_data;
        $this->return['Msg']     = '成功';
        echo json_encode($this->return);
    }

    //获取百度针对地点词汇的推荐信息
    private function getBaiduSuggestion($city_name,$key_words){

        $url = config('system.baidu_suggest_url');
        $query_string = urlencode($key_words);
        $region = urlencode($city_name);//城市名称
        $url .= $query_string.'&region='.$region;
        $return_data = array();

        try{

            $res = doCurlGetRequest($url);
            $res = json_decode($res, true);
            if(isset($res['status']) && (0 == $res['status']) && isset($res['message']) && ('ok' == $res['message'])
                && isset($res['result']) && (!empty($res['result'])) ){
                foreach($res['result'] as $point){
                    if(is_null($point['location']['lat']) || is_null($point['location']['lng'])) continue;
                    $return_data[] = array(
                        'key_words' => $point['name'],//关联的关键词
                        'district'  => $point['district'],//区域
                        'business'  => $point['business'],//商圈
                        'location'  => array(
                            'lat'=>$point['location']['lat'],
                            'lng'=>$point['location']['lng']
                        )
                    );
                }
            }
            return $return_data;
        }catch (SystemError $e){
            return $return_data;
        }
    }

}

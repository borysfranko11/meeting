<?php

namespace App\Http\Controllers;

use App\Models\AccommodationInfo;
use App\Models\ConfirmUserInfo;
use App\Models\JoinUsers;
use App\Models\ParticipantLog;
use App\Models\Rfp;
use App\Models\TravelInfo;
use App\Models\UseCarInfo;
use Illuminate\Http\Request;
use Log;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Pinyin\Pinyin;

class JoinUserInfoController extends Controller
{
    private $_pinyin;
    private $__UserInfo;
    private $__CarInfo;
    private $__AccInfo;
    private $__TraInfo;
    private $__Plog;
    private $__Rfp;
    private $__Confirm;

    public function __construct()
    {
        parent::__construct();
        $this->_pinyin = new Pinyin();
        $this->__UserInfo = new JoinUsers();
        $this->__CarInfo = new UseCarInfo();
        $this->__AccInfo = new AccommodationInfo();
        $this->__TraInfo = new TravelInfo();
        $this->__Plog = new ParticipantLog();
        $this->__Rfp = new Rfp();
        $this->__Confirm = new ConfirmUserInfo();
    }

    /**
     *  参会人详细信息
     *　@author Wind
     * @time   2017-8-30
     */
    public function index(Request $request)
    {
        $user_id = intval($request->get('user_id'));
        $bool = $this->__UserInfo->whereRaw('status != ? and join_id = ?', [0, $user_id])->count();
        if ($bool == 0) {
            abort('503');
        }

        // 基础信息
        $users_info = $this->__UserInfo
            ->leftJoin('sign_in', 'join_users.join_id', '=', 'sign_in.join_id')
            ->leftJoin('confirm_user_info', 'confirm_user_info.join_id', '=', 'join_users.join_id')
            ->leftJoin('invitation_send', 'invitation_send.join_id', '=', 'join_users.join_id')
            ->select('join_users.join_id as join_id', 'join_users.rfp_id', 'name', 'join_users.status', 'join_users.sex', 'phone', 'city', 'company', 'duty', 'id_card', 'email', 'join_users.room_type', 'sign_in_type', 'confirm_type', 'invitation_send.join_id as send_id')
            ->whereRaw('status != ? and  join_users.join_id = ?', [0, $user_id])
            ->distinct()
            ->first()
            ->toArray();

        $rfp_id = $users_info['rfp_id'];

        // 出行
        $tra_info = $this->__TraInfo->select('t_id', 'join_id', 't_way', 't_type', 'begin_time', 'begin_city', 'end_city', 't_code', 't_level', 't_money', 'status', 'create_time', 'create_user')
            ->whereRaw('status != ? and join_id = ?', [0, $user_id])
            ->orderBy('update_time', 'desc')
            ->orderBy('create_time', 'desc')
            ->get()
            ->toArray();

        $tra_log = $this->get_participant_log(array('type' => 3, 'rfp_id' => $rfp_id, 'join_id' => $user_id), 'desc', 'create_time', '10')->toArray();

        // 住宿
        $acc_info = $this->__AccInfo->select('a_id', 'join_id', 'a_name', 'a_type', 'in_time', 'out_time', 'days', 'price', 'total_price', 'status', 'create_time', 'create_user','room_num')
            ->whereRaw('status != ? and join_id = ?', [0, $user_id])
            ->orderBy('update_time', 'desc')
            ->orderBy('create_time', 'desc')
            ->get()
            ->toArray();
        $acc_log = $this->get_participant_log(array('type' => 4, 'rfp_id' => $rfp_id, 'join_id' => $user_id), 'desc', 'create_time', '10')->toArray();

        // 用车
        $car_info = $this->__CarInfo->select('uci_id', 'join_id', 'uci_way', 'begin_city', 'begin_time', 'begion_address', 'end_address', 'price', 'status', 'create_time', 'create_user')
            ->whereRaw('status != ? and join_id = ?', [0, $user_id])
            ->orderBy('update_time', 'desc')
            ->orderBy('create_time', 'desc')
            ->get()
            ->toArray();
        $car_log = $this->get_participant_log(array('type' => 5, 'rfp_id' => $rfp_id, 'join_id' => $user_id), 'desc', 'create_time', '10')->toArray();  // 用车
        return view('/join/info', ['user_info' => $users_info,
            'tra_info' => $tra_info,
            'tra_log' => $tra_log,
            'acc_info' => $acc_info,
            'acc_log' => $acc_log,
            'car_info' => $car_info,
            'car_log' => $car_log
        ]);
    }

    /**
     *  修改参会人信息  V
     * @author  Wind
     * @time    2017-8-31
     */
    public function edit(Request $request)
    {

        if ($request->method('GET')) {
            $id = $request->get('user_id');
        } else {
            abort('503');
        }

        $user_info = $this->__UserInfo
            ->select('join_id', 'rfp_id', 'name', 'sex', 'phone', 'city', 'company', 'duty', 'id_card', 'email', 'often_id')
            ->whereRaw('join_id = ? and status != ?', [$id, 0])
            ->first()
            ->toArray();
        if (empty($user_info)) {
            abort(503);
        }

        $request_type = intval($request->get('request_type'));
        if( $request_type == 1 )
        {
            $back_url = url('join/index').'?rfp_id='.$user_info['rfp_id'];
        }elseif( $request_type == 2) {
            $back_url = url('/join/info').'?user_id='.$user_info['join_id'].'&type=0';
        }else{
            abort(503);
        }
        return view('/join/edit', ['user_info' => $user_info,'back_url'=>$back_url]);
    }

    /**
     *  更新参会人信息
     *  Wind  2017-9-1
     */
    public function update(Request $request)
    {

        if (!$request->method('POST')) {
            abort('503');
        }
        $validator = \Validator::make($request->input(), [
            'JoinUsers.join_id' => 'required',
            'JoinUsers.name' => 'required|string|min:2|max:50',
            'JoinUsers.sex' => 'required|boolean',
            'JoinUsers.phone' => 'required|numeric|min:7',
            'JoinUsers.city' => 'required|string|min:2|max:50',
            'JoinUsers.company' => 'required|min:2|max:50',
            'JoinUsers.duty' => 'required|min:2|max:50',
            'JoinUsers.id_card' => 'required|min:2|max:50',
            'JoinUsers.email' => 'email',
            'JoinUsers.often_id' => 'numeric',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 不符合长度最短要求',
            'max' => ':attribute 字符长度过长',
            'integer' => ':attribute 必须是一个整数',
            'string' => ':attribute 必须为字符串类型',
            'numeric' => ':attribute 必须为一串数字',
            'email' => ':attribute 必须为有效Email格式',
        ], [
            'JoinUsers.join_id' => '参会人',
            'JoinUsers.name' => '参会人姓名',
            'JoinUsers.sex' => '性别',
            'JoinUsers.phone' => '手机号',
            'JoinUsers.city' => '所属城市',
            'JoinUsers.company' => '公司名称',
            'JoinUsers.duty' => '职位/职务',
            'JoinUsers.id_card' => '身份证号/护照号',
            'JoinUsers.email' => 'Email',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->input('JoinUsers');
        $spelling = $this -> _pinyin->convert(  $data['name']);
        $data['spelling'] = implode(' ',$spelling);
        $data['update_user'] = session('user')['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['status'] = '2';

        $old_info = $this-> __UserInfo->select('phone','id_card')->where('join_id',$data['join_id'])->first();
        $is_register = 0;

        $is_reg = 0;

        if( $old_info['phone'] != $data['phone'])
        {
            $is_register = $this -> __UserInfo
                ->whereRaw('phone = ?  and rfp_id = ? and status != ?',[$data['phone'],$data['rfp_id'],0] )
                ->count();
        }elseif($old_info['id_card'] != $data['id_card']){
            $is_reg = $this -> __UserInfo
                ->whereRaw(' id_card = ? and rfp_id = ? and status != ?',[$data['id_card'],$data['rfp_id'],0] )
                ->count();
        }
        if( $is_register > 0 )
        {
            $e['phone']="手机号已存在";
            return redirect()->back()->withErrors($e)->withInput();  //   todo  重复验证提示
        }
        if( $is_reg > 0 )
        {
            $e['id_card']="身份证号已存在";
            return redirect()->back()->withErrors($e)->withInput();  //   todo  重复验证提示
        }


        $is_set = null;
        if ($data['often_id'] != 0) {
            $is_set = $this->__UserInfo->whereRaw(' rfp_id = ? and often_id = ? and status != ?', [$data['rfp_id'], $data['often_id'], 0])->first();
        }
        if (!empty($is_set) && $is_set['join_id'] != $data['join_id']) {
            return redirect()->back();
        }

        $param = array();
        if ($this->__UserInfo->where('join_id', $data['join_id'])->update($data)) {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'content' => '更新参会人' . $data['name'] . '信息成功',
                'node' => $this->__url,
                'rfp_id' => $data['rfp_id'],
                'type' => '1',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try {
                $this->__Plog->insert($param);
            } catch (\Exception $e) {
                //写入文本日志
                $message = "{session('user')['id']}修改用户,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert($message);
            }
            $back_url = $request->get('back_url');
            if(!empty($back_url)){
                return redirect()->to($back_url);
            }else{
                return redirect('/join/index' . '?rfp_id=' . $data['rfp_id']);
            }

        } else {
            return redirect()->back()->with('error', 'false');
        }
    }

    /**
     *   添加出行/住宿/用车信息   修改出行/住宿/用车信息  V
     *   Wind
     *   2017-9-5
     *   @param  type  类型   1 出行 2 住宿  3 用车
     *   @param  join_id  被操作的参会人id
     *   @param  id    对应类型 在数据表中的主键  可以为空   NULL  新增 / NOT NULL  修改
     */
    public function addOrEditOther(Request $request)
    {
        $type   = $request->get('type');        //  展示页面类型   1 出行 2 住宿 3 用车
        $id     = $request->get('id');          //  对应修改的id  可以为空
        $join_id = $request->get('join_id');   //   被操作的参会人 可以为空
        $city = file_get_contents('http://qa.meetingv2.eventown.com/Rfp/getAllCity');
        if( !empty($city))
        {
            $city = json_decode($city,TRUE);
            foreach ($city as $k => $v )
            {
                $city[] = $v['name'];
                unset($city[$k]);
            }
        }else{
            $city = [];
        }
        // 验证参会人信息
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$join_id,0])->first()->toArray();
        if( empty($user_info))
        {
            abort(503);
        }

        // 出行信息
        if( $type == 1 )
        {
            if (!empty(intval($id)) && !empty(intval($join_id))) {
                $data = $this->__TraInfo->whereRaw('status != ? and t_id = ? and join_id = ? ', [0, $id, $join_id])->first()->toArray();
                return view('/join/addTravel', ['data' => $data,'city'=>$city]);
            }else{
                return view('/join/addTravel', ['join_id' => $join_id,'city'=>$city]);
            }

        // 住宿信息
        }elseif( $type == 2 ) {
            $hotole_id = $this->__Rfp -> where('rfp_id',$user_info['rfp_id'])->pluck('place_id');
            if( empty($hotole_id ))
            {
                abort(503);
            }
            if($hotole_id > 6000000){
                $url = 'http://api.eventown.com/q/v2?id='.$hotole_id;
            }else{
                $url = 'http://api.eventown.com/q?id='.$hotole_id;
            }

            $hotole_info = file_get_contents($url);
            $hotole_info = json_decode($hotole_info,true);
            $hotole_name = $hotole_info['place_name'];

            if( !isset($hotole_info['hotelrooms']['RoomList']) || empty($hotole_info['hotelrooms']['RoomList']))
            {
                $room_type = array();
            }else{
                $room_info = $hotole_info['hotelrooms']['RoomList'];
                $room_type = array();
                foreach ( $room_info as $v )
                {
                    $room_type[] = $v['HotelBaseRoomInfo']['BaseRoomName'];
                }
            }

            if (!empty(intval($id)) && !empty(intval($join_id))) {
                $data = $this->__AccInfo->whereRaw('status != ? and a_id = ? and join_id = ? ', [0, $id, $join_id])->first()->toArray();
                return view('/join/addAccommodation', ['data' => $data,'hotole_name'=>$hotole_name,'room_type'=>$room_type]);
            }else{
                return view('/join/addAccommodation', ['join_id' => $join_id,'hotole_name'=>$hotole_name,'room_type'=>$room_type]);
            }

        //  新增用车信息
        }elseif( $type == 3 ) {

            if (!empty(intval($id)) && !empty(intval($join_id))) {
                $data = $this->__CarInfo->whereRaw('status != ? and uci_id = ? and join_id = ? ', [0, $id, $join_id])->first()->toArray();
                return view('/join/addUseCar', ['data' => $data,'city'=>$city]);
            }else{
                return view('/join/addUseCar', ['join_id' => $join_id,'city'=>$city]);
            }
        }else{
            abort(503);
        }

    }

    /**
     *   添加出行信息   修改出行信息   C
     *   Wind
     *   2017-9-5
     */
    public function updateOrAddTravel(Request $request)
    {
        $data = array();
        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }
        // 接收数据
        $data['join_id'] = intval($request->input('join_id'));
        $data['t_way']  = intval($request->input('t_way'));
        $data['t_type']  = trim($request->input('t_type'));
        $data['begin_time']  = rtrim(ltrim($request->input('begin_time')));
        $data['begin_city']  = $request->input('begin_city');
        $data['end_city']  = $request->input('end_city');
        $data['t_level']  = trim($request->input('t_level'));
        $data['t_money']  = trim($request->input('t_money'));
        $data['t_code']  = trim($request->input('t_code'));

        // 数据验证
        if( empty($data['join_id'])) {  return response()->json(array('error'=>'false','msg'=>'错误的请求方式')); }
        if( $data['t_way'] <=0 || $data['t_way'] > 2 ) {  return response()->json(array('error'=>'false','msg'=>'请选择正确的行程类型')); }
        if( empty($data['t_type'])) {  return response()->json(array('error'=>'false','msg'=>'请选择出行方式')); }
        if( empty($data['begin_time'])) {  return response()->json(array('error'=>'false','msg'=>'请选择出行时间')); }
        if( empty($data['begin_city'])) {  return response()->json(array('error'=>'false','msg'=>'请选择始发地')); }
        if( empty($data['end_city'])) {  return response()->json(array('error'=>'false','msg'=>'请选择目的地')); }
        if( empty($data['t_level'])) {  return response()->json(array('error'=>'false','msg'=>'请输入舱位/座位等级')); }
        if( empty($data['t_money'])) {  return response()->json(array('error'=>'false','msg'=>'请输入机票/火车票价格')); }
        if( empty($data['t_code'])) {  return response()->json(array('error'=>'false','msg'=>'请输入航班号/车次号')); }
        // 验证参会人信息
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$data['join_id'],0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'当前参会人信息异常，请刷新后重新操作'));
        }
        // 判断 新增 / 修改
        $t_id = intval($request->input('t_id'));
        if( empty($t_id))
        {
            $data['status']  = 1;
            $data['create_time']  = date('Y-m-d H:i:s');
            $data['create_user']  = session('user')['id'];
            $data['update_time']  = date('Y-m-d H:i:s');
            $data['update_user']  = session('user')['id'];
            if($this-> __TraInfo -> insert($data))
            {
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '新增参会人'.$user_info['name'].'出行信息成功',
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'join_id'  => $data['join_id'],
                    'type' => '3',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}新增参会人出行信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'添加成功'));
            }else{
                return response()->json(array('error'=>'false','msg'=>'系统异常'));
            }
        }else{
            $tra_info = $this -> __TraInfo ->whereRaw('join_id = ? and status != ? and t_id = ?  ',[$data['join_id'],0,$t_id])->count();

            if( $tra_info == 0 )
            {
                return response()->json(array('error'=>'false','msg'=>'该条信息异常，请刷新后修改'));
            }
            $data['status']  = 2;
            $data['update_time']  = date('Y-m-d H:i:s');
            $data['update_user']  = session('user')['id'];

            if($this-> __TraInfo -> whereRaw('join_id = ? and status != ? and t_id = ?  ',[$data['join_id'],0,$t_id])->update($data))
            {
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '修改参会人'.$user_info['name'].'出行信息成功',
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'join_id'  => $data['join_id'],
                    'type' => '3',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}修改参会人出行信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'修改成功'));
            }else{
                return response()->json(array('error'=>'false','msg'=>'系统异常'));
            }
        }



//  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态0失效/1正常/2修改',
//  `create_time` datetime NOT NULL COMMENT '创建时间',
//  `create_user` int(11) NOT NULL COMMENT '创建人',
//  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
//  `update_user` int(11) DEFAULT NULL COMMENT '更新人',
    }

    /**
     *   添加住宿信息   修改住宿信息   C
     *   Wind
     *   2017-9-5
     */
    public function updateOrAddAcc(Request $request)
    {

        $data = array();
        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }

        // 接收数据
        $data['join_id'] = intval($request->input('join_id'));
        $data['a_name']  = trim($request->input('a_name'));
        $data['a_type']  = trim($request->input('a_type'));
        $data['in_time']  = rtrim(ltrim($request->input('in_time')));
        $data['out_time']  = rtrim(ltrim($request->input('out_time')));
        $data['days']  = intval($request->input('days'));
        $data['price']  = floatval($request->input('price'));
        $data['total_price']  = floatval(trim($request->input('total_price')));
        $data['room_num']  = trim($request->input('room_num'));
        // 数据验证
        if( empty($data['join_id'])) {  return response()->json(array('error'=>'false','msg'=>'错误的请求方式')); }
        if( empty($data['a_name'])) {  return response()->json(array('error'=>'false','msg'=>'酒店名称获取失败')); }
        if( empty($data['a_type'])) {  return response()->json(array('error'=>'false','msg'=>'请选择房间类型')); }
        if( empty($data['in_time'])) {  return response()->json(array('error'=>'false','msg'=>'请输入入住时间')); }
        if( empty($data['out_time'])) {  return response()->json(array('error'=>'false','msg'=>'请输入退房时间')); }
        if( empty($data['days']) || $data['days'] <= 0 )
        {
            return response()->json(array('error'=>'false','msg'=>'错误的入住天数'));
        }
        if( empty($data['price']) || $data['price']<= 0 )
        {
            return response()->json(array('error'=>'false','msg'=>'进入输入错误'));
        }
        if( empty($data['total_price']) || $data['total_price']<= 0 || ($data['days'] * $data['price'] != $data['total_price']))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的金额计算'));
        }
        // 验证参会人信息
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$data['join_id'],0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'当前参会人信息异常，请刷新后重新操作'));
        }
        // 判断 新增 / 修改
        $a_id = intval($request->input('a_id'));

        if( empty($a_id))
        {
            $data['status']  = 1;
            $data['create_time']  = date('Y-m-d H:i:s');
            $data['create_user']  = session('user')['id'];
            $data['update_time']  = date('Y-m-d H:i:s');
            $data['update_user']  = session('user')['id'];
            if($this-> __AccInfo -> insert($data))
            {
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '新增参会人'.$user_info['name'].'住宿信息成功',
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'join_id'  => $data['join_id'],
                    'type' => '4',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}新增参会人住宿信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'新增成功'));
            }else{
                return response()->json(array('error'=>'false','msg'=>'系统异常，刷新重试'));
            }
        }else {

            $acc_info = $this->__AccInfo->whereRaw('join_id = ? and status != ? and a_id = ?  ', [$data['join_id'], 0, $a_id])->count();

            if ($acc_info == 0) {
                return response()->json(array('error'=>'false','msg'=>'当前数据信息异常，请刷新后重新操作'));
            }
            $data['status'] = 2;
            if ($this->__AccInfo->whereRaw('join_id = ? and status != ? and a_id = ?  ', [$data['join_id'], 0, $a_id])->update($data)) {
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '修改参会人' . $user_info['name'] . '住宿信息成功',
                    'join_id'  => $data['join_id'],
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'type' => '4',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}修改参会人住宿信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'修改成功'));
            } else {
                return response()->json(array('error'=>'false','msg'=>'系统异常，刷新重试'));
            }
        }
    }

    /**
     *   添加用车信息   修改用车信息   C
     *   Wind
     *   2017-9-5
     */
    public function updateOrAddUseCar(Request $request)
    {
        $data = array();
        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }
        // 接收数据
        $data['join_id'] = intval($request->input('join_id'));
        $data['uci_way']  = intval($request->input('uci_way'));
        $data['begin_city']  = trim($request->input('begin_city'));
        $data['begin_time']  = rtrim(ltrim($request->input('begin_time')));
        $data['begion_address']  = trim($request->input('begion_address'));
        $data['end_address']  = trim($request->input('end_address'));
        $data['price']  = floatval($request->input('price'));

        // 数据验证
        if( empty($data['join_id'])) {  return response()->json(array('error'=>'false','msg'=>'错误的请求方式，请刷新！')); }
        if( $data['uci_way']> 2 || $data['uci_way'] <= 0 ) {  return response()->json(array('error'=>'false','msg'=>'请选择正确的用车类型')); }
        if( empty($data['begin_city'])) {  return response()->json(array('error'=>'false','msg'=>'请选择出发城市')); }
        if( empty($data['begin_time'])) {  return response()->json(array('error'=>'false','msg'=>'请输选择出发时间')); }
        if( empty($data['begion_address'])) {  return response()->json(array('error'=>'false','msg'=>'请输入出发地点')); }
        if( empty($data['end_address'])) {  return response()->json(array('error'=>'false','msg'=>'请输入目的地')); }
        if( empty($data['price']) || $data['price'] <= 0  ) {  return response()->json(array('error'=>'false','msg'=>'金额输入错误')); }

        // 验证参会人信息
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$data['join_id'],0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'当前参会人信息异常，请刷新后重新操作'));
        }
        // 判断 新增 / 修改
        $uci_id = intval($request->input('uci_id'));
        if( empty($uci_id))
        {
            $data['status']  = 1;
            $data['create_time']  = date('Y-m-d H:i:s');
            $data['create_user']  = session('user')['id'];
            $data['update_time']  = date('Y-m-d H:i:s');
            $data['update_user']  = session('user')['id'];
            if($this-> __CarInfo -> insert($data))
            {
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '新增参会人'.$user_info['name'].'用车信息成功',
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'join_id'  => $data['join_id'],
                    'type' => '5',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}新增参会人用车信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'新增参会人用车信息成功'));
            }else{
                return response()->json(array('error'=>'false','msg'=>'系统异常，请刷新重试！'));
            }
        }else {
            $acc_info = $this->__CarInfo->whereRaw('join_id = ? and status != ? and uci_id = ?  ', [$data['join_id'], 0, $uci_id])->count();
            if ($acc_info == 0) {
                return response()->json(array('error'=>'false','msg'=>$data));
            }
            $data['status'] = 2;
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['update_user'] = session('user')['id'];
            if ($this->__CarInfo->whereRaw('join_id = ? and status != ? and uci_id = ?  ', [$data['join_id'], 0, $uci_id])->update($data)) {
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '修改参会人' . $user_info['name'] . '用车信息成功',
                    'node' => $this->__url,
                    'rfp_id' => $user_info['rfp_id'],
                    'join_id'  => $data['join_id'],
                    'type' => '5',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try {
                    $this->__Plog->insert($param);
                } catch (\Exception $e) {
                    //写入文本日志
                    $message = "{session('user')['id']}修改参会人用车信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert($message);
                }
                return response()->json(array('error'=>'true','msg'=>'修改参会人用车信息成功'));
            } else {
                return response()->json(array('error'=>'false','msg'=>'系统异常，请刷新重试！'));
            }
        }
    }
//
    /**
     *   出行管理 ->  删除出行信息
     *   Wind
     *   2017-9-5
     */
    public function delTravel(Request $request)
    {

        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }
        $t_id = $request->input('id');
        $join_id = $request->input('join_id');
        if( empty( intval($t_id)) || empty(intval($join_id)))
        {
            return response()->json(array('error'=>'false','msg'=>'参数异常'));
        }
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$join_id,0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'用户信息异常，请刷新重试！'));
        }
        $tra_info = $this -> __TraInfo ->whereRaw('join_id = ? and status != ? and t_id = ?  ',[$join_id,0,$t_id])->count();
        if( $tra_info == 0 )
        {
            return response()->json(array('error'=>'false','msg'=>'该信息不存在或已被删除！'));
        }
        $data = array(
            'update_user' => session('user')['id'],
            'update_time' => date('Y-m-d H:i:s'),
            'status'      =>  0,
        );
        if ($this-> __TraInfo -> whereRaw('join_id = ? and t_id = ?',[$join_id,$t_id])->update($data)) {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'join_id'=> $join_id,
                'content' => '删除参会人'.$user_info['name'].'出行信息成功',
                'node' => $this->__url,
                'rfp_id' => $user_info['rfp_id'],
                'type' => '3',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try {
                $this->__Plog->insert($param);
            } catch (\Exception $e) {
                //写入文本日志
                $message = "{session('user')['id']}删除参会人出行信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert($message);
            }
            return response()->json(array('error'=>'true','msg'=>'删除成功'));
        } else {
            return response()->json(array('error'=>'true','msg'=>'系统异常！'));
        }

    }

    /**
     *   出行管理 ->  删除出行信息
     *   Wind
     *   2017-9-5
     */
    public function delAcc(Request $request)
    {

        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }
        $a_id = $request->input('id');
        $join_id = $request->input('join_id');
        if( empty( intval($a_id)) || empty(intval($join_id)))
        {
            return response()->json(array('error'=>'false','msg'=>'参数异常'));
        }
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$join_id,0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'用户信息异常，请刷新重试！'));
        }
        $acc_info = $this -> __AccInfo ->whereRaw('join_id = ? and status != ? and a_id = ?  ',[$join_id,0,$a_id])->count();
        if( $acc_info == 0 )
        {
            return response()->json(array('error'=>'false','msg'=>'该信息不存在或已被删除！'));
        }
        $data = array(
            'update_user' => session('user')['id'],
            'update_time' => date('Y-m-d H:i:s'),
            'status'      =>  0,
        );
        if ($this-> __AccInfo -> whereRaw('join_id = ? and a_id = ?',[$join_id,$a_id])->update($data)) {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'join_id'=> $join_id,
                'content' => '删除参会人'.$user_info['name'].'住宿信息成功',
                'node' => $this->__url,
                'rfp_id' => $user_info['rfp_id'],
                'type' => '4',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try {
                $this->__Plog->insert($param);
            } catch (\Exception $e) {
                //写入文本日志
                $message = "{session('user')['id']}删除参会人住宿信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert($message);
            }
            return response()->json(array('error'=>'true','msg'=>'删除成功'));
        } else {
            return response()->json(array('error'=>'true','msg'=>'系统异常！'));
        }

    }

    /**
     *   出行管理 ->  删除出行信息
     *   Wind
     *   2017-9-5
     */
    public function delUseCar(Request $request)
    {

        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }
        $uci_id = $request->input('id');
        $join_id = $request->input('join_id');
        if( empty( intval($uci_id)) || empty(intval($join_id)))
        {
            return response()->json(array('error'=>'false','msg'=>'参数异常'));
        }
        $user_info = $this-> __UserInfo ->select('name','rfp_id')->whereRaw('join_id = ? and status != ? ',[$join_id,0])->first()->toArray();
        if( empty($user_info))
        {
            return response()->json(array('error'=>'false','msg'=>'用户信息异常，请刷新重试！'));
        }
        $acc_info = $this -> __CarInfo ->whereRaw('join_id = ? and status != ? and uci_id = ?  ',[$join_id,0,$uci_id])->count();
        if( $acc_info == 0 )
        {
            return response()->json(array('error'=>'false','msg'=>'该信息不存在或已被删除！'));
        }
        $data = array(
            'update_user' => session('user')['id'],
            'update_time' => date('Y-m-d H:i:s'),
            'status'      =>  0,
        );
        if ($this-> __CarInfo -> whereRaw('join_id = ? and uci_id = ?',[$join_id,$uci_id])->update($data)) {
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'join_id'=> $join_id,
                'content' => '删除参会人'.$user_info['name'].'用车信息成功',
                'node' => $this->__url,
                'rfp_id' => $user_info['rfp_id'],
                'type' => '5',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try {
                $this->__Plog->insert($param);
            } catch (\Exception $e) {
                //写入文本日志
                $message = "{session('user')['id']}删除参会人用车信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert($message);
            }
            return response()->json(array('error'=>'true','msg'=>'删除成功'));
        } else {
            return response()->json(array('error'=>'true','msg'=>'系统异常！'));
        }

    }

    /**
     *   确认参会人信息   V
     *   Wind
     *   2017-9-6
     */
    public function confirmIndex( Request $request)
    {


        $join_id = intval($request->get('join_id'));
        $rfp_id = intval($request->get('rfp_id'));
        if( empty($join_id) ||empty($rfp_id))
        {
            abort(503);
        }
        $user_info = $this-> __UserInfo -> whereRaw('join_id = ? and rfp_id = ? and status != ? ', [$join_id,$rfp_id,0])->first()->toArray();
        if( empty($user_info))
        {
            abort(503);
        }
        //  酒店信息
        $hotole_id = $this->__Rfp -> where('rfp_id',$user_info['rfp_id'])->pluck('place_id');
        if( empty($hotole_id ))
        {
            abort(503);
        }

        if($hotole_id > 6000000){
            $url = 'http://api.eventown.com/q/v2?id='.$hotole_id;
        }else{
            $url = 'http://api.eventown.com/q?id='.$hotole_id;
        }

        $hotole_info = file_get_contents($url);
        $hotole_info = json_decode($hotole_info,true);
        $hotole_name = $hotole_info['place_name'];
        if( !isset($hotole_info['hotelrooms']['RoomList']) || empty($hotole_info['hotelrooms']['RoomList']))
        {
            $room_type = array();
        }else{
            $room_info = $hotole_info['hotelrooms']['RoomList'];
            $room_type = array();
            foreach ( $room_info as $v )
            {
                $room_type[] = $v['HotelBaseRoomInfo']['BaseRoomName'];
            }
        }
        $is_confirm = $this->__Confirm ->where('join_id',$join_id)->count();
        if( $is_confirm > 0 )
        {
            abort(503);
        }
        return view('/join/confirm',['join_id'=>$join_id,'rfp_id'=>$rfp_id,'room_type'=>$room_type]);
    }

    /***
     *   添加用户确认信息
     *   Wind
     *   2017-09-06
     */
    public  function  addJoinUserConfirm( Request $request)
    {
        $type=$request['type'];
       $rfp_id=$request['rfp_id'];
        $join_id = intval($request->input('join_id'));

        if( $join_id <= 0 )
        {
            return redirect()->back();
        }
        $user_info = $this-> __UserInfo -> whereRaw('join_id = ? and status  != ? ', [$join_id,0])->first()->toArray();

        if( empty($user_info))
        {
            abort(503);
        }
        $is_confirm = $this->__Confirm ->where('join_id',$join_id)->count();
        if( $is_confirm > 0 )
        {
            abort(503);
        }
//        dd($request->all());
        $validator = \Validator::make($request->input(),[
            'ConfirmUserInfo.is_come_ticket'  =>  'boolean',
            'ConfirmUserInfo.come_type'  =>  'boolean',
            'ConfirmUserInfo.come_time'  =>  'required_if:ConfirmUserInfo.is_come_ticket,1|date',
            'ConfirmUserInfo.come_code'  =>  'required_if:ConfirmUserInfo.is_come_ticket,1|string',
            'ConfirmUserInfo.come_begin_city'  =>  'required_if:ConfirmUserInfo.is_come_ticket,1',
            'ConfirmUserInfo.come_end_city'  =>  'required_if:ConfirmUserInfo.is_come_ticket,1',
            'ConfirmUserInfo.is_leave_ticket'  =>  'boolean',
            'ConfirmUserInfo.leave_type'  =>  'boolean',
            'ConfirmUserInfo.leave_time'  =>  'required_if:ConfirmUserInfo.is_leave_ticket,1|date',
            'ConfirmUserInfo.leave_code'  =>  'required_if:ConfirmUserInfo.is_leave_ticket,1|string',
            'ConfirmUserInfo.leave_begin_city'  =>  'required_if:ConfirmUserInfo.is_leave_ticket,1|string',
            'ConfirmUserInfo.leave_end_city'  =>  'required_if:ConfirmUserInfo.is_leave_ticket,1|string',
            'ConfirmUserInfo.is_connet'  =>  'boolean',
            'ConfirmUserInfo.is_send'  =>  'boolean',
            'ConfirmUserInfo.is_hotel'  =>  'boolean',
            'ConfirmUserInfo.room_type'  =>  'required_if:ConfirmUserInfo.is_hotel,1',
            'ConfirmUserInfo.check_in_time'  =>  'required_if:ConfirmUserInfo.is_hotel,1|date',
            'ConfirmUserInfo.check_out_time'  =>  'required_if:ConfirmUserInfo.is_hotel,1|date',
        ],[
            'required_if'  => ':attribute 为必填项 ',
            'boolean'       => ':attribute 值异常',
            'string'    => ':attribute 必须为字符串类型',
            'date'      => ':attribute 必须为有效的时间',
            '1'         => ':attribute 为选中状态的时候'
            ],[
            'ConfirmUserInfo.is_come_ticket'  =>  '是否需要预定去程车/机票',
            'ConfirmUserInfo.come_type'  =>  '去程方式',
            'ConfirmUserInfo.come_time'  =>  '去程日期',
            'ConfirmUserInfo.come_code'  =>  '去程航班/车次',
            'ConfirmUserInfo.come_begin_city'  =>  '去程出发地',
            'ConfirmUserInfo.come_end_city'  =>  '去程目的地',
            'ConfirmUserInfo.is_leave_ticket'  =>  '是否需要预订返程机票',
            'ConfirmUserInfo.leave_type'  =>  '返程方式',
            'ConfirmUserInfo.leave_time'  =>  '返程出发日期',
            'ConfirmUserInfo.leave_code'  =>  '返程意向航班号／车次号',
            'ConfirmUserInfo.leave_begin_city'  =>  '返程出发地',
            'ConfirmUserInfo.leave_end_city'  =>  '返程目的地',
            'ConfirmUserInfo.is_connet'  =>  '是否需要接机',
            'ConfirmUserInfo.is_send'  =>  '是否需要送机',
            'ConfirmUserInfo.is_hotel'  =>  '是否需要预订酒店',
            'ConfirmUserInfo.room_type'  =>  '意向房型',
            'ConfirmUserInfo.check_in_time'  =>  '入住日期',
            'ConfirmUserInfo.check_out_time'  =>  '退房日期',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->input('ConfirmUserInfo');
        $data['qrcode_code'] = rand(100000,999999).$join_id;
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['create_user'] = session('user')['id'];
        $data['confirm_time'] = date('Y-m-d H:i:s');
        $data['confirm_type'] = 2;
        $data['join_id']  = $join_id;

        if( $this-> __Confirm ->insert($data))
        {
            $this->__UserInfo ->where('join_id','=',$data['join_id'])->update(['update_time'=>date('Y-m-d H:i:s',time())]);
            // 日志信息
            $param = array(
                'belong' => session('user')['id'],
                'join_id'=> $join_id,
                'content' => '确认参会人'.$user_info['name'].'信息成功',
                'node' => $this->__url,
                'rfp_id' => $user_info['rfp_id'],
                'type' => '8',
                'ip' => $_SERVER["REMOTE_ADDR"],
                'create_time' => date('Y-m-d H:i:s'),
            );
            // 写入日志
            try {
                $this->__Plog->insert($param);
            } catch (\Exception $e) {
                //写入文本日志
                $message = "{session('user')['id']}确认参会人信息,日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                Log::alert($message);
            }
            if($type==1){
                return redirect('/join/index'.'?rfp_id='.$rfp_id);
            }else{
                return redirect('/join/info'.'?user_id='.$join_id);
            }

        }else{
            abort(503);
        }
    }
}

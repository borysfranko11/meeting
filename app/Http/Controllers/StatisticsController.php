<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\8\22 0022
 * Time: 10:48
 */
namespace App\Http\Controllers;

use App\Models\JoinUsers;
use App\Models\ConfirmUserInfo;
use App\Models\Rfp;
use App\Models\RfpPerform;
use App\Models\TravelInfo;
use App\Models\UseCarInfo;
use App\Models\AccommodationInfo;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Excel;

class StatisticsController extends Controller
{
    private  $__Join;
    private  $__Travel;
    private  $__UseCar;
    private  $__Accommodation;
    private  $__Confirm;
    private  $__Rfp;
    private  $__RfpPerform;
    public function __construct()
    {
        parent::__construct();
        $this -> __Join = new JoinUsers();
        $this -> __Travel = new TravelInfo();
        $this -> __UseCar = new UseCarInfo();
        $this -> __Accommodation = new AccommodationInfo();
        $this -> __Confirm = new ConfirmUserInfo();
        $this -> __Rfp = new Rfp();
        $this -> __RfpPerform = new RfpPerform();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 数据统计列表
     * Wind
     * 2017-9-14
     */
    public  function  statisticsList(Request $request)
    {

        if( $request->isMethod('POST') )
        {
            $url = array();
            $url['rfp_id']   = $request->input('rfp_id');
            $url['name']     = $request ->input('name');
            $url['phone']    = $request->input('phone');
            $url['page']    = intval($request->input('page'));
        }
        if( $request->isMethod('GET') )
        {
            $rfp_id = $request->get('rfp_id');
            $rfp_id = (intval($rfp_id) == null || intval($rfp_id) < 0 ) ? abort('503') : intval($rfp_id) ;
            $url['rfp_id']   = $rfp_id;
            $url['name']     = $request ->get('name');
            $url['phone']    = $request->get('phone');
            $url['page']    = intval($request->get('page'));
        }

        $chart = array();                   // 绘制图表的信息
        //  会议预计人数
        $all = $this -> __Join
            -> whereRaw('rfp_id = ? and status != ?',[$url['rfp_id'],0])
            ->count();
        //  已确认人数
        $confirm = $this-> __Join
            ->leftJoin('confirm_user_info','confirm_user_info.join_id','=','join_users.join_id')
            ->whereRaw('rfp_id = ? and join_users.status != ? and confirm_user_info.confirm_type != ? ',[$url['rfp_id'],0,0])
            ->count();
        //  已签到人数
        $sign = $this -> __Join
            ->leftJoin('sign_in','join_users.join_id','=','sign_in.join_id')
            ->whereRaw('rfp_id = ? and join_users.status != ? and sign_in.sign_in_type != ? ',[$url['rfp_id'],0,0])
            ->count();
        // 绘表数据  ->  签到
        $sign_info = $this -> __Join
            ->leftJoin('sign_in','join_users.join_id','=','sign_in.join_id')
            ->whereRaw('rfp_id = ? and join_users.status != ? and sign_in.sign_in_type != ? ',[$url['rfp_id'],0,0])
            ->lists('sign_in.sign_in_time')
            ->toArray();
        $start_time = $this->__Rfp->where('rfp_id',$url['rfp_id'])->value('start_time');
        $start_time = strtotime(date('Y-m-d',$start_time));
        $s_chart = array_fill(0,24,0);
        if(  !empty( $sign_info))
        {
            foreach ( $sign_info as $k => $v)
            {
                $sign_time = intval(date('H',(strtotime($v) - $start_time)));
                $s_chart[$sign_time] = ++$s_chart[$sign_time];
            }
        }
        // 绘表数据  ->  确认
        $c_chart = $this -> __Confirm
            ->select(DB::raw("count(*) as count ,FROM_UNIXTIME(UNIX_TIMESTAMP(confirm_time),'%Y-%m-%d') AS c_time"))
            ->leftjoin('join_users','join_users.join_id','=','confirm_user_info.join_id')
            ->whereRaw('confirm_user_info.confirm_type != ? and join_users.status != ? and join_users.rfp_id = ?',[0,0,$url['rfp_id']])
            ->groupBy('c_time')
            ->get()->toarray();
        //  图表数据
        $chart_data = array(
            'all'        => $all,
            'confirm'    => $confirm,
            'sign'       => $sign,
            's_chart'      => $s_chart,
            'c_chart'      => $c_chart,
            's_time'       => date('Y-m-d',$start_time)
        );
        //  分页地址
        $url_str = url('/Statistics/list').'?';
        foreach ( $url as $k => $v)
        {
            $url_str .= $k.'='.$v.'&';
        }

        $user_list = array();               // 信息列表
        $item = 20;                          // 每一页的条数
        $page = ($url['page'] - 1 ) < 0 ? 0 : $url['page'] -1 ;
        $begin = $page * $item;
        $count = 0;
        $sum_page = 0;

        $where_str = 'join_users.rfp_id = ?  and join_users.status != ? and confirm_user_info.confirm_type != ?';
        $where_arr[] = $url['rfp_id'];
        $where_arr[] = 0;
        $where_arr[] = 0;
        // 姓名
        if( trim($url['name']))
        {
            $where_str .= " and join_users.name like '%$url[name]%' ";
        }
        // 电话号
        if( trim($url['phone']))
        {
            $where_str .= " and join_users.phone = '$url[phone]' ";
        }
        $users = $this -> __Join
            ->select('join_users.join_id',
                'join_users.name',
                'join_users.phone',
                'confirm_user_info.is_come_ticket',
                'confirm_user_info.is_leave_ticket',
                'confirm_user_info.is_connet',
                'confirm_user_info.is_send',
                'confirm_user_info.is_hotel'
            )
            ->leftJoin('confirm_user_info','confirm_user_info.join_id','=','join_users.join_id')
            ->whereRaw($where_str,$where_arr)
            ->skip($begin)->take($item)
            ->get()
            ->toArray();
        $count = $this -> __Join
            ->select('join_users.join_id',
                'join_users.name',
                'join_users.phone',
                'confirm_user_info.is_come_ticket',
                'confirm_user_info.is_leave_ticket',
                'confirm_user_info.is_connet',
                'confirm_user_info.is_send',
                'confirm_user_info.is_hotel'
            )
            ->leftJoin('confirm_user_info','confirm_user_info.join_id','=','join_users.join_id')
            ->whereRaw($where_str,$where_arr)
            ->count();
        if( $count != 0 )
        {
            $sum_page = ceil($count/$item); // 总页数
        }else{
            $sum_page = 0; // 总页数
        }
        if( empty($users))
        {
            return view('/rfp/Statistics',['user_list'=>$user_list,'url'=>$url,'sum_page'=>$sum_page,'url_str'=>$url_str,'chart_data'=>$chart_data]);
        }

        $come_ticket_users = array();
        $leave_ticket_users = array();
        $use_car_users = array();
        $hotel_users = array();
        $users_info_arr = array();
        //餐饮费
        $eatinfo = $this -> __RfpPerform
                                ->select('food_fees','signed_number')
                                ->where('rfp_id',$rfp_id)
                                ->get()
                                ->toarray();
        if(empty($eatinfo) || $eatinfo[0]['food_fees'] <= 0 || $eatinfo[0]['signed_number'] <= 0 )
        {
            $eat_price = 0.00;
        }else{
            $eat_price = sprintf("%.2f",$eatinfo[0]['food_fees'] / $eatinfo[0]['signed_number']) ;
        }
        // 基础数据
        foreach ( $users as $k => $v)
        {
            $join_id = $v['join_id'];
            $v['total_price'] = 0.00;
            $v['hotole_price'] = 0.00;
            $v['eat_prive'] = $eat_price;
            $v['car_price']     = 0.00;
            $v['come_ticket_arr'] = array();
            $v['leave_ticket_arr'] = array();
            if( $v['is_come_ticket'] ){ $come_ticket_users[] =  $v['join_id']; }
            if( $v['is_leave_ticket'] ){ $leave_ticket_users[] =  $v['join_id']; }
            if( $v['is_send'] || $v['is_connet'] ){ $use_car_users[] =  $v['join_id']; }
            if( $v['is_hotel'] ){ $hotel_users[] =  $v['join_id']; }
            unset($v['is_come_ticket']);
            unset($v['is_leave_ticket']);
            unset($v['is_send']);
            unset($v['is_connet']);
            unset($v['is_hotel']);
            unset($v['join_id']);
            $users_info_arr[$join_id] = $v;
        }
        //  酒店金额
        $hotel_arr = $this -> __Accommodation
            ->select(DB::raw('sum(total_price) as total_price, join_id'))
            ->whereRaw('status != ?  ',[0])
            ->whereIn('join_id',$hotel_users)
            ->groupBy('join_id')
            ->get()
            ->toarray();
        foreach ( $hotel_arr as $k=>$v)
        {
            $users_info_arr[$v['join_id']]['hotole_price'] = $v['total_price'];
        }
        //  用车金额
        $connet_arr = $this -> __UseCar
            ->select(DB::raw('sum(price) as price, join_id'))
            ->whereRaw('status != ?  and uci_way != ? ',[0,0])
            ->whereIn('join_id',$use_car_users)
            ->groupBy('join_id')
            ->get()
            ->toarray();
        foreach ( $connet_arr as $k=>$v)
        {
            $users_info_arr[$v['join_id']]['car_price'] = $v['price'];
        }

        // 出行信息
        $come_ticket_arr = $this -> __Travel
            ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
            ->whereRaw('status != ? and t_way = ?',[0,1])
            ->whereIn('join_id',$come_ticket_users)
            ->get()
            ->toArray();

        foreach ( $come_ticket_arr as $k=>$v)
        {
            $users_info_arr[$v['join_id']]['come_ticket_arr'][] = $v;
        }
        $leave_ticket_arr = $this -> __Travel
            ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
            ->whereRaw('status != ? and t_way = ?',[0,2])
            ->whereIn('join_id',$leave_ticket_users)
            ->get()
            ->toArray();
        foreach ( $leave_ticket_arr as $k=>$v)
        {
            $users_info_arr[$v['join_id']]['leave_ticket_arr'][] = $v;
        }
        //  往返取第一车次的数据
        foreach ( $users_info_arr as $k => $v)
        {
            $users_info_arr[$k]['total_price'] += $v['hotole_price'] + $v['car_price'] + $v['eat_prive'];
            if( !empty($v['leave_ticket_arr'])  )
            {
                $users_info_arr[$k]['total_price'] += $v['leave_ticket_arr'][0]['t_money'];
            }
            if( !empty($v['come_ticket_arr'])   )
            {
                $users_info_arr[$k]['total_price'] += $v['come_ticket_arr'][0]['t_money'];
            }
        }
        //修整数组
        $empty_ticket = array('begin_time'=>'','t_way'=>'','t_code'=>'','begin_city'=>'','end_city'=>'','t_money'=>'','join_id'=>'');

        foreach ($users_info_arr as $key => $v)
        {
            if( count($v['leave_ticket_arr']) < 1  )
            {
                    $users_info_arr[$key]['leave_ticket_arr'][] = $empty_ticket;
            }
            if( count($v['come_ticket_arr'])  < 1 )
            {
                    $users_info_arr[$key]['come_ticket_arr'][] = $empty_ticket;
            }
        }
        foreach ( $users_info_arr as $k => $v )
        {
            $temp = '';

            for ( $i = 0 ;$i < 1  ; $i ++ )
            {
                unset($v['come_ticket_arr'][$i]['join_id']);
                unset($v['leave_ticket_arr'][$i]['join_id']);

                if( $v['come_ticket_arr'][$i]['t_way'] == 1 )
                {
                    $v['come_ticket_arr'][$i]['t_way'] = '去程';
                }elseif($v['come_ticket_arr'][$i]['t_way'] == 2 ){
                    $v['come_ticket_arr'][$i]['t_way'] = '返程';
                }

                if( $v['leave_ticket_arr'][$i]['t_way'] == 1 )
                {
                    $v['leave_ticket_arr'][$i]['t_way'] = '去程';
                }elseif($v['leave_ticket_arr'][$i]['t_way'] == 2 ){
                    $v['leave_ticket_arr'][$i]['t_way'] = '返程';
                }
                $temp .= implode(',',$v['come_ticket_arr'][$i]).','.implode(',',$v['leave_ticket_arr'][$i]).',';
            }
            unset($v['come_ticket_arr']);
            unset($v['leave_ticket_arr']);
            $info =  substr((implode(',',$v).',').$temp,0,-1);
            $user_list[] = explode(',',$info);

        }

        return view('/rfp/Statistics',['user_list'=>$user_list,'url'=>$url,'sum_page'=>$sum_page,'url_str'=>$url_str,'chart_data'=>$chart_data]);
    }


    /***
     * 费用统计
     * @param Request $request
     *  2017-9-14
     *  Wind
     */
    public function statistics(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if (!preg_match('/^\d$/', $rfp_id)) {
            abort('503');
        }
        //  基础数据查询
        $users = $this -> __Join
                        ->select('join_users.join_id',
                                 'join_users.name',
                                 'join_users.phone',
                                'confirm_user_info.is_come_ticket',
                                'confirm_user_info.is_leave_ticket',
                                'confirm_user_info.is_connet',
                                'confirm_user_info.is_send',
                                'confirm_user_info.is_hotel'
                                 )
                        ->leftJoin('confirm_user_info','confirm_user_info.join_id','=','join_users.join_id')
                        ->whereRaw('confirm_user_info.confirm_type != ? and join_users.status != ? and join_users.rfp_id = ?',[0,0,$rfp_id])
                        ->get()
                        ->toArray();
        $come_ticket_users = array();
        $leave_ticket_users = array();
        $use_car_users = array();
        $hotel_users = array();
        $users_info_arr = array();

        //餐饮费
        $eatinfo = $this -> __RfpPerform
            ->select('food_fees','signed_number')
            ->where('rfp_id',$rfp_id)
            ->get()
            ->toarray();
        if(empty($eatinfo) || $eatinfo[0]['food_fees'] <= 0 || $eatinfo[0]['signed_number'] <= 0 )
        {
            $eat_price = 0.00;
        }else{
            $eat_price = sprintf("%.2f",$eatinfo[0]['food_fees'] / $eatinfo[0]['signed_number']) ;
        }
        // 重新拼接基础数据
        foreach ( $users as $k => $v)
        {
            $join_id = $v['join_id'];
            $v['total_price'] = 0.00;
            $v['hotole_price'] = 0.00;
            $v['eat_prive'] = $eat_price;
            $v['car_price']     = 0.00;
            $v['come_ticket_arr'] = array();
            $v['leave_ticket_arr'] = array();
            if( $v['is_come_ticket'] ){ $come_ticket_users[] =  $v['join_id']; }
            if( $v['is_leave_ticket'] ){ $leave_ticket_users[] =  $v['join_id']; }
            if( $v['is_send'] || $v['is_connet'] ){ $use_car_users[] =  $v['join_id']; }
            if( $v['is_hotel'] ){ $hotel_users[] =  $v['join_id']; }
            unset($v['is_come_ticket']);
            unset($v['is_leave_ticket']);
            unset($v['is_send']);
            unset($v['is_connet']);
            unset($v['is_hotel']);
            unset($v['join_id']);
            $users_info_arr[$join_id] = $v;
        }
        //  酒店金额
        $hotel_arr = $this -> __Accommodation
            ->select(DB::raw('sum(total_price) as total_price, join_id'))
            ->whereRaw('status != ?  ',[0])
            ->whereIn('join_id',$hotel_users)
            ->groupBy('join_id')
            ->get()
            ->toarray();
        if( !empty($hotel_arr))
        {
            foreach ( $hotel_arr as $k=>$v)
            {
                $users_info_arr[$v['join_id']]['hotole_price'] = $v['total_price'];
            }
        }

        //  用车金额
        $connet_arr = $this -> __UseCar
            ->select(DB::raw('sum(price) as price, join_id'))
            ->whereRaw('status != ?  and uci_way != ? ',[0,0])
            ->whereIn('join_id',$use_car_users)
            ->groupBy('join_id')
            ->get()
            ->toarray();

        if( !empty($connet_arr))
        {
            foreach ( $connet_arr as $k=>$v)
            {
                $users_info_arr[$v['join_id']]['car_price'] = $v['price'];
            }
        }


        // 出行信息
        $come_ticket_arr = $this -> __Travel
                                    ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
                                    ->whereRaw('status != ? and t_way = ?',[0,1])
                                    ->whereIn('join_id',$come_ticket_users)
                                    ->get()
                                    ->toArray();
        if( !empty($come_ticket_arr))
        {
            foreach ( $come_ticket_arr as $k=>$v)
            {
                $users_info_arr[$v['join_id']]['come_ticket_arr'][] = $v;
            }
        }
        $leave_ticket_arr = $this -> __Travel
                                    ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
                                    ->whereRaw('status != ? and t_way = ?',[0,2])
                                    ->whereIn('join_id',$leave_ticket_users)
                                    ->get()
                                    ->toArray();
        if( !empty($leave_ticket_arr))
        {
            foreach ( $leave_ticket_arr as $k=>$v)
            {
                $users_info_arr[$v['join_id']]['leave_ticket_arr'][] = $v;
            }
        }

        //  最大长度
        $max_num = 1;
        foreach ( $users_info_arr as $k => $v)
        {
            $users_info_arr[$k]['total_price'] += $v['hotole_price'] + $v['car_price'] + $v['eat_prive'];
            if( !empty($v['leave_ticket_arr'])  )
            {
                foreach ($v['leave_ticket_arr']  as  $leave )
                {
                    $users_info_arr[$k]['total_price'] += $leave['t_money'];
                }
            }
            if( !empty($v['come_ticket_arr'])   )
            {
                foreach ($v['leave_ticket_arr']  as  $come )
                {
                    $users_info_arr[$k]['total_price'] += $come['t_money'];
                }
            }
        }
        // 抬头
        $fix_title = '姓名,手机号码,总费用,住宿费用,餐饮费用,用车费用,';
        $round_title = '去程日期,出行方式,航班号／车次号,出发地,目的地,价格,返程日期,出行方式,航班号／车次号,出发地,目的地,价格,';
        $title = '';
        for ( $i = 0 ; $i < $max_num ; $i ++ )
        {
            $title .= $round_title;
        }
        $title = substr($fix_title . $title,0,-1);
        $title = explode(',',$title);

        //修整数组
        $empty_ticket = array('begin_time'=>'','t_way'=>'','t_code'=>'','begin_city'=>'','end_city'=>'','t_money'=>'','join_id'=>'');

        foreach ($users_info_arr as $key => $v)
        {

            if( count($v['leave_ticket_arr']) < $max_num  )
            {
                $this_num = count($v['leave_ticket_arr']);
                for( $i =0 ;$i < $max_num - $this_num ; $i++ )
                {
                    $users_info_arr[$key]['leave_ticket_arr'][] = $empty_ticket;
                }
            }
            if( count($v['come_ticket_arr'])  < $max_num )
            {
                $this_num = count($v['come_ticket_arr']);
                for( $i =0 ;$i < $max_num - $this_num ; $i++ )
                {
                    $users_info_arr[$key]['come_ticket_arr'][] = $empty_ticket;
                }
            }
        }
//        dd($users_info_arr);
        $user_excel = array();
        foreach ( $users_info_arr as $k => $v )
        {
            $temp = '';

            for ( $i = 0 ;$i < $max_num  ; $i ++ )
            {
                unset($v['come_ticket_arr'][$i]['join_id']);
                unset($v['leave_ticket_arr'][$i]['join_id']);

                if( $v['come_ticket_arr'][$i]['t_way'] == 1 )
                {
                    $v['come_ticket_arr'][$i]['t_way'] = '去程';
                }elseif($v['come_ticket_arr'][$i]['t_way'] == 2 ){
                    $v['come_ticket_arr'][$i]['t_way'] = '返程';
                }

                if( $v['leave_ticket_arr'][$i]['t_way'] == 1 )
                {
                    $v['leave_ticket_arr'][$i]['t_way'] = '去程';
                }elseif($v['leave_ticket_arr'][$i]['t_way'] == 2 ){
                    $v['leave_ticket_arr'][$i]['t_way'] = '返程';
                }
                $temp .= implode(',',$v['come_ticket_arr'][$i]).','.implode(',',$v['leave_ticket_arr'][$i]).',';
            }
            unset($v['come_ticket_arr']);
            unset($v['leave_ticket_arr']);
            $info =  substr((implode(',',$v).',').$temp,0,-1);
            $user_excel[] = explode(',',$info);
        }
        $file_name = date('Y-m-d H-i-s');
        Excel::create($file_name, function($excel) use($user_excel,$title){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($user_excel,$title){ //创建表格
                $sheet->fromArray($user_excel,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->row(1,$title); //改变表头
            });
        })->download('xlsx');
    }

    //用车信息数据导出
    public function export(Request $request)
    {
        $rfp_id = $request->input('rfp_id'); //询单id
        if (!preg_match('/^\d$/', $rfp_id)) {
            abort('503');
        }

        $str = $request->input('join_id'); //主键id
        $join_id = array();
        if (!empty($str)) {
            $join_id = explode(',', $str);
        }

        if (empty($join_id)) {
            $user = DB::table('join_users')
                ->leftJoin('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.join_id', //参会人id
                    'join_users.name', //姓名
                    'join_users.sex', //性别
                    'join_users.phone', //电话
                    'join_users.id_card', //身份证
                    'join_users.status', //状态
                    'confirm_user_info.come_begin_city', //去程出发地
                    'confirm_user_info.come_end_city',  //去程目的地
                    'confirm_user_info.leave_begin_city', //返程出发地
                    'confirm_user_info.leave_end_city' //返程目的地
                )
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $rfp_id)
                ->whereRaw('( confirm_user_info.is_connet = ? or confirm_user_info.is_send = ? )', [1, 1])
                ->get();
        } else {
            $user = DB::table('join_users')
                ->leftJoin('confirm_user_info', 'join_users.join_id', '=', 'confirm_user_info.join_id')
                ->select('join_users.join_id', //参会人id
                    'join_users.name', //姓名
                    'join_users.sex', //性别
                    'join_users.phone', //电话
                    'join_users.id_card', //身份证
                    'join_users.status', //状态
                    'confirm_user_info.come_begin_city', //去程出发城市
                    'confirm_user_info.come_end_city',  //去程目的城市
                    'confirm_user_info.leave_begin_city', //返程出发城市
                    'confirm_user_info.leave_end_city' //返程目的城市
                )
                ->where('join_users.status', '!=', 0)
                ->where('join_users.rfp_id', '=', $rfp_id)
                ->whereIn('join_users.join_id','=',$join_id)
                ->whereRaw('( confirm_user_info.is_connet = ? or confirm_user_info.is_send = ? )', [1, 1])
                ->get();

        }

        $travel = DB::table('join_users')
            ->leftJoin('use_car_info', 'join_users.join_id', '=', 'use_car_info.join_id')
            ->select('use_car_info.join_id',//参会人id
                'use_car_info.uci_way',  //用车类型
                'use_car_info.begin_city', //出发城市
                'use_car_info.begin_time', //出发时间
                'use_car_info.begion_address', //出发地
                'use_car_info.end_address', //目的地
                'use_car_info.price' //价格
            )
            ->where('join_users.rfp_id', '=', $rfp_id)
            ->where('join_users.status', '!=', 0)
            ->where('use_car_info.status', '!=', 0)
            ->where('use_car_info.uci_way', '!=', 0)
            ->get();

        $user_tra = array();
        foreach ($user as $key => $value) {
            $user_tra[$value['join_id']] = array(
                'join_id'=> $value['join_id'],
                'name'=> $value['name'],                   //姓名
                'status' => $value['status'],              //信息状态
                'sex' => $value['sex'],                    //性别
                'phone' => $value['phone'],                //电话
                'id_card' => $value['id_card'],            //身份证号
                'come_begin_city'=>$value['come_begin_city'], //去程出发城市
                'come_end_city'=>$value['come_end_city'],  //去程目的城市
                'leave_begin_city'=>$value['leave_begin_city'],  //返程出发城市
                'leave_end_city'=>$value['leave_end_city'],  //返程目的城市
                'come_arr' => array(),                     //去程用车信息
                'leave_arr' => array(),                    //返程用车信息
            );
            foreach($travel as $k=>$v){
                $join_id = $v['join_id'];
                if($value['join_id'] == $join_id){
                    if($v['uci_way'] ==1) {
                        unset($v['join_id']);
                        unset($v['uci_way']);
                        $user_tra[$value['join_id']]['come_arr'][] = $v;
                    }elseif($v['uci_way'] ==2){
                        unset($v['join_id']);
                        unset($v['uci_way']);
                        $user_tra[$value['join_id']]['leave_arr'][] = $v;
                    }else{
                        continue;
                    }
                }
            }
        }

        $max = 0;
        foreach ( $user_tra as $k => $v )
        {
            $come =  count( $v['come_arr']) ;
            $leave = count( $v['leave_arr']) ;
            $this_max = ($come > $leave)?$come:$leave;
            $max =  ($this_max> $max) ? $this_max : $max;
        }

        $empty_arr  = array(
            "begin_city" => "",
            "begin_time" => "",
            "begion_address" => "",
            "end_address" => "",
            "price" => "",
        );

        foreach ( $user_tra as $k => $v)
        {
            $come_num = count($v['come_arr']);
            $leave_num = count($v['leave_arr']);
            //  补齐
            if( $come_num < $max)
            {
                for( $i = 0 ; $i< $max - $come_num ; $i ++ )
                {
                    $user_tra[$k]['come_arr'][] = $empty_arr;
                }
            }
            if( $leave_num < $max)
            {
                for( $i = 0 ; $i< $max - $leave_num ; $i ++ )
                {
                    $user_tra[$k]['leave_arr'][] = $empty_arr;
                }
            }
            unset($user_tra[$k]['join_id']);
        }

        $excel_title =  '姓名,信息状态,性别,手机号,身份证号,去程出发城市,去程目的城市,返程出发城市,返程目的城市,';
        $loop_title = '出发城市,出发时间,出发地,目的地,价格,出发城市,出发时间,出发地,目的地,价格,';
        $temp_title = '';

        for ( $i = 0; $i< $max ;$i ++)
        {
            $temp_title .= $loop_title ;
        }
        $temp_title = substr($temp_title,0,-1);
        $excel_title.= $temp_title;
        $excel_title = explode(',',$excel_title);

        $excel_info = array();
        foreach ($user_tra as $k=>$v)
        {
            $loop_info = '';
            for( $i = 0 ; $i< $max ; $i ++ )
            {
                $loop_info .= implode(',',$v['come_arr'][$i]).','.implode(',',$v['leave_arr'][$i]).',';
            }

            $loop_info = substr($loop_info,0,-1);
            unset($v['come_arr']);
            unset($v['leave_arr']);

            $user_info = implode(',',$v);

            $excel_info[$k] = explode(',',$user_info.','.$loop_info);
            //dd($excel_info);
            if($excel_info[$k][1] == 1){
                $excel_info[$k][1] = '正常';
            }elseif($excel_info[$k][1] == 2){
                $excel_info[$k][1] = '变更';
            }else{
                $excel_info[$k][1] = '失效';
            }
            //改变显示
            $excel_info[$k][2] == 0 ? $excel_info[$k][2] = '女' : $excel_info[$k][2] = '男';
            $excel_info[$k][5] == 0 ? $excel_info[$k][5] = '否' : $excel_info[$k][5] = '是';
        }
        Excel::create('批量导出参会人信息表格', function($excel) use($excel_info,$excel_title){ //创建文件并将数据传入
            $excel->sheet('sheet', function($sheet) use($excel_info,$excel_title){ //创建表格
                $sheet->fromArray($excel_info,null,'',true);//将数据写入文件并使 0 能正常显示
                $sheet->row(1,$excel_title); //改变表头
            });
        })->download('xlsx');
    }





    //费用统计   多列取出备份
//    public function statistics(Request $request)
//    {
//        $rfp_id = $request->input('rfp_id'); //询单id
//        if (!preg_match('/^\d$/', $rfp_id)) {
//            abort('503');
//        }
//        //  基础数据查询
//        $users = $this -> __Join
//            ->select('join_users.join_id',
//                'join_users.name',
//                'join_users.phone',
//                'confirm_user_info.is_come_ticket',
//                'confirm_user_info.is_leave_ticket',
//                'confirm_user_info.is_connet',
//                'confirm_user_info.is_send',
//                'confirm_user_info.is_hotel'
//            )
//            ->leftJoin('confirm_user_info','confirm_user_info.join_id','=','join_users.join_id')
//            ->whereRaw('confirm_user_info.confirm_type != ? and join_users.status != ? and join_users.rfp_id = ?',[0,0,$rfp_id])
//            ->get()
//            ->toArray();
//        $come_ticket_users = array();
//        $leave_ticket_users = array();
//        $use_car_users = array();
//        $hotel_users = array();
//        $users_info_arr = array();
//        // 重新拼接基础数据
//        foreach ( $users as $k => $v)
//        {
//            $join_id = $v['join_id'];
//            $v['total_price'] = 0.00;
//            $v['hotole_price'] = 0.00;
//            $v['eat_prive'] = 0.00;
//            $v['car_price']     = 0.00;
//            $v['come_ticket_arr'] = array();
//            $v['leave_ticket_arr'] = array();
//            if( $v['is_come_ticket'] ){ $come_ticket_users[] =  $v['join_id']; }
//            if( $v['is_leave_ticket'] ){ $leave_ticket_users[] =  $v['join_id']; }
//            if( $v['is_send'] || $v['is_connet'] ){ $use_car_users[] =  $v['join_id']; }
//            if( $v['is_hotel'] ){ $hotel_users[] =  $v['join_id']; }
//            unset($v['is_come_ticket']);
//            unset($v['is_leave_ticket']);
//            unset($v['is_send']);
//            unset($v['is_connet']);
//            unset($v['is_hotel']);
//            unset($v['join_id']);
//            $users_info_arr[$join_id] = $v;
//        }
//        //  酒店金额
//        $hotel_arr = $this -> __Accommodation
//            ->select(DB::raw('sum(total_price) as total_price, join_id'))
//            ->whereRaw('status != ?  ',[0])
//            ->whereIn('join_id',$hotel_users)
//            ->groupBy('join_id')
//            ->get()
//            ->toarray();
//        if( !empty($hotel_arr))
//        {
//            foreach ( $hotel_arr as $k=>$v)
//            {
//                $users_info_arr[$v['join_id']]['hotole_price'] = $v['total_price'];
//            }
//        }
//
//        //  用车金额
//        $connet_arr = $this -> __UseCar
//            ->select(DB::raw('sum(price) as price, join_id'))
//            ->whereRaw('status != ?  and uci_way != ? ',[0,0])
//            ->whereIn('join_id',$use_car_users)
//            ->groupBy('join_id')
//            ->get()
//            ->toarray();
//
//        if( !empty($connet_arr))
//        {
//            foreach ( $connet_arr as $k=>$v)
//            {
//                $users_info_arr[$v['join_id']]['car_price'] = $v['price'];
//            }
//        }
//
//
//        // 出行信息
//        $come_ticket_arr = $this -> __Travel
//            ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
//            ->whereRaw('status != ? and t_way = ?',[0,1])
//            ->whereIn('join_id',$come_ticket_users)
//            ->get()
//            ->toArray();
//        if( !empty($come_ticket_arr))
//        {
//            foreach ( $come_ticket_arr as $k=>$v)
//            {
//                $users_info_arr[$v['join_id']]['come_ticket_arr'][] = $v;
//            }
//        }
//        $leave_ticket_arr = $this -> __Travel
//            ->select('begin_time','t_way','t_code','begin_city','end_city','t_money','join_id')
//            ->whereRaw('status != ? and t_way = ?',[0,2])
//            ->whereIn('join_id',$leave_ticket_users)
//            ->get()
//            ->toArray();
//        if( !empty($leave_ticket_arr))
//        {
//            foreach ( $leave_ticket_arr as $k=>$v)
//            {
//                $users_info_arr[$v['join_id']]['leave_ticket_arr'][] = $v;
//            }
//        }
//
//        //  最大长度
//        $max_num = 0;
//        foreach ( $users_info_arr as $k => $v)
//        {
//            $this_max =  count($v['leave_ticket_arr']) > count($v['come_ticket_arr']) ? count($v['leave_ticket_arr']) : count($v['come_ticket_arr']);
//            $max_num = $max_num > $this_max ? $max_num : $this_max;
//            $users_info_arr[$k]['total_price'] += $v['hotole_price'] + $v['car_price'] + $v['eat_prive'];
//            if( !empty($v['leave_ticket_arr'])  )
//            {
//                foreach ($v['leave_ticket_arr']  as  $leave )
//                {
//                    $users_info_arr[$k]['total_price'] += $leave['t_money'];
//                }
//            }
//            if( !empty($v['come_ticket_arr'])   )
//            {
//                foreach ($v['leave_ticket_arr']  as  $come )
//                {
//                    $users_info_arr[$k]['total_price'] += $come['t_money'];
//                }
//            }
//        }
//        // 抬头
//        $fix_title = '姓名,手机号码,总费用,住宿费用,餐饮费用,用车费用,';
//        $round_title = '去程日期,出行方式,航班号／车次号,出发地,目的地,价格,返程日期,出行方式,航班号／车次号,出发地,目的地,价格,';
//        $title = '';
//        for ( $i = 0 ; $i < $max_num ; $i ++ )
//        {
//            $title .= $round_title;
//        }
//        $title = substr($fix_title . $title,0,-1);
//        $title = explode(',',$title);
//
//        //修整数组
//        $empty_ticket = array('begin_time'=>'','t_way'=>'','t_code'=>'','begin_city'=>'','end_city'=>'','t_money'=>'','join_id'=>'');
//
//        foreach ($users_info_arr as $key => $v)
//        {
//
//            if( count($v['leave_ticket_arr']) < $max_num  )
//            {
//                $this_num = count($v['leave_ticket_arr']);
//                for( $i =0 ;$i < $max_num - $this_num ; $i++ )
//                {
//                    $users_info_arr[$key]['leave_ticket_arr'][] = $empty_ticket;
//                }
//            }
//            if( count($v['come_ticket_arr'])  < $max_num )
//            {
//                $this_num = count($v['come_ticket_arr']);
//                for( $i =0 ;$i < $max_num - $this_num ; $i++ )
//                {
//                    $users_info_arr[$key]['come_ticket_arr'][] = $empty_ticket;
//                }
//            }
//        }
////        dd($users_info_arr);
//        $user_excel = array();
//        foreach ( $users_info_arr as $k => $v )
//        {
//            $temp = '';
//
//            for ( $i = 0 ;$i < $max_num  ; $i ++ )
//            {
//                unset($v['come_ticket_arr'][$i]['join_id']);
//                unset($v['leave_ticket_arr'][$i]['join_id']);
//
//                if( $v['come_ticket_arr'][$i]['t_way'] == 1 )
//                {
//                    $v['come_ticket_arr'][$i]['t_way'] = '去程';
//                }elseif($v['come_ticket_arr'][$i]['t_way'] == 2 ){
//                    $v['come_ticket_arr'][$i]['t_way'] = '返程';
//                }
//
//                if( $v['leave_ticket_arr'][$i]['t_way'] == 1 )
//                {
//                    $v['leave_ticket_arr'][$i]['t_way'] = '去程';
//                }elseif($v['leave_ticket_arr'][$i]['t_way'] == 2 ){
//                    $v['leave_ticket_arr'][$i]['t_way'] = '返程';
//                }
//                $temp .= implode(',',$v['come_ticket_arr'][$i]).','.implode(',',$v['leave_ticket_arr'][$i]).',';
//            }
//            unset($v['come_ticket_arr']);
//            unset($v['leave_ticket_arr']);
//            $info =  substr((implode(',',$v).',').$temp,0,-1);
//            $user_excel[] = explode(',',$info);
//        }
//
//        Excel::create('参会人员费用统计', function($excel) use($user_excel,$title){ //创建文件并将数据传入
//            $excel->sheet('sheet', function($sheet) use($user_excel,$title){ //创建表格
//                $sheet->fromArray($user_excel,null,'',true);//将数据写入文件并使 0 能正常显示
//                $sheet->row(1,$title); //改变表头
//            });
//        })->download('xlsx');
//    }
}
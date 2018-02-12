<?php
/**
 * des: 询单逻辑处理控制器
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\EveClient;
use App\Models\InvitationTpl;
use App\Models\ConfirmUserInfo;
use App\Models\JoinUsers;
use App\Models\Rfp;
use QrCode;

class H5InvitationController extends Controller
{
    private $_Tpl;
    private $_Confirm;
    private $_Join;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this -> _Tpl = new InvitationTpl();
        $this -> _Confirm = new ConfirmUserInfo();
        $this -> _Join = new JoinUsers();
        $this -> _Rfp = new Rfp();
    }

    /**
     *   如果 type = 0  则不显示二维码
     *   如果type = 1 则显示用户登录所需要的二维码
     *           二维码生成规则  待定  先随意生成占位
     *   如果不存在这个确认信息，则显示邀请函模板
     *
     *   点击确认触发
     *   如果当前时间小于规定确认时间，填写状态为模板填写状态  入库 并生成用户二维码编码
     *   如果大于或等于 入库 信息状态位为超时填写 然后 提示您已超过确认填写时间，如需参会，请联系会议主办方
     *
     */
    public function index(Request $request)
    {
        $key = 'ht-mt';
        $rfp_id = $_GET['r_id'];
        $tpl_id = $_GET['t_id'];
        $join_id = $_GET['j_id'];
        $token = $_GET['_token'];
        //dd(substr(md5($rfp_id . $join_id . $tpl_id . $key), 2, 10));
        if (substr(md5($rfp_id . $join_id . $tpl_id . $key), 2, 10) != $token) {
            die ("加载失败，请刷新后重试");
        }
        //查询数据状态信息是否确认
        $confirm = DB::table('confirm_user_info')
            ->join('join_users','confirm_user_info.join_id','=','join_users.join_id')
            ->select('confirm_user_info.join_id','confirm_user_info.confirm_type')
            ->where('confirm_user_info.join_id', '=', $join_id)
            ->where('join_users.rfp_id','=',$rfp_id)
            ->where('join_users.status','!=',0)
            ->get();
        //  酒店信息
        $hotole_id = $this->_Rfp -> where('rfp_id',$rfp_id)->pluck('place_id');
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
        $room_type = array('标准双人间','大床间');
        if (count($confirm) < 1 || $confirm[0]['confirm_type'] == 0) {
            //未确认查询用户信息
            $code = '';
            $data = DB::table('invitation_tpl')
                ->select('title','begin_time','address','confirm_time','end_time',"bg_img_url")
                ->where('tpl_id','=',$tpl_id)
                ->where('status','!=',0)
                ->get();

            $name = DB::table('join_users')
                ->select('name','sex')
                ->where('join_id','=',$join_id)
                ->where('status','!=',0)
                ->get();
            if(empty($data) || empty($name)){
                return "暂无此参会人信息 请核实后重试";
            }
            $date = [];
            foreach ($data as $key=>$val){
                $date[$key]['title']        = $val['title'];
                $date[$key]['begin_time']   = date('Y-m-d H:i',strtotime($val['begin_time']));
                $date[$key]['address']      = $val['address'];
                $date[$key]['confirm_time'] = date('Y-m-d H:i',strtotime($val['confirm_time']));
                $date[$key]['end_time']     = date('Y-m-d H:i',strtotime($val['end_time']));
                $date[$key]['bg_img_url']     = $val['bg_img_url'];
            }
            return view('h5/index',['date'=>$date,'name'=>$name,'code'=>$code,'room_type'=>$room_type, 'rfp_id' => $rfp_id]);
         //   return view('h5/index3',['date'=>$date,'name'=>$name,'code'=>$code,'room_type'=>$room_type, 'rfp_id' => $rfp_id]);
        } elseif($confirm[0]['confirm_type']!==0 ) {
            $code = DB::table('confirm_user_info')
                ->join('join_users','confirm_user_info.join_id','=','join_users.join_id')
                ->select('qrcode_code')
                ->where('confirm_user_info.join_id','=',$join_id)
                ->where('join_users.status','!=',0)
                ->get();
            $title = DB::table('rfp')
                ->select('meeting_name')
                ->where('rfp_id','=',$rfp_id)
                ->get();
            $file_dir = public_path('assets/qr_code/');
            //dd($file_dir);
            if( !file_exists($file_dir))
            {
                mkdir($file_dir,0777);
            }
            $file_name = 'QR'.date('Y-m-d H_i_s',time()).rand(1111,9999).'.png';
            //dd($file_name);
            $qr_code = 'h5/qr_code?qr_code='.$code[0]['qrcode_code'].'&join_id='.$join_id.'&_token='.substr(md5($code[0]['qrcode_code'] . $join_id . 'ht-mt'),2,10);
            QrCode::format('png')->size(200)->generate( url().'/'.$qr_code , public_path('assets/qr_code/'.$file_name));
            return view('h5/qr_code',['title'=>$title,'code'=>$code,'file_name'=>$file_name]);//跳转到二维码展示页面并展示二维码
        }
    }

    public function confirm(Request $request)
    {
        //dd(1);
        //dd($request->all());
        $date['join_id'] = $request['j_id']; //参会人id
        if(empty($date['join_id'])){
            return response()->json(['num'=>1,'msg'=>'未选择任何参会人员']);
        }

        $date['confirm_time']          = date('Y-m-d H:i:s',time());
        $date['confirm_type']          = 3;
        $date['qrcode_code']           = rand(100000,999999).$date['join_id'];
        $date['create_time']           = date('Y-m-d H:i:s',time());
        //dd($date['create_user']);
        $count = DB::table('confirm_user_info')->select('join_id')->where('join_id','=',$date['join_id'])->count();
        if($count >= 1){
            DB::table('confirm_user_info')->where('join_id','=',$date['join_id'])->update($date);
        }else {
            DB::table('confirm_user_info')->insert($date);
        }
        $url = '/h5/qr_code?qr_code='.$date['qrcode_code'].'&join_id='.$date['join_id'].'&_token='.substr(md5($date['qrcode_code'] . $date['join_id'] . 'ht-mt'),2,10);
        return ['url'=>$url];
    }

    public function qr_code()
    {
        $join_id = $_GET['join_id'];
        $title = DB::table('rfp')
            ->leftJoin('join_users','join_users.rfp_id','=','rfp.rfp_id')
            ->select('rfp.meeting_name')
            ->where('join_users.join_id','=',$join_id)
            ->where('join_users.status','!=',0)
            ->where('rfp.status','!=',0)
            ->get();
        return view('h5/qr_code',['title'=>$title]);
    }
}

<?php
/**
 * des: 询单逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\InvitationTpl;
use App\Models\JoinUsers;
use App\Models\Rfp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\send_text_messages;
use App\Jobs\send_text_notice;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\EveClient;
use Illuminate\Support\Facades\Log;
use App\Models\FailedSms;

class SendInvitationsController extends Controller
{
    private $_InvitationTpl;
    private $_Join;

    public function __construct()
    {
        parent::__construct();
        $this -> _InvitationTpl   = new InvitationTpl();
        $this -> _Join   = new JoinUsers();
    }

    //发送邀请函页面渲染
    public function index(Request $request)
    {
        $join_id = explode(',',$request['join_id']); //选择后的id
        $type=$request['type']; //前端选择状态
        $rfp_id = $request['rfp_id']; //询单id
        if(!is_numeric($rfp_id)){
            abort('503');
        }
        if($type == 0){
            $user = [];
        }else{
            //查询选中
            $user = DB::table('join_users')
                ->select('join_id','name')
                ->where('status','!=',0)
                ->whereIn('join_id',$join_id)
                ->get();
        }
        $names = DB::table('invitation_tpl')
            ->select('tpl_id','name')
            ->where('rfp_id','=',$rfp_id)
            ->where('status','!=',0)
            ->get();
        return view("SendInvitations.index",["names"=>$names,'type'=>$type,'user'=>$user,'rfp_id'=>$rfp_id]);
    }

    public function inform(Request $request)
    {
        $join_id = explode(',',$request['join_id']); //选择后的id
        $type=$request['type']; //前端选择状态
        $rfp_id = $request['rfp_id']; //询单id
        if(!is_numeric($rfp_id)){
            abort('503');
        }
        if($type == 0){
            $user = [];
        }else{
            //查询选中
            $user = DB::table('join_users')
                ->select('join_id','name')
                ->where('status','!=',0)
                ->whereIn('join_id',$join_id)
                ->get();
        }
        $names = DB::table('invitation_tpl')
            ->select('tpl_id','name')
            ->where('rfp_id','=',$rfp_id)
            ->where('status','!=',0)
            ->get();
        return view('SendInvitations/inform',["names"=>$names,'type'=>$type,'user'=>$user,'rfp_id'=>$rfp_id]);
    }
    //邀请函执行发送
    public function send_out(Request $request)
    {
        $join = $request['join_id']; //人员id 是否为空
        $rfp_id = intval($request['rfp_id']); //询单id
        $tpl_id = $request['tpl_id']; //邀请函id 是否为空
        $connect = $request['connect']; //模板连接
        $checkbox = $request['checkbox']; //判断是否为tpl_id true $connect  false $tpl_id

        if(!preg_match('/^[0-9]*$/',$rfp_id)){
            abort('503');
        }
        //如果join_id为空查询所有rfp_id对应的join_id
        if(empty($join)){
            $join_id = DB::table('join_users')
                ->select('join_id')
                ->where('rfp_id','=',$rfp_id)
                ->where('status','!=',0)
                ->get();
        }else{
            $join_id = $join;
        }
        //执行发送邀请
        if(empty($tpl_id) && empty($connect)){
            return ['num'=>2,'msg'=>'请选择邀请函模板或输入模板连接'];
        }

        $data = [];
        $name = DB::table('rfp')
            ->select('meeting_name')
            ->where('rfp_id','=',$rfp_id)
            ->get();
        if($checkbox == 'true'){
            //使用模板连接发送

            $invitation = DB::table('join_users')
                ->select('join_users.phone',
                        'join_users.join_id',
                        'join_users.name')
                ->where('join_users.rfp_id','=',$rfp_id)
                ->whereIn('join_users.join_id',$join_id)
                ->where('join_users.status','!=',0)
                ->get();

            if(count($join_id) !== count($invitation)){
                return response()->json(['num'=>1,'msg'=>'数量不对应']);
            }
            //短信内容拼装
            foreach($invitation as $key=>$val){
                $sign = 'HTw_SMg_01!znb';
                $content = '现诚邀您参加'.$name[0]['meeting_name'].'会议，点击链接查看详情,'.$connect;
                $token =md5(md5($val['phone']).md5($content).$sign);
                $message = 'http://www.eventown.com/api/message/sendMessage?phone='.$val['phone'].'&content='.$content.'&token='.$token;
                $data[$key]['join_id'] = $val['join_id'];
                $data[$key]['message'] = $message;
            }

        }else{
            //使用tpl_id发送
            $invitation = DB::table('invitation_tpl')
                ->join('join_users','invitation_tpl.rfp_id','=','join_users.rfp_id')
                ->select('join_users.phone',
                    'join_users.join_id',
                    'join_users.name',
                    'invitation_tpl.title')
                ->where('invitation_tpl.rfp_id','=',$rfp_id)
                ->where('invitation_tpl.tpl_id',$tpl_id)
                ->where('join_users.rfp_id','=',$rfp_id)
                ->whereIn('join_users.join_id',$join_id)
                ->where('join_users.status','!=',0)
                ->where('invitation_tpl.status','!=',0)
                ->get();

            if(count($join_id) !== count($invitation)){
                return response()->json(['num'=>1,'msg'=>'数量不对应']);
            }
            $code = urlencode('&');

            foreach($invitation as $key=>$val) {
                $sign = 'HTw_SMg_01!znb';
                $keys = 'ht-mt'; //h5 token

                $h5_url = str_replace('/index.php/h5/index','/h5/index',url('/h5/index')).'?r_id='.$rfp_id.$code.'j_id='.$val['join_id'].$code.'t_id='.$tpl_id.$code.'_token='.substr(md5($rfp_id . $val['join_id'] . $tpl_id . $keys),2,10);
                //$h5_url = str_replace('/index.php/h5/invitation','/h5/invitation',url('/h5/invitation')).'?r_id='.$rfp_id.$code.'j_id='.$val['join_id'].$code.'t_id='.$tpl_id.$code.'_token='.substr(md5($rfp_id . $val['join_id'] . $tpl_id . $keys),2,10);

                $content = '现诚邀您参加'.$name[0]['meeting_name'].'会议，点击链接查看详情,'.$h5_url;

                $token =md5(md5($val['phone']).md5($content).$sign);
                $message = 'http://www.eventown.com/api/message/sendMessage?phone='.$val['phone'].'&content='.$content.'&token='.$token;
                $data[$key]['join_id'] = $val['join_id'];
                $data[$key]['message'] = $message;

            }

        }

        $session_id = session::get('user.id');
       $fail = [];
       $success = [];
            foreach($data as $k=>$v){
               
                $join_id = $v['join_id'];
                $message = $v['message'];
                $date = file_get_contents($message);
                $arr = json_decode($date, true);
                if($arr['errno'] == 0){
                    $success[$k]['join_id'] = $join_id;
                    $success[$k]['send_user'] = $session_id;
                    $success[$k]['send_time'] = date('Y-m-d H:i:s');
                    if (empty($tpl_id)) {
                        $success[$k]['send_type'] = 2;
                    } else {
                        $success[$k]['send_type'] = 1;
                    }
                    $success[$k]['tpl_id'] = $tpl_id;
                    $success[$k]['constom_url'] = $connect;
                    $success[$k]['rfp_id'] = $rfp_id;
                    
                }else{
                    $fail[$k]['join_id'] = $join_id;
                    $fail[$k]['connect'] = $v['message'];
                    $fail[$k]['creation_at'] = date('Y-m-d H:i:s',time());
                }
            }
           
            $success_number = DB::table('invitation_send')->insert($success);
            if(!empty($fail)){
                $fail_number = DB::table('failed_sms')->insert($fail);
            }
            if(!isset($fail_number)){
                return response()->json(['num'=>0,'msg'=>'发送成功']);
            }else{
                return response()->json(['num'=>0,'msg'=>'发送'.count($fail).'个失败']);
            }
    }

    //发送通知
    public function send_notice(Request $request)
    {
        $join = $request['join_id']; //人员id 是否为空
        $rfp_id = $request['rfp_id']; //询单id
        
        $connect = $request['connect']; //模板连接
                if(!preg_match('/^[0-9]*$/',$rfp_id)){
            abort('503');
        }
        //如果join_id为空查询所有rfp_id对应的join_id
        if(empty($join)){
            $join_id = DB::table('join_users')
                ->select('join_id')
                ->where('rfp_id','=',$rfp_id)
                ->where('status','!=',0)
                ->get();
        }else{
            $join_id = $join;
        }
        if(empty($join_id)){
            return ['num'=>'2','msg'=>'您未选择参会人'];
        }
//        //执行发送邀请
        if(empty(trim($connect))){
            return ['num'=>1,'msg'=>'请输入短信内容'];
        }
            $invitation = DB::table('join_users')
                ->select('phone',
                    'join_id',
                    'name')
                ->where('rfp_id','=',$rfp_id)
                ->whereIn('join_id',$join_id)
                ->where('join_users.status','!=',0)
                ->get();

            if(count($join_id) !== count($invitation)){
                return '数量不对应';
            }
            $data = [];
            foreach($invitation as $key=>$val) {
                
                $sign = 'HTw_SMg_01!znb';
                $keys = 'ht-mt'; //h5 token
                $token =md5(md5($val['phone']).md5($connect).$sign);
                $message = 'http://www.eventown.com/api/message/sendMessage?phone='.$val['phone'].'&content='.$connect.'&token='.$token;
                $data[$key]['join_id'] = $val['join_id'];
                $data[$key]['message'] = $message;
            }
            
        $session_id = session::get('user.id');
        foreach($data as $k=>$v){
            $join_id = $v['join_id'];
            $message = $v['message'];
            $fail = [];
            $success = [];
            foreach($data as $k=>$v){
                $join_id = $v['join_id'];
                $message = $v['message'];
                $date = file_get_contents($message);
                $arr = json_decode($date, true);
                
                if($arr['errno'] == 0){
                    $success[$k]['join_id'] = $join_id;
                    $success[$k]['send_user'] = $session_id;
                    $success[$k]['send_time'] = date('Y-m-d H:i:s');
                    if (empty($tpl_id)) {
                        $success[$k]['send_type'] = 2;
                    } else {
                        $success[$k]['send_type'] = 1;
                    }
                    $success[$k]['constom_url'] = $message;
                    $success[$k]['rfp_id'] = $rfp_id;
                    
                }else{
                    $fail[$k]['join_id'] = $join_id;
                    $fail[$k]['connect'] = $message;
                    $fail[$k]['creation_at'] = date('Y-m-d H:i:s',time());
                }
            }
           
            $success_number = DB::table('notify_send')->insert($success);
            if(!empty($fail)){
                $fail_number = DB::table('failed_sms')->insert($fail);
            }
            if(!isset($fail_number)){
                return response()->json(['num'=>0,'msg'=>'发送成功']);
            }else{
                return response()->json(['num'=>0,'msg'=>'发送'.count($fail).'个失败']);
            }
        }
    }
}

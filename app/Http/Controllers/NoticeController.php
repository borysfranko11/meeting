<?php
/**
 * des: 会议部分逻辑处理控制器
 */
namespace App\Http\Controllers;


use App\Models\Logs;
use App\Models\UserNotice;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> _User_notice = new UserNotice();
        $this -> _Logs = new Logs();
    }

    //获取首页日历消息通知
    public function getNotice(Request $request)
    {
        if( $request -> isMethod( 'GET' ) ){
            $reqs = $request -> except( '_token' );
            $start_time = empty($reqs['start_time'])?strtotime(date('Y-m-01', strtotime(date("Y-m-d")))):strtotime($reqs['start_time']);
            $end_time = empty($reqs['end_time'])?strtotime(date("Y-m-01",strtotime("+1 month"))):strtotime($reqs['end_time']);
            $where = 'responsiblead='.session('user')['id'].' and notice_ctime>='.$start_time.' and notice_ctime<'.$end_time;
            $rs = DB::table('user_notice')->whereRaw($where)->get();
            return json_encode($rs);
        }
        return json_encode(array());

    }
    //获取首页消息通知
    public function getLogs(){
        //未读信息总条数
        $where = '(belong=0 or belong='.session('user')['id'].') and type=1 and `read`=0';
        $count = DB::table('log')->whereRaw($where)->count();
        //未读信息
        $rs = DB::table('log')->whereRaw($where)->orderby('create_time','desc')->limit(30)->get();
        if($rs){
            foreach ($rs as $k=>$v){
                $rs[$k]['create_time_value'] = date('Y-m-d H:i:s',$v['create_time']);
            }
        }

        return json_encode(array('count'=>$count,'data'=>$rs));
    }

    //获取今日未读消息
    public function getLogsNum(){
        $start_time = strtotime(date("Y-m-d 00:00:00"));
        $end_time = strtotime(date("Y-m-d 23:59:59"));
        $where = '(belong=0 or belong='.session('user')['id'].') and type=1 and `read`=0 and create_time>='.$start_time.' and create_time<='.$end_time;
        $count = DB::table('log')->whereRaw($where)->count();
        return $count;

    }


}

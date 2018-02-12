<?php
/**
 * des: 订单逻辑处理控制器
 */
namespace App\Http\Controllers;


use App\Models\OrderOrigin;
use App\Models\Rfp;
use App\Models\RfpPerform;
use App\Models\RfpPicFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Illuminate\Support\Facades\DB;

class WapController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this -> _Rfp           = new Rfp();
        $this -> _Order         = new OrderOrigin();
        $this-> _Rfp_perform    = new RfpPerform();
        $this-> _Rfp_pic_file    = new RfpPicFile();
    }


    public function index( Request $request )
    {
        $reqs                  = $request -> except( '_token' );
        $meeting_status        = empty($reqs['meeting_status'])?'':filterParam( $reqs['meeting_status'] );
        $page                  = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                 = empty($reqs['limit'])?10:(int)$reqs['limit'];

        // 根据会议状态查询
        if ($meeting_status != '') {
            $where['status'] = $meeting_status;
        }
        $where['page']  = $page;
        $where['limit'] = $limit;

        $datas = $this->getData($where);

        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $role  = '';
        if (in_array('会议发起人',$roles) || session('user')['id'] == '10001') {
           $role = 'create';
        }

        return view( '/wap/my_meeting', ["user_info" =>  session('user'), 'res' => $datas, 'meeting_status' => $meeting_status ,'role'=>$role] );

    }


    public function ajax_index( Request $request )
    {
        $reqs                  = $request -> except( '_token' );
        $meeting_status        = empty($reqs['meeting_status'])?'':filterParam( $reqs['meeting_status'] );
        $page                  = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                 = empty($reqs['limit'])?10:(int)$reqs['limit'];

        // 根据会议状态查询
        if ($meeting_status != '') {
            $where['status'] = $meeting_status;
        }
        $where['page']  = $page;
        $where['limit'] = $limit;

        $datas = $this->getData($where);
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $role  = '';
        if (in_array('会议发起人',$roles) || session('user')['id'] == '10001') {
            $role = 'create';
        }
        $arr = array('data'=>$datas,'role'=>$role);

        return json_encode($arr);
    }


    public function getData($where){
        $sql = $this->formatSql($where);
        //执行sql语句
        try
        {
            $datas = DB::select($sql);

            if(!empty($datas)){
                foreach ($datas as $k=>$v){
                    $datas[$k]['start_time']    = date('Y-m-d', $v['start_time']);
                    $datas[$k]['end_time']      = date('Y-m-d', $v['end_time']);
                    $datas[$k]['status_name']   = config('system.meeting_status.'.$v['status'].'.value');
                }
            }

            return $datas;

        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "会议明细导出,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array();
        }
    }

    protected function formatSql($where) {
        $field = 'rfp_id,meeting_code,meeting_name,start_time,end_time,budget_total_amount,provincedesc,citydesc,people_num,status,user_name';
        $sql   = 'SELECT [*] FROM rfp WHERE 1=1 ';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $where_role = array();
        if (!in_array('超级管理员',$roles)) {
            if (in_array('会议发起人', $roles)) {
                $where_role[] = ' (user_code = ' . session('user')['id'].' or deposit_code= '. session('user')['id'] .')';
            }
            if (in_array('会议授权人', $roles) ) {
                $where_role[] = ' user_code = ' . session('user')['id'];
            }
            if (in_array('费用审核员', $roles)) {
                $where_role[] = ' marketorgcode = "' . session('user')['marketorgcode'] . '"';
            }
        }
        if(!empty($where_role)){
            $sql .= ' and '.implode(' and ',$where_role);
        }

        if (isset($where['status'])) {
            $sql .= sprintf(' AND status = %d', $where['status']);
        } else {//默认不查询已取消的订单
            $sql .= sprintf(' AND status in (20,30,40,50)');
        }

        //查询sql
        $limit  = $where['limit'] ? $where['limit'] : 10;
        $offset = $where['page'] ? ($where['page'] - 1) * $limit : 0;
        $sql .= ' ORDER BY rfp_id DESC';
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        return str_replace('[*]', $field, $sql);

    }


    //水单待确认
    public function confirm_memo( Request $request ) {
        $reqs       = $request->except('_token');
        $res        = array();
        if(!empty($reqs['rfp_id'])){
            //获取会议信息
            $res        = $this-> _Rfp ->getRfpByRfpid($reqs['rfp_id']);
            $res        = isset($res[0])?$res[0]:array();
        }

        return view('wap/confirm_memo', array('res' => $res));
    }

    public function memo_detail( Request $request ) {
        $reqs            = $request->except('_token');
        $rfp_info        = array();
        $perform_info    = array();
        $files           = array();
        if(!empty($reqs['rfp_id'])){
            $rfp_info       = $this -> _Rfp -> getRfpByRfpid($reqs['rfp_id']);
            $rfp_info       = isset($rfp_info[0]) ? $rfp_info[0] : array();
            //获取perform详细信息
            $perform_info   = $this-> _Rfp_perform ->getDetail($reqs['rfp_id']);
            $perform_info   = isset($perform_info[0]) ? $perform_info[0] : array();
            //获取pic_file详细信息
            $files          = $this -> _Rfp_pic_file -> getDetail($reqs['rfp_id']);
        }
        $data = array(
            'rfp_info'      => $rfp_info,
            'equipments'    => $perform_info,
            'files'         => $files,
        );

        return view('wap/memo_defray_detail', $data);
    }

}

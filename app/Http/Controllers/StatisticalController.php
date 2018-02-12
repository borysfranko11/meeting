<?php
/**
 * des: 数据统计控制器
 */
namespace App\Http\Controllers;


use App\Models\Rfp;
use App\Models\RfpPicFile;
use App\Models\RfpPicInvoiceFile;
use App\Models\RfpSettlement;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    public $limit = 10;
    private $_Rfp;
    private $_RfpPicFile;
    private $_RfpSettlement;
    private $_RfpPicInvoiceFile;
    public function __construct()
    {
        parent::__construct();
        $this-> _Rfp                = new Rfp();
        $this-> _RfpPicFile         = new RfpPicFile();
        $this-> _RfpSettlement      = new RfpSettlement();
        $this -> _RfpPicInvoiceFile = new RfpPicInvoiceFile();
    }

    public function detail( Request $request )
    {
        $request    = $request -> except( '_token' );
        $data       = $this->meetingDetail( $request );
        $provinces  = $this->getProvinces();
        $status     = config('system.meeting_status');
        return view( '/statistical/index' , ["data" =>  $data, 'provinces' => $provinces, 'status' => json_encode($status) ]);
    }


    public function monthly( Request $request)
    {
        $reqs = $request -> except( '_token' );
        $data = $this->monthlyStatement($reqs);
        return view( '/statistical/tongji' , [ "data" =>  json_encode($data) ]);
    }

    //月结详情
    public function monStatementDetail(Request $request){
        $reqs = $request -> except( '_token' );
        $data = $this->monthlyDetail($reqs);
        return view( '/statistical/monStatementDetail' , [ "data" =>  json_encode($data) ]);
    }
    //月结会议详情
    public function monStaMeeting(Request $request){
        $reqs = $request -> except( '_token' );
        $data = $this->monthlyMeeting($reqs);
        return view( '/statistical/monStaMeeting' , [ "data" =>  json_encode($data) ]);
    }

    public function analysis()
    {
        dd( '报表分析' );
    }

    //会议明细列表
    public function meetingDetail( $reqs ){
        //格式化数字
        $begin_date         = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        $end_date           = date('Y-m-d 23:59:59', strtotime("$begin_date +1 month -1 day"));// 获取当前月份最后一天
        //$where['startTime']         = empty($reqs['start_time'])?strtotime($begin_date):strtotime(filterParam( $reqs['start_time'] ));
        //$where['endTime']           = empty($reqs['end_time'])?strtotime($end_date):strtotime(filterParam( $reqs['end_time'] ));
        $where['startTime']         = empty($reqs['start_time'])?'':strtotime(filterParam( $reqs['start_time'] ));
        $where['endTime']           = empty($reqs['end_time'])?'':strtotime(filterParam( $reqs['end_time'] ));
        $where['keyword']         = empty($reqs['keyword'])?'':filterParam( $reqs['keyword'] );//关键字
        $where['status']            = empty($reqs['status'])?'':filterParam( $reqs['status'] );//会议状态
        $where['provincedesc']      = empty($reqs['provincedesc'])?'':filterParam( $reqs['provincedesc'] );//省份
        $page                       = empty($reqs['page'])?1:(int)$reqs['page'];
        $limit                      = empty($reqs['limit'])?10:(int)$reqs['limit'];
        $arr['page']               = $page;
        $arr['limit']              = $limit;

        $arr['filter'] = [
            "start"     =>  $where['startTime'] ,
            "end"       =>  $where['endTime'] ,
            "keyword"   =>  $where['keyword'],
            "status"   =>  $where['status'],
            "provincedesc"   =>  $where['provincedesc'],
        ];
        $where = array_filter($where);//去空
        $data = array('where'=>$where,'page'=>$page,'limit'=>$limit);
        //构造sql语句
        $sql = $this->formatSql($data);

        //执行sql语句
        try
        {
            $count = DB::select($sql['sql_count']);
            $datas = DB::select($sql['sql']);
            $list = array();
            foreach ($datas as $key=>$val){
                $list[$key]['rfp_id']                   = $val['rfp_id'];
                $list[$key]['meeting_code']             = $val['meeting_code'];
                $list[$key]['meeting_name']             = $val['meeting_name'];
                $list[$key]['meeting_type_desc']                = $val['meeting_type_desc'];
                $list[$key]['clientele_num']            = $val['clientele_num'];
                $list[$key]['within_num']            = $val['within_num'];
                $list[$key]['nonparty_num']            = $val['nonparty_num'];
                $list[$key]['provincedesc']            = $val['provincedesc'];
                $list[$key]['citydesc']            = $val['citydesc'];
                $list[$key]['people_num']            = $val['people_num'];

                $list[$key]['start_time']               = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
                $list[$key]['end_time']                 = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
                $list[$key]['start_time_val']   = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
                $list[$key]['end_time_val']     = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
                $time_extend = json_decode($val['time_extend'],true);
                $list[$key]['time_extend']      = '';
                $time_extend_list = array();
                if(!empty($val['time_extend']) && !empty($time_extend)){
                    $list[$key]['time_extend']  = $time_extend;
                    foreach ($time_extend as $k=>$v){
                        $time_extend_list[$k]['start_time_val'] = empty($v['start_time'])?'':date('Y-m-d',$v['start_time']);
                        $time_extend_list[$k]['end_time_val']   = empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
                    }
                }
                $list[$key]['time_extend_val']          = $time_extend_list;
                $list[$key]['budget_total_amount']      = $val['budget_total_amount'];
                $list[$key]['ht_settlement_amount']     = $val['ht_settlement_amount'];
                $list[$key]['real_attendance_number']   = $val['real_attendance_number'];
                $list[$key]['people_num']               = $val['people_num'];
                $list[$key]['status']                   = $val['status'];
                $list[$key]['order_total_amount']       = $val['order_total_amount'];

            }
            $arr['data']                       = $list;
            $arr['count']               = $count[0]['count'];
            return json_encode($arr);
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "会议明细列表,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array();
        }

    }

    private function getRoles($step,$type=0){
        $roles = array_column(session('user')['role'], 'name');//取出用户所有角色名称重新组成数组
        $list = array();
        //TODO 用于测试
        $role = config('timeline.timelinkcreate.' . $step);
        $role = empty($role)?array():$role;
        $list = array_merge($list,$role);
        /* if(in_array('超级管理员', $roles) || $type == 1){
             return config('timeline.timelinkindex.' . $step);
         }
         if (in_array('会议发起人', $roles)) {
             $list = array_merge($list,config('timeline.timelinkcreate.' . $step));

         }
         if (in_array('费用审核员', $roles)){
             $list = array_merge($list,config('timeline.timelinkcheck.' . $step));
         }*/
        return $list;
    }

    //会议明细列表导出
    public function exportDetail( Request $request){
        $reqs = $request -> except( '_token' );
        //格式化数字
        $data = $this->formatData($reqs);
        //构造sql语句
        $data['isExport'] = '1';
        $sql = $this->formatSql($data);
        //执行sql语句
        try
        {
            $list = DB::select($sql['sql']);
            $file_name = date('Y-m-d',$data['where']['startTime']) . '至' . date('Y-m-d',$data['where']['endTime']) . '-会议信息.csv';
            $this->exportCsv4meeting($list, $file_name);
            exit;
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "会议明细导出,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            exit;
        }
    }

    public function formatData($reqs){
        $begin_date         = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));// 获取当前月份第一天
        $end_date           = date('Y-m-d 23:59:59', strtotime("$begin_date +1 month -1 day"));// 获取当前月份最后一天
        $where['startTime']         = empty($reqs['start_time'])?strtotime($begin_date):strtotime(filterParam( $reqs['start_time'] ));
        $where['endTime']           = empty($reqs['end_time'])?strtotime($end_date):strtotime(filterParam( $reqs['end_time'] ));
        $where['keyword']         = empty($reqs['keyword'])?'':filterParam( $reqs['keyword'] );//关键字
        $where['status']            = empty($reqs['status'])?'':filterParam( $reqs['status'] );//会议状态
        $where['provincedesc']      = empty($reqs['provincedesc'])?'':filterParam( $reqs['provincedesc'] );//省份
        $page                       = empty($reqs['page'])?'1':(int)$reqs['page'];
        $limit                      = empty($reqs['limit'])?$this->limit:(int)$reqs['limit'];
        $where = array_filter($where);//去空

        return array('where'=>$where,'page'=>$page,'limit'=>$limit);

    }

    public function formatSql($data){
        $where = $data['where'];
        //$field = 'rfp_id,meeting_code,meeting_name,user_name,marketorgdesc,start_time,end_time,time_extend,budget_total_amount,ht_settlement_amount,real_attendance_number,people_num,status';
        $field = 'rfp_id,meeting_code,meeting_name,meeting_type_desc,start_time,end_time,time_extend,budget_total_amount,clientele_num,within_num,nonparty_num,provincedesc,citydesc,people_num,status,real_attendance_number,ht_settlement_amount,order_total_amount';
        $sql   = 'SELECT [*] FROM rfp WHERE 1=1 AND `status` >= 20';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        $where1 = '';$where2 = '';
        if (!in_array('超级管理员',$roles)) {
            if (in_array('会议发起人',$roles)) {
                $where1 = ' user_code = '.session('user')['id'];
            }
            if (in_array('费用审核员',$roles)) {
                $where2 = ' marketorgcode = "'.session('user')['marketorgcode'].'"';
            }
        }
        // 根据角色进行搜索
        if(!empty($where1) && !empty($where2)){
            $sql .= ' and '.($where1 .' or '.$where2);
        }elseif (!empty($where1)){
            $sql .= ' and '.$where1;
        }elseif (!empty($where2)){
            $sql .= ' and '.$where2;
        }

        // 根据会议开始时间结束时间查询
        if (isset($where['startTime'])) {
            $sql .= sprintf(' AND create_time >= "%d" ',$where['startTime']);
        }
        if (isset($where['endTime'])) {
            $sql .= sprintf(' AND create_time <= "%d"',$where['endTime']);
        }
        // 根据负责人查询
        if (isset($where['keyword'])) {
            $sql .= sprintf(' AND (user_name LIKE "%s" OR meeting_code LIKE "%s" OR meeting_name LIKE "%s" OR meeting_type_desc LIKE "%s" )', '%'.$where['keyword'].'%', '%'.$where['keyword'].'%', '%'.$where['keyword'].'%', '%'.$where['keyword'].'%');
        }
        // 根据会议状态查询
        if (isset($where['status'])) {
            $sql .= sprintf(' AND status = %d', $where['status']);
        }
        if (isset($where['provincedesc'])) {
            $sql .= ' AND provincedesc = "' . $where['provincedesc'] . '"';
        }
        //计算总条数
        $arr['sql_count'] = str_replace('[*]', 'COUNT(rfp_id) AS count', $sql);
        //查询sql
        $limit  = $data['limit'] ? $data['limit'] : 10;
        $offset = $data['page'] ? ($data['page'] - 1) * $limit : 0;
        $sql .= ' ORDER BY rfp_id DESC';
        if (!isset($data['isExport'])) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }
        $arr['sql']  = str_replace('[*]', $field, $sql);
        return $arr;
    }

    /*导出到CSV*/
    private function exportCsv4meeting($data, $file_name) {
        if (empty($data)) {
            return returnJson(false,'','下载数据出错,请稍候再试.');
        }

        // 导出CSV
        $title_arr = array(
            '会议编码', '会议名称', '负责人', '成本中心', '会议状态',
            '会议开始日期', '会议结束日期', '预算金额', '参会人数', '签到人数', '订单金额￥',
        );
        $str       = implode(",", $title_arr);
        $str       = $str . PHP_EOL;

        foreach ($data as $k => $val) {
            $meeting_code               = $val['meeting_code'];
            $meeting_name               = $val['meeting_name'];
            $user_name                  = $val['user_name'];
            $marketorgdesc              = $val['marketorgdesc'];
            $start_time                 = empty($val['start_time'])?'':date('Y-m-d',$val['start_time']);
            $end_time                   = empty($val['end_time'])?'':date('Y-m-d',$val['end_time']);
            //$time_extend = $val['time_extend'];
            $budget_total_amount        = $val['budget_total_amount'];
            $ht_settlement_amount       = $val['ht_settlement_amount'];
            $real_attendance_number     = $val['real_attendance_number'];
            $people_num                 = $val['people_num'];
            $status                     = config('system.meeting_status.'.$val['status'].'.value');
            $str .= $meeting_code . "," . $meeting_name . "," . $user_name . "," . $marketorgdesc . "," . $status . "," . $start_time . "," . $end_time . ",";
            $str .= $budget_total_amount . "," . $people_num . "," . $real_attendance_number . "," . $ht_settlement_amount . PHP_EOL;
        }
        $this->doExportCsv($file_name, $str);
    }

    private function doExportCsv($filename, $data) {

        $data = iconv('utf-8', "gb2312//IGNORE", $data);

        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo $data;
        exit();
    }

    //获取会议所有状态
    public function getMeetingStatus(){
        $meeting_status =  config('system.meeting_status');
        $meeting_status = array_values($meeting_status);
        return json_encode($meeting_status);
    }

    //获取月结统计信息
    public function monthlyStatement($reqs){
        $data['page']          = empty($reqs['page'])?'1':(int)$reqs['page'];
        $begin_date            = date('Y-m');
        $data['mydate']        = empty($reqs['mydate'])?$begin_date:filterParam( $reqs['mydate'] );
        $data['marketorgcode'] = empty($reqs['marketorgcode'])?'':filterParam( $reqs['marketorgcode'] );
        $data['limit']         = empty($reqs['limit'])?$this->limit:(int)$reqs['limit'];
        //构造sql语句
        $sql = $this->formatMonthlySql($data);
        //执行sql语句
        try
        {
            $count = DB::select($sql['sql_count']);
            $datas = DB::select($sql['sql']);
            $marketorg = DB::table('marketorg')->select('marketorgcode as id','marketorgdesc as value')->get();
            return array('count'=>$count[0]['count'],'from_date'=>$data,'data'=>$datas,'marketorg'=>$marketorg);
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "月结列表,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array('count'=>0,'date'=>'','data'=>'');
        }


    }

    public function formatMonthlySql($where){
        $table_zsh_rfp_settlement    = 'rfp_settlement';
        $fields                      = 'r.marketorgcode,r.marketorgdesc,IFNULL( SUM( IFNULL(s.total_money, 0) ), 0 ) AS ht_settlement_amount_total';
        $sql ='SELECT [*] FROM  '.$table_zsh_rfp_settlement.' AS s
               LEFT JOIN rfp AS r ON s.settlement_rfp_id = r.rfp_id
               WHERE 1=1 ';
        //获取用户角色
        $roles =  array_column(session('user')['role'],'name');//取出用户所有角色名称重新组成数组
        if (!in_array('超级管理员',$roles)) {
            if (in_array('费用审核员',$roles)) {
                $where['marketorgcode'] = session('user')['marketorgcode'];
            }
        }
        if (!empty($where['mydate'])) {
            $first_day      = date('Y-m-01', strtotime($where['mydate']));
            $last_day       = date('Y-m-d 23:59:59', strtotime("$first_day+1 month -1 day"));
            $first_day_time = strtotime($first_day);
            $last_day_time  = strtotime($last_day);
            $sql .= " AND UNIX_TIMESTAMP(s.settlement_ctime) >= {$first_day_time} AND UNIX_TIMESTAMP(s.settlement_ctime) <= {$last_day_time} ";
        }

        // 单位查询
        if (!empty($where['marketorgcode'])) {
            $sql .= sprintf(' AND r.marketorgcode = "%s"', $where['marketorgcode']);
        }

        // 只查询已上传水单
        $sql .= ' AND r.status = 50 ';

        $sql .= ' GROUP BY r.marketorgcode';

        $_sql_count = str_replace('[*]', $fields, $sql);
        $arr['sql_count']  = "SELECT COUNT(1) AS count FROM ($_sql_count) AS mycount";


        $limit  = $where['limit'] ? $where['limit'] : 10;
        $offset = $where['page'] ? ($where['page'] - 1) * $limit : 0;

        $sql .= ' ORDER BY r.rfp_id DESC';

        $sql .= ' LIMIT ' . $offset . ',' . $limit;

        $arr['sql']          = str_replace('[*]', $fields, $sql);

        return $arr;

    }

    //月结详情
    public function  monthlyDetail($reqs){

        $data['mydate']        = empty($reqs['mydate'])?'':filterParam( $reqs['mydate'] );
        $data['marketorgcode'] = empty($reqs['marketorgcode'])?'':filterParam( $reqs['marketorgcode'] );
        if(empty($data['mydate']) || empty($data['marketorgcode'])){
            return array();
        }
        //构造sql语句
        $sql = $this->formatStaDetailSql($data);
        //执行sql语句
        try
        {
            $datas = DB::select($sql['sql']);
            //格式化返回参数
            $res = $this->formatStaDetailReturnData($datas);
            $res['mydate']          = date('Y年m月', strtotime($data['mydate']));
            return $res;
        }
        catch (\Exception $e)
        {
            //写入文本日志
            $message = "月结详情,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
            Log::alert( $message );
            return array('data'=>'');
        }
    }

    public function formatStaDetailSql($where){
        $table_rfp               = 'rfp';
        $table_rfp_perform       = 'rfp_perform';
        $table_rfp_settlement    = 'rfp_settlement';
        $fields                  = 'r.rfp_id,r.ht_settlement_amount,r.meeting_code,r.marketorgdesc,r.meeting_name,s.*,p.receive_status';
        $sql = 'SELECT [*] FROM '.$table_rfp_settlement.' AS s
                LEFT JOIN '.$table_rfp.' AS r ON s.settlement_rfp_id  = r.rfp_id
                LEFT JOIN '.$table_rfp_perform.' AS p ON s.settlement_rfp_id  = p.rfp_id
                WHERE 1=1 ';

        if (!empty($where['mydate'])) {
            $first_day      = date('Y-m-01', strtotime($where['mydate']));
            $last_day       = date('Y-m-d 23:59:59', strtotime("$first_day+1 month -1 day"));
            $first_day_time = strtotime($first_day);
            $last_day_time  = strtotime($last_day);
            $sql .= ' AND UNIX_TIMESTAMP(s.settlement_ctime) >= '.$first_day_time.' AND UNIX_TIMESTAMP(s.settlement_ctime) <= '.$last_day_time;
        }

        // 单位查询
        if (!empty($where['marketorgcode'])) {
            $sql .= sprintf(' AND r.marketorgcode = "%s"', $where['marketorgcode']);
        }

        // 只查询已上传水单
        $sql .= ' AND r.status =50 ';

        $arr['sql_count'] = str_replace('[*]', 'COUNT(s.settlement_rfp_id) AS count', $sql);

        $sql .= ' ORDER BY s.settlement_ctime DESC , r.create_time DESC , r.rfp_id DESC';

        $arr['sql']          = str_replace('[*]', $fields, $sql);

        return $arr;
    }

    private function formatStaDetailReturnData($list) {
        $ht_settlement_amount_total        = 0;// 会议支出金额总和
        $deductible_invoice_money_total    = 0;// 可抵税发票金额总和
        $no_deductible_invoice_money_total = 0;// 不可抵税发票金额总和
        $tax_money_total                   = 0;// 税金总和
        $subtotal_total                    = 0;// 小计总和
        $service_charge_total              = 0;// 服务费总和
        $ht_total_money                    = 0;// 与会唐结算金额总和
        $single_marketorgdesc              = '';
        $tmp                               = array();
        foreach ($list as $k => $v) {
            if (!in_array($v['rfp_id'], $tmp)) {
                $tmp [] = $v['rfp_id'];
                $ht_settlement_amount_total += $v['ht_settlement_amount'];
            }
            $deductible_invoice_money_total    = $deductible_invoice_money_total + $v['deductible_invoice_money'];
            $no_deductible_invoice_money_total = $no_deductible_invoice_money_total + $v['no_deductible_invoice_money'];
            $tax_money_total                   = $tax_money_total + $v['tax_money'];
            $subtotal_total                    = $subtotal_total + $v['subtotal'];
            $service_charge_total              = $service_charge_total + $v['service_charge'];
            $ht_total_money                    = $ht_total_money + $v['total_money'];
            $single_marketorgdesc              = $v['marketorgdesc'];
        }
        $data['data']                              = $list;
        $data['count']                              = count($list);
        $data['ht_settlement_amount_total']        = sprintf("%.2f",$ht_settlement_amount_total);
        $data['deductible_invoice_money_total']    = sprintf("%.2f",$deductible_invoice_money_total);
        $data['no_deductible_invoice_money_total'] = sprintf("%.2f",$no_deductible_invoice_money_total);
        $data['tax_money_total']                   = sprintf("%.2f",$tax_money_total);
        $data['subtotal_total']                    = sprintf("%.2f",$subtotal_total);
        $data['service_charge_total']              = sprintf("%.2f",$service_charge_total);
        $data['ht_total_money']                    = sprintf("%.2f",$ht_total_money);
        $data['single_marketorgdesc']              = $single_marketorgdesc;
        return $data;
    }

    //月结会议结算信息
    public function monthlyMeeting($reqs){
        $rfp_id  = empty($reqs['rfp_id'])?'':filterParam( $reqs['rfp_id'] );
        if(empty($rfp_id)){
            return returnJson(false,'','参数缺失');
        }
        //获取会议信息
        $rfp = $this->_Rfp->getRfpByRfpid($rfp_id);
        $data['meeting']    = isset($rfp[0])?$rfp[0]:array();
        $data['meeting']['time_extend'] = '';//前端未用到的字段，有值时需特殊处理，否则前端报错
        //获取结算信息
        $settlement         = $this->_RfpSettlement->getDetail($rfp_id);
        $data['settlement'] = $this->formatMonthMeetingSettlement($settlement);
        //获取水单信息
        $data['picFile']    = $this->_RfpPicFile->getDetail($rfp_id);
        //获取发票信息
        $data['invoice']    = $this->_RfpPicInvoiceFile->getDetail($rfp_id);
        return $data;
    }
    private function formatMonthMeetingSettlement($list) {
        if(empty($list))return array();
        $deductible_invoice_money_total    = 0;// 可抵税发票金额总和
        $no_deductible_invoice_money_total = 0;// 不可抵税发票金额总和
        $tax_money_total                   = 0;// 税金总和
        $subtotal_total                    = 0;// 小计总和
        $service_charge_total              = 0;// 服务费总和
        $ht_total_money                    = 0;// 与会唐结算金额总和
        foreach ($list as $k => $v) {
            $deductible_invoice_money_total    = $deductible_invoice_money_total + $v['deductible_invoice_money'];
            $no_deductible_invoice_money_total = $no_deductible_invoice_money_total + $v['no_deductible_invoice_money'];
            $tax_money_total                   = $tax_money_total + $v['tax_money'];
            $subtotal_total                    = $subtotal_total + $v['subtotal'];
            $service_charge_total              = $service_charge_total + $v['service_charge'];
            $ht_total_money                    = $ht_total_money + $v['total_money'];
        }
        $data['data']                              = $list;
        $data['count']                              = count($list);
        $data['deductible_invoice_money_total']    = sprintf("%.2f",$deductible_invoice_money_total);
        $data['no_deductible_invoice_money_total'] = sprintf("%.2f",$no_deductible_invoice_money_total);
        $data['tax_money_total']                   = sprintf("%.2f",$tax_money_total);
        $data['subtotal_total']                    = sprintf("%.2f",$subtotal_total);
        $data['service_charge_total']              = sprintf("%.2f",$service_charge_total);
        $data['ht_total_money']                    = sprintf("%.2f",$ht_total_money);
        return $data;
    }
    private function getProvinces(){
        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign('');
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


    /**
     * 保存结算信息接口
     */
    public function saveRfpSettlement( Request $request ) {
        $reqs = $request -> except( '_token' );
        $reqs = authcode($reqs['param'], 'DECODE');
        $reqs = json_decode($reqs, true);
        try {
            // 0.根据会议编码查询会议信息是否存在
            $param = $this->_doCheckParam4InsertRfpSettlement( $reqs );

            // 1. 保存结算信息到数据库
            $param['settlement_id'] = $this->_doInsertRfpSettlement($param);

            // 2. 保存发票信息
            $this->_doInsertRfpPicInvoiceFile($param);

            $this->response_json(0, '保存结算信息成功');
        } catch (Exception $e) {
            //$message = "保存结算信息到数据库失败,参数信息是:" . json_encode($this->param);
            //$this->log($message, 'error');
            $this->response_json($e->getCode(), $e->getMessage());
        }
    }
    /**
     * 输出json信息
     *
     * @param int    $code 返回码
     * @param string $msg  返回消息
     * @param array  $data 返回数据
     */
    public static function response_json($code, $msg = '', $data = array()) {
        if (!is_numeric($code)) {
            die('返回码必须是数字');
        }
        $result = array(
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        );
        header("Content-type:application/json");
        die(json_encode($result));
    }
    /**
     * 保存发票信息
     *
     * @param $param
     *
     * @throws Exception
     */
    private function _doInsertRfpPicInvoiceFile($param) {
        try {
            $invoice_list = explode(',', $param['file_path']);
            if (!empty($invoice_list)) {
                foreach ($invoice_list as $invoice) {
                    if (!empty($invoice)) {
                        $insert_data ['rfp_id']        = $param['rfp_id'];
                        $insert_data ['settlement_id'] = $param['settlement_id'];
                        $insert_data ['pic_url']       = $invoice;
                        $insert_data ['creat_time']    = time();
                        // 2.1 插入发票文件到数据库
                        DB::table('rfp_pic_invoice_file')->insert($insert_data);
                    }
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 保存结算信息
     *
     * @param $param
     *
     * @return int
     * @throws Exception
     */
    private function _doInsertRfpSettlement( $param ) {
        try {
            $rfp_id                                                     = $param['rfp_id'];
            $insert_rfp_settlement_data ['settlement_rfp_id']           = $rfp_id;
            //$insert_rfp_settlement_data ['meeting_code']                = $param['meeting_code'];
            //$insert_rfp_settlement_data ['order_no']                    = $param['order_no'];
            //$insert_rfp_settlement_data ['order_type']                  = $param['order_type'];
            $insert_rfp_settlement_data ['deductible_invoice_money']    = $param['deductible_invoice_money'];
            $insert_rfp_settlement_data ['no_deductible_invoice_money'] = $param['no_deductible_invoice_money'];
            //$insert_rfp_settlement_data ['tax_rate']                    = $param['tax_rate'];
            $insert_rfp_settlement_data ['tax_money']                   = $param['taxes'];
            $insert_rfp_settlement_data ['subtotal']                    = $param['subtotal'];
            $insert_rfp_settlement_data ['service_charge']              = $param['service_charge'];
            $insert_rfp_settlement_data ['total_money']                 = $param['total'];
            $insert_rfp_settlement_data ['ht_money']                 = $param['total'];
            //$insert_rfp_settlement_data ['file_path']                   = $param['file_path'];
            //$insert_rfp_settlement_data ['remark']                      = $param['remark'];
            $insert_rfp_settlement_res                                  = DB::table('rfp_settlement')->insert($insert_rfp_settlement_data);
            if (!$insert_rfp_settlement_res) {
                throw new SystemError($error_code = 30001, $message = '插入结算表数据失败');
            }
            return $insert_rfp_settlement_res;
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function _doCheckParam4InsertRfpSettlement( $reqs ) {
        try {
            $param                        = $reqs;
            $rfp_info                     = $this->getRfpByRfp($param['meeting_code']);
            if (empty($rfp_info)) {
                throw new SystemError($error_code = -1, $message = '该会议在会议平台不存在');
            }
            $param['rfp_id']   = $rfp_info[0]['rfp_id'];
            $param['rfp_info'] = $rfp_info[0];
            return $param;
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function getRfpByRfp( $meeting_coded ){
        try {
            $sql = ' SELECT * FROM rfp WHERE `meeting_code` = "'.$meeting_coded.'"';
            $picList   = DB::select($sql);
            return $picList;
        } catch (Exception $e) {
            Log::alert( $e->getMessage() );
        }
    }
}
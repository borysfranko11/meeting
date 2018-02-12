<?php

namespace App\Http\Controllers;

use App\Models\InvitationTpl;
use App\Models\JoinUsers;
use App\Models\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvitationController extends Controller
{

    private $__Invitation;
    private $__UserInfo;
    private $__PLogs;


    public function __construct()
    {
        parent::__construct();
        $this->__UserInfo = new JoinUsers();
        $this->__PLogs = new ParticipantLog();
        $this->__Invitation = new InvitationTpl();
    }


    /**
     *  邀请函列表
     *   2017-9-7
     *   Wind
     */
    public function lists( Request $request)
    {
        if( $request->isMethod('POST') )
        {
            $url = array();
            $url['rfp_id']   = $request->input('rfp_id');
            $url['name']     = $request ->input('name');
        }
        if( $request->isMethod('GET') )
        {
            $rfp_id = $request->get('rfp_id');
            $rfp_id = (intval($rfp_id) == null || intval($rfp_id) < 0 ) ? abort('503') : intval($rfp_id) ;
            $url['rfp_id']   = $rfp_id;
            $url['name']     = $request ->get('name');
        }
        if( empty( $url['rfp_id']))
        {
            abort(503);
        }
        // 状态
        $where_str = ' invitation_tpl.status != ? ';
        $where_arr[] = 0;

        // 邀请函名称
        if( trim($url['name']))
        {
            $where_str .= " and name like '%$url[name]%' ";
        }
        $where_str .= ' and rfp_id = ? ';
        $where_arr[] = $url['rfp_id'];
        $tpl_list = $this-> __Invitation
                -> leftJoin('users', 'invitation_tpl.create_user', '=', 'users.id')
                ->select('tpl_id','invitation_tpl.name','invitation_tpl.create_time','invitation_tpl.create_user','invitation_tpl.update_time','users.login_name')
                ->whereRaw($where_str,$where_arr)
                ->orderBy('invitation_tpl.update_time','desc')
                ->orderBy('invitation_tpl.create_time','desc')
                ->paginate(20,['*'],'tpl_list');
//        dd($tpl_list);
        return view('/invitation/list',['tpl_list'=>$tpl_list,'url' => $url]);
    }

    /**
     *  新增/ 修改 页面弹出层
     *   2017-9-7
     *   Wind
     */
    public function iframe( Request $request)
    {
        //

        if( !$request->method('GET'))
        {
            abort(503);
        }
        $rfp_id = intval($request->get('rfp_id'));
        if( empty( $rfp_id) || $rfp_id <= 0 )
        {
            abort(503);
        }
        $tpl_id = intval($request->get('tpl_id'));

        // 展示类型  0 为 默认展示 1展示弹窗新增成功  2  展示弹窗 修改成功;
        $type = $request->get('type')?intval($request->get('type')): 0 ;
        if( $tpl_id <= 0 )
        {
            return view('/invitation/iframe',['rfp_id'=>$rfp_id,'type'=>$type]);
        }else{

            $tpl  =  $this -> __Invitation ->select('tpl_id','bg_img_url','name','title','begin_time','end_time','address','confirm_time')
                            ->whereRaw('tpl_id = ? and rfp_id = ? and status != ?',[$tpl_id,$rfp_id,0])
                            ->first()
                            ->toArray();
            if( empty($tpl) )
            {
                abort('503'); // message // 当前信息不存在
            }
            return view('/invitation/iframe',['rfp_id'=>$rfp_id,'tpl'=>$tpl,'type'=>$type]);
        }

    }

    /**
     *  插入 / 更新邀请函样式
     *
     */
    public function updateOrAdd(Request $request)
    {

        if( !$request->method('POST'))
        {
            return response()->json(array('error'=>'false','msg'=>'错误的请求方式'));
        }

        $data = $request->input('InvitationTpl');

        if( empty($data['rfp_id']) || $data['rfp_id'] <= 0  )
        {
            return response()->json(array('type'=>false,'message'=>'错误的数据提交'));
        }
        // 字段验证
        if( empty(trim($data['name']))){return response()->json(array('type'=>false,'message'=>'请填写邀请函名称'));}
        if( empty(trim($data['title']))){return response()->json(array('type'=>false,'message'=>'请填写邀请函名称'));}
        if( empty(trim($data['begin_time']))){return response()->json(array('type'=>false,'message'=>'请填写会议开始时间'));}
        if( empty(trim($data['end_time']))){return response()->json(array('type'=>false,'message'=>'请填写会议结束时间'));}
        if( empty(trim($data['address']))){return response()->json(array('type'=>false,'message'=>'请填写会议详细地址'));}
        if( empty(trim($data['confirm_time']))){return response()->json(array('type'=>false,'message'=>'请填写邀请函确认时间'));}
        // 时间验证
        if( !$this->checkDateIsValid($data['begin_time'])){return response()->json(array('type'=>false,'message'=>'会议开始时间错误'));}
        if( !$this->checkDateIsValid($data['end_time'])){return response()->json(array('type'=>false,'message'=>'会议结束时间错误'));}
        if( !$this->checkDateIsValid($data['confirm_time'])){return response()->json(array('type'=>false,'message'=>'会议确认时间错误'));}

        // 接收图片

        if(!empty($data['bg_img_url']) && !empty($data['tpl_id']))                  # 修改时 存在图片名称 使用原图片
        {
            if(!file_exists(base_path().'/public/assets/Invitation/'.$data['bg_img_url']))
            {
                return response()->json(array('type'=>false,'message'=>'请选择背景图'));
            }
        }
        elseif(empty($data['bg_img_url']) &&  empty($_FILES))
        {                   # 未上传文件 使用默认背景图
            $data['bg_img_url'] = '';
        } else {                                                                      # 上传文件为背景图
            $img = $_FILES;
            if( empty($img))
            {
                return response()->json(array('type'=>false,'message'=>'请选择背景图'));
            }
            $img = $img['bg_img_url'];
            $img_type = ['image/jpeg','png']; // 图片类型
            $img_size = 102400;                 // 额定大小 100k    // todo  长宽高大小目前均增加两个00 先不进行验证
            $img_width = 750;                   // 宽
            $img_height = 3418;                  // 高
            $img_names = explode('.',$img['name']);  // 拆分文件名

            if( !in_array($img['type'],$img_type))
            {
                return response()->json(array('type'=>false,'message'=>'请上传正确的图片格式'));
            }

//            if( $img['size'] > $img_size)
//            {
//                return response()->json(array('type'=>false,'message'=>'图片大小不能超过100kb'));
//            }
            if( $img['error'] != 0  )
            {
                return response()->json(array('type'=>false,'message'=>'图片异常，请选择其他图片'));
            }
            $img_info = getimagesize($img['tmp_name']);
//            if( $img_info[0] != $img_width || $img_info[1] != $img_height )
//            {
//                return response()->json(array('type'=>false,'message'=>'背景图片的宽*高为 750 * 3418，单位：像素'));
//            }
            //  图片保存位置
            $image_path = base_path().'/public/assets/Invitation/';
            if( !file_exists($image_path))
            {
                mkdir($image_path,0777);
            }
            // 文件名生成规则  Ibg + 年月日时分秒 + 随机四位数
            $file_name = 'Ibg'.date('Ymdhis').rand(1000,9999).'.'.$img_names[1];
            $type = move_uploaded_file($img['tmp_name'],$image_path.$file_name);
            if( $type )
            {
                $data['bg_img_url'] = $file_name;
            }
        }

        if( !empty(intval( $data['tpl_id'])) && intval( $data['tpl_id']) > 0  )
        {
            // 修改
            $tpl_id = intval( $data['tpl_id']);
            $data['status'] = 2;
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['update_user'] = session('user')['id'];
//            $type = $this-> __Invitation ->whereRaw('tpl_id = ? and rfp_id = ? ',[$tpl_id,$data['rfp_id']])->update($data);
//            dd($type);
            if( $this-> __Invitation ->whereRaw('tpl_id = ? and rfp_id = ? ',[$tpl_id,$data['rfp_id']])->update($data))
            {
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '修改邀请函模板'.$data['name'].'成功',
                    'node' => $this-> __url,
                    'rfp_id' => $data['rfp_id'],
                    'type' => '2',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try
                {
                    $this -> __PLogs -> insert( $param );
                }
                catch (\Exception $e)
                {
                    //写入文本日志
                    $message = "{session('user')['id']}修改邀请函模板日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert( $message );
                }
                return response()->json(array('type'=>true,'message'=>'修改成功'));
            }else{
                return response()->json(array('type'=>false,'message'=>'系统异常，请刷新重试'));
            }
        }else{
            // 插入

            $data['status'] = 1;
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['create_user'] = session('user')['id'];
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['update_user'] = session('user')['id'];
            if( $this-> __Invitation ->whereRaw(' rfp_id = ? ',[$data['rfp_id']])->insert($data))
            {
                // 日志信息
                $param = array(
                    'belong' => session('user')['id'],
                    'content' => '新增邀请函模板'.$data['name'].'成功',
                    'node' => $this-> __url,
                    'rfp_id' => $data['rfp_id'],
                    'type' => '2',
                    'ip' => $_SERVER["REMOTE_ADDR"],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                // 写入日志
                try
                {
                    $this -> __PLogs -> insert( $param );
                }
                catch (\Exception $e)
                {
                    //写入文本日志
                    $message = "{session('user')['id']}新增邀请函模板日志添加失败,{$this -> __controller}/{$this -> __action},错误信息:{$e -> getMessage() }";
                    Log::alert( $message );
                }
                return response()->json(array('type'=>true,'message'=>'新增成功'));
            }else{
                return response()->json(array('type'=>false,'message'=>'系统异常，请刷新重试'));
            }
        }
    }

    /**
     *  邀请函详情查看
     *  2017-9-7
     *  Wind
     */
    public function show( Request $request)
    {
        if( !$request->method('GET'))
        {
            abort(503);
        }
        $rfp_id = intval($request->get('rfp_id'));
        if( empty( $rfp_id) || $rfp_id <= 0 )
        {
            abort(503);
        }
        $tpl_id = intval($request->get('tpl_id'));
        if( $tpl_id <= 0 )
        {
            abort(503);
        }

        $tpl  =  $this -> __Invitation ->select('tpl_id','bg_img_url','name','title','begin_time','end_time','address','confirm_time','rfp_id')
            ->whereRaw('tpl_id = ? and rfp_id = ? and status != ?',[$tpl_id,$rfp_id,0])
            ->first()
            ->toArray();
        if( empty($tpl) )
        {
            abort('503'); // message // 当前信息不存在
        }
        return view('/invitation/index',['tpl'=>$tpl]);

    }

    /***
     *  时间格式验证
     * @param $date
     * @param string $formats
     * @return bool
     * Wind  2017-9-26 01:30:20
     */
    private function checkDateIsValid($date, $formats = "Y-m-d H:i") {
        $unixTime = strtotime($date);
        if (!$unixTime)
        {
            return false;
        }
        //校验日期的有效性
        if (date($formats, $unixTime) == $date) {
            return true;
        }
        return false;
    }

}

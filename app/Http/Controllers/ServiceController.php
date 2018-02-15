<?php
/**
 * Created by PhpStorm.
 * User: Borys
 * Date: 2/13/2018
 * Time: 6:12 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Hash;
use Mockery\Exception;


define ('LOGIN_SUCCESS',0);
define ('LOGIN_NAME_FAIL',1);
define ('LOGIN_PASS_FAIL',2);
define ('RESPONSE_SUCCESS',0);
define ('RESPONSE_FAIL',1);

class ServiceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function request_captcha(Request $request) {

        if ($request -> isMethod('POST')) {
            $captcha = $this->generate_captcha();
            
            $data = array();
            if ($captcha['img_url'] != '' && $captcha['code'] != '') {
    
                $data['response'] = array('success'=>RESPONSE_SUCCESS,'result'=>array('code'=>$captcha['code'], 'captchaimg' => substr($captcha['img_url'],1,strlen($captcha['img_url'])-1)));
            } else {
                $data['response'] = array('success'=>RESPONSE_FAIL,'result'=> array());
            }

            echo json_encode($data);
        }

    }

    public function login(Request $request) {

        $user_type = '';
        $user_login_name = '';
        $password = '';
        $user_mobile_number = '';
        $user_sms_msg = '';

        if ($request -> isMethod('POST')) {

            $data = array();

            $user_type = $request['user_type'];

                if ($user_type == 0) {//会议主办员
                    $user_login_name = $request['login_name'];
                    $password = $request['password'];

                    if ($this->check_user($user_login_name, $password) == 0 ) {
                        $data['response'] = array('success'=>LOGIN_NAME_FAIL,'result'=>array());
                    } else if ( $this->check_user($user_login_name, $password) == 1 ) {
                        $data['response'] = array('success'=>LOGIN_PASS_FAIL,'result'=>array());
                    }   else if ( $this->check_user($user_login_name, $password) == 2 ) {
                        $id = DB::table('users')
                        ->select('id')
                        ->where('login_name',$user_login_name)
                        ->get();                        
                        $data['response'] = array('success'=>LOGIN_SUCCESS,'result'=>array('user_id'=>$id[0]['id']));
                    }
                    echo json_encode($data);
                } else {//服务商
                    $user_mobile_number = $request['mobile'];
                    if ($this->check_servicer($user_mobile_number)) {

                    }
                }
            }
    }

    public function check_user($user_login_name = '', $password = '') {
        $user_pass = DB::table('users')
            ->select('password')
            ->where('login_name',$user_login_name)
            ->get();

        if (count($user_pass)>0) { 
            if ( Hash::check($password, $user_pass[0]['password'])) {
                return 2;//Success
            } else {
                return 1;//Password incorrect
            }
        } else {
            return 0;//Login Name incorrect
        }             
    }

    public function check_servicer($mobile = '') {

    }

    public function getConferences($conf_type) {
        if ($conf_type == 0){ //All
            return DB::table('rfp')
                ->leftJoin('comp_main','rfp.rfp_id','=','comp_main.rfp_id')
                ->leftJoin('traffic_serve','traffic_serve.id','=','comp_main.traffic_serve_id')
                ->leftJoin('conf_upload','conf_upload.id','=','comp_main.conf_upload_id')
                ->leftJoin('conf_serve','conf_serve.id','=','comp_main.conf_serve_id')
                ->whereIn('rfp.status',[40,50])
                ->select('rfp.rfp_id as rfp_id', 'rfp.meeting_name as meeting_name' ,'rfp.start_time as start_time',
                         'rfp.end_time as end_time','rfp.people_num as people_num','comp_main.action_status as action_status',
                         'traffic_serve.status as car','conf_upload.status as conf_upload','conf_serve.status as conf_task')
                ->get();
        } elseif ($conf_type == 1) { //Finished
            return DB::table('rfp')
                    ->leftJoin('comp_main','rfp.rfp_id','=','comp_main.rfp_id')
                    ->leftJoin('traffic_serve','traffic_serve.id','=','comp_main.traffic_serve_id')
                    ->leftJoin('conf_upload','conf_upload.id','=','comp_main.conf_upload_id')
                    ->leftJoin('conf_serve','conf_serve.id','=','comp_main.conf_serve_id')
                    ->whereIn('rfp.status',[40,50])
                    ->where('comp_main.action_status',3)
                    ->select('rfp.rfp_id as rfp_id', 'rfp.meeting_name as meeting_name' ,'rfp.start_time as start_time',
                            'rfp.end_time as end_time','rfp.people_num as people_num','comp_main.action_status as action_status',
                            'traffic_serve.status as car','conf_upload.status as conf_upload','conf_serve.status as conf_task')
                    ->get();
        } elseif ($conf_type == 2) { //Started
            return DB::table('rfp')
                    ->leftJoin('comp_main','rfp.rfp_id','=','comp_main.rfp_id')
                    ->leftJoin('traffic_serve','traffic_serve.id','=','comp_main.traffic_serve_id')
                    ->leftJoin('conf_upload','conf_upload.id','=','comp_main.conf_upload_id')
                    ->leftJoin('conf_serve','conf_serve.id','=','comp_main.conf_serve_id')
                    ->whereIn('rfp.status',[40,50])
                    ->where('comp_main.action_status',2)
                    ->select('rfp.rfp_id as rfp_id', 'rfp.meeting_name as meeting_name' ,'rfp.start_time as start_time',
                            'rfp.end_time as end_time','rfp.people_num as people_num','comp_main.action_status as action_status',
                            'traffic_serve.status as car','conf_upload.status as conf_upload','conf_serve.status as conf_task')
                    ->get();
        } elseif ($conf_type == 3) { //Not Start
            return DB::table('rfp')
                    ->leftJoin('comp_main','rfp.rfp_id','=','comp_main.rfp_id')
                    ->leftJoin('traffic_serve','traffic_serve.id','=','comp_main.traffic_serve_id')
                    ->leftJoin('conf_upload','conf_upload.id','=','comp_main.conf_upload_id')
                    ->leftJoin('conf_serve','conf_serve.id','=','comp_main.conf_serve_id')
                    ->whereIn('rfp.status',[40,50])
                    ->orWhere('comp_main.action_status','=',1)
                    ->orWhereNull('comp_main.action_status')
                    ->select('rfp.rfp_id as rfp_id', 'rfp.meeting_name as meeting_name' ,'rfp.start_time as start_time',
                        'rfp.end_time as end_time','rfp.people_num as people_num','comp_main.action_status as action_status',
                        'traffic_serve.status as car','conf_upload.status as conf_upload','conf_serve.status as conf_task')
                    ->get();
        }

    }

    public function generate_captcha() {
        $captcha_code = '';
        $image = imagecreatetruecolor(100, 30);
        $letters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        for($i=0;$i<4;$i++){
            //设置字体大小
            $fontsize = 6;
            //设置字体颜色，随机颜色
            $bg = imagecolorallocate($image, 255,255,255);
            $black = imagecolorallocate($image, 0, 0, 0);
            imagecolortransparent($image, $black);
            $fontcolor = imagecolorallocate($image, 55,200, 155);      //0-120深颜色
            //设置数字
            $rand_pos = rand(0,strlen($letters)-1);
            $fontcontent = substr($letters,$rand_pos,1);
            //10>.=连续定义变量
            $captcha_code .= $fontcontent;
            //设置坐标
            $x = ($i*100/4)+rand(5,10);
            $y = rand(5,10);
            imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
        }
        //10>存到session
        //$_SESSION['authcode'] = $captcha_code;
        //8>增加干扰元素，设置雪花点
        for($i=0;$i<200;$i++){
            //设置点的颜色，50-200颜色比数字浅，不干扰阅读
            $pointcolor = imagecolorallocate($image,rand(50,200), rand(50,200), rand(50,200));
            //imagesetpixel — 画一个单一像素
            imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);
            imagesetpixel($image, 255,255,0);
        }
        //9>增加干扰元素，设置横线
        for($i=0;$i<4;$i++){
            //设置线的颜色
            $linecolor = imagecolorallocate($image,255,0,255);
            //设置线，两点一线
            //  imageline($image,rand(1,99), rand(1,29),rand(1,99), rand(1,29),$linecolor);
        }
        //2>设置头部，image/png
        header('Content-Type: image/png');
        //3>imagepng() 建立png图形函数 ，
        //Also save image
        $img_filename = './captcha/'.$captcha_code.'.png';
        imagepng($image,$img_filename);
        //4>imagedestroy() 结束图形函数 销毁$image
        imagedestroy($image);
        return array('code'=>$captcha_code, 'img_url'=>$img_filename);
    }

    public function request_conference(Request $request) {
        if( $request -> isMethod('POST')) {
            $conf_type = $request['conf_type'];
            $conferences = $this->getConferences($conf_type);
            if (count($conferences) > 0) {
                $result = array();
                foreach ($conferences as $key => $one_confer) {
                     array_push($result, $one_confer);
                }
                $data['response'] = array('success'=>RESPONSE_SUCCESS,'result'=>$result);
            } else {
                $data['response'] = array('success'=>RESPONSE_FAIL,'result'=>array());
            }

            echo json_encode($data);
        }
    }
}
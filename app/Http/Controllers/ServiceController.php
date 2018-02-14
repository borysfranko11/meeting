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
use App\Models\Mobileloginlog;
use Hash;
use Mockery\Exception;

class ServiceController extends Controller
{

    private $_mobile_log;
    public function __construct()
    {
        parent::__construct();
        $this->_mobile_log = new Mobileloginlog();

    }

    public function request_captcha() {
        $captcha = $this->generate_captcha();
        $data = array();
        if ($captcha['img_url'] != '' && $captcha['code'] != '') {
            $data['success'] = 1;
            $data['result'] = array('code'=>$captcha['code'], 'captchaimg' => substr($captcha['img_url'],1,strlen($captcha['img_url'])-1));
        } else {
            $data['success'] = 0;
            $data['result'] = array();
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

                    if ($this->check_user($user_login_name, $password)) {
                        $conferences = $this->getConferences();
                        $result = array();
                        foreach ($conferences as $key => $one_confer) {
                            $rfp_id = $one_confer['rfp_id'];
                            $action_status = 0;//0:, 1:, 2:
                            try {
                                $status = DB::table('comp_main')
                                    ->where('rfp_id', $rfp_id)
                                    ->select('action_status')
                                    ->get();
                                if (count($status) > 0) $action_status = $status[0]['action_status'];
                            } catch (Exception $exception) {
                                $action_status = 0;
                            }
                            $one_confer['action_status'] = $action_status;
                            array_push($result, $one_confer);
                        }
                        $data['success'] = 1;
                        $data['result'] = $result;
                        echo json_encode($data);
                    } else {
                        $data['success'] = 0;
                        $data['result'] = array();
                    }
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
       if ($user_pass != null && Hash::check($password, $user_pass[0]['password'])) {
            return true;
        } else { return false;}
    }

    public function check_servicer($mobile = '') {

    }

    public function getConferences() {
        return DB::table('rfp')
                    ->whereIn('status',[40,50])
                    ->select('rfp_id', 'meeting_name' ,'start_time','end_time','people_num')
                    ->get();
    }

    public function generate_captcha($user_id) {
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
}
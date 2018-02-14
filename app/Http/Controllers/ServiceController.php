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

    public function login(Request $request) {

        $user_type = '';
        $user_login_name = '';
        $password = '';
        $user_mobile_number = '';
        $user_sms_msg = '';

        if ($request -> isMethod('POST')) {

            $data = array();

            $user_type = $request['user_type'];

            switch ($user_type) {
                case 0://会议主办员
                    $user_login_name = $request['login_name'];
                    $password = $request['password'];

                    if ($this->check_user($user_login_name,$password)) {
                        $user_id = DB::table('users')
                            ->select('id')
                            ->where('login_name',$user_login_name)
                            ->get();

                        $captcha = $this->generate_captcha($user_id[0]['id']);

                        $this->insert_user_login_log($user_id, $captcha);

                        $data['success'] = 1;
                        $data['result'] = array('userid' => $user_id[0]['id'],'captchaimg' => substr($captcha['img_url'],1,strlen($captcha['img_url'])-1));

                        echo json_encode($data);

                    } else {
                        $data['success'] = 0;
                        $data['result'] = array();
                    }

                    break;
                case 1://服务商
                    $user_mobile_number = $request['mobile'];

                    if ($this->check_servicer($user_mobile_number)) {

                    }
                    break;
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
        } else {
            return false;
        }
    }

    public function check_servicer($mobile = '') {

    }

    public function check_captcha(Request $request) {

        if ($request -> isMethod('POST')) {

            $data = array();

            $user_id = $request['user_id'];
            $captcha_msg = $request['captcha_msg'];


            $code = DB::table('mobile_login_log')
                ->where('user_id',intval($user_id))
                //->where('status','!=',1)
                ->select('captcha_code')->get();

            if ($code[0]['captcha_code'] == $captcha_msg) {

                $this->update_user_login_log($user_id,0,1);

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
                        if (count($status)>0) $action_status = $status[0]['action_status'];
                    } catch (Exception $exception) {
                        $action_status = 0;
                    }
                    $one_confer['action_status'] = $action_status;
                    array_push($result,$one_confer);
                }

                $data['success'] = 1;
                $data['result'] = $result;

                echo json_encode($data);
            } else {
                $data['success'] = 0;
                $data['result'] = array();
            }
        }
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
        for($i=0;$i<4;$i++){
            //设置字体大小
            $fontsize = 6;
            //设置字体颜色，随机颜色
            $fontcolor = imagecolorallocate($image, 255,255, 255);      //0-120深颜色
            //设置数字
            $fontcontent = rand(0,9);
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
            //imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);
            imagesetpixel($image, 255,255,0);
        }
        //9>增加干扰元素，设置横线
        for($i=0;$i<4;$i++){
            //设置线的颜色
            $linecolor = imagecolorallocate($image,255,255,255);
            //设置线，两点一线
            imageline($image,rand(1,99), rand(1,29),rand(1,99), rand(1,29),$linecolor);
        }

        //2>设置头部，image/png
        header('Content-Type: image/png');
        //3>imagepng() 建立png图形函数 ，
        //Also save image
        $img_filename = './captcha/'.$user_id.'-'.$captcha_code.'.png';
        imagepng($image,$img_filename);
        //4>imagedestroy() 结束图形函数 销毁$image
        imagedestroy($image);
        return array('code'=>$captcha_code, 'img_url'=>$img_filename);


    }

    public function renew_captcah(Request $request) {
        if ($request -> isMethod('POST')) {
            $user_id = $request['user_id'];
            $captcha = $this->generate_captcha($user_id[0]['id']);
            $this->update_user_login_log($user_id, 0, 2, $captcha);
            $data['success'] = 1;
            $data['result'] = array('userid'=>$user_id[0]['id'],'captchaimg'=>substr($captcha['img_url'],1,strlen($captcha['img_url']-1)));
        }
    }
    public function insert_user_login_log($user_id, $captcha) {

        try {
            $param = array(
                'login_user_type' => 0,
                'user_id' => $user_id[0]['id'],
                'status' => 0,//New Login
                'captcha_code' => $captcha['code'],
                'captcha_url' => $captcha['img_url'],
                'login_time' => date('Y-m-d h:i:s', time()),
                'create_time' => date('Y-m-d h:i:s', time()),
                'update_time' => date('Y-m-d h:i:s', time()),
            );

            //$this->_mobile_log -> insertDatas($param);
            DB::table('mobile_login_log')->insert($param);
        } catch (Exception $exception) {

        }
    }

    public function update_user_login_log($user_id, $login_type,$status,$captcha = array()) {

        $data = array();
        $data['login_user_type'] = $login_type;
        $data['user_id'] = $user_id;
        $data['status'] = $status;//New Login
        if (count($captcha)>0) {
            $data['captcha_code'] = $captcha['code'];
            $data['captcha_url'] = $captcha['img_url'];
        }
        $data['login_time'] = date('Y-m-d h:i:s',time());
        //$data['create_time'] = date('Y-m-d h:i:s',time());
        $data['update_time'] = date('Y-m-d h:i:s',time());

        DB::table('mobile_login_log')
                        ->where('user_id',$user_id)
                        ->update($data);

    }

}
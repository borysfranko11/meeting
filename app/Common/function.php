<?php
/**
 * Created by PhpStorm.
 * User: jzco
 * Date: 2017/7/4
 * Time: 17:56
 */

use App\Libs\Upyun;
if( !function_exists( 'array_merge_smart' ) )
{
    /**
     * des: 数组合并, 避免 array_merge 合并空数组会有错误
     * @param $target [type|array] 待组合的数组
     * @param $extend [type|array] 待组合的数组
     * @return array
     */
    function array_merge_smart( $target, $extend )
    {
        $result = [];

        if( empty( $target ) && empty( $extend ) )
        {
            $result = [];
        }
        else
        {
            if( !empty( $target ) && empty( $extend ) )
            {
                $result = $target;
            }
            else
            {
                if( empty( $target ) && !empty( $extend ) )
                {
                    $result = $extend;
                }
                else
                {
                    $result = array_merge( $target, $extend );
                }
            }
        }

        return $result;
    }
}

if( !function_exists('preg_in_array') )
{
    /**
     * des: 正则匹配字符串是否出现在数组中
     * @param $target [type|string] 待查找的字符串
     * @param $group [type|array] 数组
     * @return bool
     */
    function preg_in_array( $target, $group )
    {
        $result = false;

        // 数据格式正确判断
        if( !empty( $target ) && !empty( $group ) )
        {
            foreach( $group as $key => $value )
            {
                $pattern = '/'.str_replace( '/','\/', $value ).'/';

                preg_match( $pattern, $target, $matches );

                if( !empty( $matches ) )
                {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
}

if( !function_exists( 'fetchTree' ) )
{
    /**
     * des: 将抓取数据的子类, 并合并
     * @param $data [type|array] 数据(二维数组)
     * @param $pid  [type|string] 上级ID
     * @param $name  [type|string] 子级字段名称
     * @return array
     */
    function fetchTree( $data, $pid = '0', $name = 'son' )
    {
        $result = array();

        // 先判断有多少内容是 pid 的子集
        foreach( $data as $keys => $values )
        {
            if( $values['pid'] == $pid )
            {
                $result[$values['id']] = $values;
                $sub = fetchTree( $data, $values['id'] );

                if( !empty( $sub ) )
                {
                    $result[$values['id']][$name] = $sub;
                }
            }
        }

        return $result;
    }
}

if( !function_exists('filterParam') )
{
    /**
     * des: 过滤参数的空格和html标签
     * @param $param [type|array] 参数组
     * @return array|string
     */
    function filterParam( $param )
    {
        $result = array();
        if( is_array( $param ) )
        {
            foreach( $param as $key => $value )
            {
                $result[$key] = trim( htmlspecialchars( $value ) );
            }
            return $result;
        }

        $result = trim( htmlspecialchars( $param ) );
        return $result;
    }
}

if( !function_exists('json_report') )
{
    /**
     * des: json 输出
     * @param $code
     * @param $msg
     * @param array $ext
     */
    function json_report( $code = 0, $msg='', $ext=array() )
    {
        $code_refer = array(
            '-1'    => 'FAULT',
            '0'     => 'ERROR',
            '1'     => 'SUCCESS',
            '2'     => 'WARNING',
            '3'     => 'UNKNOW'
        );

        $result = array(
            'code'      => $code,                                       // 响应编码
            'result'    => $code_refer[$code],                          // 文字结果
            'msg'       => !empty( $msg ) ? $msg : 'empty'              // 具体描述
        );

        die( json_encode( $result ) );
    }
}

if( !function_exists('upload_upanyun_file') ) {
    /**
     * des: 上传文件又拍云
     * size:kb
     */
    function upload_upanyun_file($name,$type=array(),$size = '10240')
    {

        $file_name = '';
        if (!empty($_FILES[$name])) {
            $upyun = new Upyun('eventdb', 'jianghaiming', 'jianghaiming123456');
            $dir_pic = '/company_center/';
            $file_name = $_FILES[$name]['name'];
            $tmp_name = $_FILES[$name]['tmp_name'];
            $file_size = $_FILES[$name]["size"];
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            if(!empty($type) && !in_array($file_ext,$type)){
                return  json_encode(array('status' => '0', "error" => '上传文件类型有误'));
            }
           /* if($file_size > $size*1024){
                return  json_encode(array('status' => '0', "error" => '上传文件超过大小限制'));
            }*/
            $ymd = date('Y') . "/" . date('m') . "/" . date('d') . '/'; //路径
            $new_file_name = time() . '_' . rand(10000, 99999) . '.' . $file_ext;
            $file_name = $dir_pic . $ymd . $new_file_name;
            $open_file = fopen($tmp_name, 'r');
            $result = $upyun->writeFile($file_name, $open_file, True);// 上传图片，自动创建目录
            fclose($open_file);
            if (empty($result)) {
              return  json_encode(array('status' => '0', "error" => ''));
            }
        }
        if ($file_name) {
            $upy_img_url = config('links.upy_img_url');
            $arr         = array('status' => '1', "data" => $upy_img_url . $file_name);
        } else {
            $arr = array('status' => '0', "error" => '');
        }
        return  json_encode($arr);
    }
}
if( !function_exists('checkStatus') ) {
    /**
     * des: 询单状态整理
     * @param $status 状态码
     * @return string 返回主状态名称
     */
    function checkStatus ( $status ){

        $statusName = '';
        if($status){
            $statusArr = config('system.meeting_main_status');
            foreach($statusArr AS $key => $value){
                if( $status >= $value['min'] && $status <= $value['max'] ){
                    $statusName = $value['name'];
                    break;
                }
            }
        }

        return $statusName;
        
    }
}
if( !function_exists('doCurlGetRequest') ) {
    function doCurlGetRequest($url, $data = array(), $timeout = 5){
        if ($url == "" || $timeout <= 0) return false;
        $dataStr = '';
        foreach ($data as $k => $v) {
            $dataStr.=$k.'='.trim($v).'&';
        }
        $url = $url.'?'.$dataStr;
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
        return curl_exec($con);
    }
}
if( !function_exists('doCurlPostRequest') ){
    function doCurlPostRequest($url, $data, $headers = [], $timeout = 5) {

        if($url == '' || $data == '' || $timeout <= 0) {
            return false;
        }

        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($curl, CURLOPT_HEADER, $headers);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行命令
        $res = curl_exec($curl);
        $request_header = curl_getinfo( $curl, CURLINFO_HEADER_OUT);

        //关闭URL请求
        curl_close($curl);
        return $res;
    }
}

if( !function_exists('returnJson') ) {
    function returnJson($success = false, $data = '', $msg=''){
        $return = array(
            'Success'  =>$success,
            'Data'  =>$data,
            'Msg'  =>$msg,
        );
        return json_encode($return, true);
    }
}

if( !function_exists('arraySequence') ){
    /**
     * 二维数组根据字段进行排序
     * @params array $array 需要排序的数组
     * @params string $field 排序的字段
     * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
     */
    function arraySequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }
}

if( !function_exists('get_img_url') ) {
    function get_img_url($url) {
        $mainPic = 'http://pic.eventown.com';
        if (strstr($url, 'images')) {
            $mainPic = 'http://api.eventown.com';
        } else if(strstr($url, 'place') || strstr($url, 'ebooking') || strstr($url, 'meeting') || strstr($url, 'pictrue') || strstr($url, 'upimg')) {
            $mainPic = 'http://img.eventown.cn';
        }
        return $mainPic;
    }
}
if( !function_exists('authcode') ){

    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $key         = md5($key ? $key : 'eq33(i2a7w2JHf}c');// 密匙
        $keya        = md5(substr($key, 0, 16));// 密匙a会参与加解密
        $keyb        = md5(substr($key, 16, 16));// 密匙b会用来做数据完整性验证
        $keyc        = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :// 密匙c用于变化生成的密文
            substr(md5(microtime()), -$ckey_length)) : '';
        $cryptkey    = $keya . md5($keya . $keyc);// 参与运算的密匙
        $key_length  = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
        // 解密时会通过这个密匙验证数据完整性
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string        = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result        = '';
        $box           = range(0, 255);
        $rndkey        = array();
        // 产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));// 从密匙簿得出密匙进行异或，再转成字符
        }
        if ($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
            ) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}



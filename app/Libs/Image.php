<?php

namespace App\Libs;
/**
 * 从本地获取图片写入文字
 * @auhtor bbq 2015-09-16
 * Class ImageCreateAndWriteTxt
 */
class Image
{
    //底图
    protected $imgUrl = null;
    //文字以及文字所在位置
    protected $position = array();
    //字体
    protected $font = null;
    //图片存放路劲
    protected $url = null;
    //字体大小
    const  SIZE = 10;


    public function setImgUrl($imgUrl){
        $this->imgUrl = $imgUrl;
    }
    public function setTtf($ttf){
        $this->font = $ttf;
    }
    public function setUrl($url){
        $this->url = $url;
    }

    /**
     * 添加文字以及文字位置
     * @param $arr
     * @return bool
     */
    public function addPositionAndText($arr)
    {
        if (!empty($arr['position_x']) && !empty($arr['position_y']) && !empty($arr['text'])) {
            $arr['angle'] = 0;
            $positionArr = & $this->position;
            $positionArr[] = $arr;
            return TRUE;
        }

        return FALSE;
    }

    /**
     * 删除文字以及文字位置
     * @param $text
     * @return bool
     */
    public function removePositionAndText($text)
    {
        $position = & $this->position;
        if (empty($position)) {
            return FALSE;
        }
        foreach ($position as $key => $val) {
            if ($val['text'] == $text) {
                unset($position[$key]);
                return TRUE;
            }
        }
        return FALSE;
    }


    protected function createText($instring)
    {
        $outstring = "";
        $max = strlen($instring);
        for ($i = 0; $i < $max; $i++) {
            $h = ord($instring [$i]);
            if ($h >= 160 && $i < $max - 1) {
                $outstring .= substr($instring, $i, 2);
                $i++;
            } else {
                $outstring .= $instring [$i];
            }
        }
        return $outstring;
    }

    public function outPutImage()
    {
        //输出头内容
        //Header("Content-type: image/png");
        //建立图象
        $image = imagecreatefromjpeg($this->imgUrl);
        //定义颜色
        $black = ImageColorAllocate($image, 0, 0, 0);
        //写入文字
        foreach ($this->position as $val) {
            $txt = $this->createText($val['text']);
            imagettftext($image, self::SIZE, $val['angle'], $val['position_x'], $val['position_y'], $black, $this->font, $txt);
        }
        //显示图形
        //imagejpeg($image);
        if (!is_dir(dirname($this->url))) {
            @mkdir(dirname($this->url), 0777, TRUE);
        }
        imagegif($image, $this->url);
        ImageDestroy($image);
    }

}


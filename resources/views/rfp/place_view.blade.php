<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/assets/css/product.css" rel="stylesheet">
    <link href="/assets/css/rooms.css" rel="stylesheet">
    <link href="/assets/css/room_view.css" rel="stylesheet">
    <link href="//at.alicdn.com/t/font_953hpjea7i16pqfr.css" rel="stylesheet">
    <style type="text/css" media="screen">
        .rooms_color{
            color:#aaa;
        }
        .pro_service_rooms{
            margin-left:25px;
        }
        .pro_bable .rooms_style > tbody > tr > td {
            width:10%;
        }
        .pro_btn{
            background: #5fb200;
        }
        .pro_btn:hover{
            background: #559f00;
        }
        .pro_btn:hover a{
            color:#fff;
        }
        .pro_btn:hover a.checked{
            color:green;
        }
        .add-hotel-info .hotel-img {
            position: relative;
            padding: 0 5px;
        }
        .container{
            width: 100%;
        }
        .add-hotel-info .hotel-img a,.add-hotel-info .hotel-img img {
            /* display: inline-block; */
            float: left;
            width: 80px;
            height: 80px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
            position: relative;
            transition: all 0.6s;
        }
        .hotel-img a:hover img{
            /* display: inline-block; */
            position: absolute;
            left: 0;
            /* width: 300px;
            height: 260px; */
            transform: scale(2.6);
            transform-origin: left top;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
            z-index: 999;
        }
        .table thead{
            font-size: 14px;
        }
        .table tbody{
            font-size: 12px;
        }
        .table td,.table th{
            padding-left: 6px;
            padding-right: 6px;
        }
        .small-pic {
            float: right;
            width: 50px;
            height: 50px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }
        .htl_room_table .room_type {
            padding-left: 16px;
            width: 160px;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            background: none;
            vertical-align: initial;
            overflow: hidden;
        }
        .cont-title{
            display: inline-block;
        }
        .new-add-tr{
            text-align: left;
        }
        /* 对图标的内容进行设置 */
        .iconfont{
            font-size: 18px;
        }
        .table th span.iconfont{
            border: 1px solid #ccc;
            padding: 2px;
        }
        /* 列表下的arrow设置 */
        .look-info{
            cursor: pointer;
        }
        .icon-arrow1{
            line-height: 32px;
            color: #f90;
            cursor: pointer;
            font-size: 14px;
        }
        .new-add-tr cite,.new-add-tr i{
            font-style: normal;
        }
        .new-add-tr p{
            text-align: left;
            vertical-align: bottom;
        }
        .new-add-tr p span{
            vertical-align: bottom;
            padding-top: 66px;
            display: inline-block;
        }
        #placeMap {
            width: 876px;
            height: 360px;
        }
    </style>
    <!-- <link href="/assets/css/hotel/hotelDetail.css" rel="stylesheet"> -->
    <script>
        var GLO={
            uid:'<?php echo session('user')['id']; ?>' || '',
            place_id: <?php echo $data['main_info']['place_id']?>
        }
        var  CURRENT_PLACE='<?php echo $data['main_info']['location']?>'
    </script>
</head>
<!--毛玻璃效果-->
    <svg class="hidden" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <filter id="blur">
                <feGaussianBlur stdDeviation="5" />
            </filter>
        </defs>
    </svg>
<!--end -->
<body>
    <div class="pro_top_wrap">
        <div class="w1170 pro_top clearfix">
            <div class="pull-right">
                <div class="pro_r_col1">
                    <div class="place_score">
                    </div>
                    <div class="pro_btn">

                    </div>
                </div>
            </div>
            <div class="pull-left">

                    <h2> <strong id="palce_name"   data-placeid="<?php echo $data['main_info']['place_id']?>" ><?php echo $data['main_info']['place_name']?></strong>

                    <small style="color:#666666;font-size:12px"><?php
                        echo $data['main_info']['address'];?>

                    </small>
                </h2>
                <div class="info">
                    <b>场地类型：
                        <?php
                        if (!empty($data['place_options']['place_type'])) {
                            foreach ($data['place_options']['place_type'] as $item) {
                                echo $item;
                            }
                        }
                        ?>
                    </b><span class="star">
                            <?php
                            for ($i=1; $i<= $data['main_info']['star_rate']; $i++) {
                                echo '<i class="icon iconfont">&#xe630;</i>';
                            }
                            ?>
                        </span>
                          <span class="map_icon">
                              <a href="#place_map">
                                  <i class="icon iconfont">&#xe60b;</i>
                                  地图位置
                              </a>
                              <a href="javascript:void(0)" id="panoramaMap">
                                  <i class="icon iconfont">&#xe669;</i>
                                  Panoramic Map
                              </a>
                          </span>
                </div>
                <div class="tag">
                    <?php
                    /*foreach ($place_options['tags'] as $item) {
                        echo "<strong>$item</strong>";
                    }*/
                    ?>
                </div>


            </div>
        </div>
    </div>
    <div class="pro_banner">
        <?php
        $imga = '';
            if(!empty($data['place_pic'][0]['pic_url'])){
                if(strpos($data['place_pic'][0]['pic_url'],'eventown') !== false){
                    $imga =  $data['place_pic'][0]['pic_url'];
                } else{
                    $imga = "".$data['place_pic'][0]['pic_url'];
                }
            }

        ?>
        <img src="<?= $data['place_pic'][0]['pic_url']?>" class="layer">
        <div class="cover">
            <img src="<?=$imga?>" class="blur">
            <div class="mask"></div>
        </div>
        <div class="pro_b_l">
            <ul>

                <li><span><strong><?= @(int)($data['meeting_basic']['count']?$data['meeting_basic']['count']:count($data['meetings']))?></strong>
                        <em>会议室数量</em></span><span><strong><?= @ isset($data['meeting_basic']['max_area']) && $data['meeting_basic']['max_area']?$data['meeting_basic']['max_area']:$data['main_info']['area']?></strong>
                        <em>最大会议室面积(㎡)</em></span></li>
                <li><span><strong>
                            <?= @$data['roomCounts']?></strong>
                        <em>客房数量</em></span>
                    <span><strong><?= @$data['roomRongna']?></strong>
                        <em>可容纳人数</em></span></li>
                <li><span><strong><?= @(int)$data['main_info']['found_time']?$data['main_info']['found_time']:(isset($data['meeting_rooms_info']['MeetingPlaceInfo']['OpenYear'])?$data['meeting_rooms_info']['MeetingPlaceInfo']['OpenYear']:'--')?></strong>
                        <em>开业时间</em></span>
                        <span><strong><?= @isset($data['main_info']['last_repair_time'])?$data['main_info']['last_repair_time']:$data['meeting_rooms_info']['MeetingPlaceInfo']['FitmentYear']?></strong>
                        <em>装修时间</em></span></li>

            </ul>
        </div>
        <div class="pro_b_c">
            <div id="slideshow">
                <div class="img">
                    <!--循环节流-->
                    <?php

                        foreach ($data['place_pic'] as $k => $v):?>
                            <img src="<?=$v['pic_url']?>" style="width:554px;height:332px"/>
                            <?php if($k == 0)break;?>

                        <?php endforeach;?>


                </div>
            </div>
        </div>
        <div class="pro_b_r">
            <ul>
                <?php

                    $i = 0;
                    foreach ($data['place_pic'] as $k => $v) {

                        foreach ($v as $item) {
                            $i++;
                            ?>
                            <li><img src="<?= $item ?>"/></li>
                            <?php
                            if ($i == 4) {
                                break;
                            }
                        }
                    }

                ?>
            </ul>
        </div>
    </div>
    <div class="pro_main clearfix">
        <div class="pro_content clearfix container">

            <h4 class="pro_title" id="f1"><i class="icon iconfont">&#xe602;</i>酒店简介</h4>
            <div class="pro_introduce">
                <?php
                echo empty($data['main_info']['place_desc']) ? '暂无酒店简介!' : $data['main_info']['place_desc'];
                ?>
            </div>

            <h4 class="pro_title" id="f2">
                <ul id="viewTabs">
                    <li name="meeting_place" class="on"><i class="icon iconfont">&#xe60c;</i>会议室详情</li>
                    <li name="rooms"><i class="icon iconfont">&#xe60a;</i>客房价格</li>
                </ul></h4>

            <div id="meeting_place" class="price_container">
                <div class="pro_bable">
                    <table class="table table-hover" id="pro_table_hotel1">
                        <thead>
                            <tr>
                                <th colspan=2><span>会议室名称</span></th>
                                <th><span class="iconfont icon-mianji"></span></th>
                                <th><span class="iconfont icon-chicun"></span></th>
                                <th><span class="iconfont icon-icon05"></span></th>
                                <th><span class="iconfont icon-deng"></span></th>
                                <th><span class="iconfont icon-loucengxian"></span></th>
                                <th><span class="iconfont icon-house"></span></th>
                                <th><span class="iconfont icon-chuanghu"></span></th>
                                <th><span class="iconfont icon-renshu"></span></th>
                                <th><span class="iconfont icon-jiuhuashantubiao-"></span></th>
                                <th><span class="iconfont icon-yanhuishi"></span></th>
                                <th><span class="iconfont icon-juyuanshi"></span></th>
                                <th><span class="iconfont icon-jiweijiubei"></span></th>
                                <th><span class="iconfont icon-fenzushumu"></span></th>
                                <th><span class="iconfont icon-dongshihui"></span></th>
                                <th><span class="iconfont icon-jiage1"></span></th>
                            </tr>
                            <tr>
                                <th colspan=2><span>会议室名称/详情</span></th>
                                <th><span>面积</span></th>
                                <th><span>尺寸</span></th>
                                <th><span>层高</span></th>
                                <th><span>灯下高度</span></th>
                                <th><span>楼层</span></th>
                                <th><span>立柱</span></th>
                                <th><span>有窗</span></th>
                                <th><span>容纳人数</span></th>
                                <th><span>课桌式</span></th>
                                <th><span>中式宴会</span></th>
                                <th><span>剧院式</span></th>
                                <th><span>鸡尾酒</span></th>
                                <th><span>分组式</span></th>
                                <th><span>董事会</span></th>
                                <th><span>参考价(每天)</span></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if(!empty($data['meetings'])){
                            foreach($data['meetings'] as $keym => $valuem){?>

                            <tr>
                                <td class="">
                                    <div class="cont-title">
                                        <a rel="nofollow" class="room_unfold" href="javascript:void(0);" onclick="HotelRoom.onNameClick(this)">

                                            <?=isset($valuem['meeting_name'])?$valuem['meeting_name']:$valuem['Name']?> </a>
                                        <p class="look-info">查看详情</p>
                                    </div>
                                </td>
                                <td class="">
                                    <a id="" class="pic" rel="nofollow" onclick="HotelRoom.onNameClick(this)" href="javascript:void(0);"> <img class="small-pic" id="" src="<?php echo isset($valuem['meeting_pics'][0]['pic_url'])?strpos($valuem['meeting_pics'][0]['pic_url'],'eventown') !== false ?$valuem['meeting_pics'][0]['pic_url']:''.$valuem['meeting_pics'][0]['pic_url']:'http://image.eventown.com/FrU6khjiOJsP38sWZ8xsphyIWTaW'?>" style="border-width:0px;"></a>
                                </td>
                                <td><span><?=isset($valuem['area'])?$valuem['area']:'--'?></span></td>
                                <td><span><?=isset($valuem['length'])?$valuem['length']:''?>*<?=isset($valuem['width'])?$valuem['width']:''?></span></td>
                                <td><span><?=isset($valuem['height'])?$valuem['height']:'--'?></span></td>
                                <td><span><?=isset($valuem['light_height'])?$valuem['light_height']:'--'?></span></td>
                                <td><span><?=isset($valuem['floor'])?$valuem['floor']:'--'?></span></td>
                                <td><span>
                                        <?php if(isset($valuem['is_column'])){
                                            echo isset($valuem['is_column']) && $valuem['is_column']?'是':'否';
                                        }else{
                                            echo isset($valuem['HasPillar']) && $valuem['HasPillar']?$valuem['HasPillar']:'--';
                                        }

                                        ?>
                                        </span></td>
                                <td><span>

                                        <?php echo isset($valuem['is_window']) && $valuem['is_window']?'是':'否';?></span></td>
                                <td><span><?=isset($valuem['max_capacity'])?$valuem['max_capacity']:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][1])?$valuem['layout'][1]:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][2])?$valuem['layout'][2]:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][3])?$valuem['layout'][3]:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][4])?$valuem['layout'][4]:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][5])?$valuem['layout'][5]:'--'?></span></td>
                                <td><span><?=isset($valuem['layout'][6])?$valuem['layout'][6]:'--'?></span></td>
                                <td><span><?=isset($valuem['price'])?$valuem['price']:'--'?></span></td>
                            </tr>
                            <tr class="new-add-tr  new-add-tr1439" style="display: none;">
                                <td colspan="17">
                                    <div class="add-hotel-info">
                                        <div class="hotel-img">
                                            <?php
                                            if(isset($valuem['meeting_pics']) && !empty($valuem['meeting_pics'])){foreach($valuem['meeting_pics'] as $pkey => $pvaleu){?>
                                            <a href="javascript:void(0)">
                                                <img class="showMaxImg" src="<?php echo $pvaleu['pic_url']?>">
                                            </a>
                                            <?php }}else{?>
                                                <a href="javascript:void(0)">
                                                    <img class="showMaxImg" src="http://image.eventown.com/FrU6khjiOJsP38sWZ8xsphyIWTaW">
                                                </a>
                                            <?php }?>
                                        <p>

                                            <span> <cite> 是否有讲台:</cite><i><?=isset($valuem['is_platform']) && $valuem['is_platform']?'是':'否'?></i></span>
                                            <span> <cite> 是否有舞台:</cite><i><?=isset($valuem['is_stage']) && $valuem['is_stage'] ?'是':'否'?></i></span>
                                            <span> <cite> 是否有投影/LED:</cite><i>是</i></span>
                                            <span> <cite> 宽带:</cite><i><?=isset($valuem['shared_bandwidth'])?$valuem['shared_bandwidth']:''?>M</i></span>
                                        </p>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            <?php }}else{
                                echo '暂无数据';
                            }?>


                        </tbody>
                    </table>
                </div>
                <h4 class="pro_title" id="f5"><i class="icon iconfont">&#xe626;</i>服务设施</h4>
                <div class="pro_service">
                    <?php  if (!empty($data['place_options']['meeting_equi'])): ?>
                    <dl>
                        <dt>会议服务设施</dt>
                        <dd>

                            <?php
                            foreach ($data['place_options']['meeting_equi'] as $item) {
                            echo "<span class=\"success\"><i class=\"icon iconfont\">&#xe609;</i>" . $item . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>

                    <?php  if (!empty($data['place_options']['hotel_service'])): ?>
                    <dl>
                        <dt>酒店服务设施</dt>
                        <dd>
                            <?php
                            foreach ($data['hotel_service'] as $item) {
                            echo "<span class=\"success\"><i class=\"icon iconfont\">&#xe609;</i>" . $item . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_service'])): ?>
                    <dl>
                        <dt>场地服务设施</dt>
                        <dd>
                            <?php
                            foreach ($data['meeting_service'] as $item) {
                            echo "<span class=\"success\"><i class=\"icon iconfont\">&#xe609;</i>" . $item . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>

                    <?php  if (!empty($data['place_options']['room_equi'])): ?>
                    <dl>
                        <dt>客房服务设施</dt>
                        <dd>

                            <?php
                            foreach ($data['place_options']['room_equi'] as $item) {
                            echo "<span class=\"success\"><i class=\"icon iconfont\">&#xe609;</i>" . $item . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>

                </div>
            </div>


            <!--房间信息-->

            <div id="rooms" class="price_container" style="display:none">
                <div class="pro_bable">
                    <table class="table table-hover rooms_style" id="pro_table_room1">
                        <thead>
                        <tr>
                            <th><img src="/assets/img/room-1.png" style="width: 17px;height:17px;"></th>
                            <th><img src="/assets/img/room-2.png" style="width: 17px;height:17px;"></th>
                            <th><img src="/assets/img/room-3.png" style="width: 17px;height:17px;"></th>
                            <th><img src="/assets/img/room-4.png" style="width: 17px;height:17px;"></th>
                            <th><img src="/assets/img/room-5.png" style="width: 17px;height:17px;"></th>
                            <th><img src="/assets/img/room-1.png" style="width: 17px;height:17px;"></th>
                        </tr>
                        <tr>
                            <th><span>房间类型</span></th>
                            <th><span>房间数量</span></th>
                            <th><span>房间面积</span></th>
                            <th><span>是否有窗</span></th>
                            <th><span>是否加床</span></th>
                            <th><span>最多入住人数</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($data['meeting_rooms_info']) && isset($data['meeting_rooms_info'])) { ?>
                            <?php foreach ($data['meeting_rooms_info'] as $key => $value): ?>

                                    <tr onclick="tabServise(<?php echo $key;?>);" style="cursor: pointer;">
                                        <td><strong><?= $value['room_name'] ?></strong>
                                            <img class="small-pic" id="" src="<?php echo isset($value['room_pics'][0]['pic_url'])?strpos($value['room_pics'][0]['pic_url'],'eventown') !== false ?$value['room_pics'][0]['pic_url']:''.$value['room_pics'][0]['pic_url']:'http://image.eventown.com/FrU6khjiOJsP38sWZ8xsphyIWTaW'?>" style="border-width:0px;">
                                        </td>
                                        <td><?php echo (isset($value['count']) && !empty($value['count']))?$value['count']:0 ; ?>间</td>
                                        <td><?php if (isset($value['area'])) {echo $value['area'].'平米';}  ?></td>
                                        <td><?php if (isset($value['is_window'])) {echo $value['is_window'] == 1 ? '是' : '否';}  ?></td>
                                        <td><?php if (isset($value['is_extra_bed'])) {echo $value['is_extra_bed'] == 1 ? '是' : '否';}  ?></td>
                                        <td><?php if (isset($value['max_capacity'])) {echo $value['max_capacity'];}  ?>人</td>
                                    </tr>

                            <?php endforeach; ?>
                        <?php }else{
                            echo '暂无数据';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <h4 class="pro_title" id="f5">
                    <img src="/assets/img/icon-service.png" style="width: 19px;height:19px;margin-bottom: 5px;">
                    服务设施</h4>
                <div class="pro_service pro_service_rooms">
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['media_technology'])): ?>
                    <dl>
                        <dt class="rooms_color">媒体/科技</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['media_technology'] as $item) {
                            echo "<span class=\"success\">" . $system_info['media_technology'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['food_beverages'])): ?>
                    <dl>
                        <dt class="rooms_color">食品/饮品</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['food_beverages'] as $item) {
                            echo "<span class=\"success\">" . $system_info['food_beverages'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['outdoors_views'])): ?>
                    <dl>
                        <dt class="rooms_color">室外/景观</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['outdoors_views'] as $item) {
                            echo "<span class=\"success\">" . $system_info['outdoors_views'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['services_others'])): ?>
                    <dl>
                        <dt class="rooms_color">服务及其他</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['services_others'] as $item) {
                            echo "<span class=\"success\">" . $system_info['services_others'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['convenient_facilities'])): ?>
                    <dl>
                        <dt class="rooms_color">便利设施</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['convenient_facilities'] as $item) {
                            echo "<span class=\"success\">" . $system_info['convenient_facilities'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    <?php  if (!empty($data['meeting_rooms_info'][0]['facility']['bathroom'])): ?>
                    <dl>
                        <dt class="rooms_color">浴室</dt>
                        <dd>

                            <?php
                            foreach ($data['meeting_rooms_info'][0]['facility']['bathroom'] as $item) {
                            echo "<span class=\"success\">" . $system_info['bathroom'][$item] . "</span>";
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php endif;?>


                </div>
            </div>

        </div>





            <!--房间信息end-->

            <!--        餐饮信息-->
            <div id="foods" class="price_container" style="display:none">
                <div class="pro_bable">
                    <table class="table table-hover" id="pro_table_room1">
                        <thead>
                        <tr>
                            <th><span>餐饮类型</span></th>
                            <th><span>最低用餐人数</span></th>
                            <th><span>平时价（￥）</span></th>
                            <th><span>周末价（￥）</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $typeFood = ['中餐',
                            '西餐',
                            '自助午餐',
                            '标准茶歇',
                            '简单茶歇',
                            '商务简餐',
                            '自助晚餐',];
                        if (!empty($data['yrfp_food_price']) && isset($data['yrfp_food_price']['data'])) { ?>
                            <?php foreach ($data['yrfp_food_price']['data'] as $value): ?>
                                <tr>
                                    <td><strong><?=$typeFood[$value['dining_type']];?></strong></td>
                                    <td><?= $value['diners_min'] ?></td>
                                    <td><?= $value['peacetime_price'] ?></td>
                                    <td><?= $value['weekend_price'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php }else{
                            echo '暂无数据';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--餐饮信息end-->
            <!-- 会议包信息-->
            <div id="packages" class="price_container" style="display:none">
                <div class="pro_bable">
                    <table class="table table-hover" id="pro_table_room1">
                        <thead>
                        <tr>
                            <th><span>会议套餐名称</span></th>
                            <th><span>起订人数</span></th>
                            <th><span>日均单价（￥）</span></th>
                            <th><span>描述</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($data['yrfp_package_price']) && isset($data['yrfp_package_price']['data'])) { ?>
                            <?php foreach ($data['yrfp_package_price']['data'] as $value): ?>
                                <tr>
                                    <td><strong><?= $value['package_name']; ?></strong></td>
                                    <td><?= $value['minimum'] ?></td>
                                    <td><?= $value['peacetime_price'] ?></td>
                                    <td><?= $value['describe'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php }else{
                            echo '暂无数据';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--会议包信息end-->
            <!--        设施信息-->
            <div id="equips" class="price_container" style="display:none">
                <div class="pro_bable">
                    <table class="table table-hover" id="pro_table_room1">
                        <thead>
                        <tr>
                            <th><span>设施</span></th>
                            <th><span>租售方式</span></th>
                            <th><span>半天价（￥）</span></th>
                            <th><span>全天价（￥）</span></th>
                            <th><span>单次价（￥）</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $fangshi = ['租',
                            '售',
                            '赠'];
                        if (!empty($data['yrfp_equip_price']) && isset($data['yrfp_equip_price']['data'])) { ?>
                            <?php foreach ($data['yrfp_equip_price']['data'] as $value): ?>
                                <tr>
                                    <td><strong><?= $value['facility'] ?></strong></td>
                                    <td><?=$fangshi[$value['rental_type']]?></td>
                                    <td><?= $value['half_day_price'] ?></td>
                                    <td><?= $value['all_day_price'] ?></td>
                                    <td><?= $value['once_price'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php }else{
                            echo '暂无数据';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--设施信息end-->
            <a href=""  name="place_map"></a>

            <h4 class="pro_title" id="f4"><i class="icon iconfont">&#xe613;</i>地图位置</h4>
            <div class="pro_map_box">
                <div class="pro_map" >
                    <!--                <div id="placeMap"></div>-->
                    <div id="placeMap" style="height:600px"></div>
                </div>

                <div class="pro_map_info" style="padding-left:10px; width:210px; height:600px;">
                    <div class="list" id="list">
                        <div class="black" style="overflow:hidden">
                            <a href="javascript:;" id="black" style="color:#c00; float:left; margin-right:10px;display:none;font-size:12px;border-right: 1px solid #ccc;height: 12px;line-height: 12px;margin-top: 5px;padding-right: 5px; ">< 返回</a>
                            <h1 id="titleSearch" style="margin:0px; padding:0px; font-size:14px; line-height:20px;">周边查询</h1>
                        </div>

                        <div id="typeList">
                            <a href="javascript:;" range=true alt="酒店" class="hotel" id="hotel"><i></i>酒店</a>
                            <a href="javascript:;" range=true alt="餐厅" class="restaurant" id="foot"><i></i>餐厅</a>
                            <a href="javascript:;" range=true alt="地铁" class="metro" id="metro"><i></i>地铁</a>
                            <a href="javascript:;" range=true alt="娱乐" class="entertainment" id="happy"><i></i>娱乐</a>
                            <a href="javascript:;" range=true alt="景点" class="sight" id="spots"><i></i>景点</a>
                            <a href="javascript:;" range=true alt="商场" class="market" id="shoping"><i></i>商场</a>
                        </div>
                        <div id="flayBox">
                            <h2 style="font-size:14px;margin:20px 0px 0; padding:0px;">交通枢纽<span style="font-size:12px; color:#999; margin-left:5px;">(快速查询到酒店的路线)</span></h2>
                            <div id="airportList">
                                <ul>
                                    <li>
                                        <i class="airport"></i>
                                        <div>
                                            <a href="javascript:;" alt="南苑机场" lng="116.409698486328" lat="39.7984390258789" >南苑机场</a> |
                                            <a href="javascript:;" alt="首都国际机场" lng="116.594497680664" lat="40.0872383117676">首都国际机场</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="train"></i>
                                        <div>
                                            <a href="javascript:;" alt="北京火车站" lng="116.4338" lat="39.90977" >北京火车站</a> |
                                            <a href="javascript:;" alt="北京西站" lng="116.327697753906" lat="39.9018783569336" >北京西站</a> |
                                            <a href="javascript:;" alt="北京南站" lng="116.385498046875" lat="39.871208190918" >北京南站</a> |
                                            <a href="javascript:;" alt="北京北站" lng="116.3604" lat="39.94852" >北京北站</a> |
                                            <a href="javascript:;" alt="北京东火车站" lng="116.4911" lat="39.90867" >北京东火车站</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="tripBox">
                            <h3 id="selectBtn" style="margin:15px 0 0; padding:0px; font-size:14px;">线路查询</h3>
                            <div id="trip_type">
                                <a href="javascript:;" class="active" id="trip_bus"  alt="公交" nType="0">公交</a>
                                <a href="javascript:;" id="trip_car"  alt="驾车" nType="1">驾车</a>
                                <a href="javascript:;" id="trip_walk" alt="步行"  nType="2">步行</a>
                            </div>
                            <div class="fromList">
                                <input type="text" placeholder="起点" autocomplete="off" id="startAddress">
                                <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                                <input type="text" placeholder="终点" autocomplete="off" id="endAddress" disabled>
                                <button type="button" class="searchBtn" id="checkRoute">查询路线</button>
                            </div>
                        </div>
                        <!-- <button id="addEvent">绑定事件</button> -->
                    </div>

                    <div id="citylist" style="height:470px;">
                        <div class="loading">
                            <img src="/assets/img/loading.gif" alt="">
                            <span>紧张加载中.............</span>
                        </div>
                    </div>

                </div>
            </div>

    </div>

    </div>
    <!--弹出层 -->
    <div class="photo_main">
        <div class="photo_tit">
            <ul>
                <li class="active"><a href="javascript:;">其他</a></li>
            </ul>
        </div>
        <div class="photo_body">
            <?php  foreach ($data['place_pic'] as $k1 => $v1): if (!$v1)continue;?>
                <div class="photo_con" <?php if(!$k1)echo 'style="display:block"'?>>
                    <div class="photo-l">
                        <ul>
                            <?php foreach ($data['place_pic'] as $k2 => $v2):?>
                                <li <?php if(!$k2)echo 'class="active"'?>>
                                    <a href="javascript:;"><img src="<?=$v2['pic_url']?>" alt=""></a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="photo-r">
                        <ul>
                            <?php foreach ($data['place_pic'] as $k2 => $v2):?>
                                <li <?php if(!$k2)echo 'style="display:block"'?>>
                                    <img src="<?=$v2['pic_url']?>" alt="">
                                </li>
                            <?php endforeach;?>

                        </ul>
                    </div>

                </div>
            <?php endforeach;?>


        </div>
    </div>

    <!-- end -->

    <!-- 新增导航 -->
    <div class="floatBtn">


        <a class="elevator-cart" href="javascript:void(0)">
            <div class="btnBox"><span class="box1"><div class="num number_cart">0</div><i class="icon iconfont">&#xe603;</i></span><span class="box2"><em>询单<br>车</em></span></div>
        </a>
        <a class="elevator-tel" onclick="ysf.open();return false;">
            <div class="btnBox"><span class="box1"><i class="icon iconfont">&#xe619;</i></span><span class="box2"><em>服务<br>咨询</em></span></div>
            <div class="elevator-tel-box"></div>
        </a>
        <a class="elevator-top">
            <div class="btnBox"><span class="box1"><i class="icon iconfont">&#xe646;</i></span><span class="box2" id="go_top"><em>返回<br>顶部</em></span></div>
        </a>
    </div>
    <!-- End -->


    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8"></script>
    <script src="http://links.eventown.com.cn/vendor/seajs/seajs-3.0.0/sea.js" type="text/javascript"></script>
    <script>
        seajs.use('/assets/js/place_view.js')
        seajs.use('/assets/js/jquery.min.js')
        seajs.config({
            base:'/js/',
            //设置路径，方便跨目录调用
            paths: {
                'links': 'http://links.eventown.com.cn'
            },
            //设置别名，方便调用
            alias: {
                'layer':'links/vendor/layer/layer.js',
                'cookie': 'links/vendor/plugins/jquery.cookie.cmd.js',
                'Handlebars':'links/vendor/handlebars/handlebars.min.js',
            },
            preload: ['jquery']
        })

    </script>
    <script>
        var GLOBAL={
            www_url:'<?php echo  $data['wwwUrl']; ?>'
        }
    </script>
    <script src="/assets/js/jquery.min.js"></script>
    <script>
    $(document).ready(function () {
        $(".look-info").click(function () {
            if($(this).hasClass("active")){
                $(this).removeClass("active");
                $(this).parents("tr").next(".new-add-tr").css("display","none");
            }else{
                $(this).addClass("active");
                $(this).parents("tr").next(".new-add-tr").css("display","table-row");
            }
        })
    });

    function tabServise(key){

        $.ajax( {
            type: "post",
            url: '/place/placeRoomInfo',
            data: {'key':key,'place_id':'<?php echo $place_id;?>'},
            dataType:'html',
            timeout: 5000,
            success: function( html )
            {
                $('.pro_service_rooms').html(html);
            }
        } );

    }
    </script>

</body>
</html>
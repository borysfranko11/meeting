<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>场地推荐</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/style.extend.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/plugins/toChoice/core.css" rel="stylesheet">
        <link href="/assets/css/plugins/fakeLoader/fakeLoader.css" rel="stylesheet">

        <style type="text/css">
            .footable-filtering{display: none;}
            .footable-paging{display: none;}

            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}

            .dashed-wrapper-gray{border: 1px dashed #DBDEE0; padding: 10px 20px 0; background-color: #fafafa}
            .padding-none{padding: 0;}

            .agile-list li{border-width: 0;}

            #choiced_hotel_list{position: fixed; top: 300px; right: -200px; display: flex;}
            #choiced_hotel_list .drawer-btn{display: flex; align-items: center;}
            #choiced_hotel_list .drawer-btn>a{display: block; color: #23c6c8; width: 24px; height: 50px; border: 1px solid #23c6c8; border-right-width: 0; border-radius: 4px 0 0 4px; text-align: center; line-height: 50px; text-decoration: none; font-size: 26px; background-color: #FFF;}
            #choiced_hotel_list .choiced-content{background-color: #FFF; width: 200px; color: #FFF; border-radius: 0 0 2px 2px;}
            #choiced_hotel_list .choiced-content>div{border-top: none;}
            #choiced_hotel_list .caption{height: 40px; line-height: 40px; border-radius: 4px 4px 0 0; font-size: 18px; text-align: center; background: #23c6c8}
            #choiced_hotel_list .footer{height: 40px; padding: 0; margin: 0; line-height: 40px; border-radius:  0 0 4px 4px; border: 1px solid #23c6c8; font-size: 18px; text-align: center;}
            #choiced_hotel_list .item{border:1px solid #23c6c8;font-size: 18px;padding-left: 9px;padding-right: 9px;height: 60px;}
            #choiced_hotel_list .remove{height: 24px; text-align: right; line-height: 20px; font-size: 20px; color: #23c6c8; cursor: pointer;}
            #choiced_hotel_list .text{font-size: 14px; color: #676a6c; text-overflow: clip; white-space: nowrap; overflow: hidden;}
            .item-radius{border-radius:  0 0 4px 4px;}
            /* #submit-keyword{position: absolute;top:0;}  */
            label{font-weight: 300;}
            .tips{
                display: none;
                position: absolute;
                background: #fff;
                box-shadow: 0 0 2px #ddd;
                z-index: 999;
                left: 0;
                font-size: 10px;
                top: 0;
                width: 280px;
                height:82px;
                border-radius: 30px;
                border: 1px solid #ccc;
                padding: 10px
            }
            /*地图提示信息*/
            .map_head{
                overflow: hidden;
            }
            .map_place_img{
                float: left;
            }
            .map_place_img img{
                width:80px;
                border-radius: 20px;
            }
            .map_place_title{
                float: left;
                padding-left: 10px;
                padding-top: 5px;
                width: 170px;
            }
            .map_place_title .star{
                display: block;
                overflow: hidden;
            }
            .map_place_add{
                font-size: 12px;
                margin-bottom: 0;
                color: #666;
                display:block;
                width: 100%;
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            }
            .map_place_title h3{
                margin: 0;
                padding-top: 5px;
                font-size: 14px;
            }
            .map_place_info{
                width: 260px;
                font-size: 12px;
            }
            .map_place_info ul{
                margin-bottom: 0;
                padding-top: 5px;
            }
            .map_place_info li{
            }
            .map_place_info a{
                color:#0084bb;
            }
            .map_place_info em{
                color:#a51c30;
                font-style: normal;
            }
        </style>
    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">
                                场地推荐

                                <a href="@if( !empty( $data["rfp_id"] ) ) {{'/Rfp/edit?rfp_id='.$data["rfp_id"]}} @else {{'/Rfp/index'}} @endif" class="btn btn-outline btn-info pull-right">
                                    <i class="fa fa-reply"></i> 返回
                                </a>
                            </h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">我的会议</a>
                                </li>
                                <li>
                                    <strong>场地推荐</strong>
                                </li>
                            </ol>
                        </div>
                        <div class="ibox-content">
                            <form id="submit_form" class="form-horizontal" method="POST" action="#" data-status="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dashed-wrapper-gray padding-none" style="color: #0d0316">
                                        <div class="form-group m-t">
                                            <label class="col-sm-1 control-label">类 型：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-area-type clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);" @if( empty( $data["place_type"] ) ) {{'style="color: rgb(0, 182, 184);"'}} @endif> 不限</a></li>
                                                    <li data-choiced={"id":"1","name":"酒店"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 1 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 酒店</a></li>
                                                    <li data-choiced={"id":"4","name":"艺术中心/剧院"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 4 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 艺术中心/剧院</a></li>
                                                    <li data-choiced={"id":"3","name":"餐厅/会所"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 3 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 餐厅/会所</a></li>
                                                    <li data-choiced={"id":"2","name":"会议中心/展览馆/体育馆"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 2 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 会议中心/展览馆/体育馆</a></li>
                                                    <!--<li data-choiced={"id":"8","name":"度假村"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 8 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 度假村</a></li>-->
                                                    <li data-choiced={"id":"5","name":"其他"}><a href="javascript: void(0);" @if( !empty( $data["place_type"] ) && $data["place_type"] === 5 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 其他</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">位 置：</label>

                                            <div class="col-sm-10 p-l-none">
                                                <ul class="to-choice-list single-area-location clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);"> 不限</a></li>
                                                @if( !empty( $data["select"] ) )
                                                    <!-- 行政区域 -->
                                                        @if( !empty( $data["select"]["area"] ) )
                                                            <?php $level_1_key = 'area'; ?>
                                                            <li data-choiced={"id":"1","name":"行政区域","key":"AreaCity","prefix":"area_id"}>
                                                                <a href="javascript: void(0);" style="color: rgb(0, 182, 184);"> 行政区域</a>
                                                            </li>
                                                        @else
                                                            <li data-choiced={"id":"1","name":"行政区域","key":"AreaCity","prefix":"area_id"}><a href="javascript: void(0);"> 行政区域</a></li>
                                                        @endif

                                                    <!-- 热门商圈 -->
                                                        @if( !empty( $data["select"]["business"] ) )
                                                            <?php $level_1_key = 'business'; ?>
                                                            <li data-choiced={"id":"2","name":"热门商圈","key":"HotBusinessDistrict","prefix":"business_id"}>
                                                                <a href="javascript: void(0);" style="color: rgb(0, 182, 184);"> 热门商圈</a>
                                                            </li>
                                                        @else
                                                            <li data-choiced={"id":"2","name":"热门商圈","key":"HotBusinessDistrict","prefix":"business_id"}><a href="javascript: void(0);"> 热门商圈</a></li>
                                                        @endif

                                                    <!-- 机场 -->
                                                        @if( !empty( $data["select"]["airport"] ) )
                                                            <?php $level_1_key = 'airport'; ?>
                                                            <li data-choiced={"id":"3","name":"机场","key":"DisplayAirport","prefix":"airport_id"}>
                                                                <a href="javascript: void(0);" style="color: rgb(0, 182, 184);"> 机场</a>
                                                            </li>
                                                        @else
                                                            <li data-choiced={"id":"3","name":"机场","key":"DisplayAirport","prefix":"airport_id"}><a href="javascript: void(0);"> 机场</a></li>
                                                        @endif

                                                    <!-- 火车站 -->
                                                        @if( !empty( $data["select"]["train"] ) )
                                                            <?php $level_1_key = 'train'; ?>
                                                            <li data-choiced={"id":"4","name":"火车站","key":"TrainStation","prefix":"train_station_id"}>
                                                                <a href="javascript: void(0);" style="color: rgb(0, 182, 184);"> 火车站</a>
                                                            </li>
                                                        @else
                                                            <li data-choiced={"id":"4","name":"火车站","key":"TrainStation","prefix":"train_station_id"}><a href="javascript: void(0);"> 火车站</a></li>
                                                        @endif

                                                    <!-- 地铁周边 -->
                                                        @if( !empty( $data["select"]["metro"] ) )
                                                            <?php $level_1_key = 'metro'; ?>
                                                            <li id="subway_choice" class="choiced-except" data-choiced={"id":"5","name":"地铁周边","key":"MetroLines","prefix":"metro"}>
                                                                <a href="javascript: void(0);" style="color: rgb(0, 182, 184);"> 地铁周边</a>
                                                            </li>
                                                        @else
                                                            <li id="subway_choice" class="choiced-except" data-choiced={"id":"5","name":"地铁周边","key":"MetroLines","prefix":"metro"}><a href="javascript: void(0);"> 地铁周边</a></li>
                                                        @endif

                                                    @else
                                                        <li data-choiced={"id":"1","name":"行政区域","key":"AreaCity","prefix":"area_id"}><a href="javascript: void(0);"> 行政区域</a></li>
                                                        <li data-choiced={"id":"2","name":"热门商圈","key":"HotBusinessDistrict","prefix":"business_id"}><a href="javascript: void(0);"> 热门商圈</a></li>
                                                        <li data-choiced={"id":"3","name":"机场","key":"DisplayAirport","prefix":"airport_id"}><a href="javascript: void(0);"> 机场</a></li>
                                                        <li data-choiced={"id":"4","name":"火车站","key":"TrainStation","prefix":"train_station_id"}><a href="javascript: void(0);"> 火车站</a></li>
                                                        <li id="subway_choice" class="choiced-except" data-choiced={"id":"5","name":"地铁周边","key":"MetroLines","prefix":"metro"}><a href="javascript: void(0);"> 地铁周边</a></li>
                                                    @endif
                                                </ul>

                                                <ul id="location_level_1" class="to-choice-list choice-pos-rel clearfix" style="@if( !empty( $level_1_key ) ) {{'display: block;'}}@else {{'display: none;'}} @endif">
                                                    <li class="arrow" ><i class="fa fa-caret-right"></i></li>
                                                    @if( !empty( $level_1_key ) )
                                                        @foreach( $data["select"][$level_1_key] as $key => $detail )
                                                            @if( $level_1_key !== 'metro' )
                                                                <li class="now-node" data-choiced="{&quot;id&quot;:&quot;{{$detail["id"]}}&quot;,&quot;name&quot;:&quot;{{$detail["name"]}}&quot;}">
                                                                    <a href="javascript: void(0);" @if( $detail["selected"] ) {!!'style="color: rgb(0, 182, 184);"'!!} <?php $location_msg = $detail; unset( $location_msg["selected"] ); ?>  @endif> {{$detail["name"]}}</a>
                                                                </li>
                                                            @else
                                                                <li class="now-node" data-choiced="{&quot;id&quot;:&quot;{{$detail["id"]}}&quot;,&quot;name&quot;:&quot;{{$detail["name"]}}&quot;}">
                                                                    <a href="javascript: void(0);"
                                                                    @if( $detail["selected"] ) {!!'style="color: rgb(0, 182, 184);"'!!}
                                                                    <?php $level_2_data = $detail["stations"]; $pid=$detail["id"]; ?>
                                                                            @endif> {{$detail["name"]}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                                <ul id="location_level_2" class="to-choice-list choice-pos-rel clearfix" style="@if( !empty( $level_2_data ) ) {{'display: block;'}}@else {{'display: none;'}} @endif">
                                                    <li class="arrow"><i class="fa fa-caret-right"></i></li>
                                                    @if( !empty( $level_2_data ) )
                                                        @foreach( $level_2_data as $s_key => $s_detail )
                                                            <li class="now-node" data-choiced="{&quot;id&quot;:&quot;{{$s_detail["id"]}}&quot;,&quot;name&quot;:&quot;{{$s_detail["name"]}}&quot;}">
                                                                <a href="javascript: void(0);" @if( $s_detail["selected"] ) {!!'style="color: rgb(0, 182, 184);"'!!} <?php $location_msg = $s_detail; unset( $location_msg["selected"] ); ?>  @endif> {{$s_detail["name"]}}</a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>

                                                <div id="location_loading" class="data-loading">
                                                    <div>
                                                        <i class="fa fa-spin fa-spinner icon"></i>
                                                        <span class="desc">数据传输中，请稍后...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">星 级：</label>

                                            <div class="col-sm-10 p-l-none">
                                                <ul class="to-choice-list multi-star-level clearfix">
                                                    <li data-choiced={"id":"0","name":"不限","limit":"0"}>
                                                        <a href="javascript: void(0);" @if( empty( $data["place_star"] ) ) {!!'style="color: rgb(0, 182, 184);"'!!}@endif> 不限</a>
                                                    </li>

                                                        <?php

                                                        $star = explode( ',', $data["place_star"] );

                                                        $dom = [
                                                            '5' => '<li data-choiced={"id":"5","name":"5星"}><a href="javascript: void(0);" {ifChoiced}> 5星</a></li>',
                                                            '4' => '<li data-choiced={"id":"4","name":"4星"}><a href="javascript: void(0);" {ifChoiced}> 4星</a></li>',
                                                            '3' => '<li data-choiced={"id":"3","name":"3星"}><a href="javascript: void(0);" {ifChoiced}> 3星</a></li>',
                                                            '1' => '<li data-choiced={"id":"1,2","name":"其他"}><a href="javascript: void(0);" {ifChoiced}> 其他</a></li>'
                                                        ];

                                                        foreach( $dom as $dom_key => $dom_detail )
                                                        {
                                                            if( in_array( $dom_key, $star ) )
                                                            {
                                                                echo str_replace( '{ifChoiced}', 'style="color: rgb(0, 182, 184);"', $dom_detail );
                                                            }
                                                            else
                                                            {
                                                                echo str_replace( '{ifChoiced}', '', $dom_detail );
                                                            }
                                                        }
                                                        ?>

                                                </ul>
                                            </div>
                                        </div>
                                        <?php $color = "style='color: rgb(0, 182, 184);'";?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">人 数：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-desk-num clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 0 ? $color : '';?> >不限</a></li>
                                                    <li data-choiced={"id":"1","name":"10-50人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 1 ? $color : '';?> > 10-50人</a></li>
                                                    <li data-choiced={"id":"2","name":"51-100人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 2 ? $color : '';?> > 51-100人</a></li>
                                                    <li data-choiced={"id":"3","name":"101-150人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 3 ? $color : '';?> > 101-150人</a></li>
                                                    <li data-choiced={"id":"4","name":"151-300人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 4 ? $color : '';?> > 151-300人</a></li>
                                                    <li data-choiced={"id":"5","name":"301-500人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 5 ? $color : '';?> > 301-500人</a></li>
                                                    <li data-choiced={"id":"6","name":"501-1000人"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 6 ? $color : '';?> > 501-1000人</a></li>
                                                    <li data-choiced={"id":"7","name":"1000人以上"}><a href="javascript: void(0);" <?php echo $data['people_select'] == 7 ? $color : '';?> > 1000人以上</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">面 积：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-desk-area clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 0 ? $color : '';?>> 不限</a></li>
                                                    <li data-choiced={"id":"1","name":"0-100平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 1 ? $color : '';?>> 0-100平</a></li>
                                                    <li data-choiced={"id":"2","name":"101-200平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 2 ? $color : '';?>> 101-200平</a></li>
                                                    <li data-choiced={"id":"3","name":"201-300平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 3 ? $color : '';?>> 201-300平</a></li>
                                                    <li data-choiced={"id":"4","name":"301-500平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 4 ? $color : '';?>> 301-500平</a></li>
                                                    <li data-choiced={"id":"5","name":"501-1000平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 5 ? $color : '';?>> 501-1000平</a></li>
                                                    <li data-choiced={"id":"6","name":"1001-2000平"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 6 ? $color : '';?>> 1001-2000平</a></li>
                                                    <li data-choiced={"id":"7","name":"2000以上"}><a href="javascript: void(0);" <?php echo $data['area_select'] == 7 ? $color : '';?>> 2000以上</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">价 格：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-desk-price clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 0 ? $color : '';?>> 不限</a></li>
                                                    <li data-choiced={"id":"1","name":"0-5000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 1 ? $color : '';?>> 0-5000元</a></li>
                                                    <li data-choiced={"id":"2","name":"5001-10000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 2 ? $color : '';?>> 5001-10000元</a></li>
                                                    <li data-choiced={"id":"3","name":"10001-20000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 3 ? $color : '';?>> 10001-20000元</a></li>
                                                    <li data-choiced={"id":"4","name":"20001-50000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 4 ? $color : '';?>> 20001-50000元</a></li>
                                                    <li data-choiced={"id":"5","name":"50001-100000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 5 ? $color : '';?>> 50001-100000元</a></li>
                                                    <li data-choiced={"id":"6","name":"100001-200000元"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 6 ? $color : '';?>> 100001-200000元</a></li>
                                                    <li data-choiced={"id":"7","name":"200000元以上"}><a href="javascript: void(0);" <?php echo isset($data['price_select'])&&$data['price_select'] == 7 ? $color : '';?>> 200000元以上</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">
                                            <label class="col-sm-1 control-label">摆 台：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-desk-shape clearfix">
                                                    <li data-choiced={"id":"1","name":"课桌式"}><a href="javascript: void(0);"> 课桌式</a></li>
                                                    <li data-choiced={"id":"2","name":"中式会议"}><a href="javascript: void(0);"> 中式会议</a></li>
                                                    <li data-choiced={"id":"3","name":"剧院式"}><a href="javascript: void(0);"> 剧院式</a></li>
                                                    <li data-choiced={"id":"4","name":"鸡尾酒"}><a href="javascript: void(0);"> 鸡尾酒</a></li>
                                                    <li data-choiced={"id":"5","name":"鱼骨式"}><a href="javascript: void(0);"> 鱼骨式</a></li>
                                                    <li data-choiced={"id":"6","name":"董事会"}><a href="javascript: void(0);"> 董事会</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">窗 户：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-choiced-window clearfix">
                                                    <li data-choiced={"id":"1","name":"1"}><a href="javascript: void(0);"> 有</a></li>
                                                    <li data-choiced={"id":"2","name":"0"}><a href="javascript: void(0);"> 无</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">立 柱：</label>

                                            <div class="col-sm-11 p-l-none">
                                                <ul class="to-choice-list single-choiced-column clearfix">
                                                    <li data-choiced={"id":"1","name":"1"}><a href="javascript: void(0);"> 有</a></li>
                                                    <li data-choiced={"id":"2","name":"0"}><a href="javascript: void(0);"> 无</a></li>
                                                </ul>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="dashed-wrapper-gray padding-none m-t-md" style="display: none;">
                                        <div class="form-group m-t-sm m-b-none">
                                            <label class="col-sm-2 control-label">排序：</label>

                                            <div class="col-sm-10 p-l-none">
                                                <ul class="to-choice-list choice-sort clearfix">
                                                    <li data-choiced={"id":"1","name":"asc"}>
                                                        <a href="javascript: void(0);"> 星级&nbsp;
                                                            <span id="start_sort_icon"><i class="fa fa-angle-down"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="map_height_refer" class="dashed-wrapper-gray padding-none m-t-md">
                                        <ul class="nav nav-tabs">

                                            <li class="active">
                                                <a href="javascript:;" aria-expanded="false">协议酒店</a>
                                            </li>

                                        </ul>
                                        <div class="form-group m-t-sm m-b-none">
                                            {{--<label class="col-sm-2 control-label">推荐：</label>--}}

                                            <div class="col-sm-12">
                                                <div class="input-group m-r-sm m-t-xs">
                                                    <input id="keyword_input" type="text" placeholder="关键字搜索" class="input input-sm form-control">
                                                    <div id="search_info" class="input input-sm form-control" style="flex-flow:row wrap;display: none;border:1px solid lightgray;height: auto;border-top: none;">
                                                        {{--<div style="display:flex;">
                                                            <a href="#">123412412414</a>
                                                            <span style="position: absolute;right: 15px;">12312</span>
                                                        </div>
                                                        <div style="display:flex;">
                                                            <a href="#">123412412414</a>
                                                            <span style="position: absolute;right: 15px;">12312</span>
                                                        </div>
                                                        <div style="display:flex;">
                                                            <a href="#">123412412414</a>
                                                            <span style="position: absolute;right: 15px;">12312</span>
                                                        </div>
                                                        <div style="display:flex;">
                                                            <a href="#">123412412414</a>
                                                            <span style="position: absolute;right: 15px;">12312</span>
                                                        </div>--}}
                                                    </div>
                                                    <!-- <div class="input-group-btn">
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        </ul>
                                                    </div> -->
                                                    <div class="input-group-btn" style="vertical-align: top;">
                                                        <button type="button" id="submit-keyword" class="btn btn-sm btn-info" > <i class="fa fa-search"></i> 搜索</button>
                                                    </div>
                                                </div>
                                                <div class="m-sm"></div>
                                                <span class="text-muted">共 <em id="commend_hotel_total" style="color: #FF4200">...</em> 条信息匹配</span>
                                                <div class="m-sm"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <ul id="hotel_commend_list" class="sortable-list agile-list ui-sortable" style="margin: 0 10px; max-height: 610px; overflow-y: auto; ">

                                                </ul>
                                            </div>
                                            <textarea id="hotel_commend_list_tmp" title="" style="display: none;">
                                                <li class="mv" la_data="{location}">
                                                    <div class="inline-box">
                                                        <div class="box-left">

                                                                <div class="image" style="overflow: hidden; width: 100%; max-height: 140px;">
                                                                    <img alt="image" class="img-responsive" src="{main_pic_url}" title="">
                                                                </div>

                                                                <div class="desc-file-content">
                                                                    <a href="/place/place_view?place_id={place_id}" target="_blank"> <h3>{place_name}</h3></a>
                                                                    <p class="star">
                                                                        {star_rate}
                                                                    </p>
                                                                    <button type="button" class="btn {choiced} btn-info btn-block hotel-purpose" data-compress={compress}>
                                                                        <i class="fa fa-heart"></i> 加入意向商家
                                                                    </button>
                                                                </div>

                                                        </div>
                                                        <div class="box-left-close">
                                                            <div class="box-detail">地址：{address}</div>
                                                            <div class="box-detail">类型：{place_type}</div>
                                                            <div class="box-detail">会议室最大面积：{area}㎡</div>
                                                            <div class="box-detail">客房数量：{roomCount}间</div>
                                                            <div class="box-detail">会议室数量：{meetingRoomCount}个</div>
                                                            <div class="box-detail">最多可纳人数：{maxCapacity}人</div>
                                                           {{-- <div class="box-detail">团队房 -- ￥ <em style="color: #FF4200;">{roomMinPrice}</em> /间起</div>
                                                            <div class="box-detail">会议厅 -- ￥ <em style="color: #FF4200;">{meetingRoomMinPrice}</em> 起</div>
--}}
                                                            <div class="box-detail"><em style="color: #FF4200;">{distance}</em></div>

                                                        </div>
                                                    </div>
                                                </li>
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <div id="hotel_commend_pagination" class="btn-group"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="area_inputs" style="display: none;">
                                        <input type="text" name="type" value="@if( isset( $data["place_type"] ) ){{$data["place_type"]}} @endif" title="" >

                                        @if( !empty( $level_1_key ) && !empty( $data["select"]["$level_1_key"] ) )
                                            @if( $level_1_key !== 'metro' )
                                                <input type="text" name="location" value="{{$level_1_key.'_id-'.$location_msg["id"]}}" title="" >
                                            @else
                                                <input type="text" name="location" value="{{$level_1_key.'-'.$pid.'-'.$location_msg["id"]}}" title="" >
                                            @endif
                                        @else
                                            <input type="text" name="location" value="" title="" >
                                        @endif
                                        <input type="text" name="star" value="@if( isset( $data["place_star"] ) ){{$data["place_star"]}} @endif" title="" >
                                        <input type="text" name="sort" value="desc" title="" >
                                        <input type="text" name="keyword" value="" title="" >
                                        <input type="text" name="lct" value="" title="" >
                                        <input type="text" name="is_window" value="" title="" >
                                        <input type="text" name="is_column" value="" title="" >
                                        <input type="text" name="layout" value="" title="" >
                                        <input type="text" name="place_people_num" value="" title="" >
                                        <input type="text" name="area" value="" title="" >
                                        <input type="text" name="price" value="" title="" >
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="dashed-wrapper padding-none m-t-md">
                                        <div id="Jmain" style="min-height: 810px;"></div>
                                        <div class="sidebar" id="real_sidebar">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="choiced_hotel_list">
            <div class="drawer-btn">
                <a href="javascript: void(0);"><i class="fa fa-angle-double-left"></i></a>
            </div>
            <div class="choiced-content">
                <div class="caption"><i class="fa fa-map-marker"></i> 选中场地</div>
                <div class="footer">
                    <button id="submit_hotel" type="button" class="btn btn-outline btn-info m-b-xs">提交场地</button>
                </div>
            </div>
            <textarea id="choiced_tamplate" style="display: none;" title="">
                <div id="{id}" class="item">
                    <div class="remove pull-right" data-target="{id}"><span>×</span></div>
                    <div class="text">
                        <div class="feed-element p-b-none" style="margin-top: 12px;">
                            <a href="javascript: void(0);" class="pull-left">
                                <img alt="image" class="img-circle" src="{img}">
                            </a>
                            <div class="media-body ">
                                <strong>{name}</strong>
                                <br>
                                <small class="text-muted">{addr}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </textarea>
        </div>

        <!-- 遮罩层 START -->
        <div class="fakeloader" data-status="init"></div>
        <!-- 遮罩层 END -->
        <textarea id="sidebar" style="display: none;">
            <div class="tips tips{i}" style="display: none;">
                <div class="map_tips">
                    <div class="map_head">
                        <div class="map_place_img">
                            <a href="http://www.eventown.com/place/view/{place_id1}" title="{place_name1}" target="_blank">
                            <img src="{img_url}" width="80" height="60">
                            </a>
                        </div>
                        <div class="map_place_title">
                                <a href="http://www.eventown.com/place/view/{place_id2}" target="_blank">{place_name2}</a>
                            <span class="star" style="color: #ffb20a;">
                                {star_rate}
                            </span>
                            <p class="map_place_add" style="font-size: 10px;">{address}</p>
                        </div>
                    </div>

                </div>
            </div>
        </textarea>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/common.js"></script>
        <script src="http://links.eventown.com.cn/vendor/seajs/seajs-3.0.0/sea.js" type="text/javascript"></script>
        <script src="/assets/js/plugins/underscore/core.min.js"></script>
        <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/js/plugins/suggest/bootstrap-suggest.min.js"></script>
        <script src="http://api.map.baidu.com/api?v=2.0&ak=xmZGI3LYte61HufZov90zHQpXbOa1yUU"></script>
        <script src="/assets/js/plugins/fakeLoader/fakeLoader.js"></script>
        <script src="/assets/js/plugins/toChoice/core.js"></script>
        <script src="/assets/js/rfp/page.main_recommend.js"></script>

        <script type="text/javascript">
            var TOKEN = '{{csrf_token()}}';
            var RFP_ID = '{{$data["rfp_id"]}}';
            var CITY_ID = '{{$data["city_id"]}}';
            var PLACE_TYPE = '{{$data["place_type"]}}';
            var PLACE_STAR = '{{$data["place_star"]}}';
            var PLACE_DATA = '{!! $placeData !!}';
            var POSITION = '{{$data["place_location"]}}';
            var RFP = '{!! $rfp !!}';

            // 过滤条件汇集
            var FILTER = {'_token':TOKEN, cityId: CITY_ID};

            var GLOBAL = {
                page_name: 'ht',
                location: '',
                from: ''
            };
            GLOBAL.place_geo_data = '<?php echo $mapJson; ?>';

            // 左右窗口大小自动调整
            setInterval( function()
            {
                $( '#Jmain' ).css( {"height":$( '#map_height_refer' ).height()} );
            }, 200 );
        </script>
    </body>
</html>
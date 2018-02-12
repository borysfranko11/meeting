<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title></title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
        <link href="/assets/css/plugins/air-datepicker/datepicker.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/toChoice/core.css" rel="stylesheet">
        <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
        <link href="/assets/css/plugins/touchsPin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/fakeLoader/fakeLoader.css" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/style.extend.css?v=4.1.0" rel="stylesheet">
        <style type="text/css">
            .ibox-content{border-top-width: 0;}
            .ibox-title{border-width: 1px;}
            .shape-style{vertical-align: top; width: 19px; height: 19px; margin-left: 4px; display: inline-block;}
            .shape-desk{background: url(/assets/img/table_style.png) no-repeat 0 0;}
            .shape-feast{background: url(/assets/img/table_style.png) no-repeat -51px 0;}
            .shape-theater{background: url(/assets/img/table_style.png) no-repeat -102px 0;}
            .shape-cocktail{background: url(/assets/img/table_style.png) no-repeat -154px 0;}
            .shape-fishbone{background: url(/assets/img/table_style.png) no-repeat -205px 0;}
            .shape-director{background: url(/assets/img/table_style.png) no-repeat -256px 0;}

            .shape-tip-tools{position: absolute; max-width: 380px; z-index: 1000; display: none;}

            @media screen and (min-width: 992px) {
                .modal-lg {
                    width: 980px;
                }
            }
        </style>
    </head>

    <body class="gray-bg">
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-8">
                <h2>{{ $base["detail"]["meeting_name"] }}</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="javascript: void(0);">主页</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">我的会议</a>
                    </li>
                    <li>
                        <strong>编辑询单</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-4">
                <div class="title-action">
                    <a href="/Rfp/index" class="btn btn-info">
                        <i class="fa fa-reply"></i> 返回
                    </a>
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="row">

                <div id="meeting_body" class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>会议需求</h5>
                            <div class="ibox-tools"></div>
                        </div>
                        <div class="ibox-content">
                            <form id="submit_form" class="form-horizontal" method="POST" action="/rfp/create_rfp" data-status="">
                                <div id="wizard">
                                    <h3>基本需求</h3>
                                    <!-- section 上不能附ID等属性, step 插件会替换, 基本需求内容通过表格生成 JS 自动完成 -->
                                    <section></section>
                                    <h3>区域需求</h3>
                                    <section>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-lg-1 control-label">类型：</label>

                                            <div class="col-sm-10 col-md-10 col-lg-11 p-l-none">
                                                <ul class="to-choice-list single-area-type clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);" @if( empty( $base["area"]["type_id"] ) ) {{'style="color: rgb(0, 182, 184);"'}} @endif> 不限</a></li>
                                                    <li data-choiced={"id":"1","name":"酒店"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 1 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 酒店</a></li>
                                                    <li data-choiced={"id":"4","name":"艺术中心/剧院"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 4 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 艺术中心/剧院</a></li>
                                                    <li data-choiced={"id":"3","name":"餐厅/会所"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 3 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 餐厅/会所</a></li>
                                                    <li data-choiced={"id":"2","name":"会议中心/展览馆/体育馆"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 2 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 会议中心/展览馆/体育馆</a></li>
                                                    <!--<li data-choiced={"id":"8","name":"度假村"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 8 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 度假村</a></li>-->
                                                    <li data-choiced={"id":"5","name":"其他"}><a href="javascript: void(0);" @if( !empty( $base["area"]["type_id"] ) && $base["area"]["type_id"] === 5 ) {!!'style="color: rgb(0, 182, 184);"'!!} @endif> 其他</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-lg-1 control-label">位置：</label>

                                            <div class="col-sm-10 col-md-10 col-lg-11 p-l-none">
                                                <ul class="to-choice-list single-area-location clearfix">
                                                    <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);"> 不限</a></li>
                                                    <li data-choiced={"id":"1","name":"行政区域","key":"AreaCity","prefix":"area_id"}><a href="javascript: void(0);"> 行政区域</a></li>
                                                    <li data-choiced={"id":"2","name":"热门商圈","key":"HotBusinessDistrict","prefix":"business_id"}><a href="javascript: void(0);"> 热门商圈</a></li>
                                                    <li data-choiced={"id":"3","name":"机场","key":"DisplayAirport","prefix":"airport_id"}><a href="javascript: void(0);"> 机场</a></li>
                                                    <li data-choiced={"id":"4","name":"火车站","key":"TrainStation","prefix":"train_station_id"}><a href="javascript: void(0);"> 火车站</a></li>
                                                    <li id="subway_choice" class="choiced-except" data-choiced={"id":"5","name":"地铁周边","key":"MetroLines","prefix":"metro"}><a href="javascript: void(0);"> 地铁周边</a></li>
                                                </ul>

                                                <ul id="location_level_1" class="to-choice-list choice-pos-rel clearfix" style="display: none;">
                                                    <li class="arrow" ><i class="fa fa-caret-right"></i></li>
                                                </ul>
                                                <ul id="location_level_2" class="to-choice-list choice-pos-rel clearfix" style="display: none;">
                                                    <li class="arrow"><i class="fa fa-caret-right"></i></li>
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
                                            <label class="col-sm-2 col-md-2 col-lg-1 control-label">星级：</label>

                                            <div class="col-sm-10 col-md-10 col-lg-11 p-l-none">
                                                <ul class="to-choice-list multi-star-level clearfix">
                                                    <li data-choiced={"id":"0","name":"不限","limit":"0"}><a href="javascript: void(0);"> 不限</a></li>
                                                    <li data-choiced={"id":"5","name":"5星"}><a href="javascript: void(0);"> 5星</a></li>
                                                    <li data-choiced={"id":"4","name":"4星"}><a href="javascript: void(0);"> 4星</a></li>
                                                    <li data-choiced={"id":"3","name":"3星"}><a href="javascript: void(0);"> 3星</a></li>
                                                    <li data-choiced={"id":"2","name":"其他"}><a href="javascript: void(0);"> 其他</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-lg-1 control-label">选中：</label>
                                            <div id="choiced_result" class="col-sm-10 col-md-10 col-lg-11">
                                                <span id="choiced_type_wrap">
                                                    @if ( isset( $base["area"]["type_id"] ) )
                                                        <button type="button" class="oper-btn m-r-xs choiced-type-wrap">类型: {{$base["area"]["type"]}} <i class="fa fa-remove i-close"></i></button>
                                                    @endif
                                                </span>
                                                <span id="choiced_location_wrap">
                                                    <button type="button" class="oper-btn m-r-xs choiced-location-wrap">位置: 未选中 </button>
                                                </span>
                                                <span id="choiced_star_wrap">
                                                    @if ( isset( $base["area"]["star_id"] ) )
                                                        <button type="button" class="oper-btn m-r-xs choiced-star-wrap">星级: {{$base["area"]["star"]}} <i class="fa fa-remove i-close"></i></button>
                                                    @endif
                                                </span>
                                                <input type="hidden" name="rfp_place_id" value="{{$base["area"]["rfp_place_id"]}}" title="" >
                                            </div>
                                        </div>
                                        <div id="area_inputs" style="display: none;">
                                            <input type="text" name="area[type]" value="{{$base["area"]["type_id"]}}" title="" >
                                            <input type="text" name="area[location]" value="" title="" >
                                            <input type="text" name="area[star]" value="{{$base["area"]["star_id"]}}" title="" >
                                        </div>
                                    </section>

                                    <h3>会议室需求</h3>
                                    <section>
                                        @if ( !empty( $base["equip"] ) )
                                            <?php $equip_base = array_shift( $base["equip"] ); ?>
                                            <div id="place_duplicate_layout" class="place-duplicate-layout">
                                                <div class="form-group">
                                                    <div class="col-sm-12 m-r m-b-md">
                                                        <a href="javascript: void(0);" id="add_place_layout" class="btn btn-white btn-xs pull-right">
                                                            <i class="fa fa-plus-square-o"></i> 新增
                                                        </a>
                                                    </div>

                                                    <label class="col-sm-2 control-label">会议时间：</label>

                                                    <div class="col-sm-10">
                                                        <div id="meeting_date" class="input-group" style="width: 100%;">
                                                            <input type="text" data-plugin="normal-time" class="input-sm form-control" name="place[{{$equip_base["equipment_id"]}}][start_time]" value="@if( !empty($equip_base['start_date']) ){{$equip_base['start_date']}}@endif" title="" />
                                                            <span class="input-group-addon">至</span>
                                                            <input type="text" data-plugin="normal-time" class="input-sm form-control meeting-time-correct" name="place[{{$equip_base["equipment_id"]}}][end_time]" value="@if( !empty($equip_base['end_date']) ){{$equip_base['end_date']}}@endif"  title="" />
                                                        </div>
                                                        <div class="m-sm"></div>
                                                        <span class="text-muted">- 开始和结束时间</span>
                                                        <div class="m-sm"></div>
                                                        @if( !empty( $equip_base['date_note'] ) )
                                                            <textarea class="form-control" style="resize: none;" name="place[{{$equip_base["equipment_id"]}}][time_desc]" title="">{{$equip_base['date_note']}}</textarea>
                                                        @else
                                                            <textarea class="form-control" style="resize: none;" name="place[{{$equip_base["equipment_id"]}}][time_desc]" title=""></textarea>
                                                        @endif
                                                        <div class="m-sm"></div>
                                                        <span class="text-muted">- 其他时间的描述：晚上17:00~20:00</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">桌型摆设：</label>

                                                    <div class="col-sm-10 table-shape">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_desk" value="1" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 1) {{"checked"}} @endif>
                                                            <label for="shape_desk"> 课桌式 </label>
                                                            <i class="shape-style shape-desk"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_feast" value="2" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 2) {{"checked"}} @endif>
                                                            <label for="shape_feast"> 中式宴会 </label>
                                                            <i class="shape-style shape-feast"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_theater" value="3" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 3) {{"checked"}} @endif>
                                                            <label for="shape_theater"> 剧院式 </label>
                                                            <i class="shape-style shape-theater"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_cocktail" value="4" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 4) {{"checked"}} @endif>
                                                            <label for="shape_cocktail"> 鸡尾酒 </label>
                                                            <i class="shape-style shape-cocktail"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_fishbone" value="5" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 5) {{"checked"}} @endif>
                                                            <label for="shape_fishbone"> 鱼骨式 </label>
                                                            <i class="shape-style shape-fishbone"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_director" value="6" name="place[{{$equip_base["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $equip_base['table_decoration_id'] == 6) {{"checked"}} @endif>
                                                            <label for="shape_director"> 董事会式 </label>
                                                            <i class="shape-style shape-director"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">可容纳人：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['meeting_people']) ){{$equip_base['meeting_people']}}@endif" name="place[{{$equip_base["equipment_id"]}}][amount]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">场地预算：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['budget_account']) ){{$equip_base['budget_account']}}@endif" name="place[{{$equip_base["equipment_id"]}}][budget_account]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">常用设施：</label>

                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 投影仪</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key95']) && !empty($equip_base['v_key95']) ){{$equip_base['v_key95']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][95]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 有线麦克</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key96']) && !empty($equip_base['v_key96']) ){{$equip_base['v_key96']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][96]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 无线麦克</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key97']) && !empty($equip_base['v_key97']) ){{$equip_base['v_key97']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][97]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 黑板白板</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key98']) && !empty($equip_base['v_key98']) ){{$equip_base['v_key98']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][98]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 音箱</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key99']) && !empty($equip_base['v_key99']) ){{$equip_base['v_key99']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][99]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 讲台</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key100']) && !empty($equip_base['v_key100']) ){{$equip_base['v_key100']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][100]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 引导牌</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key101']) && !empty($equip_base['v_key101']) ){{$equip_base['v_key101']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][101]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 桌卡</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key102']) && !empty($equip_base['v_key102']) ){{$equip_base['v_key102']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][102]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 签到台</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key103']) && !empty($equip_base['v_key103']) ){{$equip_base['v_key103']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][103]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 多方电话系统</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( isset($equip_base['v_key104']) && !empty($equip_base['v_key104']) ){{$equip_base['v_key104']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][104]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">其它设施：</label>

                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 横幅</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['key1']) ){{$equip_base['key1']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][1]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 茶水</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['key5']) ){{$equip_base['key5']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][5]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 矿泉水</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['key10']) ){{$equip_base['key10']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][10]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- LED</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['key12']) ){{$equip_base['key12']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][12]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">设施预算：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($equip_base['budget_account']) ){{$equip_base['budget_account']}}@endif" name="equip[{{$equip_base["equipment_id"]}}][budget_account]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">描述：</label>

                                                    <div class="col-sm-10">
                                                        @if( !empty( $equip_base['equipment_description'] ) )
                                                            <textarea class="form-control" style="resize: none;" name="equip[{{$equip_base["equipment_id"]}}][desc]" title="">{{$equip_base['equipment_description']}}</textarea>
                                                        @else
                                                            <textarea class="form-control" style="resize: none;" name="equip[{{$equip_base["equipment_id"]}}][desc]" title=""></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="equip[{{$equip_base["equipment_id"]}}][equipment_id]" value="{{$equip_base["equipment_id"]}}" title="" >
                                            </div>

                                            @if( !empty( $base["equip"] ) )
                                                @foreach( $base["equip"] as $key => $detail )
                                                    <div id="place_duplicate_layout_{{$detail["equipment_id"]}}" class="place-duplicate-layout">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 m-r m-b-md">
                                                                <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-place-layout" data-id="#place_duplicate_layout_{{$detail["equipment_id"]}}" data-count="{{$detail["equipment_id"]}}">
                                                                    <i class="fa fa-minus-square-o"></i> 删除
                                                                </a>
                                                            </div>

                                                            <label class="col-sm-2 control-label">会议时间：</label>

                                                            <div class="col-sm-10">
                                                                <div class="input-group" style="width: 100%;">
                                                                    <input type="text" data-plugin="normal-time" class="input-sm form-control" name="place[{{$detail["equipment_id"]}}][start_time]" value="@if( !empty($detail['start_date']) ){{$detail['start_date']}}@endif" title="" />
                                                                    <span class="input-group-addon">至</span>
                                                                    <input type="text" data-plugin="normal-time" class="input-sm form-control meeting-time-correct" name="place[{{$detail["equipment_id"]}}][end_time]" value="@if( !empty($detail['end_date']) ){{$detail['end_date']}}@endif"  title="" />
                                                                </div>
                                                                <div class="m-sm"></div>
                                                                <span class="text-muted">- 开始和结束时间</span>
                                                                <div class="m-sm"></div>
                                                                @if( !empty( $detail['date_note'] ) )
                                                                    <textarea class="form-control" style="resize: none;" name="place[{{$detail["equipment_id"]}}][time_desc]" title="">{{$detail['date_note']}}</textarea>
                                                                @else
                                                                    <textarea class="form-control" style="resize: none;" name="place[{{$detail["equipment_id"]}}][time_desc]" title=""></textarea>
                                                                @endif
                                                                <div class="m-sm"></div>
                                                                <span class="text-muted">- 其他时间的描述：晚上17:00~20:00</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">桌型摆设：</label>

                                                            <div class="col-sm-10 table-shape">
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_desk" value="1" name="place[{{$detail["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 1) {{"checked"}} @endif>
                                                                    <label for="shape_desk"> 课桌式 </label>
                                                                    <i class="shape-style shape-desk"></i>
                                                                </div>
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_feast" value="2" name="place[{{$detail["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 2) {{"checked"}} @endif>
                                                                    <label for="shape_feast"> 中式宴会 </label>
                                                                    <i class="shape-style shape-feast"></i>
                                                                </div>
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_theater" value="3" name="place[{{$detail["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 3) {{"checked"}} @endif>
                                                                    <label for="shape_theater"> 剧院式 </label>
                                                                    <i class="shape-style shape-theater"></i>
                                                                </div>
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_cocktail" value="4" name="place[{{$detail["equipment_id"]}}][shape]" @if ( isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 4) {{"checked"}} @endif>
                                                                    <label for="shape_cocktail"> 鸡尾酒 </label>
                                                                    <i class="shape-style shape-cocktail"></i>
                                                                </div>
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_fishbone" value="5" name="place[{{$detail["equipment_id"]}}][shape]" @if ( isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 5) {{"checked"}} @endif>
                                                                    <label for="shape_fishbone"> 鱼骨式 </label>
                                                                    <i class="shape-style shape-fishbone"></i>
                                                                </div>
                                                                <div class="radio radio-info radio-inline">
                                                                    <input type="radio" id="shape_director" value="6" name="place[{{$detail["equipment_id"]}}][shape]" @if (isset($equip_base['table_decoration_id']) && $detail['table_decoration_id'] == 6) {{"checked"}} @endif>
                                                                    <label for="shape_director"> 董事会式 </label>
                                                                    <i class="shape-style shape-director"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">场地预算：</label>

                                                            <div class="col-sm-10">
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['budget_account']) ){{$detail['budget_account']}}@endif" name="place[{{$detail["equipment_id"]}}][budget_account]" title="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">可容纳人：</label>

                                                            <div class="col-sm-10">
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['meeting_people']) ){{$detail['meeting_people']}}@endif" name="place[{{$detail["equipment_id"]}}][amount]" title="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">常用设施：</label>

                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 投影仪</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key95']) ){{$detail['key95']}}@endif" name="equip[{{$detail["equipment_id"]}}][95]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 有线麦克</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key96']) ){{$detail['key96']}}@endif" name="equip[{{$detail["equipment_id"]}}][96]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 无线麦克</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key97']) ){{$detail['key97']}}@endif" name="equip[{{$detail["equipment_id"]}}][97]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 黑板白板</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key98']) ){{$detail['key98']}}@endif" name="equip[{{$detail["equipment_id"]}}][98]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 音箱</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key99']) ){{$detail['key99']}}@endif" name="equip[{{$detail["equipment_id"]}}][99]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 讲台</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key100']) ){{$detail['key100']}}@endif" name="equip[{{$detail["equipment_id"]}}][100]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 引导牌</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key101']) ){{$detail['key101']}}@endif" name="equip[{{$detail["equipment_id"]}}][101]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 桌卡</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key102']) ){{$detail['key102']}}@endif" name="equip[{{$detail["equipment_id"]}}][102]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 签到台</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key103']) ){{$detail['key103']}}@endif" name="equip[{{$detail["equipment_id"]}}][103]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 多方电话系统</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key104']) ){{$detail['key104']}}@endif" name="equip[{{$detail["equipment_id"]}}][104]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">其它设施：</label>

                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 横幅</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key1']) ){{$detail['key1']}}@endif" name="equip[{{$detail["equipment_id"]}}][1]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 茶水</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key5']) ){{$detail['key5']}}@endif" name="equip[{{$detail["equipment_id"]}}][5]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- 矿泉水</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key10']) ){{$detail['key10']}}@endif" name="equip[{{$detail["equipment_id"]}}][10]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <span class="text-muted">- LED</span>
                                                                        <div class="m-sm"></div>
                                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['key12']) ){{$detail['key12']}}@endif" name="equip[{{$detail["equipment_id"]}}][12]" title="">
                                                                        <div class="m-sm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">设施预算：</label>

                                                            <div class="col-sm-10">
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($detail['budget_account']) ){{$detail['budget_account']}}@endif" name="equip[{{$detail["equipment_id"]}}][budget_account]" title="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">描述：</label>

                                                            <div class="col-sm-10">
                                                                @if( !empty( $detail['equipment_description'] ) )
                                                                    <textarea class="form-control" style="resize: none;" name="equip[{{$detail["equipment_id"]}}][desc]" title="">{{$detail['equipment_description']}}</textarea>
                                                                @else
                                                                    <textarea class="form-control" style="resize: none;" name="equip[{{$detail["equipment_id"]}}][desc]" title=""></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="equip[{{$detail["equipment_id"]}}][equipment_id]" value="{{$detail["equipment_id"]}}" title="">
                                                    </div>
                                                @endforeach
                                            @endif
                                            @else
                                            <div id="place_duplicate_layout" class="place-duplicate-layout">
                                                <div class="form-group">
                                                    <div class="col-sm-12 m-r m-b-md">
                                                        <a href="javascript: void(0);" id="add_place_layout" class="btn btn-white btn-xs pull-right">
                                                            <i class="fa fa-plus-square-o"></i> 新增
                                                        </a>
                                                    </div>

                                                    <label class="col-sm-2 control-label">会议时间：</label>

                                                    <div class="col-sm-10">
                                                        <div id="meeting_date" class="input-group" style="width: 100%;">
                                                            <input type="text" data-plugin="normal-time" class="input-sm form-control" name="place[101][start_time]" value="" title="" />
                                                            <span class="input-group-addon">至</span>
                                                            <input type="text" data-plugin="normal-time" class="input-sm form-control meeting-time-correct" name="place[101][end_time]" value=""  title="" />
                                                        </div>
                                                        <div class="m-sm"></div>
                                                        <span class="text-muted">- 开始和结束时间</span>
                                                        <div class="m-sm"></div>
                                                        <textarea class="form-control" style="resize: none;" name="place[101][time_desc]" title=""></textarea>
                                                        <div class="m-sm"></div>
                                                        <span class="text-muted">- 其他时间的描述：晚上17:00~20:00</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">桌型摆设：</label>

                                                    <div class="col-sm-10 table-shape">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_desk" value="1" name="place[101][shape]" />
                                                            <label for="shape_desk"> 课桌式 </label>
                                                            <i class="shape-style shape-desk"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_feast" value="2" name="place[101][shape]" />
                                                            <label for="shape_feast"> 中式宴会 </label>
                                                            <i class="shape-style shape-feast"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_theater" value="3" name="place[101][shape]" />
                                                            <label for="shape_theater"> 剧院式 </label>
                                                            <i class="shape-style shape-theater"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_cocktail" value="4" name="place[101][shape]" />
                                                            <label for="shape_cocktail"> 鸡尾酒 </label>
                                                            <i class="shape-style shape-cocktail"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_fishbone" value="5" name="place[101][shape]" />
                                                            <label for="shape_fishbone"> 鱼骨式 </label>
                                                            <i class="shape-style shape-fishbone"></i>
                                                        </div>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="shape_director" value="6" name="place[101][shape]" />
                                                            <label for="shape_director"> 董事会式 </label>
                                                            <i class="shape-style shape-director"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">可容纳人：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="place[101][amount]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">场地预算：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="place[101][budget_account]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">常用设施：</label>

                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 投影仪</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][95]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 有线麦克</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][96]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 无线麦克</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][97]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 黑板白板</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][98]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 音箱</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][99]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 讲台</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][100]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 引导牌</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][101]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 桌卡</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][102]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 签到台</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][103]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 多方电话系统</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][104]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">其它设施：</label>

                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 横幅</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][1]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 茶水</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][5]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- 矿泉水</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][10]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <span class="text-muted">- LED</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][12]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">设施预算：</label>

                                                    <div class="col-sm-10">
                                                        <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[101][budget_account]" title="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">描述：</label>

                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" style="resize: none;" name="equip[101][desc]" title=""></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="equip[101][equipment_id]" value="" title="" >
                                            </div>
                                        @endif
                                            <div id="place_duplicate_tamplate" style="display: none;" title="">
                                                <div id="place_duplicate_layout_{key}" class="place-duplicate-layout">
                                                    <div class="form-group">
                                                        <div class="col-sm-12 m-r m-b-md">
                                                            <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-place-layout" data-id="#place_duplicate_layout_{key}" data-count="{key}">
                                                                <i class="fa fa-minus-square-o"></i> 删除
                                                            </a>
                                                        </div>

                                                        <label class="col-sm-2 control-label">会议时间：</label>

                                                        <div class="col-sm-10">
                                                            <div class="input-group" style="width: 100%;">
                                                                <input type="text" data-plugin="normal-time" class="input-sm form-control" name="place[{key}][start_time]" value="" title="" />
                                                                <span class="input-group-addon">至</span>
                                                                <input type="text" data-plugin="normal-time" class="input-sm form-control meeting-time-correct" name="place[{key}][end_time]" value=""  title="" />
                                                            </div>
                                                            <div class="m-sm"></div>
                                                            <span class="text-muted">- 开始和结束时间</span>
                                                            <div class="m-sm"></div>
                                                            <textarea class="form-control" style="resize: none;" name="place[{key}][time_desc]" title=""></textarea>
                                                            <div class="m-sm"></div>
                                                            <span class="text-muted">- 其他时间的描述：晚上17:00~20:00</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">桌型摆设：</label>

                                                        <div class="col-sm-10 table-shape">
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_desk" value="1" name="place[{key}][shape]" checked="">
                                                                <label for="shape_desk"> 课桌式 </label>
                                                                <i class="shape-style shape-desk"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_feast" value="2" name="place[{key}][shape]">
                                                                <label for="shape_feast"> 中式宴会 </label>
                                                                <i class="shape-style shape-feast"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_theater" value="3" name="place[{key}][shape]">
                                                                <label for="shape_theater"> 剧院式 </label>
                                                                <i class="shape-style shape-theater"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_cocktail" value="4" name="place[{key}][shape]">
                                                                <label for="shape_cocktail"> 鸡尾酒 </label>
                                                                <i class="shape-style shape-cocktail"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_fishbone" value="5" name="place[{key}][shape]">
                                                                <label for="shape_fishbone"> 鱼骨式 </label>
                                                                <i class="shape-style shape-fishbone"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_director" value="6" name="place[{key}][shape]">
                                                                <label for="shape_director"> 董事会式 </label>
                                                                <i class="shape-style shape-director"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">场地预算：</label>

                                                        <div class="col-sm-10">
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="place[{key}][budget_account]" title="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">可容纳人：</label>

                                                        <div class="col-sm-10">
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="20" name="place[{key}][amount]" title="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">常用设施：</label>

                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 投影仪</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][95]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 有线麦克</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][96]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 无线麦克</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][97]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 黑板白板</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][98]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 音箱</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][99]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 讲台</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][100]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 引导牌</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][101]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 桌卡</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][102]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 签到台</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][103]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 多方电话系统</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][104]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">其它设施：</label>

                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 横幅</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][1]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 茶水</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][5]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- 矿泉水</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][10]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <span class="text-muted">- LED</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][12]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">设施预算：</label>

                                                        <div class="col-sm-10">
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="equip[{key}][budget_account]" title="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">描述：</label>

                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" style="resize: none;" name="equip[{key}][desc]" title=""></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </section>

                                    <h3>餐饮需求</h3>
                                    <section>
                                        @if ( !empty( $base["food"] ) )
                                            <?php $food_base = array_shift( $base["food"] ); ?>
                                            <div id="food_duplicate_layout" class="form-group food-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" id="add_food_layout" class="btn btn-white btn-xs pull-right">
                                                        <i class="fa fa-plus-square-o"></i> 新增
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">餐饮：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 餐种</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[{{$food_base['food_id']}}][type]" title="">
                                                                <option value="" @if( empty($food_base['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                <option value="1" @if( !empty($food_base['type_id']) && $food_base['type_id'] == 1) {{"selected"}} @endif>午餐</option>
                                                                <option value="2" @if( !empty($food_base['type_id']) && $food_base['type_id'] == 2) {{"selected"}} @endif>茶歇</option>
                                                                <option value="3" @if( !empty($food_base['type_id']) && $food_base['type_id'] == 3) {{"selected"}} @endif>晚餐</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 形式</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[{{$food_base['food_id']}}][style]" title="">
                                                                <option value="" @if( empty($food_base['style_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                <option value="1" @if( !empty($food_base['style_id']) && $food_base['style_id'] == 1) {{"selected"}} @endif>自助</option>
                                                                <option value="2" @if( !empty($food_base['style_id']) && $food_base['style_id'] == 2) {{"selected"}} @endif>中餐</option>
                                                                <option value="3" @if( !empty($food_base['style_id']) && $food_base['style_id'] == 3) {{"selected"}} @endif>西餐</option>
                                                                <option value="4" @if( !empty($food_base['style_id']) && $food_base['style_id'] == 4) {{"selected"}} @endif>鸡尾酒</option>
                                                                <option value="5" @if( !empty($food_base['style_id']) && $food_base['style_id'] == 5) {{"selected"}} @endif>其它</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐人数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"amount","partner":"price","target":"budget"} type="text" value="@if( !empty($food_base['amount']) ){{$food_base['amount']}}@endif" name="food[{{$food_base['food_id']}}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 人均单价</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"price","partner":"amount","target":"budget"} type="text" value="@if( !empty($food_base['price']) ){{$food_base['price']}}@endif" name="food[{{$food_base['food_id']}}][price]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="normal-time" type="text" value="@if( !empty($food_base['time']) ){{$food_base['time']}}@endif" name="food[{{$food_base['food_id']}}][time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($food_base['budget']) ){{$food_base['budget']}}@endif" name="food[{{$food_base['food_id']}}][budget]" title="" readonly>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 是否提供参考菜单</span>
                                                            <div class="m-sm"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="support_menu_101" value="1" @if( !empty($food_base['menu']) ) {{"checked"}} @endif name="food[{{$food_base['food_id']}}][menu]">
                                                                <label for="support_menu_101"> 菜单(以实际与酒店沟通情况为准) </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <input type="hidden" value="@if( !empty($food_base['food_id']) ){{$food_base['food_id']}}@endif" name="food[{{$food_base['food_id']}}][food_id]" title="">
                                                    </div>
                                                </div>
                                            </div>
                                            @if( !empty( $base["food"] ) )
                                                @foreach( $base["food"] as $key => $f_detail )
                                                    <div id="food_duplicate_layout_{{$f_detail['food_id']}}" class="form-group food-duplicate-layout">
                                                        <div class="col-sm-12 m-r m-b-md">
                                                            <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-wine-layout" data-id="#food_duplicate_layout_{{$f_detail['food_id']}}" data-count="{{$f_detail['food_id']}}">
                                                                <i class="fa fa-minus-square-o"></i> 删除
                                                            </a>
                                                        </div>

                                                        <label class="col-sm-2 control-label">餐饮：</label>

                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 餐种</span>
                                                                    <div class="m-sm"></div>
                                                                    <select class="form-control" name="food[{{$f_detail['food_id']}}][type]" title="">
                                                                        <option value="" @if( empty($f_detail['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                        <option value="1" @if( !empty($f_detail['type_id']) && $f_detail['type_id'] == 1) {{"selected"}} @endif>午餐</option>
                                                                        <option value="2" @if( !empty($f_detail['type_id']) && $f_detail['type_id'] == 2) {{"selected"}} @endif>茶歇</option>
                                                                        <option value="3" @if( !empty($f_detail['type_id']) && $f_detail['type_id'] == 3) {{"selected"}} @endif>晚餐</option>
                                                                    </select>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 形式</span>
                                                                    <div class="m-sm"></div>
                                                                    <select class="form-control" name="food[{{$f_detail['food_id']}}][style]" title="">
                                                                        <option value="" @if( empty($f_detail['style_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                        <option value="1" @if( !empty($f_detail['style_id']) && $f_detail['style_id'] == 1) {{"selected"}} @endif>自助</option>
                                                                        <option value="2" @if( !empty($f_detail['style_id']) && $f_detail['style_id'] == 2) {{"selected"}} @endif>中餐</option>
                                                                        <option value="3" @if( !empty($f_detail['style_id']) && $f_detail['style_id'] == 3) {{"selected"}} @endif>西餐</option>
                                                                        <option value="4" @if( !empty($f_detail['style_id']) && $f_detail['style_id'] == 4) {{"selected"}} @endif>鸡尾酒</option>
                                                                        <option value="5" @if( !empty($f_detail['style_id']) && $f_detail['style_id'] == 5) {{"selected"}} @endif>其它</option>
                                                                    </select>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 用餐人数</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"amount","partner":"price","target":"budget"} type="text" value="@if( !empty($f_detail['amount']) ){{$f_detail['amount']}}@endif" name="food[{{$f_detail['food_id']}}][amount]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 人均单价</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"price","partner":"amount","target":"budget"} type="text" value="@if( !empty($f_detail['price']) ){{$f_detail['price']}}@endif" name="food[{{$f_detail['food_id']}}][price]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 用餐时间</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="normal-time" type="text" value="@if( !empty($f_detail['time']) ){{$f_detail['time']}}@endif" name="food[{{$f_detail['food_id']}}][time]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 用餐预算</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($f_detail['budget']) ){{$f_detail['budget']}}@endif" name="food[{{$f_detail['food_id']}}][budget]" title="" readonly>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 是否提供参考菜单</span>
                                                                    <div class="m-sm"></div>
                                                                    <div class="checkbox checkbox-success checkbox-inline">
                                                                        <input type="checkbox" id="support_menu_{{$f_detail['food_id']}}" value="1" @if( !empty($f_detail['menu']) ){{"checked"}}@endif name="food[{{$f_detail['food_id']}}][menu]">
                                                                        <label for="support_menu_{{$f_detail['food_id']}}"> 菜单(以实际与酒店沟通情况为准) </label>
                                                                    </div>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <input type="hidden" value="@if( !empty($f_detail['food_id']) ){{$f_detail['food_id']}}@endif" name="food[{{$f_detail['food_id']}}][food_id]" title="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <div id="food_duplicate_layout" class="form-group food-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" id="add_food_layout" class="btn btn-white btn-xs pull-right">
                                                        <i class="fa fa-plus-square-o"></i> 新增
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">餐饮：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 餐种</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[101][type]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">午餐</option>
                                                                <option value="2">茶歇</option>
                                                                <option value="3">晚餐</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 形式</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[101][style]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">自助</option>
                                                                <option value="2">中餐</option>
                                                                <option value="3">西餐</option>
                                                                <option value="4">鸡尾酒</option>
                                                                <option value="5">其它</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐人数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"amount","partner":"price","target":"budget"} type="text" value="" name="food[101][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 人均单价</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"price","partner":"amount","target":"budget"} type="text" value="" name="food[101][price]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="normal-time" type="text" value="" name="food[101][time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="food[101][budget]" title="" readonly>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 是否提供参考菜单</span>
                                                            <div class="m-sm"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="support_menu_101" value="1" name="food[101][menu]">
                                                                <label for="support_menu_101"> 菜单(以实际与酒店沟通情况为准) </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="food_duplicate_tamplate" style="display: none;" title="">
                                            <div id="food_duplicate_layout_{key}" class="form-group food-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-wine-layout" data-id="#food_duplicate_layout_{key}" data-count="{key}">
                                                        <i class="fa fa-minus-square-o"></i> 删除
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">餐饮：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 餐种</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[{key}][type]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">午餐</option>
                                                                <option value="2">茶歇</option>
                                                                <option value="3">晚餐</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 形式</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="food[{key}][style]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">自助</option>
                                                                <option value="2">中餐</option>
                                                                <option value="3">西餐</option>
                                                                <option value="4">鸡尾酒</option>
                                                                <option value="5">其它</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐人数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"amount","partner":"price","target":"budget"} type="text" value="" name="food[{key}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 人均单价</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" data-action={"method":"add","self":"price","partner":"amount","target":"budget"} type="text" value="" name="food[{key}][price]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="normal-time" type="text" value="" name="food[{key}][time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="food[{key}][budget]" title="" readonly >
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 是否提供参考菜单</span>
                                                            <div class="m-sm"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="support_menu_{key}" value="1" name="food[{key}][menu]">
                                                                <label for="support_menu_{key}"> 菜单(以实际与酒店沟通情况为准) </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ( !empty( $base["wine"] ) )
                                            <?php $wine_base = array_shift( $base["wine"] ); ?>
                                            <div id="wine_duplicate_layout" class="form-group wine-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" id="add_wine_layout" class="btn btn-white btn-xs pull-right">
                                                        <i class="fa fa-plus-square-o"></i> 新增
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">酒水：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 餐种</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="wine[{{$wine_base['food_id']}}][type]" title="">
                                                                <option value="" @if( empty($wine_base['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                <option value="1" @if( !empty($wine_base['type_id']) && $wine_base['type_id'] == 1) {{"selected"}} @endif>午餐</option>
                                                                <option value="2" @if( !empty($wine_base['type_id']) && $wine_base['type_id'] == 2) {{"selected"}} @endif>茶歇</option>
                                                                <option value="3" @if( !empty($wine_base['type_id']) && $wine_base['type_id'] == 3) {{"selected"}} @endif>晚餐</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="normal-time" type="text" value="@if( !empty($wine_base['time']) ){{$wine_base['time']}}@endif" name="wine[{{$wine_base['food_id']}}][time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 酒水种类</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="wine[{{$wine_base['food_id']}}][style]" title="">
                                                                <option value="" @if( empty($wine_base['style_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                <option value="6" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 6) {{"selected"}} @endif>白酒</option>
                                                                <option value="7" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 7) {{"selected"}} @endif>啤酒</option>
                                                                <option value="8" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 8) {{"selected"}} @endif>葡萄酒</option>
                                                                <option value="9" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 9) {{"selected"}} @endif>饮料</option>
                                                                <option value="10" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 10) {{"selected"}} @endif>洋酒</option>
                                                                <option value="11" @if( !empty($wine_base['style_id']) && $wine_base['style_id'] == 11) {{"selected"}} @endif>其它</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 数量</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($wine_base['amount']) ){{$wine_base['amount']}}@endif" name="wine[{{$wine_base['food_id']}}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 酒水预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($wine_base['budget']) ){{$wine_base['budget']}}@endif" name="wine[{{$wine_base['food_id']}}][budget_account]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <input type="hidden" value="@if( !empty($wine_base['food_id']) ){{$wine_base['food_id']}}@endif" name="wine[{{$wine_base['food_id']}}][food_id]" title="">
                                                    </div>
                                                </div>
                                            </div>
                                            @if( !empty( $base["wine"] ) )
                                                @foreach( $base["food"] as $key => $w_detail )
                                                    <div id="wine_duplicate_layout_{{$w_detail["food_id"]}}" class="form-group wine-duplicate-layout">
                                                        <div class="col-sm-12 m-r m-b-md">
                                                            <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-wine-layout" data-id="#wine_duplicate_layout_{{$w_detail["food_id"]}}" data-count="{{$w_detail["food_id"]}}">
                                                                <i class="fa fa-minus-square-o"></i> 删除
                                                            </a>
                                                        </div>

                                                        <label class="col-sm-2 control-label">酒水：</label>

                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 餐种</span>
                                                                    <div class="m-sm"></div>
                                                                    <select class="form-control" name="wine[{{$w_detail["food_id"]}}][type]" title="">
                                                                        <option value="" @if( empty($w_detail['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                        <option value="1" @if( !empty($w_detail['type_id']) && $w_detail['type_id'] == 1) {{"selected"}} @endif>午餐</option>
                                                                        <option value="2" @if( !empty($w_detail['type_id']) && $w_detail['type_id'] == 2) {{"selected"}} @endif>茶歇</option>
                                                                        <option value="3" @if( !empty($w_detail['type_id']) && $w_detail['type_id'] == 3) {{"selected"}} @endif>晚餐</option>
                                                                    </select>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 用餐时间</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="normal-time" type="text" value="@if( !empty($w_detail['time']) ){{$w_detail['time']}}@endif" name="wine[{{$w_detail["food_id"]}}][time]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 酒水种类</span>
                                                                    <div class="m-sm"></div>
                                                                    <select class="form-control" name="wine[{{$w_detail["food_id"]}}][style]" title="">
                                                                        <option value="" @if( empty($w_detail['style_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                        <option value="6" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 6) {{"selected"}} @endif>白酒</option>
                                                                        <option value="7" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 7) {{"selected"}} @endif>啤酒</option>
                                                                        <option value="8" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 8) {{"selected"}} @endif>葡萄酒</option>
                                                                        <option value="9" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 9) {{"selected"}} @endif>饮料</option>
                                                                        <option value="10" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 10) {{"selected"}} @endif>洋酒</option>
                                                                        <option value="11" @if( !empty($w_detail['style_id']) && $w_detail['style_id'] == 11) {{"selected"}} @endif>其它</option>
                                                                    </select>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 数量</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($w_detail['amount']) ){{$w_detail['amount']}}@endif" name="wine[{{$w_detail["food_id"]}}][amount]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 酒水预算</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty($w_detail['budget_account']) ){{$w_detail['budget_account']}}@endif" name="wine[{{$w_detail["food_id"]}}][budget_account]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <input type="hidden" value="@if( !empty($w_detail['food_id']) ){{$w_detail['food_id']}}@endif" name="wine[{{$w_detail['food_id']}}][food_id]" title="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <div id="wine_duplicate_layout" class="form-group wine-duplicate-layout">
                                                    <div class="col-sm-12 m-r m-b-md">
                                                        <a href="javascript: void(0);" id="add_wine_layout" class="btn btn-white btn-xs pull-right">
                                                            <i class="fa fa-plus-square-o"></i> 新增
                                                        </a>
                                                    </div>

                                                    <label class="col-sm-2 control-label">酒水：</label>

                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <span class="text-muted">- 餐种</span>
                                                                <div class="m-sm"></div>
                                                                <select class="form-control" name="wine[101][type]" title="">
                                                                    <option value="" selected>-- 请选择</option>
                                                                    <option value="1">午餐</option>
                                                                    <option value="2">茶歇</option>
                                                                    <option value="3">晚餐</option>
                                                                </select>
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-muted">- 用餐时间</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="start-time" type="text" value="" name="wine[101][time]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-muted">- 酒水种类</span>
                                                                <div class="m-sm"></div>
                                                                <select class="form-control" name="wine[101][style]" title="">
                                                                    <option value="" selected>-- 请选择</option>
                                                                    <option value="6">白酒</option>
                                                                    <option value="7">啤酒</option>
                                                                    <option value="8">葡萄酒</option>
                                                                    <option value="9">饮料</option>
                                                                    <option value="10">洋酒</option>
                                                                    <option value="11">其它</option>
                                                                </select>
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-muted">- 数量</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="wine[101][amount]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-muted">- 酒水预算</span>
                                                                <div class="m-sm"></div>
                                                                <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="wine[101][budget_account]" title="">
                                                                <div class="m-sm"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                        <div id="wine_duplicate_tamplate" style="display: none;" title="">
                                            <div id="wine_duplicate_layout_{key}" class="form-group wine-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-wine-layout" data-id="#wine_duplicate_layout_{key}" data-count="{key}">
                                                        <i class="fa fa-minus-square-o"></i> 删除
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">酒水：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 餐种</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="wine[{key}][type]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">午餐</option>
                                                                <option value="2">茶歇</option>
                                                                <option value="3">晚餐</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 用餐时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="normal-time" type="text" value="" name="wine[{key}][time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 酒水种类</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="wine[{key}][style]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="6">白酒</option>
                                                                <option value="7">啤酒</option>
                                                                <option value="8">葡萄酒</option>
                                                                <option value="9">饮料</option>
                                                                <option value="10">洋酒</option>
                                                                <option value="11">其它</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 数量</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="wine[{key}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 酒水预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="wine[{key}][budget_account]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-sm"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">描述：</label>

                                            <div class="col-sm-10">
                                                @if( !empty( $food_base["desc"] ) )
                                                    <textarea class="form-control" style="resize: none;" name="food[desc]" title="">{{$food_base["desc"]}}</textarea>
                                                @else
                                                    <textarea class="form-control" style="resize: none;" name="food[desc]" title=""></textarea>
                                                @endif
                                            </div>
                                        </div>
                                    </section>
                                    <h3>住宿需求</h3>
                                    <section>
                                        @if( !empty( $base["room"] ) )
                                            <?php $room_base = array_shift( $base["room"] ); ?>
                                            <div id="room_duplicate_layout" class="form-group room-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" id="add_room_layout" class="btn btn-white btn-xs pull-right">
                                                        <i class="fa fa-plus-square-o"></i> 新增
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">住宿：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 入住时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="start-time" type="text" value="<?php echo $room_base["room_in_start_date"];?>" name="room[{{$room_base['room_id']}}][start_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 退房时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="end-time" type="text" value="<?php echo $room_base["room_out_end_date"];?>" name="room[{{$room_base['room_id']}}][end_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 天数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="check-in-days" type="text" value="@if( !empty( $room_base['day'] ) ) {{$room_base["day"]}} @endif" name="room[{{$room_base['room_id']}}][day]" title="" readonly >
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 房间类型</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="room[{{$room_base['room_id']}}][type]" title="">
                                                                <option value="" @if( empty($room_base['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                <option value="1" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 1) {{"selected"}} @endif>普通大床房</option>
                                                                <option value="2" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 2) {{"selected"}} @endif>普通双床房</option>
                                                                <option value="7" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 7) {{"selected"}} @endif>行政单间</option>
                                                                <option value="8" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 8) {{"selected"}} @endif>行政双床</option>
                                                                <option value="5" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 5) {{"selected"}} @endif>套房</option>
                                                                <option value="3" @if( !empty($room_base['type_id']) && $room_base['type_id'] == 3) {{"selected"}} @endif>特殊客房</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 数量</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty( $room_base['room_count'] ) ) {{$room_base["room_count"]}} @endif" name="room[{{$room_base['room_id']}}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 住宿预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty( $room_base['budget_account'] ) ) {{$room_base["budget_account"]}} @endif" name="room[{{$room_base['room_id']}}][budget_account]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="m-lg"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="have_breakfast_{{$room_base['room_id']}}" value="1" name="room[{{$room_base['room_id']}}][breakfast]" @if( !empty($room_base['breakfast']) ) {{"checked"}} @endif>
                                                                <label for="have_breakfast_{{$room_base['room_id']}}"> 是否包含早餐 </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <input type="hidden" value="@if( !empty($room_base['room_id']) ) {{$room_base['room_id']}} @endif" name="room[{{$room_base['room_id']}}][room_id]" title="">
                                                    </div>
                                                </div>
                                            </div>
                                            @if( !empty( $base["room"] ) )
                                                @foreach( $base["room"] as $key => $r_detail )
                                                    <div id="room_duplicate_layout_{{$r_detail["room_id"]}}" class="form-group room-duplicate-layout">
                                                        <div class="col-sm-12 m-r m-b-md">
                                                            <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-room-layout" data-id="#room_duplicate_layout_{{$r_detail["room_id"]}}" data-count="{{$r_detail["room_id"]}}">
                                                                <i class="fa fa-minus-square-o"></i> 删除
                                                            </a>
                                                        </div>

                                                        <label class="col-sm-2 control-label">住宿：</label>

                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 入住时间</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="start-time" type="text" value="@if( !empty( $r_detail['room_in_start_date'] ) ) {{$r_detail["room_in_start_date"]}} @endif" name="room[{{$r_detail["room_id"]}}][start_time]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 退房时间</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="end-time" type="text" value="@if( !empty( $r_detail['room_out_end_date'] ) ) {{$r_detail["room_out_end_date"]}} @endif" name="room[{{$r_detail["room_id"]}}][end_time]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 天数</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="check-in-days" type="text" value="@if( !empty( $r_detail['day'] ) ) {{$r_detail["day"]}} @endif" name="room[{{$r_detail["room_id"]}}][day]" title="" readonly >
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 房间类型</span>
                                                                    <div class="m-sm"></div>
                                                                    <select class="form-control" name="room[{{$r_detail["room_id"]}}][type]" title="">
                                                                        <option value="" @if( empty($r_detail['type_id']) ) {{"selected"}} @endif>-- 请选择</option>
                                                                        <option value="1" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 1) {{"selected"}} @endif>普通大床房</option>
                                                                        <option value="2" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 2) {{"selected"}} @endif>普通双床房</option>
                                                                        <option value="7" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 7) {{"selected"}} @endif>行政单间</option>
                                                                        <option value="8" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 8) {{"selected"}} @endif>行政双床</option>
                                                                        <option value="5" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 5) {{"selected"}} @endif>套房</option>
                                                                        <option value="3" @if( !empty($r_detail['type_id']) && $r_detail['type_id'] == 3) {{"selected"}} @endif>特殊客房</option>
                                                                    </select>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 数量</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty( $r_detail['amount'] ) ) {{$r_detail["amount"]}} @endif" name="room[{{$r_detail["room_id"]}}][amount]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="text-muted">- 住宿预算</span>
                                                                    <div class="m-sm"></div>
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="@if( !empty( $r_detail['budget_account'] ) ) {{$r_detail["budget_account"]}} @endif" name="room[{{$r_detail["room_id"]}}][budget_account]" title="">
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="m-lg"></div>
                                                                    <div class="checkbox checkbox-success checkbox-inline">
                                                                        <input type="checkbox" id="have_breakfast_{{$r_detail["room_id"]}}" value="1" name="room[{{$r_detail["room_id"]}}][breakfast]" @if( !empty($r_detail['breakfast']) ) {{"checked"}} @endif>
                                                                        <label for="have_breakfast_{{$r_detail["room_id"]}}"> 是否包含早餐 </label>
                                                                    </div>
                                                                    <div class="m-sm"></div>
                                                                </div>
                                                                <input type="hidden" value="@if( !empty($r_detail['room_id']) ) {{$r_detail['room_id']}} @endif" name="room[{{$r_detail["room_id"]}}][room_id]" title="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <div id="room_duplicate_layout" class="form-group room-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" id="add_room_layout" class="btn btn-white btn-xs pull-right">
                                                        <i class="fa fa-plus-square-o"></i> 新增
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">住宿：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 入住时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="start-time" type="text" value="" name="room[101][start_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 退房时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="end-time" type="text" value="" name="room[101][end_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 天数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="check-in-days" type="text" value="" name="room[101][day]" title="" readonly >
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 房间类型</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="room[101][type]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">普通大床房</option>
                                                                <option value="2">普通双床房</option>
                                                                <option value="7">行政单间</option>
                                                                <option value="8">行政双床</option>
                                                                <option value="5">套房</option>
                                                                <option value="3">特殊客房</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 数量</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="room[101][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 住宿预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="room[101][budget_account]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="m-lg"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="have_breakfast_101" value="1" name="room[101][breakfast]">
                                                                <label for="have_breakfast_101"> 是否包含早餐 </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="room_duplicate_tamplate" style="display: none;" title="">
                                            <div id="room_duplicate_layout_{key}" class="form-group room-duplicate-layout">
                                                <div class="col-sm-12 m-r m-b-md">
                                                    <a href="javascript: void(0);" class="btn btn-white btn-xs pull-right del-room-layout" data-id="#room_duplicate_layout_{key}" data-count="{key}">
                                                        <i class="fa fa-minus-square-o"></i> 删除
                                                    </a>
                                                </div>

                                                <label class="col-sm-2 control-label">住宿：</label>

                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 入住时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="start-time" type="text" value="" name="room[{key}][start_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 退房时间</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="end-time" type="text" value="" name="room[{key}][end_time]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 天数</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="check-in-days" type="text" value="" name="room[{key}][day]" title="" readonly >
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 房间类型</span>
                                                            <div class="m-sm"></div>
                                                            <select class="form-control" name="room[{key}][type]" title="">
                                                                <option value="" selected>-- 请选择</option>
                                                                <option value="1">普通大床房</option>
                                                                <option value="2">普通大床房</option>
                                                                <option value="7">行政单间</option>
                                                                <option value="8">行政双床</option>
                                                                <option value="5">套房</option>
                                                                <option value="3">特殊客房</option>
                                                            </select>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 数量</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="room[{key}][amount]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span class="text-muted">- 住宿预算</span>
                                                            <div class="m-sm"></div>
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="room[{key}][budget_account]" title="">
                                                            <div class="m-sm"></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="m-lg"></div>
                                                            <div class="checkbox checkbox-success checkbox-inline">
                                                                <input type="checkbox" id="have_breakfast_{key}" value="1" name="room[{key}][breakfast]">
                                                                <label for="have_breakfast_{key}"> 是否包含早餐 </label>
                                                            </div>
                                                            <div class="m-sm"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">描述：</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" style="resize: none;" name="room[desc]" title=""></textarea>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>备注</h3>
                                    <section>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">描述：</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" style="resize: none;" name="other[desc]" title=""></textarea>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 遮罩层 START -->
        <div class="fakeloader" data-status="init"></div>
        <!-- 遮罩层 END -->

        <div id="shape_tip_tools" class="shape-tip-tools"></div>
        <textarea id="shape_tip_tmp" style="display: none;" title="">
            <div class="contact-box" style="margin-bottom: 0;">
                <div class="col-sm-4">
                    <div class="text-center">
                        <img alt="image" class="m-t-xs img-responsive" src="{img}">
                        <div class="m-t-xs font-bold">{name}</div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <span><strong>桌型摆设：</strong>{desc}</span>
                    <hr style="border-top: 1px dashed #e6e5e5;">
                    <span><strong>特点：</strong>{feature}</span>
                </div>
                <div class="clearfix"></div>
            </div>
        </textarea>
        <form id="pushid" display="none" action="{{ URL('join/export') }}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token() }}">
            <input type="hidden" name="join_id" value="<?php if(isset($ids_str)){?>{{  $ids_str }}<?php }?>">
            <input type="hidden" value="<?php if(isset($rfpId)){?>{{ $rfpId }}<?php }?>" name="rfp_id">
        </form>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/plugins/underscore/core.min.js"></script>

        <script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/plugins/air-datepicker/datepicker.min.js"></script>
        <script src="/assets/js/plugins/air-datepicker/i18n/datepicker.zh.js"></script>
        <script src="/assets/js/plugins/toChoice/core.js"></script>
        <script src="/assets/js/plugins/touchsPin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="/assets/js/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
        <script src="/assets/js/plugins/fakeLoader/fakeLoader.js"></script>
        <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/common.js?v=1.0.0"></script>
        <script src="/assets/js/rfp/page.edit.js"></script>

        <script type="text/javascript">
            // 全局变量
            var ORIGIN_DATA = JSON.parse( '{!!$data!!}' );
            var TOKEN = '{{csrf_token()}}';
            var KEY_COUNT = 101;                            // 数组键值计数器
            var RFP_ID = ORIGIN_DATA["detail"]["rfp_id"];
            var CITY_ID = ORIGIN_DATA["detail"]["citycode"];

            var AREA_DATA = ORIGIN_DATA["area"];
            var ROOM_DATA = ORIGIN_DATA["room"];
        </script>
    </body>
</html>
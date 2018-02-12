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
            .shape-style{vertical-align: top; width: 19px; height: 19px; margin-left: 4px; display: inline-block;}
            .shape-desk{background: url(/assets/img/table_style.png) no-repeat 0 0;}
            .shape-feast{background: url(/assets/img/table_style.png) no-repeat -51px 0;}
            .shape-theater{background: url(/assets/img/table_style.png) no-repeat -102px 0;}
            .shape-cocktail{background: url(/assets/img/table_style.png) no-repeat -154px 0;}
            .shape-fishbone{background: url(/assets/img/table_style.png) no-repeat -205px 0;}
            .shape-director{background: url(/assets/img/table_style.png) no-repeat -256px 0;}

            .shape-tip-tools{position: absolute; max-width: 380px; z-index: 1000; display: none;}

            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}

            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .dashed-wrapper{border: 1px dashed #DBDEE0; padding: 10px 20px 0;}

            @media screen and (min-width: 992px) {
                .modal-lg {
                    width: 980px;
                }
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
                                <span id="meeting_name" >...</span>
                                <a href="/Rfp/index" class="btn btn-outline btn-info pull-right">
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
                                    <strong>发送询单</strong>
                                </li>
                            </ol>
                        </div>
                        <div class="ibox-content">
                            <div id="meeting_body" class="ibox float-e-margins dashed-wrapper">
                                <div class="ibox-content" style="border-top-width: 0;">
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
                                                        <ul class="to-choice-list single-area-type">
                                                            <li data-choiced={"id":"0","name":"不限"}><a href="javascript: void(0);"> 不限</a></li>
                                                            <li data-choiced={"id":"1","name":"酒店"}><a href="javascript: void(0);"> 酒店</a></li>
                                                            <li data-choiced={"id":"4","name":"艺术中心/剧院"}><a href="javascript: void(0);"> 艺术中心/剧院</a></li>
                                                            <li data-choiced={"id":"3","name":"餐厅/会所"}><a href="javascript: void(0);"> 餐厅/会所</a></li>
                                                            <li data-choiced={"id":"2","name":"会议中心/展览馆/体育馆"}><a href="javascript: void(0);"> 会议中心/展览馆/体育馆</a></li>
                                                            <!--<li data-choiced={"id":"8","name":"度假村"}><a href="javascript: void(0);"> 度假村</a></li>-->
                                                            <li data-choiced={"id":"5","name":"其他"}><a href="javascript: void(0);"> 其他</a></li>
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
                                                        <ul class="to-choice-list multi-star-level">
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
                                                            <button type="button" class="oper-btn m-r-xs choiced-type-wrap">类型: 未选中 </button>
                                                        </span>
                                                        <span id="choiced_location_wrap">
                                                            <button type="button" class="oper-btn m-r-xs choiced-location-wrap">位置: 未选中 </button>
                                                        </span>
                                                        <span id="choiced_star_wrap">
                                                            <button type="button" class="oper-btn m-r-xs choiced-star-wrap">星级: 未选中 </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div id="area_inputs" style="display: none;">
                                                    <input type="text" name="area[type]" value="" title="" >
                                                    <input type="text" name="area[location]" value="" title="" >
                                                    <input type="text" name="area[star]" value="" title="" >
                                                    <input type="text" name="area[hotel]" value="" title="" >
                                                </div>
                                            </section>

                                            <h3>会议室需求</h3>
                                            <section>
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
                                                                <input type="radio" id="shape_desk" value="1" name="place[101][shape]" checked="">
                                                                <label for="shape_desk"> 课桌式 </label>
                                                                <i class="shape-style shape-desk"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_feast" value="2" name="place[101][shape]">
                                                                <label for="shape_feast"> 中式宴会 </label>
                                                                <i class="shape-style shape-feast"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_theater" value="3" name="place[101][shape]">
                                                                <label for="shape_theater"> 剧院式 </label>
                                                                <i class="shape-style shape-theater"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_cocktail" value="4" name="place[101][shape]">
                                                                <label for="shape_cocktail"> 鸡尾酒 </label>
                                                                <i class="shape-style shape-cocktail"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_fishbone" value="5" name="place[101][shape]">
                                                                <label for="shape_fishbone"> 鱼骨式 </label>
                                                                <i class="shape-style shape-fishbone"></i>
                                                            </div>
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="shape_director" value="6" name="place[101][shape]">
                                                                <label for="shape_director"> 董事会式 </label>
                                                                <i class="shape-style shape-director"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">可容纳人：</label>

                                                        <div class="col-sm-10">
                                                            <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="place[101][amount]" title="" id="people_num">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">场地预算：</label>

                                                        <div class="col-sm-10">
                                                            <input class="form-control" data-plugin="" type="text" value="" name="place[101][budget_account]" title="">
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
                                                            <input class="form-control" data-plugin="" type="text" value="" name="equip[101][budget_account]" title="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">描述：</label>

                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" style="resize: none;" name="equip[101][desc]" title=""></textarea>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                                    <input class="form-control" data-plugin="touchs-pin" type="text" value="" name="food[{key}][budget]" title="" readonly>
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
                                                                <input class="form-control" data-plugin="normal-time" type="text" value="" name="wine[101][time]" title="">
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
                                                        <textarea class="form-control" style="resize: none;" name="food[desc]" title=""></textarea>
                                                    </div>
                                                </div>
                                            </section>
                                            <h3>住宿需求</h3>
                                            <section>
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
        <script src="/assets/js/rfp/page.create.js"></script>

        <script type="text/javascript">

            var ORIGIN_DATA = JSON.parse( '{!!$data!!}' );                // 全局变量
            var TOKEN = '{{csrf_token()}}';
            var KEY_COUNT = 101;                                             // 数组键值计数器
            var RFP_ID = ORIGIN_DATA["detail"]["rfp_id"];
            var CITY_ID = ORIGIN_DATA["detail"]["citycode"];

            $( '#meeting_name' ).text( ORIGIN_DATA["detail"]["meeting_name"] );
        </script>
    </body>
</html>
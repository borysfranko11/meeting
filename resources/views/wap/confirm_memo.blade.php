<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>水单及支出确认</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/css/wap/sm.css">
    <link rel="stylesheet" href="/assets/css/wap/extend/sm-extend.css">
    <link rel="stylesheet" href="/assets/css/wap/iconfont.css">
    <link rel="stylesheet" href="/assets/css/wap/style_min.css">
    <link rel="stylesheet" href="/assets/css/wap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/wap/star-rating.min.css">
    <link rel="stylesheet" href="/assets/css/wap/zsh.css">
    <link rel="stylesheet" href="/assets/js/web_uploader/webuploader.css">
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    <style type="text/css" media="screen">
        .photo-browser .bar {
            background-color: #fff;
        }

        .photo-browser .bar .title {
            color: #666 !important;
        }
    </style>

    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=d34e69ad1fd7b0f02c64aa78444e6f5f&plugin=AMap.Geocoder"></script>

</head>
<body>
<div class="page-group">
    <div class="page page-current">
        <header class="bar bar-nav clearfix">
            <a class="button button-link button-nav pull-left" href="javascript:history.back(-1)">
                <i class="icon iconfont">&#xe621;</i>
            </a>
            <h1 class="title">水单及支出确认</h1>
        </header>

        <div class="content">
            <div class="content-padded">
                <form id='submit_form' action="/Memo/save_memo" method="post">
                    <div class="meeting_item border-b clearfix">
                        <div class="p_img">
                            <img src="<?= isset($img_info['img_url']) ? $img_info['img_url'] : '/assets/img/statebg_01.png' ?>"
                                 alt="">
                        </div>
                        <div class="pull-left clearfix">
                            <div class="meeting_name">
                                <?php echo $res['meeting_name']; ?>
                            </div>
                            <div class="meeting_place"><?php echo $res['provincedesc'].$res['citydesc']; ?></div>
                            <p class="meeting_time"><?php echo date('Y-m-d', $res['start_time']); ?></p>
                        </div>
                    </div>
                    <div class="grid-demo space-15 clearfix">
                        <div class="row">
                            <div class="col-33 ">计划参会人数:</div>
                            <div class="col-66 text-left red_color"><?php echo $res['people_num']; ?>人</div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">会议审批预算:</div>
                            <div class="col-66 text-left red_color"><span
                                    id="prev"><?php echo $res['budget_total_amount']; ?></span> 元
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-33">实际签到人数:</div>
                            <div class="col-66 text-left position-r"><input name="signed_number"
                                                                            onkeyup="value=value.replace(/[^\d]/g,'')"
                                                                            maxlength="4" id="checkinPeople"
                                                                            type="number"
                                                                            class="form-control-1 m-r-sm ">人
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-33 ">会议室费用:</div>
                            <div class="col-66 text-left position-r"><input name="meeting_room_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">餐饮费用:</div>
                            <div class="col-66 text-left position-r"><input name="food_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">住宿费用:</div>
                            <div class="col-66 text-left position-r"><input name="room_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">会务服务费:</div>
                            <div class="col-66 text-left position-r"><input name="equipment_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">易捷采购酒水费:</div>
                            <div class="col-66 text-left position-r"><input name="wine_drinks" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">其他费用:</div>
                            <div class="col-66 text-left position-r"><input name="other_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-33 ">会唐代采酒水费:</div>
                            <div class="col-66 text-left position-r"><input name="jd_fees" type="text"
                                                                            onkeyup="onlyNaN(this)" value=""
                                                                            class="form-control-1 m-r-sm count">元
                            </div>
                        </div>
                        <div class="row m-b-sm">
                            <div class="col-33"><strong>实际支出总额:</strong></div>
                            <div class="col-66 text-left position-r"><input type="text" id="totalNum" readonly
                                                                            class="form-control-1 m-r-sm">元
                            </div>
                        </div>

                        <input id='submit_files' type="text" name="files" style="display: none">
                        <input type="text" name="rfp_id" style="display: none" value="<?php echo $res['rfp_id']; ?>">
                        <input type="text" name="isMobile" style="display: none" value="1">
                    </div>
                    <div class="grid-demo border-tb clearfix">
                        <h4 class="space-10">上传水单</h4>
                        <div id="gps_txt">定位成功后方可上传水单，正在定位中,请稍后...</div>
                        <input type="hidden" id="files">
                        <div id="fileList" class="uploader-list">

                        </div>
                        <ul class="upload_memo_list m-none">

                            <li>
                                <div id="uploadbtn">+</div>
                            </li>
                        </ul>
                    </div>
                    <div class="grid-demo border-b p-xs clearfix">
                        <h4 class="m-t-none m-b-sm">请您评分</h4>
                        <div class="row">
                            <div class="col-33 gray_color">场地满意度：</div>
                            <div class="col-66 text-left"><input value="0" name="place_star" type="number"
                                                                 class="rating star-default" min=0 max=5 step=1></div>
                        </div>
                        <div class="row">
                            <div class="col-33 gray_color">餐饮满意度：</div>
                            <div class="col-66 text-left"><input value="0" name="food_star" type="number"
                                                                 class="rating star-default" min=0 max=5 step=1></div>
                        </div>
                        <div class="row">
                            <div class="col-33 gray_color">住宿满意度：</div>
                            <div class="col-66 text-left"><input value="0" name="room_star" type="number"
                                                                 class="rating star-default" min=0 max=5 step=1></div>
                        </div>
                        <div class="row">
                            <div class="col-33 gray_color">服务满意度：</div>
                            <div class="col-66 text-left"><input value="0" name="serve_star" type="number"
                                                                 class="rating star-default" min=0 max=5 step=1></div>
                        </div>
                        <br>

                    </div>
                    <div class="grid-demo clearfix">
                        <h4 class="space-10">评价描述</h4>
                        <div class="row">
                            <div class="col-100">
                                <textarea type="text" name="appraise_serve" id="content_evaluate"
                                          class="content_evaluate" placeholder="请输入评价描述，不少于10个字" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="grid-demo clearfix">
                        <div class="row">
                            <div class="col-100">
                                <button type="button" class="btn button button-danger-redbg open-confirm"
                                        style="margin:10px auto; width:50%;">确认
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript' src='/assets/js/wap/zepto.js' charset='utf-8'></script>
<script type='text/javascript' src='/assets/js/wap/deferred.js' charset='utf-8'></script>
<script type='text/javascript' src='/assets/js/wap/callbacks.js' charset='utf-8'></script>
<script type='text/javascript' src='/assets/js/wap/data.js' charset='utf-8'></script>
<script src="/assets/js/wap/star-rating.min.js"></script>
<script src="/assets/js/web_uploader/webuploader.html5only.js"></script>
<script type='text/javascript' src="/assets/js/wap/sm.js" charset='utf-8'></script>
<script type='text/javascript' src="/assets/js/wap/extend/sm_extend.js" charset='utf-8'></script>
<script src="/assets/js/wap/page/confirm_memo.js"></script>
<script>
    $(function () {

        $('.uploader-list').on('click', 'img', function () {
            var arrUrl = [];

            arrUrl.push($(this).attr('src2'));

            $.photoBrowser({
                photos: arrUrl,
                type: 'popup',
                initialSlide: 1
            }).open();

            $('.sliding,.photo-browser-prev,.photo-browser-next').hide();

            // body...
        })

    });
    //只能输入数字、一个小数点，鼠标事件
    function onlyNaN(input) {
        //先把非数字的都替换掉，只允许数字和.
        input.value = input.value.replace(/[^\d\.]/g, '');
        //必须保证第一个为数字而不是.
        input.value = input.value.replace(/^\./g, '');
        //保证只有出现一个.而没有多个.
        input.value = input.value.replace(/^\.{2,}/g, '.');
        //保证.只出现一次，而不能出现两次以上
        input.value = input.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html ng-app="myApp">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="rfp-token" content="{{ csrf_token() }}" />
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- <link href="/assets/css/plugins/webuploader/webuploader.css" type="text/css" rel="stylesheet"> -->
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/creatMeeting/creat.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/lib/honeySwitch.css">
    <link rel="stylesheet" href="/assets/lib/clockpicker-gh-pages/src/clockpicker.css">

{{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        html,body{
            font-size: 62.5%
        }
        .h1, .h2, .h3, h1, h2, h3{
            margin-top: 0 ;
            margin-bottom:0;
        }
        .breadcrumb{
            font-size: 13px;
        }
        .ibox-content{
            background:url('/assets/img/u0.png') no-repeat center 0px/457px ;
            padding-top: 108px;
            padding-bottom: 117px;
        }
        .container-fluid{
            height: 712px;
            overflow-y:scroll;
            border: solid #000 1px;
            width: 400px;
            padding: 0;
            margin: 0 auto;

        }
        a:hover{
            color: #fff;
        }
        ::-webkit-input-placeholder { /* WebKit browsers */
            color:    #a6a8b6;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color:   #a6a8b6;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color:    #a6a8b6;
        }
        :-ms-input-placeholder { /* Internet Explorer 10+ */
            color:   #a6a8b6;
        }
        .bg{
            /*background-image: url("/assets/img/background.jpg") ;*/
            background-repeat: no-repeat;
            background-position: 0 0;
            background-size:cover ;
            padding-bottom: 10px;
        }
        .border {
            border: solid #000 1px;
        }
        .list{
            width: 85%;
            padding:0 8%;
            margin: 0 auto 1.5rem;
            background:rgba(255,255,255,0.2);
            font-size:1.2rem;
            border-radius: 5px;
        }
        .list.image {
            background: none;
        }
        .item-image {
            padding: 0;
            text-align: center;
        }
        .item-image p{
            text-align:center;
            font-size: 1.2rem;
            position: absolute;
            max-width: 89%;
            bottom: 24.5%;
            left: 0;
            right: 0;
            background: #00b6b9;
            margin: 0 auto;
            border: none;
        }
        .item-image img:first-child, .item-image .list-img {
            width: 100%;
            vertical-align: middle;
        }
        .list.invite{
            padding:0 3%;
        }
        .list.invite .item-input{
            padding: 0 14%;
        }
        .list .item:last-child{
            padding: 16px 0
        }
        .item {
            position: relative;
            padding: 16px 0 0;
            overflow: inherit;
            z-index: auto;
            color: #fff;
        }
        .item h1{
            font-size:1.8rem;
            text-align: center;
            color: #fff;
        }
        .item h2{
            font-size:1.4rem;
            color: #fff;
        }
        .item h3{
            font-size:1.2rem;
            color: #fff;
            vertical-align: top;
        }
        .item h3 input{
            display: inline;
            width: 22%;
            background: none;
            border: none;
            font-size: 12px;
        }
        .item h3 .col-xs-3, .item h3 .col-xs-8{
            padding-right: 0;
            max-height: 2.3em;
            overflow: hidden;
        }
        .item h3 .col-xs-3{
            width: 6em;
        }
        .item h3 .col-xs-8{
            padding-left: 0;
        }
        .item h3 .clockpicker input{
            width: 14%;
            padding-left: 1%;
        }
        .item h3 label{
            display: inline;
            text-indent:0.6em;
        }
        .item h3:last-of-type input{
            width: 60%;
        }
        .item input{
            width: 100%;
        }
        .item .line{
            background: #fff;
            height: 1px;
        }
        [class|=switch]{
            height: 1.2rem;
            width: 3rem;
            background: #4c5069;
            border: none;
            float: right;
        }
        .switch-off .slider{
            height: 1.6rem;
            width: 1.6rem;
            left: 0;
            top:-3px
        }
        .switch-on .slider{
            height: 1.6rem;
            width: 1.6rem;
            right: 0;
            top:-3px
        }
        .invite .item-input input{
            text-align: center;
        }
        .item-input{
            padding: 10px 0 0;
        }
        .item-input input{
            height: 2.8rem;
            line-height: 2.8rem;
            font-size: 1.4rem;
            color:  #a6a8b6;
            border: 1px solid #a6a8b6;
            border-radius: 5px;
            padding-left:1rem;
            background: none;
        }
        .radio label{
            padding-left:2rem ;
            margin-right:3rem ;
            position: relative;
        }
        .radio label input{
            display: none;
        }
        .radio label span{
            position: absolute;
            display: block;
            width:1.4rem;
            height:1.4rem;
            top: 0;
            left: 0;
            border: 1px solid #a6a8b6;
            border-radius: 50%;
        }
        .radio label input:checked+span::after{
            content:"";
            position: absolute;
            width: 50%;
            height:50%;
            top: 25%;
            right: 25%;
            background: #2ce9ec;
            border-radius: 50%;
        }
        .radio label input{
            display: none;
        }
        .radio label span{
            position: absolute;
            display: block;
            width:1.4rem;
            height:1.4rem;
            top: 0;
            left: 0;
            border: 1px solid #a6a8b6;
            border-radius: 50%;
        }
        .radio label input:checked+span::after{
            content:"";
            position: absolute;
            width: 50%;
            height:50%;
            top: 25%;
            right: 25%;
            background: #2ce9ec;
            border-radius: 50%;
        }
        .item-text-wrap span{
            position: relative;
        }
        .item-text-wrap span{
            font-size: 1.2rem;
            color: #a6a8b6;
        }
        .item-text-wrap span input{
            border: none;
            background: none;
            width: 6em;
        }
        .item-text-wrap .clockpicker input{
            width: 3em;
        }
        .item-text-wrap span:before{
            content: "";
            width: 0.5em;
            height: 1.2em;
            position: absolute;
            top: 0;
            left:-0.8em;
            background: #00b6b9;
        }
        .button-full{
            width: 100%;
            text-align: center;
            height: 2.8rem;
            display: block;
            line-height:2.8rem ;
            background:#00b6b9 ;
            border-radius:5px ;
            color: #fff;
        }
        .clockpicker-button{
            color:#000;
        }
        .button-line{
            text-align: center;
            padding: 16px;
        }
        .button-line button{
            padding-right: 10px;
        }
        .clockpicker{
            font-style: normal;
        }
        .item-image ::-webkit-input-placeholder { /* WebKit browsers */
            color:    #fff;
        }
        .item-image  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color:   #fff;
        }
        .item-image  ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color:    #fff;
        }
        .item-image  :-ms-input-placeholder { /* Internet Explorer 10+ */
            color:   #fff;
        }
    </style>
    <style>

        .bg{
            background-image: url("{{ empty($tpl['bg_img_url'])?'/assets/img/background.jpg':'/assets/Invitation/'.$tpl['bg_img_url'] }}");
        }

    </style>
</head>
<body>
<div class="row" >
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h2 class="hx-tag-extend">
                    邀请函详情页
                    <a href="/Invitation/lists?rfp_id={{ $tpl['rfp_id'] }}" class="btn btn-outline btn-info pull-right" >

                        <i class="fa fa-reply"></i> 返回
                    </a>
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="javascript: void(0);">会议列表 </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);"> 参会人管理   </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">  制作邀请函</a>
                    </li>
                    <li>
                        <strong>邀请函详情页</strong>
                    </li>
                </ol>
            </div>
            <div class="ibox-content">
                    {{--<form action="#" method="post" enctype="multipart/form-data">--}}
                    {{--邀请函名称：<input type="text" name="name" value="{{  $tpl['name'] }}">--}}
                    {{--上传背景图：<input type="file" name="bg_img_url" value="{{ $tpl['bg_img_url'] }}">--}}
                    {{--会议名称：<input type="text" name="title" value="{{ $tpl['title'] }}">--}}
                    {{--会议时间：<input type="text" name="begin_time" value="{{ $tpl['begin_time'] }}">--}}
                    {{--会议地点：<input type="text" name="address" value="{{  $tpl['address'] }}">--}}
                    {{--确认时间：<input type="text" name="confirm_time" value="{{  $tpl['confirm_time'] }}">--}}
                    {{--</form>--}}
                    <div ng-controller="myCtrl" class="container-fluid ">
                            <div class="bg">
                                <div  class="list image">
                                    <div class="item item-image">
                                        <image src="/assets/img/h5log.png" />
                                        <p>{{ $tpl['title'] }}</p>
                                    </div>
                                </div>
                                <div class="list invite">
                                    <div class="item">
                                        <h1>
                                            诚邀
                                        </h1>
                                    </div>
                                    <div class="item item-input">
                                        <input placeholder="被邀请人姓名展示区,系统自动生成" disabled ng-model="form.name" style="font-size: 12px; padding-left: 0;">
                                    </div>
                                    <div class="item">
                                        <h3>会议时间:
                                            {{ $tpl['begin_time'] }}-{{ $tpl['end_time'] }}
                                        </h3>
                                        <h3 class="row">
                                            <div class="col-xs-3">会议地点:</div>
                                            <div class="col-xs-8"  >
                                                {{  $tpl['address'] }}
                                            </div>
                                        </h3>
                                    </div>
                                </div>
                                <div class="list">
                                    <div class="item">
                                        <h1>
                                            填写个人信息
                                        </h1>
                                    </div>
                                    <div  class="item item-text-wrap">
            <span>
                温馨提示：请在{{  $tpl['confirm_time'] }}  前完成，如未 完成则视同放弃参加会议。
                </span>
                                    </div>
                                    <div class="item">
                                        <h2>
                                            去程出发日期
                                        </h2>
                                    </div>
                                    <div class="item item-input">
                                        <input placeholder='请填写' >
                                    </div>
                                    <div class="item">
                                        不需要预定机票/火车票
                                        <span id="go" class="switch-off" themeColor="#6d9eeb"></span>
                                    </div>


                                    <div id="gobox">
                                        <div class="item">
                                            <h2>去程出行方式</h2>
                                        </div>
                                        <div class="item radio" >
                                            <label for="gotrain"><input id="gotrain" checked name="gotype" type="radio"  value='true' />火车<span></span></label>
                                            <label for="goplane"><input id="goplane" name="gotype" type="radio"  value='false' />飞机<span></span></label>
                                        </div>
                                        <div class="item">
                                            <h2>去程意向航班号/车次号</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写' >
                                        </div>
                                        <div class="item">
                                            <h2>去程出发地址</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写' >
                                        </div>
                                        <div class="item">
                                            <h2>去程目的地址</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写' >
                                        </div>
                                        <div class="item">
                                            <h2>是否需要接机</h2>
                                        </div>
                                        <div class="item radio">
                                            <label for="goneed"><input id="goneed" name="goneed" type="radio" checked  value='true'  />需要<span></span></label>
                                            <label for="gowithout"><input id="gowithout" name="goneed" type="radio"  value='false' />不需要<span></span></label>
                                        </div>
                                    </div>
                                    <div class="item">
                                        不需要预订酒店
                                        <span id="hotel" class="switch-off" themeColor="#6d9eeb" ></span>
                                    </div>
                                    <div id="hotelBox">
                                        <div class="item">
                                            <h2>意向房型</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请输入' >
                                        </div>
                                        <div class="item">
                                            <h2>入住日期</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写' >
                                        </div>
                                        <div class="item">
                                            <h2>退房日期</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写' >
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="line"></div>
                                    </div>
                                    <div class="item">
                                        <h2>
                                            返程出发日期
                                        </h2>
                                    </div>
                                    <div class="item item-input">
                                        <input placeholder='请填写' >
                                    </div>
                                    <div class="item" > 不需要预定机票/火车票 <span id="back" class="switch-off" themeColor="#6d9eeb" ></span></div>
                                    <div id="backBox">
                                        <div class="item">
                                            <h2>返程出行方式</h2>
                                        </div>
                                        <div  class="item radio">
                                            <label for="backtrain"><input id="backtrain" name="backtype"  type="radio" checked  value='true' />火车<span></span></label>
                                            <label for="backplane"><input id="backplane" name="backtype" type="radio"  value='false'  />飞机<span></span></label>
                                        </div>
                                        <div class="item">
                                            <h2> 返程意向航班号/车次号</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写'>
                                        </div>
                                        <div class="item">
                                            <h2> 返程出发地址</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写'>
                                        </div>
                                        <div class="item">
                                            <h2> 返程目的地址</h2>
                                        </div>
                                        <div class="item item-input">
                                            <input placeholder='请填写'>
                                        </div>
                                        <div class="item">
                                            <h2>是否需要接机</h2>
                                        </div>
                                        <div class="item radio">
                                            <label for="backneed"><input id="backneed" name="backneed" type="radio"  checked value='true'  />需要<span></span></label>
                                            <label for="backwithout"><input id="backwithout" name="backneed" type="radio"  value='false' />不需要<span></span></label>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <a class="button button-full button-calm" >提交</a>
                                    </div>
                                </div>
                            </div>

                    </div>
            </div>
        </div>
    </div>
</div>


<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/jquery.form.min.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/tool.js"></script>
<script src="/assets/lib/honeySwitch.js"></script>
<script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>
<script src="/assets/lib/clockpicker-gh-pages/src/clockpicker.js"></script>

<script>
    $(function() {
        switchEvent("#go",function(){
            $("#gobox").hide()
        },function(){
            $("#gobox").show()
        })
        switchEvent("#back",function(){
            $("#backBox").hide()
        },function(){
            $("#backBox").show()
        })
        switchEvent("#hotel",function(){
            $("#hotelBox").hide()
        },function(){
            $("#hotelBox").show()
        })
    });
    function backHref(){
        history.back(-1);
    }
</script>

</body>

</html>

<!DOCTYPE html>
<html>
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
            background: url("/assets/img/background.jpg") no-repeat 0 0/cover;
        }
        .border {
            border: solid #000 1px;
        }
        .container-fluid{
            border: solid #000 1px;
            width: 400px;
            padding: 2.5%;
            margin: 0 auto;
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
        .item-image input{
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
            padding:0 4%;
        }
        .list.invite .item-input{
            padding: 0 14%;
        }
        .list .item:last-child{
            padding: 16px 0
        }
        .list:last-child{
            margin-bottom: 1.5rem;
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
        .item h3:last-of-type{
            padding-top: 5px;
        }
        .item h3 input{
            display: inline;
            width: 5.3em;
            border:none ;
            font-size: 12px;
            color:#555

        }
        .item h3 .col-xs-3, .item h3 .col-xs-8{
            padding-right: 0;
            max-height: 2.3em;
            overflow: hidden;
        }
        .item h3 .col-xs-3{
            width:5.8em;
        }
        .item h3 .col-xs-8{
            padding-left: 0;
        }
        .item h3 .clockpicker input{
            width: 2.6em;
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
            background: #fff;
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
            margin-right: 20px;
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

    <style id="class">
        .bg{
            background-image: url("{{ empty($tpl['bg_img_url'])?'/assets/img/background.jpg':'/assets/Invitation/'.$tpl['bg_img_url'] }}");
        }
    </style>
</head>
<body>
<div class="">
    @foreach(  $errors->all() as $v)
        {{$v}}
    @endforeach
    <form id="form" method="post" enctype="multipart/form-data" action="">
        <input type="hidden" name="InvitationTpl[tpl_id]" value="{{ isset($tpl)? $tpl['tpl_id']:'' }}">
        <input type="hidden" name="InvitationTpl[rfp_id]" value="{{ $rfp_id }}">
        <input type="hidden" name="InvitationTpl[bg_img_url]" value="{{ isset($tpl)? $tpl['bg_img_url']:'' }}">
        {{ csrf_field() }}
        <input type="hidden" name="InvitationTpl[name]" value="{{ isset($tpl)? $tpl['name']:'' }}">
        <input type="file" name="bg_img_url" id="background" onchange="changebackground()"  style="display: none" >
        {{--<a >{{ isset($tpl)? storage_path().$tpl['bg_img_url']:''  }}</a>--}}
        <input type="hidden" name="InvitationTpl[title]" value="{{ isset($tpl)? $tpl['title']:'' }}">
        <input type="hidden" name="InvitationTpl[begin_time]" value="{{ isset($tpl)? $tpl['begin_time']:'' }}">
        <input type="hidden"  name="InvitationTpl[address]" value="{{ isset($tpl)? $tpl['address']:'' }}">
        <input type="hidden" name="InvitationTpl[confirm_time]" value="{{ isset($tpl)? $tpl['confirm_time']:'' }}">
        <input type="hidden" name="InvitationTpl[end_time]" value="{{ isset($tpl)? $tpl['confirm_time']:'' }}">
    </form>
    <input  type="hidden" id="type" value="{{ $type  }}">
    <div class="row form-group" style="    margin-top: 20px;">
        <label class="col-sm-offset-1 col-sm-2  control-label" style="width: 10%;ont-size: 14px"><span style="color: #cc0000">*</span>邀请函名称:</label>
        <div class="col-sm-8" style="padding: 0">
            <input type="text" class="form-control" name="name"  placeholder="请输入您的邀请函名称" value="{{ isset($tpl)? $tpl['name']:'' }}">
        </div>
    </div>
    <div class="row">
        <label class="col-sm-offset-1 col-sm-2  control-label" style="width: 10%; font-size: 14px"><span style="color: #cc0000">*</span>邀请函内容:</label>
        <div class="col-sm-8 border" style="padding-top: 5px">

            <div class="row">
                <div class="col-xs-3 text-center" style="padding: 0; padding-left: 5%">
                    <label class="control-label btn btn-outline btn-success" for="background" style="width:124px;">
                        {{ isset($tpl['bg_img_url'])?'修改':'上传' }}背景图
                    </label>
                    <code id="fileAlert" style="display:block"></code>
                    <button type="button" class="btn btn-success" style="margin-top: 3px" id="reset">使用默认背景图</button>


                </div>

                <div class="col-xs-9 container-fluid bg ">
                    <div >
                        <div  class="list image">
                            <div class="item item-image">
                                <image src="/assets/img/h5log.png" />
                                <p><input id="title" type="text" value="{{ isset($tpl)? $tpl['name']:'' }}" placeholder="请填写会议名称！"  /></p>
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
                                    <input name="beginDate" type="text" value="{{ isset($tpl)? date('Y-m-d',strtotime($tpl['begin_time'])):'' }}" id="test-limit1" placeholder="请选择日期" readonly >
                                    <i class="clockpicker"><input name="beginTime"  placeholder="时间" value="{{ isset($tpl)? date('H:i',strtotime($tpl['begin_time'])):'' }}" readonly></i>~
                                    <input name="endDate" id="test-limit3" type="text"value="{{ isset($tpl)? date('Y-m-d',strtotime($tpl['end_time'])):'' }}" placeholder="请选择日期" readonly>
                                    <i class="clockpicker"><input name="endTime" value="{{ isset($tpl)? date('H:i',strtotime($tpl['end_time'])):'' }}" placeholder="时间" readonly></i></h3>
                                <h3 class="row">
                                       <div class="col-xs-3">会议地点:</div>
                                    <div class="col-xs-8"  >
                                     <input id="address" style="width: 100%" value="{{ !empty($tpl['address']) ? $tpl['address']:''}}" placeholder="请输入会议地址" >
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
                温馨提示：请在<input name="confirmDate" id="test-limit4" width="10em" placeholder="请选择日期" readonly  /> <i class="clockpicker"><input placeholder="时间" name="confirmTime" width="8em" readonly></i> 前完成，如未 完成则视同放弃参加会议。
                </span>
                            </div>
                            <div class="item">
                                <h2>
                                    去程出发日期
                                </h2>
                            </div>
                            <div class="item item-input">
                                <input placeholder='请填写' disabled>
                            </div>
                            <div class="item">
                                不需要预定机票/火车票
                                <span class="switch-on" themeColor="#6d9eeb"></span>
                            </div>


                            <div>
                                <div class="item">
                                    <h2>去程出行方式</h2>
                                </div>
                                <div class="item radio" >
                                    <label for="gotrain"><input id="gotrain" checked name="type" type="radio"  value='true' />火车<span></span></label>
                                    <label for="goplane"><input id="goplane" name="type" type="radio"  value='false' disabled/>飞机<span></span></label>
                                </div>
                                <div class="item">
                                    <h2>去程意向航班号/车次号</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写' disabled>
                                </div>
                                <div class="item">
                                    <h2>去程出发地址</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写' disabled>
                                </div>
                                <div class="item">
                                    <h2>去程目的地址</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写' disabled>
                                </div>
                                <div class="item">
                                    <h2>是否需要接机</h2>
                                </div>
                                <div class="item radio">
                                    <label for="goneed"><input id="goneed" name="type" type="radio" checked  value='true' disabled />需要<span></span></label>
                                    <label for="gowithout"><input id="gowithout" name="type" type="radio"  value='false' disabled/>不需要<span></span></label>
                                </div>
                            </div>
                            <div class="item">
                                不需要预订酒店
                                <span class="switch-on" themeColor="#6d9eeb" disabled></span>
                            </div>
                            <div >
                                <div class="item">
                                    <h2>意向房型</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请输入' disabled>
                                </div>
                                <div class="item">
                                    <h2>入住日期</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写' disabled>
                                </div>
                                <div class="item">
                                    <h2>退房日期</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写' disabled>
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
                                <input placeholder='请填写' disabled>
                            </div>
                            <div class="item" > 不需要预定机票/火车票 <span class="switch-on" themeColor="#6d9eeb" disabled></span></div>
                            <div >
                                <div class="item">
                                    <h2>返程出行方式</h2>
                                </div>
                                <div  class="item radio">
                                    <label for="backtrain"><input id="backtrain" name="type"  type="radio" checked  value='true' />火车<span></span></label>
                                    <label for="backplane"><input id="backplane" name="type" type="radio"  value='false' disabled />飞机<span></span></label>
                                </div>
                                <div class="item">
                                    <h2> 返程意向航班号/车次号</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写'disabled>
                                </div>
                                <div class="item">
                                    <h2> 返程出发地址</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写'disabled>
                                </div>
                                <div class="item">
                                    <h2> 返程目的地址</h2>
                                </div>
                                <div class="item item-input">
                                    <input placeholder='请填写'disabled>
                                </div>
                                <div class="item">
                                    <h2>是否需要接机</h2>
                                </div>
                                <div class="item radio">
                                    <label for="backneed"><input id="backneed" name="type" type="radio"  checked value='true' disabled />需要<span></span></label>
                                    <label for="backwithout"><input id="backwithout" name="type" type="radio"  value='false' disabled/>不需要<span></span></label>
                                </div>
                            </div>
                            {{--<div class="item">--}}
                                {{--<a class="button button-full button-calm" >提交</a>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-line">
        <button type="button" class="btn btn-primary" id="btn">确定</button>
        <button type="button" class="btn " onclick="closeBox()">取消</button>
    </div>
</div>

</body>

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
    function closeBox(){
        parent.layer.closeAll()
    }

    var  type = $('#type').val(),
        options={
            url:"{{  url('/Invitation/addOrUpdate') }}", //上传文件的路径
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
            },
            success: function (data) {
                if(typeof data=="string"){
                    data= $.parseJSON(data)
                }
                if(data.type){
                    parent.layer.closeAll()
                }else{
                    parent.layer.msg(data.message)
                }
            }
         }
    ;
    var myDate = new Date;
    var year = myDate.getFullYear();//获取当前年
    var yue = myDate.getMonth()+1;//获取当前月
    var date = myDate.getDate();//获取当前日
    var now = year+'-'+yue+'-'+date;
    var begin_time=$('input[name="InvitationTpl[begin_time]"]').val();
    var confirm_time=$('input[name="InvitationTpl[confirm_time]"]').val();
     reg=/(\d{4}-\d{2}-\d{2})\s(\d{2}:\d{2})/;
    begin_time.replace(reg,function($0,$1,$2){
        $('input[name="beginDate"]').val($1);
        $('input[name="beginTime"]').val($2);
    });
    confirm_time.replace(reg,function($0,$1,$2){
        $('input[name="confirmDate"]').val($1);
        $('input[name="confirmTime"]').val($2);
    })
       var  checkIn=$('input[name="checkInDate"]').val(),
        checkOut=$('input[name="checkOutDate"]').val(),
           ins11 = laydate.render({
            elem: '#test-limit1'
            ,min: now
            ,max: '2080-10-14',
            btns: ['now','confirm']
            ,done: function(val,data){

                $('input[name="checkInDate"]').val(val);
                checkIn=data;
                if(checkOut){
                    $('#day').val(count(checkIn,checkOut,true));
                    if(moenyInput.val()){
                        sumMoney.val($('#day').val()*$('#money').val());
                    }
                }
                data.month--;
                //ins33.config.min=data;
                   ins22.config.min=data;
                console.log(data)
            }
        }),
           ins22 = laydate.render({
                elem: '#test-limit3'
                ,min: now
                ,max: '2080-10-14'
                ,btns: ['confirm'],
                done:function(val,data){
        //                $('input[name="checkOut"]').val(val);
        //                checkOut=data;
        //                if(checkIn) {
        //                    $('#day').val(count(checkIn,checkOut,false));
        //                    if(moenyInput.val()){
        //                        sumMoney.val($('#day').val()*$('#money').val());
        //                    }
        //                }

                }
        }),
           ins33 = laydate.render({
               elem: '#test-limit4'
               ,max: '2080-10-14'
               ,min: '2017-01-01'
               ,btns: ['confirm'],
               done:function(val,data){
//                $('input[name="checkOut"]').val(val);
//                checkOut=data;
//                if(checkIn) {
//                    $('#day').val(count(checkIn,checkOut,false));
//                    if(moenyInput.val()){
//                        sumMoney.val($('#day').val()*$('#money').val());
//                    }
//                }

               }
           });

        $(".clockpicker").clockpicker();

        function changebackground () {
        var r= new FileReader(),
            f=document.getElementById('background').files[0];
            console.log($('#background').val());
        console.log(f.size>2*1024*1024)
        if(f.size>2*1024*1024){
            $("fileAlert").text(文件过大);
        }
        r.readAsDataURL(f);
        r.onload=function  (e) {
            document.getElementById('class').innerHTML=".bg{ background:url('"+this.result+" ')no-repeat 0 0 /cover }"
        };
            $("input[name='InvitationTpl[bg_img_url]']").val('');
    }

    $("#btn").on("click",function(){
        var flag=1
        $("#form").find('input[name="InvitationTpl[title]"]').val($('#title').val());
        $("#form").find('input[name="InvitationTpl[begin_time]"]').val($('input[name="beginDate"]').val()+" "+$('input[name="beginTime"]').val());
        $("#form").find('input[name="InvitationTpl[end_time]"]').val($('input[name="endDate"]').val()+" "+$('input[name="endTime"]').val());
        $("#form").find('input[name="InvitationTpl[confirm_time]"]').val($('input[name="confirmDate"]').val()+" "+$('input[name="confirmTime"]').val());
        $("#form").find('input[name="InvitationTpl[address]"]').val($('#address').val());
        $("#form").find('input[name="InvitationTpl[name]"]').val($('input[name="name"]').val());
        $("#form").find('input').each(function(){// todo  前台验证有问题
            if($(this).attr('name')=="InvitationTpl[bg_img_url]"|| $(this).attr('name')=='bg_img_url'||$(this).attr('name')=="InvitationTpl[tpl_id]"){
                return true
            }
            else {
                if (!$(this).val()) {
                    parent.layer.msg("填写表单有问题");
                    flag = 0
                }
            }
        });
        if(flag==0){
            return false
        }
       $("#form").ajaxSubmit(options);
    });
    $("#reset").on('click',function(){
        $('#class').html("");
        $('#background').val("");
        $("input[name='InvitationTpl[bg_img_url]']").val('');
    })



</script>
</html>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="rfp-token" content="{{ csrf_token() }}" />
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

    <!-- <link href="/assets/css/plugins/webuploader/webuploader.css" type="text/css" rel="stylesheet"> -->
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/creatMeeting/creat.css" rel="stylesheet">
    {{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .checkbox input[type=checkbox],
        .checkbox-inline input[type=checkbox],
        .radio input[type=radio],
        .radio-inline input[type=radio]{
            margin-top: 0;
        }
        code{
            background-color: inherit;
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
                确认参会人反馈信息
                <a href="{{url('/join/index').'?rfp_id='.$rfp_id }}" class="btn btn-outline btn-info pull-right">
                    <i class="fa fa-reply"></i> 返回
                </a>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="javascript: void(0);">参会人列表</a>
                </li>
                <li>
                    <strong>确认参会人反馈信息</strong>
                </li>
            </ol>
        </div>
                <div class="ibox-content ">
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <form id="form" class="form-horizontal m-t" action="/Confirm/insert" method="post"><!--id="signupForm" -->
                                {{ csrf_field() }}
                                <input type="hidden"  name="join_id"  value="{{ $join_id }}">
                                <input type="hidden"  name="rfp_id"  value="{{ $rfp_id }}">
                                <span class="must">去程日期</span>
                                <div>
                                    <input name="ConfirmUserInfo[come_time]"  class="layui-input form-control" id="goDate" placeholder="请选择" lay-key="20" type="text"  value="{{old('ConfirmUserInfo')['come_time'] ? old('ConfirmUserInfo')['come_time'] :''}}">
                                    <code>{{  $errors->first('ConfirmUserInfo.come_time')}}</code>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="ctrlGo" name="ConfirmUserInfo[is_come_ticket]" value="0" >是否需要预定去程车/机票
                                        <input type="hidden" name="ConfirmUserInfo[is_come_ticket]" id="goForm" value="1">
                                    </label>
                                </div>
                                <br/>
                                <div id="go">
                                    <span>去程方式火车/飞机</span>
                                    <br>
                                    <label><input type="radio" name="ConfirmUserInfo[come_type]" value="0" checked> 火车</label>
                                    <i style="margin-left: 30%"></i>
                                    <label ><input type="radio" name="ConfirmUserInfo[come_type]" value="1"> 飞机</label>
                                    <br/>
                                    <span>去程航班/车次</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[come_code]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['come_code']) ? old('ConfirmUserInfo')['come_code'] :''}}">
                                        <code>{{  $errors->first('ConfirmUserInfo.come_code')  }}</code>

                                    </div>
                                    <span>去程出发地</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[come_begin_city]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['come_begin_city']) ? old('ConfirmUserInfo')['come_begin_city'] :''}}">
                                        <code>{{  $errors->first('ConfirmUserInfo.come_begin_city')}}</code>
                                    </div>
                                    <br/>
                                    <span>去程目的地</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[come_end_city]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['come_end_city']) ? old('ConfirmUserInfo')['come_end_city'] :''}}">
                                        <code>{{  $errors->first('ConfirmUserInfo.come_end_city')}}</code>
                                    </div>
                                    <br/>
                                    <span>是否需要接机</span>
                                    <div class="checkbox">

                                        <label>
                                            <input type="checkbox" id="connetCtrl" name="ConfirmUserInfo[is_connet]" value="1">是否需要接机
                                        </label>
                                        <input type="hidden"  id="connetForm" name="ConfirmUserInfo[is_connet]" value="1">


                                    </div>
                                    <br/>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"  id="ctrlHotle"  >是否需要预订酒店
                                    </label>
                                    <input type="hidden"  id="hotleForm" name="ConfirmUserInfo[is_hotel]" value="0" >

                                </div>
                                <div id="hotle">
                                    <span>意向房型</span>
                                    <div>
                                        <select class="form-control" name="ConfirmUserInfo[room_type]">
                                            <option value="0">请选择</option>
                                            @forelse( $room_type as $type)

                                                <option value="{{ $type }}">{{  $type }}</option>
                                            @empty
                                                <option value="0">该会议无任何房间类型可选，详情请联系会议主办方。</option>
                                            @endforelse
                                        </select>
                                        <code>{{  $errors->first('ConfirmUserInfo.room_type')}}</code>
                                    </div>
                                    <span>入住日期</span>
                                    <div>
                                        <input  name="ConfirmUserInfo[check_in_time]" class="layui-input form-control" id="checkIn" placeholder="请选择" lay-key="22" type="text"  value="{{isset(old('ConfirmUserInfo')['check_in_time']) ? old('ConfirmUserInfo')['check_in_time'] :''}}">
                                        <code>{{  $errors->first('ConfirmUserInfo.check_in_time')}}</code>
                                    </div>
                                    <span>退房日期</span>
                                    <div>
                                        <input  name="ConfirmUserInfo[check_out_time]"  class="layui-input form-control" id="checkOut" placeholder="请选择" lay-key="23" type="text" value="{{isset(old('ConfirmUserInfo')['check_out_time']) ? old('ConfirmUserInfo')['check_out_time'] :''}}"/>
                                        <code> {{  $errors->first('ConfirmUserInfo.check_out_time')}}</code>
                                    </div>
                                </div>
                                <hr style="border-color: #999;"/>
                                <span class="must">返程出发日期</span>
                                <div>
                                    <input  class=" form-control" name="ConfirmUserInfo[leave_time]" id="backDate" placeholder="请选择" lay-key="21" type="text"  value="{{isset(old('ConfirmUserInfo')['leave_time']) ? old('ConfirmUserInfo')['leave_time'] :''}}">
                                    <code>{{  $errors->first('ConfirmUserInfo.leave_time')}}</code>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input id="ctrlBack" type="checkbox"  value="0">是否需要预定返程车/机票
                                    </label>
                                    <input id="backForm" type="hidden" name="ConfirmUserInfo[is_leave_ticket]" value="0">

                                </div>
                                <div id="back">
                                    <span>返程出行方式火车/飞机</span>
                                    <br/>
                                    <label><input type="radio" name="ConfirmUserInfo[leave_type]" value="0" checked> 火车</label>
                                    <i style="margin-left: 30%"></i>
                                    <label><input type="radio" name="ConfirmUserInfo[leave_type]" value="1"> 飞机</label>
                                    {{  $errors->first('ConfirmUserInfo.leave_type')}}
                                    <br/>
                                    <span>返程意向航班号／车次号</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[leave_code]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['leave_code']) ? old('ConfirmUserInfo')['leave_code'] :''}}">
                                        <code>
                                            {{  $errors->first('ConfirmUserInfo.leave_code')}}
                                        </code>
                                    </div>
                                    <span>返程出发地</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[leave_begin_city]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['leave_begin_city']) ? old('ConfirmUserInfo')['leave_begin_city'] :''}}">
                                        <code>{{  $errors->first('ConfirmUserInfo.leave_begin_city')}} </code>
                                    </div>
                                    <span>返程目的地</span>
                                    <div>
                                        <input id="" name="ConfirmUserInfo[leave_end_city]" class="form-control" type="text" value="{{isset(old('ConfirmUserInfo')['leave_end_city']) ? old('ConfirmUserInfo')['leave_end_city'] :''}}">
                                        <code>
                                            {{  $errors->first('ConfirmUserInfo.leave_end_city')}}
                                        </code>
                                    </div>
                                    <div class="checkbox">

                                        <label><input id="sendCtrl" type="checkbox"  value="{{isset(old('ConfirmUserInfo')['is_send']) ? old('ConfirmUserInfo')['is_send'] :''}}" >是否需要送机</label>
                                        <input type="hidden" id="sendForm" name="ConfirmUserInfo[is_send]">
                                    </div>
                                    <br/>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary" type="button" >提交</button>
                                    <button class="btn " type="button">取消</button>
                                </div>
                                <input type="hidden" value="{{$_GET['type']}}" name="type">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/jquery.from.min.js"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
        <script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
        <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/common.js?v=1.0.0"></script>
        <script src="/assets/js/plugins/layer/layer.min.js"></script>
        <script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>
        <script>
            // 日期选择
            var myDate = new Date;
            var year = myDate.getFullYear();//获取当前年
            var yue = myDate.getMonth()+1;//获取当前月
            var date = myDate.getDate();//获取当前日
            var now = year+'-'+yue+'-'+date,
            goDate=laydate.render({
                elem: '#goDate'
                ,min: now
                ,max: '2080-10-14',
                btns: ['now','confirm']
                ,done: function(val,date){
                    date.month--;
                    backDate.config.min=date;
                }
            }),
            backDate= laydate.render({
                    elem: '#backDate'
                    ,min: now
                    ,max: '2080-10-14',
                    btns: ['confirm']
                    ,done: function(val,date){

                    }
                }),
            checkIn= laydate.render({
                elem: '#checkIn'
                ,min: now
                ,max: '2080-10-14',
                btns: ['now','confirm']
                ,done: function(val,date){
                    date.month--;
                    checkOut.config.min=date;
                }
            }),
            checkOut=laydate.render({
                elem: '#checkOut'
                ,min: now
                ,max: '2080-10-14',
                btns: ['now','confirm']
                ,done: function(val,date){

                }
            })
        </script>
        <script>
            $("#go").find('input').prop("disabled",true);
            $("#back").find('input').prop("disabled",true);
            $("#hotle").find('input').prop("disabled",true);
            $("#hotle").find('select').prop("disabled",true);

            // 全选框
            $("#ctrlGo").on('click',function(){
            console.log($(this).is(':checked'));
                $("#go").find('input').prop("disabled",!$(this).is(':checked'));
                if(! $(this).is(':checked')){
                    $("#go").find('code').text('')
                    $(this).val(0)

                }else{
                    $(this).val(1)
                }

            })
            $("#ctrlBack").on('click',function(){
                $("#back").find('input').prop("disabled",!$(this).is(':checked'));
                if(! $(this).is(':checked')){
                    $("#back").find('code').text('')
                    $(this).val(0)

                }else{
                    $(this).val(1)
                }

            })
            $("#ctrlHotle").on('click',function(){
                $("#hotle").find('input').prop("disabled",!$(this).is(':checked'));
                $("#hotle").find('select').prop("disabled",!$(this).is(':checked'));
                if(!$(this).is(':checked')){
                    $("#hotle").find('code').text('')
                    $(this).val(0)

                }else{
                    $(this).val(1)
                }

            })
        </script>
        <script>
            //发送验证
           var text=/[0-9a-zA-Z\u4e00-\u9fa5]/,
            data=/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
            $('form').find('input[type="text"]:not([lay-key])').on("blur",function(){
                        if(!text.test($(this).val())){
                            $(this).parents('div').children('code').text("输入数据有误");
                        }else {
                            $(this).parents('div').children('code').text("");
                        }
            })
        $('.btn-primary').on("click",function(){
            var flag=1;
            console.log(data.test( $("#goDate").val()));
            if( !data.test( $("#goDate").val()) ){
                $("#goDate").parent('div').children('code').text("输入数据有误");
                layer.msg('去程日期有误')
                flag=0
            }
            if(!data.test($("#backDate").val())){
                console.log(3)

                $("#backDate").parent('div').children('code').text("输入数据有误");
                layer.msg('返程日期有误')
                flag=0
            }
            if( $("#ctrlGo").is(':checked')){
                $("#goForm").val(1);
                $("#go").find('input[type="text"]').each(function(){
                  if(! text.test($(this).val())){
                      $(this).parents('div').children('code').text("输入数据有误");
                      layer.msg('去程信息有误')
                      flag=0
                  }
                   $(this).parents('div').children('code').text("");
               });
                if($('#connetCtrl').is(":checked")){
                    $('#connetForm').val(1)
                }else{
                    $('#connetForm').val(0)
                }

            }
            else{
                $("#goForm").val(0)
            }
            if( $("#ctrlBack").is(':checked')){
                $("#backForm").val(1)
                $("#back").find('input[type="text"]').each(function(){
                    if(!text.test($(this).val())){
                        $(this).parents('div').children('code').text("输入数据有误");
                        layer.msg('返程信息有误')
                        flag=0
                    }
                    $(this).parents('div').children('code').text("");
                })
                if($('#sendCtrl').is(":checked")){
                    $('#sendForm').val(1)
                }else{
                    $('#sendForm').val(0)
                }
            }else{
                $("#backForm").val(0)
            }
            if( $("#ctrlHotle").is(':checked')){
                $("#hotleForm").val(1);
                $("#hotle").find('input[type="text"]').each(function(){
                   if(!data.test($(this).val())){
                       $(this).parents('div').children('code').text("住宿日期有误");
                       layer.msg('住宿日期有误')
                       flag=0
                   }
                    $(this).parents('div').children('code').text("");
                });
                if($("#hotle").find('select').val()==0){
                    $(this).parents('div').children('code').text("请选择意向房型");
                    layer.msg('请选择意向房型')
                    flag=0
                }
            }
            else{
                $("#hotleForm").val(0);
            }
            if(flag==1){
                $("#form").submit()
            }
        })
        </script>
</body>

</html>

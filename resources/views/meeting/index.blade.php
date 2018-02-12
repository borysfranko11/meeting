<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
        <meta name="description" content="">
        <meta http-equiv="cache-control" content="no-cache">
        <title>会议采购平台</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="/assets/css/plugins/steps/jquery.steps_recover.css" rel="stylesheet">
        <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/plugins/element/element.css" rel="stylesheet">
        <link href="/assets/css/creatMeeting/creat.css" rel="stylesheet">
        <script src="/assets/plugins/vue.min.js"></script>
        <script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>
    </head>
    <body class="gray-bg">
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="toke">
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>创建会议</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="javascript: void(0);">主页</a>
                    </li>
                    <li>
                        <strong>创建会议</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#entrust">
                        我要授权
                    </button>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div id="meeting_print" class="col-sm-4" style="display: none;">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>会议清单</h5>
                        </div>
                        <div class="ibox-content">
                            <!-- <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>名称</th>
                                    <th>内容</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>会议名称</td>
                                    <td>高频演唱会</td>
                                </tr>
                                <tr>
                                    <td>类型</td>
                                    <td id="preMeetingType"><span>技术高峰论坛</span></td>
                                    <span></span>
                                </tr>
                                <tr>
                                    <td>参会人数</td>
                                    <td>1000</td>
                                </tr>
                                </tbody>
                            </table> -->
                            <!-- 预览 基础信息部分 -->
                            <div id="preBasic">
                                <el-card class="box-card">
                                    <div class="text item" v-for="(item, index) in oitems" :key="index">
                                        <span v-text="item.name"></span>
                                        <template v-if="index == '2'">
                                            <div v-for="(step, index) in item.text" :key="index">
                                                <span v-text="step.value3"></span>
                                                <span> 至 </span>
                                                <span v-text="step.value4"></span>
                                            </div>
                                        </template>
                                        <template v-if="index == '4'">
                                            <div v-for="ostep in item.text" :key="index" class="dis_in">
                                                <span v-text="ostep.label"></span>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <span v-text="item.text"></span>
                                        </template>
                                    </div>
                                </el-card>
                            </div>
                            <!-- 预览 会议预算部分 -->
                            <div id="preMeetingBudget">
                                <el-card class="box">
                                    <div class="text item" v-for="(item, index) in oitems" :key="index">
                                        <span v-text="item.name"></span>
                                        <!-- <span v-text="item.text"></span> -->
                                    </div>
                                </el-card>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="meeting_body" class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>会议内容</h5>
                            <div class="ibox-tools" style="display:none;">
                                <button type="button" id="preview_meeting" class="btn btn-primary btn-outline btn-xs">
                                    <i class="fa fa-paste"></i> 预览
                                </button>
                            </div>
                        </div>
                        <div class="ibox-content" id="oform">
                            {{--<p>这是一个简单的表单向导示例</p>--}}
                            <form class="form-horizontal">
                            <div id="wizard">
                                <h1 >基础信息</h1>
                                <!-- <div class="biao"></div> -->
                                <div id="cont1" class="step-content" style="width: 100%">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议名称：</label>

                                        <div class="col-sm-10" id="meetingName2">
                                            <!-- <input type="text" placeholder="请输入会议名称" class="form-control" id="meetingName2"> -->
                                            <!-- <div id="app"> -->
                                            <el-input v-model.trim="oval" :rules="[{ required: true, message: '年龄不能为空'}]" placeholder="请输入会议名称">
                                            </el-input>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议类型：</label>

                                        <div class="col-sm-10">
                                            <div id="meetingType">
                                                <template>
                                                <el-select v-model="value8" filterable placeholder="请选择" @change="changeValue">
                                                    <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </template>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">竞标类型：</label>
                                        <div class="col-sm-10">
                                            <div id="meetingBitType">
                                                <template>
                                                <el-select v-model="value14" filterable placeholder="请选择" @change="changeValue">
                                                    <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </template>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议时间：</label>

                                        <div class="col-sm-10" class="meeting-time">
                                            <div id="app3">
                                                <el-row v-for="(item, index) in items" class="mb15" :key="index">
                                                    <div class="block el-col el-col-8">
                                                        <el-date-picker  v-model="item.value1" lazy type="date" placeholder="选择日期" :picker-options="pickerOptions0" style="width:97%;" id="date1" @change="oformatDate1(index,item.value1)">
                                                        </el-date-picker>
                                                    </div>
                                                    <div class="line el-col el-col-2" style="line-height:36px;" align="center">至
                                                    </div>
                                                    <div class="block el-col el-col-8">
                                                        <el-date-picker v-model="item.value2" lazy align="right" type="date" placeholder="选择日期" :picker-options="pickerOptions1" style="width:97%;" @change="oformatDate2(index,item.value2)">
                                                        </el-date-picker>
                                                    </div>
                                                    <div class="el-col-4" v-if="index > 0" align="center">
                                                        <el-button type="danger" @click="removeTime(index)">    删除
                                                        </el-button>
                                                    </div>
                                                </el-row>
                                                <el-button type="primary" @click="addTime">备选会议时间</el-button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">行程：</label>

                                        <div class="col-sm-10">
                                            <div id="app4">
                                              <div class="block el-col el-col-8">
                                                <el-date-picker v-model="value1" type="date" placeholder="选择日期" :picker-options="pickerOptions0" style="width:97%;" @change="oformatDate1(value1)">
                                                </el-date-picker>
                                              </div>
                                              <div class="line el-col el-col-2" style="line-height:36px;" align="center">至</div>
                                              <div class="block el-col el-col-8">
                                                <el-date-picker v-model="value2" align="right" type="date" placeholder="选择日期" :picker-options="pickerOptions1" style="width:97%;" @change="oformatDate2(value2)">
                                                </el-date-picker>
                                              </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议地点：</label>

                                        <div class="col-sm-10">
                                            <div id="meetingPlace">

                                                <!-- <el-cascader :options="options" change-on-select v-model="selectOption" @change="handleItemChange"></el-cascader> -->
                                                <div class="block el-col el-col-10">
                                                    <el-select v-model="valuePro" placeholder="请选择省份(支持关键字查找)" filterable @change='proChange'>
                                                        <el-option v-for="item in options" :key="item.id" :label="item.name" :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="line el-col el-col-2" style="line-height:36px;" align="center"></div>
                                                <div class="block el-col el-col-9">
                                                    <el-select v-model="valueCity" placeholder="请选择城市(支持关键字查找)"  @change='cityChange' filterable>
                                                        <el-option v-for="item in options2" :key="item.id" :label="item.name" :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议申请：</label>

                                        <div class="col-sm-10">
                                            <div id="aplSector">
                                                <el-select v-model="value8" filterable placeholder="请选择申请部门" @change="changeValue">
                                                    <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">成本中心：</label>

                                        <div class="col-sm-10">
                                            <div id="costCenter">
                                                <div class="block el-col el-col-9">
                                                <el-select v-model="value8" filterable placeholder="请选择成本中心" @change="changeValue">
                                                    <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                                    </el-option>
                                                </el-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">会议日程：</label>

                                        <div class="col-sm-10" id="app2">
                                            <div class="avatar-uploader txt-upload">
                                                <el-upload class="el-upload el-upload--picture" action="/Meeting/uploadFile" :value="imageUrl" :headers="headers" :on-change="handleChange" :before-upload="beforeUpload" :file-list="fileList3" :data="form" :on-success="onSuccess">
                                                  <i class="el-icon-plus avatar-uploader-icon"></i>
                                                  <div slot="tip" class="el-upload__tip">请选择上传文件</div>
                                            </el-upload>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1>会议预算</h1>
                                <div id="cont2" class="step-content" style="width: 100%">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">各类预算：</label>
                                        <div class="col-sm-10">
                                            <div id="meetingBudget" class="meeting-budget">
                                                <!-- <el-select v-model="value8" filterable placeholder="请选择">
                                                    <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                                    </el-option>
                                                </el-select> -->
                                                <!-- <div v-for="item of items" v-text="item.value"></div> -->
                                                <template v-for="item of items">
                                                    <el-row :value="item.id" :key="item.id">
                                                        <el-card :body-style="{ padding: '10px' }">
                                                        <el-col :span="10">
                                                            <el-checkbox :id="item.id" :label="item.value" v-model='item.checked'></el-checkbox>
                                                        </el-col>
                                                        <el-col :span="2">
                                                            <el-tag type="primary">预算</el-tag>
                                                        </el-col>
                                                        <el-col :span="10">
                                                            <el-input type="number" v-model.number="item.num" placeholder="请输入预算金额（元）" size="small" :span="10">
                                                            </el-input>
                                                        </el-col>
                                                        </el-card>
                                                    </el-row>
                                                </template>
                                                <el-row>
                                                    <el-card :body-style="{ padding: '10px' }">
                                                        <el-col :span="10">
                                                            <el-checkbox v-model="state">           预算是否对服务商可见
                                                            </el-checkbox>
                                                        </el-col>
                                                        <el-col :offset="10" :span="4">
                                                            预算合计
                                                            <el-tag type="primary">@{{total}}</el-tag>元
                                                        </el-col>
                                                    </el-card>
                                                </el-row>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <h1>参会人员</h1>
                                <div id="cont3" class="step-content" style="width: 100%">
                                    <div class="form-group" id="oactive">
                                        <label class="col-sm-2 control-label">参会人数：</label>

                                        <div class="col-sm-3">
                                            <el-input type="number" v-model.number="num1" placeholder="请输入客户参会人数" size="small">
                                                </el-input>
                                            <!-- <input type="email" placeholder="请输入客户参会人数" class="form-control" id="numberCustomer"> -->
                                            <div class="m-sm"></div>
                                            <span class="text-muted">- 客户参会人数</span>
                                        </div>
                                        <div class="col-sm-3" prop="num2">
                                            <el-input type="number" v-model.number="num2" placeholder="请输入企业内部人数" size="small">
                                            </el-input>
                                            <!-- <input type="email" placeholder="请输入企业内部人数" class="form-control" id="internal"> -->
                                            <div class="m-sm"></div>
                                            <span class="text-muted">- 企业内部</span>
                                        </div>
                                        <div class="col-sm-3" prop="num3">
                                            <el-input type="number" v-model.number="num3" placeholder="请输入第三方大会预订人数" size="small">
                                            </el-input>
                                            <div class="m-sm"></div>
                                            <span class="text-muted">- 第三方大会预订</span>
                                        </div>
                                    </div>
                                    <div class="form-group" id="dot">
                                        <label class="col-sm-2 control-label">会议签到点：</label>

                                        <div class="col-sm-10" id="addAre">
                                            <div class="mb15 el-row dots">
                                                <div class="block el-col el-col-12">
                                                    <div class="el-date-editor el-input el-date-editor--date" lazy="" id="date1" style="width: 97%;">
                                                        <input autocomplete="off" placeholder="请输入签到点" size="small" type="text" rows="2" validateevent="true" class="el-input__inner" name="dot">
                                                    </div>

                                                </div>

                                            </div>

                                            <button id="addDot" type="button" class="btn btn-info" onclick="dotModths()">增加签到点</button>
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">参会人员：</label>

                                        <div class="col-sm-10" id="pepople">
                                            <div class="avatar-uploader txt-upload">
                                                <el-upload class="el-upload el-upload--picture" action="/Meeting/uploadFile" :headers="headers" :before-upload="beforeAvatarUpload" :on-change="handleChange" :file-list="fileList2" :show-file-list="true" :on-success="onSuccess" :data="form">
                                                  <i class="el-icon-plus avatar-uploader-icon"></i>
                                                  <div slot="tip" class="el-upload__tip">只能上传xls,xlsx格式的Excel文件，且不超过2MB。</div>
                                                </el-upload>
                                            </div>
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

        <div class="modal inmodal" id="entrust" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                        </button>
                        <i class="fa fa-laptop modal-icon"></i>
                        <h4 class="modal-title">会议授权</h4>
                        <small class="font-bold">一键式会议创建，简单快捷</small>
                    </div>
                    <div class="modal-body">
                        <p><strong>会议授权</strong> 选择会议授权,您只需要监控会议进程,会议授权人人全程为您管理会议</p>
                        <br>
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" style="">会议名称：</label>

                                <div class="col-sm-8  text-left">
                                    <input type="text" placeholder="请输入会议名称" class="form-control" id="meetingName" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" style="">被授权：</label>
                                <div class="col-sm-8">
                                    <div id="meetingHost">
                                        <el-select v-model="value8" filterable placeholder="请选择" @change="changeText(value8)">
                                            <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" style="">授权凭证：</label>
                                <div class="col-sm-8" id="upload">
                                   <el-upload class="avatar-uploader" action="/Meeting/uploadFile" :headers="headers" :data="form" :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload" list-type="picture">
                                      <img v-if="imageUrl" :src="imageUrl" :value="imageUrl" class="avatar">
                                      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                      <div slot="tip" class="el-upload__tip">只能上传jpg,png文件，且不超过2MB</div>
                                    </el-upload>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" id="hosting">授权</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
        <script src="/assets/plugins/layer/layer.js"></script>
        <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/common.js?v=1.0.0"></script>
        <script type="text/javascript">
            function dotModths(){
                var htmls = "<div class='mb15 el-row'><div class='block el-col el-col-12'><div class='el-date-editor el-input el-date-editor--date' lazy='' id='' style='width: 97%;'><input autocomplete='off' placeholder='请输入签到点' size='small' type='text' rows='2' validateevent='true' class='el-input__inner' name='dot'></div></div><div align='center' class='el-col-4'><button type='button' class='el-button el-button--danger' onclick='remove(this)'>删除</button></div></div>";
                $('.dots').after(htmls);
            }
            function remove(obj){
                $(obj).parent().parent().remove();
            }
            $( document ).ready( function() {
                //$("#addDot").click(function(){alert(1);
                    //$("addAre").clone(true).appendTo("dot");
                //});
   
                var entrust = $( '#entrust' );
                // 延时执行函数
                setTimeout( function(){
                    entrust.modal( 'show' );
                    // $( '.chosen-select' ).chosen( {width: "100%"} );
                }, 300 );
                // 弹窗显示事件监控
                entrust.on('show.bs.modal', function (){

                } );
                // 弹窗关闭事件监控
                entrust.on( 'hidden.bs.modal', function (){

                } );

                $("#wizard").steps({
                    enableAllSteps: true,
                });

                //时间值初始化
                // $( ".input-daterange" ).each( function()
                // {
                //     $( this ).find( 'input' ).val( getDate( 0, '-' ) );
                // } );

                // $( ".use-date" ).datepicker( {
                //     keyboardNavigation: !1,
                //     forceParse: !1,
                //     autoclose: !0
                // } );

                // 点击预览按钮时的状态切换；
                $( '#preview_meeting' ).click( function() {
                    var print = $( '#meeting_print' ),
                        body = $( '#meeting_body' );

                    // 预览按钮的状态切换
                    if( print.css( "display" ) === 'none' ) {
                        print.attr( "class", "col-sm-4" ).fadeIn();
                        body.attr( "class","col-sm-8" );
                    }else{
                        print.hide();
                        body.attr( "class","col-sm-12" );
                    }
                });
               $(".steps").find("ul").find("li").append("<div class='biao'></div>");
               $(".steps").find("ul").find("li").eq(2).find("div").remove()
               $(".steps").find("ul").find("li").css("display","flex")
               $(".steps").find("ul").find("li").css("z-index","100")
               $(".steps").find("ul").find("li>a").css("flex","1")
               $(".steps").find("ul").find("li>div").eq(1).css("border-left","17px solid transparent")
               $(".steps").find("ul").find("li>div").eq(2).css("border-left","17px solid transparent")
               /*$(".steps>ul>li").click(function(){
                    
                    $(this).siblings("li").find(".biao").css("border-left","17px solid white")
                    $(this).siblings("li").closest("li").find(".biao").css("background","none")
                    $(this).prev("li").closest("li").find(".biao").css("background","#23c6c8")
                    $(this).find(".biao").css("border-left","17px solid #23c6c8")
                    $(this).find(".biao").css("background","none")
               })*/              
               $(".steps>ul>li").eq(1).click(function(){
                    $(this).siblings("li").find(".biao").css("border-left","17px solid white")
                    $(this).siblings("li").closest("li").find(".biao").css("background","none")
                    $(this).siblings("li").closest("li").find(".biao").css("background","#23c6c8")
                    $(this).find(".biao").css("border-left","17px solid #23c6c8")
                    $(this).find(".biao").css("background","none")                    
               })
               $(".steps>ul>li").eq(2).click(function(){
                    $(this).siblings("li").find(".biao").css("border-left","17px solid white")
                    $(this).siblings("li").closest("li").find(".biao").css("background","none")
                    $(this).prev("li").find(".biao").css("background","#23c6c8")
                    $(this).find(".biao").css("border-left","17px solid #23c6c8")
                    $(this).find(".biao").css("background","none")                   
               })
               $(".steps>ul>li").eq(0).click(function(){
                    $(this).siblings("li").find(".biao").css("border-left","17px solid white")
                    $(this).siblings("li").closest("li").find(".biao").css("background","none")
                    $(this).prev("li").find(".biao").css("background","#23c6c8")
                    $(this).find(".biao").css("border-left","17px solid #23c6c8")
                    $(this).find(".biao").css("background","none")                   
               })
               $(".steps>ul>li").on("click",("div"),function(){
                    return false;
               })
            } );
        </script>
        <script src="/assets/js/creatMeeting/creat.js"></script>
    </body>
</html>

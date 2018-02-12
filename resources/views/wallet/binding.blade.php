<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>钱包管理</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="rfp-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
        <link href="/assets/css/plugins/air-datepicker/datepicker.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/timeline/css/default.css" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/plugins/fakeLoader/fakeLoader.css" rel="stylesheet">
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="//at.alicdn.com/t/font_fmttcx9sau62bj4i.css" rel="stylesheet">
        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">

        <style type="text/css">
            .footable-filtering{display: none;}
            .footable-paging{display: none;}

            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px; font-weight: 400;}
            .dashed-wrapper{border: 1px dashed #DBDEE0; padding: 10px 20px 0;}

            .text-muted:hover{color: #888;}
            .text-muted:link{color: #888;}
            .footable-first-visible{cursor:pointer;}
            .no_border_table>tbody>tr>td{border-width: 0;}

            .arrow{position: absolute; width: 50px; height: 50px; z-index: 200; display: none;}
            .arrow.active1{
                display: block;
            }
            .icon-jiantou{
                font-size: 30px;
                color: #1ab394;
                margin-left: 10px;
            }
            /* timeline 样式补充 */
            .timeline-item{position: relative;}
            .timeline-runway{position: absolute; top: -5px; left: 90px; width: 60px; height: 50px; background:url(/assets/img/runway_left.gif) no-repeat center; z-index: 100; display: none;}
            .ibox-content.timeline {
                max-height: 590px;
                overflow-y: auto;
            }
            .chosen-container{width: 100%!important;}
            .table_inquiry button{
                width:8em;
            }
            .btn-primary:disabled{
                background: #797979;
                border-color: #797979;
            }
            .btn-primary:disabled:hover{
                background: #797979;
                border-color: #797979;
            }
            #car{
                margin:20px;
            }
            #car .use_time,#car .use_time_end{
                width:42%
            }
            .form-control{
                display:inline-block;
            }
            .datepicker,.datepicker--cell { z-index:999999999 !important}
           .car th{
            text-align: center;
           }
        </style>

        <script>
            function loadFrame(obj){
                var url = obj.contentWindow.location.href;
                console.log(url);

            }
            </script>

    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">

                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">钱包管理</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <strong>钱包管理</strong>
                                </li>
                                <li>
                                    <strong>绑卡</strong>
                                </li>

                            </ol>
                        </div>
                        <div class="ibox-content">
                            <div style="position: relative;">
                                <div class="m-b-md dashed-wrapper">
                                    <h3 class="m-b-md hx-tag-extend">绑卡</h3>

                                    <form class="form-horizontal m-t" id="signupForms">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">开户名：</label>
                                            <div class="col-sm-8">
                                                <input id="bank_account_name" name="bank_account_name" class="form-control" type="text"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">银行卡号：</label>
                                            <div class="col-sm-8">
                                                <input id="bank_account_no" name="bank_account_no" class="form-control" type="text" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">开户行所在地：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" id="one" name="" title="请选择省份！" >
                                                    <option value="" selected>请选择省份</option>
                                                    <?php foreach($area AS $key => $value){?>
                                                    <option value="<?php echo $value['ID'];?>"><?php echo $value['ShortName'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="open_account_province" id="open_account_province" value="">
                                            <div class="col-sm-2">
                                                <select class="form-control" id="two" name="" title="请选择城市！" >
                                                    <option value="" selected>请选择城市</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="open_account_city" id="open_account_city" value="">
                                            <div class="col-sm-2">
                                                <select class="form-control" id="th">
                                                    <option value="" selected>请选择区县</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">开户行：</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="open_account_bank_code" id="khh" title="请选择开户行！">
                                                    <option value="" selected>请选择开户行</option>
                                                    <?php foreach($bank AS $bkey => $bvalue){?>
                                                    <option value="<?php echo $bvalue['code'];?>"><?php echo $bvalue['BankName'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">身份证号：</label>
                                            <div class="col-sm-8">
                                                <input id="id_number" name="id_number" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <input type="hidden" name="open_account_bank_name" id="open_account_bank_name" value="">

                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-3">
                                                <button class="btn btn-primary" type="submit">提交</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="car" style="display:none">

        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
        <script src="/assets/js/plugins/validate/messages_zh.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script>
            $( document ).ready( function()
            {
                $("#signupForms").submit(function(e){
                    var index = layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    /*if(!$("#bank_account_name").val()){
                        layer.msg('请填写开户名');
                        return false;
                    }
                    if(!$("#bank_account_no").val()){
                        layer.msg('请填写银行卡号');
                        return false;
                    }else{
                        if(isNaN($("#bank_account_no").val())){
                            layer.msg('请正确填写银行卡号');
                        }
                    }
                    if(!$("#one").val()){
                        layer.msg('请选择省份');
                        return false;
                    }
                    if(!$("#two").val()){
                        layer.msg('请选择城市');
                        return false;
                    }
                    if(!$("#khh").val()){
                        layer.msg('请填写开户行');
                        return false;
                    }
                    if(!$("#id_number").val()){
                        layer.msg('请填写身份证号');
                        return false;
                    }else{
                        pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
                        if(!pattern.test($("#id_number").val())){
                            layer.msg('请正确填写身份证号');
                            return false;
                        }
                    }*/
                    var url     = '/Wallet/bindingCard';
                    var TOKEN   = '{{csrf_token()}}';
                    var _form   = $( '#signupForms' ),
                                    _form_status = _form.attr( 'data-status' ),                                                                  _form_data = _form.serialize();
                    var _tmp    = [_form_data],
                                _final_data = {"_token":TOKEN, "param":{"data": _tmp.join( '&' )}};
                    $.ajax( {
                        type: "post",
                        url: url,
                        data: _final_data,
                        dataType: "json",
                        timeout: 5000,
                        beforeSend: function( XMLHttpRequest ){
                        },
                        success: function( Response ){

                           // Response= $.parseJSON(Response);

                            if(Response.errorno>0){
                                layer.msg('绑卡失败:'+Response.msg);
                                layer.close(index);
                                return false;
                            }else{
                                layer.close(index);
                                layer.msg('绑卡成功');
                                window.location.href="/Wallet/index";
                            }
                        }
                    } );

                });
                $("#one").change(function(){
                    var id = $('#one option:selected') .val();
                    $("#two").empty();
                    $("#th").empty();

                    $.ajax({
                        type : "POST",  //提交方式
                        url : "/Wallet/getArea",
                        data : {
                            "cityId" : id
                        },//数据，这里使用的是Json格式进行传输
                        success : function(result) {//返回数据根据结果进行相应的处理
                            result= $.parseJSON(result);
                            if(result.errorno){
                                layer.msg('获取地址失败:'+result.msg);
                                return false;
                            }

                            var tbHtml = "<option value=''>请选择城市</option>";

                            $.each(result.data, function(key, value) {
                                console.log(value);
                                tbHtml+="<option value="+value['ID']+">"+value['ShortName']+"</option>";
                            });
                            $('#two').css("display","");

                            $('#two').append(tbHtml);

                        }
                    });
                    $("#open_account_province").val($('#one option:selected') .text());
                });

                $("#two").change(function(){
                    var id = $('#two option:selected') .val();

                    $.ajax({
                        type : "POST",  //提交方式
                        url : "/Wallet/getArea",
                        data : {
                            "cityId" : id
                        },//数据，这里使用的是Json格式进行传输
                        success : function(result) {//返回数据根据结果进行相应的处理
                            result= $.parseJSON(result);
                            if(result.errorno){
                                layer.msg('获取地址失败:'+result.msg);
                                return false;
                            }

                            var tbHtml = "<option value=''>请选择区县</option>";

                            $.each(result.data, function(key, value) {
                                console.log(value);
                                tbHtml+="<option value="+value['ID']+">"+value['ShortName']+"</option>";
                            });

                            $('#th').append(tbHtml);

                        }
                    });
                    $("#open_account_city").val($('#two option:selected') .text());
                });


                $("#khh").change(function(){
                    var bank = $('#khh option:selected') .text();
                    $("#open_account_bank_name").val(bank);
                });

            });



        </script>


    </body>
</html>

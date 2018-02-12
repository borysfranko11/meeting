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

                            </ol>
                        </div>
                        <div class="ibox-content">
                            <div style="position: relative;">
                                <div class="m-b-md dashed-wrapper">
                                    <h3 class="m-b-md hx-tag-extend">钱包管理</h3>

                                    <div class="table-responsive" id="wrap_table">
                                        <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                                        <?php if(empty($card)){?>
                                        您还没有绑卡,请先去绑卡<a href="/Wallet/binding" class="btn btn-primary">去绑卡</a>
                                        <?php }else{?>
                                        <div>
                                            <h3 class="m-b-md ">账户余额:<span id="money" style="color: red;">获取余额中......</span><a href="javascript:;" id="withdrawals" class="btn btn-primary" style="margin-left: 50px;">提现</a></h3>
                                        </div>
                                        <?php }?>
                                        <table id="rfp_table" class="table" data-paging="true" data-filtering="true">
                                            <thead>
                                            <tr>
                                                <th>开户名</th>
                                                <th>开户省份</th>
                                                <th>开户城市</th>
                                                <th>银行名称</th>
                                                <th>银行卡号</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($card AS $key => $value){?>
                                            <tr>
                                                <td><?php echo $value['bank_account_name'];?></td>
                                                <td><?php echo $value['open_account_province'];?></td>
                                                <td><?php echo $value['open_account_city'];?></td>
                                                <td><?php echo $value['open_account_bank_name'];?></td>
                                                <td><?php echo $value['bank_account_no'];?></td>
                                                <td><a href="javascript:;" id="resetting" class="btn btn-primary">充值</a></td>
                                            </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="/Wallet/resetting" id="formMoney" target="_blank">
            <input type="hidden" name="money" id="moneys" value="">
        </form>
        <div id="car" style="display:none">

        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/common.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script>
            $( document ).ready( function()
            {
                $.ajax( {
                    type: "post",
                    url: '/Wallet/getMoney',
                    data: '',
                    dataType: "json",
                    timeout: 5000,
                    beforeSend: function( XMLHttpRequest ){
                    },
                    success: function( Response ){

                        if(Response.errorno == 0){
                            $("#money").text("￥"+Response.data.money);
                        }else{
                            $("#money").text('获取金额失败');
                        }
                    }
                } );
                $("#resetting").click(function(){
                    parent.layer.prompt({
                        title: '请输入充值金额',
                        formType: 3 //prompt风格，支持0-2
                    }, function(pass, index, elem){
                        $("#moneys").val(pass);
                        $("#formMoney").submit()
                        parent.layer.close(index);

                       // window.location.replace("http://www.jb51.net");
                        //layer.msg('演示完毕！您的口令：'+ pass );
                    });
                });

                $("#withdrawals").click(function(){
                    parent.layer.prompt({title: '请输入交易密码，并确认', formType: 1}, function(pass, index){
                        var TOKEN   = '{{csrf_token()}}';
                        var datas = {"_token":TOKEN, "param":pass};
                        $.ajax( {
                            type: "post",
                            url: '/Wallet/checkPass',
                            data: datas,
                            dataType: "json",
                            timeout: 5000,
                            beforeSend: function( XMLHttpRequest ){
                            },
                            success: function( Response ){
                                if(Response==1){
                                    parent.layer.prompt({
                                        title: '请输入提现充值金额',
                                        formType: 3 //prompt风格，支持0-2
                                    }, function(pass, index, elem){
                                        var TOKEN   = '{{csrf_token()}}';
                                        var datas = {"_token":TOKEN, "param":pass};
                                        $.ajax( {
                                            type: "post",
                                            url: '/Wallet/withdrawals',
                                            data: datas,
                                            dataType: "json",
                                            timeout: 5000,
                                            beforeSend: function( XMLHttpRequest ){
                                            },
                                            success: function( Response ){
                                                if(Response.errorno>0){
                                                    parent.layer.close(index);
                                                    layer.msg('提现失败:'+Response.msg);
                                                    return false;
                                                }else{
                                                    parent.layer.close(index);
                                                    layer.msg('提现成功');
                                                    getMoney();
                                                    //window.location.href="/Wallet/index";
                                                }
                                            }
                                        } );

                                        // window.location.replace("http://www.jb51.net");
                                        //layer.msg('演示完毕！您的口令：'+ pass );
                                    });
                                }else{
                                    parent.layer.close(index);
                                    layer.msg('密码错误');
                                }
                            }
                        } );

                    });
                });
            } );
            function getMoney(){
                $.ajax( {
                    type: "post",
                    url: '/Wallet/getMoney',
                    data: '',
                    dataType: "json",
                    timeout: 5000,
                    beforeSend: function( XMLHttpRequest ){
                    },
                    success: function( Response ){

                        if(Response.errorno == 0){
                            $("#money").text("￥"+Response.data.money);
                        }else{
                            $("#money").text('获取金额失败');
                        }
                    }
                } );
            }

        </script>

        <script src="/assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>
        <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
       {{-- <script src="/assets/js/jquery-ui-1.10.4.min.js"></script>--}}
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script type="text/javascript" src="/assets/js/rpf/index.js"></script>
    </body>
</html>

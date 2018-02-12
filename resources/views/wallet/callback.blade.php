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
            @charset "utf-8";select{margin:0;padding:0}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal}code,kbd,pre,samp{font-family:courier new,courier,monospace}small{font-size:12px}ul,ol{list-style:none}a{text-decoration:none;outline:0}q:before,q:after{content:''}sup{vertical-align:text-top}sub{vertical-align:text-bottom}legend{color:#000}fieldset,img{border:0}button,input,select,textarea{font-family:inherit;font-size:inherit;font-weight:inherit;font-size:100%}table{border-collapse:collapse;border-spacing:0}caption,th{text-align:left}strong,b{font-weight:bold}.fl{float:left}.fr{float:right}.pr{position:relative}.cf:before,.cf:after{content:"";display:table}.cf:after{clear:both}.cf{zoom:1}.c_b{zoom:1}.c_b:after{clear:both;content:" ";display:block}.t_l{text-align:left}.coin_record_list .wd5{text-align:center}.confirm_pop{padding:20px 0}.confirm_pop dt,.confirm_pop dd{float:left;line-height:30px;height:30px;font-size:14px}.confirm_pop dt{width:140px;text-align:right;font-weight:700}.confirm_pop dd{width:270px;padding-left:10px}.btn_money_b{display:block;width:174px;height:44px;line-height:46px;text-align:center;font-size:14px;font-weight:700;color:#999;margin:auto;border:1px solid #cecece;background:#f2f2f2}.btn_money_b:hover{text-decoration:none;background:#fff}.pay_fruit{width:958px;padding:50px 0 80px}.pay_fruit.p_error{background:#fff9f7;border:1px solid #d3b6ad}.pay_fruit.p_ok{background:#f9fff8;border:1px solid #afd5a9}.pay_fruit_icon{width:280px; margin-left: 150px;}.pay_fruit_icon img{float:right;margin-right:20px;display:inboine}.pay_fruit_txt h3{font-size:24px;font-weight:700}.pay_fruit_txt p{padding-bottom:10px}.btn_u1.mln{margin-left:0}.pop_safe_w380{margin:auto;width:380px}.pop_safe_pwd{border:1px solid #ddd;height:30px;line-height:30px;padding:0 10px;width:200px}.plw1{padding-left:76px}.c_red{color:red}.md_pay .pay_info .btn_login{text-decoration:underline;color:#666;float:none}.md_pay .pay_info .btn_login:hover{color:#333}.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;font-size:0;height:0}.clearfix{zoom:1}.xjq_recharge_box{border-top:1px dashed #ccc;border-bottom:1px dashed #ccc;padding:10px 0;margin:10px 0}.xjq_blue{color:#3baaff}.ml20{margin-left:20px}.mtb10{margin:10px 0}.text_input{border:1px solid #ccc;width:50px}.xjq_recharge{line-height:30px;display:none}.fz18{font-size:18px}.xjq_recharge_box h4{font-size:14px;line-height:30px;margin-bottom:4px}.none{display:none}.J_ticket_sel{margin-top:3px;*margin-top:-2px;position:absolute;display:block}.J_ticket_logged{margin-top:10px}.J_ticket_logged label{margin-left:20px}.maskBg{background:#000;position:fixed;_position:absolute;width:100%;height:2000px;top:0;left:0;opacity:.5;filter:alpha(opacity=50);z-index:88}.pop3{width:550px;border-bottom:4px solid #bebebe;background:#fff;position:fixed;_position:absolute;top:40%;left:50%;margin-left:-245px;margin-top:-150px;line-height:2;z-index:100;display:none}.pop3 h3{font:bold 14px/34px "microsoft yahei"}.pop3 .close{float:right;width:20px;height:20px;}.pop3 .close:hover{background-position:-22px -386px}.retrieve a,.code-wrap a,.pop3 .link{color:#ff7900;text-decoration:underline}.pop3 strong{color:#ff7900}.entry-hd{border:0;background:#f0f0f0;box-shadow:0 0 0 #fff}.entry-hd h3{height:100%;padding-left:0;overflow:hidden}.entry-hd h3 a{display:inline-block;width:170px;text-align:center;vertical-align:top}.entry-hd h3 a:hover,.entry-hd h3 .now{background:#fff;color:#0eacf4;border-top:4px solid #0eacf4;text-decoration:none}.entry-bd1{height:438px;overflow-x:hidden}.xjq_box1{border:1px solid #ccc;height:40px;line-height:40px;padding-left:20px;display:none}.xjq_dl{width:39px;height:19px;line-height:19px;border:1px solid #ccc;text-align:center;display:inline-block;background-color:#ddd}.xjq_dl:hover{text-decoration:none}.w{width:960px;margin:0 auto;overflow:hidden;zoom:1}.side{float:left}.main{float:right}.mb10{margin-bottom:10px}.m0{margin:0}.games-item .btn{margin-top:5px}.icon-prev,.icon-next{width:32px;height:82px;cursor:pointer;position:absolute;top:20px}.icon-prev{background-position:-232px 0;left:15px}.icon-next{background-position:-268px 0;right:15px}.icon-prev:hover{background-position:-232px -84px}.icon-next:hover{background-position:-268px -84px}.table-hd{height:45px;line-height:45px;padding-left:20px;font-size:14px}.table-hd strong{margin:0 5px}


        </style>

    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="w">
                <div class="pay_fruit p_ok cf mb60">
                    <div class="pay_fruit_icon fl">
                        <img src="/assets/img/p_ok.png" alt="">
                    </div>
                    <div class="fl pay_fruit_txt">
                        <h3 class="pb10 pt10">您已充值成功! </h3>

                        <p class="pt20">
                            <a href="javascript:;" id="close" class="btn btn-primary">关闭页面</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/common.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script>

        </script>

        <script src="/assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>
        <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
       {{-- <script src="/assets/js/jquery-ui-1.10.4.min.js"></script>--}}
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script type="text/javascript" src="/assets/js/rpf/index.js"></script>
        <script type="text/javascript">
            $('#close').on('click',function(){
                if (navigator.userAgent.indexOf("Firefox") != -1 || navigator.userAgent.indexOf("Chrome") !=-1) {
                    window.location.href="about:blank";
                    window.close();
                } else {
                    window.opener = null;
                    window.open("", "_self");
                    window.close();
                }

            })
            function closewin(){
                self.opener=null;
                self.close();
            }

        </script>
    </body>
</html>

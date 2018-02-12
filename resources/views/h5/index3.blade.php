<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no">
    <title>会信国旅开业邀请函</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <style type="text/css" media="screen">
    * {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'PingFangSC-Light', 'helvetica neue', 'hiragino sans gb', arial, 'microsoft yahei ui', 'microsoft yahei', simsun, sans-serif;
        background: #000;
    }

    .container,
    .page {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
    }
    .footer-fixed{
       background: #000;
       position: absolute;
       width: 100%;
       bottom:0;
       padding: 15px 0;
/*       border-top:1px solid #f6e5a6;*/
       z-index: 2;
    }
    .footer-btn{
    	background: #f6e5a6;
    	color:#000;
    	width: calc(100% - 40px);
    	margin: 0 10px;
    	border-radius: 5px;
    	padding: 10px;
    	display: block;
    	text-align: center;

    }
    .oh {
        overflow: hidden !important;
    }

    .fuild {
        width: 100%;
    }

    .page {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        z-index: 1;
    }

    .bg-default {
        background-image: url("/assets/img/bg1.png");
        background-repeat: no-repeat;
        background-position: top center;
        background-size: cover;
    }

    .logo {
        margin: 20px;
    }

    .logo img {
        width: 40vw;
        max-width: 300px;
    }

    .title {
        margin: 10px 0 20px;
        text-align: center;
    }

    .title img {
        width: 40vw;
        max-width: 400px;
    }

    .content {
        padding: 0 10vw;
    }

    .text {
        color: #f6e5a6;
        line-height: 1.8;
        font-size: 14px;
    }
    h4.header{
    	font-size: 15px;
    	color: #f6e5a6;
    	margin-top: 20px;
    }
    .list{
    	overflow: hidden;
    	position: relative;
    }
    .list.dot:after{
    	content: '';
    	position: absolute;
    	top:.6em;
    	left:.36em;
    	border-left: 1px solid #f6e5a6;
    	width: 1px;
    	height: calc( 100% - 1.2em);
    }
    .list .item{
    	color: #f6e5a6;
    	padding: 5px 0;
    	font-size: 13px;
    }
    .list .item span{
    	padding-right: 5px;
    }
    .footer{
    	text-align: right;
    	color: #f6e5a6;
    	font-size: 12px;
    	padding: 30px 0 100px;
    }
    .center{
    	text-align: center;
    	display: inline-block;
    }
    </style>

</head>

<body>
    <div class="container bg-default">
        <div class="page">
            <div class="logo"><img src="/assets/img/logo.png"></div>
            <div class="title"><img src="/assets/img/title.png"></div>
            <div class="content">
                <div class="text">
                    @foreach($name as $v)
                        {{ $v['name'] }} <?php echo $v['sex']==1?'先生':'女士';?>：
                    @endforeach
                    <br> 感谢您对会信国旅的支持。
                    <br> 我们很荣幸的宣布：上海会信国际旅行社有限公司作为会唐网旗下唯一资源端采购平台，将于2017年11月16日（周四），在上海市普陀区岚皋路555号品尊国际中心A座10层举办公司的开业典礼。作为上海会信国际旅行社有限公司的一次盛会，我们所有合作的业内同仁及酒店伙伴均亲自参与此盛会
                </div>
                <h4 class="header">开业庆典时间安排如下：</h4>
                <div class="list dot">
                    <div class="item"><span>●</span>PM 13:00-13:30 来宾签到</div>
                    <div class="item"><span>●</span>PM 13:30-14:30 开业典礼仪式</div>
                    <div class="item"><span>●</span>PM 14:30-15:30 茶 歇</div>
                    <div class="item"><span>●</span>PM 15:30-17:00 自由洽谈</div>
                </div>
                <h4 class="header">如有任何问题，请联络：</h4>
                <div class="list">
                    <div class="item">联系人: Angela Zhang </div>
                    <div class="item">电 话: 13701755801</div>
                    <div class="item">上海会信国际旅行社有限公司期待您的光临。</div>
                </div>
                <div class="footer">
                	<span class="center">上海会信国际旅行社有限公司暨全体同仁敬邀 <br>二零一七年 十一月 十六日</span>
                </div>
            </div>
        </div>
        <div class="footer-fixed">
        	<a class="footer-btn" onclick="push();">接受邀请</a>
        </div>
    </div>
    <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script>
        var reg=/ONEPLUS/;
        if(reg.test(navigator.userAgent)){
            alert("因浏览器原因部分功能无法实现")
        }
        function GetQueryString(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)return  unescape(r[2]); return null;
        }
        var id=GetQueryString("j_id");
        function push() {
            $.ajax({
                type: "POST",
                url: "{{ str_replace('index.php/','',url('/h5/confirm')) }}",
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'j_id': id
                }, success: function (data) {
//                        console.log(data)
                    window.location.reload();
                },
                error: function () {
                }
            });
        }
    </script>
</body>

</html>
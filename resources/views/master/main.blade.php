<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{$title}}</title>

        <!--[if lt IE 9]>
        <meta http-equiv="refresh" content="0;ie.html" />
        <![endif]-->

         <!-- base64 替代 shorticon 图片 -->
        <link rel="shortcut icon" type="image/x-icon" href="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/style.change.css?v=4.1.0" rel="stylesheet">
        
    </head>
    <body class="fixed-sidebar full-height-layout gray-bg pace-done" style="overflow:hidden">
        <div id="wrapper">
            <!--上导航栏-->
            @include("master.topNav")
            <!-- 左侧导航布局开始 -->
            @include( 'master.navs')
            <!-- 左侧导航布局结束 -->

            <!-- 页面内容布局开始 -->
            @include( 'master.content' )
            <!-- 页面顶部布局结束 -->

            <!-- 页面内容布局开始 -->
            @include( 'master.right' )
            <!-- 页面右侧布局开始 -->

            <!-- 页面其他布局开始 -->
            <!-- 页面其他布局开始 -->
        </div>
        <script type="text/javascript" src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script type="text/javascript" src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script type="text/javascript" src="/assets/js/hplus.min.js?v=4.1.0"></script>
        <script type="text/javascript" src="/assets/js/contabs.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/pace/pace.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
      {{--  <script type="text/javascript">
            $( document).ready( function()
            {
                $('#logout').on( 'click', function()
                {
                    $.ajax( {
                        url: "/Login/out",
                        data: { '_token':'{{csrf_token()}}' },
                        type: "post",
                        dataType:"json",
                        success: function( response )        // response：响应
                        {

                            if( response['code'] == '1' )
                            {
                                swal({ title: "成功退出！", text: "2秒后自动关闭。", timer: 2000, showConfirmButton: false },function()
                                {
//                                    location.href='/Login/index';
                                });
                            }
                        }
                    } );
                })
            } )
        </script>--}} 
    </body>
</html>
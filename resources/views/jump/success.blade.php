<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>操作成功</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

    </head>

    <body class="gray-bg">
        <div class="middle-box text-center animated fadeInDown" style="max-width: 100%;">
            <!--<h1>操作成功</h1>-->
            <h2 class="font-bold">操作成功</h2>

            <div class="error-desc">
                <br/><span id="count_down">5</span>&nbsp;秒后会自动跳转到首页。</p>
                <p>手动跳转请点击<a href="/" class="text-info">跳转</a></p>
            </div>
        </div>
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
        <script type="text/javascript">
            window.onload = function()
            {
                var url = '/Login/index';

                // 倒计时跳转
                setInterval( function()
                {
                    var _dom = $( '#count_down' );
                    var now = _dom.text();

                    _dom.text( parseInt( now ) - 1 );

                    if( parseInt( now ) - 1 == 0 )
                    {
                        window.location.replace( location.href );          // 清除历史记录
                        window.location.href = url;
                    }
                }, 1000 );
            };
        </script>
    </body>
</html>

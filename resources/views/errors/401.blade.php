<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/500.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:52 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>401</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="middle-box text-center animated fadeInDown">
    <h1>401</h1>
    <h2 class="font-bold">您没有权限访问该页面</h2>

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
        var url = '/';

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


<!-- Mirrored from www.zi-han.net/theme/hplus/500.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:52 GMT -->
</html>

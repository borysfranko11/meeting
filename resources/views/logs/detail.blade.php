<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>H+ 后台主题UI框架 - 查看邮件</title>
        <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
        <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-12 animated fadeInRight">
                    <div class="mail-box-header">
                        <div class="pull-right tooltip-demo">
                            <a href="/Logs/index" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="返回"><i class="fa fa-reply"></i> 返回</a>
                            <a href="javascript: void(0);" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="打印邮件"><i class="fa fa-print"></i> </a>
                            <a href="javascript: void(0);" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="驳回"><i class="fa fa-trash-o"></i> </a>
                        </div>
                        <h2>
                            日志详情
                        </h2>
                        <div class="mail-tools tooltip-demo m-t-md">
                            <h3>
                                <span class="font-noraml">主题： </span>北京胸外科专家研讨会
                            </h3>
                            <h5>
                                <span class="font-noraml">操作人： </span>北京会唐世纪科技有限公司
                            </h5>
                            <h5>
                                <span class="font-noraml">操作人AD： </span>admin
                            </h5>
                        </div>
                    </div>
                    <div class="mail-box">
                        <div class="mail-body">
                            <h3>发布询单成功</h3>
                            <p>
                                会议编码：MEETING-2017-SC-00256
                            </p>

                            <p class="text-right">
                                2017年07月02日(星期二) 晚上8:20
                            </p>
                        </div>
                        <div class="mail-attachment">
                            <p>
                                <span><i class="fa fa-paperclip"></i> 2 个附件 - </span>
                                <a href="javascript: void(0);">下载全部</a> |
                                <a href="javascript: void(0);">预览全部图片</a>
                            </p>

                            <div class="attachment">
                                <div class="file-box">
                                    <div class="file">
                                        <a href="javascript: void(0);">
                                            <span class="corner"></span>

                                            <div class="icon">
                                                <i class="fa fa-file"></i>
                                            </div>
                                            <div class="file-name">
                                                Document_2014.doc
                                            </div>
                                        </a>
                                    </div>

                                </div>
                                <div class="file-box">
                                    <div class="file">
                                        <a href="javascript: void(0);">
                                            <span class="corner"></span>

                                            <div class="image">
                                                <img alt="image" class="img-responsive" src="/assets/img/p1.jpg">
                                            </div>
                                            <div class="file-name">
                                                Italy street.jpg
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="file-box">
                                    <div class="file">
                                        <a href="javascript: void(0);">
                                            <span class="corner"></span>

                                            <div class="image">
                                                <img alt="image" class="img-responsive" src="/assets/img/p2.jpg">
                                            </div>
                                            <div class="file-name">
                                                My feel.png
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="mail-body text-right tooltip-demo">
                            <a href="/Logs/index" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="返回"><i class="fa fa-reply"></i> 返回</a>
                            <a href="javascript: void(0);" class="btn btn-sm btn-white" data-toggle="tooltip" data-placement="top" title="下一条"><i class="fa fa-arrow-right"></i> 下一条</a>
                            <button title="" data-placement="top" data-toggle="tooltip" data-original-title="删除邮件" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> 删除</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>
        <script>
            $( document ).ready( function()
            {
                $( ".i-checks" ).iCheck( {checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"} );
            } );
        </script>
    </body>
</html>

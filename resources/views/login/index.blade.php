<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <title>{{trans('auth.login')}}</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min.css" rel="stylesheet">
        <link href="/assets/css/login.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <meta http-equiv="refresh" content="0;ie.html" />
        <![endif]-->
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>
        <script>
            if(window.top!==window.self){window.top.location=window.location}
        </script>
        <style>
            .select_language{
                background: #333;
            }
            .content_language{
                text-align: right;
            }
        </style>
    </head>

    <body class="signin">
        <div class="signinpanel">
            <div class="row">
                <div class="col-sm-7">
                    <div class="signin-info">
                        <div class="logopanel m-b">
                            <h1 class="text-success">会唐网</h1>
                        </div>
                        <div class="m-b"></div>
                        <h4>欢迎使用 <strong>会唐会议营销平台</strong></h4>
                        <ul class="m-b">
                            <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i>您只需要监控会议进程,会议托管人全程为您管理会议</li>
                            <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i>快速发布询单,五十五万酒店为您在线报价</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-5">

                    {{--
                    <div class="content_language">
                        <select onchange="changelanguage(this.value)" class="select_language">
                            <option value="en" @if(App::getLocale() =='en')selected @endif>English</option>
                            <option value='zh_cn'@if(App::getLocale() == 'zh_cn') selected @endif>简体中文</option>
                        </select>
                    </div>
                    --}}

                    <form method="post" action="/Login/index">
                        <h4 class="no-margins">{{trans('auth.login')}}：</h4>
                        <p class="m-t-md">登录到会议采购管理系统</p>
                        <input type="text" class="form-control uname" name="name" placeholder="{{trans('auth.username')}}" />
                        <input type="password" class="form-control pword m-b" name="password" placeholder="{{trans('auth.password')}}" />
                        {{csrf_field()}}
                        <button class="btn btn-success btn-block">{{trans('auth.login')}}</button>
                    </form>
                </div>
            </div>
            <div class="signup-footer">
                <div class="pull-left">
                    &copy; {{$copyright["desc"]}}版权所有{{$copyright["limit"]}} 京ICP备05018424号
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $( document ).ready( function()
            {
                @if( !empty(session('error')) )
                    toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr["error"]("用户名或密码错误", "警告");
                @endif


            } );

            function changelanguage(val){
                $.ajax({
                    type :'get',
                    url :'/Login/ins',
                    data:{
                        language :val
                    },
                    dataType :'json',
                    success:function(res){

                            window.location.reload();
                    }
                })
            }
        </script>
    </body>
</html>

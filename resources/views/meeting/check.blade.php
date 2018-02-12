<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>我的会议</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/style.extend.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/plugins/float-toolbar/core.css" rel="stylesheet">


        <style type="text/css">
            .ibox-title{border-width: 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-color{color: #00b6b8;}

            .dot:before{content: ''; display: inline-block; margin-top: 5px; margin-right: 8px; width: 6px; height: 6px; vertical-align: top; background: #00B6B9;}
            .dashed_hr{border-top: 1px dashed #e6e5e5;}
            .cover-ibox-color{border-top-width: 0; background-color: #f5f5f5;}
            .form-group{display: flex;}
        </style>
    </head>

    <body class="gray-bg" style="background-color: #f2f7f8;">
        <div id="page_top" class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">
                                会议查看
                                <a href="/Rfp/index" class="btn btn-outline btn-info pull-right">
                                    <i class="fa fa-reply"></i> 返回
                                </a>
                            </h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <strong>会议查看</strong>
                                </li>
                            </ol>
                        </div>
                        <div class="ibox-content">
                            <div id="meeting_base" class="ibox float-e-margins">
                                <div class="ibox-content cover-ibox-color">
                                    <h3 class="hx-tag-color">基础信息</h3>
                                    <hr class="dashed_hr">
                                    <form class="form-horizontal">
                                    <input type="hidden" id="rfp_id" value="{{ $data["base"][0]["rfp_id"] }}" />
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">会议名称</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["meeting_name"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">                                                 
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["meeting_name"] }}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">会议类型</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["meeting_type_desc"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["meeting_type_desc"] }}</span>
                                                    </div>
                                                </div>
                                                <hr class="dashed_hr">

                                                @if( !empty( $data["base"][0]["time_extend"] ) )
                                                    <div class="form-group">
                                                        @foreach ($data["base"][0]["time_extend"] as $content)
                                                            <div class="col-sm-6 m-b-md">
                                                                <span class="text-muted dot">会议开始时间</span>
                                                                <!-- <div class="m-sm"></div>
                                                                <span class="text-primary p-l-sm">{{ $content["start_time"] }}</span> -->
                                                            </div>
                                                            <div class="col-sm-6 m-b-md">
                                                                <span class="text-primary p-l-sm">{{ $content["start_time"] }}</span>
                                                            </div>
                                                            <div class="col-sm-6 m-b-md">
                                                                <span class="text-muted dot">会议结束时间</span>
                                                                <!-- <div class="m-sm"></div>
                                                                <span class="text-primary p-l-sm">{{ $content["end_time"] }}</span> -->
                                                            </div>
                                                            <div class="col-sm-6 m-b-md">
                                                                <span class="text-primary p-l-sm">{{ $content["end_time"] }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <hr class="dashed_hr m-t-none">

                                                <div class="form-group m-b-md">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">行程开始时间</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["trip_start_time"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["trip_start_time"] }}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">行程结束时间</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["trip_end_time"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["trip_end_time"] }}</span>
                                                    </div>
                                                </div>
                                                <hr class="dashed_hr">

                                                <div class="form-group m-b-md">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">会议地点</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["provincedesc"] }}</span>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["citydesc"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["provincedesc"] }}</span>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["citydesc"] }}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">会议申请</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["department_name"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["department_name"] }}</span>
                                                    </div>
                                                </div>
                                                <hr class="dashed_hr">

                                                <div class="form-group m-b-md">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">成本中心</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["marketorgdesc"] }}</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">{{ $data["base"][0]["marketorgdesc"] }}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">会议日程</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="p-l-sm">
                                                            <a href="{{ isset($data["base"][0]["abroad_file"]) ? $data["base"][0]["abroad_file"] : 'javascript: void(0);' }}" style="color: #00B6B9;">
                                                                <i class="fa fa-download"></i> 下载会议日程
                                                            </a>
                                                        </span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="p-l-sm">
                                                            <a href="{{ isset($data["base"][0]["abroad_file"]) ? $data["base"][0]["abroad_file"] : 'javascript: void(0);' }}" style="color: #00B6B9;">
                                                                <i class="fa fa-download"></i> 下载会议日程
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="meeting_budget" class="ibox float-e-margins">
                                <div class="ibox-content cover-ibox-color">
                                    <h3 class="hx-tag-color">会议预算</h3>
                                    <hr class="dashed_hr">
                                    <form class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group" style="margin-bottom: 0;">
                                                @if( !empty( $data["budget"] ) )
                                                    @foreach ($data["budget"] as $detail)
                                                        <div class="col-sm-6 m-b-md">
                                                            <span class="text-muted dot">{{ $detail["fundtypedese"] }}</span>
                                                            <!-- <div class="m-sm"></div>
                                                            ￥{{ $detail["budgetamount"] }} -->
                                                        </div>
                                                        <div class="col-sm-6 m-b-md">
                                                            ￥{{ $detail["budgetamount"] }}
                                                        </div>
                                                    @endforeach
                                                @else
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="meeting_humans" class="ibox float-e-margins">
                                <div class="ibox-content cover-ibox-color">
                                    <h3 class="hx-tag-color">参会人员</h3>
                                    <hr class="dashed_hr">
                                    <form class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12 m-b-md">
                                                <div class="form-group m-b-md">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">客户参会人数</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">
                                                            {{ isset($data["base"][0]["clientele_num"]) ? $data["base"][0]["clientele_num"] : '0' }} 人
                                                        </span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">
                                                            {{ isset($data["base"][0]["clientele_num"]) ? $data["base"][0]["clientele_num"] : '0' }} 人
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">企业内部</span>
                                                       <!-- <div class="m-sm"></div>
                                                       <span class="text-primary p-l-sm">
                                                           {{ isset($data["base"][0]["within_num"]) ? $data["base"][0]["within_num"] : '0' }} 人
                                                       </span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">
                                                            {{ isset($data["base"][0]["within_num"]) ? $data["base"][0]["within_num"] : '0' }} 人
                                                        </span>
                                                    </div>
                                                </div>
                                                <hr class="dashed_hr">

                                                <div class="form-group" style="margin-bottom: 0;">
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">第三方大会预订</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="text-primary p-l-sm">
                                                            {{ isset($data["base"][0]["nonparty_num"]) ? $data["base"][0]["nonparty_num"] : '0' }} 人
                                                        </span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-primary p-l-sm">
                                                            {{ isset($data["base"][0]["nonparty_num"]) ? $data["base"][0]["nonparty_num"] : '0' }} 人
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="text-muted dot">参会人员</span>
                                                        <!-- <div class="m-sm"></div>
                                                        <span class="p-l-sm" style="color: #00B6B9;">
                                                            <a href="{{ isset($data["base"][0]["url"]) ? $data["base"][0]["url"].'?'.$data["base"][0]["rfp_id"] : 'javascript: void(0);' }}" style="color: #00B6B9;">
                                                                <i class="fa fa-download"></i> 参会人员名单
                                                            </a>
                                                        </span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="p-l-sm" style="color: #00B6B9;">
                                                            <a  onclick="pushid()" style="color: #00B6B9;">
                                                                <i class="fa fa-download"></i> 参会人员名单
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="ibox float-e-margins">
                                <div id="meeting_bottom" style=" text-align:center">
                                    <button id="shenhe" class="btn btn-info " type="button" >通过</button>
                                    <button id="bohui" class="btn btn-info " type="button" style="margin-left: 160px;">驳回</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jc-float-toolbar">
            <article>
                <section>
                    <a id="to_top" href="#page_top" class="caption"><i class="fa fa-chevron-up"></i></a>
                    <div class="detail">顶部</div>
                </section>
                <section>
                    <a href="#meeting_base" class="caption"><i class="fa fa-bookmark-o"></i></a>
                    <div class="detail">基础信息</div>
                </section>
                <section>
                    <a href="#meeting_budget" class="caption"><i class="fa fa-credit-card"></i></a>
                    <div class="detail">会议预算</div>
                </section>
                <section>
                    <a href="#meeting_humans" class="caption"><i class="fa fa-group"></i></a>
                    <div class="detail">参会人员</div>
                </section>
                <section>
                    <a href="#meeting_humans" class="caption"><i class="fa fa-chevron-down"></i></a>
                    <div class="detail">底部</div>
                </section>
            </article>
        </div>

        <form id="pushid" display="none" action="{{ URL('join/export') }}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token() }}">
            <input type="hidden" name="join_id" value="{{  $data["ids_str"] }}">
            <input type="hidden" value="{{ $data["base"][0]['rfp_id'] }}" name="rfp_id">
        </form>
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/js/plugins/layer/layer.min.js"></script>
        <script type="text/javascript">
            function pushid(){
                console.log(localStorage.postArrId);
                var push=$("#pushid");
                if(localStorage.postArrId){
                    push.find('input[name="join_id"]').val(localStorage.postArrId);
                }
                push.submit();

            }
            $( document ).ready( function()
            {
                // 右侧锚点导航初始化
                $( '.jc-float-toolbar' ).find( 'article section' ).each( function()
                {
                    var _that = $( this );

                    // 点击滚动到对应锚点
                    _that.click( function()
                    {
                        var anchor = _that.find( '.caption' ).attr("href");

                        if( anchor.indexOf( 'javascript' ) < 0 )
                        {
                            var top = $( _that.find( '.caption' ).attr("href") ).offset().top + "px",
                                height = $( _that.find( '.caption' ).attr("href") ).height();

                            // 非顶部判断
                            if( anchor.indexOf( 'top' ) < 0 )
                            {
                                top = parseInt( top ) - parseInt( $( window ).height() / 2 ) + height;
                            }

                            $( "html, body" ).animate( {
                                scrollTop: top
                            }, {
                                duration: 500,
                                easing: "swing"
                            } );
                        }
                    } );

                    // 锚点列表绑定悬浮时间
                    _that.hover(
                        function()
                        {
                            _that.find( '.detail' ).show().stop().animate( {
                                right: "28"
                            }, 500 );
                        },
                        function()
                        {
                            _that.find( '.detail' ).stop().animate( {
                                right: "-50"
                            }, {
                                duration: 500,
                                easing: "swing",
                                complete: function()
                                {
                                    // 结束
                                }
                            } );
                        }
                    );
                } );
            } );

            //点击审核按钮
            var rfg = $("#rfp_id").val()
            shenhe.onclick=function(){           
             $.ajax({  
             type:'get', 
             url:'/Meeting/checkMeeting', 
             data:{
               rfp_id:rfg ,     //,必填
                is_pass:1   //是否审核通过0未通过1通过，必填
             },                         
             dataType:'json',    
             success:function (data) {  
             /*alert("success:"+data); */ 
               if (data["Success"]==true) {
                    swal( {
                        title: "成功",
                        text: "恭喜您，审核已通过！",
                        type: "success",
                        confirmButtonText: "确定"
                    },function()
                    {
                        location.href = '/Rfp/index';
                    } );
               }             
             },  
             error:function (err) {  
               
             } 
             });
         }
         //点击驳回按钮
         //
         //prompt层
           /* parent.layer.prompt({
                title: '输入任何口令，并确认',
                formType: 1 //prompt风格，支持0-2
            }, function(pass){
                layer.prompt({title: '随便写点啥，并确认', formType: 2}, function(text){
                    layer.msg('演示完毕！您的口令：'+ pass +' 您最后写下了：'+ text);
                });
            });*/

            bohui.onclick=function(){ 
                swal({
                        title: "驳回",
                        text: "请输入驳回原因:",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "驳回原因"
                    }, function(inputValue) {
                        if (inputValue === false)
                            return false;
                        if (inputValue === "") {
                            swal.showInputError("请输入!");
                            return false
                        }
                        $.ajax({
                             type:'get', 
                             url:'/Meeting/checkMeeting', 
                             data:{
                                rfp_id:rfg ,     //,必填
                                is_pass:0,   //是否审核通过0未通过1通过，必填
                                reason:inputValue,
                             },                         
                             dataType:'json',    
                             success:function (data) {
                                if (data["Success"]==true) {
                                    swal("驳回成功" , "success");
                                }else{
                                    swal("驳回失败:"+data['Msg'] , "warning");return false;
                                }    
                                window.location.href="/Rfp/index";
                             },
                             error:function (err) {  
                            
                                    swal("网络请求失败" , "warning");
                                    window.location.href="/Rfp/index";
                               
                            } 
                        });                       
                    });

                  }
        </script>
    </body>
</html>
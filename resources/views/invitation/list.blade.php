<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="rfp-token" content="{{ csrf_token() }}" />
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- <link href="/assets/css/plugins/webuploader/webuploader.css" type="text/css" rel="stylesheet"> -->
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/creatMeeting/creat.css" rel="stylesheet">
{{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .breadcrumb{
            font-size:13px;
        }
        .search{
            padding: 20px 25px 25px;
        }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="ibox-title">
        <h2 class="hx-tag-extend">
            制作邀请函
            <a href="{{url('join/index')}}?rfp_id={{$url['rfp_id']}}" class="btn btn-outline btn-info pull-right">
                <i class="fa fa-reply"></i> 返回
            </a>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript: void(0);">会议列表</a>
            </li>
            <li>
                <a>参会人管理</a>
            </li>
            <li>
                <strong>制作邀请函</strong>
            </li>
        </ol>
    </div>
    <div class="ibox-content">
            {{-- 搜索栏 --}}
        <div class="">
            <div class="panel ">
                <div class="panel-heading">
                    <div class="">
                        <div class="search">
                            <form role="form" class="form-inline" action="#" method="post">
                                {{ csrf_field() }}
                                <span>邀请函名称：</span>
                                <div class="form-group">
                                    <label for="exampleInputPassword2" class="sr-only">邀请函名称</label>
                                    <input type="text" placeholder="" value="{{empty($url['name'])?'':$url['name']}}" id="exampleInputPassword2" name="name" class="form-control">
                                </div>

                                <button class="btn btn-primary" type="submit">搜索</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="tab-4" class="tab-pane active">

                        </div>
                    </div>
                    <div class=" float-e-margins">
                        <div class="">
                            <div class="ibox-tools text-right">
                                <a  data-rfp="{{ $url['rfp_id'] }}" data-tpl="0" onclick="addOrUpdate(this)">
                                    <span class="text-success ">添加邀请函</span>
                                </a>
                                <br/>
                                <p class="text-right">提示：如需定制邀请函模版，请联系＊＊＊＊</p>
                            </div>
                        </div>
                        {{-- 列表   --}}
                        <div class="">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>邀请函名称</th>
                                    <th>制作人</th>
                                    <th>制作时间</th>
                                    <th>最后修改时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse( $tpl_list as $tpl)
                                    <tr>
                                        <td><a href="{{url('/Invitation/index')}}?tpl_id={{ $tpl['tpl_id'] }}&rfp_id={{$url['rfp_id']}}">{{ $tpl['name'] }}</a></td>
                                        <td>{{ $tpl['login_name'] }}</td>
                                        <td>{{ $tpl['create_time'] }}</td>
                                        <td>{{ empty($tpl['update_time'])?'0000-00-00 00:00:00':$tpl['update_time'] }}</td>
                                        <td><a  data-rfp="{{ $url['rfp_id'] }}" data-tpl="{{ $tpl['tpl_id'] }}" onclick="addOrUpdate(this)">修改</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"> 没有任何相关数据</td>

                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                            <div class="">
                                <div class="text-center" >
                                    {!! $tpl_list->appends($url)->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/jquery.form.min.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/tool.js"></script>
<script>
    function  addOrUpdate( obj )
    {
        var _this = $(obj);
        var rfp_id,tpl_id,title;
        rfp_id = _this.attr('data-rfp');
        tpl_id = _this.attr('data-tpl');
        title = tpl_id>0 ? '修改邀请函':'添加邀请函';
        parent.layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: "{{ url('/Invitation/iframe') }}?rfp_id="+rfp_id+"&tpl_id="+tpl_id,
            success:function(layero,index){
//                localStorage.removeItem('oftenId');
            },
            end:function(){
                    location.reload();
            }
        });
    }


</script>
</body>

</html>

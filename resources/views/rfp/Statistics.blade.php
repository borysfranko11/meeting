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
        .pie{
            margin-top:10%;
        }
        .borderNone{
            border: none;
        }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">
                        数据统计
                        <a href="{{url('Rfp/index')}}" class="btn btn-outline btn-info pull-right">
                            <i class="fa fa-reply"></i> 返回
                        </a>
                    </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">会议列表</a>
                        </li>
                        <li>
                            <strong>数据统计</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content clear">
                    <div class="col-sm-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class=""><a  href="{{ url('/join/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false"> 参会人员列表</a>
                                </li>
                                <li class=""><a href="{{ url('/Confirm/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">出行管理</a>
                                </li>
                                <li class=""><a href="{{ url('Action/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">住宿管理</a>
                                </li>
                                <li class=""><a href="{{ url('UserCar/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">用车管理</a>
                                </li>
                                <li class="active"><a href="{{ url('/Statistics/list') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="true">数据统计</a>
                                </li>
                            </ul>
                            {{--选项卡 1  数据统计--}}
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        {{--搜索栏--}}

                                        <div class="row">
                                            <form action="{{ url('/Statistics/list') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="rfp_id" value="{{  $url['rfp_id'] }}">
                                                <div class="form-group col-sm-3 m-b-xs">
                                                    <label class="col-sm-4 control-label">姓名</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" value="{{ isset($url['name'])?$url['name']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4 m-b-xs">
                                                    <label class="col-sm-4 control-label">手机号码</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="phone" value="{{ isset($url['phone'])?$url['phone']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <button class="btn btn-primary" type="submit" >搜索</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="ibox-content borderNone ">
                                            <p class="text-right">
                                                {{--                                <a href="{{ URL('/UserCar/template') }}?rfp_id={{ $url['rfp_id'] }}">批量导出</a><span>|</span>--}}
                                                <a href="{{ URL('/Statistics/statistics') }}?rfp_id={{ $url['rfp_id'] }}">批量导出</a>
                                            </p>
                                        </div>
                                        {{--内容展示--}}
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>姓名</th>
                                                    <th>手机号码</th>
                                                    <th>总费用</th>
                                                    <th>住宿费用</th>
                                                    <th>餐饮费用</th>
                                                    <th>用车费用</th>
                                                    <th>去程日期</th>
                                                    <th>出行方式</th>
                                                    <th>航班号／车次号</th>
                                                    <th>出发地</th>
                                                    <th>目的地</th>
                                                    <th>价格</th>
                                                    <th>返程日期</th>
                                                    <th>出行方式</th>
                                                    <th>航班号／车次号</th>
                                                    <th>出发地</th>
                                                    <th>目的地</th>
                                                    <th>价格</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse( $user_list as $k => $user)
                                                    <tr>
                                                        @for( $i = 0 ; $i < 18 ;$i ++ )
                                                            <td>{{ $user[$i] }}</td>
                                                        @endfor
                                                    </tr>
                                                @empty
                                                    <td colspan="18"><h5 class="text-center">没有任何确认数据！</h5></td>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- 分页--}}
                                        <div class="ibox-content text-center">
                                            <div  class="text-center" >
                                                {{--<a>分页</a>--}}
                                            </div>
                                            <ul id="page" class="pagination" style="margin: 0 auto"></ul>
                                        </div>

                                    </div>
                                    {{--数据表格 --}}
                                    <div class="">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>会议预计人数{{$chart_data['all']}}／已确认人数{{$chart_data['confirm']}}/已签到人数{{$chart_data['sign']}}</h5>
                                            </div>
                                            <div class="ibox-content" id="confirm">
                                              <div class="row">
                                                  <div class="col-sm-3 text-center pie">
                                                      <canvas id="predictArea" width="128" height="130" />
                                                  </div>
                                                  <div class="col-sm-8 col-sm-offset-1" style="max-width: 600px;">
                                                      <canvas id="predictLine" />
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="ibox-content" id="sign">
                                                <div class="row">
                                                    <div class="col-sm-3 text-center pie">
                                                        <canvas id="confirmArea" width="128" height="130" />
                                                    </div>
                                                    <div class="col-sm-8 col-sm-offset-1"  style="max-width: 600px;">
                                                        <canvas id="confirmLine" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
{{--批量导入--}}



{{--批量导出--}}
<form id="pushid" display="none" action="{{ URL('/UserCar/export') }}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token() }}">
    <input type="hidden" name="join_id">
    {{--<input type="hidden" value="{{ $url['rfp_id'] }}" name="rfp_id">--}}
</form>
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
<script src="/assets/lib/chart/Chart.js"></script>

<script src="/assets/js/tool.js"></script>
<script>
    var tool=new Tool;
    if("{{ $sum_page }}">1){
        tool.paging("#page","{{ $sum_page }}",'{{$url_str}}',"{{$url["page"]}}")
    }
</script>
<script>
    var Data=[],
        all=[],
        allTime=[];
    @foreach($chart_data['s_chart'] as $key => $data )
        Data.push("{{$data}}");
    @endforeach
    @foreach($chart_data['c_chart'] as $k => $val )
    all.push("{{$val['count']}}");
    allTime.push("{{$val['c_time']}}");
    @endforeach

console.log(Data)
    var predictData=Data.splice(8,13);

    var allNum="{{$chart_data['all']}}",
        confirmNum="{{$chart_data['confirm']}}",
        signNum='{{$chart_data['sign']}}',
        cp=parseInt(confirmNum/allNum*1000),
        sp=parseInt(signNum/allNum*1000)
    ;
console.log(cp);
    var ctx1=document.getElementById("predictArea").getContext("2d");
        ctx1.lineWidth=10;
        ctx1.strokeStyle = "#1ab394";
        ctx1.beginPath();
        ctx1.arc(64,65,54,-0.25*2*Math.PI,(confirmNum/allNum-0.25)*2*Math.PI);
        ctx1.stroke();
        ctx1.font="28px Arial ";
        ctx1.textAlign="center";
        ctx1.fillStyle="#2CC3B0";
        ctx1.fillText(isNaN(cp/10)?'0%':cp/10+"%",64,65);
        ctx1.font="16px Arial";
        ctx1.fillStyle="#CCCCCC";
        ctx1.fillText("确认率",64,85);
        var ctx2=document.getElementById("confirmArea").getContext("2d");
        ctx2.lineWidth=10;
        ctx2.strokeStyle = "#1ab394";
        ctx2.beginPath();
        ctx2.arc(64,65,54,-0.25*2*Math.PI,(signNum/allNum-0.25)*2*Math.PI);
        ctx2.stroke();
        ctx2.font="28px Arial ";
        ctx2.textAlign="center";
        ctx2.fillStyle="#2CC3B0";
        ctx2.fillText(isNaN(cp/10)?'0%':sp/10+"%",64,65);
        ctx2.font="16px Arial";
        ctx2.fillStyle="#CCCCCC";
        ctx2.fillText("签到率",64,85);

    var config2= {
        type: 'line',
        data: {
            labels: ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00","15:00","16:00","17:00","18:00","19:00","20:00"],
            datasets: [{
                label:"",
                borderColor : "#1ab394",
                backgroundColor : "#1ab377",
                data: predictData,
                fill: false
            }]
        },
        options: {
            responsive: true,
            title:{
                display:false,
                text:'Chart.js Line Chart'
            },
            scaleLabel:{
                display:false
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    allowDecimals: false,
                    display: true,
                    ticks: {
                        min: 0,
                        stepSize: 1
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Value'
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0.000001
                }
            },
            pointDot : false
        }
    };
        var config3= {
            type: 'line',
            data: {
                labels: allTime,
                datasets: [{
                    label:"",
                    borderColor : "#1ab394",
                    backgroundColor : "#1ab377",
                    data: all,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:false,
                    text:'Chart.js Line Chart'
                },
                scaleLabel:{
                    display:false
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: 0,
                            stepSize: 1
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scaleOverride : false,
                scaleSteps : null,
                scaleStepWidth : null,
                scaleStartValue : null,
            }
        };


        var line1 = document.getElementById("predictLine").getContext("2d");
        var line2 = document.getElementById("confirmLine").getContext("2d");
        window.myLine = new Chart(line1, config3);
        window.myLine = new Chart(line2, config2);


</script>

</body>

</html>

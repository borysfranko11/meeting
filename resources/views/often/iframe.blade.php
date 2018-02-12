<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
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
    <script src="/assets/plugins/vue.min.js"></script>
    <style>
        .btn{
            margin:  0 25px;
        }
        .layui-layer-btn{
            text-align: center;
        }
    </style>
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
</head>
<body class="">
    <div class="ibox">

        <div class="ibox-content">
            <form role="form" class="form-inline" action="/often/iframe" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail2" >姓名：</label>
                    <input type="text" name="name" placeholder="" id="exampleInputEmail2" class="form-control" value="{{  $url['name'] }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2" >手机号码：</label>
                    <input type="text" name="phone" placeholder="" id="exampleInputPassword2" class="form-control" value="{{  $url['phone'] }}">
                </div>

                <button class="btn btn-white" type="submit">搜索</button>
            </form>

            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" value="{{ $user_ids }}" name=""></th>
                    <th>姓名</th>
                    <th>信息状态</th>
                    <th>性别</th>
                    <th>所在城市</th>
                    <th>单位名称</th>
                    <th>职称／职位</th>
                    <th>手机号码</th>
                    <th>身份证号/护照号</th>
                    <th>邮箱</th>
                    <th>意向房型</th>
                </tr>
                </thead>
                <tbody>
                    @forelse( $users as $user)
                        @if(in_array($user->often_id,$exists))
                            <tr bgcolor="">
                                <td><input type="checkbox" value="" name="" disabled="disabled"></td>
                                <td>{{  $user->name }}</td>
                                <td>{{  ($user->status == 1 )?'正常':'更改' }}</td>
                                <td>{{  ($user->sex == 1 )?'男':'女' }}</td>
                                <td>{{  $user->city }}</td>
                                <td>{{  $user->company }}</td>
                                <td>{{  $user->duty }}</td>
                                <td>{{  $user->phone }}</td>
                                <td>{{  $user->id_card }}</td>
                                <td>{{  $user->email }}</td>
                                <td>{{  $user->room_type }}</td>
                            </tr>
                        @else
                            <tr>
                                <td><input type="checkbox" value="{{ $user->often_id }}" name="often_id" ></td>
                                <td>{{  $user->name }}</td>
                                <td>{{  ($user->status == 1 )?'正常':'更改' }}</td>
                                <td>{{  ($user->sex == 1 )?'男':'女' }}</td>
                                <td>{{  $user->city }}</td>
                                <td>{{  $user->company }}</td>
                                <td>{{  $user->duty }}</td>
                                <td>{{  $user->phone }}</td>
                                <td>{{  $user->id_card }}</td>
                                <td>{{  $user->email }}</td>
                                <td>{{  $user->room_type }}</td>
                            </tr>
                        @endif

                    @empty
                        <tr>
                            <td colspan="10" class="text-center">无常用参会人</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="col-sm-12  text-center">
                {!! $users->appends($url)->render() !!}
            </div>

        </div>
    </div>
<input id="rfp_id" type="hidden" value="123">
<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/plugins/layer/layer.js"></script>
<script src="/assets/js/tool.js"></script>
<script>
    var oTable=$("table"),
        oTBody=$("tbody"),
        postArrId=[],
        tool=new Tool,
        index = parent.layer.getFrameIndex(window.name);
    tool.allChecked(oTable,'oftenId')

</script>

</body>

</html>

 <!DOCTYPE html>
    <html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
        <meta name="description" content="">
        <meta http-equiv="cache-control" content="no-cache">
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
</head>
<body>
<table class="table table-striped">
    <thead>
    <th>行程</th>
    <th>出行方式</th>
    <th>出行时间</th>
    <th>出发地</th>
    <th>目的地</th>
    <th>航班号/车次</th>
    <th>仓位级别/座位等级</th>
    <th>机票/火车票价格（元）</th>
    </thead>
    <tbody>
        @foreach($travel as $k=>$v)
            <tr>
                <td>{{  ($v['t_way']==1 || $v['t_way']== 2 )?($v['t_way']==1?'去程':'返程'):'无效' }}</td>
                <td>{{  ($v['t_type']==1 || $v['t_type']== 2 )?($v['t_type']==1?'飞机':'火车'):'无效' }}</td>
                <td>{{$v["begin_time"]}}</td>
                <td>{{$v["begin_city"]}}</td>
                <td>{{$v["end_city"]}}</td>
                <td>{{$v["t_code"]}}</td>
                <td>{{$v["t_level"]}}</td>
                <td>{{$v["t_money"]}}</td>
            </tr>
            @endforeach
    </tbody>
</table>
<script>
</script>
</body>
 </html>
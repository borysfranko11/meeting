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
{{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .must{
            padding-top: 20px;
        }
        .must label:before{
            content:"*";
            color: red;
        }
        .time input:after{
            content: "";

        }
        code{
            height: 2em;
            line-height: 1.7em;
        }
        .money:before{
            content:'￥';
            position: absolute;
            top: 25%;
            left: 1.2em;
        }
        .btn{
            margin: 0 10px;
        }
        .form-group{
            margin-bottom:0 ;
        }

    </style>

</head>
<body class="gray-bg">
<div class="row">
    <div class="col-sm-offset-1 must">
        <form>
            <input type="hidden" name="t_id" value="{{ isset($data)?$data['t_id']:'' }}">
            <input type="hidden" name="join_id" value="{{ isset($data)?$data['join_id']:$join_id }}">
            <div class="form-group row">
                <label class="col-sm-3 control-label">行程：</label>
                <div class="col-sm-8">
                    <select class="form-control m-b" name="t_way" id="t_way">
                        <option value="0">请选择</option>
                        <option value="1" {{ (isset($data) && $data['t_way'] == 1 )?'selected':'' }}>去程</option>
                        <option value="2" {{ (isset($data) && $data['t_way'] == 2 )?'selected':'' }}>返程</option>
                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">出行方式：</label>
                <div class="col-sm-8">
                    <select class="form-control m-b" name="t_type" id="t_type">
                        <option value="0">请选择</option>
                        <option value="1" {{ (isset($data) && $data['t_type'] == 1 )?'selected':'' }}>飞机</option>
                        <option value="2" {{ (isset($data) && $data['t_type'] == 2 )?'selected':'' }}>火车</option>
                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label">出发日期：</label>
                <div class="layui-input-inline col-sm-4">
                    <input name="date" class="layui-input form-control" id="test-limit1" placeholder="yyyy-MM-dd" lay-key="20" type="text" value="{{ isset($data)?date('Y-m-d',strtotime($data['begin_time'])):date('Y-m-d') }}">
                    <input name="date" type="hidden" value="{{ isset($data)?date('Y-m-d',strtotime($data['begin_time'])):date('Y-m-d') }}"/>
                </div>

                <div class="layui-input-inline col-sm-4">
                    <input name="time" class="layui-input form-control" id="test-limit3" placeholder="HH:mm:ss" lay-key="22" type="text"  value="{{ isset($data)?date('H:i',strtotime($data['begin_time'])):'00:00' }}">
                    <input name="time" type="hidden" value="{{ isset($data)?date('H:i',strtotime($data['begin_time'])):'00:00' }}"/>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>

            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">出发地：</label>
                <div class="col-sm-8">
                    <select class="chosen-select form-control m-b" name="begin_city" id="begin_city">
                        <option value="0">请选择</option>
                        @forelse( $city as $v )
                            <option value="{{ $v }}" {{ (isset($data) && $data['begin_city'] == $v )?'selected':'' }}>{{ $v }}</option>
                        @empty
                            <option value="0"  >没有任何城市</option>
                        @endforelse
                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">目的地：</label>
                <div class="col-sm-8">
                    <select class="chosen-select form-control m-b" name="end_city" id="end_city">
                        <option value="0">请选择</option>
                        @forelse( $city as $v )
                            <option value="{{ $v }}" {{ (isset($data) && $data['end_city'] ==  $v )?'selected':'' }}>{{ $v }}</option>
                        @empty
                            <option value="0"  >没有任何城市</option>
                        @endforelse
                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">航班号/车次号：</label>
                <div class="col-sm-8">
                    <input id="cemail" class="form-control" name="t_code" required="" aria-required="true" type="text" value="{{ isset($data)?$data['t_code']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">舱位级别/座位等级：</label>
                <div class="col-sm-8">
                    <input id="cemail" class="form-control" name="t_level" required="" aria-required="true" type="text" value="{{ isset($data)?$data['t_level']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">机票/火车票价格（元）：</label>
                <div class="col-sm-8 money">
                    <input id="cemail" class="form-control" name="t_money" required="" aria-required="true" type="text" value="{{ isset($data)?$data['t_money']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group text-center row">
                <button class="btn btn-primary" type="button" onclick="commit()">确定</button>
                <button class="btn" type="button" onclick="closeLayer()">取消</button>
            </div>

        </form>
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
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>

<script>

        $(".chosen-select").chosen();
        //限定可选日期
        var myDate = new Date;
        var year = myDate.getFullYear();//获取当前年
        var yue = myDate.getMonth() + 1;//获取当前月
        var date = myDate.getDate();//获取当前日
        var now = year + '-' + yue + '-' + date,
            flag = {};
        var ins22 = laydate.render({
            elem: '#test-limit1'
            , min: now
            , max: '2080-10-14',
            btns: ['now', 'confirm']
            , done: function (date) {
                $('input[name="date"]').val(date)
            }
        });
        //限定可选时间
        laydate.render({
            elem: '#test-limit3',
            type: 'time',
            format: 'HH:mm',
            btns: ['confirm'],
            done: function (date) {
                $('input[name="time"]').val(date);
            }
        });
        function closeLayer() {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index)
        }

        $('form').on("blur", "input,select", function () {
            if(this.name==""){
                if($("#begin_city").val()==0){
                    $("#begin_city").parents('.form-group').children('code').html('请填写');
                    flag['begin_city'] = false;
                    return
                }else {
                    $("#begin_city").parents('.form-group').children('code').html('');
                    flag['begin_city'] = true;
                }
                if($("#end_city").val()==0){
                    $("#end_city").parents('.form-group').children('code').html('请填写');
                    flag["end_city"] = false;
                    return
                }else{
                    $("#end_city").parents('.form-group').children('code').html('');
                    flag['end_city'] = true;
                }
                return false
            };
            var ele = $(this),
                val = ele.val(),
                text = /[0-9a-zA-Z\u4e00-\u9fa5]/,
                money = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
            if (ele.attr('name') === "t_money") {
                if (money.test(val)) {
                    ele.parents('.form-group').children('code').html('');
                } else {
                    ele.parents('.form-group').children('code').html('请填写');
                    flag[ele.attr('name')] = false;
                    return
                }
            }
            else if (ele.attr('name') === 'date' || ele.attr('name') === 'time') {
                ele.parents('.form-group').children('code').html('');
            }
            else if (ele.attr('name') === 't_type') {

                if (val === "0") {
                    ele.parents('.form-group').children('code').html('请填写');
                    flag[ele.attr('name')] = false;
                    return
                } else {
                    ele.parents('.form-group').children('code').html('');
                }
            } else {
                if (text.test(val)) {
                    ele.parents('.form-group').children('code').html('');
                } else {
                    ele.parents('.form-group').children('code').html('请填写');
                    flag[ele.attr('name')] = false;
                    return
                }
            }
            flag[ele.attr('name')] = true;
        });

        function commit() {

            var join_id, t_id, t_way, t_type, begin_time, begin_city, end_city, t_code, t_level, t_money, date, time;
            join_id = $('input[name="join_id"]').val();
            t_id = $('input[name="t_id"]').val();
            t_way = $('#t_way').val();
            t_type = $('#t_type').val();
            date = $('input[name="date"]').val();
            time = $('input[name="time"]').val();
            begin_time = date + ' ' + time;
            begin_city = $('#begin_city').val();
            end_city = $('#end_city').val();
            t_code = $('input[name="t_code"]').val();
            t_level = $('input[name="t_level"]').val();
            t_money = $('input[name="t_money"]').val();
            console.log(end_city);
            if (t_way && t_type && begin_time && begin_city != 0 && end_city != 0 && t_code && t_level && t_money) {
                for (k in flag) {
                    if (!flag[k]) {
                        console.log(flag);
                        parent.layer.msg("表订单有误");
                        return false
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "/Manage/addOrUpdateTra",
                    data: {
                        '_token': '<?php echo csrf_token() ?>',
                        'join_id': join_id,
                        't_id': t_id,
                        't_way': t_way,
                        't_type': t_type,
                        'begin_time': begin_time,
                        'begin_city': begin_city,
                        'end_city': end_city,
                        't_code': t_code,
                        't_level': t_level,
                        't_money': t_money
                    }, success: function (data) {
                        if (typeof data == "string") {
                            data = $.parseJSON(data)
                        }
                        if (data.error) {
                            parent.layer.closeAll();
                            loaction.reload();
                        } else {
                            parent.layer.msg(data.msg);

                        }
                    },
                    error: function () {
                    }
                })
                return
            }
            parent.layer.msg("表订单有误")
        }

</script>
</body>

</html>

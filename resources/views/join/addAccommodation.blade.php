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
        .borderNone{
            border: none;
        }
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
        button{
            margin: 0 10px;
        }

    </style>
</head>


<body class="gray-bg">
<div >
    <div class="col-sm-offset-1 must">
        <form >
            <input type="hidden" name="a_id" value="{{ isset($data)?$data['a_id']:'' }}">
            <input type="hidden" name="join_id" value="{{ isset($data)?$data['join_id']:$join_id }}">
            <div class="form-group row">
                <label class="col-sm-3 control-label">酒店名称：</label>
                <div class="col-sm-8">
                    <input id="cname" name="a_name" minlength="2" class="form-control" required="" aria-required="true" readonly type="text" value="{{ $hotole_name }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">入住房型：</label>
                <div class="col-sm-8">
                    <select name="type" class="form-control m-b"  id="a_type" {{empty($room_type)?"disabled":""}}  >
                        <option value="0" >{{empty($room_type)?"没有任何房间信息，请联系管理员":"请选择"}}</option>
                        @forelse( $room_type as $v)
                            <option value="{{ $v }}" {{ (isset($data) && $data['a_type'] == $v )?'selected':'' }}>{{ $v }}</option>
                        @empty
                            <option value="0" >没有任何房间信息，请联系管理员</option>
                        @endforelse
                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">入住时间：</label>

                <div class="layui-input-inline col-sm-8">
                    <input name="date" class="layui-input form-control" id="test-limit1" placeholder="yyyy-MM-dd" lay-key="20" type="text"  value="{{ isset($data)?date('Y-m-d',strtotime($data['in_time'])):date('Y-m-d') }}">
                    <input name="checkIn" type="hidden" value="{{ isset($data)?date('Y-m-d',strtotime($data['in_time'])):date('Y-m-d') }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">退房时间：</label>

                <div class="layui-input-inline col-sm-8">
                    <input name="time" class="layui-input form-control" id="test-limit3" placeholder="yyyy-MM-dd" lay-key="22" type="text"  value="{{ isset($data)?date('Y-m-d',strtotime($data['out_time'])):date('Y-m-d') }}" >
                    <input name="checkOut" type="hidden" value="{{ isset($data)?date('Y-m-d',strtotime($data['out_time'])):date('Y-m-d') }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">天数：</label>
                <div class="col-sm-8">
                    <input id="day" class="form-control" disabled name="day" required="" aria-required="true" type="text" value="{{ isset($data)?$data['days']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row ">
                <label class="col-sm-3 control-label">单价：</label>
                <div class="col-sm-8 money">
                    <input id="money" class="form-control" name="money" required="" aria-required="true" type="text"  value="{{ isset($data)?$data['price']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">总价：</label>
                <div class="col-sm-8 money">
                    <input  class="form-control" name="sumMoney" required="" aria-required="true" disabled type="text" value="{{ isset($data)?$data['total_price']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row ">
                <label class="col-sm-3 control-label">房间号：</label>
                <div class="col-sm-8 ">
                    <input  class="form-control" name="room_num" required="" aria-required="true" type="text"  value="{{ isset($data)?$data['room_num']:'' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary" type="button" onclick="commit()">确定</button>
                <button class="btn" onclick="closeLayer()">取消</button>
            </div>
        </form>
    </div>
</div>
<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/jquery.from.min.js"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>

<script>

    //限定可选日期
    var myDate = new Date;
    var year = myDate.getFullYear();//获取当前年
    var yue = myDate.getMonth()+1;//获取当前月
    var date = myDate.getDate();//获取当前日
    var now = year+'-'+yue+'-'+date,
        checkIn=$('input[name="checkIn"]').val(),
        checkOut=$('input[name="checkOut"]').val(),
            sumMoney=$('input[name="sumMoney"]'),
        moenyInput=$('input[name=money]'),
    flag={};
    if(checkIn){
        checkIn.replace(/(\d*)-(\d*)-(\d*)/g,function($0,$1,$2,$3){
            checkIn={
                year:parseInt($1),
                month:parseInt($2-1),
                date:parseInt($3)
            }
        });
        checkOut.replace(/(\d*)-(\d*)-(\d*)/g,function($0,$1,$2,$3){
            checkOut={
                year:parseInt($1),
                month:parseInt($2),
                date:parseInt($3)
            }
        });

    }
    sumMoney.val($('#day').val()*$('#money').val());
    var ins22 = laydate.render({
        elem: '#test-limit1'
        ,min: now
        ,max: '2080-10-14',
        btns: ['now','confirm']
        ,done: function(val,data){

            $('input[name="checkIn"]').val(val);
            checkIn=data;
            if(checkOut){
                $('#day').val(count(checkIn,checkOut,true));
                if(moenyInput.val()){
                    sumMoney.val($('#day').val()*$('#money').val());
                }
            }
                data.month--;
            ins33.config.min=data;
            console.log(data)
        }
    }),
    //限定可选时间
    ins33 = laydate.render({
        elem: '#test-limit3'
        ,min: now
        ,max: '2080-10-14'
        ,btns: ['confirm'],
        done:function(val,data){
            $('input[name="checkOut"]').val(val);
            checkOut=data;
            if(checkIn) {
                $('#day').val(count(checkIn,checkOut,false));
                if(moenyInput.val()){
                    sumMoney.val($('#day').val()*$('#money').val());
                }
            }

        }
    });
    $('form').on("blur","input:not([name='room_num']),select", function check(){
        var ele=$(this),
            val=ele.val(),
            text=/[0-9a-zA-Z\u4e00-\u9fa5]/,
            money=/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
        if(ele.attr('name')==="money"){
            if(money.test(val)){
                ele.parents('.form-group').children('code').html('');
                sumMoney.val(val*$('#day').val());
            }else{
                ele.parents('.form-group').children('code').html('请填写');
                flag[ele.attr('name')]=false;
                return

            }
        }
        else if(ele.attr('name')==='date'||ele.attr('name')==='time')
        {
            ele.parents('.form-group').children('code').html('');
        }
        else if(ele.attr('name')==='type'){
            if(val==="0"){
                ele.parents('.form-group').children('code').html('请填写');
                flag[ele.attr('name')]=false;
                return
            }else{
                ele.parents('.form-group').children('code').html('');
            }
        }else{
            if(text.test(val)){
                ele.parents('.form-group').children('code').html('');
            }else{
                ele.parents('.form-group').children('code').html('请填写');
                flag[ele.attr('name')]=false;
                return
            }
        }
        flag[ele.attr('name')]=true;
    });
    function count(checkin,checkout,flag){
        if(flag){
            var checkinday=new Date().setFullYear(checkin.year,checkin.month,checkin.date);

        }else{
            var checkinday=new Date().setFullYear(checkin.year,checkin.month+1,checkin.date);
        }
    var checkoutdat=new Date().setFullYear(checkout.year,checkout.month,checkout.date+1);
        if(checkoutdat-checkinday>0){
            return(checkoutdat-checkinday)/ 1000 / 60 / 60 / 24
        }
        else{
            return 0
        }
    }
</script>
<script>

    function commit()
    {
        var join_id,a_id,a_name,a_type,in_time,out_time,days,price,total_price,room_num;
        join_id = $('input[name="join_id"]').val();
        a_id    = $('input[name="a_id"]').val();
        a_name  = $('input[name="a_name"]').val();
        a_type  = $('#a_type').val();
        in_time = $('input[name="date"]').val();
        out_time = $('input[name="time"]').val();
        days    = $('input[name="day"]').val();
        price    = $('input[name="money"]').val();
        total_price    = $('input[name="sumMoney"]').val();
        room_num =  $('input[name="room_num"]').val();
        if(join_id&&a_name&&a_type!=0&&in_time&&out_time&&days&&price&&total_price){
            for(k in flag){
                if(!flag[k]){

                    parent.layer.msg(k,"表单有错误");
                    return false
                }
            }
            if(days==0){
                parent.layer.msg("表单时间有误");
                return false
            }
            $.ajax({
                type: "POST",
                url: "/Manage/addOrUpdateAcc",
                data: {'_token'     : '<?php echo csrf_token() ?>',
                    'join_id'   : join_id ,
                    'a_id'      : a_id ,
                    'a_name'    : a_name ,
                    'a_type'    : a_type ,
                    'in_time'    : in_time ,
                    'out_time'    : out_time ,
                    'days'    : days ,
                    'price'    : price ,
                    'total_price'    : total_price ,
                    'room_num':room_num
                },success: function (data) {
                    if(typeof data=="string"){
                        data= $.parseJSON(data)
                    }
                    if(data.error)
                    {   parent
                        parent.layer.closeAll();
                    }else{
                        parent.layer.msg(data.msg);

                    }
                },
                error: function () {
                }
            })
            return
        }
        parent.layer.msg("表单有错误")

    }
    function closeLayer(){
        var index = parent.layer.getFrameIndex(window.name);
        console.log(index);
        parent.layer.close(index)
    }
</script>
</body>

</html>

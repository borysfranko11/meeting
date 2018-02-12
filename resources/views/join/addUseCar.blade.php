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
</head>
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

</style>
<body class="gray-bg">
<div class="row">
    <div class="col-sm-offset-1 must">
        <form >
            <input type="hidden" name="uci_id" value="{{ isset($data)?$data['uci_id']:'' }}">
            <input type="hidden" name="join_id" value="{{ isset($data)?$data['join_id']:$join_id }}">
            <div class="form-group row">
                <label class="col-sm-3 control-label">行程：</label>
                <div class="col-sm-8">
                    <select class="form-control m-b" name="uci_way" id="uci_way">
                        <option value="0">请选择</option>

                        <option value="1" {{ (isset($data) && $data['uci_way'] == '1' )?'selected':'' }}> 接机/车</option>
                        <option value="2" {{ (isset($data) && $data['uci_way'] == '2' )?'selected=true':'' }}>送机/车</option>

                    </select>
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">出发城市：</label>
                <div class="col-sm-8">
                    <select class="form-control m-b" name="begin_city" id="begin_city">
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
            <div class="form-group time row">
                <label class="col-sm-3 control-label">出发时间：</label>

                <div class="layui-input-inline col-sm-4">
                    <input  class="layui-input form-control" id="test-limit1" placeholder="yyyy-MM-dd" lay-key="20" type="text"  value="{{ isset($data)?date('Y-m-d',strtotime($data['begin_time'])):date('Y-m-d') }}">
                    <input name="date" type="hidden" value="{{ isset($data)?date('Y-m-d',strtotime($data['begin_time'])):date('Y-m-d') }}">
                </div>

                <div class="layui-input-inline col-sm-4">
                    <input  class="layui-input form-control" id="test-limit3" placeholder="HH:mm:ss" lay-key="22" type="text"   value="{{ isset($data)?date('H:i',strtotime($data['begin_time'])):'00:00' }}">
                    <input name="time" type="hidden" value="{{ isset($data)?date('H:i',strtotime($data['begin_time'])):'00:00' }}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">出发地：</label>
                <div class="col-sm-8">
                    <input id="cemail" class="form-control" name="begion_address" required="" aria-required="true" type="text" value="{{ isset($data)?$data['begion_address']:''}}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>

            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">目的地：</label>
                <div class="col-sm-8">
                    <input id="cemail" class="form-control" name="end_address" required="" aria-required="true" type="text" value="{{ isset($data)?$data['end_address']:''}}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>

            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">价格：</label>
                <div class="col-sm-8  money">
                    <input id="money" class="form-control" name="price" required="" aria-required="true" type="text" value="{{ isset($data)?$data['price']:''}}">
                </div>
                <code class="col-sm-offset-3 col-sm-8"></code>
            </div>
            <div class="form-group text-center row">
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
<script src="/assets/js/jquery.form.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>

<script>

    //限定可选日期
    var myDate = new Date;
    var year = myDate.getFullYear();//获取当前年
    var yue = myDate.getMonth()+1;//获取当前月
    var date = myDate.getDate();//获取当前日
    var now = year+'-'+yue+'-'+date,
        flag={};
    var ins22 = laydate.render({
        elem: '#test-limit1'
        ,min: now
        ,max: '2080-10-14',
        btns: ['now','confirm']
        ,done: function(date){
           $('input[name="date"]').val(date)
        }
    });
    //限定可选时间
    laydate.render({
        elem: '#test-limit3'
        ,type: 'time',
        btns:["confirm"],
        format: 'HH:mm',
        done:function(date){
            $('input[name="time"]').val(date);
        }
    });
    $('form').on("blur","input,select",function(){
       var ele=$(this),
           val=ele.val(),
           text=/[0-9a-zA-Z\u4e00-\u9fa5]/,
           money=/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
       if(ele.attr('name')==="price"){
           if(money.test(val)){
               ele.parents('.form-group').children('code').html('');
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
       else if(ele.attr('name')==='begin_city'||ele.attr('name')==="uci_way"){
           if(val==="0"){
               ele.parents('.form-group').children('code').html('请选择');
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
    })
</script>
<script>

    function commit()
    {
        var join_id,uci_id,uci_way,begin_city,begin_time,begion_address,end_address,price,date,time;
        join_id     =   $('input[name="join_id"]').val();
        uci_id      =   $('input[name="uci_id"]').val(); //?
        uci_way    =   $('#uci_way').val();
        begin_city  =   $('#begin_city').val();
        begion_address = $('input[name="begion_address"]').val();
        end_address    = $('input[name="end_address"]').val();
        price       =   $('input[name="price"]').val();
        date        =   $('input[name="date"]').val();
        time        =   $('input[name="time"]').val();
        begin_time = date+' '+time;
        if(uci_way&&begin_city&&begin_time&&begion_address&&end_address&&price){
            for(k in flag){
                if(!flag[k]){

                    parent.layer.msg("1");
                    return false
                }
            }
            $.ajax({
                type: "POST",
                url: "/Manage/addOrUpdateCar",
                data: {'_token'     : '<?php echo csrf_token() ?>',
                    'join_id'           : join_id ,
                    'uci_id'            : uci_id ,
                    'uci_way'          : uci_way ,
                    'begin_city'        : begin_city ,
                    'begion_address'    : begion_address ,
                    'end_address'       : end_address ,
                    'price'             : price ,
                    'begin_time'        : begin_time ,
                },success: function (data) {
                    if(typeof data=="string"){
                        data= $.parseJSON(data)
                    }
                    if(data.error != 'false')
                    {
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
        parent.layer.close(index)
    }
</script>
</body>

</html>

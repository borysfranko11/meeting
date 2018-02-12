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
    {{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
    <!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .ibox-content:after{
            content: "";
            display: block;
            height: 0;
            width:0;
            clear: both;
        }
        .warning{
            background: #ed5565;
            color: #fff;
        }
        .select select{
            width:19%;
        	margin-right:1%;
            margin-bottom:0;
        }
        .select input{
        	width:40%
        }
        .form-err{
        	color:red;
        }        

    </style>
</head>
<body class="gray-bg">
        <div class="ibox-title">
            <h2 class="hx-tag-extend">
                {{ isset($server_info['s_id'])?"修改服务商":"添加服务商"}}
                <a href="{{url('Servers/index')}}" class="btn btn-outline btn-info pull-right">
                    <i class="fa fa-reply"></i> 返回
                </a>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="javascript: void(0);">服务商管理</a>
                </li>
                <li>
                    <strong>{{ isset($server_info['s_id'])?"修改服务商":"添加服务商"}}</strong>
                </li>
            </ol>
        </div>
        <div class="ibox-content">
            <div class="col-sm-8 col-sm-offset-2">
                <form class="form-horizontal m-t" action="{{  isset($server_info['s_id']) ? url('/Servers/update') : url('/Servers/insert') }}" method="post"><!--id="signupForm" -->
                    {{ csrf_field() }}
                    <input type="hidden" value="{{empty($_GET['type'])?"":$_GET['type']}}" name="type" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>服务名称：</label>
                        <div class="col-sm-8">
                            <input id="username"  name="Server[name]" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" value="{{ old('Server')['name'] ? old('Server')['name'] : (isset($server_info['name']) ? $server_info['name'] :'')}}">
                            <div class="form-err">{{  $errors->first('Server.name')}}</div>
                        </div>                   
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>负责人{{ old('Server')['head'] }}：</label>
                        <div class="col-sm-8">
                            <input id="email" name="Server[head]" class="form-control" type="text" value="{{ old('Server')['head'] ? old('Server')['head'] : (isset($server_info['head']) ? $server_info['head'] :'')}}">
                            <div class="form-err">{{  $errors->first('Server.head')}} </div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>联系电话：</label>
                        <div class="col-sm-8">
                            <input id="email" name="Server[phone]" class="form-control" type="text" value="{{ old('Server')['phone'] ? old('Server')['phone'] : (isset($server_info['phone']) ? $server_info['phone'] :'')}}">
                            <div class="form-err">{{  $errors->first('Server.phone')}}</div>
                        </div>                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>邮箱：</label>
                        <div class="col-sm-8">
                            <input id="email" name="Server[email]" class="form-control" type="text" value="{{ old('Server')['email'] ? old('Server')['email'] : (isset($server_info['email']) ? $server_info['email'] :'')}}">
                            <div class="form-err">{{  $errors->first('Server.email')}}</div>
                        </div>                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>公司地址：</label>
                        <div class="col-sm-8 select">
                            <select class="form-control m-b col-sm-2 " name="Server[prov]" id="prov" onchange="searchCity(this)">
                                <option value="0">请选择</option>
                                @foreach($province as $p)
                                    <option value="{{ $p['id']}}"  {{ (old('Server')['prov'] && old('Server')['prov'] == $p['id']) ? 'selected' : (isset($server_info['prov'])&& $server_info['prov'] == $p['id'] ? 'selected':'')}} >{{ $p['name'] }}</option>
                                @endforeach
                            </select>                           
                            <select class="form-control m-b col-sm-2" name="Server[city]" id="city" onchange="searchCity(this)">
                                <option value="0">请选择</option> 
                                 @if(isset($city) && !empty($city))
                                     @foreach($city as $c )
                                        <option value="{{ $c['id']}}" {{ (old('Server')['city'] && old('Server')['city'] == $c['id']) ? 'selected' : (isset($server_info['city'])&& $server_info['city'] == $c['id'] ? 'selected':'')}} >{{ $c['name'] }}</option>
                                     @endforeach      
                                 @endif                           
                            </select>
                            <select class="form-control m-b col-sm-2" name="Server[area]" id="area" >
                                <option value="0">请选择</option> 
                                 @if(isset($area) && !empty($area))
                                     @foreach($area as $a )
                                        <option value="{{ $a['id']}}"  {{ (old('Server')['area'] && old('Server')['area'] == $a['id']) ? 'selected' : (isset($server_info['area'])&& $server_info['area'] == $a['id'] ? 'selected':'')}}>{{ $a['name'] }}</option>
                                     @endforeach  
                                 @endif                            
                            </select>
                            <input id="email" name="Server[adderss]" class="form-control col-sm-6" type="text" value="{{ old('Server')['adderss'] ? old('Server')['adderss'] : (isset($server_info['adderss']) ? $server_info['adderss'] :'')}}">
                            <div class="form-err" >
                                @if ($errors->has('Server.prov'))
                                        请选择省
                                @endif  
                                &nbsp;                     
                                @if ($errors->has('Server.city'))
                                            请选择市
                                @endif 
                                &nbsp; 
                                @if ($errors->has('Server.area'))
                                            请选择区
                                @endif    
                                &nbsp;                         
                                {{  $errors->first('Server.adderss')}}
                             </div>    
                        </div>   
                                         
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-3">
                            <input type="hidden" name="Server[s_id]" value="{{ isset($server_info['s_id']) ? $server_info['s_id'] :''}}">
                            <button class="btn btn-primary" type="submit">提交</button>
                            <button class="btn btn-primary" type="button" onclick="cancleBtn()" >取消</button>
                        </div>
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
<script src="assets/js/jquery.form.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>

<script src="js/plugins/validate/jquery.validate.min.js"></script>
<script src="js/plugins/validate/messages_zh.min.js"></script>
<script src="js/demo/form-validate-demo.min.js"></script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
<script>

    //修改服务商状态【弹窗】
    function searchCity( obj)
    {
        var _this = obj;       
        var prov = $(_this).val();    
        $.ajax({
            type: "POST",
            url: "/Servers/search_city",
            data: { '_token'     : '<?php echo csrf_token() ?>',
                    'prov'       : prov ,                           
            },success: function (data) {
                 var div_id = $(_this).attr('id');
            	 var html = '<option value="0">请选择</option>';              	
           		 for(var o in data){  
     		        html += "<option value='"+data[o].id+"'  >"+data[o].name+"</option>";      		         		              		          
     		     }   
     		       		
            	 $("#area").html('');    
        		 if(div_id == 'prov')
 		         {
 		        	$("#city").html(''); 		        	
 		        	$("#city").append(html); 
 		        	$("#area").append('<option value="0">请选择</option>');
     		     } else{     		    	
     		    	$("#area").append(html); 
         		 }                    
            },
            error: function () {
            }
        })
    }

    //点击取消按钮，返回上一页面
	function cancleBtn()
	{
		window.history.go(-1); 
	}
</script>
</body>

</html>


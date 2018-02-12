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
         .form-err{
        	color:red;
        	float:left;
        } 
    </style>
</head>
<body class="gray-bg">
        <div class="ibox-title">
    <h2 class="hx-tag-extend">
        添加员工
        <a href="{{url('Servers/index')}}" class="btn btn-outline btn-info pull-right">
            <i class="fa fa-reply"></i> 返回
        </a>
    </h2>
    <ol class="breadcrumb">
        <li>
            <a href="javascript: void(0);">服务商管理</a>
        </li>
        <li>
            <strong>添加员工</strong>
        </li>
    </ol>
</div>
        <div class="ibox-content">
            <div class="col-sm-6 col-md-offset-3">
                <form class="form-horizontal m-t" action="{{  isset($staff['id']) ? url('/Servers/staff_update') : url('/Servers/staff_insert') }}" method="post"><!--id="signupForm" -->
                    {{ csrf_field() }}                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>姓名：</label>
                        <div class="col-sm-8">                           
                            <input name="Staff[name]" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" value="{{  old('Staff')['name'] ? old('Staff')['name'] : (isset($staff['name']) ? $staff['name'] :'')}}">
                            <div class="form-err">{{  $errors->first('Staff.name')}}</div>
                        </div>                        
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>性别：</label>
                        <div class="col-sm-8">
                            <input type="radio" value="1" name="Staff[sex]" {{ (old('Staff')['sex'] && 1 == old('Staff')['sex']) ? 'checked' : (!isset($staff['sex']) || 1==$staff['sex'] ?'checked' :'') }}> 男
                            <input type="radio" value="0" name="Staff[sex]" {{ (old('Staff')['sex'] && 0 == old('Staff')['sex']) ? 'checked' : (isset($staff['sex'])&& 0==$staff['sex'] ?'checked' :'') }} style="margin-left: 20px;"> 女
                        </div>
                        <div class="form-err"> {{  $errors->first('Staff.sex')}}</div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>手机号码：</label>
                        <div class="col-sm-8">
                            <input name="Staff[phone]" class="form-control" type="text" value="{{ old('Staff')['phone'] ? old('Staff')['phone'] : (isset($staff['phone']) ? $staff['phone'] :'')}}">
                            <div class="form-err">{{  $errors->first('Staff.phone')}}</div>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>身份证号：</label>
                        <div class="col-sm-8">
                            <input name="Staff[id_card]" class="form-control" type="text" value="{{ old('Staff')['id_card'] ? old('Staff')['id_card'] : (isset($staff['id_card']) ? $staff['id_card'] :'')}}">
                            <div class="form-err">{{  $errors->first('Staff.id_card')}}</div>
                        </div>
                       
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>邮箱：</label>
                        <div class="col-sm-8">
                            <input name="Staff[email]" class="form-control" type="text" value="{{ old('Staff')['email'] ? old('Staff')['email'] :  (isset($staff['email']) ? $staff['email'] :'')}}">
                            <div class="form-err">{{  $errors->first('Staff.email')}}</div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>职位名称：</label>
                        <div class="col-sm-8">
                            <input name="Staff[company]" class="form-control" type="text" value="{{ old('Staff') != null ? old('Staff')['company'] : (isset($staff['company']) ? $staff['company'] :'')}}">
                            <div class="form-err">{{  $errors->first('Staff.company')}}</div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>系统角色：</label>
                        <div class="col-sm-8">
                            <select class="form-control m-b" name="UserRole[role_id]">
                                <option value="0">请选择</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role['id']}}" {{ (old('UserRole')['role_id'] && $role['id'] == old('UserRole')['role_id']) ? 'selected' : (isset($staff['role_id']) && $role['id'] == $staff['role_id'] ? 'selected' :'')}} >{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="form-err"> 
                               @if ($errors->has('UserRole.role_id')) 
                                                                                       请选择系统角色
                               @endif  
                            </div>  
                        </div>  
                                        
                    </div>
                    @if( isset ($staff['id']) )       
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>用户名：</label>
                        <div class="col-sm-8"> {{ $staff['username'] }}</div>                        
                    </div>
                     @endif 
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>密码：</label>
                        <div class="col-sm-8">                        
                            <input name="User[password]" class="form-control" type="password" value="">
                            <div class="form-err">{{  $errors->first('User.password')}}</div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><em style="color: red">*</em>确认密码：</label>
                        <div class="col-sm-8">
                            <input name="User[password_confirmation]" class="form-control" type="password" value="">
                            <div class="form-err">{{  $errors->first('User.password_confirmation')}}</div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-3">
                            <input type="hidden" name="Staff[s_id]" value="{{ isset($server_id) ? $server_id :''}}">
                            <input type="hidden" name="Staff[id]" value="{{ isset($staff['id']) ? $staff['id'] :''}}">
                            <input type="hidden" name="Staff[users_id]" value="{{ isset($staff['users_id']) ? $staff['users_id'] :''}}">
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

    //点击取消按钮，返回上一页面
	function cancleBtn()
	{
		window.history.go(-1); 
	}
	$("form").find('input').on('blur',function(){
	    $(this).parent('div').children('div').text('')
    })
</script>
</body>

</html>


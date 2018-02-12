<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>添加用户</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

        <style type="text/css">
            .dashed-wrapper{border: 1px dashed #DBDEE0; padding: 10px 20px 0;}

            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px; font-weight: 400;}
        </style>
    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">添加用户</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <strong>添加用户</strong>
                                </li>
                            </ol>
                        </div>
                        <div class="ibox-content">
                            <form id="increase_form" class="form-horizontal" method="POST" action="#">
                                {{csrf_field()}}
                                <div class="m-b-md dashed-wrapper">
                                    <h3 class="m-b-md hx-tag-extend">用户信息</h3>
                                    <div class="row">
                                        <div class="col-sm-12 m-b-md">
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 账户名称(用于登录)</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="account" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 用户名称(系统内显示)</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="username" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 电话号码</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="mobile" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 邮箱地址</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="email" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 角色</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <select id="role_list" class="form-control m-b" name="role" title=""></select>
                                                        <input id="role_name" type="hidden" name="role_name" value="" title="" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 成本中心</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <select id="code_list" class="form-control m-b" name="code" title="">
                                                            <option value="">- 请选择</option>
                                                            <option value="10001">成本中心1</option>
                                                            <option value="10002">成本中心2</option>
                                                            <option value="10003">成本中心3</option>
                                                            <option value="10004">成本中心4</option>
                                                            <option value="10005">成本中心5</option>
                                                            <option value="10006">成本中心6</option>
                                                            <option value="10007">成本中心7</option>
                                                            <option value="10008">成本中心8</option>
                                                        </select>
                                                        <input id="code_name" type="hidden" name="code_name" value="" title="" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 密码</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="password" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <span class="text-muted">- 确认密码</span>
                                                    <div class="m-sm"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-info-circle"></i></button>
                                                        </span>
                                                        <input class="form-control" type="text" value="" name="confirm" title="" autocomplete="off" />
                                                    </div>
                                                    <div class="m-sm"></div>
                                                    <span class="text-warning" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <span class="text-muted">- 用户描述</span>
                                                    <div class="m-sm"></div>
                                                    <textarea class="form-control" style="resize: none;" name="desc" title=""></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group m-b-none m-t-md">
                                                <div class="col-sm-12">
                                                    <button id="add_action" class="btn btn-sm btn-info pull-right m-t-n-xs"><strong>添加用户</strong></button>
                                                    <button class="btn btn-sm btn-default pull-right m-t-n-xs refuse-reconfirm" style="display: none;"><strong>添加用户</strong></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/js/plugins/underscore/core.min.js"></script>
        <script src="/assets/js/plugins/validation/jquery.validate.min.js"></script>
        <script src="/assets/js/plugins/jquery-form/core.js"></script>
        <script type="text/javascript">
            $( document ).ready( function()
            {
                var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );
                var TOKEN = '{{csrf_token()}}';

                // 角色数据初始化
                ( function( data )
                {
                    var node = $( '#role_list' );

                    if( !_.isUndefined( data ) )
                    {
                        var tmp = [];

                        tmp.push( '<option value="">- 请选择</option>' );

                        $.each( data, function( key, detail )
                        {
                            tmp.push( '<option value="'+detail["id"]+'">'+detail["name"]+'</option>' );
                        } );

                        node.html( tmp.toString() );
                    }

                } )( ORIGIN_DATA["roles"] );

                var form_node = $( '#increase_form' );

                // 选中角色, 自动填写角色名称
                form_node.find( 'select[name="role"]' ).change( function()
                {
                    var role_name = $( '#role_list' ).find( "option:selected" ).text();

                    $( '#role_name' ).val( role_name );
                } );

                // 成本中心, 自动填写名称
                form_node.find( 'select[name="code"]' ).change( function()
                {
                    var role_name = $( '#code_list' ).find( "option:selected" ).text();

                    $( '#code_name' ).val( role_name );
                } );

                // 手机号码验证
                jQuery.validator.addMethod( "isMobile", function( value, element )
                {
                    var length = parseInt( value.length );
                    var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
                    return this.optional( element ) || ( length === 11 && mobile.test( value ) );
                }, "请正确填写您的手机号码" );

                // 邮箱验证
                jQuery.validator.addMethod( "isEmail", function( value, element )
                {
                    var email = /^[A-Za-z0-9\u4e00-\u9fa5_]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
                    return this.optional( element ) || email.test( value );
                }, "请正确填写邮箱地址" );

                // 表单提交, 新增用户
                form_node.validate( {
                    //debug: true,                              // 开启此功能则不进行提交
                    errorClass: 'errorbo',
                    errorElement: "span",
                    noClassInElement: true,                     // 错误重置后不需要添加样式  -- 自定义属性(改部分插件源码)
                    focusInvalid: true,
                    submitHandler: function( form )
                    {
                        var that = $( '#add_action' ),
                            siblings = that.siblings( '.refuse-reconfirm' );

                        // 防止反复请求限制
                        that.hide();
                        siblings.show();

                        $( form ).ajaxSubmit( {
                            type:"post",
                            url:"/User/increase",
                            success: function( Response, status, xhr )
                            {
                                Response = JSON.parse( Response );

                                if( Response["Success"] === true )
                                {
                                    swal( {
                                            title: "恭喜",
                                            text: Response["Msg"],
                                            type: "success",
                                            confirmButtonText: "确定"
                                        },
                                        function()
                                        {
                                            // 成功跳转
                                            location.href = '/User/index';
                                        }
                                    );
                                }
                                else
                                {
                                    swal( {
                                        title: "抱歉",
                                        text: '添加失败, 请稍后再试！',
                                        type: "warning",
                                        confirmButtonText: "确定"
                                    } );

                                    that.show();
                                    siblings.hide();
                                }
                            }
                        } );
                    },
                    onfocusout: function( element )             // 焦点离开时进行验证的调用
                    {
                        $( element ).valid();                   // 单独对触发的标签进行验证
                    },
                    errorPlacement: function( error, element )
                    {
                        var icon = element.siblings( '.input-group-btn' ).find( 'button' );         // element 好比 $( this )
                        var notice = element.parent().siblings( '.text-warning' );

                        icon.removeClass( 'btn-default' ).removeClass( 'btn-info' ).addClass( 'btn-warning' );                           // 图标换色
                        notice.html( error ).show();                                                // 显示报错信息
                    },
                    success: function( msg, element )
                    {
                        var name = $( element ).attr( 'name' );
                        var _that = form_node.find( 'input[name="'+name+'"]' );
                        var icon = _that.siblings( '.input-group-btn' ).find( 'button' );         // element 好比 $( this )
                        icon.removeClass( 'btn-default' ).removeClass( 'btn-warning' ).addClass( 'btn-info' );                            // 图标换色

                    },
                    rules: {
                        account: {
                            required: true,
                            remote: {
                                url: "/User/verify",
                                type: "post",
                                data:{
                                    _token: TOKEN,
                                    type: "string",
                                    action: "account"
                                }   // 验证的参数
                            }       // ajax 验证
                        },
                        username:{
                            required: true,
                            minlength: 6,
                            maxlength: 12
                        },
                        mobile:{
                            required: true,
                            isMobile: true
                        },
                        email:{
                            required: true,
                            isEmail: true
                        },
                        role:{
                            required: true
                        },
                        code:{
                            required: true
                        },
                        password: {
                            required: true,
                            minlength: 6,
                            maxlength: 12
                        },
                        confirm: {
                            required: true,
                            minlength: 6,
                            maxlength: 12,
                            equalTo: form_node.find( 'input[name="password"]' )
                        }
                    },
                    messages: {
                        account: {
                            required: "用户名不能为空",
                            remote: "该账号已被使用"
                        },
                        role: {
                            required: "请选择角色"
                        },
                        code: {
                            required: "成本中心不能为空"
                        },
                        username:{
                            required: "请填写新密码",
                            minlength: "名称长度6-12, 请检查",
                            maxlength: "名称长度6-12, 请检查"
                        },
                        password: {
                            required: "请填写新密码",
                            minlength: "密码长度6-12, 请检查",
                            maxlength: "密码长度6-12, 请检查"
                        },
                        confirm: {
                            required: "请确认新密码",
                            minlength: "密码长度6-12, 请检查",
                            maxlength: "密码长度6-12, 请检查",
                            equalTo: "两次密码不相同, 请重新输入"
                        }
                    }
                } );
            } );
        </script>
    </body>
</html>
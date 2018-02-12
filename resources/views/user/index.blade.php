<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title></title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <style type="text/css">
            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px; font-weight: 400;}

            .footable-filtering{display: none;}
            .user-edit-model{cursor: pointer;}
        </style>
    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">用户列表</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <strong>用户列表</strong>
                                </li>
                            </ol>
                        </div>
                        <div class="ibox-content">
                            <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="智能搜索...">
                            <br>
                            <table id="user_table" class="table" data-paging="true" data-filtering="true"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal fade in" id="user_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">
                            <i class="fa fa-edit modal-icon" style="font-size: 42px; vertical-align:middle;"></i> 设置用户角色信息
                        </h4>
                    </div>
                    <div class="modal-body" style="background-color: #FFF;">
                        <form id="form_user_edit" method="POST" action="/User/editMsg">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="" title=""/>
                            <table id="edit_layout" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 100px;">#</th>
                                    <th>内容</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>用户编码:</td>
                                    <td id="place_id">100101</td>
                                </tr>
                                <tr>
                                    <td>登录名:</td>
                                    <td id="place_login_name">Ht_pu</td>
                                </tr>
                                <tr>
                                    <td>姓名:</td>
                                    <td id="place_username">pu</td>
                                </tr>
                                <tr>
                                    <td>手机:</td>
                                    <td id="place_phone">18614055555</td>
                                </tr>
                                <tr>
                                    <td>邮箱:</td>
                                    <td id="place_email">hongjie_pu@eventown.com</td>
                                </tr>
                                <tr>
                                    <td>状态:</td>
                                    <td>
                                        <div class="form-group">
                                            <div id="place_status" class="col-sm-12" style="padding-left: 0; padding-right: 0;">
                                                <label class="checkbox-inline i-checks">
                                                    <input type="radio" value="1" name="edit_user_status">生效
                                                </label>
                                                <label class="checkbox-inline i-checks">
                                                    <input type="radio" value="2" name="edit_user_status">待验证
                                                </label>
                                                <label class="checkbox-inline i-checks">
                                                    <input type="radio" value="3" name="edit_user_status">未验证
                                                </label>
                                                <label class="checkbox-inline i-checks">
                                                    <input type="radio" value="4" name="edit_user_status">禁用
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>用户角色:</td>
                                    <td>

                                        <select id="place_role" data-placeholder="选择角色..." class="chosen-select" tabindex="-1" name="edit_user_role[]" multiple>
                                            <option value=""></option>
                                            @foreach( $role_list as $key => $value )
                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>成本中心:</td>
                                    <td>
                                        <select id="place_center" data-placeholder="选择成本中心..." class="chosen-select" tabindex="-1" name="edit_user_center">
                                            <option value=""></option>
                                            @foreach( $marketorg_list as $k => $v )
                                            <option value="{{$v['marketorgcode']}}">{{$v['marketorgdesc']}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="edit_center_name" value="" title="" readonly />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" id="submit_edit">提交更改</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/plugins/underscore/core.min.js"></script>

        <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>
        <script src="/assets/js/moment.min.js"></script>
        <script src="/assets/js/plugins/footable/3.1.5/footable.js"></script>
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>
        <script>
            $( document ).ready( function()
            {
                // 全部用户数据
                var user_list = JSON.parse( '{!!$user_list!!}' );

                // 用户列表数据格式化( footable format 不支持数组传递 )
                for( var key in user_list )
                {
                    for( var row in user_list[key] )
                    {
                        if( row === 'role' )
                        {
                            user_list[key]['role'] = JSON.stringify( user_list[key]['role'] );
                        }

                        if( row === 'center' )
                        {
                            user_list[key]['center'] = JSON.stringify( user_list[key]['center'] );
                        }
                    }
                }

                var table_header = [
                    {"name": "id", "title": "用户编码"},
                    {"name": "login_name", "title": "登录名"},
                    {"name": "username", "title": "姓名", "breakpoints": "sm"},
                    {
                        "name": "status", "title": "状态", "breakpoints": "sm",
                        "formatter": function( value, options, rowData )                                                // 格式化数据
                        {
                            var result = '<span class="label {css}">{value}</span>';
                            var style = {
                                "0": {"class":'label-default',"ch":"未知"},
                                "1": {"class":'label-primary',"ch":"生效"},
                                "2": {"class":'label-warning',"ch":"待验证"},
                                "3": {"class":'label-info',"ch":"未验证"},
                                "4": {"class":'label-danger',"ch":"禁用"}
                            };

                            result = result.replace( /{css}/, style[value]["class"] );
                            result = result.replace( /{value}/, style[value]["ch"] );

                            return result;
                        }
                    },
                    {
                        "name": "center", "title": "成本中心", "breakpoints": "xs sm",
                        "formatter": function( value, options, rowData )
                        {
                            var origin = JSON.parse( value );

                            return origin["name"];
                        }
                    },
                    {"name": "phone", "title": "联系电话", "breakpoints": "xs sm md"},
                    {"name": "email", "title": "邮箱", "breakpoints": "xs sm md"},
                    {
                        "name": "role", "title": "用户角色", "breakpoints": "xs sm md",
                        "formatter": function( value, options, rowData )
                        {
                            var origin = JSON.parse( value );
                            var tmp = [];

                            // 将角色放入临时数组, 最终以字符串形式输出
                            for( var key in origin )
                            {
                                tmp.push( origin[key]["name"] );
                            }

                            return tmp.join( '&' );
                        }
                    },
                    {
                        "name": "oper", "title": "操作", "breakpoints": "xs sm md",
                        "formatter": function( value, options, rowData )                                                // 格式化数据
                        {
                            var html = '<span class="text-success user-edit-model" data-row='+JSON.stringify( rowData )+'>' +
                                           '<i class="fa fa-edit"></i> 用户编辑' +
                                       '</span>';

                            return html;
                        }
                    }
                ];

                var user_table = $( '#user_table' );

                // 用户列表生成, 以及插件初始化
                user_table.footable( {
                    "columns": table_header,
                    "rows": user_list,
                    "paging":{
                        "size": 10,
                        "limit": 4
                    },
                    "empty": "数据暂无"
                } );

                // 打开用户编辑界面
                user_table.on( 'click', '.user-edit-model', function()
                {
                    var origin_data = JSON.parse( $( this ).attr( 'data-row' ) );

                    // 用户修改索引
                    $( '#form_user_edit' ).find( 'input[name="user_id"]' ).val( origin_data["id"] );

                    // 手动打开 bt model 层
                    $( '#user_edit' ).modal( 'show' );

                    for( var key in origin_data )
                    {
                        var target = $( '#place_'+key );

                        // 状态数据填充
                        if( key === 'status' )
                        {
                            target.find( 'input[name="edit_user_status"]' ).each( function()
                            {
                                var _input = $( this );

                                if( _input.val() === origin_data[key] )
                                {
                                    _input.iCheck('check');
                                }
                                else
                                {
                                    _input.iCheck('uncheck');
                                }
                            } );

                            continue;
                        }

                        // 成本数据数据填充
                        if( key === 'center' )
                        {
                            // chosen 动态设置默认值 https://harvesthq.github.io/chosen/
                            var center_data = JSON.parse( origin_data[key] );
                            target.val( center_data["id"] ).trigger( 'change' );
                            target.trigger( 'chosen:updated' );

                            // 获取 selected 选中的文本
                            target.chosen().change( function()
                            {
                                $( this ).siblings( 'input[name="edit_center_name"]').val( $( this ).find( "option:selected" ).text() );
                            } );

                            continue;
                        }

                        // 角色数据填充
                        if( key === 'role' )
                        {
                            var role_data = JSON.parse( origin_data[key] );
                            var roles_id = [];

                            for( var r_k in role_data )
                            {
                                roles_id.push( role_data[r_k]["id"] );
                            }

                            target.val( roles_id ).trigger('change');
                            target.trigger( 'chosen:updated' );

                            continue;
                        }

                        // 节点存在执行以下操作
                        if( target.length  > 0 )
                        {
                            target.text( origin_data[key] );
                        }
                    }
                } );

                // 清空用户修改索引(避免不可预见问题)
                $( '#user_edit' ).on( 'hidden.bs.modal', function()
                {
                    $( '#form_user_edit' ).find( 'input[name="user_id"]' ).val( '' );
                } );

                // 自动获取表格键名, 并重组(为 footable 提供服务)
                var table_header_keys = function()
                {
                    var result = '';

                    if( !_.isEmpty( table_header ) && !_.isUndefined( table_header ) )
                    {
                        var tmp = [];

                        for( var row in table_header )
                        {
                            tmp.push( table_header[row]["name"] );
                        }

                        result = tmp;
                    }
                    else
                    {
                        result = 'id';
                    }

                    return result;
                };

                // footable 自定义搜索事件监听
                $( '#filter' ).change( function()
                {
                    var filtering = FooTable.get( '#user_table' ).use( FooTable.Filtering ),                         // get the filtering component for the table
                        filter = $( this ).val();                                                                       // get the value to filter by

                    // if the value is "none" or empty remove the filter
                    if( _.isEmpty( filter ) || filter === 'none' )
                    {
                        filtering.removeFilter( 'id' );
                    }
                    else
                    {
                        // otherwise add/update the filter.
                        filtering.addFilter( 'id', filter, table_header_keys() );
                    }

                    filtering.filter();
                } );

                // select 美化插件初始化, 作用于用户角色选择、成本中心选择
                $( '.chosen-select' ).chosen( {width: "100%"} );

                // input 样式插件初始化, 作用于用户状态选择
                $( ".i-checks" ).iCheck( {checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"} );

                // 表单提交
                $( '#submit_edit' ).click( function()
                {
                    $( '#form_user_edit' ).submit();
                } );

                //错误提示
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                @if( !empty( session('error') ) )
                toastr["error"]("修改失败", "错误");
                @elseif( !empty( session('success') ) )
                 toastr["success"]("修改成功", "恭喜");
                @endif
            } );
        </script>
    </body>
</html>

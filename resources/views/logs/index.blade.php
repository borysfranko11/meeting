<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>H+ 后台主题UI框架 - 收件箱</title>
        <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
        <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="//cdn.bootcss.com/bootstrap-table/1.11.1/bootstrap-table.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
        <!-- <link href="//cdn.bootcss.com/jquery-footable/3.1.5/footable.bootstrap.min.css" rel="stylesheet"> -->
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/bootTheme.css" rel="stylesheet">
        
        <style scoped>
            /* provides a red astrix to denote required fields - this should be included in common stylesheet */
            .form-group.required .control-label:after {
                content:"*";
                color:red;
                margin-left: 4px;
            }
        </style>
    </head>
    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <div class="space-20"></div>
                                <h2>日志类型</h2>
                                <div class="space-25"></div>
                                <ul class="folder-list m-b-md" style="padding: 0">
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-inbox "></i> 某类型1 <span class="label label-warning pull-right">16</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-envelope-o"></i> 某类型2 <span class="label label-primary pull-right">3</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-file-text-o"></i> 某类型3 <span class="label label-danger pull-right">2</span>
                                        </a>
                                    </li>
                                </ul>

                                <h5 class="tag-title">标签</h5>
                                <ul class="tag-list" style="padding: 0">
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 会议</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 费用</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 审核</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 订单</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 水单</a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 animated fadeInRight">
                    <div class="mail-box-header">

                        <form method="get" action="#" class="pull-right mail-search" onsubmit="return false;">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" name="search" placeholder="搜索日志标题，正文等">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        搜索
                                    </button>
                                </div>
                            </div>
                        </form>
                        <h2>
                            日志列表 (16)
                        </h2>
                        <div class="mail-tools tooltip-demo m-t-md">
                            <div class="btn-group pull-right">
                                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>
                            </div>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="刷新日志列表">
                                <i class="fa fa-refresh"></i> 刷新
                            </button>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="标为已读">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="标为重要">
                                <i class="fa fa-exclamation"></i>
                            </button>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="驳回">
                                <i class="fa fa-recycle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mail-box">

                        <table class="table table-hover table-mail">
                            <tbody>
                            <tr class="unread">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks" checked>
                                </td>
                                <td class="mail-ontact"><a href="/Logs/detail">支付宝</a>
                                </td>
                                <td class="mail-subject"><a href="/Logs/detail">支付宝提醒</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">昨天 10:20</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">WordPress</a> <span
                                            class="label label-warning pull-right">验证邮件</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">wp-user-frontend-pro v2.1.9</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">上午9:21</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">史上最全！淘宝双11红包疯抢攻略！</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">中午12:24</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a> <span
                                            class="label label-danger pull-right">AD</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">亲，双11来啦！帮你挑货，还送你4999元红包！仅此一次！</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">上午6:48</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">支付宝</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">支付宝提醒</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">昨天 10:20</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">Amaze UI</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">Amaze UI Beta2 发布</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">上午10:57</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">WordPress</a> <span
                                            class="label label-warning pull-right">验证邮件</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">wp-user-frontend-pro v2.1.9</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">上午9:21</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">史上最全！淘宝双11红包疯抢攻略！</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">中午12:24</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a> <span
                                            class="label label-danger pull-right">AD</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">亲，双11来啦！帮你挑货，还送你4999元红包！仅此一次！</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">上午6:48</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">支付宝</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">支付宝提醒</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">昨天 10:20</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">Amaze UI</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">Amaze UI Beta2 发布</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">上午10:57</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">WordPress</a> <span
                                            class="label label-warning pull-right">验证邮件</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">wp-user-frontend-pro v2.1.9</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">上午9:21</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">史上最全！淘宝双11红包疯抢攻略！</a>
                                </td>
                                <td class=""></td>
                                <td class="text-right mail-date">中午12:24</td>
                            </tr>
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact"><a href="javascript: void(0);">淘宝网</a> <span
                                            class="label label-danger pull-right">AD</span>
                                </td>
                                <td class="mail-subject"><a href="javascript: void(0);">亲，双11来啦！帮你挑货，还送你4999元红包！仅此一次！</a>
                                </td>
                                <td class=""><i class="fa fa-paperclip"></i>
                                </td>
                                <td class="text-right mail-date">上午6:48</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <div class="space-20"></div>
                                <h2>日志类型</h2>
                                <div class="space-25"></div>
                                <ul class="folder-list m-b-md" style="padding: 0">
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-inbox "></i> 某类型1 <span class="label label-warning pull-right">16</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-envelope-o"></i> 某类型2 <span class="label label-primary pull-right">3</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-file-text-o"></i> 某类型3 <span class="label label-danger pull-right">2</span>
                                        </a>
                                    </li>
                                </ul>

                                <h5 class="tag-title">标签</h5>
                                <ul class="tag-list" style="padding: 0">
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 会议</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 费用</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 审核</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 订单</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 水单</a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 animated fadeInRight">
                    <div class="panel-body" style="padding-bottom:0px;">
                        <div class="panel panel-default">
                            <div class="panel-heading">查询条件</div>
                            <div class="panel-body">
                                <form id="formSearch" class="form-horizontal">
                                    <div class="form-group" style="margin-top:15px">
                                        <label class="control-label col-sm-1" for="txt_search_departmentname">部门名称</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txt_search_departmentname">
                                        </div>
                                        <label class="control-label col-sm-1" for="txt_search_statu">状态</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txt_search_statu">
                                        </div>
                                        <div class="col-sm-4" style="text-align:left;">
                                            <button type="button" style="margin-left:50px" id="btn_query" class="btn btn-primary">查询</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>       

                        <div id="toolbar" class="btn-group">
                            <button id="btn_add" type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增
                            </button>
                            <button id="btn_edit" type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>修改
                            </button>
                            <button id="btn_delete" type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>删除
                            </button>
                        </div>
                        <table id="tb_departments" class="table table-hover table-mail">
                            <!-- <thead>
                                <tr>
                                    <th data-field="checkbox" class="check-mail">
                                        
                                    </th>
                                    <th data-field="id" class="mail-ontact">id</th>
                                    <th data-field="Name" class="mail-ontact">Name</th>
                                    <th data-field="ParentName" class="mail-subject">Stars</th>
                                    <th data-field="Level">Forks</th>
                                    <th data-field="Desc">Description</th>
                                </tr>
                            </thead> -->
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <div class="space-20"></div>
                                <h2>日志类型</h2>
                                <div class="space-25"></div>
                                <ul class="folder-list m-b-md" style="padding: 0">
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-inbox "></i> 某类型1 <span class="label label-warning pull-right">16</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-envelope-o"></i> 某类型2 <span class="label label-primary pull-right">3</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <i class="fa fa-file-text-o"></i> 某类型3 <span class="label label-danger pull-right">2</span>
                                        </a>
                                    </li>
                                </ul>

                                <h5 class="tag-title">标签</h5>
                                <ul class="tag-list" style="padding: 0">
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 会议</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 费用</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 审核</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 订单</a>
                                    </li>
                                    <li>
                                        <a href="mail_compose.html"><i class="fa fa-tag"></i> 水单</a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 animated fadeInRight">
                    <!-- Table Markup -->
                    <table id="showcase-example-1" class="table" data-paging="true" data-filtering="true" data-sorting="true" data-editing="true" data-state="true"></table>

                    <!-- Editing Modal Markup -->
                    <div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">
                        
                        <div class="modal-dialog" role="document">
                            <form class="modal-content form-horizontal" id="editor">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="editor-title">Add Row</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="number" id="id" name="id" class="hidden"/>
                                    <div class="form-group required">
                                        <label for="firstName" class="col-sm-3 control-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jobTitle" class="col-sm-3 control-label">Job Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="Job Title">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="startedOn" class="col-sm-3 control-label">Started On</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="startedOn" name="startedOn" placeholder="Started On" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob" class="col-sm-3 control-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="status" name="status">
                                                <option value="Active">Active</option>
                                                <option value="Disabled">Disabled</option>
                                                <option value="Suspended">Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="//cdn.bootcss.com/bootstrap-table/1.11.1/bootstrap-table.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap-table/1.11.1/locale/bootstrap-table-zh-CN.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>
        <script src="/assets/js/dairyList/dairyList.js"></script>
        <script src="//cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>
        <script src="//cdn.bootcss.com/moment.js/2.18.1/locale/zh-cn.js"></script>
        <script src="/assets/js/plugins/footable/3.1.5/footable.js"></script>
        <!-- <script src="//cdn.bootcss.com/jquery-footable/3.1.5/footable.min.js"></script> -->
        <script>
$( document ).ready(function(){
    $( ".i-checks" ).iCheck( {checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"} );
    
    $(function () {
        //1.初始化Table
        var oTable = new TableInit();
        oTable.Init();
        //2.初始化Button的点击事件
        // var oButtonInit = new ButtonInit();
        // oButtonInit.Init();
    });
var TableInit = function () {
    var oTableInit = new Object();
    //初始化Table
    oTableInit.Init = function () {
        $('#tb_departments').bootstrapTable({
            // url: '',         //请求后台的URL（*）
            // method: 'get',                      //请求方式（*）
            toolbar: '#toolbar',                //工具按钮用哪个容器
            striped: true,                      //是否显示行间隔色
            // cache: false,                        //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            sortable: false,                     //是否启用排序
            sortOrder: "asc",                   //排序方式
            // queryParams: oTableInit.queryParams,//传递参数（*）
            sidePagination: "client",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber:1,                       //初始化加载第一页，默认第一页
            pageSize: 2,                       //每页的记录行数（*）
            pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
            search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
            // strictSearch: false,
            showColumns: true,                  //是否显示所有的列
            showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            // clickToSelect: true,                //是否启用点击选中行
            height: 500,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            // uniqueId: "ID",                     //每一行的唯一标识，一般为主键列
            showToggle:true,                    //是否显示详细视图和列表视图的切换按钮
            cardView: false,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            columns: [
                {
                    checkbox: true
                },
                {
                    field: 'id',
                    title: 'itmeId'
                },
                {
                    field: 'Name',
                    title: '部门名称'
                }, {
                    field: 'ParentName',
                    title: '上级部门'
                }, {
                    field: 'Level',
                    title: '部门级别'
                }, {
                    field: 'Desc',
                    title: '描述'
                }
            ],
            data:[
                {
                // "checkbox": "checked",
                "id": 1,
                "Name": "张三",
                "ParentName": "张三",
                "Level": "张三",
                "Desc": "15223810923"
              },
              {
                "checkbox": 0,
                "id": 12,
                "Name": "张三",
                "ParentName": "张三",
                "Level": "张三",
                "Desc": "15223810923"
              },
              {
                "checkbox": true,
                "id": 2,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 4,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 5,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 22,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 32,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 42,
                "Name": "李四",
                "ParentName": "李四",
                "Level": "李四",
                "Desc": "15223810923wanger"
              },
              {
                "checkbox": true,
                "id": 3,
                "Name": "王二",
                "ParentName": "王二",
                "Level": "王二",
                "Desc": "1522381092haha"
              }
            ]
        });
    };
    // 得到查询的参数
    // oTableInit.queryParams = function (params) {
    //     var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
    //         limit: params.limit,   //页面大小
    //         offset: params.offset,  //页码
    //         departmentname: $("#txt_search_departmentname").val(),
    //         statu: $("#txt_search_statu").val()
    //     };
    //     return temp;
    // };
    return oTableInit;
};


// var ButtonInit = function () {
//     var oInit = new Object();
//     var postdata = {};
//     oInit.Init = function () {
//         //初始化页面上面的按钮事件
//     };
//     return oInit;
// };
 } );
    </script>
    <script>
    jQuery(function($){
        var $modal = $('#editor-modal'),
            $editor = $('#editor'),
            $editorTitle = $('#editor-title'),
            ft = FooTable.init('#showcase-example-1', {
                // columns: $.get("//127.0.0.1:3003/columns"),
                columns:[
                  {"name":"id","title":"ID","breakpoints":"xs sm","type":"number","style":{"width":80,"maxWidth":80}},
                  {"name":"firstName","title":"First Name"},
                  {"name":"lastName","title":"Last Name"},
                  {"name":"something","title":"Never seen but always around","visible":false,"filterable":false},
                  {"name":"jobTitle","title":"Job Title","breakpoints":"xs sm","style":{"maxWidth":200,"overflow":"hidden","textOverflow":"ellipsis","wordBreak":"keep-all","whiteSpace":"nowrap"}},
                  {"name":"started","title":"Started On","type":"date","breakpoints":"xs sm md","formatString":"MMM YYYY"},
                  {"name":"dob","title":"Date of Birth","type":"date","breakpoints":"xs sm md","formatString":"DD MMM YYYY"},
                  {"name":"status","title":"Status"}
                ],
                // rows: $.get("//127.0.0.1:3003/rows"),
                rows: [
                  {"id":1,"firstName":"Annemarie","lastName":"Bruening","something":1381105566987,"jobTitle":"Cloak Room Attendant","started":1367700388909,"dob":122365714987,"status":"Suspended"},
                  {"id":2,"firstName":"Nelly","lastName":"Lusher","something":1267237540208,"jobTitle":"Broadcast Maintenance Engineer","started":1382739570973,"dob":183768652128,"status":"Disabled"},
                  {"id":3,"firstName":"Lorraine","lastName":"Kyger","something":1263216405811,"jobTitle":"Geophysicist","started":1265199486212,"dob":414197000409,"status":"Active"},
                  {"id":4,"firstName":"Maire","lastName":"Vanatta","something":1317652005631,"jobTitle":"Gaming Cage Cashier","started":1359190254082,"dob":381574699574,"status":"Disabled"},
                  {"id":5,"firstName":"Whiney","lastName":"Keasler","something":1297738568550,"jobTitle":"High School Librarian","started":1377538533615,"dob":-11216050657,"status":"Active"},
                  {"id":6,"firstName":"Nikia","lastName":"Badgett","something":1283192889859,"jobTitle":"Clown","started":1348067291754,"dob":-236655382175,"status":"Active"},
                  {"id":7,"firstName":"Renea","lastName":"Stever","something":1289586239969,"jobTitle":"Work Ticket Distributor","started":1312738712940,"dob":483475202947,"status":"Disabled"},
                  {"id":8,"firstName":"Rayna","lastName":"Resler","something":1351969871214,"jobTitle":"Ordnance Engineer","started":1300981406722,"dob":267565804332,"status":"Disabled"},
                  {"id":9,"firstName":"Sephnie","lastName":"Cooke","something":1318107009703,"jobTitle":"Accounts Collector","started":1348566414201,"dob":84698632860,"status":"Suspended"},
                  {"id":10,"firstName":"Lauri","lastName":"Kyles","something":1298847936600,"jobTitle":"Commercial Lender","started":1306984494872,"dob":647549298565,"status":"Disabled"},
                  {"id":11,"firstName":"Maria","lastName":"Hosler","something":1372447291002,"jobTitle":"Auto Detailer","started":1295239832657,"dob":92796339552,"status":"Suspended"},
                  {"id":12,"firstName":"Lakeshia","lastName":"Sprinkle","something":1296451003728,"jobTitle":"Garment Presser","started":1350695946669,"dob":6068444160,"status":"Suspended"},
                  {"id":13,"firstName":"Isidra","lastName":"Dragoo","something":1285852466255,"jobTitle":"Window Trimmer","started":1264658548150,"dob":129659544744,"status":"Active"},
                  {"id":14,"firstName":"Marquia","lastName":"Ardrey","something":1336968147859,"jobTitle":"Broadcast Maintenance Engineer","started":1281348596711,"dob":69513590957,"status":"Disabled"},
                  {"id":15,"firstName":"Jua","lastName":"Bottom","something":1322560108993,"jobTitle":"Broadcast Maintenance Engineer","started":1350354712910,"dob":397465403667,"status":"Active"},
                  {"id":16,"firstName":"Delana","lastName":"Sprouse","something":1367925208609,"jobTitle":"High School Librarian","started":1360754556666,"dob":-101355021375,"status":"Disabled"},
                  {"id":17,"firstName":"Annamaria","lastName":"Pennock","something":1385602980951,"jobTitle":"Photocopying Equipment Repairer","started":1267426062440,"dob":129358493928,"status":"Active"},
                  {"id":18,"firstName":"Junie","lastName":"Leinen","something":1270540402378,"jobTitle":"Roller Skater","started":1343534987824,"dob":405467757390,"status":"Suspended"},
                  {"id":19,"firstName":"Charles","lastName":"Hayton","something":1309910398220,"jobTitle":"Ships Electronic Warfare Officer","started":1297511155831,"dob":603442557419,"status":"Disabled"},
                  {"id":20,"firstName":"Lorriane","lastName":"Roling","something":1278850931389,"jobTitle":"Industrial Waste Treatment Technician","started":1279697681249,"dob":236380359513,"status":"Disabled"},
                  {"id":21,"firstName":"Alice","lastName":"Goodlow","something":1268720188765,"jobTitle":"State Archivist","started":1381306773987,"dob":455731231484,"status":"Disabled"},
                  {"id":22,"firstName":"Carie","lastName":"Dragoo","something":1384770174557,"jobTitle":"Financial Accountant","started":1277771127047,"dob":-219020252497,"status":"Active"},
                  {"id":23,"firstName":"Gran","lastName":"Valles","something":1337645396364,"jobTitle":"Childrens Pastor","started":1288986457843,"dob":-227796663726,"status":"Suspended"},
                  {"id":24,"firstName":"Jacqulyn","lastName":"Polo","something":1326444321746,"jobTitle":"Window Trimmer","started":1301386589024,"dob":35495285174,"status":"Suspended"},
                  {"id":25,"firstName":"Whiney","lastName":"Schug","something":1307849405355,"jobTitle":"Financial Accountant","started":1306555903074,"dob":435274848084,"status":"Disabled"},
                  {"id":26,"firstName":"Dennise","lastName":"Halladay","something":1337981034973,"jobTitle":"Geophysicist","started":1322643709717,"dob":181548946421,"status":"Active"},
                  {"id":27,"firstName":"Celia","lastName":"Leister","something":1309315284479,"jobTitle":"Commercial Lender","started":1331516367758,"dob":-264359348487,"status":"Disabled"},
                  {"id":28,"firstName":"Karon","lastName":"Klotz","something":1320236999249,"jobTitle":"Route Sales Person","started":1317976956544,"dob":-305463328126,"status":"Suspended"},
                  {"id":29,"firstName":"Myesha","lastName":"Kyger","something":1314407559398,"jobTitle":"LAN Systems Administrator","started":1376934306176,"dob":-218657222188,"status":"Disabled"},
                  {"id":30,"firstName":"Beariz","lastName":"Ortego","something":1310918048393,"jobTitle":"Commercial Lender","started":1326301928745,"dob":17930742800,"status":"Suspended"},
                  {"id":31,"firstName":"Lauri","lastName":"Landa","something":1299220719823,"jobTitle":"Emergency Room Orderly","started":1278297973662,"dob":389332600186,"status":"Disabled"},
                  {"id":32,"firstName":"Lakeshia","lastName":"Cataldo","something":1276655728605,"jobTitle":"Biology Laboratory Assistant","started":1345440531397,"dob":670737968811,"status":"Active"},
                  {"id":33,"firstName":"Jack","lastName":"Goodlow","something":1359264767205,"jobTitle":"Wallpaperer Helper","started":1325417690668,"dob":390860124904,"status":"Disabled"},
                  {"id":34,"firstName":"Karon","lastName":"Weisz","something":1385661528555,"jobTitle":"Parachute Officer","started":1381228657436,"dob":258279988522,"status":"Disabled"},
                  {"id":35,"firstName":"Bernie","lastName":"Ates","something":1290416240383,"jobTitle":"Beveling and Edging Machine Operator","started":1339828820306,"dob":-241204720505,"status":"Disabled"},
                  {"id":36,"firstName":"Alonzo","lastName":"Dragoo","something":1385425643141,"jobTitle":"Route Sales Person","started":1283427599749,"dob":-43286536918,"status":"Active"},
                  {"id":37,"firstName":"Jacqulyn","lastName":"Boudreaux","something":1301509564939,"jobTitle":"Hemodialysis Technician","started":1299186053429,"dob":-28706770458,"status":"Active"},
                  {"id":38,"firstName":"Whiney","lastName":"Smelcer","something":1348107814490,"jobTitle":"Offbearer","started":1279051462500,"dob":-83372379183,"status":"Disabled"},
                  {"id":39,"firstName":"Laurena","lastName":"Ardrey","something":1317463286660,"jobTitle":"Master of Ceremonies","started":1277026873583,"dob":-265217817760,"status":"Suspended"},
                  {"id":40,"firstName":"Lashanda","lastName":"Wohlwend","something":1348081466228,"jobTitle":"Offbearer","started":1376204654140,"dob":-244248898940,"status":"Disabled"},
                  {"id":41,"firstName":"Gwyn","lastName":"Fuhrman","something":1297825975376,"jobTitle":"Internal Medicine Nurse Practitioner","started":1360899610372,"dob":666149629137,"status":"Active"},
                  {"id":42,"firstName":"Chun","lastName":"Cooke","something":1367188188482,"jobTitle":"Electrical Engineering Director","started":1263546064404,"dob":51712931971,"status":"Disabled"},
                  {"id":43,"firstName":"Mariko","lastName":"Furniss","something":1350578370165,"jobTitle":"National Association for Stock Car Auto Racing Driver","started":1309447851039,"dob":464309188120,"status":"Disabled"},
                  {"id":44,"firstName":"Londa","lastName":"Difranco","something":1302061818121,"jobTitle":"Periodontist","started":1278471697817,"dob":114612210842,"status":"Active"},
                  {"id":45,"firstName":"Junie","lastName":"Leinen","something":1288710880233,"jobTitle":"Geophysical Engineer","started":1358658207175,"dob":467506533140,"status":"Active"},
                  {"id":46,"firstName":"Chun","lastName":"Branco","something":1352564545893,"jobTitle":"LAN Systems Administrator","started":1287347506646,"dob":647599930885,"status":"Disabled"},
                  {"id":47,"firstName":"Rheba","lastName":"Branco","something":1266316091624,"jobTitle":"Telephone Lines Repairer","started":1331066862260,"dob":452152850326,"status":"Active"},
                  {"id":48,"firstName":"Isidra","lastName":"Sluss","something":1276489295656,"jobTitle":"Photocopying Equipment Repairer","started":1271941169015,"dob":288909488866,"status":"Active"},
                  {"id":49,"firstName":"Myesha","lastName":"Marco","something":1372414008480,"jobTitle":"Clinical Services Director","started":1271766890324,"dob":374650329690,"status":"Suspended"},
                  {"id":50,"firstName":"Karena","lastName":"Hosler","something":1294015640769,"jobTitle":"Automobile Body Painter","started":1280013636936,"dob":398832948998,"status":"Active"},
                  {"id":51,"firstName":"Whiney","lastName":"Falls","something":1343358865538,"jobTitle":"Childrens Pastor","started":1270853037253,"dob":-164518511726,"status":"Active"},
                  {"id":52,"firstName":"Gran","lastName":"Dauenhauer","something":1304876059529,"jobTitle":"Commercial Lender","started":1284449547894,"dob":23725605889,"status":"Active"},
                  {"id":53,"firstName":"Rona","lastName":"Nicley","something":1371323038673,"jobTitle":"Ordnance Engineer","started":1385711619364,"dob":644741897037,"status":"Disabled"},
                  {"id":54,"firstName":"Charles","lastName":"Pennock","something":1271111689368,"jobTitle":"Pipe Organ Technician","started":1313121452453,"dob":215809917048,"status":"Suspended"},
                  {"id":55,"firstName":"Phoebe","lastName":"Hallett","something":1365597767116,"jobTitle":"Scale Clerk","started":1372372052497,"dob":261671360690,"status":"Disabled"},
                  {"id":56,"firstName":"Rona","lastName":"Valles","something":1275949467931,"jobTitle":"Pipe Organ Technician","started":1383713178914,"dob":-80231579404,"status":"Disabled"},
                  {"id":57,"firstName":"Junie","lastName":"Stgelais","something":1356664390055,"jobTitle":"Emergency Room Orderly","started":1334095649576,"dob":210389956078,"status":"Suspended"},
                  {"id":58,"firstName":"Judi","lastName":"Klotz","something":1277644144793,"jobTitle":"Wood Fence Installer","started":1275855811961,"dob":539954455756,"status":"Disabled"},
                  {"id":59,"firstName":"Judi","lastName":"Stever","something":1295969453187,"jobTitle":"Scale Clerk","started":1353605624511,"dob":-227257898151,"status":"Suspended"},
                  {"id":60,"firstName":"Laurena","lastName":"Ates","something":1373875684468,"jobTitle":"Ordnance Engineer","started":1265257792022,"dob":723437534836,"status":"Suspended"},
                  {"id":61,"firstName":"Delana","lastName":"Maxton","something":1370462490417,"jobTitle":"Scale Clerk","started":1298009253232,"dob":-170766860972,"status":"Active"},
                  {"id":62,"firstName":"Annemarie","lastName":"Cataldo","something":1349111358955,"jobTitle":"Childrens Pastor","started":1339938860137,"dob":756148001098,"status":"Disabled"},
                  {"id":63,"firstName":"Beariz","lastName":"Ardrey","something":1307848809525,"jobTitle":"State Archivist","started":1328083403936,"dob":158469729667,"status":"Disabled"},
                  {"id":64,"firstName":"Jason","lastName":"Yaple","something":1322046418919,"jobTitle":"Union Representative","started":1274963639149,"dob":-42290184765,"status":"Suspended"},
                  {"id":65,"firstName":"Solomon","lastName":"Leonardo","something":1338552033174,"jobTitle":"Wood Fence Installer","started":1299246189050,"dob":548967023569,"status":"Suspended"},
                  {"id":66,"firstName":"Lizzee","lastName":"Hallett","something":1290397622447,"jobTitle":"Weight Training Instructor","started":1298391849496,"dob":315448812621,"status":"Active"},
                  {"id":67,"firstName":"Chun","lastName":"Hibler","something":1371180561438,"jobTitle":"Airline Transport Pilot","started":1325786897385,"dob":213832078486,"status":"Disabled"},
                  {"id":68,"firstName":"Junie","lastName":"Leister","something":1370855772790,"jobTitle":"Magician","started":1274400042690,"dob":567177840352,"status":"Active"},
                  {"id":69,"firstName":"Lucila","lastName":"Bottom","something":1298428240748,"jobTitle":"Commercial Lender","started":1384714584264,"dob":197489406189,"status":"Active"},
                  {"id":70,"firstName":"Shenia","lastName":"Stgelais","something":1384899230591,"jobTitle":"Hemodialysis Technician","started":1289742377230,"dob":86200175251,"status":"Suspended"},
                  {"id":71,"firstName":"Beariz","lastName":"Furniss","something":1321358118131,"jobTitle":"Serials Librarian","started":1271750637662,"dob":-1700061635,"status":"Suspended"},
                  {"id":72,"firstName":"Anonina","lastName":"Schug","something":1365931268373,"jobTitle":"Industrial Waste Treatment Technician","started":1300732223840,"dob":524208129562,"status":"Suspended"},
                  {"id":73,"firstName":"Rigobero","lastName":"Keasler","something":1334213897296,"jobTitle":"Post-Anesthesia Care Unit Nurse","started":1381474649060,"dob":312625171296,"status":"Suspended"},
                  {"id":74,"firstName":"Muriel","lastName":"Lafromboise","something":1337309408774,"jobTitle":"Roller Skater","started":1368734853445,"dob":-299233500103,"status":"Disabled"},
                  {"id":75,"firstName":"Laurena","lastName":"Valles","something":1366490868427,"jobTitle":"Childcare Center Administrator","started":1313362574426,"dob":743244140743,"status":"Disabled"},
                  {"id":76,"firstName":"Lorraine","lastName":"Carasco","something":1346720156399,"jobTitle":"Technical Writer","started":1321622236813,"dob":449808416414,"status":"Suspended"},
                  {"id":77,"firstName":"Neie","lastName":"Quaranta","something":1340756928057,"jobTitle":"Geophysical Engineer","started":1290642157370,"dob":579103375368,"status":"Active"},
                  {"id":78,"firstName":"Claudine","lastName":"Letts","something":1380403442822,"jobTitle":"Broadcast Maintenance Engineer","started":1344418507955,"dob":497860170791,"status":"Active"},
                  {"id":79,"firstName":"Doy","lastName":"Mosher","something":1381492674398,"jobTitle":"LAN Systems Administrator","started":1383492070886,"dob":313398281206,"status":"Suspended"},
                  {"id":80,"firstName":"Doy","lastName":"Dauenhauer","something":1326852382094,"jobTitle":"Aircraft Landing Gear Inspector","started":1328266893960,"dob":622334288715,"status":"Suspended"},
                  {"id":81,"firstName":"Ilona","lastName":"Hogle","something":1379728572228,"jobTitle":"Post-Anesthesia Care Unit Nurse","started":1347561807688,"dob":347532519012,"status":"Active"},
                  {"id":82,"firstName":"Jacqulyn","lastName":"Hibler","something":1348017063340,"jobTitle":"Hemodialysis Technician","started":1309053572070,"dob":420086000556,"status":"Disabled"},
                  {"id":83,"firstName":"Shona","lastName":"Valles","something":1346814216720,"jobTitle":"Geophysical Engineer","started":1280015397474,"dob":-296028769678,"status":"Active"},
                  {"id":84,"firstName":"Sephnie","lastName":"Stgelais","something":1291893133524,"jobTitle":"Beveling and Edging Machine Operator","started":1358574804278,"dob":514650425817,"status":"Disabled"},
                  {"id":85,"firstName":"Venice","lastName":"Matsumura","something":1335418283321,"jobTitle":"Childrens Pastor","started":1274131178238,"dob":100657405744,"status":"Suspended"},
                  {"id":86,"firstName":"Alonzo","lastName":"Hibler","something":1336830772752,"jobTitle":"Propeller-Driven Airplane Mechanic","started":1315978241383,"dob":207878629300,"status":"Suspended"},
                  {"id":87,"firstName":"Cyndy","lastName":"Wadkins","something":1375185012899,"jobTitle":"Window Trimmer","started":1369617393878,"dob":-279401611387,"status":"Suspended"},
                  {"id":88,"firstName":"Annea","lastName":"Hibler","something":1296799940657,"jobTitle":"Strawberry Sorter","started":1305458404152,"dob":625424603571,"status":"Disabled"},
                  {"id":89,"firstName":"Celia","lastName":"Hibler","something":1388389757412,"jobTitle":"Jig Bore Tool Maker","started":1358180149613,"dob":72655242898,"status":"Disabled"},
                  {"id":90,"firstName":"Laurena","lastName":"Klotz","something":1312724442772,"jobTitle":"Hydroelectric Machinery Mechanic","started":1291043285485,"dob":-315004906495,"status":"Active"},
                  {"id":91,"firstName":"Jua","lastName":"Vanatta","something":1343300771926,"jobTitle":"Animal Husbandry Manager","started":1338911658975,"dob":-233816779922,"status":"Disabled"},
                  {"id":92,"firstName":"Rona","lastName":"Halladay","something":1308403637621,"jobTitle":"Staff Electronic Warfare Officer","started":1324189448326,"dob":187959761088,"status":"Suspended"},
                  {"id":93,"firstName":"Desmond","lastName":"Lafromboise","something":1367503406501,"jobTitle":"Blackjack Supervisor","started":1284064043518,"dob":-192057374436,"status":"Disabled"},
                  {"id":94,"firstName":"Ilda","lastName":"Difranco","something":1322164346137,"jobTitle":"Work Ticket Distributor","started":1304532521629,"dob":194255714243,"status":"Suspended"},
                  {"id":95,"firstName":"Ami","lastName":"Haner","something":1332781031595,"jobTitle":"Aircraft Landing Gear Inspector","started":1381600160153,"dob":284819714749,"status":"Disabled"},
                  {"id":96,"firstName":"Renaa","lastName":"Leister","something":1315473522199,"jobTitle":"Drywall Stripper","started":1363382105359,"dob":239192801814,"status":"Suspended"},
                  {"id":97,"firstName":"Easer","lastName":"Smelcer","something":1355943317755,"jobTitle":"Blackjack Supervisor","started":1267228580779,"dob":35361496970,"status":"Suspended"},
                  {"id":98,"firstName":"Jacqulyn","lastName":"Vanatta","something":1374921304329,"jobTitle":"Youth Pastor","started":1278573829451,"dob":705821964664,"status":"Suspended"},
                  {"id":99,"firstName":"Rayna","lastName":"Leister","something":1288850759218,"jobTitle":"Periodontist","started":1377850593881,"dob":-306045605184,"status":"Active"},
                  {"id":100,"firstName":"Anonina","lastName":"Hyland","something":1365145994979,"jobTitle":"Aircraft Landing Gear Inspector","started":1376456146247,"dob":460732752870,"status":"Disabled"},
                  {"id":101,"firstName":"Renea","lastName":"Sinclair","something":1381071330133,"jobTitle":"Animal Husbandry Manager","started":1268331521787,"dob":756817183954,"status":"Disabled"},
                  {"id":102,"firstName":"Carie","lastName":"Landa","something":1374093955832,"jobTitle":"Strawberry Sorter","started":1340574609178,"dob":533844431585,"status":"Active"},
                  {"id":103,"firstName":"Alonzo","lastName":"Shumpert","something":1376941694429,"jobTitle":"Roller Skater","started":1364616170920,"dob":265449995450,"status":"Active"},
                  {"id":104,"firstName":"Sanford","lastName":"Keasler","something":1276833111559,"jobTitle":"Electrical Engineering Director","started":1271461426389,"dob":-243179799722,"status":"Active"},
                  {"id":105,"firstName":"Anonina","lastName":"Hayton","something":1294298068407,"jobTitle":"Cloak Room Attendant","started":1269486656038,"dob":725562610325,"status":"Active"},
                  {"id":106,"firstName":"Maple","lastName":"Wadkins","something":1385172680489,"jobTitle":"Periodontist","started":1306605507385,"dob":-292668657944,"status":"Suspended"},
                  {"id":107,"firstName":"Annamaria","lastName":"Furniss","something":1335401051491,"jobTitle":"Aviation Tactical Readiness Officer","started":1352628077858,"dob":88001820113,"status":"Disabled"},
                  {"id":108,"firstName":"Gwyn","lastName":"Cataldo","something":1308700320703,"jobTitle":"Employment Clerk","started":1276257362092,"dob":-254291170149,"status":"Disabled"},
                  {"id":109,"firstName":"Renea","lastName":"Landa","something":1326852080696,"jobTitle":"Technical Writer","started":1297426590106,"dob":442604022208,"status":"Suspended"},
                  {"id":110,"firstName":"Rona","lastName":"Leister","something":1381276170421,"jobTitle":"High School Librarian","started":1383354349296,"dob":169447218344,"status":"Disabled"}
                ],
                editing: {
                    enabled: true,
                    addRow: function(){
                        $modal.removeData('row');
                        $editor[0].reset();
                        $editorTitle.text('Add a new row');
                        $modal.modal('show');
                    },
                    editRow: function(row){
                        var values = row.val();
                        $editor.find('#id').val(values.id);
                        $editor.find('#firstName').val(values.firstName);
                        $editor.find('#lastName').val(values.lastName);
                        $editor.find('#jobTitle').val(values.jobTitle);
                        $editor.find('#status').val(values.status);
                        $editor.find('#startedOn').val(values.started.format('YYYY-MM-DD'));
                        $editor.find('#dob').val(values.dob.format('YYYY-MM-DD'));
                        $modal.data('row', row);
                        $editorTitle.text('Edit row #' + values.id);
                        $modal.modal('show');
                    },
                    deleteRow: function(row){
                        if (confirm('Are you sure you want to delete the row?')){
                            row.delete();
                        }
                    }
                }
            }),
            uid = 110;
        // 保存一行
        $editor.on('submit', function(e){
            if (this.checkValidity && !this.checkValidity()) return;
            e.preventDefault();
            var row = $modal.data('row'),
                values = {
                    id: $editor.find('#id').val(),
                    firstName: $editor.find('#firstName').val(),
                    lastName: $editor.find('#lastName').val(),
                    jobTitle: $editor.find('#jobTitle').val(),
                    started: moment($editor.find('#startedOn').val(), 'YYYY-MM-DD'),
                    dob: moment($editor.find('#dob').val(), 'YYYY-MM-DD'),
                    status: $editor.find('#status option:selected').val()
                };

            if (row instanceof FooTable.Row){
                row.val(values);
            } else {
                values.id = uid++;
                ft.rows.add(values);
            }
            $modal.modal('hide');
        });
    });    
    </script>
    </body>
</html>

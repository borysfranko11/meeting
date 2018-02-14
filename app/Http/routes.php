<?php

/*
|--------------------------------------------------------------------------
| 路由配置说明
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
    # 不通过控制器直接访问页面, 直接访问 welcome
    Route::any('/', function () {
        return view('welcome');
    });
*/

Route::get('503', function () {
    return view('errors/503');
});

Route::group( ['middleware' => ['auth']], function()
{
    Route::any( '/', 'MainController@index' );
    Route::any( '/Dashboard/index', 'DashboardController@index' );

    Route::any( '/Rfp/index', 'RfpController@index' );
    //Route::any( '/Rpf/create/id/{_id?}', 'RpfController@create' )->where(['id' => '[0-9]+']);
    Route::any( '/Rfp/create', 'RfpController@create' );
    Route::any( '/Rfp/edit', 'RfpController@edit' );
    Route::any( '/Rfp/list', 'RfpController@rfpList' );
    Route::post( '/Rfp/links', 'RfpLinkController@index' );
    Route::post( '/Rfp/correlate', 'RfpLinkController@correlate' );
    Route::any( '/Rfp/confirm/memo', [
        'as'    => 'rcm',
        'uses'  => 'RfpController@confirmMemo'
    ] )->name( 'rcm' );
    Route::any( '/Rfp/getOfferRank', [
    'as'    => 'rcma',
    'uses'  => 'RfpController@getOfferRank'
        ] )->name( 'rcma' );
    Route::any( '/Order/index', 'OrderController@index' );
    Route::any( '/Statistical/detail', 'StatisticalController@detail' );
    Route::any( '/Statistical/monthly', 'StatisticalController@monthly' );
    Route::any( '/Statistical/analysis', 'StatisticalController@analysis' );
    Route::any( '/User/index', 'UserController@index' );
    Route::any( '/User/editMsg', 'UserController@editMsg' );
    Route::any( '/User/increase', 'UserController@increase' );
    Route::any( '/User/verify', 'UserController@verify' );
    Route::any( '/User/profile/id/{name?}', 'UserController@profile' );
    Route::any( '/User/personal/id/{name?}', 'UserController@personal' );
    Route::any( '/Logs/index', 'LogsController@index' );
    Route::any( '/Logs/detail', 'LogsController@detail' );

    Route::any( '/Jump/back', 'JumpController@back' );
    Route::any( '/Jump/any', 'JumpController@any' );
    Route::any( '/Jump/success', 'JumpController@success' );


    // 创建会议相关
    Route::any( '/Meeting/create', 'MeetingController@create' );
    Route::any( '/Meeting/preview', 'MeetingController@preview' );
    Route::any( '/Meeting/check', 'MeetingController@check' );
    Route::any( '/Meeting/createsubmit', 'MeetingController@createSubmit' );
    Route::any( '/Meeting/saveSubmit', 'MeetingController@saveSubmit' );
    Route::any( '/Meeting/uploadFile', 'MeetingController@uploadFile' );
    Route::any( '/Meeting/createDeposit', 'MeetingController@createDeposit' );
    Route::any( '/Meeting/getMeetingType', 'MeetingController@getMeetingType' );
    Route::any( '/Meeting/getRfpBudget', 'MeetingController@getRfpBudget' );
    Route::any( '/Meeting/getDepositPerson', 'MeetingController@getDepositPerson' );
    Route::any( '/Meeting/getDepartment', 'MeetingController@getDepartment' );
    Route::any( '/Meeting/getMarketorg', 'MeetingController@getMarketorg' );
    Route::any( '/Meeting/edit', 'MeetingController@edit' );
    Route::any( '/Meeting/editajax', 'MeetingController@editajax' );
    Route::any( '/Meeting/getMeetingBitTypes', 'MeetingController@getMeetingBitTypes' );

    // 会议审核
    Route::any( '/Meeting/checkMeeting', 'MeetingController@checkMeeting' );
    Route::any( '/Meeting/noticeAuthor', 'MeetingController@noticeAuthor' );                        // 提醒审核人

    // 确认水单
    Route::any( '/Memo/preview', 'MemoController@preview' );
    Route::any( '/Memo/confirmMemo', 'MemoController@confirmMemo' );
    Route::any( '/Memo/confirm_memo', 'MemoController@confirm_memo' );
    Route::any( '/Memo/save_memo', 'MemoController@save_memo' );
    Route::any( '/Memo/uploadFile', 'MemoController@uploadFile' );                                 // 上传水单
    Route::any( '/Memo/memo_detail', 'MemoController@memo_detail' );                                // 水单详细信息
    Route::any( '/Memo/getUpname', 'MemoController@getUpname' );                                    // 获取上会人

    // 统计相关
    Route::any( '/Statistical/getMeetingStatus', 'StatisticalController@getMeetingStatus' );        // 获取会议状态
    Route::any( '/Statistical/meetingDetail', 'StatisticalController@meetingDetail' );              // 会议明细
    Route::any( '/Statistical/exportDetail', 'StatisticalController@exportDetail' );                // 导出会议明细
    Route::any( '/Statistical/monthlyStatement', 'StatisticalController@monthlyStatement' );        // 月结列表
    Route::any( '/Statistical/monStatementDetail', 'StatisticalController@monStatementDetail' );    // 月结详情
    Route::any( '/Statistical/monStaMeeting', 'StatisticalController@monStaMeeting' );              // 月结单个会议详情

    // 订单
    Route::any( '/Order/orderDetail', 'OrderController@orderDetail' );          //查看异步获取数据
    Route::any( '/Order/preview', 'OrderController@preview' );                  //查看
    Route::any( '/Order/confirm', 'OrderController@confirm' );                  // 确认下单
    Route::any( '/Order/wine', 'OrderController@wine' );                        // 酒水list
    Route::any( '/Order/winePreview', 'OrderController@winePreview' );          // 查看酒水订单
    Route::any( '/Order/ordermemo', 'OrderController@ordermemo' );          // 查看水单图片


    // 消息相关
    Route::any( '/Notice/getNotice', 'NoticeController@getNotice' );            // 首页日历消息
    Route::any( '/Notice/getLogs', 'NoticeController@getLogs' );                // 首页消息通知
    Route::any( '/Notice/getLogsNum', 'NoticeController@getLogsNum' );          // 今日未读消息


    Route::any( '/Rfp/cancel', 'RfpController@cancel' );
    // 询单快照
    Route::any( '/Rfp/preview', 'RfpController@preview' );
    Route::any( '/Rfp/preview_confim', 'RfpController@confimPreview' );
    Route::any( '/Order/rfpDetail', 'OrderController@rfpDetail' );

    // 城市商圈火车站机场等等
    /*Route::any( '/Rfp/getAreaCity', 'RfpController@getAreaCity' );
    Route::any( '/Rfp/getProvinces', 'RfpController@getProvinces' );*/
    Route::any( '/Rfp/getHotBusinessDistrict', 'RfpController@getHotBusinessDistrict' );
    Route::any( '/Rfp/getDisplayAirport', 'RfpController@getDisplayAirport' );
    Route::any( '/Rfp/getDisplayTrainStation', 'RfpController@getDisplayTrainStation' );
    Route::any( '/Rfp/getMetroLines', 'RfpController@getMetroLines' );
    Route::any( '/rfp/create_rfp', 'RfpController@createRfp' );
    Route::any( '/rfp/send_rfp', 'RfpController@sendRfp' );
    Route::any( '/rfp/get_offer_list', 'RfpController@getOfferList' );
    Route::any( '/rfp/down_order', 'RfpController@downOrder' );
    Route::any( '/Rfp/recommend', 'RfpController@recommend' );
    Route::any( '/Rfp/main_recommend', 'RfpController@mainRecommend' );

    // 场地相关

    Route::any( '/place/get_place_detail', 'PlaceController@getPlaceDetail' );
    Route::any( '/place/set_hotel', 'PlaceController@setHotel' );

    // 查看场地详情
    Route::any( '/place/place_view', 'PlaceController@place_view' );
    Route::any( '/place/placeFuzzyRetrieval', 'PlaceController@placeFuzzyRetrieval' );

    //wap
    Route::any( '/wap/index', 'WapController@index' );
    Route::any( '/wap/ajax_index', 'WapController@ajax_index' );
    Route::any( '/wap/confirm_memo', 'WapController@confirm_memo' );
    Route::any( '/wap/memo_detail', 'WapController@memo_detail' );

    // 留言
    Route::any( '/message/get_message', 'MessageController@getMessage' );
    Route::any( '/message/save_message', 'MessageController@saveMessage' );

    //参会人员管理
    Route::any('/join/index','JoinusersController@index');                  # 参会人列表
    Route::get('/join/template','JoinusersController@template');            #参会人下载模板
    Route::post('/join/import','JoinusersController@import');
    Route::post('/join/export','JoinusersController@export');               # 参会人导出
    Route::any('/join/del','JoinusersController@delJoinUser');              # 参会人删除
    Route::get('/join/add','JoinusersController@addJoinUser');              # 参会人新增  V
    Route::post('/join/ins','JoinusersController@userInsert');              # 参会人新增  C
    Route::any('/join/addbatch','JoinusersController@addOftenToJoin');     # 从常用参会人中批量导入至参会人
    Route::get('/join/info','JoinUserInfoController@index');                # 参会人详情
    Route::get('/Join/edit','JoinUserInfoController@edit');                 # 参会人信息修改  V
    Route::any('/Join/update','JoinUserInfoController@update');             # 参会人信息修改  C

    // 出行 住宿 用车管理
    Route::get('/Manage/addOrEdit','JoinUserInfoController@addOrEditOther');               # 参会人 出行/住宿/用车 新增/修改 iframe页
    Route::post('/Manage/delTra','JoinUserInfoController@delTravel');                       # 参会人 删除出行信息
    Route::post('/Manage/delAcc','JoinUserInfoController@delAcc');                          # 参会人 删除住宿信息
    Route::post('/Manage/delCar','JoinUserInfoController@delUseCar');                       # 参会人 删除用车信息
    Route::post('/Manage/addOrUpdateTra','JoinUserInfoController@updateOrAddTravel');      # 参会人出行信息新增/修改
    Route::post('/Manage/addOrUpdateAcc','JoinUserInfoController@updateOrAddAcc');         # 参会人住宿信息新增/修改
    Route::post('/Manage/addOrUpdateCar','JoinUserInfoController@updateOrAddUseCar');      # 参会人用车信息新增/修改

    // 确认信息
    Route::get('/Confirm/add','JoinUserInfoController@confirmIndex');               # 确认参会人信息页
    Route::post('/Confirm/insert','JoinUserInfoController@addJoinUserConfirm');    # 添加参会人确认信息

    //常用参会人
    Route::any('/often/iframe','OftenUsersController@indexIframe');             # 常用参会人 iframe 列表页
    Route::get('/Often/updataiframe','OftenUsersController@updateIframe');      # 修改参会人 引入的iframe 列表页
    Route::any('/Often/index','OftenUsersController@index');                     # 常用参会人 列表页
    Route::post('/Often/getinfo','OftenUsersController@getOftenInfo');          # 常用参会人 列表页
    Route::any('/Often/store','OftenUsersController@store');                     # 添加常用参会人
    Route::any('/Often/update','OftenUsersController@update');                   # 修改常用参会人
    Route::any('/Often/delJoinUser','OftenUsersController@delJoinUser');        # 删除常用参会人


    //邀请函invitation_tpl
    Route::any('/Invitation/lists','InvitationController@lists');            # 邀请函列表
    Route::get('/Invitation/index','InvitationController@show');           #  邀请函详情
    Route::get('/Invitation/iframe','InvitationController@iframe');          #  邀请函修改/新增     V
    Route::any('/Invitation/addOrUpdate','InvitationController@updateOrAdd');     #  邀请函插入/更新     C





    Route::any('/Confirm/index','TravelController@index');   #参会人出行信息列表
    Route::get('/Confirm/template','TravelController@template');   #参会人出行信息模板下载
    Route::post('/Confirm/import','TravelController@import');   #参会人出行信息文件导入
    Route::post('/Confirm/export','TravelController@export');   #参会人出行信息文件导出
    Route::get('/Confirm/actual_travel','TravelController@actual_travel');   #参会人出行信息与意向不符时查看数据
    Route::any('/Action/index','AccommodationController@index');   #参会人住宿信息列表
    Route::any('/Action/template','AccommodationController@template');   #参会人住宿信息模板下载
    Route::any('/Action/import','AccommodationController@import');   #参会人住宿信息文件导入
    Route::any('/Action/export','AccommodationController@export');   #参会人住宿信息文件导出
    Route::any('/UserCar/index','UserCarController@index');   #参会人用车信息列表
    Route::any('/UserCar/template','UserCarController@template');   #参会人用车信息模板下载
    Route::post('/UserCar/import','UserCarController@import');   #参会人用车信息文件导入
    Route::post('/UserCar/export','UserCarController@export');   #参会人用车信息文件导出
    Route::any('/Statistics/list','StatisticsController@statisticsList'); //费用统计列表
    Route::get('/Statistics/statistics','StatisticsController@Statistics'); //费用统计Excel导出

    //服务商管理
    Route::any('/Servers/index','ServersController@index');         //服务商管理
    Route::get('/Servers/create','ServersController@create');         //服务商添加页面
    Route::post('/Servers/insert','ServersController@insert');         //服务商添加
    Route::post('/Servers/update','ServersController@update');         //服务商修改
    Route::post('/Servers/change','ServersController@changeStatus');         //服务商修改
    Route::get('/Servers/info','ServersController@info');         //服务商信息查看页在
    
    Route::get('/Servers/staff','ServersController@staff');         //服务商员工添加或修改页面
    Route::post('/Servers/staff_insert','ServersController@staffInsert');         //服务商员工添加
    Route::post('/Servers/staff_update','ServersController@staffUpdate');         //服务商员工修改
    Route::post('/Servers/staff_del','ServersController@delStaff');         //服务商员工修改
    Route::any('/Servers/search_city','ServersController@SearchCity');         //查询城市、区


    Route::get('/Statistics/statistics','StatisticsController@Statistics'); //费用统计
    Route::get('/send/index','SendInvitationsController@index'); //发送邀请函页面渲染


    Route::post('/send/send_out','SendInvitationsController@send_out'); //发送邀请函执行
    Route::post('/send/send_notice','SendInvitationsController@send_notice'); //发送通知执行
    Route::get('/send/inform','SendInvitationsController@inform'); //发送通知


    //钱包管理
    Route::any('/Wallet/index','WalletController@index'); //钱包首页
    Route::any('/Wallet/binding','WalletController@binding'); //绑卡操作
    Route::any('/Wallet/bindingCard','WalletController@bindingCard');
    Route::any('/Wallet/resetting','WalletController@resetting');
    Route::any('/Wallet/getMoney','WalletController@getMoney');
    Route::any('/Wallet/withdrawals','WalletController@withdrawals');
    Route::any('/Wallet/pay','WalletController@pay');
    Route::any('/Order/getPayInstrument','OrderController@getPayInstrument');



    //出行管理
//    Route::any("/Rfp/index",function(){
//        return view("rfp.travel");
//    });
} );
Route::get('/h5/index','H5InvitationController@index'); //邀请函h5页面
Route::get('/h5/invitation','H5InvitationController@invitation'); //邀请函h5页面
Route::get('/h5/qr_code','H5InvitationController@qr_code'); //邀请函二维码页面
Route::any('/h5/confirm','H5InvitationController@confirm'); //邀请函信息添加

Route::any( '/Login/index', 'LoginController@index' );                                                                  // 响应所有 HTTP 行为, GET POST
Route::any( '/Login/out', 'LoginController@out' );
Route::any( '/Login/ins', 'LoginController@ins' );
Route::any( '/Rfp/getAreaCity', 'RfpController@getAreaCity' );
Route::any( '/Rfp/getAllCity', 'RfpController@getAllCitiesOrderbyAbcd' );
Route::any( '/Rfp/getProvinces', 'RfpController@getProvinces' );
Route::any( '/Rfp/getCityName', 'RfpController@getCityNameById' );
Route::any( '/place/get_place', 'PlaceController@getPlaceBySearch' );
Route::any( '/place/get_place_main', 'PlaceController@getPlaceBySearchMain' );
Route::any( '/dinner/user_add', 'BookdinnerController@userAdd' );
Route::any( '/dinner/user_edit', 'BookdinnerController@userEdit' );
Route::any( '/dinner/user_del', 'BookdinnerController@userDel' );
Route::any( '/dinner/sellerJoin', 'BookdinnerController@sellerJoin' );
Route::any( '/dinner/validateStatus', 'BookdinnerController@validateStatus' );
Route::any( '/dinner/businessOrderIdsQuery', 'BookdinnerController@businessOrderIdsQuery' );
Route::any( '/dinner/businessOrderQuery', 'BookdinnerController@businessOrderQuery' );
Route::any( '/dinner/orderPay', 'BookdinnerController@orderPay' );
Route::any( '/dinner/orderPayInfo', 'BookdinnerController@orderPayInfo' );

Route::any('/Wallet/getArea','WalletController@getArea'); //获取地区
Route::any('/Wallet/getBank','WalletController@getBank'); //获取银汉
Route::any('/Wallet/callback','WalletController@callBack');//
Route::any('/Wallet/checkPass','WalletController@checkPass');//验证密码
Route::any( '/Statistical/save_settlement', 'StatisticalController@saveRfpSettlement' );//接收发票与结算信息
//Route::any( '/Login/qrcode', 'LoginController@qrcode' );

//酒店客房信息
Route::any( '/place/placeRoomInfo', 'PlaceController@place_view_roominfo' );

/* Added by Ninja 2018 - 2- 12*/
//Service Router

//Login Router --- 会议主办员 和 服务商 登录 功能
Route::post('/service/login','ServiceController@login');
Route::post('/service/check_captcha','ServiceController@check_captcha');
Route::post('/service/renew_captcha','ServiceController@renew_captcha');
Route::post('/service/request_captcha','ServiceController@request_captcha');
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的会议</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/css/wap/sm.css">
    <link rel="stylesheet" href="/assets/css/wap/extend/sm-extend.css">
    <link rel="stylesheet" href="/assets/css/wap/iconfont.css">
    <link rel="stylesheet" href="/assets/css/wap/style_min.css">
    <link rel="stylesheet" href="/assets/css/wap/zsh.css">
</head>

<body>
    <div class="page-group">
        <div class="page page-current clearfix">
            <div class="personal_info">
                <div class="infobox">
                    <!-- <div id="test" class="user_img"><img src="/assets/img/userBg_02.png" /></div> -->
                    <div class="com_user">
                        <div class="dataName"><?php echo $user_info['username'];?>，你好！</div>
                    </div>
                </div>
            </div>
            <div class="buttons-tab">
                <a id="but1" class="button <?php if ($meeting_status == '')echo 'active';?>" href="index"  external>所有会议</a>
                <a id="but2" href="index?meeting_status=20" class="button  <?php if ($meeting_status === '20')echo 'active';?>" external>待发询单</a>
                <a id="but3" href="index?meeting_status=30" class="button  <?php if ($meeting_status == '30')echo 'active';?>" external>待确认场地</a>
                <a id="but4" href="index?meeting_status=40" class="button  <?php if ($meeting_status == '40')echo 'active';?>" external>待确认水单</a>
            </div>

            <div class="content clearfix infinite-scroll infinite-scroll-bottom" data-distance="100" style="top:5.5rem; bottom:1.55rem;">
                <div class="content-block m-none p-none">
                        <div id="tab1" class="tab active">
                            <div class="content-block m-none p-none">
                                <!-- <p>This is tab 1 content</p> -->
                                <?php if (empty($res)){?>                                   
                                    <div class="content-padded statebg text-center" >
                                        <img src="/assets/img/statebg_01.png" alt="">
                                        <h5 class="m-none gray_color">没有当前状态会议</h5>
                                    </div>
                                <?php } ?>
                                <?php foreach ($res as $k => $v) { ?>
                                    <div class="card space-5">
                                    <div class="card-header">
                                        <div class="memo_name"><?php echo $v['meeting_code'];?></br><?php echo $v['meeting_name']; ?></div>
                                        <div class="pull-right state_t red_color">● <?php echo $v['status_name'];?></div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-content-inner clearfix">
                                            <div class="grid-demo space-5">
                                                <div class="row">
                                                    <div class="col-33 gray_color">时&nbsp;&nbsp;&nbsp;&nbsp;间：</div>
                                                    <div class="col-66 text-left gray_color"><?php echo $v['start_time'].'~'.$v['end_time'];?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-33 gray_color">地&nbsp;&nbsp;&nbsp;&nbsp;点：</div>
                                                    <div class="col-66 text-left gray_color"><?php echo $v['provincedesc'].$v['citydesc'];?> </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-33 gray_color">预&nbsp;&nbsp;&nbsp;&nbsp;算：</div>
                                                    <div class="col-66 text-left gray_color">¥<?php echo $v['budget_total_amount'];?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-33 gray_color">负责人：</div>
                                                    <div class="col-66 text-left gray_color"><?php echo $v['user_name'];?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-40 gray_color" style="width:33%">计划参会人数：</div>
                                                    <div class="col-60 text-left gray_color m-l-none"><?php echo $v['people_num'];?>人</div>
                                                </div>
                                                <?php if (((int)$v['status'] == 40) && $role == 'create') { ?>
                                                <div class="btn_box"><a href="/wap/confirm_memo?rfp_id=<?= $v['rfp_id'] ?>" class="button" external>确认水单及支出</a></div>
                                                <?php };?>
                                                <?php if ((int)$v['status'] == 50) { ?>
                                                <div class="tfed" ><img src="/assets/img/finish.png" alt=""></div>
                                                <div class="btn_box"><a href="/wap/memo_detail?rfp_id=<?= $v['rfp_id'] ?>" class="button" external>查看已确认水单</a></div>
                                                <?php };?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }; ?>
                                <!-- <p>This is tab 4 content</p> -->
                            </div>
                              <!-- 加载提示符 -->
                            <div class="infinite-scroll-preloader" style="display:none">
                                <div class="preloader"></div>
                            </div>


                        </div>
                </div>            
            </div>
                 <div class="operation_box border-t">
                <button  type="button" class="btn button white_bg black_color border-none flex-2" style="float:left; width:70%"><a href="tel:01056296960"><i class="icon iconfont green_color m-t-n-xxs3">&#xe619;</i> 联系会唐客服:010-56296960</a></button>
            <!--     <a href="/login/wap_logout" class="btn button dark_grey_bg white_color border-none flex-1" style="display:inline-block; width:30%" external><i class="icon iconfont  white_color m-t-n-xxs3">&#xe66f;</i> 退出系统</a> -->
                </div>

        </div>
    </div>
            <script type='text/javascript' src='/assets/js/wap/zepto.js' charset='utf-8'></script>
            <script type='text/javascript' src='/assets/js/wap/sm.js' charset='utf-8'></script>
            <script type='text/javascript' src='/assets/js/wap/extend/sm_extend.js' charset='utf-8'></script>
            <script>

                var myconfig ={
                    'cur_user_ad':'<?= $user_info['id'] ?>'
                };

         function getQueryString(name) { 
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
                var r = window.location.search.substr(1).match(reg); 
                if (r != null) return unescape(r[2]); return null; 
                }
                var num= getQueryString('meeting_status');
                var page=2;
                var loading = false;
                var hasdata = true;
                function getnextPage(){
                    console.log('get_more_meeting请求第几页？',page)

                loading = true;
                $('.infinite-scroll-preloader').show();

                $.post("/wap/ajax_index", { "meeting_status": num ,"page": page,"_token":$('meta[name="csrf-token"]').attr('content')},
                       function(datas,status){
                            var data = datas.data;
                            var role = datas.role;
                       if (status == 'success') {
                           $('.infinite-scroll-preloader').hide();

                            if (data.length == 0) {
                                hasdata=false;
                                $.alert('已经没有更多数据了');
                            }else{

                                 var str ='';
                                for (var i = 0; i < data.length; i++) {
                                    var btn_str = '';
                                    if (parseInt(data[i].status) == 40 && role == 'create') {
                                        btn_str = '<div class="btn_box"><a href="/wap/confirm_memo?rfp_id='+data[i].rfp_id+'" class="button" external>确认水单及支出</a></div>';
                                    }else if (parseInt(data[i].status) == 50) {
                                        btn_str = '<div class="tfed" ><img src="/assets/img/finish.png"></div>'
                                                    +'<div class="btn_box"><a href="/wap/memo_detail?rfp_id='+data[i].rfp_id+'" class="button" external>查看已确认水单</a></div>';
                                    }
                                str += '<div class="card space-5">'
                                    +'<div class="card-header">'                              
                                        +'<div class="memo_name">'+data[i].meeting_code+'</br>'+data[i].meeting_name+'</div>'
                                        +'<div class="pull-right state_t red_color">●'+data[i].status_name+'</div>'
                                    +'</div>'
                                    +'<div class="card-content">'
                                        +'<div class="card-content-inner clearfix">'
                                            +'<div class="grid-demo space-5">'
                                                +'<div class="row">'
                                                    +'<div class="col-33 gray_color">时&nbsp;&nbsp;&nbsp;&nbsp;间：</div>'
                                                    +'<div class="col-66 text-left gray_color">'+data[i].start_time+'~'+data[i].end_time+'</div>'
                                                +'</div>'
                                                +'<div class="row">'
                                                    +'<div class="col-33 gray_color">地&nbsp;&nbsp;&nbsp;&nbsp;点：</div>'
                                                    +'<div class="col-66 text-left gray_color">'+data[i].provincedesc+data[i].citydesc+'</div>'
                                                +'</div>'
                                                +'<div class="row">'
                                                    +'<div class="col-33 gray_color">预&nbsp;&nbsp;&nbsp;&nbsp;算：</div>'
                                                    +'<div class="col-66 text-left gray_color">¥'+data[i].budget_total_amount+'</div>'
                                                +'</div>'
                                                +'<div class="row">'
                                                    +'<div class="col-33 gray_color">负责人：</div>'
                                                    +'<div class="col-66 text-left gray_color">'+data[i].user_name+'</div>'
                                                +'</div>'
                                                +'<div class="row">'
                                                    +'<div class="col-40 gray_color" style="width:33%">计划参会人数：</div>'
                                                    +'<div class="col-60 text-left gray_color m-l-none">'+data[i].people_num+'人</div>'
                                                +'</div>'
                                                +btn_str
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="tfed" style="display:none;"><img src="/assets/img/finish.png" alt=""></div>'
                                +'</div>';
                                   
                                }

                                $(".tab .content-block").append($(str));
                                  loading=false;
                                  page++;

                            }
                       }            
                    }, "json");                 
            };
                 $.init();
                $(document).on('infinite', '.infinite-scroll-bottom',function(){
                      // 如果正在加载，则退出
                          if (loading) return;
                          if(!hasdata) return;
                        
                          getnextPage()
          
                })
            </script>

</body>

</html>
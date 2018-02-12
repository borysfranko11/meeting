<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/assets/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="/assets/css/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <link href="/assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <!-- 首页样式的文件 -->
    <link href="/assets/css/home/home.css" rel="stylesheet">
    <style type="text/css">
        .ibox-title{border-width: 1px 0 0;}
        canvas{top:15px!important;}
    </style>
</head>
<div class="wrapper wrapper-content" style="background:  #f3f6fb">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <!-- <div class="ibox-title">
                    <h5>我的会议</h5>
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white active">天</button>
                            <button type="button" class="btn btn-xs btn-white">月</button>
                            <button type="button" class="btn btn-xs btn-white">年</button>
                        </div>
                    </div>
                </div> -->
                <div class="ibox-co">
                    <div class="row" >
                        <div class="col-sm-3" style="width: 100%">
                            <div class="ibox-content" style="border-top-width: 0;padding-right: 0;padding-left: 0;padding-top: 0; background: none">
                                <ul class="stat-list" style="width:100%; display: flex;justify-content: space-between;align-items: center;">
                                    <li style="width: 32.5%;text-align: center;background: #ffffff;border-radius: 2px;padding-top:15px;padding-bottom: 15px;box-shadow: #bebebe 0 2px 5px;">
                                        <h2 class="no-margins" style="font-size: 30px;color:#00aeae;padding-bottom: 5px;">2585</h2>
                                        <small>订单总数</small>
                                        <div class="stat-percent">
                                        </div>
                                        <!-- <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div> -->
                                    </li>
                                    <li style="width: 32.5%;text-align: center;margin-top: 0;background: #ffffff;border-radius: 2px;padding-top:15px;padding-bottom: 15px;box-shadow: #bebebe 0 2px 5px;">
                                        <h2 class="no-margins " style="font-size: 30px;color:#00aeae;padding-bottom: 5px;">270</h2>
                                        <small>本月订单</small>
                                        <div class="stat-percent">
                                        </div>
                                        <!-- <div class="progress progress-mini">
                                            <div style="width: 60%;" class="progress-bar"></div>
                                        </div> -->
                                    </li>
                                    <li style="width: 32.5%;text-align: center;margin-top: 0;background: #ffffff;border-radius: 2px;padding-top:15px;padding-bottom: 15px;box-shadow: #bebebe 0 2px 5px;">
                                        <h2 class="no-margins " style="font-size: 30px;color:#00aeae;padding-bottom: 5px;">210,034</h2>
                                        <small style="margin-top: 10px;">本月会议支出</small>
                                        <div class="stat-percent">
                                        </div>
                                        <!-- <div class="progress progress-mini">
                                            <div style="width: 22%;" class="progress-bar"></div>
                                        </div> -->
                                    </li>
                                </ul>
                            </div>
                            <!-- <div class="ibox-title" style="border-top: none;border-bottom: 1px solid #e7eaec">
                                                <h5>我的会议</h5>
                                                <div class="pull-right">
                                                    <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white active">天</button>
                            <button type="button" class="btn btn-xs btn-white">月</button>
                            <button type="button" class="btn btn-xs btn-white">年</button>
                                                    </div>
                                                </div>
                                            </div> -->
                        </div>
                        <div  class="col-sm-3" style="width: 100%">
                            <div class="ibox-title" style="border-top: none;border-bottom: 1px solid #e7eaec">
                                <h5 style="border-left: 4px solid #00b6b8;padding-left: 4px;">我的会议</h5>
                                <div class="pull-right">
                                    <div class="btn-group">
                                    <button type="button" id="btn_1" class="btn btn-xs btn-white active" style="background: #2db2b2;color: #fff;outline: none;">+ 创建会议</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9" style="width: 100%;">
                            <div class="flot-chart" style="background: #ffffff;height: 300px;">
                                <!-- <div class="flot-chart-content" id="flot-dashboard-chart"></div> -->
                                <div class="flot-chart-content" id="zhuzhuangtu" style="width:100%;height:300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="message">
        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="border-left: 4px solid #00b6b8;padding-left: 4px;">会议日历 </h5>
                    <div class="ibox-tools">


                    </div>
                </div>
                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="border-left: 4px solid #00b6b8;padding-left: 4px;">消息</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> 新消息</h3>
                    <small><i class="fa fa-tim"></i> 您有 @{{otextCount}} 条未读消息</small>
                </div>
                <div class="ibox-content message-num" style="max-height: 760px;">
                    <div class="feed-activity-list">

                        <!-- <div class="feed-element">
                            <div>
                                <small class="pull-right text-navy">1月前</small>
                                <strong>井幽幽</strong>
                                <div>有人说：“一辈子很长，要跟一个有趣的人在一起”。我想关注我的人，应该是那种喜欢找乐子也乐意分享乐趣的人，你们一定挺优秀的。所以单身的应该在这条留言，互相勾搭一下。特别有钱人又帅可以直接私信我！</div>
                                <small class="text-muted">4月11日 00:00</small>
                            </div>
                        </div> -->

                        <div class="feed-element" v-for="(item, index) in options" :key="index">
                            <div>
                                <!-- <small class="pull-right">2月前</small>
                                <strong>马伯庸 </strong> -->
                                <div v-text="item.content"></div>
                                <small class="text-muted" v-text="item.create_time_value"></small>
                            </div>
                        </div>

                       <!--  <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>芒果宓 </strong>
                                <div>一个完整的梦。</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>刺猬尼克索</strong>
                                <div>哈哈哈哈 你卖什么萌啊! 蠢死了</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>


                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>老刀99</strong>
                                <div>昨天评论里你见过最“温暖和感人”的诗句，整理其中经典100首，值得你收下学习。</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>娱乐小主 </strong>
                                <div>你是否想过记录自己的梦？你是否想过有自己的一个记梦本？小时候写日记，没得写了就写昨晚的梦，后来变成了习惯………翻了一晚上自己做过的梦，想哭，想笑…</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5月前</small>
                                <strong>DMG电影 </strong>
                                <div>《和外国男票乘地铁，被中国大妈骂不要脸》妹子实在委屈到不行，中国妹子找外国男友很令人不能接受吗？大家都来说说自己的看法</div>
                                <small class="text-muted">11月8日 20:08 </small>
                            </div>
                        </div>
 -->
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>

<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/assets/js/plugins/flot/jquery.flot.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="/assets/js/plugins/easypiechart/jquery.easypiechart.js"></script> -->
<script src="//cdn.bootcss.com/echarts/3.6.2/echarts.min.js"></script>
<script src="/assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="/assets/js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="/assets/plugins/vue.min.js"></script>
<script src="/assets/js/home/home.js"></script>
<script type="text/javascript">
btn_1.onclick=function(){
    document.location.href="http://dev.meetingv2.eventown.com/Meeting/create"
}
</script>

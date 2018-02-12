<!DOCTYPE html>
<html lang="en"  ng-app="myApp">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="renderer" content="webkit">
    <title>Title</title>

    {{--<link rel="stylesheet" href="h5/lib/ionic/css/ionic.css" type="text/css">--}}
    {{--<script src="h5/lib/ionic/js/ionic.bundle.min.js"></script>--}}
    {{--<script src="h5/lib/ionic-datepicker/ionic-datepicker.bundle.min.js"></script>--}}
    <link rel="stylesheet" href="/assets/h5/lib/ionic/css/ionic.css" type="text/css">
    <script src="/assets/h5/lib/ionic/js/ionic.bundle.min.js"></script>
    <script src="/assets/h5/lib/ionic-datepicker/ionic-datepicker.bundle.min.js"></script>
    <style>
        html,body{
            font-size: 62.5%
        }
        .bg{
            background-size :cover;
            background-repeat:no-repeat ;
            background-position: 0 0;
            /*background-image: url("{{ empty($date[0]['bg_img_url'])?'/assets/img/background.jpg':'/assets/Invitation/'.$date[0]['bg_img_url'] }}");*/
            background-image:url("h5/image/background.jpg");
            padding-bottom:2rem ;
        }
        span{
            font-size: 1.4rem;
        }
        .list{
            width: 85%;
            padding:0 8%;
            margin: 0 auto 1.5rem;
            background:rgba(255,255,255,0.2);
            font-size:1.2rem;
            border-radius: 5px;

        }
        .list.image{
            background: none;
            width: 100%;
            padding:0;

        }
        .list.invite{
            padding: 0 4%;
        }
        .invite .item-input{
            padding: 16px 14% 0;
        }
        .list .item:last-child{padding: 16px 0 }
        .item{
            padding: 16px 0 0;
            overflow: inherit;
            z-index: auto;
        }
        .item h1{
            font-size:1.7rem;
            text-align: center;
            color: #000;
        }
        .item h2{
            font-size:1.4rem;
            color: #000;
        }
        .item h3{
            font-size:1.3rem;
            color: #000;
        }

        .item .line{
            background: #fff;
            height: 1px;
        }
        .item ,.item-radio ,.item-conten{
            background: none;
            color: #000;
            border:none;
        }

        .item-complex .item-content, .item-radio .item-content{
            background: none;
        }
        .invite .item-input input{
            text-align: center;
        }
        .item-input{
            padding: 10px 0 0;
        }
        .item-input input,.item-input input[readonly]{
            height: 2.8rem;
            line-height: 2.8rem;
            font-size: 1.4rem;
            color:  #a6a8b6;
            border: 1px solid #a6a8b6;
            border-radius: 5px;
            padding-left:1rem;
            background: none;
        }
        .item label{
            font-size: 1.4rem;

        }
        .item-toggle .toggle{
            right: 0;
            top: 50%;
        }

        .toggle .track{
            height: 1.2rem;
            width: 3rem;
            background: #4c5069;
            border: none;
        }
        .toggle .handle{
            height: 1.6rem;
            width: 1.6rem;
            left: 10%;
            top: 20%;
        }
        .type{
            position: relative;
            overflow: initial;
        }
        .type .select{
            background: #fff;
            width: 100%;
            position: absolute;
            left: 0;
            z-index: 100;
        }
        .type .select li{
            width: 100%;
            max-width: 100%;
            min-height: 47px;
            font-size: 1.2rem;
            line-height: 42px;
            background: none;
            color:  #a6a8b6;
            border: 1px solid #a6a8b6;
            direction: ltr;
        }
        .button.button-light{
            background:none;
            text-align: left;
            color:  #a6a8b6;
            border: 1px solid #a6a8b6;

        }
        .radio label{
            padding-left:2rem ;
            margin-right:4rem ;
            position: relative;
        }
        .radio label input{
            display: none;
        }
        .radio label span{
            position: absolute;
            display: block;
            width:1.4rem;
            height:1.4rem;
            top: 0;
            left: 0;
            border: 1px solid #a6a8b6;
            border-radius: 50%;
        }
        .radio label input:checked+span::after{
            content:"";
            position: absolute;
            width: 50%;
            height:50%;
            top: 25%;
            right: 25%;
            background: #2ce9ec;
            border-radius: 50%;
        }
        .radio label{
            padding-left:2rem ;
            margin-right:4rem ;
            position: relative;
        }
        .radio label input{
            display: none;
        }
        .radio label span{
            position: absolute;
            display: block;
            width:1.4rem;
            height:1.4rem;
            top: 0;
            left: 0;
            border: 1px solid #a6a8b6;
            border-radius: 50%;
        }
        .radio label input:checked+span::after{
            content:"";
            position: absolute;
            width: 50%;
            height:50%;
            top: 25%;
            right: 25%;
            background: #2ce9ec;
            border-radius: 50%;
        }
        .button.button-full{
            font-size: 1.4rem;
            margin: 0;
        }
        .item-text-wrap span{
            position: relative;
        }
        .item-text-wrap span{
            font-size: 1.2rem;
            color: #a6a8b6;
        }
        .item-text-wrap span:before{
            content: "";
            width: 0.5em;
            height: 1em;
            position: absolute;
            top: 3px;
            left:-0.5em;
            background: #00b6b9;
        }

        .button{
            height: 2.8rem;
            line-height: 2.8rem;
            min-height: 2.8rem;
            border-radius: 3px;
        }
        .button.icon-right:before{
            line-height: 2.8rem;
        }
        .item-text-wrap h1{
            text-align: left;
        }
        .item-text-wrap p{
            color: #000;
            font-size: 12px;
        }

        .date_cell{font-size: 1.2rem}
        @-moz-document url-prefix() {
            .item-input input{ flex:none }
            .toggle .handle{top:22%}
            .date_cell{font-size: 1.2rem}
        }
        .item-image p{
            font-size: 1.2rem;
            position: absolute;
            max-width: 89%;
            bottom: 24.5%;
            left: 0;
            right: 0;
            background: #00b6b9;
            margin: 0 auto;
        }
        .item-text-wrap i{
            padding-right: 5px;
        }
        .item-text-wrap .box{
            border-bottom: 1px #a6a8b6 solid;
            position: relative;
            height: 2.4rem;
            line-height: 2.4rem;
        }
        .item-text-wrap .box:before{
            content: "";
            position: absolute;
            height: 0.2rem;
            width: 20%;
            background: #4cd964;
            bottom:-2px;
            left: 0;
        }
        .item-text-wrap b{
            display: inline-block;
        }
        .item-text-wrap b i{
            font-size: 3.5rem;
        }
        @media screen and (max-width: 320px){
            .list.invite {
                padding: 0 3%;
            }
            .item h3{
                font-size:1.2rem;
                color: #fff;
            }
        }

    </style>
    <script>
        var reg=/ONEPLUS/,
            dataReg=/(\d*)-(\d*)-(\d*)/,
            timeReg=/(\d*):(\d*)/,
            date=new Date,
            now=date.getTime()
        if(reg.test(navigator.userAgent)){
            alert("因浏览器原因部分功能无法实现")
        }
        function GetQueryString(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)return  unescape(r[2]); return null;
        }
        var id=GetQueryString("j_id");
        var role_id=GetQueryString("role_id");
        var app=angular.module("myApp",["ionic","ionic-datepicker"]);
        app.controller("myCtrl",function($scope,$http,$ionicPopup,$stateParams,ionicDatePicker) {
            $scope.flag= {
                goTravel:false,
                backTracel:false,
                hotel:false
            };
            @foreach($date as $val)
                var timeStart="{{ $val['begin_time'] }}";
                var timeEnd=" {{ $val['end_time'] }}"
            @endforeach
            timeStart.replace(dataReg,function($0,$1,$2,$3){
                date.setYear($1);
                date.setMonth($2-1);
                date.setDate($3);
            })
            timeStart.replace(timeReg,function($0,$1,$2){
                date.setHours($1);
                date.setMinutes($2);
            })
            var start=date.getTime();
            console.log(start);
            console.log(now);
            console.log();
            var time=parseInt(start-now);
            console.log(timeEnd);
            if(time<0){
                timeEnd.replace(dataReg,function($0,$1,$2,$3){
                    date.setYear($1);
                    date.setMonth($2-1);
                    date.setDate($3);
                });
                timeEnd.replace(timeReg,function($0,$1,$2){
                    date.setHours($1);
                    date.setMinutes($2);
                })
                var end=date.getTime();
                if(parseInt(end-now)<0){
                    $scope.startTime='已结束'
                }else{
                    $scope.startTime='已开始'
                }
            }else{
                $scope.startTime=parseInt((start-now)/24/60/60/1000)+'天';
            }

            $scope.meet={
                time:'2017-09-11 18:00~2017-09-11 19:00',
                address:"北京饭店"
            }
            $scope.types=['请选择','大房型'];
            $scope.form={
                j_id:id,
                role_id:role_id,
                is_come_ticket:false,
                come_type:0,
                come_time:"请选择",
                come_code:"",
                come_begin_city:"",
                come_end_city:"",
                is_leave_ticket:false,
                leave_time:"请选择",
                leave_code:"",
                leave_type:"0",
                leave_begin_city:"",
                leave_end_city:"",
                is_connet:true,
                is_send:true,
                is_hotel:false,
                hotel:"请选择",
                hotel_id:0,
                room_type:"请选择",
                check_in_time:"请选择",
                check_out_time:"请选择",
            };

            $scope.come_time=0;
            $scope.leave_time=0;
            $scope.check_in_time=0;
            $scope.check_out_time=0

           $scope.push=function(){
                if(showPopup()){
                   $http({
                    method:'post',
                       dataType:'json',
                     url:"{{ str_replace('index.php/','',url('/h5/confirm')) }}",
                    data: $scope.form
            }).success(function(req){
                if(req.status == '1'){
                    window.location.reload(req.data);
                }else{
                    alert(req.msg);
                }
            })
        }



            }
            var ipObj1 = {
                callback: function (val) {  //Mandatory
                    console.log('Return value from the datepicker popup is : ' + val, new Date(val));
                },
                inputDate : new Date(),
                from : new Date(),
                mondayFirst: true,
                monthsList:["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                weeksList:["日", "一", "二", "三", "四", "五", "六"],
                closeOnSelect: false,
                templateType: 'popup',
                dateFormat: 'yyyy-MM-dd',
            };
            var ipObj_hin = {
                callback: function (val) {  //Mandatory
                    console.log('Return value from the datepicker popup is : ' + val, new Date(val));
                },
                mondayFirst: true,
                monthsList:["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                weeksList:["日", "一", "二", "三", "四", "五", "六"],
                closeOnSelect: false,
                templateType: 'popup',
                dateFormat: 'yyyy-MM-dd',

            };
            var ipObj_hout = {
                callback: function (val) {  //Mandatory
                    console.log('Return value from the datepicker popup is : ' + val, new Date(val));
                },
                mondayFirst: true,
                monthsList:["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                weeksList:["日", "一", "二", "三", "四", "五", "六"],
                closeOnSelect: false,
                templateType: 'popup',
                dateFormat: 'yyyy-MM-dd',
            };
            $scope.openSelect=function(){
                $scope.flag.type=! $scope.flag.type;
            }
            $scope.selectType=function(type){
                $scope.form.room_type=type;
                $scope.flag.type=false;
            }
            $scope.openSelectHotel=function(){
                $scope.flag.type_hotel=! $scope.flag.type_hotel;
            }
            $scope.selectTypeHotel=function(id,name,room_type,start_date,end_date,out_end_date){
                $scope.form.hotel=name;
                $scope.form.hotel_id=id;
                $scope.form.room_type=room_type;
                $scope.flag.type_hotel=false;
                ipObj_hin.inputDate = new Date(start_date);
                ipObj_hin.from = new Date(start_date);
                ipObj_hin.to = new Date(end_date);
                ipObj_hout.inputDate = new Date(start_date);
                ipObj_hout.from = new Date(start_date);
                ipObj_hout.to = new Date(out_end_date);
            }
            $scope.openDatePicker = function(head){
                ipObj1.callback=function(val){
                   var y=new Date(val).getFullYear(),
                        m=new Date(val).getMonth()+1,
                       d=new Date(val).getDate();
                    $scope.form[head]=""+y+"-"+m+"-"+d;
                    $scope[head]=val;
                };
                ionicDatePicker.openDatePicker(ipObj1);
            };
            $scope.openDatePicker_hin = function(head){
                ipObj_hin.callback=function(val){
                    var y=new Date(val).getFullYear(),
                        m=new Date(val).getMonth()+1,
                        d=new Date(val).getDate();
                    $scope.form[head]=""+y+"-"+m+"-"+d;
                    $scope[head]=val;
                };
                ionicDatePicker.openDatePicker(ipObj_hin);
            };
            $scope.openDatePicker_hout = function(head){
                ipObj_hout.callback=function(val){
                    var y=new Date(val).getFullYear(),
                        m=new Date(val).getMonth()+1,
                        d=new Date(val).getDate();
                    $scope.form[head]=""+y+"-"+m+"-"+d;
                    $scope[head]=val;
                };
                ionicDatePicker.openDatePicker(ipObj_hout);
            };
            function showPopup () {
                // 自定义弹窗
                var popup={
                    title: '警告',
                    template: "表单有问题"
                };
                console.log($scope.form.is_come_ticket,$scope.flag.hotel);
             if(!$scope.form.is_come_ticket){
                if(!$scope.form.come_code||
                 !$scope.form.come_begin_city||
                 !$scope.form.come_end_city){
                    alert("去程信息问题");
                    return false
                }
             }
             else{
                     $scope.form.come_type="";
                     $scope.form.come_code="";
                     $scope.form.come_begin_city="";
                     $scope.form.come_end_city="";
             }
                if(! $scope.form.is_leave_ticket){
                 if(
                     !$scope.form.leave_code||
                     !$scope.form.leave_begin_city||
                     !$scope.form.leave_end_city
                 ){
                    alert("返程信息问题");
                    return false
                 }
                }
                else{
                    $scope.form.leave_type="";
                    $scope.form.leave_code="";
                    $scope.form.leave_begin_city="";
                    $scope.form.leave_end_city="";
                }
                if(!$scope.form.is_hotel){
                   if(
                       $scope.form.room_type == "请选择"||
                       !$scope.form.check_in_time||
                       !$scope.form.check_out_time
                   ){
                       alert("住宿信息有问题");
                       return false
                   }
                   else if($scope.check_in_time> $scope.check_out_time|| $scope.check_in_time==0|| $scope.check_out_time==0){
                       alert("住宿时间有问题")
                       return false
                       }
                }
                else {
                    for(var k in $scope.form.hotel){
                        $scope.form.room_type="";
                        $scope.form.check_in_time="";
                        $scope.form.check_out_time="";
                    }
                }
                if($scope.come_time > $scope.leave_time||$scope.come_time==0||$scope.leave_time==0){
                    alert("出行时间有问题");
                    return false

                }
                return true;
            }
        }).config(['$interpolateProvider', function ($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        }]);

    </script>
</head>
<body ng-controller="myCtrl">
<ion-content has-bouncing="false">
    <div >
    <form   >
    <div id="a" class="list image">
        <ion-item class="item-image">
            <image src="/assets/img/banner.jpg" />
            <!--@foreach($date as $val)-->
            <!--<p>{{ $val['title'] }}</p>-->
                <!--@endforeach-->
        </ion-item>
    </div>
    <div class="list invite">
        <!--<ion-item class="item-input">-->
            <!--@foreach($name as $v)-->
            <!--<input placeholder="参会人姓名" value="{{ $v['name'] }}" readonly="">-->
                <!--@endforeach-->
        <!--</ion-item>-->
        <ion-item class="item-text-wrap">
            @foreach($date as $val)
            <h1>会议名称
                {{ $val['title'] }}
            </h1>
            <h2><i class="icon ion-ios-calendar" style="color: #2ce9ec"></i>
                {{ $val['begin_time'] }}
            </h2>
            <h2><i class="icon  ion-ios-location" style="color: #4cd964"></i>北京
                {{ $val['address'] }}
            </h2>
            <h2><i class="icon  ion-ios-person" style="color: #e42112"></i>爱普生（中国）有限公司
                {{ $val['address'] }}
            </h2>
                @endforeach
        </ion-item>
        <ion-item class="item-text-wrap">
            <h2 class="box">
                活动详情
            </h2>
            <p>
                爱普生在中国开展的业务主要有打印机、扫描仪、投影机等信息关联产品业务，电子元器件业务以及工业机器人业务。其产品以卓越的品质和节能环保的特点，赢得了中国消费者的厚爱。立足于中国市场，爱普生始终本着“挑战与创新”理念，不断将一系列先进技术及应用方案引入中国，从而使中国消费者能够与世界同步，享受创新科技带来的完美体验。爱普生不断贡献于中国的环保和教育事业，作为一名优秀的中国企业公民而倍感自豪。
            </p>
            <h2 class="box">
                时间
            </h2>
            <p>
                <b>
                    <i class="icon ion-ios-clock-outline" style="color: #2ce9ec"></i>
                </b>
                <b style="font-weight: normal">
                    @foreach($date as $val)
                    {{ $val['begin_time'] }}-开始时间<br>
                        {{ $val['end_time'] }}-结束时间
                    @endforeach
                </b>
                <b style="clear: both"></b>
            </p>
            <p>
                <b><i class="icon  ion-play" style="color: #4cd964;font-size: 3.5rem"></i></b><b style="vertical-align: middle;margin-top: -2rem;margin-left: 1rem;">距离开始时间：[[startTime]]</b>
            </p>
        </ion-item>
    </div>
    <ion-list>
        <ion-item>
           <h1>
               填写个人信息
           </h1>
        </ion-item>
        <ion-item class="item-text-wrap">
            <span>
                @foreach($date as $val)
                    温馨提示：请在{{ $val['confirm_time'] }}前完成，如未 完成则视同放弃参加会议。
                    @endforeach
                </span>
        </ion-item>
        <ion-item>
            <h2>
                去程出发日期
            </h2>
        </ion-item>
        <ion-item class="item-input">
            <button type="button" name="come_time" class="button button-light icon-right button-full ion-chevron-down" ng-click="openDatePicker('come_time')" readonly=""  ng-model="form.come_time"  >
                [[form.come_time]]
            </button>
        </ion-item>
            <ion-toggle toggle-class="toggle-calm" ng-model="form.is_come_ticket">
                不需要预定机票/火车票</ion-toggle>

        <div ng-if="!form.is_come_ticket">
            <ion-item>
                <h2>去程出行方式</h2>
            </ion-item>
            <div class="item radio" >
                <label for="gotrain"><input id="gotrain" name="come_type" checked type="radio" ng-model="form.come_type"  ng-value="0" />火车<span></span></label>
                <label for="goplane"><input id="goplane" name="come_type" type="radio" ng-model="form.come_type" ng-value="1"  />飞机<span></span></label>
            </div>
        <ion-item>
            <h2>去程意向航班号/车次号</h2>
        </ion-item>
        <ion-item class=" item-input">
            <input ng-model="form.come_code" placeholder=请填写>
        </ion-item>
        <ion-item>
            <h2>出发地</h2>
        </ion-item>
        <ion-item class="item-input">
            <input  ng-model="form.come_begin_city" placeholder=请填写>
        </ion-item>
        <ion-item>
            <h2>目的地</h2>
        </ion-item>
        <ion-item class="item-input">
            <input ng-model="form.come_end_city" placeholder=请填写>
        </ion-item>
        <ion-item>
            <h2>是否需要接机</h2>
        </ion-item>
        <div class="item radio">
            <label ><input  name="is_connet" type="radio"   ng-value="true" ng-model="form.is_connet"  />需要<span></span></label>
            <label ><input  name="is_connet" type="radio"  ng-value="false" ng-model="form.is_connet"/>不需要<span></span></label>
        </div>
        </div>
        <ion-toggle  toggle-class="toggle-calm" ng-model="form.is_hotel">
            不需要预订酒店</ion-toggle>
        <div ng-if="!form.is_hotel">
            <ion-item>
                <h2>入住酒店</h2>
            </ion-item>
            <div class="item type">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openSelectHotel()">
                    [[form.hotel]]
                </button>
                <ul class="select" ng-show="flag.type_hotel">
                    @foreach($hotel as $v)
                        <li  ng-click=selectTypeHotel("{{ $v['id'] }}","{{ $v['name'] }}","{{ $v['room_type'] }}","{{ $v['start_date'] }}","{{ $v['end_date'] }}","{{ date('Y-m-d',strtotime('+1 days',strtotime($v['end_date']))) }}")>{{ $v['name'] }}</li>
                    @endforeach
                </ul>

            </div>
            <ion-item>
                <h2>意向房型</h2>
            </ion-item>
            <div class="item type">
                <button class="button button-light icon-right button-full ion-chevron-down">
                    [[form.room_type]]
                </button>
            </div>
            <ion-item>
                <h2>入住日期</h2>
            </ion-item>
            <ion-item class="item-input">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openDatePicker_hin('check_in_time')" readonly>[[form.check_in_time]]</button>
            </ion-item>
            <ion-item>
                <h2>退房日期</h2>
            </ion-item>
            <ion-item class="item-input">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openDatePicker_hout('check_out_time')" readonly>[[form.check_out_time]]</button>
            </ion-item>
        </div>
        <ion-item>
            <div class="line"></div>
        </ion-item>
        <ion-item>
            <h2>
                返程出发日期
            </h2>
        </ion-item>
        <ion-item class="item-input">
            <button class="button-light button button-full icon-right ion-chevron-down " ng-click="openDatePicker('leave_time')" readonly>[[form.leave_time]]</button>
        </ion-item>
        <ion-toggle toggle-class="toggle-calm" ng-model="form.is_leave_ticket">
            不需要预定机票/火车票</ion-toggle>
        <div ng-if="!form.is_leave_ticket">
            <ion-item>
                <h2>返程出行方式</h2>
            </ion-item>
            <div  class="item radio">
                <label for="backtrain"><input id="backtrain" name="leave_type" checked ng-model="form.leave_type"  type="radio" checked  ng-value="0" />火车<span></span></label>
                <label for="backplane"><input id="backplane" name="leave_type" ng-model="form.leave_type" type="radio"  ng-value="1"/>飞机<span></span></label>
            </div>
            <ion-item>
                <h2> 返程意向航班号/车次号</h2>
            </ion-item>
            <ion-item class=" item-input">
                <input ng-model="form.leave_code" placeholder=请填写>
            </ion-item>
            <ion-item>
                <h2> 出发地</h2>
            </ion-item>
            <ion-item class="item-input">
                <input ng-model="form.leave_begin_city" placeholder=请填写>
            </ion-item>
            <ion-item>
                <h2> 目的地</h2>
            </ion-item>
            <ion-item class="item-input">
                <input ng-model="form.leave_end_city" placeholder=请填写>
            </ion-item>
            <ion-item>
                <h2>是否需要接机</h2>
            </ion-item>
            <div class="item radio">
                <label ><input  name="is_send" ng-model="form.is_send"   type="radio"  checked ng-value="true" />需要<span></span></label>
                <label ><input  name="is_send" ng-model="form.is_send" type="radio"  ng-value="false"/>不需要<span></span></label>
            </div>
        </div>
        <ion-item>
            <button class="button button-full button-calm" ng-click="push()"  >提交</button>
        </ion-item>
    </ion-list>
    </form>
    </div>
</ion-content>
</body>
</html>
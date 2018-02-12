<!DOCTYPE html>
<html lang="en"  ng-app="myApp">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="renderer" content="webkit">
    <title>Title</title>
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
            background-image: url("{{ empty($date[0]['bg_img_url'])?'/assets/img/background.jpg':'/assets/Invitation/'.$date[0]['bg_img_url'] }}");
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
            color: #fff;
        }
        .item h2{
            font-size:1.4rem;
            color: #fff;
        }
        .item h3{
            font-size:1.3rem;
            color: #fff;
        }

        .item .line{
            background: #fff;
            height: 1px;
        }
        .item ,.item-radio ,.item-conten{
            background: none;
            color: #ffffff;
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
            color:  #fff;
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
            top: 14%;
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
            color:  #fff;
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

        .date_cell{font-size: 1.2rem}
        @-moz-document url-prefix() {
            .item-input input{ flex:none }
            .toggle .handle{top:22%}
            .date_cell{font-size: 1.2rem}
        }
        .item-image p{
            color:#fff;
            font-size: 1.2rem;
            position: absolute;
            max-width: 89%;
            bottom: 24.5%;
            left: 0;
            right: 0;
            background: #00b6b9;
            margin: 0 auto;
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
        .dayly span{
            color:#FA9;
            padding: 0 5px;
        }
    </style>
    <script>

        var reg=/ONEPLUS/;
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
        var app=angular.module("myApp",["ionic","ionic-datepicker"]);
        app.controller("myCtrl",function($scope,$http,$ionicPopup,$stateParams,ionicDatePicker) {
            $scope.flag= {
                goTravel:false,
                backTracel:false,
                hotel:false
            };

            $scope.meet={
                time:'2017-09-11 18:00~2017-09-11 19:00',
                address:"北京饭店"
            }
            $scope.types=['请选择','大房型'];
            $scope.form={
                j_id:id,
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
                     url:"{{ str_replace('index.php/','',url('/h5/confirm')) }}",
                    data: $scope.form
            }).success(function(req){
                window.location.reload();
            })
        }



            }
            var ipObj1 = {
                callback: function (val) {  //Mandatory
                    console.log('Return value from the datepicker popup is : ' + val, new Date(val));
                },
                from: new Date(),
                inputDate: new Date(),
                mondayFirst: true,
                monthsList:["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                weeksList:["日", "一", "二", "三", "四", "五", "六"],
                closeOnSelect: false,
                templateType: 'popup',
                dateFormat: 'yyyy-MM-dd'
            };
            $scope.openSelect=function(){
                $scope.flag.type=! $scope.flag.type;
            }
            $scope.selectType=function(type){
                $scope.form.room_type=type;
                $scope.flag.type=false;
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
    {{--{{ dd(url('/h5/lib/ionic/css/ionic.css')) }}--}}
    <div class="bg">


    <form   >
    <div id="a" class="list image">
        <ion-item class="item-image">
            <image src="/assets/h5/image/h5log.png" />
            @foreach($date as $val)
            <p>{{ $val['title'] }}</p>
                @endforeach
        </ion-item>
    </div>
    <div class="list invite">
        <ion-item>
            <h1>
                诚邀
            </h1>
        </ion-item>
        <ion-item class="item-input">
            @foreach($name as $v)
            <input placeholder="参会人姓名" value="{{ $v['name'] }}" readonly="">
                @endforeach
        </ion-item>
        <ion-item class="item-text-wrap">
            @foreach($date as $val)
            <h3>会议时间:&nbsp{{ $val['begin_time'] }}~{{ $val['end_time'] }}</h3>
            <h3>会议地点: </i>&nbsp{{ $val['address'] }}</h3>
                @endforeach
        </ion-item>
        <ion-item class="item-text-wrap dayly">
            <?php
                if($rfp_id != $rfp_id){
            ?>
                <span>2017-11-04</span><br/>
                <h3>14:00 ：开始会议</h3><br/>
                <h3>18:00 ：外出晚餐</h3><br/>
                <h3>21:00 ：酒店住宿</h3><br/>
                <span>2017-11-05</span><br/>
                <h3>12:00 ：离开酒店</h3><br/>
            <?php
                }else{
            ?>
                <span>2017-12-15</span><br/>
                <h3>14:00 ：报到</h3><br/>
                <h3>18:00 ：酒店用餐</h3><br/>
                <h3>21:00 ：酒店住宿</h3><br/>
                <span>2017-12-16</span><br/>
                <h3>10:30 ：报到</h3><br/>
                <h3>12:00 ：酒店用餐</h3><br/>
                <h3>14:00 ：开始会议</h3><br/>
                <h3>18:00 ：酒店用餐</h3><br/>
                <h3>21:00 ：酒店住宿</h3><br/>
                <span>2017-12-17</span><br/>
                <h3>12:00 ：离开酒店</h3><br/>
            <?php
                }
            ?>



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
                不预定机票/火车票</ion-toggle>

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
            <h2>去程出发地址</h2>
        </ion-item>
        <ion-item class="item-input">
            <input  ng-model="form.come_begin_city" placeholder=请填写>
        </ion-item>
        <ion-item>
            <h2>去程目的地址</h2>
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
            不预订酒店</ion-toggle>
        <div ng-if="!form.is_hotel">
            <ion-item>
                <h2>意向房型</h2>
            </ion-item>
            <div class="item type">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openSelect()">
                    [[form.room_type]]
                </button>
                <ul class="select" ng-show="flag.type">
                    @foreach($room_type as $v)
                    <li  ng-click='selectType("{{ $v }}")'>{{ $v }}</li>
                        @endforeach
                </ul>

            </div>
            <ion-item>
                <h2>入住日期</h2>
            </ion-item>
            <ion-item class="item-input">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openDatePicker('check_in_time')" readonly>[[form.check_in_time]]</button>
            </ion-item>
            <ion-item>
                <h2>退房日期</h2>
            </ion-item>
            <ion-item class="item-input">
                <button class="button button-light icon-right button-full ion-chevron-down" ng-click="openDatePicker('check_out_time')" readonly>[[form.check_out_time]]</button>
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
            不预定机票/火车票</ion-toggle>
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
                <h2> 返程出发地址</h2>
            </ion-item>
            <ion-item class="item-input">
                <input ng-model="form.leave_begin_city" placeholder=请填写>
            </ion-item>
            <ion-item>
                <h2> 返程目的地址</h2>
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
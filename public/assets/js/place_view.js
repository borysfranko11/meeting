define(function(require, exports) {
    require('layer');
    layer.config({
        path: 'http://links.eventown.com.cn/vendor/layer/'
    })
    require('/assets/js/tipso.js');

    window.isRoom=true;
    window.isPlace=false;


    // 会场详情tips
    $('.tip').each(function() {
        var $con = $(this).siblings('div.pro_tips_layer').html();
        $(this).tipso({
            useTitle: false,
            width: 320,
            content: $con,
            delay: 0
        });
    })


    //IE10+ blur            
    if (typeof document.msHidden != "undefined") {
        [].slice.call(document.querySelectorAll(".cover img")).forEach(function(img) {
            img.classList.add("hidden");

            var myImage = new Image(),
                src = img.src;
            img.insertAdjacentHTML("afterend", '<svg class="blur" width="100%" height="394">\
            <image xlink:href="' + src + '" src="' + src + '" width="100%" height="394" y="0" x="0" filter="url(#blur)" />\
        </svg>');
        });
    }

    //跟随导航
    var onOff = true;
    var len = $('#pro_table_hotel tr').length
    var trShow = $('#pro_table_hotel tr:gt(3)')
    var proIndex = {
        Init: function() {
            // proIndex.bind.moreHotel();
            proIndex.bind.mapInfoTab();
            proIndex.bind.albumLayer();
            proIndex.bind.selectPhoto()
            proIndex.bind.tabPhoto()
        }
    };
    proIndex.bind = {
        moreHotel: function() { //控制会场详情显示隐藏
            if (len > 4) {
                trShow.addClass('hide')
            }
            $(".pro_table_more a").click(function() {
                trShow.toggleClass('hide');
                // _top = setTop()
                if (onOff) {
                    $(this).html('收起更多会场 <i class="icon iconfont">&#xe62e;</i>')
                    onOff = false
                } else {
                    $(this).html('展开更多会场 <i class="icon iconfont">&#xe62f;</i>')
                    onOff = true
                }
            })
        },
        RightNav: function() {
            _top = setTop()
            $(window).scroll(function() {
                var top = $(window).scrollTop();
                if ($(this).scrollTop() > $('#f1').offset().top - 70) {
                    $(".pro_subNav").addClass('fixed');
                } else {
                    $(".pro_subNav").removeClass('fixed')
                }
                for (i = 0; i < _top.length; i++) {
                    top > _top[i] && $('.pro_subNav').find('li').eq(i).addClass('active').siblings().removeClass('active');
                }
            });
        },
        clickNav: function() {
            $(".pro_subNav a").click(function() {
                var $this = $(this);
                var o = {
                    "Btn1": "#f1",
                    "Btn2": "#f2",
                    "Btn3": "#f3",
                    "Btn4": "#f4",
                    "Btn5": "#f5",
                    // "Btn6": "#f6"
                }
                var id = eval('o.' + $this.attr("class"));
                proIndex.func.Scroll($(id));
            });
        },
        mapInfoTab: function() {
            $(".pro_map_title span").each(function(i) {
                $(this).click(function() {
                    $(".pro_map_title span").removeClass('active')
                    $(this).addClass('active')
                    $('.pro_map_con>div').css('display', 'none')
                    $('.pro_map_con>div').eq(i).css('display', 'block')
                });
            });
        },
        albumLayer: function() {
            $(".pro_b_r li").click(function() {
                layer.open({
                    title: false,
                    type: 1,
                    closeBtn: 0,
                    area: ['900px', 'auto'],
                    offset: ['100px'],
                    shift: 2,
                    scrollbar: false,
                    shadeClose: true, //开启遮罩关闭
                    content: $('.photo_main')
                });
            });
        },
        tabPhoto: function() {
            $(".photo_tit li").each(function(i) {
                $(this).find('a').click(function() {alert(1);
                    $(".photo_tit li").removeClass('active')
                    $(this).parent().addClass('active')
                    $('.photo_con').css('display', 'none')
                    $('.photo_body').find('div.photo_con').eq(i).fadeIn()
                });
            })
        },
        selectPhoto: function() {
            $(".photo_con").each(function() {
                $(this).find('.photo-l li').each(function(i) {
                    $(this).click(function() {
                        $(this).siblings().removeClass('active')
                        $(this).addClass('active')
                        $(this).parents('.photo-l').siblings('.photo-r').find('li').css('display', 'none')
                        $(this).parents('.photo-l').siblings('.photo-r').find('li').eq(i).fadeIn()
                    });
                });
            })
        }
    };


    $(document).ready(function() {
        proIndex.Init();
        // 关注
//        function addFav(dom) {
//            $.ajax({
//                type: "post",
//                url: "/user/favourite",
//                data: {
//                    'uc_id': GLO.uid,
//                    'place_id': $('#palce_name').attr('data-placeid')
//                }
//            })
//        }
//
//        $(".place_score").bind("click", function() {
//            if (GLO.uid === 'null' || typeof GLO.uid === 'undefined') {
//                layer.msg('请先登录!');
//                return;
//            }
//
//            if ($(this).hasClass('success')) {
//                layer.msg('取消关注成功')
//
//            } else {
//                layer.msg('关注成功')
//
//            }
//
//            $(this).toggleClass('success');
//            addFav($(this))
//
//        })

    });


    //加载百度地图中心点

    // var start = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0]);
    // var map = new BMap.Map("placeMap");
    // map.centerAndZoom(start, 11);
    // map.enableScrollWheelZoom(true);
    // // console.log('start', start);
    //
    // var marker = new BMap.Marker(start); // 创建标注
    // map.addOverlay(marker); // 将标注添加到地图中
    // marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    //
    //
    // var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME, BMAP_DRIVING_POLICY_LEAST_DISTANCE, BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];
    //
    // function draw(end) {
    //     map.clearOverlays();
    //     var driving = new BMap.DrivingRoute(map, {
    //         renderOptions: {
    //             map: map,
    //             autoViewport: true
    //         },
    //         policy: routePolicy[1]
    //     });
    //     driving.search(start, end);
    // }
    // $('.pro_map_con dl').on('click', function() {;
    //     var dataend = $(this).attr('data-location').split(',');
    //     var endPoint = new BMap.Point(dataend[1], dataend[0])
    //     draw(endPoint)
    //
    // })

    var pointArr=CURRENT_PLACE.split(',');
    var markerArr=[];
    var boxArr=[];
    var num=0;
    var map = new BMap.Map("placeMap");
    map.centerAndZoom(new BMap.Point(pointArr[1],pointArr[0]), 14);
    // map.addControl(new BMap.MapTypeControl());
    // map.setCurrentCity("北京");
    map.enableScrollWheelZoom(true);
    // var opts={anchor:BMAP_ANCHOR_TOP_RIGHT}
    // map.addControl(new BMap.NavigationControl(opts));

    addPoint({'lng':pointArr[1],'lat':pointArr[0]},true)
    var newPointArr=[{'lng':'116.417','lat':'39.909'}];


    // 地图点击事件
    $('#addEvent').click(function(){
        map.addEventListener("click",mapClick);
    })
    function mapClick(e){
        newPointArr.push({'lng':e.point.lng ,'lat':e.point.lat})
        var pt = e.point;
        // map.setViewport(newPointArr); //让所有点在视野范围内
        addPoint(e.point);
        map.removeEventListener('click',mapClick);
    }
    //创建标记
    function addPoint(pointData,qf){
        num++;
        var pt = new BMap.Point(pointData.lng,pointData.lat);
        var marker= new BMap.Marker(pt);  // 创建标注
        markerArr.push(marker);
        map.addOverlay(marker,num); // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        addRess(pt,marker,qf);

    }

    // 创建纯文本说明
    function label(addressData,marker){
        $('#endAddress').val(addressData.address).attr({'lng':pointArr[1],'lat':pointArr[0]});
        // var label = new BMap.Label(addressData.address,{offset:new BMap.Size(30,0)});
        // map.addOverlay(marker);// 将标注添加到地图中
        // marker.setLabel(label);
    }

    // 检索框
    function searchInfoWindow(data,marker){
        var title=data.province+data.city+data.district;
        var str=data.address.toString();
        data.address+='<div class="typeBtn">'+
            '<a href="javascript:;" class="markerCar" onClick=addEvent_click("'+str+'",1,'+data.point.lng+','+data.point.lat+')>驾车</a>'+
            '<a href="javascript:;" onClick=addEvent_click("'+str+'",2,'+data.point.lng+','+data.point.lat+') class="markerPeople">步行</a>'+
            '<a href="javascript:;" onClick=addEvent_click("'+str+'",0,'+data.point.lng+','+data.point.lat+') class="markerBus">公交</a>'+
            '<a href="javascript:;" onClick="deletePoint(this)" index="'+num+'" class="marker_del">删除</a></div>';
        boxArr[num]=new BMapLib.SearchInfoWindow(map, data.address, {
            title: title, //标题
            panel: "citylist", //检索结果面板
            className:'mybox',
            width: 290,             //宽度
            height:40,
            enableAutoPan : false, //自动平移
            searchTypes :[
                // BMAPLIB_TAB_FROM_HERE, //从这里出发
                // BMAPLIB_TAB_SEARCH   //周边检索
            ]
        });

        marker.addEventListener("click", function(e){
            boxArr[num].open(marker);
        })
        return boxArr[num];
    }

    $('#black').click(function(){
        $('#typeList').show();
        $('#flayBox').show();
        $('#tripBox').show();
        $('#citylist').html('').hide();
        $('#titleSearch').html('周边查询');
        $('#startAddress').val('').attr({'lat':'','lng':''})
        $('#selectBtn').show();
        $(this).hide();
        $('#trip_type a').eq(0).addClass('active').siblings().removeClass('active')
        map.clearOverlays();
        listHideShow=false;
        map.centerAndZoom(new BMap.Point(pointArr[1],pointArr[0]), 14);
        addPoint({'lng':pointArr[1],'lat':pointArr[0]},true)
    })

    function deletePoint(obj){
        var index=$(obj).attr('index');
        map.removeOverlay(markerArr[index-1]);
        boxArr[index].close();
        map.closeInfoWindow();
    }

    // 交通工具路线规化
    function addEvent_click(elem,stype,lng,lat){
        $('#startAddress').val(elem).attr({'lng':lng,'lat':lat});
        searchOver(stype,lng,lat);
    }
    function searchOver(num,slng,slat,elng,elat){
        elng=elng?elng:Number(pointArr[1]);
        elat=elat?elat:Number(pointArr[0]);
        var p1 = new BMap.Point(elng,elat);
        var p2 = new BMap.Point(slng,slat);
        var load=loading();
        $("#citylist").show().html(load);
        map.clearOverlays();
        if(num==0){

            // 公交
            var transit = new BMap.TransitRoute(map, {
                renderOptions: {map: map, panel: "citylist"},
                onResultsHtmlSet : function(result){

                    var list=$(result).find('table');
                }
            });
            transit.search(p1, p2);
        }else if(num==1){

            // 驾车
            var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME,BMAP_DRIVING_POLICY_LEAST_DISTANCE,BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];
            var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, panel: "citylist", autoViewport: true}});
            driving.search(p1, p2);
        }else if(num==2){

            // 步行
            var walking = new BMap.WalkingRoute(map, {renderOptions: {map: map, panel: "citylist", autoViewport: true}});
            walking.search(p2,p1);
        }
        // listHideShow=false;
    }

    // 经续度转换成 具体地址
    function addRess(pt,marker2,qf){
        var geoc = new BMap.Geocoder();
        geoc.getLocation(pt, function(rs){
            var addComp = rs.addressComponents;
            var address=rs.address
            address={
                'point':rs.point,  //坐标
                'address':address, //全部地址
                'city':addComp.city, //衡水市
                'district':addComp.district, //深州市
                'province':addComp.province,  //河北省
            }
            if(qf){
                label(address,marker2);
            }else{
                searchInfoWindow(address,marker2).open(marker2);
            }
        });
        return false;
    }

    function loading(){
        var str='<div class="loading"><img src="/assets/img/loading.gif" alt=""><span>紧张加载中.............</span></div>';
        return str;
    }

    $('#typeList a').click(function(){
        var bool=$(this).attr('range');
        var txt=$(this).attr('alt');
        $('#black').css('display','block');
        $('#flayBox').hide();
        $('#tripBox').hide();
        var load=loading();
        $('#citylist').show().html(load).height('470');
        if(bool=='true'){
            foot_seach(txt);
        }else{
            hotel_search(txt);
        }
    })

    function hotel_search(txt){
        var local = new BMap.LocalSearch(map, {
            renderOptions: {map: map, panel: "citylist"}
        });
        local.search(txt);
    }

    function foot_seach(txt){
        map.clearOverlays();
        map.centerAndZoom(new BMap.Point(pointArr[1],pointArr[0]), 14);
        var mPoint = new BMap.Point(pointArr[1],pointArr[0]);
        var circle = new BMap.Circle(mPoint,1000,{fillColor:"blue", strokeWeight:3 ,fillOpacity: 0.3, strokeOpacity:0.8});
        map.addOverlay(circle);
        var local =  new BMap.LocalSearch(
            map, {
                renderOptions: {
                    map: map,
                    autoViewport: false,
                    panel:"citylist"}
            }
            );
        local.searchNearby(txt,mPoint,1000);
    }
    var newPoint;

    function getPoint(startAddress,id){
        var geoc = new BMap.Geocoder();
        geoc.getPoint(startAddress,function(point){
            if(point){
                longitude = point.lng;
                latitude = point.lat;
                changeAdress(point,id);
            }
        });
    }

    function changeAdress(point,id){
        $(id).attr({'lng':point.lng,'lat':point.lat})
        newPoint=point;
    }

    var defaultLng="";
    var defaultLat="";

    $('#airportList a').click(function(){

        $('#black').show();
        $('#titleSearch').html('线路查询');
        $('#typeList').hide();
        $('#flayBox').hide();
        $('#selectBtn').hide();
        var txt=$(this).attr('alt');
        defaultLng=$(this).attr('lng');
        defaultLat=$(this).attr('lat');
        $('#startAddress').val(txt);
        $('#startAddress').attr({'lng':defaultLng,'lat':defaultLat});

        $('#searchResultPanel').click();
        getPoint(txt,'#startAddress');
        $('#checkRoute').trigger('click');
        return false;
    })

    var listHideShow=false;
    //tirp_type  出行方式
    $('#trip_type a').click(function(){
        $(this).addClass('active').css('cursor','default').siblings().removeClass('active').css('cursor','pointer');
        var nType=$.trim($(this).attr('nType'));
        nType=nType?nType:0;
        if(listHideShow){
            var lng=$('#startAddress').attr('lng');
            var lat=$('#startAddress').attr('lat');
            if(lng && lng!='' && !isNaN(lng) && lat && lat!='' && !isNaN(lat)){
                searchOver(nType,lng,lat);
            }
        }
    })

    $('#checkRoute').click(function(){
        var startCity=$('#startAddress').val();
        var endCity=$('#endAddress').val();
        var s=$('#startAddress');
        var e=$('#endAddress');
        var start=$.trim(s.val());
        var end=$.trim(e.val());
        listHideShow=true;
        var typeNum=0;
        $('#trip_type a').each(function(){
            if($(this).hasClass('active')){
                typeNum=$(this).attr('ntype');
            }
        })

        if(start && start!='' && end && end!=''){
            listHideShow=true;
            $('#selectBtn').hide();
            $('#black').show();
            $('#titleSearch').html('线路查询');
            $('#typeList').hide();
            $('#flayBox').hide();
            var slng=s.attr('lng')?s.attr('lng'):defaultLng,slat=s.attr('lat')?s.attr('lat'):defaultLat;
            var elng=e.attr('lng'),elat=e.attr('lat');

            searchOver(typeNum,slng,slat,elng,elat);
        }
    })

    function G(id) {
        return document.getElementById(id);
    }
    $('#startAddress').focus(function(){
        var ac = new BMap.Autocomplete( //建立一个自动完成的对象
            {"input" : "startAddress"
                ,"location" : map
            });

        ac.addEventListener("onhighlight", function(e) { //鼠标放在下拉列表上的事件
            var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("searchResultPanel").innerHTML = str;
        });

        var myValue;
        ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
            var _value = e.item.value;
            myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
            $('#startAddress').val(myValue);
            getPoint(myValue,'#startAddress');
        });
    })




    //显示全景地图。

    function showpanoramaMap() {

        layer.open({
            type: 1,
            title: $('#palce_name').text() + '全景地图',
            skin: 'layui-layer-rim', //加上边框
            area: ['1160px', '625px'], //宽高
            offset: ['100px'],
            content: '<div id="innerPanoramaMap" style="width:100%;height:570px"> <span style="padding:20px;display:block">全景地图加载中...</span></div>',
            success: function(layero, index) {
                if (panorama) {
                    return
                }
                var panorama = new BMap.Panorama('innerPanoramaMap');
                var point = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0])

                panorama.setPosition(point);
                var labelPosition = point
                var labelOptions = {
                    position: labelPosition,
                    altitude: 5
                }; //设置标注点的经纬度位置和高度
                var label = new BMap.PanoramaLabel($('#palce_name').text(), labelOptions);
                panorama.addOverlay(label); //在全景地图里添加该标注
                panorama.setPanoramaPOIType(BMAP_PANORAMA_POI_INDOOR_SCENE); //室内景点

            }
        });
    }

    $('#panoramaMap').on('click', showpanoramaMap)



    /*****新增包房业务代码*****/
function GetRequest(id) { 
        var url = location.search; //获取url中"?"符后的字串 
        var theRequest = new Object(); 
        if (url.indexOf("?") != -1) { 
          var str = url.substr(1); 
          strs = str.split("&"); 
          for(var i = 0; i < strs.length; i ++) { 
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
          } 
        } 
        return  theRequest[id] ? theRequest[id] : null 
      } 



    function showTab() {
        $('#viewTabs').find('li').on('click', function() {
            $(this).siblings().removeClass('on');
            $(this).addClass('on')
            $('.price_container').hide();
            $('#' + $(this).attr('name')).show();
        })
    }

showTab()

        //默认
    // $('li[name="rooms"]').trigger('click')

    var roomData;
    var show_room = require('/assets/js/show_place.js')
    //请求房间数据渲染模板添加到dom
//    show_room.init('/search-place/psearch/get-list?place_id='+GLO.place_id)
    //显示购物车
    $('.elevator-cart,#shopCartBox').on('mouseenter',function(){
        $('#shopCartBox').css({
            opacity:1,
            transform: 'scale(1)'
        })
    })

     $('.elevator-cart,#shopCartBox').on('mouseleave',function(){
        $('#shopCartBox').css({
            opacity:0,
            transform: 'scale(0.1)'
        })
    })

 

    /*****新增包房业务代码*****/

})


$(function() {
    'use strict';

    $.fn.toTop = function(opt) {

        //variables
        var elem = this;
        var win = $(window);
        var doc = $('html, body');

        //Extended Options
        var options = $.extend({
            autohide: true,
            offset: 420,
            speed: 500,
        }, opt);

        elem.css({
            'cursor': 'pointer'
        });

        if (options.autohide) {
            elem.css('display', 'none');
        }

        if (options.position) {
            elem.css(
                'display', 'block'
            );
        }

        elem.click(function() {
            doc.animate({ scrollTop: 0 }, options.speed);
        });

        win.scroll(function() {
            var scrolling = win.scrollTop();

            if (options.autohide) {
                if (scrolling > options.offset) {
                    elem.fadeIn(options.speed);
                } else elem.fadeOut(options.speed);
            }

        });

    };

}(jQuery));
$('.elevator-top').toTop();

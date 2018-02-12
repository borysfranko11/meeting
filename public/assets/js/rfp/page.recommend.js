/**
 * Created by jzco on 2017/9/13.
 */

$( document ).ready( function()
{
    /*
     * 百度地图对象
     */

    function GetRequest() {
        //var url = location.search; //获取url中"?"符后的字串
        var lctde = $( '#area_inputs' ).find( 'input[name="lct"]' ).val();
        var url = '?city_id='+CITY_ID+'&position='+POSITION+'&place_type='+PLACE_TYPE+'&place_star='+PLACE_STAR+'&key_words=&location='+lctde; //获取url中"?"符后的字串

        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
        //return '';
    }

    var keyPoint=GetRequest();
    var PlaceMap = {
        markerArr: [], //点对象的集合。
        IMG_BASEURL: 'http://links.eventown.com.cn/images/icon/',
        mapDatalist: jQuery.parseJSON(GLOBAL.place_geo_data),
        index:10,
        urlPoint:'',
        //获取百度地图
        getBaiduMap: function() {
            return new BMap.Map("Jmain", { enableMapClick: false })
        },
        initMap: function( datalist ) {
            this.map = this.getBaiduMap()
            console.log(keyPoint)

            var mapDatalist = datalist;
            var point = [];

            if( !_.isEmpty( mapDatalist ) )
            {
                point = new BMap.Point( !_.isUndefined( mapDatalist[0]["lng"] ) ? mapDatalist[0].lng : 116.404, !_.isUndefined( mapDatalist[0]["lat"] ) ? mapDatalist[0].lat : 39.915 ); // 创建点坐标
            }
            else
            {
                point = new BMap.Point( 116.404, 39.915 ); // 创建点坐标
            }

            this.map.centerAndZoom(point, 15)

            this.map.addControl(new BMap.NavigationControl())
            this.map.addControl(new BMap.ScaleControl())
            this.map.addControl(new BMap.OverviewMapControl())
            this.map.enableScrollWheelZoom() //启动鼠标滚轮缩放地图
            // this.map.clearOverlays()

            this.mapDatalist = datalist;
            this.createTag()
            this.randerMarker( datalist )
            // this.removeLogo()
        },
        createTag:function(){
            this.urlPoint = $( '#area_inputs' ).find( 'input[name="lct"]' ).val()
            if(this.urlPoint=='' || this.urlPoint=='undefined' || this.urlPoint==null) return false;
            var arr=this.urlPoint.split(',');
            var pint= new BMap.Point(arr[1],arr[0]);
            var mykey = new BMap.Marker(pint);  // 创建标注
            this.map.addOverlay(mykey);               // 将标注添加到地图中
            mykey.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        },
        randerMarker: function( data ) {
            var mapDatalist = data
            var points = []
            var len = this.mapDatalist.length

            for (var i = 0; i < len; i++) {
                var point = new BMap.Point(mapDatalist[i].lng, mapDatalist[i].lat, { icon: myIcon })
                var myIcon = new BMap.Icon(this.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56))
                var themarker = new BMap.Marker(point, { icon: myIcon })
                themarker.addEventListener("onmouseover", (function(themarker, i) {
                    return function() {
                        PlaceMap.showTips(themarker, i)
                    }
                })(themarker, i))

                themarker.addEventListener("onmouseout", (function(themarker, i) {
                    return function() {
                        PlaceMap.hideTips(themarker, i)
                    }
                })(themarker, i))

                points.push(point)


                PlaceMap.markerArr.push(themarker)

                this.map.addOverlay(themarker); // 将标注添加到地图中
            }


            this.map.setViewport(points);
        },

        showTips: function(themarker, i) {

            var myIcon = new BMap.Icon(PlaceMap.IMG_BASEURL + "orange_" + (i + 1) + ".png", new BMap.Size(56, 56));
            var myIconblue = new BMap.Icon(PlaceMap.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56));

            themarker.setIcon(myIcon);

            var tipsPos = PlaceMap.map.pointToPixel(themarker.getPosition());

            // var LayerWidth = $(".tips").outerWidth();

            $('.tips' + (i + 1)).on('mouseenter', function() {
                $(this).show()
                themarker.setIcon(myIcon);
            })

            $('.tips' + (i + 1)).on('mouseleave', function() {
                $(this).hide()
                themarker.setIcon(myIconblue);

            })

            $('.tips' + (i + 1)).show().css({ "top": tipsPos.y + 30, "left": tipsPos.x - 100 })



        },

        hideTips: function(themarker, i) {

            var myIcon = new BMap.Icon(PlaceMap.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56));
            themarker.setIcon(myIcon);
            $('.tips' + (i + 1)).hide()

        },
        onover: function(i) {
            var myIcon;
            var myIcon = (function(){
                return myIcon || (myIcon=new BMap.Icon(PlaceMap.IMG_BASEURL + "orange_" + (i + 1) + ".png", new BMap.Size(56, 56)))
            })()

            PlaceMap.markerArr[i].setIcon(myIcon);




        },
        onout: function(i) {
            var myIcon = new BMap.Icon(PlaceMap.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56));
            PlaceMap.markerArr[i].setIcon(myIcon);
        },
        removeLogo: function() {
            window.setTimeout(function() {
                if ($('.anchorBL').size() > 0) {
                    $('.anchorBL').hide()
                } else {
                    arguments.callee()
                }
            }, 100)
        }

    }



    //触发浏览器dom事件
    var fireEvent = function(element, event) {

        if (document.createEventObject) {

            // IE浏览器支持fireEvent方法

            var evt = document.createEventObject();

            return element.fireEvent('on' + event, evt)

        } else {

            // 其他标准浏览器使用dispatchEvent方法

            var evt = document.createEvent('HTMLEvents');

            // initEvent接受3个参数：

            // 事件类型，是否冒泡，是否阻止浏览器的默认行为

            evt.initEvent(event, true, true);

            return !element.dispatchEvent(evt);

        }

    };

    /*
     *响应式地图
     */
    var $main= $('#Jmain');

    function setMapAreaSize(){

        var winH=$(window).height(),
            winW=$(window).width(),

            $topBarH=$('.topBar').height(),
            mainW= $main.outerWidth();


        $main.height(winH-$topBarH);

        var w=winW-mainW;
        var h=winH-$topBarH;

        $('.sidebar,#map').css({
            width:w,
            height:h
        })
    }

    setMapAreaSize();
    //加载地图

    PlaceMap.initMap( jQuery.parseJSON(GLOBAL.place_geo_data) );


    $(window).on('resize.map',setMapAreaSize);

    // api 数据地址集
    var api_urls = {
        "location":{
            "area": {
                "AreaCity": "/Rfp/getAreaCity",
                "Provinces": "/Rfp/getProvinces",
                "HotBusinessDistrict": "/Rfp/getHotBusinessDistrict",
                "DisplayAirport": "/Rfp/getDisplayAirport",
                "TrainStation": "/Rfp/getDisplayTrainStation",
                "MetroLines": "/Rfp/getMetroLines"
            },                                                                          // 区域需求配置项
        }
    };
    var place_types = {"1": '酒店',"2": '会议中心/展览馆/体育馆',"3": '餐厅/会所',"4": '艺术中心/剧院',"5": '其他',"8": '度假村'};

    genCommendList( JSON.parse( PLACE_DATA ) );

    // 区域需求的类型选择
    $( '.single-area-type' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="type"]' ).val( id );

            ajaxGetPlace();
        }
    } );

    // 地铁周边选择
    $( '#subway_choice' ).click( function()
    {
        var toggle = $( this ).attr( 'data-toggle' );

        $( '.single-area-location li a' ).css( {"color": "#676a6c"} );                // 清除全部选中字体样式
        $( this ).find( 'a' ).css( {"color": "#00b6b8"} );                            // 该节点添加选中样式

        $.ajax( {
            type: "post",
            url: "/Rfp/getMetroLines",
            data: {'_token':TOKEN, cityId: CITY_ID},
            dataType: "json",
            timeout: 5000,
            beforeSend: function( XMLHttpRequest )
            {
                $( "#location_level_1" ).hide();
                $( "#location_level_2" ).hide();
                $( "#location_loading" ).show();
            },
            success: function( Response )
            {
                var location_layer = $( '#location_level_1' );
                var location_layer2 = $( '#location_level_2' );

                if( Response["Success"] === true )
                {
                    $( "#location_loading" ).hide();
                    location_layer.show();

                    // 清除之前上一次数据
                    location_layer.find( '.now-node' ).remove();

                    var data = Response["Data"];

                    // 生成新数据
                    for( var key in data )
                    {
                        var h_li = $( '<li class="now-node" data-choiced={"id":"'+data[key]["id"]+'","name":"'+data[key]["name"]+'"}></li>'),
                            h_a = $( '<a href="javascript: void(0);"> '+data[key]["name"]+ '</a>' );

                        h_li.append( h_a );
                        location_layer.append( h_li );
                    }

                    location_layer.toChoice( {
                        list: 'li',
                        bind: 'a',
                        after_choiced: function( id, name, obj )
                        {
                            $( "#location_level_2" ).hide();
                            $( "#location_loading" ).show();

                            // 地铁周边子级数据生成
                            if( typeof data[key]["stations"] !== 'undefined' )
                            {
                                var son_data = data[id]["stations"];

                                // 清除之前上一次数据
                                location_layer2.find( '.now-node' ).remove();

                                // 生成新数据
                                for( var s_key in son_data )
                                {
                                    var s_h_li = $( '<li class="now-node" data-choiced={"id":"'+son_data[s_key]["id"]+'","name":"'+son_data[s_key]["name"]+'"}></li>'),
                                        s_h_a = $( '<a href="javascript: void(0);"> '+son_data[s_key]["name"]+ '</a>' );

                                    s_h_li.append( s_h_a );
                                    location_layer2.append( s_h_li );
                                }
                            }

                            // 模拟数据传输过程
                            setTimeout( function()
                            {
                                location_layer2.show();
                                $( "#location_loading" ).hide();

                                location_layer2.toChoice( {
                                    list: 'li',
                                    bind: 'a',
                                    after_choiced: function( s_id, s_name )
                                    {
                                        // 选中的值写入表单区域
                                        $( '#area_inputs' ).find( 'input[name="location"]' ).val( 'metro-'+id+'-'+s_id );

                                        ajaxGetPlace();
                                    }
                                } );
                            }, 1200 );
                        }
                    } );
                }
            }
        } );
    } );



$("body").bind("click",function(evt){
if(evt.target!=$('#keyword_input').get(0)) {
$('#search_info').hide();
}
});

        var rfpDetail = JSON.parse(RFP);
        var city_name = rfpDetail.provincedesc;
        if(rfpDetail.provincedesc != '北京' && rfpDetail.provincedesc != '上海' && rfpDetail.provincedesc != '天津' && rfpDetail.provincedesc != '重庆'){
            city_name = rfpDetail.citydesc;
        }

    $('#keyword_input').keyup(function(){
        var key_words = $("#keyword_input").val();
        var data={'_token':TOKEN,city_name:city_name,key_words:key_words}
        $.ajax({
            type: "post",
            url: "/place/placeFuzzyRetrieval",
            data:data,
            dataType: "json",
            success:function(data){
                $("#search_info").empty();
                var dataLen = data.Data.length;
                if(dataLen == 0){
                    $('#search_info').hide();
                }
                var tagA = '';
                for(var i=0; i<dataLen; i++){
                    var lcts = '';
                    lcts = data.Data[i].location.lat+','+data.Data[i].location.lng;
                    tagA += "<div style='display:flex;' ><a href='javascript: void(0);' class='search_think' lct='"+lcts+"' key_words='"+data.Data[i].key_words+"'>"+data.Data[i].key_words+"</a><span style='position: absolute;right: 15px;'>"+data.Data[i].district+"</span></div>";

                }
                $("#search_info").append(tagA);
                if ($('#keyword_input').val()!="") {
                    $('#search_info').show();
                }
            }
        });
    });

    // 区域需求的位置选择
    $( '.single-area-location' ).toChoice( {
        list: 'li',
        bind: 'a',
        except: '.choiced-except',
        after_choiced: function( id, name, obj )
        {
            var params = JSON.parse( obj.attr( 'data-choiced' ) );
            var api_url = api_urls["location"]["area"][params["key"]];
            var area_inputs = $( '#area_inputs' );

            // 不限制条件不进行网络请求
            if( typeof api_url === 'undefined' )
            {
                $( "#location_level_1" ).hide();
                $( "#location_level_2" ).hide();

                // 选中的值写入表单区域
                area_inputs.find( 'input[name="location"]' ).val( '0' );
                return false;
            }

            $.ajax( {
                type: "post",
                url: api_url,
                data: {'_token':TOKEN, cityId: CITY_ID},
                dataType: "json",
                timeout: 5000,
                beforeSend: function( XMLHttpRequest )
                {
                    $( "#location_level_1" ).hide();
                    $( "#location_level_2" ).hide();
                    $( "#location_loading" ).show();
                },
                success: function( Response )
                {
                    var location_layer = $( '#location_level_1' );

                    if( Response["Success"] === true )
                    {
                        $( "#location_loading" ).hide();
                        location_layer.show();

                        // 清除之前上一次数据
                        location_layer.find( '.now-node' ).remove();

                        var data = Response["Data"];

                        // 生成新数据
                        for( var key in data )
                        {
                            var h_li = $( '<li class="now-node" data-choiced={"id":"'+data[key]["id"]+'","name":"'+data[key]["name"]+'"}></li>'),
                                h_a = $( '<a href="javascript: void(0);"> '+data[key]["name"]+ '</a>' );

                            h_li.append( h_a );
                            location_layer.append( h_li );
                        }

                        location_layer.toChoice( {
                            list: 'li',
                            bind: 'a',
                            after_choiced: function( id, name )
                            {
                                // 选中的值写入表单区域
                                area_inputs.find( 'input[name="location"]' ).val( params["prefix"]+'-'+id );

                                ajaxGetPlace();
                            }
                        } );
                    }
                }
            } );
        }
    } );

    // 区域需求的星级选择
    var choiced_star = [];
    $( '.multi-star-level' ).find( 'li' ).each( function()
    {
        var that = $( this );

        that.click( function()
        {
            var _this = $( this );
            var choiced = _this.attr( 'if-choiced' );
            var data = JSON.parse( _this.attr( 'data-choiced' ) );
            var area_inputs = $( '#area_inputs' );

            // 选中不限制与其他选项的效果
            if( !_.isUndefined( data["limit"] ) )
            {
                area_inputs.find( 'input[name="star"]' ).val( '0' );

                $( '.multi-star-level' ).find( 'li' ).removeAttr( 'if-choiced' ).find( 'a' ).css( {"color": "#676a6c"} );

                _this.find( 'a' ).css( {"color": "#00b6b8"} );
                _this.attr( 'if-choiced', 'on' );
            }
            else
            {
                // 去除不限按钮被选中状态
                $( '.multi-star-level' ).find( 'li' ).eq(0).removeAttr( 'if-choiced' ).find( 'a' ).css( {"color": "#676a6c"} );

                // 选中和非选中状态判断
                if( typeof choiced === 'undefined' )
                {
                    _this.find( 'a' ).css( {"color": "#00b6b8"} );
                    _this.attr( 'if-choiced', 'on' );

                    // 星级值得添加
                    choiced_star.push( data["id"] );
                    area_inputs.find( 'input[name="star"]' ).val( choiced_star.join( ',' ) );
                }
                else
                {
                    // 取消选中状态
                    _this.find( 'a' ).css( {"color": "#676a6c"} );
                    _this.removeAttr( 'if-choiced' );

                    // 星级值得删除
                    choiced_star = _.filter( choiced_star, function( num ){ return num !== data["id"]; } );
                    area_inputs.find( 'input[name="star"]' ).val( choiced_star.join( ',' ) );
                }
            }

            ajaxGetPlace();
        } );
    } );

    // 摆桌类型
    $( '.single-desk-shape' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="layout"]' ).val( id );

            ajaxGetPlace();
        }
    } );

    // 窗户选择
    $( '.single-choiced-window' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="is_window"]' ).val( name );

            ajaxGetPlace();
        }
    } );
    //人数选择
    $( '.single-desk-num').toChoice({
        list : 'li',
        bind : 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="place_people_num"]' ).val( id );

            ajaxGetPlace();
        }
    });
    //面积选择
    $( '.single-desk-area').toChoice({
        list : 'li',
        bind : 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="area"]' ).val( id );

            ajaxGetPlace();
        }
    });
    //价格选择
    $( '.single-desk-price').toChoice({
        list : 'li',
        bind : 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="price"]' ).val( id );

            ajaxGetPlace();
        }
    });
    // 立柱选择
    $( '.single-choiced-column' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="is_column"]' ).val( name );

            ajaxGetPlace();
        }
    } );

    // 排序选择
    $( '.choice-sort' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            var node = $( '#start_sort_icon' );

            // 状态转换
            if( name === 'desc' )
            {
                obj.attr( 'data-choiced', JSON.stringify( {"id":id, "name":"asc"} ) );
                node.html( '<i class="fa fa-angle-down"></i>' );
            }
            else
            {
                obj.attr( 'data-choiced', JSON.stringify( {"id":id, "name":"desc"} ) );
                node.html( '<i class="fa fa-angle-up"></i>' );
            }

            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="sort"]' ).val( name );

            ajaxGetPlace();
        }
    } );

    // 关键字搜索
    $( '#submit-keyword' ).click( function()
    {
        var that = $( this );
        var keyword = that.parent().siblings( 'input' ).val();

        $( '#area_inputs' ).find( 'input[name="keyword"]' ).val( keyword );

        ajaxGetPlace()
    } );

    // 联想搜索选择地标
    $("body").on("click", ".search_think", function() {
        var that = $( this );
        // 选中的值写入表单区域
        $( '#area_inputs' ).find( 'input[name="lct"]' ).val( that.attr("lct") );
        $( '#area_inputs' ).find( 'input[name="keyword"]' ).val( that.attr("key_words") );
        $( '#keyword_input').val(that.attr("key_words"));

        ajaxGetPlace();
    } );


    // 对于自动生成的节点进行点击事件数据请求绑定
    var auto_keys = [1,2];

    $.each( auto_keys, function( key, content )
    {
        $( '#location_level_'+content ).toChoice( {
            list: 'li',
            bind: 'a',
            after_choiced: function( id, name, obj )
            {
                ajaxGetPlace();
            }
        } );
    } );

/*    $( "#keyword_input" ).bsSuggest( {
        url: "js/plugins/suggest/data.json?_token="+TOKEN,
        idField: "userId",
        keyField: "userName"
    } )
    .on( "onDataRequestSuccess", function( e, result )
    {
        console.log( "onDataRequestSuccess: ", result );
    } )
    .on( "onSetSelectValue", function( e, keyword )
    {
        console.log( "onSetSelectValue: ", keyword );
    } )
    .on( "onUnsetSelectValue", function( e )
    {
        console.log( "onUnsetSelectValue" );
    } );*/

    // 获取推荐酒店信息
    function ajaxGetPlace()
    {
        GetRequest();
        var filter_wrap = $( '#area_inputs' );

        // 过滤条件
        filter_wrap.find( 'input' ).each( function( i )
        {
            var _that = $( this ),
                _name = _that.attr( 'name' ),
                _val = _that.val();

            FILTER[_name] = _val;
        } );

        // 数据请求
        $.ajax( {
            type: "post",
            url: "/place/get_place",
            data: FILTER,
            dataType: "json",
            timeout: 5000,
            success: function( Response )
            {
                if( Response["Success"] === true )
                {
                    var data = JSON.parse( Response["Data"] );

                    genCommendList( data );


                    PlaceMap.initMap( jQuery.parseJSON( JSON.stringify( data["mapJson"] ) ) );
                    setMapAreaSize();
                }
            }
        } );
    }

    /**
     * des: 生成推荐列表
     * @param data [type|object] 数据集
     */
    function genCommendList( data )
    {
        var total       = data.total,                                     // 匹配数据条数
            count       = 10,                                             // 每页显示数量
            page        = data.page;                                       // 当前页码
        var rows        = data.rows;                                       // 数据集
        var request     = data.request;                                     //获取返回的搜索场地搜索参数
        var list_wrap   = $( '#hotel_commend_list' );                 // 推荐列表展示区域
        var real_sidebar= $( '#real_sidebar' );
        list_wrap.empty();
        real_sidebar.empty();
        var key_words = '';


        if(request['key_words']){
            key_words = request['key_words'];
        }

        var keys_place_name = '';
        // 循环生成推荐列表
        for( var key in rows )
        {

            if(key == 0){
                keys_place_name = rows[key]["place_name"];
            }

            var _place_id = rows[key]["place_id"],                                                                                      // 推荐列表索引
                _place_name = rows[key]["place_name"],                                                                                  // 酒店名称
                _address = rows[key]["address"],                                                                                        // 酒店地址
                _location = rows[key]["location"],                                                                                      // 酒店坐标
                _place_type = !_.isUndefined( rows[key]["place_type"] ) ? place_types[rows[key]["place_type"]] : ' ',                   // 酒店类型
                _star_rate = !_.isUndefined( rows[key]["star_rate"] ) ? rows[key]["star_rate"] : '1',                                   // 酒店星级
                _area = !_.isUndefined( rows[key]["area"] ) ? rows[key]["area"] : ' ',                                                  // 会议室最大面积
                _roomCount = !_.isUndefined( rows[key]["roomCount"] ) ? rows[key]["roomCount"] : ' ',                                   // 客房数量
                _meetingRoomCount = !_.isUndefined( rows[key]["meetingRoomCount"] ) ? rows[key]["meetingRoomCount"] : ' ',              // 会议室数量
                _maxCapacity = !_.isUndefined( rows[key]["maxCapacity"] ) ? rows[key]["maxCapacity"] : ' ',                             // 最多可纳人数
                _roomMinPrice = !_.isUndefined( rows[key]["roomMinPrice"] ) ? rows[key]["roomMinPrice"] : '_',                          // 团队房
                _meetingRoomMinPrice = !_.isUndefined( rows[key]["meetingRoomMinPrice"] ) ? rows[key]["meetingRoomMinPrice"] : '_',     // 会议厅
                _main_pic_url = rows[key]["main_pic_url"],                 // 图片地址
                _distance = !_.isUndefined( rows[key]["distance"] ) ? rows[key]["distance"] : '-';

            var list_tmp = $( '#hotel_commend_list_tmp' ).text();           // 推荐列表模板

            // 场地是否已经被选中样式
            for( var h_key in choiced_hotel )
            {
                var choiced_id = 'be_choiced_hotel_'+_place_id;

                if( _.has( choiced_hotel, choiced_id ) )
                {
                    list_tmp = list_tmp.replace( '{choiced}', '' );
                }
            }

            list_tmp = list_tmp.replace( '{choiced}', 'btn-outline' );

            // 星级节点生成
            var wrap_star = $( '<span></span>' );
            for( var iCount = 0; iCount < _star_rate; iCount++ )
            {
                wrap_star.append( $( '<i class="fa fa-star"></i>' ) );
            }

            list_tmp = list_tmp.replace( '{compress}', JSON.stringify( {place_id:_place_id,place_name:_place_name,addr:_address,img:_main_pic_url} ) );   // 精简一部分数据
            list_tmp = list_tmp.replace( '{place_name}', _place_name );
            list_tmp = list_tmp.replace( '{place_id}', _place_id );
            list_tmp = list_tmp.replace( '{address}', _address );
            list_tmp = list_tmp.replace( '{star_rate}', wrap_star.html() );
            list_tmp = list_tmp.replace( '{place_type}', _place_type );
            list_tmp = list_tmp.replace( '{area}', _area );
            list_tmp = list_tmp.replace( '{roomCount}', _roomCount );
            list_tmp = list_tmp.replace( '{meetingRoomCount}', _meetingRoomCount );
            list_tmp = list_tmp.replace( '{maxCapacity}', _maxCapacity );
            list_tmp = list_tmp.replace( '{roomMinPrice}', _roomMinPrice );
            list_tmp = list_tmp.replace( '{meetingRoomMinPrice}', _meetingRoomMinPrice );
            list_tmp = list_tmp.replace( '{main_pic_url}', _main_pic_url );
            list_tmp = list_tmp.replace( '{location}', _location );

            // 做判断
            if(key_words!= '' && keys_place_name!=key_words){
                if(_distance == '-'){
                    var x = 2000;
                    var y = 500;
                    _distance = parseInt(Math.random() * (x - y + 1) + y);
                }
                list_tmp = list_tmp.replace( '{distance}', '该场地距离'+key_words+'步行'+_distance+'米' );
            }else{
                list_tmp = list_tmp.replace( '{distance}', '' );
            }


            list_wrap.append( list_tmp );

            //生成提示列表
            var tips_tmp = $( '#sidebar' ).text();
            tips_tmp = tips_tmp.replace( '{i}', Number(key)+1 );
            tips_tmp = tips_tmp.replace( '{place_name1}', _place_name );
            tips_tmp = tips_tmp.replace( '{place_name2}', _place_name );
            tips_tmp = tips_tmp.replace( '{img_url}', _main_pic_url );
            tips_tmp = tips_tmp.replace( '{place_id1}', _place_id );
            tips_tmp = tips_tmp.replace( '{place_id2}', _place_id );
            tips_tmp = tips_tmp.replace( '{address}', _address );
            tips_tmp = tips_tmp.replace( '{star_rate}', wrap_star.html() );

            real_sidebar.append( tips_tmp );


        }

        $( '#commend_hotel_total' ).html( total );

        var pagination_node = genPagination( {"total":total,"count":count,"current":page,"template": '<a href="javascript: void(0);" class="btn btn-white"></a>'} );

        // 循环绑定事件
        $.each( pagination_node, function( i, n )
        {
            var that = $( this );
            that.on( 'click', function()
            {
                var _action = $( this ).attr( 'data-action' );

                if( _action !== 'none' )
                {
                    reCommendList( {"page":_action} );
                }
            } );
        } );

        $( '#hotel_commend_pagination' ).html( pagination_node );

    }

    /**
     * des: 重新请求数据
     * @param:
     */
    function reCommendList( params )
    {
        var http_data = $.extend( true, {}, FILTER, params );

        $.ajax( {
            type: "post",
            url: "/place/get_place",
            data: http_data,
            dataType: "json",
            timeout: 5000,
            success: function( Response )
            {
                if( Response["Success"] === true )
                {
                    var data = JSON.parse( Response["Data"] );
                    genCommendList( data );

                    PlaceMap.initMap( jQuery.parseJSON( JSON.stringify( data["mapJson"] ) ) );
                    setMapAreaSize();
                }
            }
        } );
    }
    function addTips( data ){
        console.log(data);
    }


    //鼠标划过推荐列表的酒店事件
    /*
     *绑定鼠标滑入list li
     */

    $( '#hotel_commend_list' ).on( 'mouseover','.mv', function(){
        var location = $(this).attr('la_data');
        location = location.split(',');

        var myIcons = new BMap.Icon(this.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56));
        var points = new BMap.Point(location[1], location[0], { icon: myIcons });
        var themarkers = new BMap.Marker(points, { icon: myIcons });

        var i=$(this).index();
        PlaceMap.onover(i);
        PlaceMap.showTips(themarkers, i);
    });
    $( '#hotel_commend_list' ).on( 'mouseout','.mv', function(){

        var location = $(this).attr('la_data');
        location = location.split(',');

        var myIcons = new BMap.Icon(this.IMG_BASEURL + "blue_" + (i + 1) + ".png", new BMap.Size(56, 56));
        var points = new BMap.Point(location[1], location[0], { icon: myIcons });
        var themarkers = new BMap.Marker(points, { icon: myIcons });

        var i=$(this).index();
        PlaceMap.onout(i);
        PlaceMap.hideTips(themarkers, i);
    });



    // 将酒店加入意向酒店场地
    var choiced_hotel = [];
    var choiced_hotel_node = $( '#choiced_hotel_list' );

    $( '#hotel_commend_list' ).on( 'click', '.hotel-purpose', function()
    {
        var that = $( this );
        var base_data = JSON.parse( that.attr( 'data-compress' ) ),
            choiced_id = 'be_choiced_hotel_'+base_data["place_id"];
        var item_node = function()
            {
                // 动态获取节点数量
                return ( function()
                {
                    return choiced_hotel_node.find( '.choiced-content' ).find( '.item' );
                } )();
            },
            item_tmp = $( '#choiced_tamplate' ).text();
        var choiced_tmp = [];

        // 选中和取消选中场地
        if( that.attr( 'class' ).indexOf( 'btn-outline' ) > 0 && !_.has( choiced_hotel, choiced_id ) )
        {
            // 备选场地数量控制
            if( Object.keys( choiced_hotel ).length >= 3 )
            {
                swal( {
                    title: "",
                    text: "只能有3个场地作为备选",
                    type: "error",
                    confirmButtonText: "确定"
                } );
                return false;
            }

            // 右侧购物车填入选中场地
            if( item_node().length < 3 )
            {
                // 选中状态
                that.removeClass( 'btn-outline' );
                choiced_hotel[choiced_id] = {
                    "place_id": base_data["place_id"],
                    "place_name": base_data["place_name"]
                };

                item_tmp = item_tmp.replace( /({id})/g, choiced_id );
                item_tmp = item_tmp.replace( '{name}', base_data["place_name"] );
                item_tmp = item_tmp.replace( '{img}', base_data["img"] );
                item_tmp = item_tmp.replace( '{addr}', base_data["addr"] );

                choiced_hotel_node.find( '.choiced-content' ).find( '.caption' ).after( item_tmp );

                // 删除意向酒店场地
                choiced_hotel_node.find( '.choiced-content' ).find( '.remove' ).click( function()
                {
                    var in_that = $( this );
                    var target = in_that.attr( 'data-target' );

                    // 数据过滤
                    for( var key in choiced_hotel )
                    {
                        if( key !== choiced_id )
                        {
                            choiced_tmp[key] = choiced_hotel[key];
                        }
                    }
                    choiced_hotel = choiced_tmp;


                    $( '#'+target ).remove();

                    // 取消选中
                    that.addClass( 'btn-outline' );
                } );

                // 购物车效果展开
                if( item_node().length === 1 )
                {
                    choiced_hotel_node.animate( {
                        right: "0"
                    }, 500 );

                    choiced_hotel_node.find( '.drawer-btn' ).find( 'a' ).html( '<i class="fa fa-angle-double-right"></i>' );
                }
            }
        }
        else
        {
            // 取消选中
            that.addClass( 'btn-outline' );

            // 数据过滤
            for( var key in choiced_hotel )
            {
                if( key !== choiced_id )
                {
                    choiced_tmp[key] = choiced_hotel[key];
                }
            }
            choiced_hotel = choiced_tmp;

            $( '#'+choiced_id ).remove();
        }
    } );


    // 手动展开或收起购物车效果
    choiced_hotel_node.find( '.drawer-btn' ).on( 'click', function()
    {
        // 收起
        if( parseInt( choiced_hotel_node.css( "right" ) ) === 0 )
        {
            choiced_hotel_node.animate( {
                right: "-200"
            }, 500 );
            choiced_hotel_node.find( '.drawer-btn' ).find( 'a' ).html( '<i class="fa fa-angle-double-left"></i>' );
        }

        // 展开
        if( parseInt( choiced_hotel_node.css( "right" ) ) === -200 )
        {
            choiced_hotel_node.animate( {
                right: "0"
            }, 500 );
            choiced_hotel_node.find( '.drawer-btn' ).find( 'a' ).html( '<i class="fa fa-angle-double-right"></i>' );
        }
    } );

    // 选中场地提交
    $( '#submit_hotel' ).click( function()
    {
        var data = [
            'rfp_id='+RFP_ID,
            'place='+JSON.stringify( _.values( choiced_hotel ) ) 
        ];

        var loader = $( ".fakeloader" ),
            loader_status = loader.attr( "data-status" );

        $.ajax( {
            type: "post",
            url: '/place/set_hotel?'+data.join( '&' ),
            data: {'_token':TOKEN},
            dataType: "json",
            timeout: 5000,
            beforeSend: function( XMLHttpRequest )
            {
                // 无需重复实例化, 可以服用特效
                if( loader_status === 'init' )
                {
                    loader.fakeLoader( {
                        cancelHide: true,
                        bgColor: "#e74c3c",
                        zIndex: 9999,
                        extTxtCss: {"margin-top": "18px"},
                        extCss: {"background-color": "#000000","opacity": "0.8","-moz-opacity": "0.8","filter": "alpha(opacity=80)"},
                        spinner: "spinner7",
                        loadingTxt: '处理中, 请稍后...'
                    } );

                    loader.attr( {"data-status":"used"} );                // 修改遮罩层的状态
                }
                else
                {
                    loader.fadeIn();
                }
            },
            success: function( Response )
            {
                if( Response["Success"] === true )
                {
                    swal( {
                            title: "",
                            text: "操作成功",
                            type: "success",
                            confirmButtonText: "确定"
                        },
                        function ( flag )
                        {
                            location.href = '/Rfp/preview_confim?rfp_id='+RFP_ID;
                        } );
                }
                else
                {
                    swal( {
                            title: "",
                            text: "操作失败,请重试",
                            type: "error",
                            confirmButtonText: "确定"
                        },
                        function ( flag )
                        {
                            loader.fadeOut();
                        } );
                }
            }
        } );
    } );
} );
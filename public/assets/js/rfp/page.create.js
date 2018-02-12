/**
 * Created by jzco on 2017/8/18.
 */
function pushid(){
    console.log(localStorage.postArrId);
    var push=$("#pushid");
    if(localStorage.postArrId){
        push.find('input[name="join_id"]').val(localStorage.postArrId);
    }
    push.submit();

}
$( document ).ready( function()
{
    $( "#wizard" ).steps( {
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        stepsOrientation: "vertical",
        enableAllSteps: true,
        labels:{finish:"智能场地推荐"},
        /*onStepChanging: function( event, currentIndex, newIndex )
         {

         },
         onFinishing: function( event, currentIndex )
         {

         },*/
        onFinished: function( event, currentIndex )
        {
            var _form = $( '#submit_form' ),
                _form_status = _form.attr( 'data-status' ),                                     // 表单目前状态
                _form_data = _form.serialize();

            // 屏蔽重复提交
            if( _form_status !== 'processed' )
            {
                var _base_str = 'cityId='+CITY_ID+'&rfp_id='+RFP_ID,                            // 必传数据
                    _tmp = [_base_str,_form_data],                                              // 数组化, 方便组合
                    _final_data = {"_token":TOKEN, "param":{"data": _tmp.join( '&' )}};         // 最终提交数据

                var loader = $( ".fakeloader" ),
                    loader_status = loader.attr( "data-status" );

                $.ajax( {
                    type: "post",
                    url: '/rfp/create_rfp',
                    data: _final_data,
                    dataType: "json",
                    timeout: 5000,
                    beforeSend: function( XMLHttpRequest )
                    {
                        _form.attr( 'data-status', 'processed' );                               // 屏蔽表单重复提交

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
                            var input_wrap = $( '#area_inputs' );
                            var input_names = ["area[type]","area[location]","area[star]"];
                            var reg = /area\[(.*)\]/;
                            var filter_ext = [];

                            $.each( input_names, function( key, content )
                            {
                                var tmp_val = input_wrap.find( 'input[name="'+content+'"]' ).val();
                                var tmp_key = content.match( reg );

                                if( !_.isEmpty( tmp_val ) )
                                {
                                    filter_ext.push( tmp_key[1]+'='+tmp_val );
                                }
                            } );

                            filter_ext.push( "rfp_id="+RFP_ID );
                            filter_ext.push( "city_id="+CITY_ID );

                            // 跳转到智能推荐页面
                            location.href = "/Rfp/main_recommend?"+filter_ext.join('&');
                        }
                    },
                    error: function( XMLHttpRequest, textStatus, errorThrown )
                    {
                        loader.fadeOut();
                        _form.attr( 'data-status', '' );

                        var error_code = XMLHttpRequest['status'],
                            error_msg = {
                                "500": "未知错误, 请联系管理人员！",
                                "504": "服务器未响应, 请稍后重试！"
                            };

                        swal( {
                            title: "抱歉",
                            text: error_msg[error_code],
                            type: "error",
                            confirmButtonText: "确定"
                        } );
                    }
                } );
            }
        }
    } );

    // 基本表格数据创建
    var table_data = ( function( detail, rfp )
    {
        var base = '[{"table_id":"base_demand_table","class":"table table-bordered m-t-md","css":{"background-color":"#FFF"},"attr":{"border":"1"},"target":"#wizard-p-0","thead":[{"css":{"width":"15%","text-align":"center"},"text":"#"},{"attr":{"colspan":"2"},"text":"内容"},{"css":{"width":"80px","text-align":"center"},"text":""}],"tbody":[{"0":{"css":{"text-align":"center"},"text":"会议编码"},"1":{"attr":{"colspan":"2"},"text":"{meeting_code}"},"2":{"css":{"text-align":"center"},"attr":{"rowspan":"10"},"html":"{edit}"}},{"0":{"css":{"text-align":"center"},"text":"会议名称"},"1":{"attr":{"colspan":"2"},"text":"{meeting_name}"}},{"0":{"css":{"text-align":"center"},"text":"会议类型"},"1":{"attr":{"colspan":"2"},"text":"{meeting_type_desc}"}},{"0":{"css":{"text-align":"center"},"text":"参会人数"},"1":{"attr":{"colspan":"2"},"text":"{people_num}人"}},{"0":{"css":{"text-align":"center"},"text":"会议时间"},"1":{"attr":{"colspan":"2"},"text":"{start_time} - {end_time}"}},{"0":{"css":{"text-align":"center"},"text":"行程时间"},"1":{"attr":{"colspan":"2"},"text":"{trip_start_time} - {trip_end_time}"}},{"0":{"css":{"text-align":"center"},"text":"会议地点"},"1":{"attr":{"colspan":"2"},"text":"{citydesc}"}},{"0":{"css":{"text-align":"center"},"text":"总预算"},"1":{"attr":{"colspan":"2"},"text":"{budget_total_amount}"}},{"0":{"css":{"text-align":"center"},"text":"会议日程"},"1":{"attr":{"colspan":"2"},"html":"{download_file}"}},{"0":{"css":{"text-align":"center"},"text":"参会人管理"},"1":{"attr":{"colspan":"2"},"html":"{pepo}"}}]}]';

        for( var key in detail )
        {
            var tmp = '{'+key+'}';

            if( base.indexOf( tmp ) > -1 )
            {
                base = base.replace( tmp, detail[key] );
            }
        }

        // 特殊替换处理
        base = base.replace( '{edit}', '<a class=\\\"text-info\\\"; href=\\\"/Meeting/edit?rfp_id='+rfp+'\\\"><i class=\\\"fa fa-edit\\\"></i> 编辑</a>' );
        base = base.replace( '{download_file}', '<a class=\\\"text-info\\\" href=\\\"'+detail["abroad_file"]+'\\\"><i class=\\\"fa fa-download\\\"></i> 查看附件</a>' );
        base = base.replace( '{pepo}', '<a class=\\\"text-info\\\"  onclick=\\\"pushid()\\\" target=\\\"_blank\\\"><i class=\\\"fa fa-download\\\"></i> 查看参会人员名单</a>' );

        return JSON.parse( base );
    } )( ORIGIN_DATA["detail"], RFP_ID );

    tableBuilder( table_data );

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
            }                                                                          // 区域需求配置项
        }
    };

    // 区域需求的类型选择
    $( '.single-area-type' ).toChoice( {
        list: 'li',
        bind: 'a',
        after_choiced: function( id, name, obj )
        {
            var node = $( '#choiced_type_wrap' );
            node.find( '.choiced-type-wrap' ).remove();

            node.append( '<button type="button" class="oper-btn m-r-xs choiced-type-wrap">类型: '+name+' <i class="fa fa-remove i-close"></i></button>' );

            // 选中的值写入表单区域
            $( '#area_inputs' ).find( 'input[name="area[type]"]' ).val( id );
        }
    } );

    // 地铁周边选择
    $( '#subway_choice' ).click( function()
    {
        var toggle = $( this ).attr( 'data-toggle' );

        $( '.single-area-location li a' ).css( {"color": "#999999"} );                // 清除全部选中字体样式
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
                                        var node = $( '#choiced_location_wrap' );
                                        node.find( '.choiced-location-wrap' ).remove();
                                        node.append( '<button type="button" class="oper-btn m-r-xs choiced-location-wrap">位置: '+s_name+' <i class="fa fa-remove i-close"></i></button>' );

                                        // 选中的值写入表单区域
                                        $( '#area_inputs' ).find( 'input[name="area[location]"]' ).val( 'metro-'+id+'-'+s_id );
                                    }
                                } );
                            }, 1200 );
                        }
                    } );
                }
            }
        } );
    } );

    // 区域需求的位置选择
    $( '.single-area-location' ).toChoice( {
        list: 'li',
        bind: 'a',
        except: '.choiced-except',
        after_choiced: function( id, name, obj )
        {
            var params = JSON.parse( obj.attr( 'data-choiced' ) );
            var api_url = api_urls["location"]["area"][params["key"]];
            var node = $( '#choiced_location_wrap' );
            var area_inputs = $( '#area_inputs' );

            // 不限制条件不进行网络请求
            if( typeof api_url === 'undefined' )
            {
                $( "#location_level_1" ).hide();
                $( "#location_level_2" ).hide();

                node.find( '.choiced-location-wrap' ).remove();
                node.append( '<button type="button" class="oper-btn m-r-xs choiced-location-wrap">位置: 不限 <i class="fa fa-remove i-close"></i></button>' );

                // 选中的值写入表单区域
                area_inputs.find( 'input[name="area[location]"]' ).val( '0' );
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
                                node.find( '.choiced-location-wrap' ).remove();
                                node.append( '<button type="button" class="oper-btn m-r-xs choiced-location-wrap">位置: '+name+' <i class="fa fa-remove i-close"></i></button>' );

                                // 选中的值写入表单区域
                                area_inputs.find( 'input[name="area[location]"]' ).val( params["prefix"]+'-'+id );
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
            var node = $( '#choiced_star_wrap' );
            var area_inputs = $( '#area_inputs' );

            // 选中不限制与其他选项的效果
            if( !_.isUndefined( data["limit"] ) )
            {
                node.empty();
                node.append( '<button type="button" class="oper-btn m-r-xs choiced-star-wrap">星级: 不限 <i class="fa fa-remove i-close"></i></button>' );
                area_inputs.find( 'input[name="area[star]"]' ).val( '0' );

                $( '.multi-star-level' ).find( 'li' ).removeAttr( 'if-choiced' ).find( 'a' ).css( {"color": "#999999"} );

                _this.find( 'a' ).css( {"color": "#00b6b8"} );
                _this.attr( 'if-choiced', 'on' );
            }
            else
            {
                // 去除不限按钮被选中状态
                $( '.multi-star-level' ).find( 'li' ).eq(0).removeAttr( 'if-choiced' ).find( 'a' ).css( {"color": "#999999"} );

                // 选中和非选中状态判断
                if( typeof choiced === 'undefined' )
                {
                    // 清除初始化节点
                    node.find( '.choiced-star-wrap' ).remove();

                    _this.find( 'a' ).css( {"color": "#00b6b8"} );
                    _this.attr( 'if-choiced', 'on' );

                    // 星级值得添加
                    choiced_star.push( data["id"] );
                    area_inputs.find( 'input[name="area[star]"]' ).val( choiced_star.join( ',' ) );

                    node.append( '<button type="button" class="oper-btn m-r-xs choiced-start-'+data["id"]+'">星级: '+data["name"]+' <i class="fa fa-remove i-close"></i></button>' );
                }
                else
                {
                    // 取消选中状态
                    _this.find( 'a' ).css( {"color": "#999999"} );
                    _this.removeAttr( 'if-choiced' );

                    // 星级值得删除
                    choiced_star = _.filter( choiced_star, function( num ){ return num !== data["id"]; } );
                    area_inputs.find( 'input[name="area[star]"]' ).val( choiced_star.join( ',' ) );

                    node.find( '.choiced-start-'+data["id"] ).remove();
                }
            }
        } );
    } );

    shapeTipTools();

    // 桌型排放简介 tip tools
    function shapeTipTools()
    {
        var node = $( '#shape_tip_tools' );
        var wrap = $( '#wizard-p-2' );
        var config = {
            "shape_desk":{
                "img":"http://links.eventown.com.cn/images/4.0/kzs.jpg",
                "name":"课桌式",
                "desc":"会议室内将桌椅按排端正摆放，按教室式布置会议室，每个座位的空间将根据桌子的大小而有所不同。",
                "feature":"此种桌型摆设可针对会议室面积和观众人数在安排布置上有一定的灵活性；参会者可以有放置资料及记笔记的桌子，还可以最大限度容纳人数。"
            },
            "shape_feast":{
                "img":"http://links.eventown.com.cn/images/4.0/zsyh.jpg",
                "name":"中式宴会",
                "desc":"多张圆形桌组成，周围摆放座椅。以宴会形式摆桌。",
                "feature":"合人数较多。档次较高的就餐要求，距离较近，容易产生近距离的交流感。"
            },
            "shape_theater":{
                "img":"http://links.eventown.com.cn/images/4.0/jys.jpg",
                "name":"剧院式",
                "desc":"在会议厅内面向讲台摆放一排排座椅，中间留有较宽的过道。",
                "feature":"在留有过道的情况下，最大程度地摆放座椅，最大限度地将空间利用起来，在有限的空间里可以最大限度容纳人数；但参会者没有地方放资料，也没有桌子可用来记笔记。"
            },
            "shape_cocktail":{
                "img":"http://links.eventown.com.cn/images/4.0/jwj.jpg",
                "name":"鸡尾酒",
                "desc":"以酒会式摆桌，只摆放供应酒水、饮料及餐点的桌子，不摆设椅子，以自由交流为主的一种会议摆桌形式。",
                "feature":"自由的活动空间可以让参会者自由交流，构筑轻松自由的氛围。"
            },
            "shape_fishbone":{
                "img":"http://links.eventown.com.cn/images/4.0/fzs.jpg",
                "name":"鱼骨式",
                "desc":"由桌椅搭配，也有另一个名字“鱼骨式”。",
                "feature":"一般用于需求小组讨论的培训。"
            },
            "shape_director":{
                "img":"http://links.eventown.com.cn/images/4.0/dsh.jpg",
                "name":"董事会式",
                "desc":"圆形或椭圆形大会议桌，周围摆放座椅。按照主次落座。",
                "feature":"适合人数较少。档次较高的会议要求，距离较近，容易产生近距离的交流感。"
            }
        };

        // 事件绑定
        wrap.on( 'mouseover', '.shape-style', function()
        {
            var refer = $( this ).siblings( 'input' ),                              // 参考的节点
                _offset = refer.offset();
            var _shape_data = config[refer.attr( "id" )];

            var tmp = $( '#shape_tip_tmp' ).text();
            $.each( _shape_data, function( key, content )
            {
                tmp = tmp.replace( '{'+key+'}', content );
            } );

            node.empty().html( tmp );

            // 边界超越判断
            if( _offset["left"] + node.width() >= $( document ).width() )
            {
                node.css( {"top": _offset["top"] + refer.height()*3, "left": _offset["left"] - node.width()/2} ).show();
            }
            else
            {
                node.css( {"top": _offset["top"] + refer.height()*3, "left": _offset["left"]} ).show();
            }

            node.on( 'mouseout', function()
            {
                node.hide();
            } );
        } );
    }

   /* -=== 多节点创建和插件绑定配置 START ===- */

    var plugin_store = {
        "place": {},
        "food": {},
        "wine": {},
        "room": {}
    };

    var datapicker_options = {
        language: 'zh',
        minDate: '',                 // 禁止选择今天之前的日期
        //todayButton: new Date(),
        //clearButton: true
    };
    var datepicker_options_notime = $.extend( true, {}, datapicker_options );
    var datepicker_options = $.extend( true, {}, datapicker_options, {timepicker: true} );

    batchInitPlugins( plugin_store["place"], '#place_duplicate_layout', 'base' );
    batchInitPlugins( plugin_store["food"], '#food_duplicate_layout', 'base' );
    batchInitPlugins( plugin_store["wine"], '#wine_duplicate_layout', 'base' );
    batchInitPlugins( plugin_store["room"], '#room_duplicate_layout', 'base' );

    var bind_config = ["place","food","wine","room"];

    $.each( bind_config, function( _key, _value )
    {
        var wraps = {
            "place": "#wizard-p-2",
            "food": "#wizard-p-3",
            "wine": "#wizard-p-3",
            "room": "#wizard-p-4"
        };
        var _add = $( '#add_'+_value+'_layout' );

        if( _add.length > 0 )
        {
            // 重复添加某需求节点内容
            _add.click( function()
            {
                var tamplate = $( '#'+_value+'_duplicate_tamplate' ).html();
                var find = $( this ).closest( '.'+_value+'-duplicate-layout' );

                ++KEY_COUNT;
                var dup_id = '#'+_value+'_duplicate_layout_'+( KEY_COUNT );

                tamplate = $( tamplate.replace( /\{key\}/g, KEY_COUNT ) );      // 替换 name 键值, 并对文本节点 jQuery 对象化
                find.after( tamplate );

                batchInitPlugins( plugin_store[_value], dup_id, 'node_'+KEY_COUNT );
            } );
        }

        var _warp = $( wraps[_value] );
        if( _warp.length > 0 )
        {
            // 删除某需求  notice: #wizard-p-x 是由 step.js 插件生成
            _warp.on( 'click', '.del-'+_value+'-layout', function()
            {
                var del_id = $( this ).attr( 'data-id' );
                var key_id = $( this ).attr( 'data-count' );

                delete plugin_store[_value]["node_"+key_id];
                $( del_id ).remove();
            } );
        }
    } );

    /**
     * des: 批量初始化指定节点插件
     */
    function batchInitPlugins( obj_store, addr, index )
    {
        // 节点寻址初始化
        $( addr ).find( 'input' ).each( function()
        {
            var plugin = $( this ).attr( 'data-plugin' ),
                node_index = $( this ).attr( "name" );

            var layout_node = $( addr );

            // 变量初始化
            if( typeof obj_store[index] === 'undefined' )
            {
                obj_store[index] = {};
            }

            if( typeof obj_store[index][node_index] === 'undefined' )
            {
                obj_store[index][node_index] = {};
            }

            if( typeof obj_store[index][node_index]["init"] === 'undefined' )
            {
                obj_store[index][node_index]["init"] = {};
            }

            if( typeof obj_store[index][node_index]["node"] === 'undefined' )
            {
                obj_store[index][node_index]["node"] = {};
            }

            // 需要特殊处理的插件部分
            switch( plugin )
            {
                case 'start-time':
                    datepicker_options = $.extend( true, {}, datapicker_options, {timepicker: false,autoClose:true} );
                    obj_store[index][node_index]["init"] = $( this ).datepicker( datepicker_options );
                    break;
                case 'end-time':
                    datepicker_options = $.extend( true, {}, datapicker_options, {timepicker: false,autoClose:true} );
                    obj_store[index][node_index]["init"] = $( this ).datepicker( datepicker_options );
                    break;
                case 'normal-time':
                    datepicker_options = $.extend( true, {}, datapicker_options, {timepicker: true,autoClose:true,minutesStep:5} );
                    obj_store[index][node_index]["init"] = $( this ).datepicker( datepicker_options );
                    break;
            }

            obj_store[index][node_index]["node"] = layout_node.find( $( this ) );
            obj_store[index][node_index]["plugin"] = plugin;
        } );

        // 插件关系绑定
        $.each( obj_store[index], function( key, detail )
        {
            var _this_var = detail["init"],
                _this_node = detail["node"];

            switch( detail["plugin"] )
            {
                case 'normal-time':
                    break;
                case 'start-time':
                    _this_var.datepicker( {
                        onHide: function( this_obj, completed )
                        {
                            if( !completed )
                            {
                                var this_val = this_obj.lastSelectedDate;
                                var target_index = key.replace( 'start', 'end' ),
                                    target_obj = obj_store[index][target_index]["init"].data( 'datepicker' ),
                                    target_val = target_obj.lastSelectedDate;

                                // 纠正开始时间和结束时间存在的时间区间错误
                                if( !_.isUndefined( this_val ) && !_.isUndefined( target_val ) )
                                {
                                    if( dateCompare( this_val, target_val ) > 0 )
                                    {
                                        var this_date = formatDatepicker( Date.parse( new Date( this_val ) ) ),
                                            target_date = formatDatepicker( Date.parse( new Date( target_val ) ) );

                                        this_obj.selectDate( new Date( target_date.getFullYear(), target_date.getMonth(), target_date.getDate(), target_date.getHours(), target_date.getMinutes() ) );
                                        target_obj.selectDate( new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() ) );
                                    }

                                    var days = new Date( Math.abs( this_val - target_val ) ) / ( 1000 * 60 * 60 * 24 );

                                    // 需要天数计算
                                    if( typeof obj_store[index][key.replace( '[start_time]', '[day]' )] !== 'undefined' )
                                    {
                                        obj_store[index][key.replace( '[start_time]', '[day]' )]["node"].val( Math.ceil( days ) );
                                    }
                                }
                            }
                        }
                    } );
                    break;
                case 'end-time':
                    _this_var.datepicker( {
                        onHide: function( this_obj, completed )
                        {
                            if( !completed )
                            {
                                var this_val = this_obj.lastSelectedDate;
                                var target_index = key.replace( 'end', 'start' ),
                                    target_obj = obj_store[index][target_index]["init"].data( 'datepicker' ),
                                    target_val = target_obj.lastSelectedDate;

                                // 未选中开始时间直接选择结束时间的纠正处理
                                if( !_.isUndefined( this_val ) && _.isUndefined( target_val ) )
                                {
                                    var date = formatDatepicker( Date.parse( new Date( this_val ) ) );
                                    target_obj.selectDate( new Date( date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes() ) );

                                    this_obj.clear();
                                }

                                // 纠正开始时间和结束时间存在的时间区间错误
                                if( !_.isUndefined( this_val ) && !_.isUndefined( target_val ) )
                                {
                                    if( dateCompare( this_val, target_val ) < 0 )
                                    {
                                        var this_date = formatDatepicker( Date.parse( new Date( this_val ) ) ),
                                            target_date = formatDatepicker( Date.parse( new Date( target_val ) ) );

                                        this_obj.selectDate( new Date( target_date.getFullYear(), target_date.getMonth(), target_date.getDate(), target_date.getHours(), target_date.getMinutes() ) );
                                        target_obj.selectDate( new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() ) );
                                    }

                                    var days = new Date( Math.abs( this_val - target_val ) ) / ( 1000 * 60 * 60 * 24 );

                                    // 需要天数计算
                                    if( typeof obj_store[index][key.replace( '[end_time]', '[day]' )] !== 'undefined' )
                                    {
                                        obj_store[index][key.replace( '[end_time]', '[day]' )]["node"].val( Math.ceil( days ) );
                                    }
                                }
                            }
                        }
                    } );
                    break;
                case 'touchs-pin':
                    _this_node.TouchSpin( {
                        min: 0,
                        max: 100000,
                        step: 1,
                        boostat: 5,
                        maxboostedstep: 10,
                        mousewheel:false,
                        buttondown_class: 'btn btn-white',
                        buttonup_class: 'btn btn-white'
                    } );

                    var _action = ( typeof _this_node.attr( 'data-action' ) !== 'undefined' ) ? JSON.parse( _this_node.attr( 'data-action' ) ) : '';

                    // 预算自动计算
                    if( !_.isEmpty( _action ) )
                    {
                        var _self = _action["self"], _self_seed = '['+_self+']',
                            _partner = _action["partner"], _partner_seed = '['+_partner+']',
                            _target = _action["target"], _target_seed = '['+_target+']';

                        var _partner_key = key.replace( _self_seed, _partner_seed ),
                            _partner_node = $( addr ).find( 'input[name="'+_partner_key+'"]' );

                        var _target_key = key.replace( _self_seed, _target_seed ),
                            _target_node = $( addr ).find( 'input[name="'+_target_key+'"]' );

                        // 事件监听
                        _this_node.closest( '.input-group' ).on( 'mouseleave', function()
                        {
                            var _this_val = Number( _this_node.val() ),
                                _partner_val = Number( _partner_node.val() );

                            if( _.isNumber( _this_val ) && _.isNumber( _partner_val ) )
                            {
                                // 计算结果
                                _target_node.val( _this_val * _partner_val );
                            }
                        } );
                    }
                    break;
            }
        } );

    }
    /* -=== 多节点创建和插件绑定配置 END ===- */

    // 数据带入, 暂行办法
    var meeting_date = $( '#meeting_date' );
    meeting_date.find( 'input[name="place[101][start_time]"]' ).val( ORIGIN_DATA["detail"]["start_time"] );
    meeting_date.find( 'input[name="place[101][end_time]"]' ).val( ORIGIN_DATA["detail"]["end_time"] );

    $('#people_num').val(ORIGIN_DATA["detail"]["people_num"]);
} );
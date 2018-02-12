$( document ).ready( function(){ //服务商选择，负责人跟着改变
    var model=$("#myModal");
    var name=model.find("select[name='name']");//服务商选择框
    var head=model.find("select[name='head']");//负责人选择框
    var server={};//会议ID
    var table=$("table"),
        alertModal=$("#alert");
    table.on("click","a[data-toggle=\"modal\"]",function(){
        server=$(this);
    })
//                table.on("click","a",function(){
//
//                })
    alertModal.on('click',"button",function(){
        alertModal.hide();
    })
    $(".chosen-select").chosen();
    model.find(".btn").on("click",function() { //点击确定触发

        if (!isNaN(head.val()) ) {
            $.ajax({
                type: "POST",
                url: "/Rfp/correlate",
                async:false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
                },
                data: {name: name.val(),rfp_id: server.attr("cord"),head:head.val()},
                success: function (data) {
                    if(data.msg){
                        console.log(data);
                        parent.layer.msg(data.msg);
                    }
                    else{
                        parent.layer.msg("添加成功");
                        setTimeout(function(){
                            location.reload();
                        },300)

                    }
                },
                error: function () {

                }
            })
        }else{
            alertModal.show()
        }

    });
    model.on("hidden.bs.modal",function(){
        name.val("请选择");
        head.val("请选择");
        head.attr("disabled","true");
        name.trigger("chosen:updated");
        head.trigger("chosen:updated");
        head.siblings(".chosen-container").find("span").html("请选择");
        name.siblings(".chosen-container").find("span").html("请选择");

    });

    name.on("change",function() { //第一个下拉框选择后触发

        var val = $(this).val();
        var nameVal = $(this).find('option[value=' + val + ']').html();


        head.val(val);
        head.siblings(".chosen-container").find("span").html(head.find('option[value=' + val + ']').html());
        var html="<option hassubinfo=\'true\' value='"  + "'>与服务器连接失败</option>";
        selectupdate(head, html);
        $.ajax({
            type: "POST",
            url: "/Rfp/links",

            headers: {
                'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
            },
            data: {name: val},
            success: function (data) {
                console.log(data)
                head.removeAttr("disabled");
                var html = "<option value='请选择' hassubinfo=\"true\">请选择</option>";
                for (var i = 0; i < data.length; i++) {
                    html += "<option hassubinfo=\'true\' value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                selectupdate(head, html);
                if (data.length === 1) {
                    head.val(data[0].id);
                    head.siblings(".chosen-container").find("span").text(data[0].name);
                }
                else if (data.length === 0){
                    head.attr("disabled","true");
                    selectupdate(head, html);
                    head.siblings(".chosen-container").find("span").text("暂无员工信息");
                }

            }
        })
    }).error(function() { alert("error"); });
    head.on("change",function(){
        var val=$(this).val(),
            //var id=$(this).
            headval=$(this).find('option[value='+val+']').html();


        //console.log(head)
//                    $.post("/Rfp/links",
//                        {head:head}


    })
    function selectupdate(obj,html){
        obj.html("");
        obj.append(html)
        $(obj).trigger("chosen:updated");
    }
    $( '#order_list' ).find( '.order-detail' ).click( function(){
        var data_content = JSON.parse( $( this ).attr( 'data-content' ) );
        var target = $( '#order_progress' );
        target.empty();
        // 对arrow在不同分辨率下的存在与否进行判断；
        var offset = $( this ).offset();
        function oresize(argument) {
            var leftW = 220;
            var rightW = 1000-leftW;
            if($(document.body).width() < rightW){
                // console.log($(document.body).width())
                $( '.arrow' ).fadeOut();
            }else{
                $( '.arrow' ).fadeIn();
                $( '.arrow' ).css( {"top":offset["top"]-100, "right": "-60px"});
            }
        }
        oresize();
        window.onresize = oresize;
        // 数据存在才执行
        if( !_.isEmpty( data_content )){
            var tmp = $( '#progress_tamplate' ).text();
            var html = '';
            var current = ( parseInt( data_content["current"] ) < 0 ) ? 0 : parseInt( data_content["current"] ),    // 目前应该处理的工作
                current_texts = [
                    "创建会议",
                    "会议审核",
                    "发送询单",
                    "服务商报价",
                    "确认场地",
                    "下单",
                    "上传水单",
                    "结算"
                ],
                done = ( current - 1 < 0 ) ? 0 : current - 1;                                               // 已经处理的工作
            var process_len = Object.keys( data_content["progress"] ).length;                                   // Object.keys( data_content["progress"] ).length 计算对象长度

            // 基本数据替换
            if( current === 0 )
            {
                html = tmp.replace( /{project_status}/, '<span class="label label-warning-light">项目进行中</span>' );
                html = html.replace( /{progress_text}/, '请先<span class="text-success">创建会议</span>' );
            }
            else if( current >= process_len )
            {
                html = tmp.replace( /{project_status}/, '<span class="label label-success">项目已经完成</span>' );
                html = html.replace( /{progress_text}/, '<span class="text-info">恭喜您，该订单已经完成</span>' );
            }
            else
            {
                html = tmp.replace( /{project_status}/, '<span class="label label-warning-light">项目进行中</span>' );
                html = html.replace( /{progress_text}/, '等待<span class="text-warning">'+current_texts[current]+'</span>' );
            }
            html = html.replace( /{project_name}/, data_content['table']['name'] );

            // 项目进度数据替换
            for( var key in data_content['progress'] )
            {
                var exact_time = '{exact_time_'+key+'}',
                    from_time = '{from_now_'+key+'}',
                    process_result = '{process_result_'+key+'}';

                html = html.replace( exact_time, '0515' );
                html = html.replace( from_time, key+' 小时' );

                if( key<current )
                {
                    html = html.replace( process_result, '处理完成' );
                }
                else
                {
                    html = html.replace( process_result, '<span class="text-warning">未处理</span>' );
                }
            }

            // 生成节点
            target.prepend( html );

            // 显示进度指向图标
            target.find( '.timeline-item' ).each( function( i )
            {
                if( i === current )
                {
                    $( this ).find( '.timeline-runway' ).show();
                }
            } );
        }
    } );


    $( ".chart" ).easyPieChart( {barColor: "#f8ac59", scaleLength: 5, lineWidth: 4, size: 80} );
    $( ".chart2" ).easyPieChart( {barColor: "#1c84c6", scaleLength: 5, lineWidth: 4, size: 80} );
    var data1 = [[0, 4], [1, 8], [2, 5], [3, 10], [4, 4], [5, 16], [6, 5], [7, 11], [8, 6], [9, 11], [10, 30], [11, 10], [12, 13], [13, 4], [14, 3], [15, 3], [16, 6]];
    var data2 = [[0, 1], [1, 0], [2, 2], [3, 0], [4, 1], [5, 3], [6, 1], [7, 5], [8, 2], [9, 3], [10, 2], [11, 1], [12, 0], [13, 2], [14, 8], [15, 0], [16, 0]];

    $( "#flot-dashboard-chart" ).length && $.plot( $( "#flot-dashboard-chart" ), [data1, data2], {
        series: {
            lines: {
                show: false,
                fill: true
            },
            splines: {show: true, tension: 0.4, lineWidth: 1, fill: 0.4},
            points: {radius: 0, show: true},
            shadowSize: 2
        },
        grid: {hoverable: true, clickable: true, tickColor: "#d5d5d5", borderWidth: 1, color: "#d5d5d5"},
        colors: ["#1ab394", "#464f88"],
        xaxis: {},
        yaxis: {ticks: 4},
        tooltip: false
    } );
    localStorage.clear();
} );


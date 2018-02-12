/**
 * Created by jzco on 2017/8/1.
 */

/**
 * des: 获取日期
 * @param day [type|int] 0.当天 -1.前一天 +1.后一天
 * @param split [type|string] 日期的分隔符
 * @returns {*}
 */
function getDate( day, split )
{
    var _split = split ? split : '-';
    var date = new Date();
    date.setDate( date.getDate() + day );//获取AddDayCount天后的日期
    var y = date.getFullYear();
    var m = date.getMonth() + 1;//获取当前月份的日期
    var d = date.getDate();

    // 分隔符的范围验证
    if( split != '/' && split != '-' )
    {
        _split = '-';
    }

    return y + _split + m + _split + d;
}

/**
 * des: 时间大小比较
 * @param master [type|string]
 * @param slave [type|string]
 * @returns {number} result -1.小于 0.等于 1.大于
 */
function dateCompare( master, slave )
{
    var result = 0;

    if( !_.isNull( master ) && !_.isNull( slave ) )
    {
        var master_stamp = Date.parse( new Date( master ) ),
            slave_stamp = Date.parse( new Date( slave ) );

        if( master_stamp - slave_stamp < 0 )
        {
            result = -1;
        }

        if( master_stamp - slave_stamp > 0 )
        {
            result = 1;
        }
    }

    return result;
}

/**
 * des: air-datepicker 专用拓展格式化方法
 * @param stamp
 */
function formatDatepicker( stamp )
{
    var date = new Date();
    date.setTime( stamp );

    return date;
}

/**
 * des: 图片尺寸格式化
 * @param imgSrc [type|string] 图片地址
 * @param measure [type|object] 图片格式化尺寸
 * @param target [type|string] 替换对象
 * @returns {string}
 */
function imgFormat( imgSrc, measure, target )
{
    var cans_dom = $( '<canvas id=""></canvas>' ),
        canvas = cans_dom[0],
        canvas_init = cans_dom[0].getContext( "2d" );

    cans_dom.attr( measure );

    var img = new Image();
    img.crossOrigin = "anonymous";                  // 解决跨域问题关键
    img.src = imgSrc;

    img.onload = function ()                        // 确保图片已经加载完毕
    {
        canvas_init.drawImage( img, 0, 0 );

        $( target ).attr( 'src', canvas.toDataURL('image/png') );
    };
}

/**
 * des: 表格生成器
 * @param: seed [type|object] 数据集
 */
function tableBuilder( seed )
{
    var done = [];

    for( var table_params in seed )
    {
        var _h_table = $( '<table></table>' );

        var _table_params = seed[table_params],
            _this_thead = theadBuilder( _table_params["thead"] ),
            _this_tbody = tbodyBuilder( _table_params["tbody"] );

        _h_table.attr( {"id":_table_params["table_id"], "class":_table_params["class"]} );

        if( typeof _table_params["attr"] !== 'undefined' )
        {
            _h_table.attr( _table_params["attr"] );
        }

        if( typeof _table_params["css"] !== 'undefined' )
        {
            _h_table.css( _table_params["css"] );
        }

        if( typeof _table_params["html"] !== 'undefined' )
        {
            _h_table.html( _table_params["html"] );
        }

        if( typeof _table_params["text"] !== 'undefined' )
        {
            _h_table.text( _table_params["text"] );
        }

        _h_table.append( _this_thead );
        _h_table.append( _this_tbody );

        // 生成表格插入
        $( _table_params["target"] ).append( _h_table );
        done.push( _table_params["table_id"] );
    }

    return done;
}

/**
 * des: 表头生成器
 * @param: thead [type|object] 数据集
 */
function theadBuilder( thead )
{
    var _h_tr = $( '<tr></tr>' ),
        _h_thead = $( '<thead></thead>' );

    for( var tr in thead )
    {
        var _tr_params = thead[tr],
            _this_th = $( '<th></th>' );

        if( typeof _tr_params["attr"] !== 'undefined' )
        {
            _this_th.attr( _tr_params["attr"] );
        }

        if( typeof _tr_params["class"] !== 'undefined' )
        {
            _this_th.addClass( _tr_params["class"] );
        }

        if( typeof _tr_params["css"] !== 'undefined' )
        {
            _this_th.css( _tr_params["css"] );
        }

        if( typeof _tr_params["html"] !== 'undefined' )
        {
            _this_th.html( _tr_params["html"] );
        }

        if( typeof _tr_params["text"] !== 'undefined' )
        {
            _this_th.text( _tr_params["text"] );
        }

        _h_tr.append( _this_th );
    }

    _h_thead.append( _h_tr );

    return _h_thead;
}

/**
 * des: 表体生成器
 * @param: tbody [type|object] 数据集
 */
function tbodyBuilder( tbody )
{
    var _h_tbody = $( '<tbody></tbody>' );

    for( var tr in tbody )
    {
        var _h_tr = $( '<tr></tr>' ),
            _tr_params = tbody[tr];

        for( var td in _tr_params )
        {
            var _td_params = _tr_params[td],
                _this_td = $( '<td></td>' );

            if( typeof _td_params["attr"] !== 'undefined' )
            {
                _this_td.attr( _td_params["attr"] );
            }

            if( typeof _td_params["class"] !== 'undefined' )
            {
                _this_td.addClass( _td_params["class"] );
            }

            if( typeof _td_params["css"] !== 'undefined' )
            {
                _this_td.css( _td_params["css"] );
            }

            if( typeof _td_params["html"] !== 'undefined' )
            {
                _this_td.html( _td_params["html"] );
            }

            if( typeof _td_params["text"] !== 'undefined' )
            {
                _this_td.text( _td_params["text"] );
                _this_td.attr( {"title":_td_params["text"]} );
            }

            _h_tr.append( _this_td );
        }
        _h_tbody.append( _h_tr );
    }

    return _h_tbody;
}

/**
 * des: 前端分页生成器
 * @param params [type|object] 数据总数量
 * @return result [type|string] 分页的 HTML 代码
 */
function genPagination( params )
{
    var pagination = $( '<div></div>' );                                                           // 临时存储分页节点空间
    var template = !_.isUndefined( params["template"] ) ? params["template"]: '<span></span>';     // 分页按钮模板

    // 非空判断
    if( !_.isEmpty( params ) && params["count"] > 0 && params["total"] > 0 )
    {
        var total = parseInt( params["total"] ),
            count = parseInt( params["count"] ),
            current = parseInt( params["current"] );

        var page_count = parseInt( total / count ) + ( parseInt( total % count ) > 0 ? 1 : 0 );         // 能分页的数量
        var show_page_num = !_.isUndefined( params["show_page_num"] ) ? params["show_page_num"] : 5;    // 显示页码的长度

        var previous = current - 1,
            next = current + 1;
        var loop_start = 0;
        var limit = current + show_page_num;

        // 页码最小范围限制
        if( current < 1 || previous < 1 )
        {
            current = 1;
            previous = 1;
        }

        // 页码最大范围限制
        if( current > page_count )
        {
            current = page_count;
            next = page_count;
        }

        // 显示页码范围限定
        if( page_count <= show_page_num )
        {
            show_page_num = page_count;
        }

        // 上一页
        pagination.append( $( template ).attr( "data-action", previous ).html( '<i class="fa fa-chevron-left"></i>' ) );

        if( current === 1 || current <= show_page_num )
        {
            show_page_num = ( show_page_num < page_count ) ? show_page_num + 1: show_page_num;

            for( var iCount = 1; iCount <= show_page_num; iCount++ )
            {
                // 当页添加选中效果
                if( iCount === current )
                {
                    pagination.append( $( template ).addClass( 'active' ).attr( "data-action", "none" ).text( current ) );
                    continue;
                }
                pagination.append( $( template ).attr( "data-action", iCount ).text( iCount ) );
            }

            // 只有一页的情况下不显示
            if( page_count !== show_page_num )
            {
                pagination.append( $( template ).attr( "data-action", "none" ).text( '...' ) );
                pagination.append( $( template ).attr( "data-action", page_count ).text( page_count ) );
            }
            else
            {
                next = show_page_num;
            }
        }
        else if( ( current >= show_page_num  && limit < page_count ) || ( limit === page_count ) )
        {
            pagination.append( $( template ).attr( "data-action", '1' ).text( '1' ) );
            pagination.append( $( template ).attr( "data-action", "none" ).text( '...' ) );

            var loop_count = current + 3;
            loop_start = current - 2;
            for( var iCount = loop_start; iCount < loop_count; iCount++ )
            {
                // 当页添加选中效果
                if( iCount === current )
                {
                    pagination.append( $( template ).addClass( 'active' ).attr( "data-action", "none" ).text( current ) );
                    continue;
                }
                pagination.append( $( template ).attr( "data-action", iCount ).text( iCount ) );
            }

            pagination.append( $( template ).attr( "data-action", "none" ).text( '...' ) );
            pagination.append( $( template ).attr( "data-action", page_count ).text( page_count ) );
        }
        else if( limit > page_count )
        {
            pagination.append( $( template ).attr( "data-action", '1' ).text( '1' ) );
            pagination.append( $( template ).attr( "data-action", "none" ).text( '...' ) );

            loop_start = page_count - show_page_num;
            for( var iCount = loop_start; iCount <= page_count; iCount++ )
            {
                // 当页添加选中效果
                if( iCount === current )
                {
                    pagination.append( $( template ).addClass( 'active' ).attr( "data-action", "none" ).text( current ) );
                    continue;
                }
                pagination.append( $( template ).attr( "data-action", iCount ).text( iCount ) );
            }
        }

        // 下一页
        pagination.append( $( template ).attr( "data-action", next ).html( '<i class="fa fa-chevron-right"></i>' ) );
    }
    else
    {
        pagination.append( $( template ).attr( "data-action", "none" ).html( '<i class="fa fa-chevron-left"></i>' ) );
        pagination.append( $( template ).addClass( 'active' ).attr( "data-action", "none" ).text( '1' ) );
        pagination.append( $( template ).attr( "data-action", "none" ).html( '<i class="fa fa-chevron-right"></i>' ) );
    }

    return pagination.children();
}
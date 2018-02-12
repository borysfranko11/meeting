/**
 * Created by jzco on 2017/8/14.
 * Author: jzco
 * Email: freejzco@sina.com
 * License: MIT
 */

( function( $ )
{
    // 默认参数
    var defaluts = {
        list: '',                                   // 只承认 jQuery 对象, $( '#id' ) 或 $( '.class' ) 等
        bind: '',                                   // 对象节点
        except: '',
        bind_class: '',
        init_color: '#676a6c',
        change_color: '#00b6b8',
        value_area: 'data-choiced',                 // 取值的位置
        after_choiced: function( id, name, obj ){}
    };

    $.fn.toChoice = function( options )
    {
        // 检测用户传进来的参数是否合法
        if( !isValid( options ) )
        {
            return this;
        }

        var opts = $.extend( {}, defaluts, options );               // 使用jQuery.extend 覆盖插件默认参数

        return this.each( function()                                // 这里的 this 就是 jQuery 对象。这里return 为了支持链式调用
        {
            var _this = $( this );                                  // 获取当前 dom 的 jQuery 对象，这里的this是当前循环的dom

            // 查找节点
            _this.find( opts["list"] ).not( opts["except"] ).not( '.arrow' ).on( 'click', function()
            {
                var _bind = $( this ).find( opts["bind"] );                         // 找到绑定事件节点
                var _value = JSON.parse( $( this ).attr( opts["value_area"] ) );    // 取值

                // 循环初始化样式
                _this.find( opts["bind"] ).each( function()
                {
                    $( this ).css( {"color": opts["init_color"]} ).removeClass( opts["bind_class"] );
                } );

                opts["after_choiced"]( _value["id"], _value["name"], $( this ) );
                //$.fn.toChoice.afterChoiced( _value );

                _bind.css( {"color": opts["change_color"]} ).addClass( opts["bind_class"] );
            } );
        } );
    };

    // 可以通过覆盖该方法达到不同的效果
    $.fn.toChoice.afterChoiced = function( value )
    {
        console.log( value );
    };

    // 私有方法，检测参数是否合法
    function isValid( options )
    {
        return !options || (options && typeof options === "object") ? true : false;
    }
} )( window.jQuery );
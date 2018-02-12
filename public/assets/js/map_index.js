/**
 *
 * @title --场地搜索页
 * @authors yaojia
 * @date 2016-3-8 19:35:08
 *
 */

define(function(require,exports) {


    var PlaceMap= require('/assets/js/showmap_new.js');



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

    setMapAreaSize()
    //加载地图
    PlaceMap.initMap()


    $(window).on('resize.map',setMapAreaSize)


})


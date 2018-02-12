var pre_files = [];
var needWaterMaker = true;
(function () {

    //是否需要添加水印功能
    if (needWaterMaker) {

        var warter_marker;
        /*利用高德地图定位和地理位置解析*/
        var getLocation = function(cb) {
            cb('start');
            var map, geolocation, lnglatXY = [],
                str = '';
            //加载地图，调用浏览器定位服务
            map = new AMap.Map('');
            map.plugin('AMap.Geolocation', function() {
                geolocation = new AMap.Geolocation({
                    enableHighAccuracy: true, //是否使用高精度定位，默认:true
                    timeout: 10e3, //超过10秒后停止定位，默认：无穷大
                    buttonOffset: new AMap.Pixel(10, 20), //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
                });
                geolocation.getCurrentPosition();
                AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
                AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息
            });
            //解析定位结果
            function onComplete(data) {
                str += '经度：' + data.position.getLng();
                str += '纬度：' + data.position.getLat();
                // str+='精度：' +  data.accuracy + ' 米';
                // str.push('是否经过偏移：' + (data.isConverted ? '是' : '否'));

                lnglatXY.push(data.position.getLng());
                lnglatXY.push(data.position.getLat());
                regeocoder(lnglatXY)

            }
            //解析定位错误信息
            function onError(data) {
                cb('err');
            }

            function regeocoder() { //逆地理编码
                var geocoder = new AMap.Geocoder({
                    radius: 1000,
                    extensions: "all"
                });

                geocoder.getAddress(lnglatXY, function(status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        geocoder_CallBack(result);
                    }
                });

            }

            function geocoder_CallBack(data) {
                var address = data.regeocode.formattedAddress; //返回地址描述
                cb(null, address, str);
            }

        };

        getLocation(function(err, address, location) {

            if (err === 'err') {
                alert('获取地理位置失败,请返回重试，否则不能上传水单');
                return
            }
            if (err === null) {
                warter_marker = address + getNowFormatDate();
                $('#gps_txt').html('定位成功：<strong>' + address + ' </strong>(此信息会直接合成到水单上,如果误差太大，请打开手机GPS重试)')

                createUploader(warter_marker)
            }

        })

    } else {

        $('#gps_txt').remove();
        createUploader();

    }

    //自动计算。。
    $('.count').on('keyup paste change', function () {
        $('#totalNum').val(total_number().toFixed(2));
    });

    function total_number() {
        var number = 0;
        $('.count').each(function (k, v) {

            var val = $(v).val();
            if (val == '' || isNaN(val) || val == null || typeof val == 'undefined') {
                val = '0'
            }

            val = val.replace(/[^\d\.]/g, "").replace(/^\./g, "").replace(/\.\d*\./g, ".").replace(/(\.\d{2,2})\d*/g, "$1").replace(/^[0]{1}/g, '');
            $(v).val(val);
            number += +val;

        });

        return number;
    }

    function createUploader(warter_marker) {

        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // 文件接收服务端。
            server: '/Memo/uploadFile',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#uploadbtn',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,GIF,jpg,JPG,jpeg,JPEG,bmp,BMP,png,PPNG',
                mimeTypes: 'image/*'
            },
            compress: {
                width: 1,
                height: 1,
                // 图片质量，只有type为`image/jpeg`的时候才有效。
                quality: 95,

                // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
                allowMagnify: false,

                // 是否允许裁剪。
                crop: false,

                // 是否保留头部meta信息。
                preserveHeaders: true,

                // 如果发现压缩后文件大小比原来还大，则使用原来图片
                // 此属性可能会影响图片自动纠正功能
                noCompressIfLarger: false,

                // 单位字节，如果图片大小小于此值，不会采用压缩。
                compressSize: 0,
                warterTxt: warter_marker

            }
        });

        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '</div>'
                ),
                $img = $li.find('img');


            // $list为容器jQuery实例
            $('#fileList').append($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src).width(90).height(90);
            }, 90, 90);

            $percent = $li.find('.progress span');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<p class="progress"><span style="width:5%"></span></p>')
                    .appendTo($li)
                    .find('span');
            }


        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                $percent = $li.find('.progress span');
            $percent.css('width', percentage * 100 + '%');
        });

        //var pre_files = [];
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, res) {
           /* console.log(1);
            console.log(file);
            console.log(2);
            console.log(res);
            console.log(3);*/
            var $li = $('#' + file.id),
                $success = $li.find('div.success');

            // 避免重复创建
            if (!$success.length) {
                $success = $('<div class="success"></div>').appendTo($li, res);
            }

            $success.html('上传成功 <a href="#" class="delete show-toast"><i class="icon iconfont ">&#xe654;</i></a>');

             console.log(file);
            pre_files[file.id] = res.data;

             //alert(res.path);

            var remote_img_path = res.data;
            var myimg_url = (remote_img_path.indexOf("http")!=-1) ? remote_img_path : '/' + remote_img_path;
            $li.find('img').attr('src2', myimg_url);


            // console.log(pre_files);
            //$('<input  name="file[]" type="hidden" value="' + res.data.url + '">').appendTo($li);

        });

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            var $li = $('#' + file.id),
                $error = $li.find('div.error');

            // 避免重复创建
            if (!$error.length) {
                $error = $('<div class="error"></div>').appendTo($li);
            }

            $error.html('上传失败 <a href="#" class="delete show-toast"><i class="icon iconfont ">&#xe654;</i></a>');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress').remove();
        });

    }

    $('#fileList').on('click.del', '.delete', function () {

        var id = $(this).parents('.file-item').attr('id');
        $(this).parents('.file-item').remove();

        uploader.removeFile(id);
        delete pre_files[id];
    });


    function checkStart() {
        var ischeck = false;

        $('.rating').each(function (k, v) {
            if ($(v).val() != 0) {
                ischeck = true;
            }
        });
        return ischeck;
    }

    function checkPicture() {
        var str_url = '';
        for (var each in pre_files) {
            str_url += pre_files[each] + ',';
        }
        if (str_url == '') {
            return false;
        }
        $('#submit_files').val(str_url);

        return true;
    }


    function checkcomment() {
        return $('#content_evaluate').val().length > 10;
    }


    function checkMoney() {
        return parseInt($('#totalNum').val()) > parseInt($('#prev').text());
    }

    function checktotalNum() {
        return $('#totalNum').val() > 0
    }

    function checkinPeople() {
        var g = /^[1-9]*[1-9][0-9]*$/;
        return $('#checkinPeople').val() == '' || $('#checkinPeople').val() == null || !g.test($('#checkinPeople').val());
    }


    var wait = 5;

    function time() {
        if (wait == 0) {
            $.closeModal(modal_two);

            window.location.href = "/memo_defray_detail.html";
        } else {
            $(".swiper-pagination").find('span').html(wait);
            wait--;
            setTimeout(function () {
                    time()
                },
                1000);
        }
    }


    function submitform() {
        myajaxSubmit();
    }

    //获取格式化的时间
    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();

        var strHour = date.getHours();
        var strMin = date.getMinutes();
        var stSec = date.getSeconds();


        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }

        if (strHour >= 0 && strHour <= 9) {
            strHour = "0" + strHour;
        }

        if (strMin >= 0 && strMin <= 9) {
            strMin = "0" + strMin;
        }

        if (strDate >= 0 && stSec <= 9) {
            stSec = "0" + stSec;
        }
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + strHour + seperator2 + strMin
            + seperator2 + stSec;
        return currentdate;
    }


    var modal_two = '';

    $(document).on('click', '.open-confirm', function () {

        if (checkinPeople()) {
            return $.alert('请输入签到人数');
        }


        if (!checktotalNum()) {
            return $.alert('请输入实际支出金额');
        }


        if (!checkPicture()) {
            return $.alert('请上传水单照片');
        }


        if (!checkStart()) {
            return $.alert('请对酒店服务进行评分');
        }

        // if (!checkcomment()) {
        //     return $.alert('请输入评价描述，不少于10个字哦');
        // }


        if (checkMoney()) {

            var modal = $.modal({
                title: '<div class="swiper-slide"><i class="icon iconfont orange_color" style="font-size:1rem;">&#xe65d;</i></div>',
                text: '请仔细检查实际支出及水单，是否确认提交？',
                buttons: [{
                    text: '是(Y)',
                    bold: true,
                    onClick: function () {
                        submitform();
                    }
                }, {
                    text: '否(N)'
                }]
            });

        } else {

            var modal = $.modal({
                title: '<div class="swiper-slide"><i class="icon iconfont orange_color" style="font-size:1rem;">&#xe65d;</i></div>',
                text: '请仔细检查实际支出及水单，是否确认提交？',
                buttons: [{
                    text: '是(Y)',
                    bold: true,
                    onClick: function () {
                        submitform();
                    }
                }, {
                    text: '否(N)'
                }]
            });

        }

    });

    $(".star-default").rating({
        size: 'xt',
        starCaptions: {
            1: '很差',
            2: '不满',
            3: '一般',
            4: '满意',
            5: '很赞'
        },
        clearCaption: '',
        showClear: false
    });

    function show_loading(msg) {
        $.showPreloader(msg);
    }

    function myajaxSubmit() {
        $.ajax({
            method: 'post',
            url: '/Memo/save_memo',
            dataType: 'JSON',
            timeout: 20000,
            beforeSend: function () {
                // 显示loading
                show_loading('请求中...');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#submit_form').serialize(),
            success: function (data) {
                // 后续处理
                var obj = JSON.parse(data);
                if (obj.Success == true) {
                    $.alert('操作成功', function () {
                        window.location.href = '/wap/index';
                    });
                }else{
                    $.alert(obj.Msg);
                }
            },
            complete: function () {
                $.hidePreloader();// 隐藏loading
            },
            error: function () {
                $.alert("请求出错了,请稍候再试");
            }
        });
    }

})();
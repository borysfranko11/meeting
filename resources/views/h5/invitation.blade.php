<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>EPSON —— 邀请函</title>
    <link rel="stylesheet" href="/assets/css/weui.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/common_in.css" type="text/css">
</head>

<body ontouchstart>
    <img width="100%" src="/assets/img/invitation.jpg" alt="">
    <div class="weui-panel__bd">
        <div class="weui-media-box weui-media-box_small-appmsg">
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access weui-media-box" href="http://9udgdq9v.eventdove.com/">
                    <div class="weui-cell__hd"><img src="/assets/img/icon_attendee.png" alt=""></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <h3 class="weui-media-box__title">我是参会者</h3>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
                <a class="weui-cell weui-cell_access weui-media-box" href="<?php echo $uri;?>&role_id=1">
                    <div class="weui-cell__hd"><img src="/assets/img/icon_media.png" alt=""></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <h3 class="weui-media-box__title">我是媒体</h3>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
                <a class="weui-cell weui-cell_access weui-media-box" href="<?php echo $uri;?>&role_id=2">
                    <div class="weui-cell__hd"><img src="/assets/img/icon_dealer.png" alt=""></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <h3 class="weui-media-box__title">我是经销商</h3>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
                <a class="weui-cell weui-cell_access weui-media-box" href="<?php echo $uri;?>&role_id=3">
                    <div class="weui-cell__hd"><img src="/assets/img/icon_staff.png" alt=""></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <h3 class="weui-media-box__title">我是员工</h3>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
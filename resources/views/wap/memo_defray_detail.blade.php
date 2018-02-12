<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>水单及支出确认</title>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="/assets/css/wap/sm.css">
    <link rel="stylesheet" href="/assets/css/wap/extend/sm-extend.css">
    <link rel="stylesheet" href="/assets/css/wap/iconfont.css">
    <link rel="stylesheet" href="/assets/css/wap/style_min.css">
    <link rel="stylesheet" href="/assets/css/wap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/wap/star-rating.min.css">
    <link rel="stylesheet" href="/assets/css/wap/zsh.css">
	<link rel="stylesheet" href="/assets/js/web_uploader/webuploader.css">
	<link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    <style type="text/css" media="screen">
    .photo-browser .bar {
        background-color: #fff;
    }
    
    .photo-browser .bar .title {
        color: #666 !important;
    }
    </style>

	<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=d34e69ad1fd7b0f02c64aa78444e6f5f&plugin=AMap.Geocoder"></script>

</head>
<body>
	<div class="page-group">
		<div class="page page-current">
			<header class="bar bar-nav clearfix">
				<button onclick="history.go(-1)" class="button button-link button-nav pull-left">
					<i class="icon iconfont">&#xe621;</i>
				</button>
				<h1 class="title">水单及支出确认</h1>
			</header>
			<form id='submit_form' action="/index.php/rfp/update_memo_info" method="post">
				<input id='submit_files' type="text" name="files" style="display: none">
				<input type="text" name="rfp_id" style="display: none" value="<?php echo $rfp_info['rfp_id']; ?>">
				<input type="text" name="isMobile" style="display: none" value="1">

				<div class="content">
				<div class="content-padded">
					<div class="meeting_item border-b clearfix">
						<div class="p_img">
							<img src="<?= isset($img_info['img_url'])?$img_info['img_url']:'/assets/img/statebg_01.png' ?>" alt="">
						</div>
                        <div class="pull-left clearfix">
                          <div class="meeting_name">
                            <?php echo $rfp_info['meeting_name'];?>
                          </div>
                          <div class="meeting_place"><?php echo $rfp_info['provincecode'].$rfp_info['citydesc'];?></div>
                          <div class="meeting_time"><?php echo date('Y-m-d',$rfp_info['start_time']);?></div>
                        </div>
                    </div>
	                <div class="grid-demo space-15 clearfix">
	                <div class="row">
	                    <div class="col-33 ">计划参会人数:</div>
	                    <div class="col-66 text-left red_color"><?php echo $rfp_info['people_num'];?>人</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">会议审批预算:</div>
	                    <div class="col-66 text-left red_color"><?php echo $rfp_info['budget_total_amount'];?>元</div>
	                </div>
	                <div class="row m-t-sm">
	                    <div class="col-33">实际签到人数:</div>
						<div class="col-66 text-left">
							<?php echo $equipments['signed_number'];?>人
						</div>
	                </div>
	                <div class="row m-b-sm">
	                    <div class="col-33">实际支出总额:</div>
						<div class="col-66 text-left">
							<?php echo  number_format(floatval($equipments['meeting_room_fees']+$equipments['food_fees']+$equipments['room_fees']+$equipments['equipment_fees']+$equipments['wine_drinks']+$equipments['other_fees']),2);?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">会议室费用:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['meeting_room_fees'];?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">餐饮费用:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['food_fees'];?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">住宿费用:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['room_fees'];?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">会务服务费:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['equipment_fees'];?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">易捷采购酒水费:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['wine_drinks'];?>元
						</div>
	                </div>
	                <div class="row">
	                    <div class="col-33 ">其他费用:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['other_fees'];?>元
						</div>
	                </div>
                    <div class="row">
                        <div class="col-33 ">会唐代采酒水费:</div>
						<div class="col-66 text-left ">
							<?php echo $equipments['jd_fees'];?>元
						</div>

                    </div>
	           </div>
	           <div class="grid-demo border-tb clearfix">
	           	<h4 class="space-10">上传水单</h4>
				   <ul class="upload_memo_list m-none" style="float: left">
				   <?php foreach($files as $k => $v){?>
	           		<li><img src="<?= $v['pic_url'] ?>" alt="" class="memo_img"></li>
	           		<?php } ?>
				   </ul>
			   </div>
   	               <div class="grid-demo border-b clearfix">
		               	<h4 class="space-10">请您评分</h4>
		               	<div class="row">
		                    <div class="col-33 ">场地满意度：</div>
							<div class="col-66 text-left">
								<input value="<?php echo $equipments['place_star'];?>" name="place_star" type="number" class="rating star-default" min=0 max=5 step=1 readonly="readonly">
							</div>
						</div>
		                <div class="row">
		                    <div class="col-33 ">餐饮满意度：</div>
							<div class="col-66 text-left">
								<input value="<?php echo $equipments['food_star'];?>" name="food_star" type="number"
									   class="rating star-default" min=0 max=5 step=1 readonly="readonly">
							</div>
						</div>
		                <div class="row">
		                    <div class="col-33 ">住宿满意度：</div>
							<div class="col-66 text-left">
								<input value="<?php echo $equipments['room_star'];?>" name="room_star" type="number" class="rating star-default" min=0 max=5 step=1 readonly="readonly"></div>
						</div>
		                <div class="row">
		                    <div class="col-33 ">服务满意度：</div>
							<div class="col-66 text-left">
								<input value="<?php echo $equipments['serve_star'];?>"  name="serve_star" type="number"
									   class="rating star-default" min=0 max=5 step=1 readonly="readonly">
							</div>
						</div>
	               </div>
	               <div class="grid-demo clearfix">
		               	<h4 class="space-10">评价描述</h4>
		               	<div class="row">
		                    <div class="col-100">
								<?php if($equipments['appraise_serve'] != '0'){echo $equipments['appraise_serve'];}?>
							</div>
						</div>
		                </div>
	               </div>
			</div>
			</form>
		</div>
	</div>

	<script type='text/javascript' src='/assets/js/wap/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='/assets/js/wap/sm.js' charset='utf-8'></script>
    <script type='text/javascript' src='/assets/js/wap/extend/sm_extend.js' charset='utf-8'></script>
    
	<!-- 评分 -->
	<script src="/assets/js/wap/star-rating.min.js"></script>

	<script type='text/javascript' src='/assets/js/wap/deferred.js' charset='utf-8'></script>
	<script type='text/javascript' src='/assets/js/wap/callbacks.js' charset='utf-8'></script>
	<script type='text/javascript' src='/assets/js/wap/data.js' charset='utf-8'></script>
	<script src="/assets/js/wap/star-rating.min.js"></script>
	<script src="/assets/js/web_uploader/webuploader.html5only.js"></script>
	<script src="/assets/js/wap/page/confirm_memos.js"></script>


</body>
</html>
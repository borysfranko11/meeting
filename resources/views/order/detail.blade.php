<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <!-- <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet"> -->
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/myorder/sured.css" rel="stylesheet">
    <link href="/assets/css/myorder/orderDetail.css" rel="stylesheet">



    <style type="text/css">
          .el-col-offset-1{margin-left:0!important;}
          /* dd:nth-of-type(4).clearfix>p:nth-of-type(3){width: auto!important;}
          dd:nth-of-type(5).clearfix>p:nth-of-type(3){width: auto!important;}  */
          .dptable>tbody>tr>td,.dptable>tbody>tr>th{
              vertical-align:middle;
              text-align: center;
          }
        .el-form-item__content{
            margin-left: 90px;
        }
    </style>
     <link href="/assets/css/rfp/change_inquiryShots.css" rel="stylesheet">
</head>
<body class="bg-grow">
    <input type="hidden" name="_token" value="{{csrf_token()}}"/ id="toke">
        <input type="hidden" value="{{$data}}" id="rfp">
    <div class="cont" id="section1">
        <header>
            <p>
                <!-- <span class="otitle">会议执行确认</span> -->
                <span>订单中心</span>
                <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                <span class="meeting-sure">订单详情</span>
            </p>
            <!-- <article class="cont1">
                <el-form :label-position="labelPosition" label-width="80px" :model="oform1">
                    
                </el-form>
            </article> -->
        </header>
        <main>
            <h1><span></span>订单详情</h1>
            <section class="cont1">
                <article>
                    <el-form :label-position="labelPosition" label-width="80px">
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="会议编码">
                                <span v-text="oform.ocode"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="会议名称">
                                <span v-text="oform.name"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="会议时间">
                                <span v-text="oform.meetingStartTime"></span>
                                <span> 至 </span>
                                <span v-text="oform.meetingEndTime"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="会议预算">
                                <span v-text="oform.budget"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="会议人数">
                                <span v-text="oform.pepo"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="行程时间">
                                <span v-text="oform.tripStartTime"></span>
                                <span> 至 </span>
                                <span v-text="oform.tripEndTime"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                        <!-- <template v-for="(item, index) in oform.type">
                            <el-row :key="item.id">
                                <el-col :span="11">
                                  <el-form-item :label="item.otext1">
                                    <span v-text="item.num"></span>
                                  </el-form-item>
                                </el-col>
                                <el-col :span="11" :offset="2">
                                  <el-form-item :label="item.otext2">
                                    <span v-text="item.oinput"></span>
                                  </el-form-item>
                                </el-col>
                            </el-row>
                        </template> -->
                        <el-row>
                            <el-col :span="11">
                                {{--<el-form-item label="会议状态">
                                    <span class="basic-color" v-text="oform.ostate"></span>
                                </el-form-item>--}}
                                <!-- <span class="pl16">实际支出金额：</span>
                                <span class="basic-color">￥</span>
                                <span class="basic-color" v-text="total"></span> -->
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="酒店名称">
                                <span v-text="oform.hotelName"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="酒店地址">
                                <span v-text="oform.hotelPla"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </article>
            </section>
        </main>
        <div class=' blank '></div>
        <main>
            <h1><span></span>支付记录</h1>
            <section class="cont1">
                <article>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>支付时间</th>
                                <th>支付金额</th>
                                <th>累计支付</th>
                                <th>备注</th>
                                <th>提交人</th>
                                <th>支付状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($flow)){foreach ( $flow as $key => $value) {?>
                                <tr>
                                    <td><?php echo date('Y-m-d H:i:s', $value['create_time']);?></td>
                                    <td><?php echo $value['money']?></td>
                                    <td><?php echo $value['money']?></td>
                                    <td><?php echo $value['message']?></td>
                                    <td><?php echo $value['payer_account_name']?></td>
                                    <td>
                                        <?php
                                            if($value['status'] == 1){
                                                echo '支付成功';
                                            }elseif($value['status'] == 2){
                                                echo '<sanp style="color:red;">支付失败</span>';
                                            }else{
                                                echo '支付中';
                                            }

                                        ?>
                                    </td>
                                    <td><a href="/Order/getPayInstrument?flow_id=<?php echo $value['flow_id']?>">下载支付凭证</a></td>
                                </tr>
                            <?php }}?>
                        </tbody>
                    </table>
                    <a href="javascript:;" class="el-tabs__item is-active" data-toggle="modal" data-target="#myModal1">添加支付</a>
                    <div class="modal inmodal" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
                        <form action="/Wallet/pay" id="" target="_blank" method="post">
                            <div class="modal-dialog">
                            <div class="modal-content animated flipInY">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title">支付</h4>

                                </div>
                                <div class="modal-body">

                                        <div class="form-group">
                                            <label>支付金额</label>
                                            <input type="text" name="money" id="money" placeholder="请输入支付金额" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>订单号</label>
                                            <input type="text" name="order_no" value="<?php echo $rfp['order_no']?>" id="order_no" disabled class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>收款人</label>
                                            <input type="text" name="" value="<?php echo $hotel['place_name'];?>" disabled class="form-control">
                                            <input type="hidden" name="recieve_id" id="recieve_id" value="<?php echo $rfp['place_id'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label>商品名</label>
                                            <input type="text" value="<?php echo $hotel['place_name'];?>" disabled class="form-control" name="product_name" id="product_name">
                                        </div>
                                        <div class="form-group">
                                            <label>描述</label>
                                            <input type="text" value="<?php echo $hotel['place_name'].'-'.$rfp['meeting_name'].' 支付会议款项';?>"  class="form-control" name="product_desc" id="product_desc">
                                        </div>
                                        <div class="form-group">
                                            <label>交易密码</label>
                                            <input type="password" value="" id="password"  class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>支付方式</label>
                                            钱包<input type="radio" checked="" value="1" id="qianbao" name="type">
                                            {{--网关<input type="radio" value="2" id="wangguan" name="type">--}}
                                        </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                                    <button type="button" id="pay" class="btn btn-primary">提交</button>
                                </div>

                            </div>

                        </div>
                        </form>
                    </div>
                </article>
            </section>
        </main>
        <div class=' blank '></div>
        <main>
            <!-- <h1><span></span>场地评分</h1> -->
            <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="场地订单" name="first">
                    <section class="place-rate">
                        <el-form label-position="top" label-width="100px" class="order-des">
                            <el-row>
                            <el-col :span="11">
                              <el-form-item label="订单号">
                                <span v-text="pla.orderNum"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="订单状态">
                                <span v-text="pla.orderStatus"></span>
                              </el-form-item>
                            </el-col>
                            </el-row>
                        </el-form>
                    <el-row class="cont-nums">
                      <el-col :span="12">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 12px 20px;" class="bgcol-gray">
                              <p>
                                <span>场地</span>
                              </p>
                            </div>
                            <div style="padding: 20px;" class="obdtitle">
                              <p>
                                <span v-text="pla.hotel" class="ft18"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>使用时间 ：</span>
                                <span v-text="pla.userStartTime"></span>
                                <span> 至 </span>
                                <span v-text="pla.userEndTime"></span>
                              </p>
                              <p>
                                <span>备注信息 ：</span>
                                <span v-text="pla.infor"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>合计 ：</span>
                                <span class="basic-color" v-text="pla.total"></span>
                              </p>
                            </div>
                        </el-card>
                      </el-col>
                      <!-- <el-col :span="7" :offset="1" v-for="(itme, index) in pla.food">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 12px 20px;" class="bgcol-gray">
                              <p>
                                <span>餐饮</span>
                              </p>
                            </div>
                            <div style="padding: 20px;" class="obdtitle">
                              <p>
                                <span v-text="pla.dinner" class="ft18"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>用餐信息 ：</span>
                                <span v-text="pla.dinType"></span>
                                <span v-text="pla.pepoNum"></span>
                                <span v-text="pla.costYuan"></span>
                              </p>
                              <p>
                                <span>备注信息 ：</span>
                                <span v-text="pla.inforDin"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>合计 ：</span>
                                <span class="basic-color" v-text="pla.totalDin"></span>
                              </p>
                            </div>
                        </el-card>
                      </el-col> -->
                       <el-col :span="12" v-for="(item, index) in pla.food" :key="item.food_id" :offset="0" :class="">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 12px 20px;" class="bgcol-gray">
                              <p>
                                <span>餐饮</span>
                              </p>
                            </div>
                            <div style="padding: 20px;" class="obdtitle">
                              <p>
                                <span v-text="item.rice_type_name" class="ft18"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>用餐信息 ：</span>
                                <span v-text="item.dining_type_name"></span>
                                <span v-text="item.people"></span>
                                <span>人</span>
                                <span v-text="item.unit_price"></span>
                                <span>/人/顿</span>
                              </p>
                              <p>
                                <span>备注信息 ：</span>
                                <span v-text="item.food_description"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>合计 ：</span>
                                <span class="basic-color" v-text="item.budget_account"></span>
                              </p>
                            </div>
                        </el-card>
                      </el-col>
                      <!-- <el-col :span="7" :offset="1" v-for="(item, index) in pla.food" :key="item.room_id" :class="martop">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 12px 20px;" class="bgcol-gray">
                              <p>
                                <span>住宿</span>
                              </p>
                            </div>
                            <div style="padding: 20px;" class="obdtitle">
                              <p>
                                <span v-text="pla.stayType" class="ft18"></span>
                                <span v-text="pla.roomNum" class="ft18"></span>
                                <span v-text="pla.nightNum" class="ft18"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>入住时间 ：</span>
                                <span v-text="pla.stayStaTime"></span>
                                <span> 至 </span>
                                <span v-text="pla.stayEndTime"></span>
                              </p>
                              <p>
                                <span>备注信息 ：</span>
                                <span v-text="pla.inforStay"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>合计 ：</span>
                                <span class="basic-color" v-text="pla.totalStay"></span>
                              </p>
                            </div>
                        </el-card>
                      </el-col> -->
                      <el-col :span="12" v-for="(item, index) in pla.room" :key="item.room_id" :offset="1" :class="">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 12px 20px;" class="bgcol-gray">
                              <p>
                                <span>住宿</span>
                              </p>
                            </div>
                            <div style="padding: 20px;" class="obdtitle">
                              <p>
                                <span v-text="item.type_name" class="ft18"></span>

                                <span v-text="item.room_count" class="ft18"></span>
                                <span> 间 </span>
                                <span v-text="item.day" class="ft18"></span>
                                <span> 晚 </span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>入住时间 ：</span>
                                <span v-text="item.room_in_start_date"></span>
                                <span> 至 </span>
                                <span v-text="item.room_out_end_date"></span>
                              </p>
                              <p>
                                <span>备注信息 ：</span>
                                <span v-text="item.room_description"></span>
                              </p>
                            </div>
                            <div style="padding: 20px;">
                              <p>
                                <span>合计 ：</span>
                                <span class="basic-color" v-text="item.budget_account"></span>
                              </p>
                            </div>
                        </el-card>
                      </el-col>
                    </el-row>
                    <el-row class="mt30">
                        <el-col :span="23">
                            <el-card :body-style="{ padding: '0px' }">
                                <div style="padding: 12px 20px;" class="bgcol-gray">
                                  <p>
                                    <span>场地确认及报价</span>
                                  </p>
                                </div>
                                <div style="padding: 20px;" class="obdtitle">
                                    <p>
                                        <span>确认场地 ：</span>
                                        <span v-text="pla.surePla"></span>
                                    </p>
                                </div>
                                <div style="padding: 20px;">
                                  
                                  <p>
                                    <span>订单号 ：</span>
                                    <span v-text="pla.sureNum"></span>
                                  </p>
                                </div>
                                <div style="padding: 20px;">
                                  <p>
                                    <span>场地报价 ：</span>
                                    <span class="basic-color" v-text="pla.sureTotal"></span>
                                  </p>
                                </div>
                            </el-card>
                        </el-col>
                    </el-row>
                    <el-row class="mt30">
                        <el-col :span="23">
                            <el-card :body-style="{ padding: '0px' }">
                                <div style="padding: 12px 20px;" class="bgcol-gray">
                                  <p>
                                    <span>会议执行信息</span>
                                  </p>
                                </div>
                                <div style="padding: 20px;">
                                  <p>
                                    <span>现场签到人数 ：</span>
                                    <span v-text="meetingInfo.pepoNum"></span>
                                    <!-- <span class="ml20p">场地报价 ：</span>
                                    <span class="basic-color" v-text="meetingInfo.siteOffer"></span> -->
                                  </p>
                                </div>
                                <div style="padding: 20px;" class="fact-cost">
                                    <el-form label-position="top" label-width="80px">
                                        <el-row>
                                            <el-col>
                                              <el-form-item label="实际支出明细：">
                                                <div class="cont-table">
                                                    <dl>
                                                        <dt class="clearfix">
                                                            <p>费用</p>
                                                            <p>费用说明</p>
                                                        </dt>
                                                        <dd class="clearfix" v-for="(item, index) in meetingInfo.type" :key="item.id">
                                                          <span><p v-text="item.otext1"></p>
                                                            <p class="basic-color" v-text="item.num"></p></span>
                                                          <span><p v-text="item.otext2"></p>
                                                            <p class="basic-color" v-text="item.oinput"></p></span>
                                                            
                                                        </dd>
                                                        <dd class="clearfix">
                                                            <p>实际支出金额：</p>
                                                            <p class="basic-color" v-text="meetingInfo.factCost"></p>
                                                        </dd>
                                                    </dl>
                                                </div>
                                              </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-form>
                                </div>
                                <div style="padding: 20px;">
                                  <el-form label-position="top" label-width="80px">
                                        <el-row>
                                            <el-col>
                                              <el-form-item label="水单及发票：">
                                                <ul class="el-upload-list el-upload-list--picture-card">
                                                    <li class="el-upload-list__item is-success" v-for="(item, index) in meetingInfo.imgUrl" :key="item.id">
                                                        <img :src="item.pic_url" class="el-upload-list__item-thumbnail"><a class="el-upload-list__item-name"></a>
                                                        <i class="el-icon-plus"></i>
                                                        <span class="el-upload-list__item-actions"><span class="el-upload-list__item-preview"><i class="el-icon-view" @click="shwoBigImg(index, item.pic_url)"></i></span>
                                                    </li>
                                                    <el-dialog v-model="dialogVisible" size="large">
                                                      <img width="100%" :src="dialogImageUrl" alt>
                                                    </el-dialog>
                                                </ul>
                                              </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-form>
                                </div>
                                <div style="padding: 20px;" class="evalu-des">
                                    <el-form label-position="left" label-width="100px">
                                        <el-form-item label="评价描述">
                                        </el-form-item>
                                        <el-form-item label="场地评星">
                                            <el-rate v-model="value1" disabled></el-rate>
                                        </el-form-item>
                                        <el-form-item label="餐饮评星">
                                            <el-rate v-model="value2" disabled></el-rate>
                                        </el-form-item>
                                        <el-form-item label="住宿评星">
                                            <el-rate v-model="value3" disabled></el-rate>
                                        </el-form-item>
                                        <el-form-item label="服务评星">
                                            <el-rate v-model="value4" disabled></el-rate>
                                        </el-form-item>
                                        <el-form-item label="评价服务" class="omerge">
                                        </el-form-item>
                                         <el-form-item label-width="0">
                                            <span v-text="desc" class="pl16"></span>
                                        </el-form-item>
                                        <!-- <el-row>
                                            <el-col :offset="20" :span="2" align="right">
                                                <el-button type="primary" size="large" class="sure">确定</el-button>
                                            </el-col>
                                            <el-col :span="2" align="right">
                                                <el-button class="sure-hov" size="large">取消</el-button>
                                            </el-col>
                                        </el-row>   -->
                                    </el-form>
                                </div>
                            </el-card>
                        </el-col>
                    </el-row>
                    </section>
                </el-tab-pane>
                <el-tab-pane label="京东酒水订单" name="second">
                    <el-table :data="tableData" style="width: 100%">
                      <el-table-column align="center" prop="userCode" label="用户编码" min-width="120">
                      </el-table-column>
                      <el-table-column align="center" prop="orderNum" label="订单编号" min-width="120">
                      </el-table-column>
                      <el-table-column align="center" prop="metCode" label="会议编码">
                      </el-table-column>
                      <el-table-column align="center" prop="metName" label="会议名称" min-width="120">
                      </el-table-column>
                      <el-table-column align="center" prop="orderTime" label="下单时间" min-width="120">
                      </el-table-column>
                      <el-table-column align="center" prop="wineAmount" label="酒水金额" min-width="120">
                      </el-table-column>
                      <el-table-column align="center" prop="orderSatus" label="订单状态" min-width="100">
                      </el-table-column>
                    </el-table>
                </el-tab-pane>
            <el-tab-pane label="点评用餐订单" name="third">
                <el-card :body-style="{ padding: '0px' }">
                    <table class="table table-bordered dptable" style="margin-bottom: 0px;">
                        <tr>
                            <th>订单号</th>
                            <th>商铺</th>
                            <th>地址</th>
                            <th>预定人数</th>
                            <th>包间类型</th>
                            <th>用餐时间</th>
                            <th>消费金额</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        <?php if(!empty($dporder)){foreach ($dporder as $dpo){?>
                            <tr>
                                <td><?php echo $dpo['orderId'];?></td>
                                <td><?php echo $dpo['shopName'];?></td>
                                <td><?php echo $dpo['shopAddress'];?></td>
                                <td><?php echo $dpo['number'];?></td>
                                <td><?php echo $dpo['position'];?></td>
                                <td><?php echo $dpo['bookingTime'];?></td>
                                <td><?php echo $dpo['pay_price'];?></td>
                                <td><?php if(!empty($dpo['orderPay'])){echo '已支付';}else{echo $dpo['status_name'];}?></td>
                                <td>
                                    <?php if(($dpo['status'] == '50' || $dpo['status'] == '40') && empty($dpo['orderPay'])){?>
                                    <a class="btn btn-primary dim btn-sm-dim btn-outline" target="_blank" data-toggle="modal" data-whatever="<?php echo $dpo['orderId'];?>" data-target="#useFood">去支付</a><?php }?>
                                </td>
                            </tr>
                       <?php }}?>
                        </table>
                </el-card>
            </el-tab-pane>
                <el-tab-pane label="消费对比" name="fourth">
                    <el-card :body-style="{ padding: '0px' }">
                        <div class="fact-cost cost-compare">
                            <div class="cont-table">
                                <dl>
                                    <dt class="clearfix" style="display: flex;justify-content: space-around;">

                                        <span></span>
                                        <p>预算</p>
                                       {{-- <p>实际费用</p>
                                        <p>费用说明</p>--}}
                                        <p>订单费用</p>

                                        <p>实际费用</p>
                                        <p>费用说明</p>
                                        <p>供应商</p>
                                    </dt>
                                    <dd class="clearfix" v-for="(item, index) in costCompare.type" :key="item.id" style="display: flex;justify-content: space-around;">
                                        <span v-text="item.otext1"></span>
                                        <p class="basic-color" v-text="item.numb"></p>
                                        <!-- <p v-text="item.otext1"></p> -->
                                       {{-- <p class="basic-color" v-text="item.num"></p>--}}
                                        <!-- <p v-text="item.otext2"></p> -->
                                        {{--<p class="basic-color" v-text="item.oinput"></p>--}}
                                        <!-- <p v-text="item.otext1"></p> -->
                                        <p class="basic-color" v-text="item.num2"></p>
                                        <p class="basic-color" v-text="item.num"></p>
                                        <!-- <p v-text="item.otext2"></p> -->
                                        <p class="basic-color" v-text="item.oinput"></p>
                                        <p v-text="item.supplier"></p>
                                    </dd>
                                    <dd class="clearfix" style="display: flex;justify-content: space-around;background: rgb(244, 248, 249);">
                                        <span>总计：</span>
                                        <p class="basic-color" v-text="costCompare.factTotal3"></p>
                                        <p class="basic-color" v-text="costCompare.factTotal2"></p>
                                        {{--<p class="basic-color">&nbsp;</p>--}}
                                        <p class="basic-color" v-text="costCompare.factTotal1"></p>
                                        <p class="basic-color" v-text=""></p>
                                        <p v-text=""></p>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </el-card>
                    <a href="/Order/ordermemo?rfp_id={{$data}}" class="btn btn-info" style="background-color: #fff;color:#000;">查看支持材料</a>
                </el-tab-pane>
            </el-tabs>
        </main>
    </div>
        <div class="modal inmodal" id="useFood" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:300px">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header" style="padding:10px 15px;">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                        </button>
                        <h2 class="modal-title">用餐</h2>
                    </div>
                    <div class="modal-body">
                        {{--<iframe src="/dinner/orderPay" width="100%" height="500" name="main"></iframe>--}}
                        <div id="foodPut">
                            <small class="font-bold" style="color: red;" id="msgdp"></small>
                            <input type="text" id="useFoodPrice" value="" />
                            <input type="hidden" id="order_id" value="" />
                            <button type="button" class="btn btn-primary" id="setPrice">确定</button>
                        </div>
                        <div id="getPay" style="display: none">
                            <small class="font-bold">扫描二维码完成支付</small>
                            <img src="" width="100%" name="main" id="foodbody" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/assets/plugins/vue.min.js"></script>
    <script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>
    <script src="/assets/js/myorder/orderDetail.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
    <script>
        $("#pay").click(function(){

            var money           = $('#money').val();
            var order_no        = $('#order_no').val();
            var recieve_id      = $('#recieve_id').val();
            var product_name    = $('#product_name').val();
            var product_desc    = $('#product_desc').val();
            var password        = $('#password').val();
            var TOKEN           = '{{csrf_token()}}';
            if(!password){
                parent.layer.msg('请输入交易密码!');
                return false;
            }
            if(!money){
                parent.layer.msg('请输入金额!');
                return false;
            }else{
                var fix_amountTest=/^(([1-9]\d*)|\d)(\.\d{1,2})?$/;
                if(fix_amountTest.test(money)==false){
                    parent.layer.msg('请输入金额!');
                    return false;
                }
            }
            if(!product_desc){
                parent.layer.msg('请输入付款描述!');
                return false;
            }
            $.ajax({
                type : "POST",  //提交方式
                url : "/Wallet/pay",
                data : {
                    "money" : money,
                    "order_no" : order_no,
                    "recieve_id" : recieve_id,
                    "product_name" : product_name,
                    "product_desc" : product_desc,
                    "password" : password,
                    "_token" : TOKEN,
                },//数据，这里使用的是Json格式进行传输
                success : function(result) {//返回数据根据结果进行相应的处理

                    result= $.parseJSON(result);
                    if(result.errorno){
                        parent.layer.msg('获取地址失败:'+result.msg);
                        return false;
                    }else{
                        parent.layer.msg('支付成功!');
                        $("#myModal1").hide();
                        self.location.reload();
                    }



                }
            });
            $("#open_account_city").val($('#two option:selected') .text());
        });
        //绑定模态框展示的方法
        $('#useFood').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('whatever');
            var price = $('#useFoodPrice').val();
            $('#foodPut').show();
            $('#getPay').hide();
            $('#msgdp').html('确定金额之后将无法修改，请慎重填写');
            $('#order_id').val(recipient);
            $.ajax({
                type : "GET",  //提交方式
                url : "/dinner/orderPay?order_id="+recipient+"&price="+price,
                success : function(result) {//返回数据根据结果进行相应的处理
                    result= $.parseJSON(result);
                    if(result.rs == 1){
                        $('#foodPut').hide();
                        $('#foodbody').attr("src",result.data);
                        $('#getPay').show();
                    }
                }
            });
        });
        $("#setPrice").click(function(){
            var price = $('#useFoodPrice').val();
            var recipient = $('#order_id').val();
            if(price == ''){
                $('#msgdp').html('请填写完整支付信息');
                return false
            }
            $.ajax({
                type : "GET",  //提交方式
                url : "/dinner/orderPay?order_id="+recipient+"&price="+price,
                success : function(result) {//返回数据根据结果进行相应的处理
                    result= $.parseJSON(result);
                    if(result.rs == 1){
                        $('#foodPut').hide();
                        $('#foodbody').attr("src",result.data);
                        $('#getPay').show();
                    }else{
                        $('#msgdp').html(result.msg);
                        return false;
                    }
                }
            });

        });
    </script>
</body>
</html>
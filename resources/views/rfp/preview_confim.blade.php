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
    <link href="//at.alicdn.com/t/font_364022_hfnji7v8779wl8fr.css" rel="stylesheet">
    <link href="/assets/css/myorder/sured.css" rel="stylesheet">
    <link href="/assets/css/rfp/inquiryShots.css" rel="stylesheet">
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
</head>
<body class="bg-grow">
    <input type="hidden" value="{{$data}}" id="rfp">
    <div class="cont" id="section1">
        <header>
            <p>
                <!-- <span class="otitle" v-text="otitle">会议执行确认</span> -->
                <span>我的会议</span>
                <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                <span class="meeting-sure">询单快照</span>
            </p>
                <h1><span></span>基本需求</h1>
            <article class="cont1">
                <el-form :label-position="labelPosition" label-width="80px" :model="basicNeeds">
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议编码">
                            <span v-text="basicNeeds.code"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="会议名称">
                            <span v-text="basicNeeds.name"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议类型">
                            <span v-text="basicNeeds.typeMeeting"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="参会人数">
                            <span v-text="basicNeeds.num" :min="0"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议时间">
                            <span v-text="basicNeeds.meetStartTime"></span>
                            <span> 至 </span>
                            <span v-text="basicNeeds.meetEndTime"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="行程时间">
                            <span v-text="basicNeeds.tripStartTime"></span>
                            <span> 至 </span>
                            <span v-text="basicNeeds.tripEndTime"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议地点">
                            <span v-text="basicNeeds.meetPlaPro"></span> 
                             <span v-text="basicNeeds.meetPlaCity"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="服务预算">
                            <div v-for="(item, index) in basicNeeds.serviceBudget" :key="index" class="change-block">
                                <span v-text="item.fundtypedese"></span>
                                <span v-text="item.budgetamount"></span>
                            </div>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议日程">
                              <a :href="basicNeeds.meetDairy" target="_blank" class="meet-dairy">点此预览文件</a>
                          </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </article>
        </header>
        <main>
            <h1><span></span>区域需求</h1>
            <section class="cont1">
                <article>
                    <el-form :label-position="labelPosition" label-width="80px">
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
                              <el-form-item label="类型">
                                <span v-text="regionNeeds.type"></span>
                              </el-form-item>
                            </el-col>
                            <el-col :span="11" :offset="2">
                              <el-form-item label="位置">
                                <span v-text="regionNeeds.oposition" :min="0"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="11">
                                <el-form-item label="星级">
                                    <span class="basic-color" v-text="regionNeeds.start"></span>
                                </el-form-item>
                                <!-- <span class="pl16">实际支出金额：</span>
                                <span class="basic-color">￥</span>
                                <span class="basic-color" v-text="total"></span> -->
                            </el-col>
                        </el-row>
                        <!-- <el-row>
                            <el-col>
                                <el-form-item label="备注">
                                    <span v-text="oform.desc"></span>
                                </el-form-item>
                            </el-col>
                        </el-row> -->
                        <el-row class="cont-card">
                            <el-form-item label="场地">
                                <el-col :span="5" v-for="(item, index) in regionNeeds.site" :key="index" :offset="index > 0 ? 1 : 0">
                                <el-card :body-style="{ padding: '20px' }">
                                    <div class="cont-img">
                                      <img :src="item.main_pic_url" class="image">
                                    </div>
                                    <div class="img-cont">
                                        <p>
                                            <span v-text="item.place_name"></span>
                                        </p>
                                        <p>
                                            <span class="iconfont icon-jiudian"></span>
                                            <span v-text="item.place_type"></span>
                                        </p>
                                        <p>
                                            <span class="iconfont icon-weizhixinxi"></span>
                                            <span v-text="item.address"></span>
                                        </p>
                                    </div>
                                </el-card>
                              </el-col>
                            </el-form-item>
                        </el-row>
                        <!-- <el-row>
                            <el-col>
                                <el-form-item label="场地">
                                    <ul class="el-upload-list el-upload-list--picture-card">
                                        <li class="el-upload-list__item is-success" v-for="(item, index) in oform.imgUrl" :key="item.id">
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
                        </el-row> -->
                    </el-form>
                </article>
            </section>
            <h1><span></span>会议室需求</h1>
            <article class="cont1 meeting-needs" v-for="(item, index) in oequipment" :key="index">
                <el-form :label-position="labelPosition" label-width="80px">
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议时间">
                            <span v-text="item.start_date"></span>
                            <span> 至 </span>
                            <span v-text="item.end_date"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="其它时间描述">
                            <span v-text="item.date_note"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="桌型摆设">
                            <span v-text="item.table_decoration_name"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="可容纳人数">
                            <span v-text="item.meeting_people"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row class="cont-num">
                        <el-form-item label="常用设施">
                            <el-col :span="5" v-for="(item, index) in item.equipment" :key="index" :offset="index > 0 ? 1 : 0">
                                <div>
                                    <span class="mb10" v-text="item.name"></span>
                                     <el-input-number v-model="item.num" disabled></el-input-number>
                                </div>
                            </el-col>
                        </el-form-item>
                    </el-row>
                    <el-row class="cont-num">
                        <el-form-item label="其它设施">
                            <el-col :span="5" v-for="(item, index) in item.commonFacility" :key="index" :offset="index > 0 ? 1 : 0">
                                <div>
                                    <span class="mb10" v-text="item.name"></span>
                                     <el-input-number v-model="item.num" disabled></el-input-number>
                                </div>
                            </el-col>
                        </el-form-item>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="描述">
                            <span v-text="item.equipment_description"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </article>
            <h1><span></span>餐饮需求</h1>
            <section class="cont1">
                <article class="food-needs">
                    <el-table :data="dinnerNeeds.foodNeeds" border stripe style="width: 100%">
                        <el-table-column label="餐饮" align="center">
                            <el-table-column prop="rice_type_name" label="餐种" min-width="80"  align="center">
                            </el-table-column>
                            <el-table-column prop="dining_type_name" label="形式" min-width="80"  align="center">
                            </el-table-column>
                            <el-table-column prop="people" label="用餐人数" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="unit_price" label="人均单价" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="food_time" label="时间" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="budget_account" label="用餐预算" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="food_description" label="描述" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="food_menu_name" label="是否提供参考菜单" align="center" :filters="[{text: '提供菜单(以实际与酒店沟通情况为准)', value: '提供菜单(以实际与酒店沟通情况为准)'},{text: '不提供菜单', value: '不提供菜单'}]" :filter-method="filterSupply" filter-placement="bottom" min-width="120">
                                <template scope="scope">
                                    <el-tag :type="scope.row.food_menu_name === '提供菜单(以实际与酒店沟通情况为准)'? 'primary' : 'success'" v-text="scope.row.food_menu_name"></el-tag>
                                </template>
                            </el-table-column>
                        </el-table-column>
                    </el-table>

                </article>
                <article class="food-needs">
                    <el-table :data="dinnerNeeds.wineNeeds" border stripe style="width: 100%">
                        <el-table-column label="酒水" align="center">
                            <el-table-column prop="rice_type_name" label="餐种" min-width="80"  align="center">
                            </el-table-column>
                            <el-table-column prop="food_time" label="用餐时间" min-width="160"  align="center">
                            </el-table-column>
                            <el-table-column prop="rice_type_name" label="酒水种类" align="center" min-width="120">
                            </el-table-column>
                            <el-table-column prop="people" label="数量" align="center" min-width="80">
                            </el-table-column>
                            <el-table-column prop="food_description" label="描述" align="center" min-width="120" >
                            </el-table-column>
                        </el-table-column>
                    </el-table>
                </article>
                <!-- <article>
                    <el-form :label-position="labelPosition" label-width="80px">
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="描述">
                                <span v-text="dinnerNeeds.desc"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </article> -->
            </section>
            <h1><span></span>住宿需求</h1>
            <section class="cont1">
                <article class="food-needs">
                    <el-table :data="hotelNeeds.hotelData" border stripe style="width: 100%">
                        <el-table-column label="住宿" align="center">
                            <el-table-column prop="room_in_start_date" label="入住时间" width="180"  align="center">
                            </el-table-column>
                            <el-table-column prop="room_out_end_date" label="退房时间" width="180"  align="center">
                            </el-table-column>
                            <el-table-column prop="day" label="天数" align="center" width="120">
                            </el-table-column>
                            <el-table-column prop="type_name" label="房间类型" align="center">
                            </el-table-column>
                            <el-table-column prop="room_count" label="数量" align="center">
                            </el-table-column>
                            <el-table-column prop="room_description" label="描述" align="center">
                            </el-table-column>
                            <el-table-column prop="breakfast_name" label="是否提供早餐" align="center" :filters="[{text: '提供早餐', value: '提供早餐'},{text: '不提供早餐', value: '不提供早餐'}]" :filter-method="filterSupply2" filter-placement="bottom">
                                <template scope="scope">
                                    <el-tag :type="scope.row.breakfast_name === '提供早餐'? 'primary' : 'success'" v-text="scope.row.breakfast_name"></el-tag>
                                </template>
                            </el-table-column>
                        </el-table-column>
                    </el-table>

                </article>
            </section>
            <h1><span></span>其它需求</h1>
            <section class="cont1">
                <article>
                    <el-form :label-position="labelPosition" label-width="80px">
                        <el-row>
                            <el-col :span="11">
                              <el-form-item label="描述">
                                <span v-text="otherNeeds.desc"></span>
                              </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </article>
            </section>
            <!-- <h1><span></span>场地评分</h1>
            <section class="place-rate">
                <article>
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
                        <el-form-item label="确认状态" class="omerge">
                            <el-button type="primary" class="nosure sure-hov sure">已确认</el-button>
                        </el-form-item>
                    </el-form>
                </article>
            </section> -->
        </main>

    </div>
    <div class="is-center">
        <button type="button" id="submit" class="btn btn btn-primary">发布询单</button>
        <button type="button" id="edit" class="btn btn btn-primary">编辑询单</button>
    </div>
    <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/assets/plugins/vue.min.js"></script>
    <script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>
    <script src="/assets/js/rfp/inquiryShots.js"></script>
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
        $( document ).ready( function() {
            //点击驳回按钮
            submit.onclick = function () {
                $.ajax({
                    type: "get",
                    url: '/rfp/send_rfp?rfp_id='+id,

                    dataType: "text",
                    timeout: 5000,

                    success: function (Response) {


                        swal({
                                    title: "恭喜",
                                    text: "您已经成功发送询单！",
                                    type: "success",
                                    confirmButtonText: "确定"
                                },
                                function () {
                                    location.href = "/Rfp/index";
                                });

                        console.log(Response);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        loader.fadeOut();
                        _form.attr('data-status', '');

                        var error_code = XMLHttpRequest['status'],
                                error_msg = {
                                    "500": "未知错误, 请联系管理人员！",
                                    "504": "服务器未响应, 请稍后重试！"
                                };

                        swal({
                            title: "抱歉",
                            text: error_msg[error_code],
                            type: "error",
                            confirmButtonText: "确定"
                        });
                    }
                });
            }
            edit.onclick = function () {
                window.location.href="/Rfp/edit?rfp_id="+id;
            }
        });
    </script>
</body>
</html>
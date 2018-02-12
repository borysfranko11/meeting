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
</head>
<body class="bg-grow">
    <input type="hidden" name="_token" value="{{csrf_token()}}"/ id="toke">
    <input type="hidden" value="{{$data}}" id="rfp">
    <div class="cont" id="section1">
        <header>
            <p>
                <span class="otitle">会议执行确认</span>
                <span>我的会议</span>
                <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                <span class="meeting-sure">会议执行确认</span>
            </p>
            <article class="cont1">
                <el-form :label-position="labelPosition" label-width="80px" :model="oform1">
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议名称">
                            <span v-text="oform1.name"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="会议预算">
                            <span v-text="oform1.budget"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="签到人数">
                            <span v-text="oform1.num" :min="0"></span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="上会人">
                            <span v-text="oform1.value8" :min="0"></span>
                          </el-form-item>
                        </el-col>
                    </el-row>
                      <!-- <el-form-item label="实际参会人员">
                        <el-input v-model="oform.activeUrl"></el-input>
                      </el-form-item> -->
                </el-form>
            </article>
        </header>
        <main>
            <h1><span></span>实际支出明细</h1>
            <section class="cont1">
                <article>
                    <el-form :label-position="labelPosition" label-width="80px">
                        <template v-for="(item, index) in oform.type">
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
                        </template>
                        <el-row>
                            <el-col :span="11">
                                <el-form-item label="实际支出金额">
                                    <span class="basic-color" v-text="total"></span>
                                </el-form-item>
                                <!-- <span class="pl16">实际支出金额：</span>
                                <span class="basic-color">￥</span>
                                <span class="basic-color" v-text="total"></span> -->
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col>
                                <el-form-item label="备注">
                                    <span v-text="oform.desc"></span>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col>
                                <el-form-item label="支持材料">
                                <!-- v-for循环中index和item的值不可颠倒切记； -->
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
                        </el-row>
                    </el-form>
                </article>
            </section>
            <h1><span></span>场地评分</h1>
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
                        <!-- <el-row>
                            <el-col :offset="20" :span="2" align="right">
                                <el-button type="primary" size="large" class="sure">确定</el-button>
                            </el-col>
                            <el-col :span="2" align="right">
                                <el-button class="sure-hov" size="large">取消</el-button>
                            </el-col>
                        </el-row>   -->
                    </el-form>
                </article>
            </section>
        </main>
    </div>
    <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/assets/plugins/vue.min.js"></script>
    <script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>
    <script src="/assets/js/myorder/sured.js"></script>
</body>
</html>
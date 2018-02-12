<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <!-- <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet"> -->
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/myorder/myorder.css" rel="stylesheet">
</head>
<body class="bg-grow">
    <input type="hidden" name="_token" value="{{csrf_token()}}"/ id="toke">
    <input type="hidden" value="{{$data}}" id="rfp">
    <div class="cont">
        <header>
            <p>
                <span class="otitle">会议执行确认</span>
                <span>我的会议</span>
                <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                <span class="meeting-sure">会议执行确认</span>
            </p>
            <article id="article1">
                <el-form :label-position="labelPosition" label-width="80px" :model="oform" :rules="rules">
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="会议名称">
                            <el-input v-model="oform.name" readonly :disabled="true"></el-input>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="会议预算">
                            <el-input v-model="oform.budget" readonly :disabled="true"></el-input>
                          </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                          <el-form-item label="签到人数" prop="num">
                            <el-input-number v-model="oform.num" :min="1" @change="handleChange1"></el-input-number>
                          </el-form-item>
                        </el-col>
                        <el-col :span="11" :offset="2">
                          <el-form-item label="上会人">
                            <el-select v-model="oform.value8" filterable placeholder="请选择" style="width:100%;" @change="handleChange2">
                                <el-option v-for="item in options" :key="item.id" :label="item.value" :value="item.id">
                                </el-option>
                            </el-select>
                          </el-form-item>
                        </el-col>
                    </el-row>
                      <!-- <el-form-item label="实际参会人员">
                        <el-input v-model="oform.activeUrl"></el-input>
                      </el-form-item> -->
                </el-form>
            </article>
        </header>
        <main id="section1">
            <h1><span></span>实际支出明细</h1>
            <section>
                <article>
                    <el-form :label-position="labelPosition" label-width="80px" :rules="rules">
                        <template v-for="(item, index) in oform.type">
                            <el-row :key="item.id">
                                <el-col :span="11">
                                  <el-form-item :label="item.otext1">
                                    <el-input-number v-model="item.num" :min="0"></el-input-number>
                                  </el-form-item>
                                </el-col>
                                <el-col :span="11" :offset="2">
                                  <el-form-item :label="item.otext2">
                                    <el-input v-model.lazy="item.oinput"></el-input>
                                  </el-form-item>
                                </el-col>
                            </el-row>
                        </template>
                        <el-row>
                            <el-col :span="11">
                                <span>实际支出金额：</span>
                                <span class="basic-color">￥</span>
                                <span class="basic-color">@{{total}}</span>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col>
                                <p class="bd1"></p>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col>
                                <el-form-item label="备注">
                                    <el-input type="textarea" v-model="oform.desc" placeholder="如果需要请填写备注" :autosize="{ minRows: 2, maxRows: 5}">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col>
                                <el-form-item label="支持材料" prop="imageUrl">
                                    <el-upload action="/Memo/uploadFile" :value="oform.imageUrl" :headers="headers" :data="form" :on-change="handleChange" list-type="picture-card" :on-preview="handlePictureCardPreview" :before-upload="beforeUpload" :on-success="onSuccess">
                                      <i class="el-icon-plus"></i>
                                    </el-upload>
                                    <el-dialog v-model="dialogVisible" size="large">
                                      <img width="100%" :src="oform.imageUrl" alt>
                                    </el-dialog>
                                        <!-- <el-upload class="el-upload el-upload--picture" action="/Memo/uploadFile" :value="oform.imageUrl" :headers="headers" :on-change="handleChange" :before-upload="beforeUpload" :file-list="fileList3" :data="form" :on-success="onSuccess">
                                            <i class="el-icon-plus avatar-uploader-icon"></i>
                                            <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过10MB</div>
                                        </el-upload> -->
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </article>
            </section>
            <h1><span></span>场地评分</h1>
            <section class="place-rate">
                <article>
                    <el-form label-position="left" label-width="80px">
                        <el-form-item label="评价描述">
                        </el-form-item>
                        <el-form-item label="场地评星">
                            <el-rate v-model="value1" show-text></el-rate>
                        </el-form-item>
                        <el-form-item label="餐饮评星">
                            <el-rate v-model="value2" show-text></el-rate>
                        </el-form-item>
                        <el-form-item label="住宿评星">
                            <el-rate v-model="value3" show-text></el-rate>
                        </el-form-item>
                        <el-form-item label="服务评星">
                            <el-rate v-model="value4" show-text></el-rate>
                        </el-form-item>
                        <el-form-item label="评价服务" class="omerge">
                        </el-form-item>
                         <el-form-item label-width="0">
                            <el-input type="textarea" v-model="desc" placeholder="场地很好，非常不错" :autosize="{ minRows: 4, maxRows: 6}">
                            </el-input>
                        </el-form-item>
                        <el-row>
                            <el-col>
                                <p class="bd1 mt0"></p>
                            </el-col>
                        </el-row>
                        <el-form-item label="确认状态" class="omerge">
                            <el-button class="nosure sure-hov">未确认</el-button>
                        </el-form-item>
                        <el-row>
                            <el-col :offset="20" :span="2" align="right">
                                <el-button type="primary" size="large" class="sure" @click="subForm">确定</el-button>
                            </el-col>
                            <el-col :span="2" align="right">
                                <el-button class="sure-hov" size="large">取消</el-button>
                            </el-col>
                        </el-row>  
                    </el-form>
                </article>
            </section>
        </main>
    </div>
    <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/assets/plugins/vue.min.js"></script>
    <script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>
    <script src="/assets/js/myorder/myorder.js"></script>
</body>
</html>
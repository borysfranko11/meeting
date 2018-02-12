var toke = $("#toke").val();

function add0(m){return m<10?'0'+m:m }
function format(shijianchuo){
    //shijianchuo是整数，否则要parseInt转换
    var time = new Date(shijianchuo);
    // console.log(time)
    var y = time.getFullYear();
    var m = time.getMonth()+1;
    var d = time.getDate();
    var h = time.getHours();
    var mm = time.getMinutes();
    var s = time.getSeconds();
    // return y+'-'+add0(m)+'-'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    return y+'-'+add0(m)+'-'+add0(d);
}
function getCascaderObj(val,opt) {
    return val.map(function (value, index, array) {
        for (var itm of opt) {
            if (itm.value == value) { opt = itm.children; return itm; }
        }
        return null;
    });
}
function layFun(message) {
    layer.msg(message);
}
setTimeout(function () {
//对我要托管里的图片上传进行实例化；
var Main = {
    data() {
      return {
        form: {
            name: 'file',
            type: '3'
        },
        headers: {
            'X-CSRF-TOKEN': toke
        },
        imageUrl: ''
      };
    },
    methods: {
      handleAvatarSuccess(res, file) {
        this.imageUrl = res.data;
      },
      beforeAvatarUpload(file) {
        var isJPG = file.type === 'image/jpeg';
        // element-ui 比较坑的设置文件类型的方法；
        var isPNG = file.type === 'image/png';
        var isLt2M = file.size / 1024 / 1024 < 2;
        if (!isJPG && !isPNG) {
          this.$message.error('上传头像图片只能是 jpg,png格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return (isJPG || isPNG) && isLt2M;
      }
    }
  }

var Ctor = Vue.extend(Main)
var upload = new Ctor().$mount('#upload');
// 会议日程的上传实例化；
var Main2 = {
    data() {
      return {
        form:{
            name:'file',
            type: '1'
        },
        imageUrl:'',
        headers: {
           // 'Content-Type':'application/x-www-form-urlencoded',
           // 该请求头的设置是为了后端的laravel框架（该框架为了防止csrf攻击，需进行token验证）生成一个令牌，
            'X-CSRF-TOKEN': toke
        },
        fileList3: []
      };
    },
    methods: {
      // 图片上传之前执行的回调
        beforeUpload (file){
            // console.log(file)
        },
        // 在图片改变时执行的回调
        handleChange(file, fileList) {
            this.fileList3 = fileList.slice(-1);
        },
        //  图片上传成功时的回调
        onSuccess (response, file, fileList){
            file.url = response.data;
            this.imageUrl = response.data;
            this.$message.success("恭喜您，文件上传成功！");
            // console.log(file.url)
        }
    }
  }
var Ctor = Vue.extend(Main2)
var meetingDairy = new Ctor().$mount('#app2')
// 会议时间
var Main3 = {
    data() {
      return {
        pickerOptions0: {
          disabledDate(time) {
            if (meetingTime3.items[0].value2 !="") {                             
               return time.getTime()>meetingTime3.items[0].value2.getTime() || time.getTime() < Date.now() - 8.64e7
            }else{
                return time.getTime() < Date.now() - 8.64e7;  
            }
           
          }
        },
        pickerOptions1: {
        disabledDate(time) {
            if ( meetingTime3.items[0].value1!="") {
                return time.getTime() < meetingTime3.items[0].value1.getTime();  
            }else{
                return time.getTime() < Date.now() - 8.64e7; 
                }                 
          }/*,
          shortcuts: [{
            text: '今天',
            onClick(picker) {
              picker.$emit('pick', new Date());
            }
          }, {
            text: '昨天',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24);
              picker.$emit('pick', date);
            }
          }, {
            text: '一周前',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', date);
            }
          }]*/
        },
        items: [
            {
                value1: '',
                value2: '',
                value3: '',
                value4: ''
            }
        ]
      }
    },

    methods: {
        addTime (){
            this.items.push({
                value1: '',
                value2: '',
                value3: '',
                value4: ''
            });
        },
        removeTime (index){
            this.items.splice(index, 1);
        },
        oformatDate1(index, value1){
            if(!value1) return;
            var seconds = value1.getTime();
            this.items[index].value3 = format(seconds);
        },
        oformatDate2(index, value2){
            if(!value2) return;
            var seconds = value2.getTime();
            this.items[index].value4 = format(seconds);
        }
    }
  };
var Ctor3 = Vue.extend(Main3)
var meetingTime3 = new Ctor3().$mount('#app3');
// 会议行程；
var Main4 = {
    data() {
      return {
        pickerOptions0: {
          disabledDate(time) {
            if (meetingItinerary.value2!="") {               
                return time.getTime()>meetingItinerary.value2.getTime() || time.getTime() < Date.now() - 8.64e7
            }else{
                 return time.getTime() < Date.now() - 8.64e7;
            }          
          }
        },
        pickerOptions1: {
          disabledDate(time) {
            if (meetingItinerary.value1!="") {
                return time.getTime() < meetingItinerary.value1.getTime(); 
            }else{
                return time.getTime() < Date.now() - 8.64e7;
            }                  
          }/*,
          shortcuts: [{
            text: '今天',
            onClick(picker) {
              picker.$emit('pick', new Date());
            }
          }, {
            text: '昨天',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24);
              picker.$emit('pick', date);
            }
          }, {
            text: '一周前',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', date);
            }
          }]*/
        },
        value1: '',
        value2: '',
        value3: '',
        value4: '',
      };
    },
    computed: {
        getSeconds1 (){
            if(!this.value1) return; 
            var value1Time = this.value1.getTime()/1000;
            return value1Time;
        },
        getSeconds2 (){
            if(!this.value2) return;
            var value1Time = this.value2.getTime()/1000;
            return value1Time;
        }
    },
    methods: {
        oformatDate1(value1){
            if(!value1) return;
            var seconds = value1.getTime();
            this.value3 = format(seconds);
        },
        oformatDate2(value2){
            if(!value2) return;
            var seconds = value2.getTime();
            this.value4 = format(seconds);
        }
    }
};
var Ctor4 = Vue.extend(Main4);
var meetingItinerary = new Ctor4().$mount('#app4');
// 会议地点
var Main5 = {
    data() {
        return {
            valuePro: '',
            proText:'',
            options: '',
            valueCity: '',
            cityText:'',
            options2: ''
        };
    },
    created (){
        var that = this;
        // 获取城市列表；
        $.ajax({
            url:'/Rfp/getProvinces',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                // console.log(res)
                if(res.Success == true && res.Data != 0){
                    that.options = res.Data; 
                }else{
                    that.$message.error("暂时没有数据哦")
                }
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        // handleItemChange() {
        //     this.selectOptions=getCascaderObj(this.selectOption, this.options);
        // },
        // 依据城市列表获取城市；
        proChange (valuePro){
            // console.log(val);
            this.valueCity = '';
            var odata = {
                cityId : valuePro
            };
            var that = this;
            $.ajax({
                url:'/Rfp/getAreaCity',
                type:'GET',
                dataType: 'JSON',
                data: odata,
                success: function (res) {
                    if(res.Success == true && res.Data != 0){
                        that.options2 = res.Data; 
                    }else{
                        that.$message.error("暂时没有数据哦")
                    }
                },
                error: function (res) {
                    that.$message({
                        showClose: true,
                        message: '服务器繁忙请稍后再试',
                        type: 'error'
                    });
                }
            })
            if(!this.options) return;
            // var obj = {};
            // obj = this.options.find(function (item) {
            //     return item.id === valuePro;
            // })
            this.proText = this.options[valuePro]["name"];
            // console.log(obj.name)
        },
        cityChange (valueCity){
            if(!this.options2 || !valueCity) return;
            // console.log(valueCity)
            // obj = this.options2.find(function (item) {
            //     return item.id === valueCity;
            // })
            this.cityText = this.options2[valueCity]["name"];
        }
    }
  };
var Ctor5 = Vue.extend(Main5);
var meetingPlace = new Ctor5().$mount('#meetingPlace');
// 参会人员上传实例化；
var uplo2 = {
    data() {
      return {
          form:{
              name:'file',
              type: '2'
          },
          arr: '',
          headers: {
              // 'Content-Type':'application/x-www-form-urlencoded',
              // 该请求头的设置是为了后端的laravel框架（该框架为了防止csrf攻击，需进行token验证）生成一个令牌，
              'X-CSRF-TOKEN': toke
          },
        fileList2: []
      };
    },
    methods: {
        beforeAvatarUpload(file) {
            var isLt2M = file.size / 1024 / 1024 < 2;
            var name = file.name.split(".");
            var format = ".xls,.xlsx";
            if (format.indexOf(name[name.length-1]) < 0) {
              this.$message.error('上传文件只能是 xls,xlsx格式!');
              return false;
            }
            if (!isLt2M) {
              this.$message.error('上传文件大小不能超过 2MB!');
              return false;
            }
            return format.indexOf(name[name.length-1]) && isLt2M;
        },
        handleChange(file, fileList) {
            this.fileList2= fileList.slice(-1);
           
        },
        onSuccess(response, file, fileList){
            if(response.status == 1){
                this.$message.success('文件已上传成功！');
                file.name = response.name;
                this.arr = response.data;
                // console.log(this.fileList2);
            }
        }
    }
  }
var Uplo2 = Vue.extend(uplo2);
var pepople = new Uplo2().$mount('#pepople');
//会议类型；
var Main6 = {
    data() {
      return {
        options: '',
        value8: '',
        valueText: ''
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Meeting/getMeetingType',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                that.options = res;
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        changeValue (value8){
            // console.log(value8);
            var obj = {};
            // obj = this.options.find((item)=>{
            //     return item.id === value8;
            // });
            obj = this.options.find(function (item) {
                return item.id === value8;
            });
            this.valueText = obj.value;
        }
    }
};
var Ctor6 = Vue.extend(Main6);
var meetingType = new Ctor6().$mount('#meetingType');

//竞标类型；
var Main14 = {
    data() {
      return {
        options: '',
        value14: '',
        valueText: ''
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Meeting/getMeetingBitTypes',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                that.options = res;
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试-bittype',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        changeValue (value14){
            var obj = {};
            obj = this.options.find(function (item) {
                return item.id === value14;
            });
            this.valueText = obj.value;
        }
    }
};
var Ctor14 = Vue.extend(Main14);
var meetingBitType = new Ctor14().$mount('#meetingBitType');

// 会议预算；
var Main7 = {
    data() {
      return {
        items: '',
        state: '',
        ototal: ''
      }
    },
    created () {
        var that = this;
        $.ajax({
            url:'/Meeting/getRfpBudget',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                // console.log(res);
                that.items = res;
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    computed: {
        total: function(){
            var total = 0;
            if(!this.items) return; //因为items是由后台获取的，因此需要做一个不为空判断，否则vue会在初始化时执行，导致报错；
            this.items.filter(function(item) {
                return item.checked;
            }).forEach(function(item) {
                if(typeof item.num != 'number'){
                    item.num = 0;
                }
                total += item.num;
            });
            // for (var i = 0;i < this.items.length;i++) {
            //         if(typeof this.items[i].num != 'number'){
            //             this.items[i].num = 0;
            //         }
            //         total += parseInt(this.items[i].num);
            //         // console.log(this.items[i].checked)
            // };
            this.ototal = total;
            return total;
        }
    }    
};
var Ctor7 = Vue.extend(Main7);
var meetingBudget = new Ctor7().$mount('#meetingBudget');
// 会议申请，申请部门；
var Main8 = {
    data() {
      return {
        options: '',
        value8: '',
        valueText: ''
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Meeting/getDepartment',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                // console.log(res)
                that.options = res;
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        changeValue (value8){
            // console.log(value8);
            var obj = {};
            // obj = this.options.find((item)=>{
            //     return item.id === value8;
            // });
            obj = this.options.find(function (item) {
                return item.id === value8;
            });
            this.valueText = obj.value;
        }
    }
};
var Ctor8 = Vue.extend(Main8);
var aplSector = new Ctor8().$mount('#aplSector');
// 会议申请，成本中心；
var Main9 = {
    data() {
      return {
        options: '',
        value8: '',
        valueText: '',
        checked: false
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Meeting/getMarketorg',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                // console.log(res)
                that.options = res;
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        changeValue (value8){
            // console.log(value8);
            var obj = {};
            // obj = this.options.find((item)=>{
            //     return item.id === value8;
            // });
            obj = this.options.find(function (item) {
                return item.id === value8;
            });
            this.valueText = obj.value;
        }
    }
};
var Ctor9 = Vue.extend(Main9);
var costCenter = new Ctor9().$mount('#costCenter');
// 会议托管下的 会议人员实例化；
var Main10 = {
    data() {
      return {
        options: [],
        value8: '',
        otext: ''
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Meeting/getDepositPerson',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                that.options = res;
                // console.log(res);
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    },
    methods: {
        changeText (val){
            if(!val || !this.options) return;
            var that =this;
            var obj = {};
            obj = that.options.find(function (item) {
                return item.id == that.value8;
            });
            this.otext = obj.value;
            console.log(obj)
        }
    }
};
var Ctor10 = Vue.extend(Main10);
var meetingHost = new Ctor10().$mount('#meetingHost');
// 会议预算；
var Main11 = {
    data() {
      return {
        num1: '',
        num2: '',
        num3: ''
      }
    },
    methods: {

    }
    
};
var Ctor11 = Vue.extend(Main11);
var activePepole1 = new Ctor11().$mount('#oactive');
var dot           = new Ctor11().$mount('#dot');
// 会议名称
var oMain = {
    data() {
        return {
          oval: '',
          rulers: {
            oval: [
                { required: true, type: 'number', message: '请输入活动名称', trigger: 'change' }
            ]
          }
        }
    }
}
var oCtor = Vue.extend(oMain)
var omeetingName2 = new oCtor().$mount('#meetingName2')

//会议托管提交的逻辑；
$("#hosting").on('click', function () {
    var meetingName = $("#meetingName").val();
    var meetingPeople = meetingHost.value8;
    var keeper = meetingHost.otext;
    var managedVoucher = upload.imageUrl;
    if(!meetingName){
        layFun("会议名称不能为空");
        return false;
    }
    if(!meetingPeople){
        layFun("托管人不能为空");
        return false;
    }
    if(!managedVoucher){
        layFun("托管凭证不能为空");
        return false;
    }
    var data = {
        meeting_name: meetingName,
        deposit_code: meetingPeople,
        deposit_name: keeper,
        deposit_proof: managedVoucher
    };
    $.ajax({
        url:'/Meeting/createDeposit',
        type:'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': toke
        },
        data: data,
        success: function (res) {
            if(res.status == '1'){
                layFun("托管成功");
                window.location.href = "/Rfp/index";
                // var sideBar = parent.window.document.getElementById("side-menu");
                // $(sideBar).find('li').eq(2).find('a').attr('href', '/Rfp/index');
                // parent.jumpPage(2);
            }else{
                layFun("托管失败，请稍后再试");
            }
        },
        error: function (res) {
            layFun("托管失败，请稍后再试");
        }
    });
});
// 会议内容的提交逻辑
var next1 = $('.actions>ul>li').eq(1);
var prev = $('.actions>ul>li').eq(0);
// 修改step插件的显示内容；
 var sub = $('.actions>ul>li').eq(2);
 // 添加保存草稿按钮
var saveDraft = '<li aria-hidden="false" id="saveDraft"><a href="#finish2" role="menuitem">保存草稿</a></li>';
sub.after(saveDraft);
sub.find('a').text('提交');
//编辑草稿时，生成的rfp_id meeting_code:
var rfpId = '',
    meetingCode = '';
$(".actions ul li").on('click', function () {
   var oindex = $(this).index();
   if( oindex==2 || oindex == 3){
    // 对插件的显示状态进行手动设置；
    // cont1.addClass('active');
    // cont2.css("display","none");
    // document.getElementById("#cont1").style.display = "block";
     $("#preMeetingType span").text(meetingType.valueText);
    //基础信息模块
    var meetingName2= omeetingName2.oval;//会议名称
    var meetingTp = meetingType.value8;//会议类型
    var meetingBitTyp   =  meetingBitType.value14;//竞标类型
    var meetingTimeItems = meetingTime3.items;//会议时间
    var itineraryStart = meetingItinerary.getSeconds1;//会议行程开始时间
    var itineraryEnd = meetingItinerary.getSeconds2;//会议行程结束时间
    var meetingProCode = meetingPlace.valuePro;//会议省份code
    var meetingPro = meetingPlace.proText;//会议省份
    var meetingCityCode = meetingPlace.valueCity;//会议city code
    var meetingCity = meetingPlace.cityText;//会议city 
    var appliSector = aplSector.value8;//申请部门；
    var meetingCostCenter = costCenter.value8;//会议申请，成本中心；
    var dairy = meetingDairy.imageUrl;//会议日程
    // console.log(dairy);
    // console.log(meetingDairy.fileList3);
       var dotArr = new Array;
       $("input[name='dot']").each(function(i){

           dotArr[i] = $(this).val();
       });
       var priv = dotArr.join(',');

    if(!meetingName2){
        layFun("会议名称不能为空");
        return false;
    }
    if(oindex == 2){  
        if(!meetingTp){
            layFun("会议类型不能为空");
            return false;
        }
        if(meetingBitTyp === ''){
            layFun("竞标类型不能为空");
            return false;
        }
        if(!meetingTimeItems || !meetingTimeItems[0].value1 || !meetingTimeItems[0].value2){
            layFun("会议时间不能为空");
            return false;
        }
        // if(!itineraryEnd){
        //     layFun("会议行程结束时间不能为空");
        //     return false;
        // }
        if(!meetingProCode || !meetingCityCode){
            layFun("会议地点不能为空");
            return false;
        }
        // if(!appliSector){
        //     layFun("申请部门不能为空");
        //     return false;
        // }
        if(!meetingCostCenter){
            layFun("成本中心不能为空");
            return false;
        }
        // if(!dairy){
        //     layFun("会议日程不能为空");
        //     return false;
        // }
    }    
    //会议预算
    var budget = meetingBudget.items;//会议预算的各个费用项
    var visi = meetingBudget.state;//决定预算费用是否对服务商可见；
    var totalCost = meetingBudget.ototal; //会议预算总费用；

    /*if(oindex == 2){  
        if(!totalCost || totalCost <= 0){
            layFun("会议预算费用填写不正确");
            return false;
        }
    }*/
    //参会人员模块；

    var numberCustomer= activePepole1.num1;//客户参会人数
    var internal= activePepole1.num2;//企业内部
    var thirdPart= activePepole1.num3;//第三方大会预订
    var participants = pepople.arr;//会议日程人员名单；

    var meetingDot = dot.num1;

    if(oindex == 2){ 
        var flag1=flag2=flag3=true;
    //if (!(flag1&&flag2&&flag3)) {

        if((!numberCustomer || numberCustomer <= 0) && (!internal || internal <= 0) && (!thirdPart || thirdPart <= 0)){
            layFun("请填写参会人数");
            return flag1 = false;
        }
        //if(!internal || internal <= 0){
            /*layFun("企业内部人数填写不正确");*/
            //return flag2 = false;
        //}
        //if(!thirdPart || thirdPart <= 0){
            /*layFun("第三方大会预订人数填写不正确");*/
        //    return flag3 = false;
        //}
    //}
        
        // if(!participants){
        //     layFun("请上传参会人员名单");
        //     return false;
        // }
    }


    var data = {
        rfp_id : rfpId,         //会议id--------------------直接提交可以为空，草稿编辑时不能为空
        meeting_code: meetingCode,      //会议编码
        meeting_type_code: meetingTp,      //会议类型编码---------直接提交可以为空，草稿编辑时不能为空
        meeting_name: meetingName2,      //会议名称
        bit_type:meetingBitTyp, //竞标类型
        meeting_time: JSON.stringify(meetingTimeItems),      //会议时间
        trip_start_time: itineraryStart,      //行程开始时间int
        trip_end_time: itineraryEnd,      //行程结束时间int
        provincedesc: meetingPro,      //会议省份
        provincecode: meetingProCode,      //省份编码
        citydesc: meetingCity,      //会议城市
        citycode: meetingCityCode,      //城市编码
        abroad_site: '',      //海外会议地址
        department: appliSector,     //会议申请部门
        marketorgcode: meetingCostCenter,      //成本中心编码
        abroad_file: dairy,      //会议日程上传文件地址

        fundtypecode_arr: JSON.stringify(budget),      // 费用类型编码=>费用预算金额 格式：fundtypecode_arr[‘code’]=value
        look_budget: visi,      //预算是否可见

        clientele_num: numberCustomer,      //客户参会人数
        within_num : internal,      //客户参会人数
        nonparty_num: thirdPart,       //客户参会人数
        dot : priv,
        meeting_file: JSON.stringify(participants)       //参会人员上传文件地址
    };
    if(oindex == 2){
        Url = '/Meeting/createsubmit';
    }else if(oindex == 3){
        Url = '/Meeting/saveSubmit';
    }
    $.ajax({
        url: Url,
        type:'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': toke
        },
        data: data,
        success: function (res) {
            if(res.status == '1'){
                if(oindex == 3){
                    rfpId = res.data.rfp_id;
                    meetingCode = res.data.meeting_code;
                    layFun("保存草稿成功");
                    window.location.href = "/Rfp/index";
                    // console.log(rfpId,meetingCode)
                }else if(oindex == 2){
                    layFun("已提交成功");
                    window.location.href = "/Rfp/index";
                }
            }else{
                layFun("未成功，请稍后再试");
            }
        },
        error: function (res) {
            layFun("提交失败，请稍后再试")
        }
    })
    }
});
// 点击提交时执行的方法；

                                           
// 点击预览时出现的会议预算(只读)
var next1 = $('.actions>ul>li').eq(1);
var preMeeting = {};
var preMeeting2 = {};
/*next1.click(function () {

    preMeeting.length = 7;
    for (var i = 0; i < preMeeting.length; i++) {
        preMeeting[i] = [];
    }
    preMeeting[0].name = '会议名称';
    preMeeting[1].name = '会议类型';
    preMeeting[2].name = '会议时间';
    preMeeting[3].name = '行程';
    preMeeting[4].name = '会议地点';
    preMeeting[5].name = '会议申请';
    preMeeting[6].name = '会议日程';
    preMeeting[0].text = $.trim($("#meetingName2").val());
    preMeeting[1].text = meetingType.valueText;
    preMeeting[2].text = meetingTime3.items;
    preMeeting[3].text = meetingItinerary.value3 +'至'+meetingItinerary.value4;
    preMeeting[4].text = meetingPlace.selectOptions;
    preMeeting[5].text = aplSector.valueText;
    preMeeting[6].text = costCenter.valueText;
    var Main12 = {
        data() {
          return {
            oitems: preMeeting
          }
        },
        methods: {

        }
    };
    var Ctor12 = Vue.extend(Main12);
    var preBasic = new Ctor12().$mount('#preBasic');
    // 拼接会议预算的对象;
    preMeeting2.length = 7;
    for (var i = 0; i < preMeeting2.length; i++) {
        preMeeting2[i] = [];
    }
    // console.log(meetingBudget)
    preMeeting2[0].name = '餐饮费';
    preMeeting2[1].name = '酒店费';
    preMeeting2[2].name = '酒水';
    preMeeting2[3].name = '机票';
    preMeeting2[4].name = '租车';
    preMeeting2[5].name = '是否对服务商可见';
    preMeeting2[6].name = '预算合计';
    // preMeeting2[0].text = meetingBudget[0].num;
    // preMeeting2[1].text = meetingBudget[1].num;
    // preMeeting2[2].text = meetingBudget[2].num;
    // preMeeting2[3].text = meetingBudget[3].num;
    // preMeeting2[4].text = meetingBudget[4].num;
    // preMeeting2[5].text = meetingBudget.state;
    // preMeeting2[6].text = costCenter.total;
    // console.log(preMeeting2)

    // 预览会议预算部分
    var Main13 = {
        data() {
          return {
            oitems: preMeeting2
          }
        },
        methods: {

        }
    };
    var Ctor13 = Vue.extend(Main13);
    var preMeetingBudget = new Ctor13().$mount('#preMeetingBudget');
})*/

    
},50);

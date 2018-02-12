// 会议执行全部
var toke = $("#toke").val();
// 由列表跳转过来时携带的id值，在list页面存在后需要重写进行获取id;
var id = $("#rfp").val();
// 事件总线；
var bus = new Vue();
// 会议执行确认的实例化；
var main = {
    data (){
        // 对签到人数进行验证
        var validateNum = function (rule, value, callback) {
            // setTimeout(function () {
                // body...
                if(value < 1){
                    // callback(new Error('请输入正确的签到人数'));
                }else{
                    callback();
                }
            // },1000)
        };
        return {
            labelPosition: 'top',
            options: '',
            oform: {
                name: '',
                budget: '',
                num: '',
                value8: ''
                // activeUrl: ''
            },
            rules:{
                num: [{required: true,  trigger: 'blur' }
                ]
            }
        };
    },
    created (){
        var that = this;
        //获取上会人
        $.ajax({
            url:'/Memo/getUpname',
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
        // 依据listId获取会议名称及会议预算；
        $.ajax({
            url:'/Memo/confirm_memo',
            type:'GET',
            dataType: 'JSON',
            data: {rfp_id: id},
            success: function (res) {
                // console.log(res)
                that.oform.name = res.Data.meeting_name;
                that.oform.budget = res.Data.budget_total_amount;
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
        // 对事件进行分发；计数器必须进行传递参数，而不是从data里获取
        handleChange1: function (num) {
            bus.$emit("useDefinedEvent1", num);
        },
        handleChange2: function (val) {
            bus.$emit("useDefinedEvent2", val);
        }
    }
}
var Ctor = Vue.extend(main);
var article = new Ctor().$mount("#article1");

var oformData =  [
                {
                    id:"0",
                    otext1: "会议费用(元)",
                    num: "0",
                    otext2: "会议室费用说明",
                    oinput: ''
                },
                {
                    id:"1",
                    otext1: "餐饮费用(元)",
                    num: "0",
                    otext2: "餐饮费用说明",
                    oinput: ''
                },
                {
                    id:"2",
                    otext1: "住宿费用(元)",
                    num: "0",
                    otext2: "住宿费用说明",
                    oinput: ''
                },
                {
                    id:"3",
                    otext1: "易捷采购酒水费(元)",
                    num: "0",
                    otext2: "易捷采购酒水费说明",
                    oinput: ''
                },
                {
                    id:"4",
                    otext1: "会唐代采酒水费(元)",
                    num: "0",
                    otext2: "会唐代采酒水费说明",
                    oinput: ''
                },
                {
                    id:"5",
                    otext1: "其他费用(元)",
                    num: "0",
                    otext2: "其他费用说明",
                    oinput: ''
                },
                {
                    id:"6",
                    otext1: "会务服务费(元)",
                    num: "0",
                    otext2: "会务服务费说明",
                    oinput: ''
                }
            ]
// 实际支出明细的实例化
var main2 = {
    data () {
        return {
            labelPosition: 'top',
            form: {
                name: 'file'
            },
            headers: {
                'X-CSRF-TOKEN': toke
            },
            oform: {
                num: 1,
                people: '',
                type: oformData,
                desc: '',
                imageUrl: []
            },
            dialogVisible: false,
            fileList3: [],
            oList: [],
            value1: null,
            value2: null,
            value3: null,
            value4: null,
            desc: '',
            rules: {
                imageUrl: [{ required: true}
                ]
            }
        };
    },
    created (){
        
    },
    methods: {
        beforeUpload (file, fileList){
            var isJPG = file.type === 'image/jpeg';
            // element-ui 比较坑的设置文件类型的方法；
            var isPNG = file.type === 'image/png';
            var isLt2M = file.size / 1024 / 1024 < 10;
            if (!isJPG && !isPNG) {
              this.$message.error('上传头像图片只能是 jpg,png格式!');
            }
            if (!isLt2M) {
              this.$message.error('上传头像图片大小不能超过 10MB!');
            }
            return (isJPG || isPNG) && isLt2M;
        },
        // 在图片改变时执行的回调
        handleChange(file, fileList) {
            // console.log(fileList)
            this.fileList3 = fileList;
        },
        // 获取图片的路径
        handlePictureCardPreview(file) {
            this.oform.imageUrl = file.url;
            this.dialogVisible = true;
        },
        //  图片上传成功时的回调
        onSuccess (response, file, fileList){
            file.url = response.data;
            this.oform.imageUrl = response.data;
            
            // console.log(file.url)
        },
        // 点击确定时执行的方法；
        subForm: function (){
            var that = this;
            if(this.oform.imageUrl == 0) return  this.$message.error('支持材料不能为空');
            // 在点击提交时获取图片数组；
            this.oList = [];
            for (var i = 0; i < this.fileList3.length; i++) {
                this.oList.push(this.fileList3[i].url)
            }
            // 获取提交的数据方法；
            var odata = {
                rfp_id: id,
                signed_number: this.oform.num, //签到人数
                up_name : this.oform.people,  //上会人
                meeting_room_fees   : this.oform.type[0].num,  //场地费用
                food_fees : this.oform.type[1].num,  //餐饮费用
                room_fees : this.oform.type[2].num,  //住宿费用
                wine_drinks: this.oform.type[3].num, //易捷酒水
                jd_fees   : this.oform.type[4].num,  //京东代采费用
                other_fees: this.oform.type[5].num,  //其他费用
                equipment_fees: this.oform.type[6].num,  //会务费用
                meeting_room_note : this.oform.type[0].oinput,  //会议室费用说明
                meeting_food_note : this.oform.type[1].oinput,  //餐饮费用说明
                meeting_hotel_note: this.oform.type[2].oinput,  //住宿费用说明
                meeting_note  : this.oform.type[3].oinput,  //会务费说明
                meeting_yijie_note: this.oform.type[4].oinput,  //易捷费用说明
                meeting_eventown_note : this.oform.type[5].oinput,  //会唐采购说明
                meeting_other_note: this.oform.type[6].oinput,  //其他费用说明
                remark    : this.oform.desc,  //备注
                place_star: this.value1,  //场地评星
                food_star : this.value2,  //
                room_star   : this.value3,
                serve_star  : this.value4,
                appraise_serve: this.desc,  //评价服务
                files: JSON.stringify(that.oList)     //图片路径
            };
            // 发起提交请求；
            $.ajax({
                url: '/Memo/save_memo',
                type:'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': toke
                },
                data: odata,
                success: function (res) {
                    if(res.Success == true){
                        that.$message.success("提交成功");
                        window.location.href = "/Rfp/index";
                    }else{
                        that.$message.error("网络繁忙，请稍后再试");
                    }
                },
                error: function (res) {
                    that.$message.error("提交失败，请稍后再试")
                }
            })
        }
    },
    computed: {
        total (){
            var total = 0;
            if(!this.oform.type) return;
            this.oform.type.forEach(function(item){
                total += item.num;
            });
            return total;
        }
    },
    mounted (){
        var that = this;
        // 事件接收器；
        bus.$on("useDefinedEvent1", function (num) {
            that.oform.num = num;
        });
        bus.$on("useDefinedEvent2", function (val) {
            that.oform.people = val;
            // console.log(val)
        });
    }
}
var Ctor2 = Vue.extend(main2);
var section1 = new Ctor2().$mount("#section1");


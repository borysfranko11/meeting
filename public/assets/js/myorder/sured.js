// 会议执行全部
var toke = $("#toke").val();
var id = $("#rfp").val();
// var main = {
//     data (){
//         return {
//             labelPosition: 'top',
//             options: '',
            
//         };
//     },
//     created (){
        
//     },
//     methods: {

//     }
// }
// var Ctor = Vue.extend(main);
// var article = new Ctor().$mount("#article1");
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
var oText =  ['极差', '失望', '一般', '满意', '惊喜'];
// 实际支出明细
var main2 = {
    data (){
        return {
            labelPosition: 'top',
            headers: {
                'X-CSRF-TOKEN': toke
            },
            oform1: {
                name: '',
                budget: '',
                num: '',
                value8: ''
            },
            oform: {
                type: oformData,
                desc: '',
                imgUrl: []
            },
            total: '',
            value1: 0,
            value2: 0,
            value3: 0,
            value4: 0,
            dialogVisible: false,
            dialogImageUrl: '',
            desc: '',
            total: ''
            // activeUrl: ''
        };
    },
    created (){
        var that = this;
        var odata = {
            rfp_id: id
        };
        $.ajax({
            url:'/Memo/memo_detail',
            type:'GET',
            dataType: 'JSON',
            data: odata,
            success: function (res) {
                if(res.Success == true){
                    getList(res)
                }else{
                    that.$message.error("服务器繁忙请稍后再试");
                }
            },
            error: function (res) {
                that.$message.error("服务器繁忙请稍后再试");
            }
        });
        function getList(res) {
            var resData = res.Data.perform_info;
            var resData2 = res.Data.rfp_info;
            var imgList  = res.Data.files;
            // 设置各个值与后台给的字段进行对应；
            that.oform1.name = resData2.meeting_name;
            that.oform1.budget = resData2.budget_total_amount;
            that.oform1.num = resData.signed_number;
            that.oform1.value8 = resData.up_name;
            // zhichumingxi
            that.oform.type[0].num = resData.meeting_room_fees;
            that.oform.type[1].num = resData.food_fees;
            that.oform.type[2].num = resData.room_fees;
            that.oform.type[3].num = resData.wine_drinks;
            that.oform.type[4].num = resData.jd_fees;
            that.oform.type[5].num = resData.other_fees;
            that.oform.type[6].num = resData.equipment_fees;
            that.oform.type[6].num = resData.equipment_fees;
            that.oform.type[0].oinput = resData.meeting_room_note;
            that.oform.type[1].oinput = resData.meeting_food_note;
            that.oform.type[2].oinput = resData.meeting_hotel_note;
            that.oform.type[3].oinput = resData.meeting_note;
            that.oform.type[4].oinput = resData.meeting_yijie_note;
            that.oform.type[5].oinput = resData.other_fees;
            that.oform.type[6].oinput = resData.meeting_eventown_note;
            that.oform.type[6].oinput = resData.meeting_other_note;
            that.total = resData2.ht_settlement_amount;
            that.oform.desc = resData.remark;
            that.desc = resData.appraise_serve;
            that.value1 = resData.place_star;
            that.value2 = resData.food_star;
            that.value3 = resData.room_star;
            that.value4 = resData.serve_star;
            that.oform.imgUrl = imgList;
        }
    },
    methods: {
        shwoBigImg (index, name){
            this.dialogImageUrl = name;
            this.dialogVisible = true;
        }
    }
}
var Ctor2 = Vue.extend(main2);
var section1 = new Ctor2().$mount("#section1");


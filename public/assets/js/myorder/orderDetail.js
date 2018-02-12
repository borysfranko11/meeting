// 会议执行全部
var toke = $("#toke").val();
var id = $("#rfp").val();
// var id = 1;
function add0(m){return m<10?'0'+m:m }
function oformTime(shijianchuo){
    //shijianchuo是整数，否则要parseInt转换
    var time = new Date(shijianchuo);
    var y = time.getFullYear();
    var m = time.getMonth()+1;
    var d = time.getDate();
    var h = time.getHours();
    var mm = time.getMinutes();
    var s = time.getSeconds();
    return y+'-'+add0(m)+'-'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    // return y+'-'+add0(m)+'-'+add0(d);
}
var oformData =  [
                {
                    id:"0",
                    otext1: "场地费用：",
                    num: "0",
                    otext2: "场地费用说明：",
                    oinput: '测试场地用说明'
                },
                {
                    id:"1",
                    otext1: "餐饮费用：",
                    num: "0",
                    otext2: "餐饮费用说明：",
                    oinput: ''
                },
                {
                    id:"2",
                    otext1: "住宿费用：",
                    num: "0",
                    otext2: "住宿费用说明：",
                    oinput: ''
                },
                {
                    id:"3",
                    otext1: "易捷采购酒水费：",
                    num: "0",
                    otext2: "易捷采购酒水费说明：",
                    oinput: ''
                },
                {
                    id:"4",
                    otext1: "会唐代采酒水费：",
                    num: "0",
                    otext2: "会唐代采酒水费说明：",
                    oinput: ''
                },
                {
                    id:"5",
                    otext1: "其他费用：",
                    num: "0",
                    otext2: "其他费用说明：",
                    oinput: ''
                },
                {
                    id:"6",
                    otext1: "会务服务费：",
                    num: "0",
                    otext2: "会务服务费说明：",
                    oinput: ''
                },
                {
                    id:"7",
                    otext1: "交通费用：",
                    num: "0",
                    otext2: "交通说明：",
                    oinput: ''
                },
                {
                    id:"8",
                    otext1: "用车费用：",
                    num: "0",
                    otext2: "用车费用说明：",
                    oinput: ''
                },
                {
                    id:"9",
                    otext1: "外出用餐费用：",
                    num: "0",
                    otext2: "外出用餐费用说明：",
                    oinput: ''
                }
            ];
var oformData1 =  [
    {
        id:"0",
        otext1: "场地费用：",
        num: "0",
        otext2: "场地费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"1",
        otext1: "餐饮费用：",
        num: "0",
        otext2: "餐饮费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"2",
        otext1: "住宿费用：",
        num: "0",
        otext2: "住宿费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"3",
        otext1: "易捷采购酒水费：",
        num: "0",
        otext2: "易捷采购酒水费说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"4",
        otext1: "会唐代采酒水费：",
        num: "0",
        otext2: "会唐代采酒水费说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"5",
        otext1: "其他费用：",
        num: "0",
        otext2: "其他费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"6",
        otext1: "会务服务费：",
        num: "0",
        otext2: "会务服务费说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"7",
        otext1: "交通费用：",
        num: "0",
        otext2: "交通说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"8",
        otext1: "用车费用：",
        num: "0",
        otext2: "用车费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    },
    {
        id:"9",
        otext1: "外出用餐费用：",
        num: "0",
        otext2: "外出用餐费用说明：",
        oinput: '该项费用暂无说明',
        num2: "0",
        supplier: '供应商'
    }
]
var tableData =[{
            userCode: '2016-05-02',
            orderNum: '王小虎',
            metCode: '上海市普陀区金沙江路 1518 弄',
            metName: '上海市普陀区金沙江路 1518 弄',
            orderTime: '上海市普陀区金沙江路 1518 弄',
            wineAmount: '666666',
            orderSatus: '已确认'
          },{
            userCode: '2016-05-02',
            orderNum: '王小虎',
            metCode: '上海市普陀区金沙江路 1518 弄',
            metName: '上海市普陀区金沙江路 1518 弄',
            orderTime: '上海市普陀区金沙江路 1518 弄',
            wineAmount: '666666',
            orderSatus: '已确认'
          },{
            userCode: '2016-05-02',
            orderNum: '王小虎',
            metCode: '上海市普陀区金沙江路 1518 弄',
            metName: '上海市普陀区金沙江路 1518 弄',
            orderTime: '上海市普陀区金沙江路 1518 弄',
            wineAmount: '666666',
            orderSatus: '已确认'
          } ];
var otableData =[];
var oText =  ['极差', '失望', '一般', '满意', '惊喜'];
// 实际支出明细
var main2 = {
    data (){
        return {
            labelPosition: 'top',
            headers: {
                'X-CSRF-TOKEN': toke
            },
            martop: 'martop',
            oform: {
                ocode: '',
                name: '',
                meetingStartTime: '',
                meetingEndTime: '',
                budget: '',
                pepo: '',
                tripStartTime: '',
                tripEndTime: '',
                ostate: '',
                hotelName: '',
                hotelPla: ''
            },
            pla: {
                name: '地点名字',
                orderNum: '',
                orderStatus: '',
                total: '',
                userStartTime: '',
                userEndTime: '',
                infor: '备注',
                food: '',
                room: '',
                dinner: 'dinner',
                dinType: 'dinner',
                pepoNum: 'dinner',
                costYuan: 'dinner',
                inforDin: 'dinner',
                totalDin: 'dinner',
                stayType: 'dinner',
                roomNum: 'dinner',
                nightNum: 'dinner',
                stayStaTime: 'dinner',
                stayEndTime: 'dinner',
                inforStay: 'dinner',
                totalStay: 'dinner',
                surePla: 'dinner',
                sureNum: 'dinner',
                sureTotal: 'dinner',
                hotel: '酒店name'
            },
            ofontlen: 0,
            costCompare: {
                type: oformData1,
                factTotal1: 0,
                factTotal2: 0,
                totalSupplier: ''
            },
            dialogVisible: false,
            dialogImageUrl: '',

            value1: 0,
            value2: 0,
            value3: 0,
            value4: 0,
            desc: '',
            total: '',
            meetingInfo: {
                pepoNum: '666',
                type: oformData,
                imgUrl: [],
                factCost: 0
            },
            activeName: 'first',
            tableData: otableData
            // activeUrl: ''
        };
    },
    created (){
        var that = this;
        var odata = {
            rfp_id: id
        };
        $.ajax({
            url:'/Order/orderDetail',
            type:'GET',
            dataType: 'JSON',
            data: odata,
            success: function (res) {
                console.log(res);
                if(res.Success == true){
                    getList(res);
                }else{
                    that.$message.error("服务器繁忙请稍后再试");
                }
            },
            error: function (res) {
                that.$message.error("服务器繁忙请稍后再试");
            }
        });
        function getList(res) {
            var resData = res.Data.meeting;
            var resBudget = res.Data.budget;
            var resDataOrder = res.Data.order;
            var resDataFood = res.Data.rfp.food;
            var resDataRoom = res.Data.rfp.room;
            var imgList  = res.Data.picFile;
            var resDataInfor = res.Data.perform[0];
            // 订单详情部分 设置各个值与后台给的字段进行对应；
            that.oform.name = resData.meeting_name;
            that.oform.ocode = resData.meeting_code;
            that.oform.pepo = resData.people_num;
            that.oform.budget = resData.ht_payamount;
            that.oform.hotelName = resDataOrder.place_name;
            that.oform.hotelPla = resDataOrder.place_address;
                //时间戳转换；
            if(resData.start_time){
                that.oform.meetingStartTime = oformTime(resData.start_time*1000);
                // console.log(that.oform.meetingStartTime)
            };
            if(resData.end_time){
                that.oform.meetingEndTime = oformTime(resData.end_time*1000);
                // console.log(that.oform.meetingStartTime)
            };
            if(resData.trip_start_time){
                that.oform.tripStartTime = oformTime(resData.trip_start_time*1000);
            };
            if(resData.trip_end_time){
                that.oform.tripEndTime = oformTime(resData.trip_end_time*1000);
            };
            var statusText = resData.status || '';
            if(statusText != ''){
                if(statusText == 40){
                    that.oform.ostate = "订单完成";
                }else if(statusText == 30){
                    that.oform.ostate = "下单成功";
                }
            }
            // 场地订单下的title与场地部分；
            that.pla.orderNum = resDataOrder.order_no;
            that.pla.orderStatus = that.oform.ostate;
            that.pla.hotel = that.oform.hotelName;
            that.pla.userStartTime = resDataOrder.start_time;
            that.pla.userEndTime = resDataOrder.end_time;
            that.pla.total = resDataOrder.total_money;
                // 餐饮部分；
            that.pla.food = resDataFood;
                // 住宿部分；
            that.pla.room = resDataRoom;
                // 场地确认及报价
            that.pla.surePla = that.pla.hotel;
            that.pla.sureNum = that.pla.orderNum;
            that.pla.sureTotal = that.pla.total;
                // 会议执行信息部分
            that.meetingInfo.pepoNum = resDataInfor.signed_number;
            that.meetingInfo.type[0].num = resDataInfor.meeting_room_fees;
            that.meetingInfo.type[1].num = resDataInfor.food_fees;
            that.meetingInfo.type[2].num = resDataInfor.room_fees;
            that.meetingInfo.type[3].num = resDataInfor.wine_drinks;
            that.meetingInfo.type[4].num = resDataInfor.jd_fees;
            that.meetingInfo.type[5].num = resDataInfor.other_fees;
            that.meetingInfo.type[6].num = resDataInfor.equipment_fees;
            that.meetingInfo.type[7].num = '0.00';
            that.meetingInfo.type[8].num = '0.00';
            that.meetingInfo.type[9].num = '0.00';
            that.meetingInfo.type[0].oinput = resDataInfor.meeting_room_note;
            that.meetingInfo.type[1].oinput = resDataInfor.meeting_food_note;
            that.meetingInfo.type[2].oinput = resDataInfor.meeting_hotel_note;
            that.meetingInfo.type[3].oinput = resDataInfor.meeting_note;
            that.meetingInfo.type[4].oinput = resDataInfor.meeting_yijie_note;
            that.meetingInfo.type[5].oinput = resDataInfor.meeting_eventown_note;
            that.meetingInfo.type[6].oinput = resDataInfor.meeting_other_note;
            that.meetingInfo.type[7].oinput = '';
            that.meetingInfo.type[8].oinput = '';
            that.meetingInfo.type[9].oinput = '';
            that.meetingInfo.factCost = (Number(resData.ht_settlement_amount)+Number(0)+Number(0)+Number(0)).toFixed(2);
            // that.oform.desc = resData.remark;
            // 图片列表获取
            that.meetingInfo.imgUrl = imgList;
            // 评价服务部分
            that.desc = resDataInfor.appraise_serve;
            that.value1 = resDataInfor.place_star;
            that.value2 = resDataInfor.food_star;
            that.value3 = resDataInfor.room_star;
            that.value4 = resDataInfor.serve_star;
            //消费对比

            that.costCompare.type[0].numb = resBudget.equipment;
            that.costCompare.type[1].numb = resBudget.T01;
            that.costCompare.type[2].numb = resBudget.T02;
            that.costCompare.type[3].numb = '-';
            that.costCompare.type[4].numb = resBudget.T03;
            that.costCompare.type[5].numb = '-';
            that.costCompare.type[6].numb = '-';
            that.costCompare.type[7].numb = resBudget.T04;
            that.costCompare.type[8].numb = resBudget.T05;
            that.costCompare.type[9].numb = '-';
            var num_budget = Number(resBudget.equipment)+Number(resBudget.T01)+Number(resBudget.T02)+Number(resBudget.T03)+Number(resBudget.T04)+Number(resBudget.T05);
            console.log(num_budget);
            if(num_budget != 0 && num_budget != ''){
                that.costCompare.factTotal3 = num_budget.toFixed(2);
            }else{
                that.costCompare.factTotal3 = 0.00;
            }

            that.costCompare.type[0].num = resDataInfor.meeting_room_fees;
            that.costCompare.type[1].num = resDataInfor.food_fees;
            that.costCompare.type[2].num = resDataInfor.room_fees;
            that.costCompare.type[3].num = resDataInfor.wine_drinks;
            that.costCompare.type[4].num = resDataInfor.jd_fees;
            that.costCompare.type[5].num = resDataInfor.other_fees;
            that.costCompare.type[6].num = resDataInfor.equipment_fees;
            that.costCompare.type[7].num = '0.00';
            that.costCompare.type[8].num = '0.00';
            that.costCompare.type[9].num = '0.00';
            that.costCompare.type[0].oinput = resDataInfor.meeting_room_note;
            that.costCompare.type[1].oinput = resDataInfor.meeting_food_note;
            that.costCompare.type[2].oinput = resDataInfor.meeting_hotel_note;
            that.costCompare.type[3].oinput = resDataInfor.meeting_note;
            that.costCompare.type[4].oinput = resDataInfor.meeting_yijie_note;
            that.costCompare.type[5].oinput = resDataInfor.meeting_eventown_note;
            that.costCompare.type[6].oinput = resDataInfor.meeting_other_note;
            that.costCompare.type[7].oinput = '';
            that.costCompare.type[8].oinput = '';
            that.costCompare.type[9].oinput = '';
            that.costCompare.factTotal1 = (Number(resData.ht_settlement_amount)+Number(0)+Number(0)+Number(0)).toFixed(2);
                // 右半部分
            that.costCompare.type[0].num2 = resDataOrder.orderPlaceRoom;
            that.costCompare.type[1].num2 = resDataOrder.orderFood;
            that.costCompare.type[2].num2 = resDataOrder.orderRoom;
            that.costCompare.type[3].num2 = resDataInfor.wine_drinks;
            that.costCompare.type[4].num2 = resDataInfor.jd_fees;
            that.costCompare.type[5].num2 = resDataInfor.other_fees;
            that.costCompare.type[6].num2 = resDataInfor.equipment_fees;
            that.costCompare.type[7].num2 = '0.00';//37620.00
            that.costCompare.type[8].num2 = '0.00';//155400.00
            that.costCompare.type[9].num2 = '0.00';//51800.00
            that.costCompare.type[0].supplier = resDataOrder.place_name;
            that.costCompare.type[1].supplier = resDataOrder.place_name;
            that.costCompare.type[2].supplier = resDataOrder.place_name;
            that.costCompare.type[3].supplier = '易捷';
            that.costCompare.type[4].supplier = '京东';
            that.costCompare.type[5].supplier = '会唐';
            that.costCompare.type[6].supplier = '会唐';
            that.costCompare.type[7].supplier = '携程商旅';
            that.costCompare.type[8].supplier = '神州';
            that.costCompare.type[9].supplier = '大众点评';
            that.costCompare.factTotal2 = (Number(resDataOrder.total_money)+Number(0)+Number(0)+Number(0)).toFixed(2);
            that.costCompare.totalSupplier = '会唐';
        }
    },
    methods: {
        shwoBigImg (index, name){
            this.dialogImageUrl = name;
            this.dialogVisible = true;
        },
        handleClick (tab, event){
            // console.log(tab, event)
        }
    },
    computed: {
    }
}
var Ctor2 = Vue.extend(main2);
var section1 = new Ctor2().$mount("#section1");


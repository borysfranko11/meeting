// 会议执行全部
var toke = $("#toke").val();
var id = $("#rfp").val();
// console.log(id)
//var id= 1;
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
// 模版
var main2 = {
    data (){
        return {
            labelPosition: 'top',
            headers: {
                'X-CSRF-TOKEN': toke
            },
            otitle: '',
            basicNeeds: {
                code: '',
                name: '',
                typeMeeting: '',
                num: '',
                meetStartTime: '',
                meetEndTime: '',
                tripStartTime: '',
                tripEndTime: '',
                meetPlaPro: '',
                meetPlacity: '',
                serviceBudget: '',
                meetDairy: ''
            },
            oequipment: [],
            dinnerNeeds:{
                foodNeeds: [],
                wineNeeds: [],
                desc: '暂无描述'
            },
            hotelNeeds:{
                hotelData: [],
                desc: '暂无描述'
            },
            regionNeeds: {
                type: '',
                oposition: '',
                start: '',
                site: []
            },
            otherNeeds: {
                desc: '暂无描述'
            }
        };
    },
    created (){
        var that = this;
        var odata = {
            rfp_id: id
        };
        $.ajax({
            url:'/Order/rfpDetail',
            type:'GET',
            dataType: 'JSON',
            data: odata,
            success: function (res) {
                // console.log(res)
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
            // console.log(res)
            var resDataMeet = res.Data.meeting || '';
            var resDataBudget = res.Data.budget || '';
            var resDataRegion = res.Data.rfp.place || '';
            var resDataFood  = res.Data.rfp.dining || '';
            var resDataWine  = res.Data.rfp.wine || '';
            var resDataRoom  = res.Data.rfp.room || '';
            var resDataEquipment  = res.Data.rfp.equipment_arr || '';
            // 设置各个值与后台给的字段进行对应；
            // basicNeeds
            that.basicNeeds.code = resDataMeet.meeting_code;
            that.basicNeeds.name = resDataMeet.meeting_name;
            that.basicNeeds.typeMeeting = resDataMeet.meeting_type_desc;
            that.basicNeeds.num = resDataMeet.people_num;
            if(resDataMeet.start_time){
                that.basicNeeds.meetStartTime = oformTime(resDataMeet.start_time*1000);
            };
            if(resDataMeet.end_time){
                that.basicNeeds.meetEndTime = oformTime(resDataMeet.end_time*1000);
            };
            if(resDataMeet.trip_start_time){
                that.basicNeeds.tripStartTime = oformTime(resDataMeet.trip_start_time*1000);
            };
            if(resDataMeet.trip_end_time){
                that.basicNeeds.tripEndTime = oformTime(resDataMeet.trip_end_time*1000);
            };
            if(resDataMeet){
                that.basicNeeds.meetPlaPro = resDataMeet.provincedesc;
                that.basicNeeds.meetPlacity = resDataMeet.citydesc;
                that.basicNeeds.serviceBudget = resDataBudget;
                that.basicNeeds.meetDairy = resDataMeet.abroad_file;
            }
            // regionNeeds
            if(resDataRegion){
                that.regionNeeds.type = resDataRegion.place_type_name;
                that.regionNeeds.oposition = resDataRegion.place_location_name;
                that.regionNeeds.start = resDataRegion.place_star_name;
                that.regionNeeds.site = resDataRegion.hotel_arr;
            }
            // equipment
            if(resDataEquipment){
                // var emptyArr = [];
                var newobj = JSON.parse(JSON.stringify(resDataEquipment))
                var onewEquipment = newobj;
                // console.log(onewEquipment);
                for (var i = 0; i < onewEquipment.length; i++) {
                    // var commonFacility = {'commonFacility': []};
                    // var onewEquipment[i].push(commonFacility);
                    onewEquipment[i]["commonFacility"] = [];
                    if(onewEquipment[i]['equipment']){
                        onewEquipment[i]["commonFacility"] = onewEquipment[i]['equipment'].splice(10,4);
                    }
                }
                
                // console.log(onewEquipment)
            }
            that.oequipment = onewEquipment || [];
            // dinnerNeeds
            that.dinnerNeeds.foodNeeds = resDataFood || [];
            // wineNeeds
            that.dinnerNeeds.wineNeeds = resDataWine || [];
            // roomNeeds
            that.hotelNeeds.hotelData = resDataRoom || [];
        }
    },
    methods: {
        shwoBigImg (index, name){
            this.dialogImageUrl = name;
            this.dialogVisible = true;
        },
        filterSupply (value, row){
            // console.log(value, row)
            return row.food_menu_name == value;
        },
        filterSupply2 (value, row){
            // console.log(value, row)
            return row.breakfast_name == value;
        }
    }
}
var Ctor2 = Vue.extend(main2);
var section1 = new Ctor2().$mount("#section1");



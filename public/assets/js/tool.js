function Tool(){
}
Tool.prototype.allChecked=function(table,name){
    var oTBody=table.find('tbody'),
        oTHead=table.find('thead'),
    arrId=oTHead.find('input').val().split(',');
    if(localStorage[name]) {
        postArrId=localStorage[name].split(',');
        if (postArrId.length === arrId.length) {

            table.find("input").prop("checked", true);
        }
        oTBody.find("input").each(function () {

            if (postArrId.indexOf($(this).val()) !== -1) {

                $(this).prop('checked', true)
            }
        })
    }
    oTHead.find("input").on("click",function(){ //全选
        oTBody.find('input').prop("checked",this.checked);
        if($(this).is(':checked')) {
            postArrId = arrId.slice();
        }else{
            postArrId = [];
        }
        localStorage[name]=postArrId;
    });
    oTBody.on("change","input",function(){ //判断全选
        var val=$(this).val();
        if($(this).is(':checked')){
            postArrId.push(val);
            if(postArrId.length===arrId.length) {
                oTHead.find("input").prop("checked", this.checked);
            }
        }else{
            var num=postArrId.indexOf(val);
            postArrId.splice(num,1);
            oTHead.find("input").prop("checked", this.checked);
        }
        localStorage[name]=postArrId;
    })
};
Tool.prototype.updateAlert=function (alertbox,number,msg){
    number=parseInt(number);
    console.log(number)
    switch(parseInt(number))// 1发送文件格式不对 2发送文件过大   3超过六万条数据 4数据导入失败 5发送成功 9
    {
        case 0:
            console.log(number);
            break;
        case 1:
            console.log(number);
            alertbox.find('code').text('文件格式不对，请重新选择');
            break;
        case 2:
            console.log(number);

            alertbox.find('code').text('文件超出2M，请修改后重试');

            break;
        case 3:
            console.log(number);
            alertbox.find('code').text('已超出6万条数据，请修改后重试');
            break;
        case 4:
            var text="";
            alertbox.find('.sub').find('img').attr("src",'/assets/img/fail.png');
            alertbox.find('.sub').find('span').text('批量导入失败')
            for(var i=0;i<msg.length;i++){
                text+=msg[i]+"<br/>";
            }
            alertbox.find('.sub').find('p').html(text);
            break;
        case 5:
            alertbox.find('.sub').find('img').attr("src",'/assets/img/allow.png');
            alertbox.find('span[aria-hidden="true"]').on("click",function(){
                window.location.reload();
            });
            alertbox.find('code').text('');
            alertbox.find('.sub').find('span').text(msg);
            break;
        case 9:
            console.log(123);
            alertbox.find('code').text('文件内没有任何信息');
            break;


    }
};
Tool.prototype.GetQueryString=function (name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
};
Tool.prototype.paging=function (obj,sumpage,href,nowP){
    var sumPage=parseInt(sumpage),

        reg=/page=\d+/,
        url=href.replace(reg,"");
    var PageItem="",
        nowPage=parseInt(nowP),
        nextNum=0,
        lastNum=0,
        flag="none";
    if
    (sumPage<=7 ){
        nextNum=sumPage-nowPage;
        lastNum=sumPage-nextNum
    }
    else if(nowPage>sumPage-6 && sumPage>7){
        nextNum=sumPage-nowPage;
        lastNum=7-nextNum;
        flag="last";

    }else if(nowPage<=5){
        nextNum=6-nowPage;
        lastNum=6-nextNum;
        flag="next"
    }
    else if(nowPage<=7 &&  sumPage<7){
        nextNum=6-nowPage;
        lastNum=6-nextNum;
    }
    else{
        nextNum=3;
        lastNum=3;
        flag="double"
    }
    if(nowPage>0){
        PageItem="<li><a href='"+url+"page="+parseInt(nowPage-1)+"&'><</a></li>"
    }
    if( flag ==="double"||flag==="last"){
        PageItem+="<li><a href='"+url+"page=0&'>1</a></li>";
        PageItem+="<li><a href='"+url+"page=1&'>2</a></li>";
        PageItem+="<li><span>...</span></li>";
    }
    for(var i=0 ;i<lastNum;i++){
        var page=nowPage-lastNum+i;PageItem+="<li><a href='"+url+"page="+page+"&'>"+parseInt(page+1)+"</a></li>"
    }

    PageItem+="<li class='active'><a href='"+url+"page="+nowPage+"&'>"+parseInt(nowPage+1)+"</a></li>"
    if(nowPage==5 && sumPage>7){
        console.log(sumPage,nowPage);
        PageItem+="<li class='active'><a href='"+url+"page="+parseInt(nowPage+1)+"&'>"+parseInt(nowPage+2)+"</a></li>"
    }
    for( i=1 ;i<nextNum;i++){
        var page=nowPage+i;
        PageItem+="<li><a href='"+url+"page="+parseInt(page)+"&'>"+parseInt(page+1)+"</a></li>"
    }
    if( flag ==="double"||flag==="next"){
        PageItem+="<li><span>...</span></li>";
        PageItem+="<li><a href='"+url+"page="+parseInt(sumPage-2)+"&'>"+parseInt(sumPage-1)+"</a></li>";
        PageItem+="<li><a href='"+url+"page="+parseInt(sumPage-1)+"&'>"+parseInt(sumPage)+"</a></li>"
    }
    if(nowPage<sumPage-1){
        PageItem+="<li><a href='"+url+"page="+parseInt(nowPage+1)+"&'>></a></li>"
    }



    $(obj).html(PageItem);

};


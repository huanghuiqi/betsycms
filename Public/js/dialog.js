/**
 * Created by huanghuiqi on 2017/7/12.
 */
var dialog = {
    //错误弹出层
    error:function(message){
        layer.open({
            content:message,
            icon:2,
            title:"错误提示"
        })
    },

    //成功弹出层
    success:function(message,url){
        layer.open({
            content:message,
            icon:1,
            yes:function(){
                location.href=url;
            }
        })
    },

    //确认弹出层
    confirm:function(message,url){

    }
}
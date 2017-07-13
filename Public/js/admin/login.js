/**
 * Created by huanghuiqi on 2017/7/12.
 */
//前端登陆的业务类

var login = {
    check : function(){
        //获取登陆页面中的用户名和密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        if(!username){
            dialog.error("用户名不能为空！");
        }
        if(!password){
            dialog.error("密码不能为空！");
        }

        // 执行异步请求
        //var url = 'index.php?m=admin&c=login&a=check';
        var url = 'index.php?m=admin&c=login&a=check';
        data = {'username':username,'password':password};
        $.post(url,data,function(res){
            if(res.status == 0){
                return dialog.error(res.message);
            }
            if(res.status ==1){
                return dialog.success(res.message,'admin.php');
            }
        },'JSON');
    }
}
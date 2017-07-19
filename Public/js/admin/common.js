//公共的js写在这

/*
* 添加按钮操作
**/
$('#button-add').click(function(){
    var url = SCOPE.add_url;
    console.log(url);
    window.location.href = url;
});

/*
* 添加菜单信息表单
* */
$('#singcms-button-submit').on('click',function(){
    var data = $('#singcms-form').serializeArray();
    //console.log(data);
    var postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    })
    //console.log(postData);

    var url = SCOPE.save_url;
    var jump_url = SCOPE.jump_url;
    //将获取到的数据post到服务器
    $.post(url,postData,function(res){
        if(res.status == 1){
            return dialog.success(res.message,jump_url);
        }else if(res.stutus == 0){
            return dialog.error(res.message);
        }
    },'JSON');
});

/*
* 修改菜单名操作
* */
$('.singcms-table #singcms-edit').on('click',function(){
    var menuID = $(this).attr('attr-id');
    window.location.href = SCOPE.edit_url+'&id='+menuID;
})

/*
* 更新菜单信息表单
* */
$('#singcms-button-submit').on('click',function(){
    var data = $('#singcms-form').serializeArray();
    var postData = {};
    $(data).each(function(i){
        postData[this.name]=this.value;
    });
    var url = SCOPE.save_url;
    var jump_url = SCOPE.jump_url;

    $.post(url,postData,function(res){
        if(res.status == 1){
            dialog.success(res.message,jump_url);
        }else if(res.status == 0){
            dialog.error(res.message);
        }
    },'JSON')
})
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
    },'JSON');
})

/*
 * 删除菜单名操作
 * */
$('.singcms-table #singcms-delete').on('click',function(){
    var id = $(this).attr('attr-id');
    var a = $(this).attr('attr-a');  //menu
    var message = $(this).attr('attr-message');
    var url = SCOPE.set_status_url;

    pdata = {};
    pdata['id'] = id;
    pdata['status'] = -1;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定"+message,
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, pdata);
        },

    });
});

//删除
function todelete (url,data) {
    $.post(url,data,function (res) {
        if (res.status == 1) {
            return dialog.success(res.message, '')
        }
        else {
            return dialog.error(res.message);
        }
    }, 'JSON');
}

//更新排序
$('#button-listorder').on('click',function(){
    var data = $('#singcms-listorder').serializeArray();
    var postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    })

    var url = SCOPE.listorder_url;
    //将获取到的数据post到服务器
    $.post(url,postData,function(res){
        if(res.status == 1){
            console.log(res)
            return dialog.success(res.message,'');
        }else if(res.stutus == 0){
            return dialog.error(res.message);
        }
    },'JSON');
})
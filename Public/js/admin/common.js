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
* 添加form表单操作
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


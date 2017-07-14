//公共的js写在这

/*
* 添加按钮操作
* */
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

});


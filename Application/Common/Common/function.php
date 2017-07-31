<?php
//处理一些公用的方法与函数

//显示一些接口数据
function show($status,$msg,$data){
    $result = array(
        "status" => $status,
        "message" => $msg,
        "data" => $data
    );

    exit(json_encode($result));
}

//配合特殊字符进行md5加密
function getMd5Password($password){
    return md5($password.C('MD5_PRE'));
}

//获取session中的登陆用户名
function getLoginUsername(){
    return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}

//获取菜单的URL
function getAdminMenuUrl($nav){
    $url = 'admin.php?c='.$nav['c'].'&a='.$nav['f'];
    if($nav['f'] == 'index'){
        $url = 'admin.php?c='.$nav['c'];
    }
    return $url;
}

//菜单选中高亮显示
function getActive($navc){
    $c = strtolower(CONTROLLER_NAME);  //控制器
    if(strtolower($navc) == $c) {
        return 'class="active"';
    }
    return '';
}

//菜单列表类型
function getMenuType($type){
    return $type==1 ? "后台导航" : "前台导航";
}

//菜单列表状态
function getStatus($status){
    if($status == 0){
        $str = "关闭";
    }elseif ($status == 1){
        $str = "开启";
    }elseif ($status == -1){
        $str = "删除";
    }
    return $str;
}

//返回kindEditor的内容 不能用show 另外定义一个方法
function showKind($status,$data){
    header('Content-type:application/json;charset=UTF-8');
    if($status == 0){
        exit(json_encode(array('error'=>0,'url'=>$data)));
    }else{
        exit(json_encode(array('error'=>1,'message'=>'上传失败')));
    }
}
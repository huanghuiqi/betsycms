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
    return md5($password . C('MD5_PRE'));
}
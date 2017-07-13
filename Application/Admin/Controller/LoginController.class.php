<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller{
    public function index(){
        $this -> display();
    }

    public function check(){
        //print_r($_POST);
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!trim($username)){
            return show(0,'用户名不能为空哦');
        }
        if(!trim($password)){
            return show(0,'密码不能为空哦');
        }

        //D()实例化一个模型 ThinkPHP/Common/function.php
        $ret = D('Admin')->getAdminByUsername($username);
        if(!$ret){
            return show(0,'该用户不存在');
        }
    }
}
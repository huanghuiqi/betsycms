<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller{
    public function index(){
        if(session('adminUser') && session('adminUser') !== null){
            redirect('admin.php?c=index');
        }
        $this -> display();
    }

    //a=check
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
        if($ret['password'] != getMd5Password($password)){
            return show(0,'密码错误');
        }
        //保存登陆状态
        //session('adminUser',$ret['username']);
        session('adminUser',$ret);

        return show(1,'登陆成功');
    }

    //a=loginout
    public function loginout(){
        session('adminUser',null);
        //tp自带的跳转函数
        redirect('admin.php?c=login');
    }
}
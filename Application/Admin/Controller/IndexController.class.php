<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller{
    public function index(){
        //如果已经退出再打开是跳转到登录页
        if(!session('adminUser')){
            redirect('admin.php?c=login');
        }
        $this->display();
    }
}
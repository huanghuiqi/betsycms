<?php
namespace Admin\Controller;

use Think\Controller;

class MenuController extends CommonController{
    public function index(){
        /*
         * 分页操作逻辑 tp自带page库
         * */
        $page  = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 3;
        //获取数据
        $data = array();
        if(isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1))){
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }else{
            $this->assign('type',-10);
        }
        $menus = D('Menu') -> getMenus($data,$page,$pageSize);
        $menusCount = D('Menu') -> getMenusCount($data);
        //print_r($menusCount);

        //thinkphp自带page分页方法
        $res = new \Think\Page($menusCount,$pageSize);  //实例化page类
        $pageRes = $res->show(); //分页显示输出
        //赋值分页输出
        $this->assign('pageRes',$pageRes);
        //赋值数据集
        $this->assign('menus',$menus);
        //输出模板
        $this->display();
    }

    public function add(){
        if($_POST){
            //print_r($_POST);
            if(!isset($_POST['name']) || !$_POST['name']){
                show(0,'菜单名不能为空');
            }
            if(!isset($_POST['m']) || !$_POST['m']){
                show(0,'模块名不能为空');
            }
            if(!isset($_POST['c']) || !$_POST['c']){
                show(0,'控制器不能为空');
            }
            if(!isset($_POST['f']) || !$_POST['f']){
                show(0,'方法名不能为空');
            }
            $menuID = D('Menu')->insert($_POST);
            if($menuID){
                return show(1,"新增成功",$menuID);
            }else{
                return show(0,"新增失败");
            }
        }else{
            $this->display();
        }
    }

    //编辑页面显示
    public function edit(){
        $menuID = $_GET['id'];
        $menu = D('Menu')->find($menuID);
        $this->assign('menu',$menu);
        $this->display();
    }

    //更新操作
    public function save(){

    }
}
<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class MenuController extends CommonController{
    public function index(){
        /*
         * 分页操作逻辑 tp自带page库
         * */
        $page  = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 5;
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
            //更新操作
            if($_POST['menu_id']){
                return $this->save($_POST);   // 1
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
    public function save($data){
        $menuID = $data['menu_id'];
        unset($data['menu_id']);  //除了id其他都可以更换，所以$data数组里面去掉这个id

        try{
            $id = D('Menu')->updateMenubyId($menuID,$data);
            if($id === false){
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
    }

    //删除操作
    public function setStatus(){
        try{
            if($_POST){
                $menuID = $_POST['id'];
                $status = $_POST['status'];
                $res = D('Menu') -> updateStatusById($menuID,$status);
                if(res){
                    return show(1,"操作成功");
                }else{
                    return show(0,"操作失败");
                }
            }
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
        return show(0,"没有提交的数据");
    }

    //更新排序操作
    public function listorder(){
        $listorder = $_POST['listorder'];
        $errors = [];
        $jumpUrl = $_SERVER['HTTP_REFERER']; // 获取当前页面的地址
        if($listorder){
            try{
                foreach ($listorder as $menuID=>$val){
                    $id = D('Menu') -> updateMenuListorderById($menuID,$val);
                    if($id === false){
                        $errors[] = $menuID;
                    }
                }
            }catch (Exception $e){
                return show(0,$e->getMessage());
//                array('jump_url'=>$jumpUrl)
            }
            if($errors){
                return show(0,"排序失败-".implode(',',$errors));
            }else{
                return show(1,"排序成功");
            }
        }
        return show(0,"排序顺序失败");
    }
}

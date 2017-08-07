<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class PositionController extends Controller{
    public function index(){
        $data['ststus'] = array('neq',-1);
        $position = D('Position')->select($data);
        $this->assign('positions',$position);

        $this->display();
    }

    public function add(){
        if($_POST){
            if(!isset($_POST['name']) || !$_POST['name']){
                return show(0,'推荐位名称不存在');
            }
            //推荐位内容不是必须的
            if($_POST['id']){
                return $this->save($_POST);
            }

            $positionId = D('Position')->insert($_POST);
            if($positionId){
                return show(1,'添加成功');
            }else{
                return show(0,'添加失败！');
            }
        }
        $this->display();
    }

    public function edit(){
        $id = $_GET['id'];
        if($id){
            $position = D('Position')->find($id);
            if($position){
                $this->assign('vo',$position);
            }
        }
        $this->display();
    }

    public function save($data){
        $id = $data['id'];
        unset($data['id']);
        $res = D('Position')->updatePositionById($id,$data);
        if($res){
            return show(1,'更新成功');
        }else{
            return show(0,'更新失败');
        }
    }

    public function setStatus(){
        try{
            if($_POST){
                $positionId = $_POST['id'];
                $status = $_POST['status'];
                //print_r($_POST);exit;
                $res = D('Position')->updateStatusById($positionId,$status);
                if($res){
                    return show(1,'更改成功');
                }else{
                    return show(0,'更改失败，请检查原因');
                }
            }
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }

    }
}
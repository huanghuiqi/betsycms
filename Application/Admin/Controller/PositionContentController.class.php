<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class PositionContentController extends Controller{
    public function index(){
        //推荐位
        $position = D('Position')->getNormalPosition();
        $this->assign('positions',$position);

        //搜索功能
        //$data['status'] = array('neq', -1);
        if($_GET['title']){
            $data['title'] = trim($_GET['title']);
            $this->assign('title',$data['title']);
        }
        $data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $position[0]['id'];
        $contents = D('PositionContent')->select($data);
        $this->assign('positionId',$data['position_id']);
        $this->assign('contents',$contents);

        $this->display();
    }

    public function add(){
        if($_POST){
            if(!isset($_POST['position_id']) || !$_POST['position_id']){
                return show(0,'推荐位名称不存在');
            }
            if(!isset($_POST['title']) || !$_POST['title']){
                return show(0,'推荐位标题不能为空');
            }
            //url和文章id必须得选择一个
            if(!$_POST['url'] && !$_POST['news_id']){
                return show(0,'url和文章id不能同时为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb']){
                if($_POST['news_id']){
                    $news = D('News')->find($_POST['news_id']);
                    if($news && is_array($news)){
                        $_POST['thumb'] = $news['thumb'];
                    }
                }else{
                    return show(0,'图片不能为空');
                }
            }
            //更新数据
            if($_POST['id']){
                return $this->save($_POST);
            }

            try{
                $id = D('PositionContent')->insert($_POST);
                if($id){
                    return show(1,'新增成功');
                }
                return show(0,'新增失败');
            }catch(Exception $e){
                return show(0,$e->getMessage());
            }



        }else{
            $position = D('Position')->getNormalPosition();
            $this->assign('positions',$position);
            $this->display();
        }
    }

    public function edit(){
        $id = $_GET['id'];
        $positionContentInfo = D('PositionContent')->find($id);
        $position = D('Position')->getNormalPosition();
        $this->assign('vo',$positionContentInfo);
        $this->assign('positions',$position);
        $this->display();
    }

    public function save($data){
        $id = $data['id'];
        unset($data['id']);
        try{
            $res = D('PositionContent')->updateById($id,$data);
            if($res === false){
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
    }

    public function setStatus(){
        try{
            if($_POST){
                $positionId = $_POST['id'];
                $status = $_POST['status'];
                $res = D('PositionContent')->updateStatusById($positionId,$status);
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
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
        $data['status'] = array('neq', -1);
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
}
<?php
namespace Common\Model;

use Think\Model;

class MenuModel extends Model{
    private $_db = '';
    public function __construct()
    {
        $this -> _db = M('menu');
    }

    //左侧菜单栏排序
    public function getAdminMenus(){
        $data = array(
          'status' => array('neq',-1),   //neq 不等于-1的意思
          'type' => 1
        );

        return $this -> _db -> where($data) -> order('listorder desc,menu_id desc') -> select();
    }

    public function insert($data = array()){
        if(!$data || !is_array($data)){
            return 0;
        }else{
            return $this -> _db -> add($data);
        }
    }

    public function update($data=array()){
//        if(!$data || !is_array($data)){
//            return 0;
//        }else{
//            return $this -> _db -> where($data) -> save($data);
//        }
    }

    public function find($id){
        if(!$id || !is_numeric($id)){
            return 0;
        }else{
            return $this -> _db -> where('menu_id='.$id) ->find();
        }
    }

    public function updateMenubyId($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception("更新的数据不合法");
        }
        return $this -> _db -> where('menu_id='.$id) -> save($data);
    }

    //通过status删除菜单记录
    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if(!$status || !is_numeric($status)){
            throw_exception("status不合法");
        }
        $data['status'] = $status;
        return $this -> _db -> where('menu_id='.$id) -> save($data);
    }

    //更新排序
    public function updateMenuListorderById($id,$listorder){
        if(!$id || !is_numeric($id)){
            throw_exception("id不合法");
        }
        $data = array(
          'listorder' => $listorder
        );
        return $this -> _db -> where('menu_id='.$id) -> save($data);
    }

    //菜单列表分页
        //每一页的数据
    public function getMenus($data,$page,$pageSize=10){
        $data['status'] = array('neq',-1); //where条件就是 status<>-1
        $offset = ($page-1)*$pageSize;
        //如果order里面有两个desc 优先第一个排序完后再排序第二个
        $list = $this -> _db -> where($data) -> order('listorder desc,menu_id desc') -> limit($offset,$pageSize) ->select();
        return $list;
    }
        //菜单总共的数目
    public function getMenusCount($data){
        $data['status'] = array('neq',-1); //where条件就是 status<>-1
        $menuCount = $this -> _db ->where($data) ->count();
        return $menuCount;
    }

    //获取前端导航的内容
    public function getFrontMenus(){
        $data = array(
            'status' => array('neq',-1),
            'type' => 0
        );
        $res = $this -> _db -> where($data) -> order('listorder desc,menu_id desc') ->select();
        return $res;
    }

}
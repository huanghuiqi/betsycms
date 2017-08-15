<?php
namespace Common\Model;
use Think\Model;

class PositionContentModel extends Model{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('PositionContent');
    }

    public function insert($data){
        if(!$data || !is_array($data)){
            throw_exception('data数据有误');
        }
        return $this->_db->add($data);
    }

    public function getNews($data=array()){
        //$data['status'] = array('neq',-1);
        return $this->_db->where($data)->select();
    }

    //搜索
    public function select($data = array()){
        if($data['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        return $this->_db->where($data)->order('listorder desc,id desc')->select();
    }

    //id获取数据
    public function find($id){
        if(!$id || !is_numeric($id)){
            throw_exception('id有误');
        }
        return $this->_db->where('id='.$id)->find();
    }

    public function updateById($id,$data){
        if(!$id || !is_numeric($id)){
            return 0;
        }
        if(!$data || !is_array($data)){
            return 0;
        }
        $data['update_time'] = time();
        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            throw_exception('id不合规范');
        }
        if(!$status || !is_numeric($status)){
            throw_exception('status不合规范');
        }
        $data['status'] = $status;
        return $this->_db->where('id='.$id)->save($data);
    }
}
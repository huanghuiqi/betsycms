<?php
namespace Common\Model;
use Think\Model;

class PositionModel extends Model{
    private $_db = '';
    public function __construct()
    {
        $this -> _db = M('position');
    }

    public function select($data = array()){
        $condition = $data;
        $list = $this->_db->where($condition)->select();
        return $list;
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

    public function insert($data){
        if(!is_array($data) || !$data){
            return 0;
        }
        $data['create_time'] = time();
        return $this->_db->add($data);
    }

    public function find($id){
        if(!$id || !is_numeric($id)){
            return 0;
        }
        return $this->_db->find($id);
    }

    public function updatePositionById($id,$data){
        if(!$id || !is_numeric($id)){
            return 0;
        }
        if(!$data || !is_array($data)){
            return 0;
        }
        $data['update_time'] = time();
        return $this->_db->where('id='.$id)->save($data);
    }

    //获取正常的推荐位内容
    public function getNormalPosition(){
        return $this->_db->where('status=1')->select();
    }
}
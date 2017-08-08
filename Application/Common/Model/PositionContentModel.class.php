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
}
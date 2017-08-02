<?php
namespace Common\Model;
use Think\Model;

//文章管理这块
class NewsContentModel extends Model
{
    private $_db = '';
    public function __construct()
    {
        $this -> _db = M('news_content');
    }

    public function insert($data = array()){
        if(!is_array($data) || !$data){
            return 0;
        }
        $data['create_time'] = time();
        if(isset($data['content']) && $data['content']){
            //转化为html格式
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this -> _db -> add($data);
    }

    //根据id获取一条数据
    public function find($id){
        if(!$id || !is_numeric($id)){
            return 0;
        }
        return $this->_db->where('news_id='.$id)->find();
    }

    //更新信息
    public function updataNewsContentById($data,$id){
        if(!$id || !is_numeric($id)){
            throw_exception('id不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新数据不合法');
        }
        if(isset($data['content']) && $data['content']){
            $data['content'] = htmlspecialchars($data['content']);
        }

        return $this->_db->where('news_id='.$id)->save($data);
    }
}
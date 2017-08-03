<?php
namespace Common\Model;
use Think\Model;

//文章管理这块 新闻内容主表，考虑到太庞大故另外创建一个简化的NewsContent新闻副表来进行内容查询
class NewsModel extends Model
{
    private $_db = '';
    public function __construct()
    {
        $this -> _db = M('news');
    }

    public function insert($data = array()){
        if(!is_array($data) || !$data){
            return 0;
        }
        $data['create_time'] = time();
        $data['username'] = getLoginUsername();

        return $this -> _db -> add($data);
    }

    //获取x页列表内容
    public function getNews($data,$page,$pageSize=10){
        $condition='';
        if(isset($data['title']) && $data['title']){
            $condition['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $condition['catid'] = $data['catid'];
        }
        $offset = ($page - 1)*$pageSize;
        $list = $this->_db->where($condition)->order('listorder desc,news_id desc')->limit($offset,$pageSize)->select();
        //echo $this->_db->getLastSql();
        return $list;
    }

    //获取x页新闻数量
    public function getNewsCount($data = array()){
        $condition='';
        if(isset($data['title']) && $data['title']){
            $condition['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $condition['catid'] = intval($data['catid']);
        }
        return $this->_db->where($condition)->count();
    }

    //根据id获取一条数据
    public function find($id){
        if(!$id || !is_numeric($id)){
            return 0;
        }
        return $this->_db->where('news_id='.$id)->find();
    }

    //更新信息
    public function updataNewsById($data,$id){
        if(!$id || !is_numeric($id)){
            throw_exception('id不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新数据不合法');
        }
        return $this->_db->where('news_id='.$id)->save($data);
    }

    //删除
    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            throw_exception('id不合法');
        }
        if(!$status || !is_numeric($status)){
            throw_exception('ststus值不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('news_id='.$id)->save($data);
    }
}
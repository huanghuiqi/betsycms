<?php
namespace Common\Model;
use Think\Model;

//文章管理这块 新闻内容主表，考虑到太庞大故另外创建一个简化的NewsContent新闻副表来进行内容查询
class NewsConModel extends Model
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
        if(isset($data['content']) && $data['content']){
            //转化为html格式
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this -> _db -> add($data);
    }
}
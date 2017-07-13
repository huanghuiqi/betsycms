<?php
namespace Common\Model;

use Think\Model;

class AdminModel extends Model{
    private $_db = '';
    public function __construct()
    {
        //实例化admin这个表  配置文件db.php已经给所有表添加了前缀，所以这李不需要添加
        $this->_db = M('Admin');
    }

    public function getAdminByUsername($username){
        $ret = $this->_db->where('username="'.$username.'"')->find();
    }
}
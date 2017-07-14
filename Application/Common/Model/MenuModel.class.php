<?php
namespace Common\Model;

use Think\Model;

class MenuModel extends Model{
    private $_db = '';
    public function __construct()
    {
        $this -> _db = M('menu');
    }

    public function getAdminMenus(){
        $data = array(
          'status' => array('neq',-1),   //neq 不等于-1的意思
          'type' => 1
        );

        return $this -> _db -> where($data) -> order('listorder desc,menu_id desc') -> select();
    }

}
<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ContentController extends CommonController{
    public function index(){
        $this->display();
    }

    public function add(){
        $this->display();
    }
}
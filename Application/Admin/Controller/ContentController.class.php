<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ContentController extends CommonController{
    public function index(){
        $this->display();
    }

    public function add(){
        //获取前端导航
        $webSiteMenus = D('Menu')->getFrontMenus();
        //标题颜色
        $titleFontColor = C('TITLE_FONT_COLOR');  //配置文件声明用C()
        //来源
        $copyFrom = C('COPY_FROM');

        $this->display();
    }
}
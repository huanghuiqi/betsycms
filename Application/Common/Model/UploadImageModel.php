<?php

namespace Common\Model;

use Think\Model;

class UploadImageModel extends Model{
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    public function __construct()
    {
        $this->_uploadObj = new \Think\Upload();  //实例化think自带的upload类
        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';  //存放图片文件的位置
        $this->_uploadObj->subName = date(Y).'/'.date(m).'/'.date(d);  //存放的名字
    }

    public function imageUpload(){

    }
}
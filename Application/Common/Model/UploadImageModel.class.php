<?php
namespace Common\Model;
use Think\Model;

/**
 * 上传图片类
 * @author  singwa
 */
class UploadImageModel extends Model {
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    public function __construct() {
        $this->_uploadObj = new  \Think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y) . '/' . date(m) .'/' . date(d);
    }

    //针对编辑器kindEditor的图片上传
    public function upload() {
        $res = $this->_uploadObj->upload();

        if($res) {
            return __ROOT__.'/' .self::UPLOAD . '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
        }else{
            return false;
        }
    }

    //针对图片的上传
    public function imageUpload() {
        $res = $this->_uploadObj->upload();
        /*
         * Array
        (
         [file] => Array
        (
        [name] => 信息技术部-黄慧淇.jpg
        [type] => image/jpeg
        [size] => 24485
        [key] => file
        [ext] => jpg
        [md5] => 1e4027d7f7868ed032149dc969e21e9c
        [sha1] => af1400d5f7bb3ac9b1f97d685b4f94b88baa62dc
        [savename] => 597ecc83dcd88.jpg
        [savepath] => 2017/07/31/
        )
        )
         * */

        if($res) {
            return __ROOT__.'/' .self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
        }else{
            return false;
        }
    }
}

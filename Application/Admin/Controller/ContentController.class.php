<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ContentController extends CommonController{
    public function index(){
        //栏目下拉列表内容
        $webSiteMenus = D('Menu')->getFrontMenus();
        $this->assign('webSiteMenus',$webSiteMenus);

        //搜索功能
        $conds = '';
        if($_GET['title']){
            $conds['title'] = $_GET['title'];
        }
        if($_GET['catid']){
            $conds['catid'] = $_GET['catid'];
        }

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 2;   //默认10
        $conds['status'] = array('neq',-1);
        $newsList = D('News') -> getNews($conds,$page,$pageSize);
        $newsCount = D('News') -> getNewsCount($conds);
        //print_r($newsList);

        $res = new \Think\Page($newsCount,$pageSize);
        $pageRes = $res -> show();

        $this->assign('pageres',$pageRes);
        $this->assign('news',$newsList);

        $this->display();
    }

    public function add(){
       if($_POST){
           //提交数据
           if(!isset($_POST['title']) || !$_POST['title']){
               return show(0,'标题不存在');
           }

           if(!isset($_POST['small_title']) || !$_POST['small_title']){
               return show(0,'短标题不存在');
           }

           if(!isset($_POST['catid']) || !$_POST['catid']){
               return show(0,'文章栏目不存在');
           }

           if(!isset($_POST['title']) || !$_POST['title']){
               return show(0,'标题不存在');
           }

           if(!isset($_POST['keywords']) || !$_POST['keywords']){
               return show(0,'关键字不存在');
           }

           if(!isset($_POST['content']) || !$_POST['content']){
               return show(0,'文章内容不存在');
           }

           if(!isset($_POST['description']) || !$_POST['description']){
               return show(0,'描述不存在');
           }

           //更新操作
           if($_POST['news_id']){
               return $this->save($_POST);
           }

           $newsID = D('News')->insert($_POST);
           //再插入一份到副表
            if($newsID){
                $newContentData['content'] = $_POST['content'];
                $newContentData['news_id'] = $newsID;
                $cID =  D('NewsContent')->insert($newContentData);
                if($cID){
                    return show(1,'新增成功');
                }else{
                    return show(1,'主表插入成功，副表插入失败');
                }
                return show(1,'插入成功');
            }else{
                return show(0,'新增失败');
            }

       }else{
           //获取前端导航
           $webSiteMenus = D('Menu')->getFrontMenus();
           //标题颜色
           $titleFontColor = C('TITLE_FONT_COLOR');  //配置文件声明用C()
           //来源
           $copyFrom = C('COPY_FROM');

           //赋值给模板
           $this->assign('webSiteMenus',$webSiteMenus);
           $this->assign('titleFontColor',$titleFontColor);
           $this->assign('copyFrom',$copyFrom);
       }

        $this->display();
    }

    public function edit(){
        $newsID = $_GET['id'];
        if(!$newsID){
            $this->redirect('admin.php?c=content');
        }

        $news = D('News')->find($newsID);
        if(!$news){
            $this->redirect('admin.php?c=content');
        }

        $newsContent = D('NewsContent')->find($newsID);
        if($newsContent){
            $news['content'] = $newsContent['content'];
        }


        $webSiteMenus = D('Menu')->getFrontMenus();
        $this->assign('news',$news);
        $this->assign('webSiteMenus',$webSiteMenus);
        $this->assign('titleFontColor',C('TITLE_FONT_COLOR'));
        $this->assign('copyFrom',C('COPY_FROM'));

        $this->display();
    }

    public function save($data){
        $newsID = $data['news_id'];
        unset($data['news_id']);

        try{
            $id = D('News')->updataNewsById($data,$newsID);
            $newsContentData['content'] = $data['content'];
            $contentId = D('NewsContent')->updataNewsContentById($newsContentData,$newsID);
            if($id === false || $contentId===false){
                show(0,'更新失败');
            }else{
                return show(1,'更新成功');
            }
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
    }

    public function setStatus(){
        try{
            if($_POST){
                $newsID = $_POST['id'];
                $status = $_POST['status'];
                $res = D('News')->updateStatusById($newsID,$status);
                if($res){
                    return show(1,'操作成功');
                }else{
                    return show(0,'操作失败了~');
                }
            }
            return show(0,'没有提交内容');
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
    }

    //排序
    public function listorder(){
        $listorder = $_POST['listorder'];
        $error = [];
        if($listorder){
            try{
                foreach ($listorder as $newID=>$listVal){
                    $id = D('News')->updateListorderById($newID,$listVal);
                    if($id === false){
                        $error[] = $id;
                    }
                }
            }catch(Exception $e){
                return show(0,$e->getMessage());
            }
            if($error){
                return show(0,'排序失败 '.implode($error,','));
            }else{
                return show(1,'更新排序成功');
            }
        }
        return show(0,'更新排序失败');
    }
}
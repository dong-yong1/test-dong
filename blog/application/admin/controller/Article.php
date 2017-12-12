<?php
namespace app\admin\controller;

use app\common\model\ArticleModel;
use app\common\model\TypeModel;
class Article extends Base{
    public function index(){
        $art = new ArticleModel();
        $res = $art->paginate(10);        
        //dump($res);exit;
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function add(){ 
        $type = new TypeModel();
        $type = $type->select();
        $this->assign('type',$type);
        return $this->fetch();
    }
    
    public function save(){
        $acc = $this->request->param();
        //dump($acc);exit;
        $create_time = time();
        $acc['create_time'] = $create_time;
        //dump($acc);exit;
        $file = $this->request->file('img');      
        //dump($file);exit;        
        if ($file){
            $filenew = $file->move(ROOT_PATH.'/public/static/upload/');
            //dump($art);exit;
            if ($filenew){
                $imgname = $filenew->getSaveName();
                $acc['imgname'] = $imgname;
                //dump($imgname);exit;               
            }            
        }
        $art = new ArticleModel();
        //dump($acc);exit;
        $res = $art->save($acc);
        //dump($res);exit;
        if ($res){
            $this->success("添加成功",'article/index');
        }else{
            $this->error("添加失败");
        }       
    }
    
    public function update(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $art = new ArticleModel();
        $art = $art->where('id',$id)->find();
        //dump($art);exit;
        $type = new TypeModel();
        $type = $type->where('fid','0')->select();
        $this->assign('type',$type);
        $this->assign('art',$art);
        return $this->fetch();
    }
    
    
    public function usave(){
        $arr = $this->request->param();
        $id = $arr['id'];
        $ref = $arr['ref'];
        $file = $this->request->file('imgname');
        //dump($arr);exit;
        if ($file){
            $info = $file->move(ROOT_PATH.'public/static/upload/');
            if ($info){
                $newimg = $info->getSaveName(); 
                $arr['imgname'] = $newimg;
            }
        }
        
        //dump($arr);exit;
        $art = new ArticleModel();
        unset($arr['visibility']);
        unset($arr['create_time']);
        unset($arr['ref']);
        $res = $art->where('id',$id)->update($arr);
        if ($res){
            $this->success("修改成功",$ref);
        }else{
            $this->error("修改失败");
        }
    }
    
    //删除文章
    public function del(){
        $id = $this->request->param('id');
        //dump($id);
        $art = new ArticleModel();
        $res = $art->where('id',$id)->delete();
        //dump($res);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->redirect($ref);
            //$this->success('删除成功');
        }else{
            $this->error("删除失败");
        }                       
    }
    
    public function delAll(){
            $arr = $this->request->param();
            //dump($arr);exit;
            if ($arr){
                $v = $arr['checkbox'];
                $id=implode(',',$v);
                //dump($id);exit;
                $art = new ArticleModel();
                $ref = $_SERVER['HTTP_REFERER'];
                //dump($id);exit;
                $res = $art->where('id',$id)->delete($id);
                if ($res){
                    $this->success("删除成功",$ref);
                }else{
                    $this->error("删除失败");
                }
            }else{
                $this->error("请点击选中删除");
            }      
        }
    
    //文章的推荐
    public function recom(){
        $id = $this->request->param('id');
        $art = new ArticleModel(); 
        $res = $art->where('id',$id)->update(['state'=>'1']);
        $ref = $_SERVER["HTTP_REFERER"];        
        if ($res){
            return $this->success("推荐成功",$ref);
        }else{
            return $this->error("推荐失败");
        }
    }
    
    //文章推荐的取消
    public function unrecom(){
        $id = $this->request->param('id');
        $art = new ArticleModel();
        $res = $art->where('id',$id)->update(['state'=>'0']);
        $ref = $_SERVER["HTTP_REFERER"];
        if ($res){
            return $this->success("取消成功",$ref);
        }else{
            return $this->error("取消失败");
        }
    }
    
    
    
    
    
    
}
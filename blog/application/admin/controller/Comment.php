<?php
namespace app\admin\controller;
use app\common\model\CommentModel;

class Comment extends Base{
    public function index(){
        $com = new CommentModel();
        //dump($com);exit;
        $res = $com->paginate(5);              
        $this->assign('res',$res);
        return $this->fetch();
    }
    
    public function readCom(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $com = new CommentModel();
        $ob = $com->where('id',$id)->find();
        //dump($ob);exit;
        $this->assign("ob",$ob);
        return $this->fetch();
    }
    
    
    public function del(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $com = new CommentModel();
        $res = $com->where('id',$id)->delete();
        if ($res){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }        
    }
    
    public function delAll(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $rows = $arr['checkbox'];
        $idstr = implode(',', $rows);
        //dump($idstr);
        $com = new CommentModel();
        $res = $com->where('id',$idstr)->delete($idstr);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->success("删除成功",$ref);
        }else{
            $this->error("删除失败");
        }
    }
    
    
    
    
    
    
    
    
    
}
<?php
namespace app\index\controller;
use app\common\model\ArticleModel;
use app\common\model\CommentModel;


class Index extends Base{
    public function index(){
        $ar = new ArticleModel();
        $art = $ar->where('state','0')->where('typeid','0')->paginate(5);
        $recom = $ar->order('id desc')->where('state','1')->limit(5)->select();
        //dump($recom);exit;
        $this->assign("art",$art);
        $this->assign("recom",$recom);
        //dump($con);exit;  
        //$arr = $com->group('aid')->count();
        //dump($arr);exit;
       
        return $this->fetch();
    }
    
    //文章的详细页
    public function detail(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $com = new CommentModel();
        $comnum = $com->getcomnum($id);                
        $comusernum = $com->getcomusernum($id);
        //dump($comnum);exit;
        $art = new ArticleModel();
        $recom = $art->order('id desc')->where('state','1')->limit(5)->select();
        $this->assign("recom",$recom);
        $res = $art->where('id',$id)->find();
        //dump($res->author);exit;
        $this->assign("comnum",$comnum);
        $this->assign("comusernum",$comusernum);
        $this->assign("res",$res);
        return $this->fetch();
    }
   
}
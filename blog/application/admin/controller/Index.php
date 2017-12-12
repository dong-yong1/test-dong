<?php
namespace app\admin\controller;
use app\common\model\UsersModel;
use app\common\model\LogrecordModel;
use think\Session;
use app\common\model\ArticleModel;
use app\common\model\CommentModel;
use app\common\model\FriendModel;
use app\common\model\MsgModel;

class Index extends Base{
    public function index(){
        $uid = Session::get('id');        
        $log = new LogrecordModel();
        $log = $log->where('uid',$uid)->order('id desc')->limit(1)->find();
        $this->assign("log",$log);
        //dump($log);exit;
        
        $art = new ArticleModel();
        $artNum = $art->getArtNum();
        $this->assign("artNum",$artNum);
        $com = new CommentModel();
        $comNum = $com->getComAllNum();
        $this->assign("comNum",$comNum);
        $fri = new FriendModel();
        $friNum = $fri->getFriNum();
        $this->assign("friNum",$friNum);
        
        $msg = new MsgModel();
        $msgNum = $msg->msgNum();
        $this->assign("msgNum",$msgNum);
        //dump($artNum);exit;
        $user = new UsersModel();                      
        $num = $user->where('isadmin','1')->count();
        $this->assign("num",$num);
        
        //dump($num);exit;
        return $this->fetch();
    }
}
<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\ConfigModel;
use app\common\model\FriendModel;
use app\common\model\ArticleModel;
class Base extends Controller{
    public function _initialize(){
        //备案号的获取
        $con = new ConfigModel();;
        $con = $con->where('id',1)->find();
        $this->assign("con",$con);
        $fr = new FriendModel();
        $fr = $fr->select();
        $this->assign("fr",$fr);
        $ar = new ArticleModel();
        $rows = $ar->getuserart();
        $this->assign("rows",$rows);
    }
}
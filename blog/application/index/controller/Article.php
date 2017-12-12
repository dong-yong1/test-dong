<?php
namespace app\index\controller;

use app\common\model\CommentModel;
use think\Session;
use app\common\model\UsersModel;
class Article extends Base{
    
    //文章评论
    public function comArticle(){
        if(!Session::has('id')){
            //判断用户名密码是否正确
            $username=$this->request->param('username');
            $password=$this->request->param('password');
            //dump($password);exit;
            $user=new UsersModel();
            $user=$user->where('username','=',$username)
            ->where('password','=',$password)
            ->find();
            //dump($user);exit;
            if($user){
                Session::set('username',$user->username);
                Session::set('id',$user->id);
                $userid=$user->id;
                $username=$user->username;                 
            }else{//登录失败
                $this->error("发表失败");
            }
        }else{
            $userid=Session::get('id');
            $username=Session::get('username');
        }

        $arr = $this->request->param();
        $id = session('id');
        
        $user = new UsersModel();
        $user = $user->where('id',$id)->find();
        $username = $user->username;
        //dump($username);exit;
        $arr['username'] = $username;      
        //dump($arr);exit;
        $arr['ctime'] = time();
        $arr['ip'] = $_SERVER['REMOTE_ADDR'];
        //dump($arr);exit;
        $com = new CommentModel();
        $res = $com->allowField(true)->save($arr);
        if ($res){
            $this->success("评论成功");
        }else{
            $this->error("评论失败");
        }
    }
}
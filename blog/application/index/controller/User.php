<?php
namespace app\index\controller;
use app\common\model\UsersModel;
use think\Session;
use app\common\model\DiaryModel;
use app\common\model\UserinfoModel;
use app\common\model\ArticleModel;
use app\common\model\MsgModel;
class User extends Base{
    public function regist(){
        $arr = $this->request->param();
        $user = new UsersModel();
        $res = $user->allowField(true)->save($arr);
        if($res){
            $this->success("注册成功",'login');
        }else{
            $this->error("注册失败");
        }
    }
    
    public function login(){
        return $this->fetch();
    }
    
    public function loginDo(){
        $userinfo = $this->request->param();
        $res = UsersModel::where("username","EQ",$userinfo['username'])
               ->where("password","EQ",$userinfo['password'])
               ->where('state','0')
               ->find();
        //dump($res->id);exit;
        if($res){            
            Session::set("username",$userinfo["username"]);
            Session::set("id",$res->id);
            $user = new UsersModel();
            //$user->where('id',$res->id)->setInc('logcount');
            $save = $user->where('id',$res->id)->update(["status"=>1,"logcount"=>$res->logcount+1]);
            $this->success("登录成功","index/index/index");
        }else{
            $this->error("登陆失败");
        }
    }
    public function logout(){
        $user = new UsersModel();
        $id = Session::get("id");
        $user->where('id',$id)->update(["status"=>0]);
        Session::delete("username");
        Session::delete("id");        
        //跳转回首页
        $this->redirect("index/index/index");
    }
    
    //关于我页面
    public function about(){  
            $art = new ArticleModel();
            $art = $art->where('typeid','1')->where('state','0')->find();
            //dump($art);exit;
            $this->assign('art',$art);
            //dump($art);exit;
            $my = new UserinfoModel();
            $my = $my->where('state',0)->find();
            $this->assign('my',$my);            
            return $this->fetch();                   
    }
    
    //日志界面
    public function diary(){ 
            $date = new DiaryModel();
            $date = $date->where('state',0)->order('id desc')->select();
            $this->assign('date',$date);
           
            return $this->fetch();  
    }
    public function phpend(){
        $art = new ArticleModel();
        $recom = $art->order('id desc')->where('state','1')->limit(5)->select();
        $art = $art->where('typeid','3')->where('state','0')->paginate(4);
        $this->assign("recom",$recom);
        $this->assign('art',$art);        
        return $this->fetch();       
    }
    public function summary(){
        $art = new ArticleModel();
        $recom = $art->order('id desc')->where('state','1')->limit(5)->select();       
        $this->assign("recom",$recom);
        $art = $art->where('typeid','4')->where('state','0')->paginate(4);
        $this->assign('art',$art);
        
        return $this->fetch();       
    }
    public function gustbook(){
        $user = Session::get("username");
        if ($user){
            $art = new ArticleModel();
            $recom = $art->order('id desc')->where('state','1')->limit(5)->select();           
            $this->assign("recom",$recom);
            //获取留言信息
            $msg = new MsgModel();
            $mnum = $msg->msgNum();
            $msg = $msg->order('id desc')->paginate(5);
            //dump($mnum);exit;
            $this->assign('mnum',$mnum);
            $this->assign('msg',$msg);
            
            return $this->fetch();
        }else{
            $this->error("请先完成登录",'index/user/login');
        } 
    }
    
    public function saveGust(){
        $arr = $this->request->param();        
        $username = Session::get("username");
        $gtime = time();
        //dump($username);
        $ip = $_SERVER['REMOTE_ADDR'];
        $msg = new MsgModel();
        $arr['username'] = $username;
        $arr['gtime'] = $gtime;
        $arr['ip'] = $ip;
        //dump($arr);exit;
        $res = $msg->save($arr);
        if ($res){
            $this->success("留言成功","user/gustbook");
        }else{
            $this->error("留言失败");
        }
    }
    
    
    
    
    
    
    
    
    
    
}
<?php
namespace app\admin\controller;

use app\common\model\FriendModel;
use app\common\model\MsgModel;
class Others extends Base{
    public function index(){
        $fr = new FriendModel();        
        $friend = $fr->paginate(5); 
        //dump($friend);exit;
        $this->assign("friend",$friend);
        return $this->fetch();
    }
    //访问记录
    public function loginLog(){
        $msg = new MsgModel();
        $msg = $msg->paginate(5);
        $this->assign("msg",$msg);
        return $this->fetch();
    }
    
    public function addFlink(){    
        $time= time();        
        $this->assign("time",$time);
        
        return $this->fetch();
    }
    
    public function save(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $fr = new FriendModel();
        $res = $fr->save($arr);
        if ($res){
            $this->success("添加成功","others/index");
        }else{
            $this->error("添加失败");
        }
    }
    
    public function update(){
        $uptime=time();
        $id = $this->request->param('id');
        //dump($id);exit;
        $fr = new FriendModel();
        $fr = $fr->where('id',$id)->find();
        
        //dump($fr);exit;
        $this->assign("uptime",$uptime);
        $this->assign("fr",$fr);                
        return $this->fetch();
    }
    
    public function usave(){
        $arr = $this->request->param();
        //dump($arr);exit;       
        $id = $arr['id'];        
        //dump($arr);exit;
        $fr = new FriendModel();
        $res = $fr->where('id',$id)->update($arr);           
        if ($res){
            $this->success("修改成功","others/index");
        }else{
            $this->error("修改失败");
        }    
    }
    
    public function del(){
        $id = $this->request->param("id");
        //dump($id);
        $fr = new FriendModel();
        $res = $fr->where('id',$id)->delete();
        //dump($res);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->redirect($ref);
        }else{
            $this->error("删除失败");
        }    
    }
    //删除多条友情链接
    public function delAll(){
        $arr = $this->request->param();
        //dump($arr);exit;
        if ($arr){
            $checkid = $arr['checkbox'];        
            $id = implode(",",$checkid);
            //dump($id);exit;
            $fr = new FriendModel();    
            $ref = $_SERVER['HTTP_REFERER'];
            //dump($id);exit;
            $res = $fr->where('id',$id)->delete($id);
            //dump($res);exit;           
            if ($res){
                $this->success("删除成功",$ref);
            }else{
                $this->error("删除失败");
            }
        }else{
            $this->error("请选中删除");
        }   
    }
    
    //删除单用户的访问记录
    public function delVisitOne(){
        $id = $this->request->param('id');
        //dump($id);
        $log = new MsgModel();
        $res = $log->where('id',$id)->delete();
        //dump($res);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->redirect($ref);
        }else{
            $this->error('删除失败');
        }
    }    
    
    //删除所有访问用户的登录记录
    public function delVisitAll(){
        $log = new MsgModel();
        $res = $log->where('1=1')->delete();
        if ($res){
            $this->success('清除成功');
        }else{
            $this->error('清除失败');
        }
         
    }
    
    
    
    
    
    
    
    
    
}
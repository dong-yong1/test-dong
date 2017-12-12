<?php
namespace app\admin\controller;

use app\common\model\MsgModel;

class Message extends Base{
    public function msg(){
        $msg = new MsgModel();        
        $msg = $msg->paginate(5);
        //dump($msg);exit;
        $this->assign("msg",$msg);
        return $this->fetch();
    }
    
    public function showmsg(){
        $id = $this->request->param('id');
        //dump($id);
        $msg = new MsgModel();
        $ob = $msg->where('id',$id)->find();
        $this->assign("ob",$ob);
        return $this->fetch();
    }
    
    public function del(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $com = new MsgModel();
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
        $com = new MsgModel();
        $res = $com->where('id',$idstr)->delete($idstr);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->success("删除成功",$ref);
        }else{
            $this->error("删除失败");
        }
    }
    
    
}
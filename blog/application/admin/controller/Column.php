<?php
namespace app\admin\controller;
use app\common\model\TypeModel;


class Column extends Base{
    public function index(){
        $type = new TypeModel();
        $arr = $type->where('fid','0')->select();
        $str = $type->showOption();                         
        $this->assign("str",$str);
        $this->assign("arr",$arr);
        return $this->fetch();
    }
    
    public function add(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $type = new TypeModel();
        $res = $type->allowField(true)->save($arr);
        if ($res){
            $this->success("添加成功","column/oper");
        }else{
            $this->error("添加失败");
        }
        
    }
    
    public function oper(){
        $type = new TypeModel();
        $arr = $type->where('fid','0')->select();
        $str = $type->showOption();                         
        $this->assign("str",$str);
        $this->assign("arr",$arr);
        return $this->fetch('column/index');                
    }
    
    public function update(){
        $id = $this->request->param('id');
        //dump($id);exit;
        $type = new TypeModel();
        $type = $type->where('id',$id)->find();
        //dump($type);exit;
        $str = $type->showOption();
        //dump($str);exit;
        $this->assign('str',$str);
        $this->assign('type',$type);        
        return $this->fetch();
    }
    
    public function updatedo(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $id = $arr['id'];
        $type = new TypeModel();
        $res = $type->where('id',$id)->update($arr);
        
        if ($res){
            $this->success("修改成功",'column/index');
        }else{
            $this->error("修改失败");
        }        
    }
    
    public function del(){
        $id = $this->request->param('id');        
        //dump($id);
        $type = new TypeModel();
        $res = $type->where('id',$id)->delete();
        if ($res){
            $this->redirect("column/index");
        }else{
            $this->error("删除失败");
        }
    }
    
    
    
    
    
    
    
    
    
    
    
}
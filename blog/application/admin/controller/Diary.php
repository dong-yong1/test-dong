<?php
namespace app\admin\controller;


use app\common\model\DiaryModel;

class Diary extends Base{
    
    public function diaryShow(){
        $diary = new DiaryModel();
        $day = $diary->order('id desc')->paginate(5);
        $this->assign("day",$day);
        return $this->fetch();
    }
    public function add(){
        $time = time();
        $this->assign("time",$time);
        return $this->fetch();
    }
    
    public function save(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $diary = new DiaryModel();
        $res = $diary->save($arr);
        //dump($res);
        if ($res){
            $this->success("添加成功",'diary/diaryshow');
        }else{
            $this->error("添加失败");
        }        
    }
    
    public function update(){
        $id = $this->request->param('id');
       //dump($id);
        $day = new DiaryModel();
        $res = $day->where('id',$id)->find();
        $time = time();
        $this->assign('res',$res);
        $this->assign('time',$time);
        return $this->fetch();
    }
    
    public function usave(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $id = $arr['id'];
        $date = new DiaryModel();
        $res = $date->where('id',$id)->update($arr);
        if ($res){
            $this->success("修改成功","diary/diaryshow");
        }else{
            $this->error("修改失败");
        }
    }
    
    //删除文章
    public function del(){
        $id = $this->request->param('id');
        //dump($id);
        $art = new DiaryModel();
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
            $date = new DiaryModel();
            $ref = $_SERVER['HTTP_REFERER'];
            //dump($id);exit;
            $res = $date->where('id',$id)->delete($id);
            if ($res){
                $this->success("删除成功",$ref);
            }else{
                $this->error("删除失败");
            }
        }else{
            $this->error("请点击选中删除");
        }
    }
    
    
    
    
    
    
    
    
}
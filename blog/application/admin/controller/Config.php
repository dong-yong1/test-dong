<?php
namespace app\admin\controller;
use app\common\model\ConfigModel;

class Config extends Base{
    public function setting(){
        $con = new ConfigModel();
        $res = $con->find();
        //dump($res);exit;
        $this->assign('res',$res);
        return $this->fetch();
    }
    
    public function save(){
        $arr = $this->request->param();
        $con = new ConfigModel();
        $res = $con->where('id',1)->update($arr);
        if ($res){
            $this->success("修改成功","config/setting");
        }else{
            $this->error("修改失败");
        }
    }
    
    
}
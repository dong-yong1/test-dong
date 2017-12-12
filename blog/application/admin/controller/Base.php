<?php
namespace app\admin\controller;
use app\common\model\UsersModel;
use think\Session;
use think\Controller;

class Base extends Controller{
    public function _initialize(){
        $id = Session::get('id');
        //dump($id);exit;
        $user = new UsersModel();
        //dump($str);exit;
        $res = $user->where('id',$id)->find();
        $this->assign("user",$res);
        if(empty(session('id'))){
            //session下的isadmin的值为空,说明不是管理员 则跳转到登录页面;admin/user/login
            $this->redirect('login/login');
        }
    }
}
<?php
namespace app\admin\controller;
use app\common\model\UsersModel;
use app\common\model\LogrecordModel;
use think\Session;
use app\common\model\UserinfoModel;
use function think\where;
class User extends Base{
    public function index(){
        $guser = new UsersModel();
        $guser = $guser->where('isadmin','0')->select();        
        //dump($guser);exit;
        $this->assign("guser",$guser);        
        return $this->fetch();
    }
    
    //用户登录记录
    public function loginLog(){
        $log = new LogrecordModel();
        $log = $log->paginate(10);
        $this->assign('log',$log);        
        return $this->fetch();
    }
    
    //个人信息的修改
    public function per(){
        $arr = $this->request->param();
        $id = $arr['id'];
        
        //dump($arr);exit;
        if ($arr['old_password']==$arr['password']){
            $this->error('新密码不能与原密码相同');
        }else{
            if ($arr['password']!==$arr['new_password']){
                $this->error("新密码与确认密码不正确");
            }else{
                $user = new UsersModel();
                $res = $user->allowField(true)->validate(true)->save($arr,['id'=>$id]);
                //dump(Users::getLastSql());exit;
                //dump($res);
                if ($res){
                    $this->success("修改成功",'login/loginout');
                }else{
                    $this->error($user->getError());                
                }
            }  
        }             
    }
    
    //删除单用户的登录记录
    public function del(){
        $id = $this->request->param('id');      
        //dump($id);
        $log = new LogrecordModel();
        $res = $log->where('id',$id)->delete();  
        //dump($res);
        $ref = $_SERVER['HTTP_REFERER'];
        if ($res){
            $this->redirect($ref);
        }else{
            $this->error('删除失败');
        }  
    }
    
    //删除某在线用户的登录记录
    public function delSelf(){ 
        $username = Session::get('username');
        //dump($username);exit;
        $log = new LogrecordModel();
        $res = $log->where('username',$username)->delete();
        //dump($res);
        if ($res){
            $this->success('清除成功');
        }else{
            $this->error('清除失败');
        }
       
    }
    
    //删除所有用户的登录记录
    public function delAll(){        
        $log = new LogrecordModel();
        $res = $log->where('1=1')->delete();
        //dump($res);exit;
        if ($res){
            $this->success('清除成功');
        }else{
            $this->error('清除失败');
        }
         
    }
    
    //新增用户
    public function addUser(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $pwd = $arr['password'];
        $firm_pwd = $arr['new_password'];        
        $user = new UsersModel(); 
        $res = $user->allowField(true)->save($arr);
        //dump($res);
        if ($pwd==$firm_pwd){
            $this->success("增加成功","user/index");
        }else{
            $this->error("增加失败");
        }        
    }
    
    //删除用户
    public function delUser(){
        $id = $this->request->param('id');
        //dump($id);
        $user = new UsersModel();
        $u = $user->where('id',$id)->find();        
        $username = $u->username;
        //dump($username);   
        $res = $user->where('id',$id)->delete();
        
        if ($res){
            $log = new LogrecordModel();//删除该用户的所有登录信息
            $logall = $log->where('username',$username)->delete(); 
            //dump($logall);exit;
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }        
    }
    
    //禁用某用户的权限
    public function unUser(){
        $id = $this->request->param('id');
        //dump($id);exit
        $user = new UsersModel();

        $res = $user->where('id',$id)->update(['state'=>'1']);
        //dump($res);exit;
        if ($res){
            $this->success("禁用成功");
        }else{
            $this->success("禁用失败");
        }
    }
    
    //解禁某用户的权限
    public function reUser(){
        $id = $this->request->param('id');
        //dump($id);
        $user = new UsersModel();    
        $res = $user->where('id',$id)->update(['state'=>'0']);
        //dump($res);
        if ($res){
            $this->success("启用成功");
        }else{
            $this->success("启用失败");
        }
    }
    
    //用户的详细信息
    public function detail(){
        $user = new UserinfoModel();
        $uinfo = $user->where('state',0)->select();
        $this->assign('uinfo',$uinfo);
        return $this->fetch();
    }
    
    //新增用户的详细信息
    public function upuser(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $uinfo = new UserinfoModel();
        $res = $uinfo->save($arr);
        //dump($res);
        if ($res){
            $this->success("添加成功",'user/detail');
        }else{
            $this->error("添加失败");
        }
    }
    
    //删除某个用户的详细信息
    public function deldetail(){
        $id = $this->request->param('id');
        //dump($id);
        $del = new UserinfoModel();
        $res = $del->where('id',$id)->delete();
        if ($res){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    
    
    
    
    
    
    
    
    
    
}
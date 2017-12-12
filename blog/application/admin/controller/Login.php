<?php
namespace app\admin\controller;
use app\common\model\UsersModel;
use app\common\model\LogrecordModel;
use think\Controller;
use think\Session;

class Login extends Controller{
    public function login(){       
        return $this->fetch();
    }
    
    public function logindo(){
        $arr = $this->request->param();
        //dump($arr);exit;
        $username = $arr['username'];
        $password = $arr['password'];
        //dump($arr);exit;
        $user = new UsersModel();
        $res = $user->where('username',"$username")
                    ->where('password',"$password")
                    ->where('isadmin','1')
                    ->find();
        //$arr = $res->logtime;
        //dump($arr);exit;
        
        if ($res){ 
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];
            $uid = $res->id;
            $re=[
                'username'=>$res->username,
                'logtime'=>$time,
                'logip'=>$ip,
                'uid'=>$uid,
            ];
            //dump($re);exit;
            $log = new LogrecordModel();
            $info = $log->save($re);
            //dump($info);exit;
            Session::set('id',$res->id);
            Session::set('isadmin',$res->isadmin);
            Session::set('username',$username); 
            Session::set('logcount',$res->logcount);           
            $data = ["status"=>1,"logcount"=>$res->logcount+1];
            $save = $res->where('id',$res->id)->update($data);
            
            
            $this->success("登陆成功",'index/index');
        }else{
            $this->error("登陆失败");
        }
    }
      
    public function LoginOut(){
        $id=Session::get('id');
        //dump($id);exit;
        $user = new UsersModel();
        $res = $user->where('id',$id)->find();
        //dump($res);exit;
        $save = $res->where('id',$res->id)->update(["status"=>0]);
        //dump($save);exit;
        Session::delete("id");
        Session::delete("isadmin");
        Session::delete("username");
        Session::delete("logcount");
        $this->redirect('admin/login/login');
    }
    
}
<?php
namespace app\common\model;

use think\Model;

class CommentModel extends Model{
    protected $table = 'blog_comment';
    
    public function getcomnum($id){
        $com = new CommentModel();
        $comnum = $com->where('aid',$id)->count();        
        
        return $comnum;
    }
    
    public function getcomusernum($id){
        $com = new CommentModel();        
        $comuser = $com->where('aid',$id)->group('username')->select();
        $comusernum = count($comuser);        
        return $comusernum;
    }
       
   
    public function getComAllNum(){
        $comNum = $this->count();    
        return $comNum;
    }
    

    
}
<?php
namespace app\common\model;


use think\Model;

class MsgModel extends Model{
    
    protected $table="blog_msg";
    
    //留言数量
    public function msgNum(){
        $mnum = $this->order('id')->select();        
        $mnum = count($mnum);
        return $mnum;
    }
       
    
}
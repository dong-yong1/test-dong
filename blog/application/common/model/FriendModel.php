<?php
namespace app\common\model;

use think\Model;

class FriendModel extends Model{
    protected $table = 'blog_friend';
    
    //获取友情链接的总数量
    public function getFriNum(){
        $friNum = $this->count();    
        return $friNum;
    }
}
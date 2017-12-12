<?php
namespace app\common\model;

use think\Model;

class ArticleModel extends Model{
    protected $table = 'blog_article';
    
    
    //获取文章的总数量
    public function getArtNum(){
        $artNum = $this->count();       
        
        return $artNum;
    }
    
    //根据评论的数量来获取2片文章    放在模型ArticleModel中
    public function getuserart(){        
        $com = new CommentModel();
        $userart = $com->group('aid')->field('count(*),aid')
        ->order('count(*) desc')->limit(5)->select();
        $rows = [];
        foreach ($userart as $key=>$k){
            $aid = $k->aid;
            //dump($aid);exit;
            $ar = new ArticleModel();
            $rows[] = $ar->where('id',$aid)->find();
        }
       
        return $rows;
    }
}
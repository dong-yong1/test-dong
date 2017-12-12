<?php
namespace app\common\model;

use think\Model;

class TypeModel extends Model{
    protected $table = 'blog_type';
    
    public function showOption($typeid=0){
        $arr = $this->where('fid','0')->select();
        $str = "";        
        foreach ($arr as $ob){
            $tname = $ob->tname;
            $id = $ob->id;
            if ($id == $typeid){
                $str .= "<option selected='selected' value='{$id}'>{$tname}</option>";
            }else{
                $str .= "<option value='{$id}'>{$tname}</option>";
            } 
        }        
        return $str;
    }
}
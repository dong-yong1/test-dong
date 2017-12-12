<?php
namespace app\admin\validate;

use think\Validate;

class UsersModel extends Validate{
    // 当前验证的规则
    protected $rule = ["username"=>"require|unique:users",
        "password"=>"require|regex:/^[a-z0-9]{6,10}$/",
        "new_password"=>"require|confirm:new_password"
    ];
    
    // 验证提示信息
    protected $message = [
        "username.unique"=>"用户已存在",
        "password.require"=>"新密码不能为空",
        "password.regex"=>"新密码格式不正确",
        "new_password.require"=>"确认密码不能为空",
        "new_password.confirm"=>"两次密码密码不一致"
    ];
}
<?php
namespace app\index\validate;

use think\Validate;

class UsersModel extends Validate{
        // 当前验证的规则
        protected $rule = ["username"=>"require|unique:blogusers",
            "password"=>"require|regex:/^\d{6,8}$/",
            "confirmpwd"=>"require|confirm:password"
        ];
        
        // 验证提示信息
        protected $message = ["username.require"=>"用户名不能为空",
            "username.unique"=>"用户已存在",
            "password.require"=>"密码不能为空",
            "password.regex"=>"密码格式不正确",
            "confirmpwd.confirm"=>"确认密码不正确"
        ];
}
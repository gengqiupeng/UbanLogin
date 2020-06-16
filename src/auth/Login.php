<?php

namespace uban\auth;

use uban\base\BaseClass;

abstract class Login extends BaseClass
{
    /**
     * 抽象用户模型，其他框架实现
     * 登录时使用用户对象
     */

    /**
     * 用户登录
     * @param $account string 用户名
     * @param $password string 密码
     * @param $formatUser string 回调方法
     * @return mixed
     */
    public abstract function login($account, $password,$formatUser);

    public abstract function register();

    public abstract function resetPassword();

    /**
     * 单点登录
     * @return mixed
     */
    public abstract function sso();
}
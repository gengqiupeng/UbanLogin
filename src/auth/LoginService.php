<?php

namespace uban\auth;

use think\Db;

/**
 * 认证服务类
 * Class LoginService
 * @package uban\auth
 */
class LoginService extends Login
{

    public function login($account, $password)
    {
        $config = $this->getConfig();
        $table = $config['table'];
        $accountColumn = $config['accountColumn'];
        $passwordColumn = $config['passwordColumn'];
        $user = Db::name($table)->where("$accountColumn", $account)
            ->where("$passwordColumn", $password)
            ->find();
    }

    public function register()
    {
        // TODO: Implement register() method.
    }

    public function resetPassword()
    {
        // TODO: Implement resetPassword() method.
    }

    public function sso()
    {
        // TODO: Implement sso() method.
    }
}
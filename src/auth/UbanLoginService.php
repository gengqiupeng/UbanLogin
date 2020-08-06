<?php

namespace uban\auth;

use think\facade\Db;
use think\facade\Session;

/**
 * 认证服务类
 * Class LoginService
 * @package uban\auth
 */
class UbanLoginService extends Login
{
    private $rawUser;

    public function login($account, $password, $formatUser)
    {
        $config = $this->getConfig();
        $table = $config->userTable;
        $accountColumn = $config->accountColumn;
        $passwordColumn = $config->passwordColumn;
        $user = Db::name($table)->where("$accountColumn", $account)
            ->where("$passwordColumn", $password)
            ->find();
        $this->rawUser = $user;
        $this->user = $formatUser($user);
        $this->save();
        $this->user->setToken(Session::getId());
        return $user;
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

    public function setRoleByData()
    {
        $user_id = $this->user->getId();
        $config = $this->getConfig();
        $table = $config->roleTable;
        $userIdColumn = $config->userIdColumn;
        $roleColumn = $config->roleIdColumn;
        $roles = Db::name($table)->where("$userIdColumn=$user_id")->select()->toArray();
        $role = array_column($roles, $roleColumn);
        $this->user->setRole($role);
        $this->save();
        return $this;
    }

    public function getRawUser()
    {
        return $this->rawUser;
    }

    public function setRoleByString($role)
    {
        $role = explode(",", $role);
        $this->user->setRole($role);
        return $this;
    }

    /**
     * 保存登录信息
     */
    public function save()
    {
        Session::set('uban_user', $this->user);
    }
}
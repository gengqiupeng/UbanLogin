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
    protected $rawUser;

    protected $config;
    protected $table;
    protected $accountColumn;
    protected $passwordColumn;
    protected $tokenColumn;
    protected $tokenExpire;
    protected $userIdColumn;
    protected $roleColumn;

    public function __construct()
    {
        $this->config = $this->getConfig();
        $this->table = $this->config->userTable;
        $this->accountColumn = $this->config->accountColumn;
        $this->passwordColumn = $this->config->passwordColumn;
        $this->tokenColumn = $this->config->tokenColumn;
        $this->tokenExpire = $this->config->tokenExpire;

        $this->userIdColumn = $this->config->roleUserIdColumn;
        $this->roleColumn = $this->config->roleIdColumn;
    }

    public function login($account, $password,$where, $formatUser)
    {
        $user = Db::name($this->table)->where("$this->accountColumn", $account)
            ->where("$this->passwordColumn", $password)
            ->where($where)
            ->find();
        $this->rawUser = $user;
        if (empty($user)) {
            return false;
        }
        $this->user = $formatUser($user);
        $this->user->setToken(Session::getId());
        UbanUserTool::setUser($this->user);
        return $user;
    }

    /**
     * 通过token登录
     * @param $token
     * @param $formatUser
     * @return array|bool|\think\Model|null
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function tokenIn($token, $formatUser)
    {
        $user = Db::name($this->table)->where("$this->tokenColumn", $token)
            ->where("$this->tokenExpire", ">", time())
            ->find();
        $this->rawUser = $user;
        if (empty($user)) {
            return false;
        }
        $this->user = $formatUser($user);
        UbanUserTool::setUser($this->user);
        $this->user->setToken(Session::getId());
        return $user;
    }

    /**
     * 更新用户信息缓存
     * @param $where array
     * @param $formatUser
     */
    public function updateUserCache($where, $formatUser)
    {
        $rawUser = Db::name($this->table)->where($where)->find();
        $this->user = $formatUser($rawUser);
        $this->user->setToken(Session::getId());
        UbanUserTool::setUser($this->user);
        $this->setRoleByData();
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
        $table = $this->config->userRoleTable;
        $userIdColumn = $this->config->roleUserIdColumn;
        $roleColumn = $this->config->roleIdColumn;
        $roles = Db::name($table)->where("$userIdColumn=$user_id")->select()->toArray();
        $role = array_column($roles, $roleColumn);
        $this->user->setRole($role);
        UbanUserTool::setUser($this->user);
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

}
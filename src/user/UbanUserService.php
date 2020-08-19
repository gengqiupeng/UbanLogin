<?php

namespace uban\user;

use think\facade\Db;

class UbanUserService extends User
{

    public function isLogin()
    {
        // TODO: Implement isLogin() method.
    }

    public function isRole()
    {
        // TODO: Implement isRole() method.
    }

    public function edit()
    {
        // TODO: Implement edit() method.
    }

    public function save($data, $primary_key = '')
    {
        $config = $this->getConfig();
        $table = $config->userTable;
        if (empty($primary_key)) {
            $primary_key = $config->accountColumn;
        }
        if (!array_key_exists($primary_key, $data)) {
            return Db::name($table)->insertGetId($data);
        }
        $oldData = Db::name($table)->where($primary_key, $data[$primary_key])->find();
        if (empty($oldData)) {
            $result = Db::name($table)->insertGetId($data);
        } else {
            $result = Db::name($table)->where($primary_key, $data[$primary_key])->update($data);
        }
        return $result;
    }

    public function addRoleByData($userId, $role = [])
    {
        $config = $this->getConfig();
        if (!is_array($role)) {
            $role = [$role];
        }
        foreach ($role as $item) {
            $oldRole = Db::name($config->userRoleTable)->where($config->roleUserIdColumn, $userId)
                ->where($config->roleIdColumn, $item)
                ->find();
            if (empty($oldRole)) {
                Db::name($config->userRoleTable)->insert([$config->roleUserIdColumn => $userId, $config->roleIdColumn => $item]);
            }
        }
    }

    /**
     * 通过角色获取用户列表
     * @param $roles []int 角色列表
     * @param $field
     * @throws \think\Exception
     */
    public function getUsersByRoleTable($roles, $field)
    {
        $config = $this->getConfig();
        $userTable = $config->userTable;
        $userRoleTable = $config->userRoleTable;
        $roleIdColumn = $config->roleIdColumn;
        $roleUserIdColumn = $config->roleUserIdColumn;
        $userIdColumn = $config->userIdColumn;
        return Db::name($userRoleTable)->alias('ur')
            ->join("$userTable u", "ur.$roleUserIdColumn = u.$userIdColumn")
            ->whereIn("$roleIdColumn", $roles)
            ->field($field)
            ->select();
    }
}
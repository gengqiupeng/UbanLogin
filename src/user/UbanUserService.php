<?php

namespace uban\user;

use think\facade\Db;

class UbanUserService extends User
{
    private $config;

    public function __construct()
    {
        $this->config = $this->getConfig();
    }

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
            Db::name($table)->where($primary_key, $data[$primary_key])->update($data);
            return $oldData[$config->userIdColumn];
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
     * @param int $page
     * @param int $pageSize
     * @param array $where
     * @param string $whereRaw
     * @return \think\Collection|\think\Paginator
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUsersByRoleTable($roles, $field, $page = 0, $pageSize = 20, $where = [], $whereRaw = '1')
    {
        $config = $this->getConfig();
        $userTable = $config->userTable;
        $userRoleTable = $config->userRoleTable;
        $roleIdColumn = $config->roleIdColumn;
        $roleUserIdColumn = $config->roleUserIdColumn;
        $userIdColumn = $config->userIdColumn;
        return Db::name($userRoleTable)->alias('ur')
            ->join("$userTable u", "ur.$roleUserIdColumn = u.$userIdColumn")
            ->where($where)
            ->whereRaw($whereRaw)
            ->whereIn("$roleIdColumn", $roles)
            ->field("u.$userIdColumn")
            ->field($field)
            ->page($page)
            ->paginate($pageSize);
    }

    /**
     * 获取用户信息和角色
     * @param $field
     * @param $where
     * @return array|false
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserAndRoleByWhere($field, $where)
    {
        $config = $this->getConfig();
        $userTable = $config->userTable;
        $userRoleTable = $config->userRoleTable;
        $roleIdColumn = $config->roleIdColumn;
        $roleUserIdColumn = $config->roleUserIdColumn;
        $userIdColumn = $config->userIdColumn;
        $user = Db::name($userTable)
            ->field($field)
            ->field($userIdColumn)
            ->where($where)->find();
        //获取角色
        if (empty($user)) {
            return false;
        }
        $roles = Db::name($userRoleTable)
            ->field($roleIdColumn)
            ->where($roleUserIdColumn, $user[$userIdColumn])
            ->select()->toArray();
        $user['roles'] = array_column($roles, $roleIdColumn);
        return $user;
    }

    /**
     * 根据email获取用户信息
     * @param $field
     * @param $email
     * @return array|false
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserAndRoleByEmail($field, $email)
    {
        $config = $this->getConfig();
        $account = $config->accountColumn;
        $where = "$account = '$email'";
        return $this->getUserAndRoleByWhere($field, $where);
    }

    public function changePassword($findWhere, $oldPassword, $newPassword)
    {
        $userTable = $this->config->userTable;
        $passwordColumn = $this->config->passwordColumn;
        $user = Db::name($userTable)->where($findWhere)->find();
        if (empty($user)) {
            return false;
        }
        if ($user[$passwordColumn] != $oldPassword) {
            return false;
        }
        return Db::name($userTable)->where($findWhere)->update([$passwordColumn => $newPassword]);
    }

    public function getRoleArrayByUserId($userId)
    {
        $userRoleTable = $this->config->userRoleTable;
        $userIdColumn = $this->config->roleUserIdColumn;
        $roleIdColumn = $this->config->roleIdColumn;
        $roles = Db::name($userRoleTable)->where($userIdColumn, $userId)->field($roleIdColumn)->select()->toArray();
        return array_column($roles,$roleIdColumn);
    }
}
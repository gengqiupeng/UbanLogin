<?php

namespace uban\user;

use think\facade\Db;

class UbanUser extends User
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

        $oldData = Db::name($table)->where($primary_key, $data[$primary_key])->find();
        if (empty($oldData)) {
            $result = Db::name($table)->insertGetId($data);
        } else {
            $result = Db::name($table)->where($primary_key, $data[$primary_key])->update($data);
        }
        return $result;
    }
}
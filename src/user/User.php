<?php

namespace uban\user;

use uban\base\BaseClass;

abstract class User extends BaseClass
{
    public abstract function isLogin();

    public abstract function isRole();

    public abstract function edit();

    /**
     * @param $data [] 保存用户数据
     * @param $primary_key string 更新时唯一主键
     * @return boolean 保存结果
     */
    public abstract function save($data, $primary_key = '');

    public abstract function addRoleByData($userId,$role);
}
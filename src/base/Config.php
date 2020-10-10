<?php

namespace uban\base;

/**
 * @property $userTable;
 * @property $accountColumn;
 * @property $passwordColumn;
 * @property $userIdColumn;
 * @property $userRoleTable;
 * @property $roleUserIdColumn;
 * @property $roleIdColumn;
 * @property $tokenColumn;
 * @property $tokenExpire;
 * Class Config
 * @package uban\base
 */
class Config
{
    private $data=[];

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        if(array_key_exists($name, $this->data))
            return $this->data[$name];
        return NULL;
    }

}
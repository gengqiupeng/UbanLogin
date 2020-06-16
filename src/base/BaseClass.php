<?php

namespace uban\base;

use think\facade\Config;
use uban\auth\UserModel;

abstract class BaseClass
{
    /**
     * @var array 读取配置
     */
    private $config;

    /**
     * @var UserModel
     */
    protected $user;

    protected function getConfig()
    {
        if (is_null($this->config)) {
            $this->config = Config::get('uban_user');
        }
        return $this->config;
    }

    public function getUser()
    {
        return $this->user;
    }
}
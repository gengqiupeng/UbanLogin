<?php

namespace uban\base;

use think\facade\Config;

abstract class BaseClass
{
    /**
     * @var array 读取配置
     */
    private $config;

    protected function getConfig()
    {
        if (is_null($this->config)) {
            $this->config = Config::get('uban_user');
        }
        return $this->config;
    }
}
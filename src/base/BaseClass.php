<?php

namespace uban\base;

use think\Exception;
use think\facade\Config;
use uban\user\UbanUserModel;

abstract class BaseClass
{
    /**
     * @var \uban\base\Config
     */
    private $config;

    /**
     * @var UbanUserModel
     */
    protected $user;

    /**
     * @return \uban\base\Config
     * @throws Exception
     */
    protected function getConfig()
    {
        $config = session('uban_user_config');
        if (empty($config)) {
            $config = Config::get('uban_user');
            if (empty($config)) {
                throw new Exception('Uban User Config uban_user.php not define');
            }
            $this->config = new \uban\base\Config();
            foreach ($config as $key => $item) {
                $this->config->$key = $item;
            }
            session('uban_user_config', $this->config);
        } else {
            $this->config = $config;
        }
        return $this->config;
    }

    public function getUser()
    {
        return $this->user;
    }
}
<?php

namespace uban\auth;

use think\facade\Session;
use uban\user\UbanUserModel;

class UbanUserTool
{
    public static function isLogin()
    {
        return !empty(self::getUser());
    }

    /**
     * @return UbanUserModel
     */
    public static function getUser()
    {
        return Session::get('uban_user');
    }
}
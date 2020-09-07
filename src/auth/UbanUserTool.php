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

    public static function loginOut()
    {
        Session::delete('uban_user');
    }

    /**
     * @return UbanUserModel
     */
    public static function getUser()
    {
        return Session::get('uban_user');
    }
}
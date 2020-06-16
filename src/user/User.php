<?php

namespace uban\user;

use uban\base\BaseClass;

abstract class User extends BaseClass
{
    public abstract function isLogin();

    public abstract function isRole();

    public abstract function edit();

}
<?php

namespace uban\tests\user;

use PHPUnit\Framework\TestCase;
use uban\base\Config;

class ConfigTest extends TestCase
{
    public function test()
    {
        $config = new Config();
        $config->userTable = "users";
        $table = $config->userTable;
        $this->assertEquals("users", $table);
    }
}
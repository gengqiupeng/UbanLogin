<?php

namespace uban\user;

class UbanUserModel implements \JsonSerializable
{
    /**
     * @var string 用户昵称
     */
    private $name;
    /**
     * @var []string 用户角色
     */
    private $roles;
    /**
     * @var string 用户邮箱
     */
    private $email;
    /**
     * @var string 用户账户
     */
    private $account;

    /**
     * @var int 用户ID
     */
    private $id;

    /**
     * @var string 请求token
     */
    private $token;

    /**
     * @var string 头像
     */
    private $avatar;
    /**
     * @var string 名字
     */
    private $first_name;
    /**
     * @var string 姓氏
     */
    private $last_name;
    private $phone;
    /**
     * @var string 机构
     */
    private $employer;
    /**
     * @var string 简介
     */
    private $description;

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param string $employer
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
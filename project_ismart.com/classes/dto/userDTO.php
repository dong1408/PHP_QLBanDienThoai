<?php

class UserDTO
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $createdAt;
    public $deletedAt;
    public $userType;
    public $active_token = NULL;
    public $is_active = 0;

    function __construct($id, $username, $password, $email, $createdAt, $deletedAt, $userType)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->deletedAt = $deletedAt;
        $this->userType = $userType;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getUsername()
    {
        return $this->username;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getCreatedAt()
    {
        return $this->createdAt;
    }

    function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    function getDeletedAt()
    {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    function getUserType()
    {
        return $this->userType;
    }

    function serUserType($userType)
    {
        $this->userType = $userType;
    }

    function getActiveToken()
    {
        return $this->active_token;
    }

    function setActiveToken($active_token)
    {
        $this->active_token = $active_token;
    }

    function getIsActive()
    {
        return $this->is_active;
    }

    function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }
}

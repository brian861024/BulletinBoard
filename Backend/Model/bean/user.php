<?php

class user {
    private $int_id;
    private $str_userName;
    private $str_password;
    private $str_email;
    private $date_created_at;
    private $date_updated_at;

    public function __construct()
    {
        $this->int_id;
        $this->str_userName;
        $this->str_password;
        $this->str_email;
        $this->date_created_at;
        $this->date_updated_at;
    }

    public function setId($id)
    {
        $this->int_id = $id;
    }

    public function getId()
    {
        return $this->int_id;
    }

    public function setUserName($userName)
    {
        $this->str_userName = $userName;
    }

    public function getUserName()
    {
        return $this->str_userName;
    }

    public function setPassword($password)
    {
        $this->str_password = $password;
    }

    public function getPassword()
    {
        return $this->str_password;
    }

    public function setEmail($email)
    {
        $this->str_email = $email;
    }

    public function getEmail()
    {
        return $this->str_email;
    }

    public function setDateCreatedAt($date_created_at)
    {
        $this->date_created_at = $date_created_at;
    }

    public function getDateCreatedAt()
    {
        return $this->date_created_at;
    }

    public function setDateUpdateAt($date_updated_at)
    {
        $this->date_updated_at = $date_updated_at;
    }

    public function getDateUpdateAt()
    {
        return $this->date_updated_at;
    }
}

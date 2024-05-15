<?php

require_once '/htdocs/Backend/Model/dao/userDaoPdo.php';
require_once '/htdocs/Backend/Model/dao/categoryDaoPdo.php';
require_once '/htdocs/Backend/Model/bean/user.php';
require_once '/htdocs/Backend/Model/bean/category.php';

class message
{
    private $int_id;
    private $int_user_id;
    private $int_category_id;
    private $str_title;
    private $str_content;
    private $date_created_at;
    private $date_updated_at;
    // 額外注入
    private $obj_user;
    private $str_category;

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->int_id = $id;
    }

    public function getId()
    {
        return $this->int_id;
    }

    public function setUser_id($user_id)
    {
        $this->int_user_id = $user_id;
    }

    public function getUser_id()
    {
        return $this->int_user_id;
    }

    public function setCategory_id($category_id)
    {
        $this->int_category_id = $category_id;
    }

    public function getCategory_id()
    {
        return $this->int_category_id;
    }

    public function setTitle($title)
    {
        $this->str_title = $title;
    }

    public function getTitle()
    {
        return $this->str_title;
    }

    public function setContent($content)
    {
        $this->str_content = $content;
    }

    public function getContent()
    {
        return $this->str_content;
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

    public function setUserIntoMessage()
    {
        $userDaoPdo = new userDaoPdo;
        $user = $userDaoPdo->findUserByUserId($this->getUser_id());
        $this->obj_user = $user;
    }

    public function getUser()
    {
        return $this->obj_user;
    }

    public function setCategoryIntoMessage()
    {
        $categoryDaoPdo = new categoryDaoPdo;
        $category = $categoryDaoPdo->findCategoryById($this->getCategory_id());
        $this->str_category = $category;
    }

    public function getCategory()
    {
        return $this->str_category;
    }
}

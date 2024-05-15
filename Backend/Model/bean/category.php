<?php

class category
{
    private $int_id;
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

    public function setCategory($category)
    {
        $this->str_category = $category;
    }

    public function getCategory()
    {
        return $this->str_category;
    }
}

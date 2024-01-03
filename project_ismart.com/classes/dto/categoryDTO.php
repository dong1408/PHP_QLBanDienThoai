<?php

class CategoryDTO
{
    public $id;
    public $name;
    public $status_id;
    public $created_at;
    public $deleted_at;

    function __construct($id, $name, $status_id, $created_at, $deleted_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status_id = $status_id;
        $this->created_at = $created_at;
        $this->deleted_at = $deleted_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getStatusId()
    {
        return $this->status_id;
    }

    function setStatusId($status_id)
    {
        $this->status_id = $status_id;
    }

    function getCreatedAt()
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    function getDeletedAt()
    {
        return $this->deleted_at;
    }

    function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }
}

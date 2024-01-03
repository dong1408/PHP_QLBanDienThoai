<?php

class RoleDTO{
    public $id;
    public $name;
    public $description;
    public $created_at;
    public $deleted_at;

    function __construct($id, $name, $description, $created_at, $deleted_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->deleted_at = $deleted_at;
    }

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getName(){
        return $this->name;
    }

    function setName($name){
        $this->name = $name;
    }

    function getDescription(){
        return $this->description;
    }

    function setDescription($description){
        $this->description = $description;
    }

    function getCreatedAt(){
        return $this->created_at;
    }

    function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    function getDeletedAt(){
        return $this->deleted_at;
    }

    function setDeletedAt($deleted_at){
        $this->deleted_at = $deleted_at;
    }
}

?>
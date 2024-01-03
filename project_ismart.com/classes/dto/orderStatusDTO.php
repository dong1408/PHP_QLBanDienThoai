<?php

class OrderStatusDTO{
    public $id;
    public $name;
    public $note;

    function __construct($id, $name, $note)
    {
        $this->id = $id;
        $this->name = $name;
        $this->note = $note;
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

    function getNote(){
        return $this->note;
    }

    function setNote($note){
        $this->note = $note;
    }
}



?>
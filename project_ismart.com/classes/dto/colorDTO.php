<?php

class ColorDTO{
    public $id;
    public $value;

    function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    } 

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }
}
?>
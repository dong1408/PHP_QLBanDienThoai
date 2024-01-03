<?php

class ProductDTO
{
    public $id;
    public $name;
    public $price;
    public $amount;
    public $shortDesc;
    public $detailDesc;
    public $imageUrl;
    public $created_at;
    public $deleted_at;
    public $user_id;
    public $ram_id;
    public $rom_id;
    public $color_id;
    public $category_id;
    public $status_id;

    function __construct($id, $name, $price, $amount, $shortDesc, $detailDesc, $imageUrl, $created_at, $deleted_at, $user_id, $ram_id, $rom_id, $color_id, $category_id, $status_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->amount = $amount;
        $this->shortDesc = $shortDesc;
        $this->detailDesc = $detailDesc;
        $this->imageUrl = $imageUrl;
        $this->created_at = $created_at;
        $this->deleted_at = $deleted_at;
        $this->user_id = $user_id;
        $this->ram_id = $ram_id;
        $this->rom_id = $rom_id;
        $this->color_id = $color_id;
        $this->category_id = $category_id;
        $this->status_id = $status_id;
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

    function getPrice()
    {
        return $this->price;
    }

    function setPrice($price)
    {
        $this->price = $price;
    }

    function getAmount()
    {
        return $this->amount;
    }

    function setAmount($amount)
    {
        $this->amount = $amount;
    }

    function getShortDesc()
    {
        return $this->shortDesc;
    }

    function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;
    }

    function getDetailDesc()
    {
        return $this->detailDesc;
    }

    function setDetailDesc($detailDesc)
    {
        $this->detailDesc = $detailDesc;
    }

    function getImageUrl()
    {
        return $this->imageUrl;
    }

    function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
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

    function getUserId(){
        return $this->user_id;
    }

    function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    function getCategoryId()
    {
        return $this->category_id;
    }

    function setCategoryId($category_id){
        $this->category_id = $category_id;
    }

    function getStatusId(){
        return $this->status_id;
    }

    function setStatusId($status_id){
        $this->status_id = $status_id;
    }

    function getRamId(){
        return $this->ram_id;
    }

    function setRamId($ram_id){
        $this->ram_id = $ram_id;
    }

    function getRomId(){
        return $this->rom_id;
    }

    function setRomId($rom_id){
        $this->rom_id = $rom_id;
    }

    function getColorId(){
        return $this->color_id;
    }

    function setColorId($color_id){
        $this->color_id = $color_id;
    }


}

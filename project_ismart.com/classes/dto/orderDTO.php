<?php

class OrderDTO{
    public $id;
    public $userID;
    public $fullname;
    public $email;
    public $address;
    public $phone;
    public $note;
    public $payMethod;
    public $created_at;
    public $amount;
    public $total;
    public $confirm_token = NULL;
    public $statusId = 1;

    function __construct($id, $userID, $fullname, $email, $address, $phone, $note, $payMethod, $created_at, $amount, $total, $statusId)
    {
        $this->id = $id;
        $this->userID = $userID;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->address = $address;
        $this->phone = $phone;
        $this->note = $note;
        $this->payMethod = $payMethod;
        $this->created_at = $created_at;
        $this->amount = $amount;
        $this->total = $total;
        $this->statusId = $statusId;
    }

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getUserID(){
        return $this->userID;
    }

    function setUserID($userID){
        $this->userID = $userID;
    }

    function getFullname(){
        return $this->fullname;
    }

    function setFullname($fullname){
        $this->fullname = $fullname;
    }

    function getEmail(){
        return $this->email;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function getAddress(){
        return $this->address;
    }

    function setAddress($address){
        $this->address = $address;
    }

    function getPhone(){
        return $this->phone;
    }

    function setPhone($phone){
        $this->phone = $phone;
    }

    function getNote(){
        return $this->note;
    }

    function setNote($note){
        $this->note = $note;
    }

    function getPayMethod(){
        return $this->payMethod;
    }

    function setPayMethod($payMethod){
        $this->payMethod = $payMethod;
    }

    function getCreatedAt(){
        return $this->created_at;
    }

    function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    function getAmount(){
        return $this->amount;
    }

    function setAmount($amount){
        $this->amount = $amount;
    }

    function getTotal(){
        return $this->total;
    }

    function setTotal($total){
        $this->total = $total;
    }

    function getStatusId(){
        return $this->statusId;
    }

    function setStatudId($statusId){
        $this->statusId = $statusId;
    }

    function getConfirmToken(){
        return $this->confirm_token;
    }

    function setConfirmToken($confirm_token){
        $this->confirm_token = $confirm_token;
    }
}
?>
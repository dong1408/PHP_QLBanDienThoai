<?php
function checkValidateUsername($username){
    $partten = "/^[A-Za-z0-9_\.]{6,32}$/";
    if(preg_match($partten,$username)){
        return true;
    }
    return false;
}

function checkValidatePassword($password){
    $partten = "/^([A-Z]){1}([\w\.!@#$%^&*()]+){5,31}$/";
    if(preg_match($partten,$password,$matchs)){
       return true;
     }
     return false;
}

function checkValidatePhone($phoneNumber){
    $partten = "/(84|0[3|5|7|8|9])+([0-9]{8})\b/g";
    if(preg_match($partten, $phoneNumber)){
        return true;
    }
    return false;
}

function checkValidateEmail($email){
    $partten = "/^[A-Za-z0-9_.]{6,32}@([A-Za-z0-9]{2,12})(.[A-Za-z]{2,12})+$/";
    if(preg_match($partten, $email)){
        return true;
    }
    return false;
}

function is_email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

?>
<?php
function get_list_users()
{
    $result = db_fetch_array("SELECT * FROM `users`");
    return $result;
}

function get_user_by_id($id)
{
    $result = db_fetch_row("SELECT * FROM `staffs` WHERE `StaffID` = '{$id}'");
    return $result;
}

function check_login($username, $password)
{
    $query = "SELECT * FROM `users` WHERE `username` = '{$username}' AND `password` = '{$password}'";
    $count = db_num_rows($query);
    // echo $count;
    if ($count > 0) {
        return true;
    }
    return false;
}

function check_permission_admin($userID)
{
    $query = "SELECT * FROM `users` WHERE id = {$userID} AND user_type = 'Admin'";
    $count = db_num_rows($query);
    echo $count;
    if ($count > 0) {
        return true;
    }
    return false;
}


function get_userid_by_username($username)
{
    $result = db_fetch_row("SELECT `id` FROM `users` WHERE username = '{$username}'");
    return $result['id'];
}


function get_permissions_by_userId($userId){
    $data = db_fetch_array("SELECT role_permission.permission_id AS id FROM `user_role`, `role_permission` WHERE user_role.role_id = role_permission.role_id AND user_role.user_id = '{$userId}'");
    $result = array();
    foreach($data as $val){
        $result[] = $val['id'];
    }
    // if(db_num_rows())                    
    return $result;
}





function add_user($data)
{
    db_insert('users', $data);
}

function user_exist($username, $email)
{
    $sql = "SELECT * FROM users WHERE `username` = '{$username}' OR `email` = '{$email}'";
    if (db_num_rows($sql) > 0) {
        return true;
    }
    return false;
}

function active_user($active_token)
{
    return db_update('users', array('is_active' => 1), "`active_token` = '{$active_token}'");
}

function check_active_token($active_token)
{
    $check = db_num_rows("SELECT * FROM `users` WHERE `active_token` = '{$active_token}' AND `is_active` = '0'");
    if ($check > 0) {
        return true;
    }
    return false;
}

function email_exist($email){
    $sql = "SELECT * FROM users WHERE `email` = '{$email}'";
    if(db_num_rows($sql) > 0){
        return true;
    }
    return false;
}

function update_resert_token($data,$email){
    db_update('users', $data, "`email` = '{$email}'");
}

function check_resert_token($reset_token){
    $check = db_num_rows("SELECT * FROM `users` WHERE `reset_token` = '{$reset_token}'");
    if($check > 0){
        return true;
    }
    return false;
}

function update_pass($data,$reset_token){
    db_update('users',$data,"`reset_token` = '{$reset_token}'");
}

function compareStringsWithSpecialChars($string1, $string2) {
    $len1 = strlen($string1);
    $len2 = strlen($string2);

    if ($len1 !== $len2) {
        return false; // Độ dài của hai chuỗi không giống nhau, chắc chắn khác nhau.
    }

    for ($i = 0; $i < $len1; $i++) {
        if ($string1[$i] !== $string2[$i]) {
            return false; // Tìm thấy ký tự khác nhau, hai chuỗi khác nhau.
        }
    }

    return true; // Hai chuỗi giống nhau.
}
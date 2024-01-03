<?php
function get_list_staff(){
    $result = db_fetch_array("SELECT * FROM `users`, `status` WHERE users.StatusID = status.StatusID");
    return $result;
}

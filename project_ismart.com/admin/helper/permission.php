<?php
function get_list_permis()
{
    $result = db_fetch_array("SELECT * FROM `permission`");
    return $result;
}
?>
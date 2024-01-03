<?php

function get_list_product_by_category($categoryID)
{
    return db_fetch_array("SELECT * FROM `products` WHERE products.category_id = {$categoryID} AND products.status_id = 1");
}

function get_list_category()
{
    return db_fetch_array("SELECT * FROM `categories` WHERE categories.status_id = 1");
}

function get_list_product_search($keySearch)
{
    return db_fetch_array("SELECT * FROM `products` WHERE products.status_id = 1 AND products.name like '%{$keySearch}%'");
}

function get_list_product_search_pagging($start, $num_per_page, $where = "")
{
    if (!empty($where)) {
        return db_fetch_array("SELECT * FROM `products` WHERE products.status_id = 1 AND " . $where . " LIMIT {$start}, {$num_per_page}");
    } else {
        return db_fetch_array("SELECT * FROM `products` WHERE products.status_id = 1 LIMIT {$start}, {$num_per_page}");
    }
}

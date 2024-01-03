<?php
function get_list_category()
{
    return db_fetch_array("SELECT * FROM `category` WHERE category.StatusID = 1");
}

function get_list_product_by_category($catID)
{
    return db_fetch_array("SELECT * FROM `product` WHERE product.CategoryID = {$catID} AND product.StatusID = 1");
}

function get_list_product_by_category_paging($start, $num_per_page, $where = ""){
    if (!empty($where)) {
        return db_fetch_array("SELECT * FROM `product` WHERE product.StatusID = 1 AND " . $where . " LIMIT {$start}, {$num_per_page}");
    } else {
        return db_fetch_array("SELECT * FROM `product` WHERE product.StatusID = 1 LIMIT {$start}, {$num_per_page}");
    }
}

function get_name_cat_by_id($catID)
{
    return db_fetch_row("SELECT `Name` FROM `category` WHERE category.CategoryID = {$catID}");
}

<?php
function get_product_by_id($id)
{
    return db_fetch_row("SELECT * FROM `product` WHERE product.ProductID = '{$id}'");
}

function get_list_category()
{
    return db_fetch_array("SELECT * FROM `category` WHERE category.StatusID = 1");
}

function get_list_product_by_category($idPro, $catID) // Get nhung san pham cung chuyen muc
{
    return db_fetch_array("SELECT * FROM `product` WHERE product.CategoryID = {$catID} AND product.StatusID = 1 AND product.ProductID != '{$idPro}'");
}

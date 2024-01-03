<?php
function construct()
{
    load_model('index');
}

function indexAction()
{
    $id = $_GET['id'];
    $product = get_product_by_id($id);
    // show_array($product);
    if (!empty($product)) {
        $list_category = get_list_category();
        $list_product_by_cat = get_list_product_by_category($product['ProductID'], $product['CategoryID']);
        // show_array($list_product_by_cat);    
        $data['product'] = $product;
        $data['list_category'] = $list_category;
        $data['list_product_by_cat'] = $list_product_by_cat;
        load_view('index', $data);
    } else {
        header("Location:?mod=product");
    }
}

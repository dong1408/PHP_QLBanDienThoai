<?php

function construct()
{
    load_model('proByCat');
}

function indexAction()
{
    $catID = (int) $_GET['id'];

    $list_product_by_cat = get_list_product_by_category($catID);
    // Set so ban ghi tren 1 trang
    $num_per_page = 12;
    // Tong so ban ghi
    $total_row = numRowOfList($list_product_by_cat);
    // ==> So trang
    $num_page = ceil($total_row / $num_per_page);
    // Get page tu url, khong co mac dinh page=1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Tinh so ban ghi bat dau cua moi trang
    $start = ($page - 1) * $num_per_page;
    // Lay danh sach theo phan trang
    $list_product_pagging = get_list_product_by_category_paging($start, $num_per_page, "product.CategoryID = {$catID}");


    $nameCat = get_name_cat_by_id($catID);
    $list_category = get_list_category();
    
    $data['num_page'] = $num_page;
    $data['page'] = $page;
    $data['catID'] = $catID;
    $data['list_category'] = $list_category;
    $data['list_product_pagging'] = $list_product_pagging;
    $data['nameCat'] = $nameCat;
    load_view('proByCat', $data);
}

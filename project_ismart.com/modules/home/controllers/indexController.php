<?php
function construct()
{
    load_model('index');
}

// function indexAction()
// {
//     if (isset($_GET['q']) && !empty($_GET['q'])) {
//         $keySearch = $_GET['q'];
//         $list_product = get_list_product_search($keySearch);

//         // Set so ban ghi tren 1 trang
//         $num_per_page = 8;
//         // Tong so ban ghi
//         $total_row = numRowOfList($list_product);
//         // ==> So trang
//         $num_page = ceil($total_row / $num_per_page);
//         // Get page tu url, khong co mac dinh page=1
//         $page = isset($_GET['page']) ? $_GET['page'] : 1;
//         // Tinh so ban ghi bat dau cua moi trang
//         $start = ($page - 1) * $num_per_page;
//         // Lay danh sach theo phan trang
//         $list_product_pagging = get_list_product_search_pagging($start, $num_per_page, "products.name like '%{$keySearch}%'");

//         $list_category = get_list_category();
//         $data['page'] = $page;
//         $data['num_page'] = $num_page;
//         $data['keySearch'] = $keySearch;
//         $data['list_category'] = $list_category;
//         $data['list_product_pagging'] = $list_product_pagging ;
//         load_view('search', $data);
//     }
//     $list_category = get_list_category();
//     $data['list_category'] = $list_category;
//     load_view('index', $data);
// }

function indexAction()
{
    $productDAL = new ProductDAL();
    $categoryDAL = new CategoryDAL();
    $categories = $categoryDAL->getObjects();

    // Set so san pham tren 1 page
    $item_per_page = 20;

    // Tính toán số page 
    $num_product = $productDAL->countItems('id', "deleted_at IS NULL AND amount > 0")[0];
    $num_page = ceil($num_product / $item_per_page);

    // Get page hien tai, mac dinh page  = 1
    $page_current = (isset($_GET['page'])) ? $_GET['page'] : 1;
    // Get những sản phẩm thuộc page hiện tại
    $products = $productDAL->getObjects($page_current, "deleted_at IS NULL AND amount > 0", $item_per_page);

    // Xử lý tìm kiếm
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        if (!empty($q)) {
            // Tinh toán số page
            $num_product = $productDAL->countItems('id', "(`name` LIKE '%{$q}%' OR `id` LIKE '%{$q}%') AND amount > 0 AND deleted_at IS NULL")[0];
            $num_page = ceil($num_product / $item_per_page);

            // Get nhung san pham theo tu khoa tim kiem
            $products = $productDAL->getObjects($page_current, "(`name` LIKE '%{$q}%' OR `id` LIKE '%{$q}%') AND amount > 0 AND deleted_at IS NULL", $item_per_page);
        }
    }

    $data = [
        'categories' => $categories,
        'products' => $products,
        'num_page' => $num_page,
        'page_current' => $page_current
    ];
    if (!empty($q)) {
        $data['q'] = $q;
    }
    load_view('index', $data);
}

function productByCatAction()
{
    $idCat = (int) $_GET['id'];
    $productDAL = new ProductDAL();
    $categoryDAL = new CategoryDAL();
    $categories = $categoryDAL->getObjects();

    // Set so san pham tren 1 trang
    $item_per_page = 20;

    // Tinh toan so page
    $num_product = $productDAL->countItems('id', "category_id = {$idCat} AND amount > 0 AND deleted_at IS NULL")[0];
    $num_page = ceil($num_product / $item_per_page);

    // Lay  so trang hien tai, khong co mac dinh = 1
    $page_current = (isset($_GET['page'])) ? $_GET['page'] : 1;

    // Get san pham theo danh muc
    $products = $productDAL->getObjects($page_current, "category_id = {$idCat} AND amount > 0 AND deleted_at IS NULL", $item_per_page);

    $data = [
        'categories' => $categories,
        'products' => $products,
        'num_page' => $num_page,
        'page_current' => $page_current
    ];

    load_view('index', $data);
}

function detailAction()
{
    $id = $_GET['id'];

    $categoryDAL = new CategoryDAL();
    $productDAL = new ProductDAL();
    $ramDAL = new RamDAL();
    $romDAL = new RomDAL();
    $categories = $categoryDAL->getObjects();
    $product = $productDAL->getObject("'{$id}'", "deleted_at IS NULL AND amount > 0");
    if (is_object($product)) {
        $data = [
            'categories' => $categories,
            'product' => $product,
            'ramDAL' => $ramDAL,
            'romDAL' => $romDAL
        ];
        load_view('detailProduct', $data);
    } else {
        header("Location:?");
    }
}

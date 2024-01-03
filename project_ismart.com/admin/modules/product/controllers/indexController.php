<?php

use WindowsAzure\Common\Internal\Atom\Category;

function construct()
{
    // Dùng chung, load đầu tiên
    load_model('index');
}

function indexAction()
{
    $productDAL = new ProductDAL();
    $products = $productDAL->getObjects();
    $status = isset($_GET['status']) ? $_GET['status'] : 'active';
    $pageCurrent = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemPerPage = 6;
    $totalProductActive = $productDAL->countItems('id', 'deleted_at IS NULL')[0];
    $totalProductTrash = $productDAL->countItems('id', 'deleted_at IS NOT NULL')[0];
    if ($status == "active") {
        $list_act = [
            'delete' => 'Xóa',
        ];
        $totalRow = $productDAL->countItems('id', 'deleted_at IS NULL')[0];
        $numPage = ceil($totalRow / $itemPerPage);
        $products = $productDAL->getObjects($pageCurrent, 'deleted_at IS NULL', $itemPerPage);
        if (isset($_GET['q'])) {
            $keySearch = $_GET['q'];
            $products = $productDAL->getObjects($pageCurrent, "(`name` LIKE '%{$keySearch}%' OR `id` LIKE '%{$keySearch}%') AND deleted_at IS NULL", $itemPerPage);
            $totalRow = $productDAL->countItems('id', "(`name` LIKE '%{$keySearch}%' OR `id` LIKE '%{$keySearch}%') AND deleted_at IS NULL")[0];
            $numPage = ceil($totalRow / $itemPerPage);
        }
    } else {
        $list_act = [
            'restore' => 'Khôi phục',
            'forceDelete' => 'Xóa vĩnh viên'
        ];
        $totalRow = $productDAL->countItems('id', 'deleted_at IS NOT NULL')[0];
        $numPage = ceil($totalRow / $itemPerPage);
        $products = $productDAL->getObjects($pageCurrent, 'deleted_at IS NOT NULL', $itemPerPage);
        if (isset($_GET['q'])) {
            $keySearch = $_GET['q'];
            $products = $productDAL->getObjects($pageCurrent, "(`name` LIKE '%{$keySearch}%' OR `id` LIKE '%{$keySearch}%') AND deleted_at IS NOT NULL", $itemPerPage);
            $totalRow = $productDAL->countItems('id', "(`name` LIKE '%{$keySearch}%' OR `id` LIKE '%{$keySearch}%') AND deleted_at IS NOT NULL")[0];
            $numPage = ceil($totalRow / $itemPerPage);
        }
    }
    $data = [
        'products' => $products,
        'list_act' => $list_act,
        'totalProductActive' => $totalProductActive,
        'totalProductTrash' => $totalProductTrash,
        'page' => $pageCurrent,
        'status' => $status,
        'numPage' => $numPage,
    ];
    if (isset($keySearch)) {
        $data['keySearch'] = $keySearch;
    }
    load_view('show', $data);
}

function addAction()
{
    $productDAL = new ProductDAL();
    $ramDAL = new RamDAL();
    $romDAL = new RomDAL();
    $colorDAL = new ColorDAL();
    $categoryDAL = new CategoryDAL();
    $rams = $ramDAL->getObjects();
    $roms = $romDAL->getObjects();
    $colors = $colorDAL->getObjects();
    $categories = $categoryDAL->getObjects();

    global $error, $code, $nameProduct, $price, $amount, $ram, $rom, $color, $shortDesc, $detailDesc, $category;
    if (isset($_POST['btn_add'])) {
        // Kiem tra ma code
        if (empty($_POST['code'])) {
            $error['code'] = "Không được để trống mã code!";
        } else {
            $code = $_POST['code'];
        }

        // Kiem tra ten 
        if (empty($_POST['nameProduct'])) {
            $error['nameProduct'] = "Không được để trống tên điện thoại!";
        } else {
            $nameProduct = $_POST['nameProduct'];
        }

        // Kiểm tra giá sản phẩm
        if (empty($_POST['price'])) {
            $error['price'] = "Không được để trống giá điện thoại!";
        } else {
            $price = $_POST['price'];
        }

        // Kiểm tra số lượng sản phẩm
        if (empty($_POST['amount'])) {
            $error['amount'] = "Không được để trống số lượng điện thoại!";
        } else {
            $amount = $_POST['amount'];
        }

        // Kiểm tra trường RAM
        if (empty($_POST['ram'])) {
            $error['ram'] = "Bạn chưa chọn dung lượng RAM cho điện thoại!";
        } else {
            $ram = $_POST['ram'];
        }

        // Kiểm tra trường ROM
        if (empty($_POST['rom'])) {
            $error['rom'] = "Bạn chưa chọn bộ nhớ ROM cho điện thoại!";
        } else {
            $rom = $_POST['rom'];
        }

        // Kiểm tra màu 
        if (empty($_POST['color'])) {
            $error['color'] = "Vui lòng chọn màu sắc điện thoại!";
        } else {
            $color = $_POST['color'];
        }


        // Kiem tra danh muc san pham
        if (empty($_POST['category'])) {
            $error['category_id'] = "Bạn chưa chọn danh mục sản phẩm";
        } else {
            $category = $_POST['category'];
        }

        // Kiem tra shortDesc
        $shortDesc = '';
        if (!empty($_POST['shortDesc'])) {
            $shortDesc = $_POST['shortDesc'];
        }

        // Kiem tra detailDesc
        $detailDesc = '';
        if (!empty($_POST['detailDesc'])) {
            $detailDesc = $_POST['detailDesc'];
        }

        // ================================================================================ //
        // ================================ Kiem tra imageUrl ============================= //
        // ================================================================================ //
        // Kiem tra xem da chon file
        if (!empty($_FILES['file_image_thumbnail']['name'])) {
            // Tạo thư mục chứa file upload
            $upload_dir = 'public/images/products/';
            // Tạo đường dẫn của file sau khi upload
            $upload_file = $upload_dir . $_FILES['file_image_thumbnail']['name'];
            // Xử lý upload đúng file ảnh
            $type_allow = array('jpg', 'png', 'gif', 'jpeg'); // Các kiểu file được phép upload
            $type = pathinfo($_FILES['file_image_thumbnail']['name'], PATHINFO_EXTENSION); // Lấy đuôi file
            if (!in_array(strtolower($type), $type_allow)) {
                $error['file_image_thumbnail'] = 'Chỉ được upload file có đuôi jpg, png, jpeg, gif';
            } else {
                //Upload file có kích thước cho phép (size file <= 300000000)
                $size_file = $_FILES['file_image_thumbnail']['size'];
                if ($size_file > 30000000) {
                    $error['file_image_thumbnail'] = 'Kích thước file không được vượt qua 20MB';
                }
                //Kiểm tra trùng file trên hệ thống
                if (file_exists($upload_file)) {
                    //=====================================
                    // Xử lý đổi tên file tự động
                    //=================================
                    $filename = pathinfo($_FILES['file_image_thumbnail']['name'], PATHINFO_FILENAME); // Lấy tên file
                    $new_filename = $filename . "-copy."; // Đặt tên mới cho file
                    $new_upload_file = $upload_dir . $new_filename . $type;
                    $k = 1;
                    while (file_exists($new_upload_file)) {
                        $new_filename = $filename . "-copy({$k}).";
                        $k++;
                        $new_upload_file = $upload_dir . $new_filename . $type;
                    }
                    $upload_file = $new_upload_file;
                }
            }
        } else {
            $error['file_image_thumbnail'] = "Vui long chon anh san pham";
        }

        // Thêm sản phẩm khi không còn lỗi
        if (empty($error)) {
            if (move_uploaded_file($_FILES['file_image_thumbnail']['tmp_name'], $upload_file)) {
                $productDTO = new ProductDTO($code, $nameProduct, $price, $amount, $shortDesc, $detailDesc, $upload_file, Date('Y-m-d H:i:s', time()), NULL, NULL, $ram, $rom, $color, $category, 1);
                $idProductAddRecently = $productDAL->addProduct($productDTO);
                echo "<script type='text/javascript'>alert('Thêm thành công!');</script>";
            }
        }
    }

    $data = [
        'error' => $error,
        'code' => $code,
        'nameProduct' => $nameProduct,
        'price' => $price,
        'amount' => $amount,
        'ram' => $ram,
        'rom' => $rom,
        'color' => $color,
        'category' => $category,
        'shortDesc' => $shortDesc,
        'detailDesc' => $detailDesc,
        'rams' => $rams,
        'roms' => $roms,
        'colors' => $colors,
        'categories' => $categories
    ];
    load_view('add', $data);
}

function editAction()
{
    $id = $_GET['id'];
    $productDAL = new ProductDAL();
    $product = $productDAL->getObject("'{$id}'");
    if (is_object($product)) {
        $ramDAL = new RamDAL();
        $romDAL = new RomDAL();
        $colorDAL = new ColorDAL();
        $categoryDAL = new CategoryDAL();
        $rams = $ramDAL->getObjects();
        $roms = $romDAL->getObjects();
        $colors = $colorDAL->getObjects();
        $categories = $categoryDAL->getObjects();

        global $error, $code, $nameProduct, $price, $amount, $ram, $rom, $color, $shortDesc, $detailDesc, $category;
        if (isset($_POST['btn_edit'])) {
            // Kiem tra ma code
            if (empty($_POST['code'])) {
                $error['code'] = "Không được để trống mã code!";
            } else {
                $code = $_POST['code'];
                // $product->setId($code);
            }

            // Kiem tra ten 
            if (empty($_POST['nameProduct'])) {
                $error['nameProduct'] = "Không được để trống tên điện thoại!";
            } else {
                $nameProduct = $_POST['nameProduct'];
                $product->setName($nameProduct);
            }

            // Kiểm tra giá sản phẩm
            if (empty($_POST['price'])) {
                $error['price'] = "Không được để trống giá điện thoại!";
            } else {
                $price = $_POST['price'];
                $product->setPrice($price);
            }

            // Kiểm tra số lượng sản phẩm
            if (empty($_POST['amount'])) {
                $error['amount'] = "Không được để trống số lượng điện thoại!";
            } else {
                $amount = $_POST['amount'];
                $product->setAmount($amount);
            }

            // Kiểm tra trường RAM
            if (empty($_POST['ram'])) {
                $error['ram'] = "Bạn chưa chọn dung lượng RAM cho điện thoại!";
            } else {
                $ram = $_POST['ram'];
                $product->setRamId($ram);
            }

            // Kiểm tra trường ROM
            if (empty($_POST['rom'])) {
                $error['rom'] = "Bạn chưa chọn bộ nhớ ROM cho điện thoại!";
            } else {
                $rom = $_POST['rom'];
                $product->setRomId($rom);
            }

            // Kiểm tra màu 
            if (empty($_POST['color'])) {
                $error['color'] = "Vui lòng chọn màu sắc điện thoại!";
            } else {
                $color = $_POST['color'];
                $product->setColorId($color);
            }


            // Kiem tra danh muc san pham
            if (empty($_POST['category'])) {
                $error['category_id'] = "Bạn chưa chọn danh mục sản phẩm";
            } else {
                $category = $_POST['category'];
                $product->setCategoryId($category);
            }

            // Kiem tra shortDesc
            if (!empty($_POST['shortDesc'])) {
                $shortDesc = $_POST['shortDesc'];
                $product->setShortDesc($shortDesc);
            }

            // Kiem tra detailDesc
            if (!empty($_POST['detailDesc'])) {
                $detailDesc = $_POST['detailDesc'];
                $product->setDetailDesc($detailDesc);
            }

            // ================================================================================ //
            // ================================ Kiem tra imageUrl ============================= //
            // ================================================================================ //
            // Kiem tra xem da chon file anh thumbnail
            if (!empty($_FILES['file_image_thumbnail']['name'])) {
                // Tạo thư mục chứa file upload
                $upload_dir = 'public/images/products/';
                // Tạo đường dẫn của file sau khi upload
                $upload_file = $upload_dir . $_FILES['file_image_thumbnail']['name'];
                // Xử lý upload đúng file ảnh
                $type_allow = array('jpg', 'png', 'gif', 'jpeg'); // Các kiểu file được phép upload
                $type = pathinfo($_FILES['file_image_thumbnail']['name'], PATHINFO_EXTENSION); // Lấy đuôi file
                if (!in_array(strtolower($type), $type_allow)) {
                    $error['file_image_thumbnail'] = 'Chỉ được upload file có đuôi jpg, png, jpeg, gif';
                } else {
                    //Upload file có kích thước cho phép (size file <= 300000000)
                    $size_file = $_FILES['file_image_thumbnail']['size'];
                    if ($size_file > 30000000) {
                        $error['file_image_thumbnail'] = 'Kích thước file không được vượt qua 20MB';
                    }
                    //Kiểm tra trùng file trên hệ thống
                    if (file_exists($upload_file)) {
                        //=====================================
                        // Xử lý đổi tên file tự động
                        //=================================
                        $filename = pathinfo($_FILES['file_image_thumbnail']['name'], PATHINFO_FILENAME); // Lấy tên file
                        $new_filename = $filename . "-copy."; // Đặt tên mới cho file
                        $new_upload_file = $upload_dir . $new_filename . $type;
                        $k = 1;
                        while (file_exists($new_upload_file)) {
                            $new_filename = $filename . "-copy({$k}).";
                            $k++;
                            $new_upload_file = $upload_dir . $new_filename . $type;
                        }
                        $upload_file = $new_upload_file;
                    }
                }
            }

            // Cập nhật sản phẩm khi không còn lỗi
            if (empty($error)) {
                if (!empty($_FILES['file_image_thumbnail']['name'])) {
                    move_uploaded_file($_FILES['file_image_thumbnail']['tmp_name'], $upload_file);
                    $product->setImageUrl($upload_file);
                }
                $idProductAddRecently = $productDAL->updateProduct($product);
                echo "<script type='text/javascript'>alert('Cập nhật sản phẩm thành công!');</script>";
                header("Refresh:0.01");
            }
        }

        $data = [
            'product' => $product,
            'error' => $error,
            'nameProduct' => $nameProduct,
            'price' => $price,
            'amount' => $amount,
            'ram' => $ram,
            'rom' => $rom,
            'color' => $color,
            'category' => $category,
            'shortDesc' => $shortDesc,
            'detailDesc' => $detailDesc,
            'rams' => $rams,
            'roms' => $roms,
            'colors' => $colors,
            'categories' => $categories
        ];
        load_view('edit', $data);
    } else {
        header("Location:?mod=product");
    }
}

function deleteAction()
{
    $id = $_GET['id'];
    $productDAL = new ProductDAL();
    $product = $productDAL->getObject("'{$id}'");
    if (is_object($product)) {
        $productDAL->deleteProduct($product);
        echo "<script type='text/javascript'>alert('Bạn đã xóa thành công!');</script>";
        header("Refresh: 0.0001; URL=?mod=product");
    } else {
        header("Location:?mod=product");
    }
}

function forceDeleteAction()
{
    $productDAL = new ProductDAL();
    $id = $_GET['id'];
    $productDTO = $productDAL->getObject("'{$id}'");
    if (is_object($productDTO)) {
        $productDAL->forceDelete($id);
        echo "<script type='text/javascript'>alert('Đã xóa vĩnh viễn sản phẩm khỏi hệ thống!');</script>";
        header("Refresh: 0.01; URL=?mod=product");
    } else {
        header("Location:?mod=product");
    }
}

function restoreAction()
{
    $productDAL = new ProductDAL();
    $id =  $_GET['id'];
    $productDTO = $productDAL->getObject("'{$id}'");
    if (is_object($productDTO)) {
        $productDAL->restore($productDTO);
        echo "<script type='text/javascript'>alert('Khôi phục thành công!');</script>";
        header("Refresh: 0.01; URL=?mod=product");
    } else {
        header("Location:?mod=product");
    }
}

function handlerTasksSametimeAction()
{
    $productDAL = new ProductDAL();
    global $config;
    if (!empty($_POST['list_check'])) {
        $list_check = $_POST['list_check'];
        $act = $_POST['action'];
        if ($act == 'delete') {
            $productDAL->deleteAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã xóa thành công!');</script>";
            header("Refresh: 0.0001; URL=?mod=product");
        } elseif ($act == 'restore') {
            $productDAL->restoreAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã khôi phục thành công!');</script>";
            header("Refresh: 0.0001; URL=?mod=product");
        } elseif ($act == 'forceDelete') {
            $productDAL->forceDeleteAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã xóa vĩnh viễn user khỏi hệ thống!');</script>";
            header("Refresh: 0.0001; URL=?mod=product");
        } else {
            echo "<script type='text/javascript'>alert('Vui lòng chọn thao tác để thực hiện!');</script>";
            header("Refresh: 0.0001; URL=?mod=product");
        }
    } else {
        echo "<script type='text/javascript'>alert('Vui lòng chọn phần tử để thực hiện thao tác!');</script>";
        header("Refresh: 0.0001; URL=?mod=product");
    }
}

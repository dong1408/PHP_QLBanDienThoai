<?php
get_header();
?>

<div id="page-body" class="d-flex">
    <?php
    get_sidebar();
    ?>

    <div id="wp-content">
        <div id="content" class="container-fluid">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0 ">Danh sách sản phẩm</h5>
                    <div class="form-search form-inline">
                        <form action="">
                            <input type="hidden" name="mod" value="product">
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                            <input type="text" name="q" value="<?php if (!empty($keySearch)) echo $keySearch ?>" class="form-control form-search" placeholder="Tìm kiếm">
                            <button type="submit" name="" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="analytic">
                        <a href="<?php echo base_url("admin/?mod=product&status=active") ?>" class="text-primary" <?php if ($status == 'active') echo "style='color: red!important;'" ?>>Kích hoạt<span class="text-muted">(<?php echo $totalProductActive ?>)</span></a>
                        <a href="<?php echo base_url("admin/?mod=product&status=trash") ?>" class="text-primary" <?php if ($status != 'active') echo "style='color: red!important;'" ?>>Vô hiệu hóa<span class="text-muted">(<?php echo $totalProductTrash ?>)</span></a>
                    </div>
                    <form action="?mod=product&action=handlerTasksSametime" method="POST">
                        <div class="form-action form-inline py-3">
                            <select class="form-control mr-1" id="" name="action">
                                <option>Chọn</option>
                                <?php
                                foreach ($list_act as $key => $value) {
                                ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        </div>
                        <div class="scrollable-container" style="overflow-x:auto; width:100%">
                            <table class="table table-striped table-checkall">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input name="checkall" type="checkbox">
                                        </th>
                                        <th scope="col">#</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($products != 0) {
                                        $t = 0;
                                        foreach ($products as $product) {
                                    ?>
                                            <tr class="">
                                                <td>
                                                    <input type="checkbox" name="list_check[]" value="<?php echo $product->getId() ?>">
                                                </td>
                                                <td><?php echo $t++ ?></td>
                                                <td><img src="<?php echo $product->getImageUrl() ?>" width="100px" alt=""></td>
                                                <td><a href="#"><?php echo $product->getName() ?></a></td>
                                                <td><?php echo $product->getPrice() ?></td>
                                                <td>Điện thoại</td>
                                                <td><?php echo $product->getCreatedAt() ?></td>
                                                <td><span class="badge badge-success">Còn hàng</span></td>
                                                <?php
                                                if ($status == "active") {
                                                ?>
                                                    <td>
                                                        <a href="<?php echo base_url("admin/?mod=product&action=edit&id={$product->getId()}") ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url("admin/?mod=product&action=delete&id={$product->getId()}") ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm?')"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td>
                                                        <a href="<?php echo base_url("admin/?mod=product&action=restore&id={$product->getId()}") ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore" onclick="return confirm('Bạn có muốn khôi phục?')"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                                        <a href="<?php echo base_url("admin/?mod=product&action=forceDelete&id={$product->getId()}") ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Force Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm khỏi hệ thống vĩnh viễn?')"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">Không tìm thấy kết quả phù hợp.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <nav aria-label="Page navigation example">
                        <?php
                        if (!empty($keySearch)) {
                            get_pagging($numPage, $page, "?mod=product&status={$status}&q={$keySearch}");
                        } else {
                            get_pagging($numPage, $page, "?mod=product&status={$status}");
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
get_footer();
?>
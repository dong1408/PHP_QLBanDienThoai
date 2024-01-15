<?php
$userDAL = new UserDAL();
?>

<div id="sidebar" class="bg-white">
    <ul id="sidebar-menu">

        <?php
        if ($userDAL->hasPermission('dashboard.view')) {
        ?>
            <li class="nav-link">
                <a href="?view=dashboard">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Dashboard
                </a>
                <i class="arrow fas fa-angle-right"></i>
            </li>
        <?php
        }
        ?>


        <!-- <li class="nav-link">
            <a href="?view=list-post">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Trang
            </a>
            <i class="arrow fas fa-angle-right"></i>

            <ul class="sub-menu">
                <li><a href="?view=add-post">Thêm mới</a></li>
                <li><a href="?view=list-post">Danh sách</a></li>
            </ul>
        </li> -->


        <?php
        if ($userDAL->hasPermission('product.view') || $userDAL->hasPermission('product.add') || $userDAL->hasPermission('product.edit') || $userDAL->hasPermission('product.delete' || $userDAL->hasPermission('category.view') || $userDAL->hasPermission('category.edit') || $userDAL->hasPermission('category.view') || $userDAL->hasPermission('category.add') || $userDAL->hasPermission('category.delete'))) {
        ?>
            <li class="nav-link">
                <a href="<?php echo base_url("admin/?mod=product") ?>">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Sản phẩm
                </a>
                <i class="arrow fas fa-angle-right"></i>
                <ul class="sub-menu">
                    <?php
                    if ($userDAL->hasPermission('product.add')) {
                    ?>
                        <li><a href="<?php echo base_url("admin/?mod=product&action=add") ?>">Thêm mới</a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if ($userDAL->hasPermission('product.view') || $userDAL->hasPermission('product.edit') || $userDAL->hasPermission('product.delete')) {
                    ?>
                        <li><a href="<?php echo base_url("admin/?mod=product") ?>">Danh sách</a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if ($userDAL->hasPermission('category.view') || $userDAL->hasPermission('category.edit') || $userDAL->hasPermission('category.view') || $userDAL->hasPermission('category.add') || $userDAL->hasPermission('category.delete')) {
                    ?>
                        <li><a href="<?php echo base_url("admin/?mod=category") ?>">Danh mục</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
        ?>


        <?php
        if ($userDAL->hasPermission('order.view')) {
        ?>
            <li class="nav-link">
                <a href="?mod=order">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Bán hàng
                </a>
                <i class="arrow fas fa-angle-right"></i>
                <ul class="sub-menu">
                    <li><a href="?mod=order">Đơn hàng</a></li>
                </ul>
            </li>
        <?php
        }
        ?>


        <?php
        if ($userDAL->hasPermission('user.view') || $userDAL->hasPermission('user.add') || $userDAL->hasPermission('user.edit') || $userDAL->hasPermission('user.delete')) {
        ?>
            <li class="nav-link">
                <a href="?mod=user">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Users
                </a>
                <i class="arrow fas fa-angle-right"></i>

                <ul class="sub-menu">
                    <?php
                    if ($userDAL->hasPermission('user.add')) {
                    ?>
                        <li><a href="<?php echo base_url('admin/?mod=user&action=add') ?>">Thêm mới</a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if ($userDAL->hasPermission('user.view') || $userDAL->hasPermission('user.edit') || $userDAL->hasPermission('user.delete')) {
                    ?>
                        <li><a href="<?php echo base_url('admin/?mod=user') ?>">Danh sách</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
        ?>

        <li class="nav-link">
            <a href="?mod=statistical">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Thống kê
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                <li><a href="?mod=statistical&statistical=time">Thời gian</a></li>
                <li><a href="?mod=statistical&statistical=staff">Nhân viên</a></li>
                <li><a href="?mod=statistical&statistical=cus">Khách hàng</a></li>
                <li><a href="?mod=statistical&statistical=product">Sản phẩm</a></li>
            </ul>
        </li>


        <?php
        if ($userDAL->hasPermission('role.view') || $userDAL->hasPermission('role.add') || $userDAL->hasPermission('role.edit') || $userDAL->hasPermission('role.delete') || $userDAL->hasPermission('permission.view') || $userDAL->hasPermission('permission.add') || $userDAL->hasPermission('permission.edit') || $userDAL->hasPermission('permission.delete')) {
        ?>
            <li class="nav-link active">
                <a href="?mod=permission">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Phân quyền
                </a>
                <i class="arrow fas fa-angle-right"></i>
                <ul class="sub-menu">
                    <?php
                    if ($userDAL->hasPermission('permission.view') || $userDAL->hasPermission('permission.add') || $userDAL->hasPermission('permission.edit') || $userDAL->hasPermission('permission.delete')) {
                    ?>
                        <li><a href="?mod=permission">Quyền</a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if ($userDAL->hasPermission('role.add')) {
                    ?>
                        <li><a href="?mod=role&action=add">Thêm vai trò</a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if ($userDAL->hasPermission('role.view') || $userDAL->hasPermission('role.edit') || $userDAL->hasPermission('role.delete')) {
                    ?>
                        <li><a href="?mod=role">Danh sách vai trò</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
        ?>


        <!-- <li class="nav-link"><a>Bài viết</a>
                        <ul class="sub-menu">
                            <li><a>Thêm mới</a></li>
                            <li><a>Danh sách</a></li>
                            <li><a>Thêm danh mục</a></li>
                            <li><a>Danh sách danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link"><a>Sản phẩm</a></li>
                    <li class="nav-link"><a>Đơn hàng</a></li>
                    <li class="nav-link"><a>Hệ thống</a></li> -->

    </ul>
</div>
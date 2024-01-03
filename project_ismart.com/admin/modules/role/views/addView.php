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
                    <h5 class="m-0 ">Thêm mới vai trò</h5>
                    <div class="form-search form-inline">
                        <form action="#">
                            <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="text-strong" for="nameRole">Tên vai trò</label>
                            <input class="form-control" type="text" name="nameRole" id="nameRole">
                            <?php
                            if (!empty($error['nameRole'])) {
                                echo "<p style='color:red'>{$error['nameRole']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="text-strong" for="description">Mô tả</label>
                            <textarea class="form-control" type="text" name="description" id="description"></textarea>
                            <?php
                            if (!empty($error['description'])) {
                                echo "<p style='color:red'>{$error['description']}</p>";
                            }
                            ?>
                        </div>
                        <strong>Vai trò này có quyền gì?</strong>
                        <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn quyền.</small>
                        <!-- List Permission  -->

                        <?php
                        if (!empty($permissions)) {
                            foreach ($permissions as $moduleName => $modulePermission) {
                        ?>
                                <div class="card my-4 border">
                                    <div class="card-header">
                                        <input type="checkbox" class="check-all" name="" id="<?php echo $moduleName ?>">
                                        <label for="<?php echo $moduleName ?>" class="m-0"><?php echo "Module " . $moduleName ?></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            foreach ($modulePermission as $permission) {
                                            ?>
                                                <div class="col-md-3">
                                                    <input type="checkbox" class="permission" value="<?php echo $permission->getId() ?>" name="list_permission_id[]" id="<?php echo $permission->getName() ?>">
                                                    <label for="<?php echo $permission->getName() ?>"><?php echo $permission->getName() ?></label>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <input type="submit" name="btn_add" class="btn btn-primary" value="Thêm mới">
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('.check-all').click(function() {
                $(this).closest('.card').find('.permission').prop('checked', this.checked)
            })
        </script>
    </div>
</div>

<?php
get_footer();
?>
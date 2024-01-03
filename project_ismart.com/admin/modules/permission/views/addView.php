<?php
get_header();
?>

<div id="page-body" class="d-flex">
    <?php
    get_sidebar();
    ?>
    <div id="wp-content">
        <div id="content" class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm quyền
                        </div>
                        <div class="card-body">
                            <?php
                            global $error, $namePermission, $slug, $description;
                            ?>
                            <form action="?mod=permission&action=add" method="POST">
                                <div class="form-group">
                                    <label for="name">Tên quyền</label>
                                    <input class="form-control" type="text" name="namePermission" id="name" value="<?php if (!empty($namePermission)) echo $namePermission ?>">
                                    <?php
                                    if (!empty($error['namePermission'])) {
                                        echo "<p style='color:red'>{$error['namePermission']}</p>";
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <small class="form-text text-muted pb-2">Ví dụ: posts.add</small>
                                    <input class="form-control" type="text" name="slug" id="slug" value="<?php if (!empty($slug)) echo $slug ?>">
                                    <?php
                                    if (!empty($error['slug'])) {
                                        echo "<p style='color:red'>{$error['slug']}</p>";
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" type="text" name="description" id="description"><?php if (!empty($description)) echo $description ?></textarea>
                                </div>
                                <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Danh sách quyền
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên quyền</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($permissions as $moduleName => $modulePermission) {
                                    ?>
                                        <tr>
                                            <td scope="row"></td>
                                            <td colspan="3"><strong><?php echo ucfirst($moduleName) ?></strong></td>
                                        </tr>
                                        <?php
                                        $t = 0;
                                        foreach ($modulePermission as $permission) {
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo $t++ ?></td>
                                                <td>|---<?php echo $permission->getName() ?></td>
                                                <td><?php echo $permission->getSlug() ?></td>
                                                <td>
                                                    <a href="?mod=permission&action=edit&id=<?php echo $permission->id ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="?mod=permission&action=delete&id=<?php echo $permission->id ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa quyền này khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
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
                    <h5 class="m-0 ">Danh sách vai trò</h5>
                    <div class="form-search form-inline">
                        <form action="">
                            <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                            <button type="submit" name="" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="">
                            <option>Chọn</option>
                            <option>Tác vụ 1</option>
                            <option>Tác vụ 2</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Vai trò</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $t = 0;
                            foreach ($roles as $role) {
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                    <td scope="row"><?php echo $t++ ?></td>
                                    <td><a href="?mod=role&action=edit&id=<?php echo $role->id ?>"><?php echo $role->getName() ?></a></td>
                                    <td><?php echo $role->getDescription() ?></td>
                                    <td><?php echo $role->getCreatedAt() ?></td>
                                    <td>
                                        <a href="?mod=role&action=edit&id=<?php echo $role->id ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="?mod=role&action=delete&id=<?php echo $role->id ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa vai trò này khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                                    </td>

                                </tr>
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

<?php
get_footer();
?>
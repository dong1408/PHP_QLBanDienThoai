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
                    <h5 class="m-0 ">Danh sách thành viên</h5>                    
                    <div class="form-search form-inline">
                        <form action="">
                            <input type="hidden" name="mod" value="user">
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                            <input type="text" name="q" value="<?php if (!empty($search)) echo $search ?>" class="form-control form-search" placeholder="Tìm kiếm">
                            <!-- <input type="submit" name="" value="Tìm kiếm" class="btn btn-primary"> -->
                            <button type="submit" name="" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="analytic">
                        <a href="<?php echo base_url('admin/?mod=user&status=active') ?>" <?php if ($status == 'active') echo "style='color:red!important'" ?> class="text-primary">Kích hoạt<span class="text-muted">(<?php echo $countUserActive ?>)</span></a>
                        <a href="<?php echo base_url('admin/?mod=user&status=trash') ?>" <?php if ($status != 'active') echo "style='color:red!important'" ?> class="text-primary">Vô hiệu hóa<span class="text-muted">(<?php echo $countUserTrash ?>)</span></a>
                    </div>
                    <form action="?mod=user&action=handlerTasksSametime" method="POST">
                        <div class="form-action form-inline py-3">
                            <select name="action" class="form-control mr-1" id="">
                                <option>Chọn</option>
                                <?php
                                foreach ($list_act as $key => $value) {
                                ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <input type="submit" name="btn_handler_tasks" value="Áp dụng" class="btn btn-primary">
                        </div>
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Vai trò</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($users != 0) {
                                    $t = 0;
                                    foreach ($users as $user) {
                                ?>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="list_check[]" value="<?php echo $user->id ?>">
                                            </td>
                                            <th scope="row"><?php echo $t++ ?></th>
                                            <td><?php echo $user->username ?></td>
                                            <td><?php echo $user->email ?></td>
                                            <td>
                                                <?php
                                                $rolesOfUser = $userDAL->getRolesOfUser($user->getId());
                                                if (is_array($rolesOfUser)) {
                                                    foreach ($rolesOfUser as $role) {
                                                ?>
                                                        <a href="<?php echo base_url("admin/?mod=role&action=edit&id={$role->id}") ?>"><span class="badge badge-warning"><?php echo $role->getName() ?></span></a>
                                                <?php
                                                    }
                                                } else {
                                                    echo "";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $user->createdAt ?></td>
                                            <td>
                                                <?php
                                                if ($status == 'active') {
                                                ?>
                                                    <?php
                                                    if ($userDAL->hasPermission('user.edit')) {
                                                    ?>
                                                        <a href="?mod=user&action=edit&id=<?php echo $user->id ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($userDAL->hasPermission('user.delete')) {
                                                    ?>
                                                        <a href="?mod=user&action=delete&id=<?php echo $user->id ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                } else {
                                                ?>
                                                    <?php
                                                    if ($userDAL->hasPermission('user.delete')) {
                                                    ?>
                                                        <a href="?mod=user&action=restore&id=<?php echo $user->id ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore" onclick="return confirm('Bạn có muốn khôi phục?')"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                                        <a href="?mod=user&action=forceDelete&id=<?php echo $user->id ?>" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Force Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn khỏi hệ thống?')"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
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
                    </form>
                    <nav aria-label="Page navigation example">
                        <!-- <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">Trước</span>
                                    <span class="sr-only">Sau</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul> -->
                        <?php
                        if (!empty($search)) {
                            get_pagging($numPage, $page, "?mod=user&status={$status}&q={$search}");
                        } else {
                            get_pagging($numPage, $page, "?mod=user&status={$status}");
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
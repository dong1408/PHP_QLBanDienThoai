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
                <div class="card-header font-weight-bold">
                    Thêm người dùng
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" id="name" value="<?php if (!empty($username)) echo $username ?>">
                            <?php
                            if (!empty($error['username'])) {
                                echo "<p style='color:red'>{$error['username']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?php if (!empty($email)) echo $email ?>">
                            <?php
                            if (!empty($error['email'])) {
                                echo "<p style='color:red'>{$error['email']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input class="form-control" type="password" name="password" id="password">
                            <?php
                            if (!empty($error['password'])) {
                                echo "<p style='color:red'>{$error['password']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="role">Vai trò</label><br>
                            <?php
                            foreach ($roles as $role) {
                            ?>
                                <input type="checkbox" name="roles_id[]" id="<?php echo $role->getId()?>" value="<?php echo $role->getId()?>">
                                <label for="<?php echo $role->getId()?>"><a href="<?php echo base_url("admin/?mod=role&action=edit&id={$role->id}") ?>"><?php echo $role->getName() ?></a></label><br>
                            <?php
                            }
                            ?>
                            <!-- <input type="checkbox" name="role[]" id="" value="">
                            <label for="">Vai trò 1</label><br>
                            <input type="checkbox" name="role[]" id="" value="">
                            <label for="">Vai trò 2</label><br>
                            <input type="checkbox" name="role[]" id="" value="">
                            <label for="">Vai trò 3</label> -->
                        </div>

                        <!-- <div class="form-group">
                            <label for="">Nhóm quyền</label>
                            <select class="form-control" id="">
                                <option>Chọn quyền</option>
                                <option>Danh mục 1</option>
                                <option>Danh mục 2</option>
                                <option>Danh mục 3</option>
                                <option>Danh mục 4</option>
                            </select>
                        </div> -->

                        <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
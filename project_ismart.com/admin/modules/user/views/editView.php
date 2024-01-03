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
                    Chỉnh sửa thông tin người dùng
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input class="form-control" type="text" name="username" id="name" value="<?php echo $user->getUsername() ?>">
                            <?php
                            if (!empty($error['username'])) {
                                echo "<p style='color:red'>{$error['username']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?php echo $user->getEmail() ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="role">Vai trò</label><br>
                            <?php
                            foreach ($roles as $role) {
                            ?>
                                <input type="checkbox" name="roles_id[]" id="<?php echo $role->getId() ?>" value="<?php echo $role->getId() ?>" <?php if(is_array($rolesOfUser) && in_array($role->getId(), $rolesOfUser)) echo "checked=checked" ?>>
                                <label for="<?php echo $role->getId() ?>"><?php echo $role->getName() ?></label><br>
                            <?php
                            }
                            ?>
                        </div>

                        <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
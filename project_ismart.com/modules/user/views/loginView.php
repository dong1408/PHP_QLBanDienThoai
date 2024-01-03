<?php
get_header();
?>

<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="wp-login">
            <h2 style="font-size: 20px; margin-bottom: 10px;">Đăng nhập</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username ?>" placeholder="Nhập tên đăng nhập">
                    <?php
                    if (!empty($error['username'])) {
                        echo "<p style='color:red'>" . $error['username'] . "</p>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" value="<?php if(!empty($password)) echo $password ?>"  placeholder="Nhập mật khẩu">
                    <?php
                    if (!empty($error['password']))
                        echo "<p style='color:red'>" . $error['password'] . "</p>";
                    ?>
                </div>
                <div class="form-group">
                    <input type="submit" id="btn-login" name="btn-login" value="Đăng nhập">
                </div>
                <div class="from-group">
                    <p style="text-align: center;"><a href="?mod=user&action=forgetPassword">Quên mật khẩu?</a></p>
                    <p style="text-align: center;">Chưa có tài khoản? <a href="?mod=user&action=register">( Đăng ký ngay )</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();
?>
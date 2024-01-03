<?php
get_header();
?>

<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="wp-login">
            <h2 style="font-size: 20px; margin-bottom: 10px;">Lấy lại mật khẩu</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php if(!empty($email)) echo $email ?>" placeholder="Nhập email">
                    <?php
                    if (!empty($error['email'])) {
                        echo "<p style='color:red'>" . $error['email'] . "</p>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input type="submit" id="btn-login" name="btn_reset_pass" value="Gửi yêu cầu">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();
?>
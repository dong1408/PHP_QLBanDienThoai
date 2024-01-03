<?php
get_header();
?>

<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="wp-register">
            <h2 style="font-size: 20px; margin-bottom: 10px;">Đăng ký</h2>
            <form action="" method="post">                
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" value="<?php if(!empty($username)) echo $username ?>" placeholder="Nhập tên đăng nhập">
                    <?php
                    if(!empty($error['username'])){
                        echo "<p class='error'>{$error['username']}</p>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                    <?php
                    if(!empty($error['password'])){
                        echo "<p class='error'>{$error['password']}</p>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php if(!empty($email)) echo $email ?>" placeholder="Nhập email">
                    <?php
                    if(!empty($error['email'])){
                        echo "<p class='error'>{$error['email']}</p>";
                    }
                    ?>
                </div>
                <!-- <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại">
                </div> -->
                <div class="form-group">
                    <button type="submit" id="btn-register" name="btn-register">Đăng ký</button>
                </div>
                <div class="from-group">
                    <p style="text-align: center;">Bạn đã có tài khoản? <a href="?mod=user&action=login">( Đăng nhập )</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();
?>
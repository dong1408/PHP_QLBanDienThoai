<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="public/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="public/reset.css" rel="stylesheet" type="text/css" />
    <link href="public/css/carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="public/css/carousel/owl.theme.css" rel="stylesheet" type="text/css" />
    <link href="public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="public/style.css" rel="stylesheet" type="text/css" />
    <link href="public/responsive.css" rel="stylesheet" type="text/css" />

    <script src="public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="public/js/elevatezoom-master/jquery.elevatezoom.js" type="text/javascript"></script>
    <!-- <script src="public/js/bootstrap/bootstrap.min.js" type="text/javascript"></script> -->
    <script src="public/js/carousel/owl.carousel.js" type="text/javascript"></script>
    <script src="public/js/main.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script> -->
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="?page=home" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="?page=category_product" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="?page=blog" title="">Blog</a>
                                </li>
                                <li>
                                    <a href="?page=detail_blog" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="?page=detail_blog" title="">Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="?page=home" title="" id="logo" class="fl-left"><img src="public/images/logo.png" /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="GET" action="">
                                <input type="text" name="q" id="s" placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" name="" id="sm-s">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <?php
                            if (isset($_SESSION['is_login'])) {
                            ?>
                                <ul id="login-info" class="fl-left">
                                    <li>
                                        <!-- <a href="?page=list_post" title="">Trang</a> -->
                                        <p id="test" style="padding:27px 0px 27px 8px; color:white; position: relative; right: 30px;"><?php echo $_SESSION['user_login'] ?></p>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="?page=add_page" title="">Thông tin tài khoản</a>
                                            </li>
                                            <li>
                                                <a href="?mod=user&action=order" title="">Đơn hàng</a>
                                            </li>
                                            <?php
                                            if (isset($_SESSION['is_admin'])) {
                                                global $config;
                                            ?>
                                                <li>
                                                    <a href="<?php echo $config['base_url'] . "admin/" ?>">Admin</a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                            <li>
                                                <a href="?mod=user&action=logout" title="">Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <div id="login" class="fl-left">
                                    <a href="?mod=user&action=login">
                                        <p style="padding:27px 0px 27px 8px; color:white; position: relative; right: 30px;">Đăng nhập</p>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">2</span>
                                </a> -->
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <a href="?mod=cart" style="color: white;">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <?php
                                        if (isset($_SESSION['cart']['buy']) && !empty($_SESSION['cart']['buy'])) {
                                        ?>
                                            <span id="num"><?php echo $_SESSION['cart']['info']['num_order'] ?></span>
                                        <?php
                                        }
                                        ?>
                                    </a>

                                </div>
                                <?php
                                if (isset($_SESSION['cart']['buy']) && !empty($_SESSION['cart']['buy'])) {
                                ?>
                                    <div id="dropdown">
                                        <p class="desc">Có <span><?php echo $_SESSION['cart']['info']['num_order'] ?> sản phẩm</span> trong giỏ hàng</p>
                                        <ul class="list-cart">
                                            <?php
                                            foreach ($_SESSION['cart']['buy'] as $item) {
                                            ?>
                                                <li class="clearfix">
                                                    <a href="" title="" class="thumb fl-left">
                                                        <img src="<?php echo "admin/" . $item['product_thumb'] ?>" alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="" title="" class="product-name"><?php echo $item['product_title'] ?></a>
                                                        <p class="price"><?php echo currency_format($item['price']) ?></p>
                                                        <p class="qty">Số lượng: <span><?php echo $item['qty'] ?></span></p>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right"><?php echo currency_format($_SESSION['cart']['info']['total']) ?></p>
                                        </div>
                                        <dic class="action-cart clearfix">
                                            <a href="?mod=cart" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="?mod=cart&action=checkout" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                        </dic>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
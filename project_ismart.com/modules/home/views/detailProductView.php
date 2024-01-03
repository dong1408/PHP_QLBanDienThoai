<?php
get_header();
?>

<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <img src="<?php echo base_url("admin/{$product->getImageUrl()}") ?>" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name"><?php echo $product->getName() ?></h3>
                        <div class="desc">
                            <p>Bộ vi xử lý: Intel Core i505200U 2.2 GHz (3MB L3)</p>
                            <p>Cache upto 2.7 GHz</p>
                            <p>Bộ nhớ RAM: <?php echo " " . $ramDAL->getObject($product->getRamID())->getValue() ?> (DDR3 Bus 1600 MHz)</p>
                            <p>Đồ họa: Intel HD Graphics</p>
                            <p>Ổ đĩa cứng: <?php echo " " . $romDAL->getObject($product->getRomID())->getValue() ?></p>
                        </div>
                        <!-- <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">Còn hàng</span>
                        </div> -->
                        <p class="price"><?php echo currency_format($product->getPrice()) ?></p>
                        <!-- <div id="num-order-wp">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="num_order" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                        </div> -->
                        <a href="?mod=cart&action=addCart&id=<?php echo $product->getId() ?>" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <!-- <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p> -->
                    <?php echo $product->getDetailDesc() ?>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-17.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-18.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-19.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-20.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-21.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-22.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-23.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop HP Probook 4430s</a>
                            <div class="price">
                                <span class="new">17.900.000đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <?php
            get_sidebar('category-product');
            ?>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
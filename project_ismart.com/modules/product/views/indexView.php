<?php
get_header();
?>

<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <!-- <div class="secion" id="breadcrumb-wp">
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
        </div> -->
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <img src="<?php echo "admin/" . $product['ImageUrl'] ?>" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name"><?php echo $product['Name'] ?></h3>
                        <div class="desc">
                            <p>Bộ vi xử lý :Intel Core i505200U 2.2 GHz (3MB L3)</p>
                            <p>Cache upto 2.7 GHz</p>
                            <p>Bộ nhớ RAM :4 GB (DDR3 Bus 1600 MHz)</p>
                            <p>Đồ họa :Intel HD Graphics</p>
                            <p>Ổ đĩa cứng :500 GB (HDD)</p>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status"><?php if ($product['Amount'] > 0) {
                                                        echo "<p>Còn hàng</p>";
                                                    } else {
                                                        echo "<p style='color:red'>Hết hàng</p>";
                                                    } ?></span>
                        </div>
                        <p class="price"><?php echo currency_format($product['Price']) ?></p>
                        <?php
                        if ($product['Amount'] > 0) {
                        ?>
                            <!-- <div id="num-order-wp">
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="num-order" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div> -->
                            <a href="?mod=cart&action=addCart&id=<?php echo $product['ProductID'] ?>" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <?php
                    echo $product['DetailDesc'];
                    ?>
                    <!-- <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p> -->
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        foreach ($list_product_by_cat as $item) {
                        ?>
                            <li>
                                <a href="<?php echo "?mod=product&id={$item['ProductID']}" ?>" title="" class="thumb">
                                    <img src="<?php echo "admin/{$item['ImageUrl']}" ?>">
                                </a>
                                <a href="<?php echo "?mod=product&id={$item['ProductID']}" ?>" title="" class="product-name"><?php echo $item['Name'] ?></a>
                                <div class="price">
                                    <span class="new"><?php echo currency_format($item['Price']) ?></span>
                                    <span class="old"><?php echo currency_format($item['Price']) ?></span>
                                </div>
                                <div class="action clearfix">
                                    <a href="?mod=product&id=<?php echo $item['ProductID'] ?>" class="detail-view">Xem chi tiết</a>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
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
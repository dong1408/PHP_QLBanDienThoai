<?php
get_header();
?>

<div id="main-content-wp" class="cart-page">
    <!-- <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Sản phẩm làm đẹp da</a>
                    </li>
                </ul>
            </div>
        </div>
    </div> -->
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <?php
            if (!empty($_SESSION['cart']['buy'])) {
            ?>
                <div class="section-detail table-responsive">
                    <form action="?mod=cart&action=update" method="POST">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Mã sản phẩm</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td colspan="2">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($_SESSION['cart']['buy'] as $item) {
                                ?>
                                    <tr>
                                        <td><?php echo $item['id'] ?></td>
                                        <td>
                                            <a href="" title="" class="thumb">
                                                <img src="<?php echo base_url("admin/{$item['product_thumb']}") ?>" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" title="" class="name-product"><?php echo $item['product_title'] ?></a>
                                        </td>
                                        <td><?php echo currency_format($item['price']) ?></td>
                                        <td>
                                            <input type="number" class="num-order" name="qty[<?php echo $item['id'] ?>]" value="<?php echo $item['qty'] ?>" <?php
                                                                                                                                    if ($item['amount_stock'] < 3) {
                                                                                                                                    ?> min="0" , max=<?php echo $item['amount_stock'] ?> <?php
                                                                                                                                                                                        } else {
                                                                                                                                                                                            ?> min="0" , max="3" <?php
                                                                                                                                                                                                                } ?>>
                                        </td>
                                        <td><?php echo currency_format($item['sub_total']) ?></td>
                                        <td>
                                            <a href="?mod=cart&action=delete&id=<?php echo $item['id'] ?>" title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right">Tổng giá: <span><?php echo currency_format($_SESSION['cart']['info']['total']) ?></span></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                <input type="submit" name="btn_update_cart" value="Cập nhập giỏ hàng" id="update-cart">
                                                <a href="?mod=cart&action=checkout" title="" id="checkout-cart">Thanh toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div class="empty">
                    <img src="admin/public/images/empty-cart.png" style="width: 100px;margin: 0 auto;" alt="">
                    <p>Không có sản phẩm nào trong giỏ hàng</p>
                    <a href="?">VỀ TRANG CHỦ</a>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        if (!empty($_SESSION['cart']['buy'])) {
        ?>
            <div class="section" id="action-cart-wp">
                <div class="section-detail clearfix">
                    <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                    <a href="?" title="" id="buy-more">Mua tiếp</a><br />
                    <a href="?mod=cart&action=deleteAll" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        <?php
        } else {
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>
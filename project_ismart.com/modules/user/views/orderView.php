<?php
get_header();
?>

<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="section" id="nav-status-order" style="margin: 0px 0px 25px 0px;">
            <ul style="display: flex; justify-content: space-around; margin:0px">
                <li <?php if($type == 0) echo "style='color: red; border-bottom: 1px solid red;'" ?>><a href="?mod=user&action=order&type=0">All</a></li>
                <?php
                foreach ($list_orderStatus as $orderStatus) {
                ?>
                    <li <?php if($orderStatus->getId() == $type) echo "style='color: red; border-bottom: 1px solid red;'" ?>><a href="?mod=user&action=order&type=<?php echo $orderStatus->getId() ?>"><?php echo $orderStatus->getName() ?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <?php
        if (is_array($orders)) {
        ?>
            <div class="section" id="search-order">
                <form action="">
                    <input type="text" style="width:100%; padding:10px 5px" placeholder="Bạn có thể tìm kiếm theo ID đơn hàng hoặc Tên sản phẩm">
                    <input type="button" value="" hidden>
                </form>
            </div>
            <div class="section" id="history-cart" style="margin: 40px 0px;">
                <ul>
                    <?php
                    foreach ($orders as $order) {
                        $orderDetails = $orderDetailDAL->getObjects(NULL, "order_id = {$order->getId()}")
                    ?>
                        <li style="border-bottom: 1px solid black; margin-bottom: 30px;">
                            <p class="tiem-order">Thời gian đặt hàng : <strong><?php echo $order->getCreatedAt() ?></strong></p>
                            <p>Mã đơn hàng: <strong>#<?php echo $order->getId() ?></strong></p>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td>Stt</td>
                                        <td>Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Đơn giá</td>
                                        <td>Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 0;
                                    foreach ($orderDetails as $orderDetail) {
                                        $product = $productDAL->getObject("'{$orderDetail->getProductId()}'");
                                    ?>
                                        <tr style="padding: 5px 0px;">
                                            <td><?php echo $t++ ?></td>
                                            <td><img src="<?php echo base_url("admin/{$product->getImageUrl()}") ?>" width="100px" alt=""></td>
                                            <td><?php echo $product->getName() ?></td>
                                            <td>x <?php echo $orderDetail->getAmount() ?></td>
                                            <td><?php echo currency_format($orderDetail->getPrice()) ?></td>
                                            <td><?php echo currency_format($orderDetail->getSubTotal()) ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div style="margin: 5px 0px; text-align: end; padding-right: 50px;">
                                <p>Tổng tiền: <strong><?php echo currency_format($order->getTotal()) ?></strong></p>
                            </div>
                            <div style="margin:5px 0px; text-align: end; padding-right: 50px;">
                                <p>Trạng thái: <strong><?php echo $orderStatusDAL->getObject($order->getStatusId())->getName() ?></strong></p>
                            </div>
                            <!-- {{-- @if ($order->orderStatus->id == 1)
                            <a target="?mod=cart&action=cancel&id=" id="" type="submit" name="cancel">Hủy đơn
                                hàng</a>
                        @endif --}} -->
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        <?php
        } else {
        ?>
            <div class="section" id="empty-order">
                <div id="empty-order" style="background-color: aliceblue; height:550px">
                    <img src="public/images/empty-order.png" alt="" style="margin: 0px auto; padding:120px 0px 15px 0px">
                    <p style="text-align: center; font-size:20px">Chưa có đơn hàng</p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>
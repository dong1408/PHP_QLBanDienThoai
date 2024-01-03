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
                    Thông tin đơn hàng
                </div>
                <div class="card-body">
                    <div class="section">
                        <ul class="">
                            <li style="margin-bottom: 10px;">
                                <p style="margin: 0px;">Mã đơn hàng:</p>
                                <span>#<?php echo $order->getId() ?></span>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <p style="margin: 0px;">Địa chỉ nhận hàng:</p>
                                <span class="detail"><?php echo $order->getAddress() ?></span>
                            </li>
                            <li style="margin-bottom: 10px;">
                                <p style="margin: 0px;">Thông tin vận chuyển:</p>
                                <span class="detail"><?php echo ($order->getPayMethod() == "payment-home") ? "Thanh toán tại nhà" : "Thanh toán tại cửa hàng" ?></span>
                            </li>
                            <form method="POST" action="">
                                <li style="margin-bottom: 10px;">
                                    <p style="margin: 0px;">Tình trạng đơn hàng:</p>
                                    <select name="status">
                                        <?php
                                        foreach ($list_orderStatus as $item) {
                                        ?>
                                            <option value="<?php echo $item->getId() ?>" <?php if ($order->getStatusId() == $item->getId()) echo "selected=selected" ?>><?php echo $item->getName() ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" name="btn_update" value="Cập nhật đơn hàng">
                                </li>
                            </form>
                        </ul>
                    </div>
                    <div class="section">
                        <div class="section-head">
                            <p>Sản phẩm đơn hàng</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table info-exhibition">
                                <thead>
                                    <tr>
                                        <td class="thead-text">STT</td>
                                        <td class="thead-text">Ảnh sản phẩm</td>
                                        <td class="thead-text">Tên sản phẩm</td>
                                        <td class="thead-text">Đơn giá</td>
                                        <td class="thead-text">Số lượng</td>
                                        <td class="thead-text">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    foreach ($orderDetails as $orderDetail) {
                                        $product = $productDAL->getObject("'{$orderDetail->getProductId()}'");
                                    ?>
                                        <tr>
                                            <td class="thead-text"><?php echo $t++ ?></td>
                                            <td class="thead-text">
                                                <div class="thumb">
                                                    <img src="<?php echo base_url("admin/{$product->getImageUrl()}") ?>" alt="" width="100px">
                                                </div>
                                            </td>
                                            <td class="thead-text"><?php echo $product->getName() ?></td>
                                            <td class="thead-text"><?php echo currency_format($orderDetail->getSubTotal()) ?></td>
                                            <td class="thead-text"><?php echo $orderDetail->getAmount() ?></td>
                                            <td class="thead-text"><?php echo currency_format($orderDetail->getSubTotal()) ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="section">
                        <p style="font-weight: bold;">Giá trị đơn hàng</p>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                <li>Tổng số lượng: <?php echo $order->getAmount() ?> sản phẩm</li>
                                <li>Tổng giá trị đơn hàng: <?php echo currency_format($order->getTotal()) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
?>
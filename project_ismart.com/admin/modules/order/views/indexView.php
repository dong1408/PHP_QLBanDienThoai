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
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="?mod=order&type=1">
                                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                    <div class="card-header">CHỜ XÁC NHẬN</div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $countNewOrder ?></h5>
                                        <p class="card-text">Đơn hàng mới chưa được xác nhận</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="?mod=order&type=3">
                                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                                    <div class="card-header">ĐANG XỬ LÝ</div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $countProcessOrder ?></h5>
                                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="?mod=order&type=4">
                                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                                    <div class="card-header">ĐANG VẬN CHUYỂN</div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $countShipOrder ?></h5>
                                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="?mod=order&type=6">
                                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                    <div class="card-header">THÀNH CÔNG</div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $countCompletedOrder ?></h5>
                                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="?mod=order&type=7">
                                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $countCancelOrder ?></h5>
                                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- end analytic  -->
                <!-- <div class="card"> -->
                <div class="card-header font-weight-bold pb-0">
                    <p>ĐƠN HÀNG <?php echo mb_strtoupper($orderStatus) . " ($amountOrder)" ?></p>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!-- <th scope="col">#</th> -->
                                <th scope="col">Mã</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($orders)) {
                                foreach ($orders as $order) {
                                    $orderDetails = $orderDetailDAL->getObjects(NULL, "order_id = {$order->getId()}")
                            ?>
                                    <tr>
                                        <td>#<?php echo $order->getId() ?></td>
                                        <td>
                                            <?php echo $userDAL->getObject($order->getUserId())->getUserName() ?><br>
                                            <?php echo $order->getPhone() ?>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($orderDetails as $orderDetail) {
                                            ?>
                                                <a href="#"><?php echo $productDAL->getObject("'{$orderDetail->getProductId()}'")->getName() ?></a> x <?php echo $orderDetail->getAmount() ?></br>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $order->getAmount() ?></td>
                                        <td><?php echo currency_format($order->getTotal()) ?></td>
                                        <td><span class="badge badge-warning"><?php echo $orderStatus ?></span></td>
                                        <td><?php echo $order->getCreatedAt() ?></td>
                                        <td>
                                            <a href="?mod=order&action=detail&id=<?php echo $order->getId() ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            <!-- <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a> -->
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8">HIện tại chưa có đơn hàng.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <?php
                        get_pagging($numPage, $page, "?mod=order&type={$type}");
                        ?>
                    </nav>
                </div>

                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
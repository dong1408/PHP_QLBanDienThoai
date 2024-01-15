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
                    <div class="section-title" style="border-bottom: 1px solid black; padding-bottom: 20px;">
                        <h4 style="text-align: center;">Báo cáo doanh thu</h4>
                    </div>
                    <div class="section-filter" style="border-bottom: 1px solid black; padding-top: 15px; text-transform: none;">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" style="padding-right: 15px;">Loại thời gian</label>
                                        <select name="typeStatistical" id="select-statistical">
                                            <option value="statisticalByDate">Báo cáo theo ngày</option>
                                            <option value="statisticalByMonth">Báo cáo theo tháng</option>
                                            <option value="statisticalByQuy">Báo cáo theo quý</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row" id="filter">
                                        <!-- Lọc theo ngày -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="" style="padding-right: 15px;">Ngày bắt đầu</label>
                                                <input type="date" id="date-from" value="<?php echo date('Y-m-d') ?>" style="width: 160px">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="" style="padding-right: 15px;">Ngày kết thúc</label>
                                                    <input type="date" id="date-to" value="<?php echo date('Y-m-d') ?>" style="width: 160px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button name="filter" style="border-radius: 5px;">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="section-statiscial" style="padding-top: 15px; text-transform: none">
                        <div class="row" style="text-align: center;">
                            <div class="col-md-3">
                                <p>Doanh thu</p>
                            </div>
                            <div class="col-md-3">
                                Tổng vốn (trừ vốn hàng trả)
                            </div>
                            <div class="col-md-3">
                                Trả hàng
                            </div>
                            <div class="col-md-3">
                                Lợi nhuận (%)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="section-display" style="width: 100%; min-height: 100px;">
                        <h5>Bảng thống kê chi tiết</h5>
                        <?php
                        if ($typeStatistical == 'statisticalByDate') {
                        ?>
                            <table border="1" class="table table-striped">
                                <thead class="thead-dark" style="text-align: center; background-color: antiquewhite;">
                                    <tr>
                                        <td>#</td>
                                        <td>Ngày</td>
                                        <td>Bán hàng</td>
                                        <td>Doanh thu</td>
                                        <td>Lợi nhuận</td>
                                        <td>Lợi nhuận (%)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } elseif ($typeStatistical == 'statisticalByMonth') {
                        ?>
                            <table border="1" class="table table-striped">
                                <thead class="thead-dark" style="text-align: center; background-color: antiquewhite;">
                                    <tr>
                                        <td>#</td>
                                        <td>Tháng</td>
                                        <td>Bán hàng</td>
                                        <td>Doanh thu</td>
                                        <td>Lợi nhuận</td>
                                        <td>Lợi nhuận (%)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } elseif ($typeStatistical == 'statisticalByQuy') {
                        ?>
                            <table border="1" class="table table-striped">
                                <thead class="thead-dark" style="text-align: center; background-color: antiquewhite;">
                                    <tr>
                                        <td>#</td>
                                        <td>Tháng</td>
                                        <td>Bán hàng</td>
                                        <td>Doanh thu</td>
                                        <td>Lợi nhuận</td>
                                        <td>Lợi nhuận (%)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td>01/2024</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>205.800.000 VNĐ</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
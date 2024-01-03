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
                    Thêm sản phẩm
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-group">
                            <label for="code">CODE</label>
                            <input class="form-control" type="text" name="code" id="code" value="<?php if (!empty($code)) echo $code ?>">
                            <?php
                            if (!empty($error['code'])) {
                                echo "<p style='color:red'>{$error['code']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="nameProduct">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="nameProduct" id="nameProduct" value="<?php if (!empty($nameProduct)) echo $nameProduct ?>">
                            <?php
                            if (!empty($error['nameProduct'])) {
                                echo "<p style='color:red'>{$error['nameProduct']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input class="form-control" type="text" name="price" id="price" value="<?php if (!empty($price)) echo $price ?>">
                            <?php
                            if (!empty($error['price'])) {
                                echo "<p style='color:red'>{$error['price']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="amount">Số lượng</label>
                            <input class="form-control" type="number" min='0' max='100' name="amount" id="amount" value="<?php if (!empty($amount)) echo $amount ?>">
                            <?php
                            if (!empty($error['amount'])) {
                                echo "<p style='color:red'>{$error['amount']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">RAM</label>
                            <select class="form-control" id="" name="ram">
                                <option value="">Chọn</option>
                                <?php
                                foreach ($rams as $ram) {
                                ?>
                                    <option value="<?php echo $ram->getId() ?>"><?php echo $ram->getValue() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                            if (!empty($error['ram'])) {
                                echo "<p style='color:red'>{$error['ram']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">ROM</label>
                            <select class="form-control" id="" name="rom">
                                <option value="">Chọn</option>
                                <?php
                                foreach ($roms as $rom) {
                                ?>
                                    <option value="<?php echo $rom->getId() ?>"><?php echo $rom->getValue() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                            if (!empty($error['rom'])) {
                                echo "<p style='color:red'>{$error['rom']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">Màu</label>
                            <select class="form-control" id="" name="color">
                                <option value="">Chọn</option>
                                <?php
                                foreach ($colors as $color) {
                                ?>
                                    <option value="<?php echo $color->getId() ?>"><?php echo $color->getValue() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                            if (!empty($error['color'])) {
                                echo "<p style='color:red'>{$error['color']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="short">Mô tả sản phẩm</label>
                            <textarea name="shortDesc" class="form-control ckeditor" id="short" cols="30" rows="5"><?php if (!empty($shortDesc)) echo $shortDesc ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="detail">Chi tiết sản phẩm</label>
                            <textarea name="detailDesc" class="form-control ckeditor" id="detail" cols="30" rows="5"><?php if (!empty($detailDesc)) echo $detailDesc ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục</label>
                            <select class="form-control" id="" name="category">
                                <option value="">Chọn</option>
                                <?php
                                foreach ($categories as $category) {
                                ?>
                                    <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                            if (!empty($error['category'])) {
                                echo "<p style='color:red'>{$error['category']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="image">Chọn ảnh</label><br>
                            <input type="file" name="file_image_thumbnail" id="image" onchange="displayImage()"><br><br>
                            <div id="imageContainer"></div>
                            <?php
                            if (!empty($error['file_image_thumbnail'])) {
                                echo "<p style='color:red'>{$error['file_image_thumbnail']}</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function displayImage() {
            var input = document.getElementById('image');
            var container = document.getElementById('imageContainer');

            // Kiểm tra xem đã chọn tệp hình ảnh hay chưa
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Tạo một phần tử hình ảnh và thiết lập thuộc tính src
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.width = '140px';
                    image.style.height = '200px';

                    // Xóa hình ảnh cũ (nếu có) và thêm hình ảnh mới
                    while (container.firstChild) {
                        container.removeChild(container.firstChild);
                    }
                    container.appendChild(image);
                };

                // Đọc tệp hình ảnh như một URL dữ liệu
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</div>
<?php
get_footer();
?>
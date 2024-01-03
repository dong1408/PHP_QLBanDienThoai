<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            <?php
            foreach ($categories as $category) {
            ?>
                <li>
                    <a href="?action=productByCat&id=<?php echo $category->getId() ?>" title=""><?php echo $category->getName() ?></a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>

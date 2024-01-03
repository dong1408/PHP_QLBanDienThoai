<?php

function get_product_by_id($id)
{
    return db_fetch_row("SELECT * FROM `product` WHERE product.ProductID = '{$id}'");
}

function addCart($product)
{
    // Kiem tra san pham da co trong gio hang
    $qty = 1;
    if (isset($_SESSION['cart']) && array_key_exists($product->getId(), $_SESSION['cart']['buy'])) {
        $qty = $_SESSION['cart']['buy'][$product->getId()]['qty'] + 1;
    }

    $_SESSION['cart']['buy'][$product->getId()] = array(
        'id' => $product->getId(),
        'product_title' => $product->getName(),
        'price' => $product->getPrice(),
        'product_thumb' => $product->getImageUrl(),
        // 'code' => $item['code'],
        'qty' => $qty,
        'amount_stock' => $product->getAmount(),
        'sub_total' => $qty * $product->getPrice()
    );

    update_info_cart();
}


function update_info_cart()
{
    if (isset($_SESSION['cart'])) {
        $num_order = 0;
        $total = 0;
        foreach ($_SESSION['cart']['buy'] as $item) {
            $num_order += $item['qty'];
            $total += $item['sub_total'];
        }

        $_SESSION['cart']['info'] = array(
            'num_order' => $num_order,
            'total' => $total,
        );
    }
}

function update_cart($qty)
{
    foreach ($qty as $id => $new_qty) {
        if ($new_qty == 0) {
            unset($_SESSION['cart']['buy'][$id]);
        } else {
            $_SESSION['cart']['buy'][$id]['qty'] = $new_qty;
            $_SESSION['cart']['buy'][$id]['sub_total'] = $new_qty * $_SESSION['cart']['buy'][$id]['price'];
        }
    }
    update_info_cart();
}

function delete_cart($id)
{
    if (isset($_SESSION['cart'])) {
        # Xóa sản phẩm có $id trong giỏ hàng
        if (!empty($id)) {
            unset($_SESSION['cart']['buy'][$id]);
            update_info_cart();
        } else {
            unset($_SESSION['cart']);
            update_info_cart();
        }
    }
}

function delete_cart_all()
{
    foreach ($_SESSION['cart']['buy'] as $key => $value) {
        unset($_SESSION['cart']['buy'][$key]);
    }
    update_info_cart();
}

function checkoutOrder($customerID, $fullname, $email, $address, $phone, $note, $payMethod, $amount, $total)
{
    global $conn;
    $current_time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `orders` (`OrderID`,`StaffID`,`CustomerID`,`FullName`,`Email`, `Address`, `Phone`, `Note`,`PayMethod`, `CreateAt`, `Amount`, `Total`, `StatusID`) VALUES (NULL, NULL, '$customerID', '$fullname', '$email', '$address', '$phone', '$note', '$payMethod', '$current_time', $amount, $total, 1)";
    $result =  mysqli_query($conn, $sql);
    if ($result) {
        return mysqli_insert_id($conn);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function create_OrderDetail($orderID)
{
    foreach ($_SESSION['cart']['buy'] as $item) {
        $pr = get_product_by_id($item['id']);
        $sql = "INSERT INTO `orderdetail` (`OrderDetailID`, `OrderID`, `ProductID`, `Amount`, `Price`, `SubTotal`) VALUES (NULL, $orderID, '{$item['id']}', {$item['qty']}, {$item['price']}, {$item['sub_total']})";
        $current_amount = $pr['Amount'] - $item['qty'];
        db_query($sql);
        update_amount_product($item['id'], $current_amount);
    }
}

function update_amount_product($productID, $current_amount)
{
    db_query("UPDATE `product` SET product.Amount = {$current_amount} WHERE product.ProductID = '{$productID}'");
}

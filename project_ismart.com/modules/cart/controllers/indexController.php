<?php
function construct()
{
    load_model('index');
}

function indexAction()
{
    load_view('index');
}

function addCartAction()
{
    $id = $_GET['id'];
    $productDAL = new ProductDAL();
    $product = $productDAL->getObject("'{$id}'", "deleted_at IS NULL AND amount > 0");
    if (is_object($product)) {
        addCart($product);
        header("Location:?mod=cart");
    }
}

function updateAction()
{
    if (isset($_POST['btn_update_cart'])) {
        update_cart($_POST['qty']);
        header("Location:?mod=cart");
    }
}

function deleteAction()
{
    $id = $_GET['id'];
    delete_cart($id);
    header("Location:?mod=cart");
}

function deleteAllAction()
{
    delete_cart_all();
    header("Location:?mod=cart");
}

function checkoutAction()
{
    if (!isset($_SESSION['is_login'])) {
        header("Location:?mod=user&action=login");
    }

    if (empty($_SESSION['cart']['buy'])) {
        header("Location:?");
    }

    $userDAL = new UserDAL();
    $orderDAL = new OrderDAL();
    $orderDetailDAL = new OrderDetailDAL();
    $productDAL = new ProductDAL();
    $user = $userDAL->getObject($_SESSION['userID']);
    if (isset($_POST['btn-checkout'])) {
        global $error;
        $error = array();

        // Kiem tra fullname
        if (!empty($_POST['fullname'])) {
            $fullname = $_POST['fullname'];
        } else {
            $error['fullname'] = "Vui lòng điền đủ thông tin họ tên người đặt!";
        }

        // Get email
        $email = $_POST['email'];

        // Kiem tra dia chi
        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        } else {
            $error['address'] = "Vui lòng điền đẩy đủ thông tin địa chỉ giao hàng!";
        }

        // Kiểm tra so dien thoai
        if (!empty($_POST['phone'])) {
            $phone = $_POST['phone'];
        } else {
            $error['phone'] = "Vui lòng điền đầy đủ thông tin số điện thoại";
        }

        // Kiem tra ghi chu
        if (!empty($_POST['note'])) {
            $note = $_POST['note'];
        } else {
            $note = "";
        }

        // Kiem tra hinh thuc thanh toan
        if (!empty($_POST['payment-method'])) {
            $payment_method = $_POST['payment-method'];
        } else {
            $error['payment-method'] = "Vui lòng chọn hình thức thanh toán";
        }

        // Tien hanh thanh toan khi khong co loi
        if (empty($error)) {
            $confirm_token = md5($_SESSION['user_login'] . time());
            $order = new OrderDTO(NULL, $_SESSION['userID'], $fullname, $email, $address, $phone, $note, $payment_method, Date('Y-m-d H:i:s', time()), $_SESSION['cart']['info']['num_order'], $_SESSION['cart']['info']['total'], 1);
            $order->setConfirmToken($confirm_token);
            $idOrder = $orderDAL->addOrder($order);
            $link_confirm = base_url("?mod=cart&action=confirm&confirm_token={$confirm_token}");
            $list_product_order = "";
            $date_order = Date('Y-m-d H:i:s', time());
            $total_order = currency_format($_SESSION['cart']['info']['total']);
            foreach ($_SESSION['cart']['buy'] as $item) {
                $price = currency_format($item['price']);
                $sub_total = currency_format($item['sub_total']);
                $list_product_order .= "<tr>
                <td style='text-align: center;'>{$item['product_title']}</td>
                <td style='text-align: center;'>{$item['qty']}</td>
                <td style='text-align: center;''>{$price}</td>
                <td style='text-align: center;'>{$sub_total}</td>
            </tr>";
            }
            $content = "
            <p style='text-align: center;'>Xác Nhận Đơn Hàng Của Quý Khách</p>

<p>Xin chào {$fullname}.</p>

<p>Rất vui vì bạn đã tin tưởng và đặt hàng sản phẩm trên hệ thống của chúng tôi!</p>

<p>Để hoàn tất quá trình đặt hàng và đảm bảo tính bảo mật, chúng tôi cần bạn xác nhận thông tin đơn hàng bằng cách nhấp vào liên kết xác nhận dưới đây.</p>

<a href='{$link_confirm}'>Click vào đường link này để xác nhận đặt hàng.</a>

<p><strong>Thông Tin Đơn Hàng:</strong></p>

<p>Mã đơn hàng: {$idOrder}</p>

<p>Ngày đặt: {$date_order}</p>

<table border='1' cellpadding='1' cellspacing='1' style='width:500px'>
	<thead>
		<tr>
			<th scope='col'>Sản phẩm</th>
			<th scope='col'>Số lượng</th>
			<th scope='col'>Giá</th>
			<th scope='col'>Thành tiền</th>
		</tr>
	</thead>
	<tbody>
		{$list_product_order}
	</tbody>
</table>

<p>Tổng giá trị đơn hàng: {$total_order}</p>

<p><strong>Địa chỉ giao hàng:</strong></p>

<p>{$address}</p>

<p><strong>Phương thức thanh toán:</strong></p>

<p>{$payment_method}</p>

<p>Vui lòng xác nhận đơn hàng để chúng tôi có thể tiếp tục xử lý và giao hàng đến bạn một cách nhanh chóng.</p>

<p>Nếu có bất ky vấn đề hoặc câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi qua địa chỉ email dongden14082002@gmail.com hoặc số điện thoại 0374920524.</p>

<p>Cảm ơn bạn đã chọn CTTNHH 1 thành viên Bronze. Chúng tôi mong rằng bạn sẽ hài lòng với sản phẩm của chúng tôi.</p>

<p>Trân trọng!</p>

<p>Người gửi: Giám đốc Trần Văn Đồng.</p>

<p>Số điện thoại liên hệ: 0374920524</p>

            ";
            foreach ($_SESSION['cart']['buy'] as $item) {
                $product = $productDAL->getObject("'{$item['id']}'");
                $orderDetailDTO = new OrderDetailDTO(NULL, $idOrder, $item['id'], $item['qty'], $item['price'], $item['sub_total']);
                $orderDetailDAL->addOrderDetail($orderDetailDTO);
                $current_amount = $product->getAmount() - $item['qty'];
                $productDAL->updateAmount($item['id'], $current_amount);
            }
            delete_cart_all();
            send_mail($email, $_SESSION['user_login'], "Xác nhận đơn đặt hàng", $content);
            echo "<script type='text/javascript'>alert('Bạn đã đặt hàng thành công! Vui lòng check email để xác nhận.');</script>";
        } else {
            // show_array($error);
        }
    }
    $data = [
        'user' => $user
    ];
    load_view('checkout', $data);
}


function confirmAction(){
    $orderDAL = new OrderDAL();
    $confirm_token = $_GET['confirm_token'];
    if($orderDAL->checkConfirmToken($confirm_token)){
        $orderDAL->confirmOrder($confirm_token);
        echo "Bạn đã xác nhận đơn hàng thành công. Cảm ơn bạn đã tin tưởng và đặt sản phẩm trên hệ thống của chúng tôi!";
        // header("Refresh:0.01");
    }else{
        echo "Xác nhận đơn hàng không thành công.";
    }
}
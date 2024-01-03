<?php

function construct()
{
}


function indexAction()
{
    $orderDAL = new OrderDAL();
    $userDAL = new UserDAL();
    $orderDetailDAL = new OrderDetailDAL();
    $productDAL = new ProductDAL();
    $type = isset($_GET['type']) ? $_GET['type'] : 1;
    $pageCurrent = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemPerPage = 2;
    $countNewOrder = $orderDAL->countItems('id', "status_id = 1")[0];
    $countProcessOrder = $orderDAL->countItems('id', "status_id = 3")[0];
    $countShipOrder = $orderDAL->countItems('id', "status_id = 4")[0];
    $countCompletedOrder = $orderDAL->countItems('id', "status_id = 6")[0];
    $countCancelOrder = $orderDAL->countItems('id', "status_id = 7")[0];
    $orderStatus = '';
    if ($type == 3) {
        $numPage = ceil($countProcessOrder / $itemPerPage);
        $orders = $orderDAL->getObjects($pageCurrent, "status_id = 3", $itemPerPage);
        $orderStatus = "Đang xử lý";
    } elseif ($type == 4) {
        $numPage = ceil($countShipOrder / $itemPerPage);
        $orders = $orderDAL->getObjects($pageCurrent, "status_id = 4", $itemPerPage);
        $orderStatus = "Đang vận chuyển";
    } elseif ($type == 6) {
        $numPage = ceil($countCompletedOrder / $itemPerPage);
        $orders = $orderDAL->getObjects($pageCurrent, "status_id = 6", $itemPerPage);
        $orderStatus = "Đã hoàn thành";
    } elseif ($type == 7) {
        $numPage = ceil($countCancelOrder / $itemPerPage);
        $orders = $orderDAL->getObjects($pageCurrent, "status_id = 7", $itemPerPage);
        $orderStatus = "Bị hủy";
    } else {
        $numPage = ceil($countNewOrder / $itemPerPage);
        $orders = $orderDAL->getObjects($pageCurrent, "status_id = 1", $itemPerPage);
        $orderStatus = "Chờ xác nhận";
    }
    $data = [
        'orders' => $orders,
        'numPage' => $numPage,
        'page' => $pageCurrent,
        'type' => $type,
        'orderStatus' => $orderStatus,
        'countNewOrder' => $countNewOrder,
        'countProcessOrder' => $countProcessOrder,
        'countShipOrder' => $countShipOrder,
        'countCompletedOrder' => $countCompletedOrder,
        'countCancelOrder' => $countCancelOrder,
        'userDAL' => $userDAL,
        'orderDetailDAL' => $orderDetailDAL,
        'productDAL' => $productDAL
    ];
    load_view('index', $data);
}

function detailAction()
{
    $id = (int) $_GET['id'];
    $orderDAL = new OrderDAL();
    $order = $orderDAL->getObject($id);
    if (is_object($order)) {
        $orderDetailDAL = new OrderDetailDAL();
        $orderStatusDAL = new OrderStatusDAL();
        $productDAL = new ProductDAL();
        $list_orderStatus = $orderStatusDAL->getObjects();
        if (isset($_POST['btn_update'])) {
            $status = (int)$_POST['status'];
            $order->setStatudId($status);
            $orderDAL->updateStatusOrder($id, $status);
        }
        $orderDetails = $orderDetailDAL->getObjects(NULL, "order_id={$order->getId()}");
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'orderDetailDAL' => $orderDetailDAL,
            'productDAL' => $productDAL,
            'list_orderStatus' => $list_orderStatus
        ];
        load_view('detail', $data);
    } else {
        header("Location:?mod=order");
    }
}

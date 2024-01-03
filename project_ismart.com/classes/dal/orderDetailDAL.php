<?php

class OrderDetailDAL extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'orderdetails';
        $this->fields = array(
            'id',
            'order_id',
            'product_id',
            'amount',
            'price',
            'subTotal'
        );
    }

    public function getObject($condition = '1>0', $fields = '*')
    {
        $result = $this->select($fields, "{$condition}");
        if ($result) {
            $object = new OrderDetailDTO(
                $result[0]['id'],
                $result[0]['order_id'],
                $result[0]['product_id'],
                $result[0]['amount'],
                $result[0]['price'],
                $result[0]['subTotal']
            );
            return $object;
        }
        return 0;
    }


    public function getObjects($page_current = 1, $condition = '1>0', $itemPerPage = '')
    {
        $start = '0';
        if (!empty($itemPerPage)) {
            $start = ($page_current - 1) * $itemPerPage;
        }
        $results = $this->select('*', $condition, $start, $itemPerPage);
        if ($results) {
            $objects = array();
            foreach ($results as $key => $result) {
                $objects[] = new OrderDetailDTO(
                    $result['id'],
                    $result['order_id'],
                    $result['product_id'],
                    $result['amount'],
                    $result['price'],
                    $result['subTotal']
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addOrderDetail(OrderDetailDTO $orderDetailDTO)
    {
        $data = [
            'id' => $orderDetailDTO->getId(),
            'order_id' => $orderDetailDTO->getOrderId(),
            'product_id' => $orderDetailDTO->getProductId(),
            'amount' => $orderDetailDTO->getAmount(),
            'price' => $orderDetailDTO->getPrice(),
            'subTotal' => $orderDetailDTO->getSubTotal()
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }
}

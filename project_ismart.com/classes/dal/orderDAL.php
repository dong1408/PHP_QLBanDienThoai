<?php

class OrderDAL extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'orders';
        $this->fields = array(
            'id',
            'user_id',
            'fullname',
            'email',
            'address',
            'phone',
            'note',
            'payMethod',
            'created_at',
            'amount',
            'total',
            'confirm_token',
            'status_id'
        );
    }

    public function getObject($value = '0', $condition = '1>0', $key = 'id', $fields = '*')
    {
        $result = $this->select($fields, "{$key} = {$value} AND {$condition}");
        if ($result) {
            $object = new OrderDTO(
                $result[0]['id'],
                $result[0]['user_id'],
                $result[0]['fullname'],
                $result[0]['email'],
                $result[0]['address'],
                $result[0]['phone'],
                $result[0]['note'],
                $result[0]['payMethod'],
                $result[0]['created_at'],
                $result[0]['amount'],
                $result[0]['total'],
                $result[0]['status_id']
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
                $objects[] = new OrderDTO(
                    $result['id'],
                    $result['user_id'],
                    $result['fullname'],
                    $result['email'],
                    $result['address'],
                    $result['phone'],
                    $result['note'],
                    $result['payMethod'],
                    $result['created_at'],
                    $result['amount'],
                    $result['total'],
                    $result['status_id']
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addOrder(OrderDTO $orderDTO)
    {
        $data = [
            'id' => $orderDTO->getId(),
            'user_id' => $orderDTO->getuserID(),
            'fullname' => $orderDTO->getFullname(),
            'email' => $orderDTO->getEmail(),
            'address' => $orderDTO->getAddress(),
            'phone' => $orderDTO->getPhone(),
            'note' => $orderDTO->getNote(),
            'payMethod' => $orderDTO->getPayMethod(),
            'created_at' => $orderDTO->getCreatedAt(),
            'amount' => $orderDTO->getAmount(),
            'total' => $orderDTO->getTotal(),
            'confirm_token' => $orderDTO->getConfirmToken(),
            'status_id' => $orderDTO->getStatusId(),
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updateStatusOrder($orderID, $statusID)
    {
        $data = array(
            'status_id' => $statusID
        );
        $result = $this->update($data, "id = '{$orderID}'");
        if ($result)
            return $result;
        return 0;
    }

    public function checkConfirmToken($confirmToken)
    {
        $num_row = $this->countItems('id', "`confirm_token` = '{$confirmToken}' AND `is_confirm` = '0'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }

    function confirmOrder($confirmToken)
    {
        return $this->update(array('is_confirm' => 1), "`confirm_token` = '{$confirmToken}'");
    }
}

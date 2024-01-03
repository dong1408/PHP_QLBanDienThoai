<?php

class OrderStatusDAL extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'orderstatus';
        $this->fields = array(
            'id',
            'name',
            'note'
        );
    }

    public function getObject($value = '0', $condition = '1>0', $key = 'id', $fields = '*')
    {
        $result = $this->select($fields, "{$key} = {$value} AND {$condition}");
        if ($result) {
            $object = new OrderStatusDTO(
                $result[0]['id'],
                $result[0]['name'],
                $result[0]['note'],                
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
                $objects[] = new OrderStatusDTO(
                    $result['id'],
                    $result['name'],
                    $result['note']
                );
            }
            return $objects;
        }
        return 0;
    }    
}

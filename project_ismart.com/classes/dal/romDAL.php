<?php

class RomDAL extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'roms';
        $this->fields = array(
            'id',
            'value'
        );
    }

    public function getObject($value = '0', $condition = '1>0', $key = 'id', $fields = '*')
    {
        $result = $this->select($fields, "{$key} = {$value} AND {$condition}");
        if ($result) {
            $object = new RomDTO(
                $result[0]['id'],
                $result[0]['value']
            );
            return $object;
        }
        return 0;
    }



    public function getObjects($page = 1, $condition = '1>0', $itemPerPage = '')
    {
        $start = '0';
        if (!empty($itemPerPage)) {
            $start = ($page - 1) * $itemPerPage;
        }
        $results = $this->select('*', $condition, $start, $itemPerPage);
        if ($results) {
            $objects = array();
            foreach ($results as $key => $result) {
                $objects[] = new RomDTO(
                    $result['id'],
                    $result['value']
                );
            }
            return $objects;
        }
        return 0;
    }
}

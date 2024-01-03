<?php

use PermissionDTO as GlobalPermissionDTO;

// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/permissionDTO.php';

class PermissionDAL extends Model{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'permissions';
        $this->fields = array(
            'id',
            'name',
            'slug',
            'description',
            'created_at',
            'deleted_at'
        );
    }

    /*-------------------------------------------------------------------------------------------------------*
    * public function: getObject 
    * Parameter: value, WHERE condition, key, fields
    * Return: Object
    * Description: Hàm lấy thông tin 1 user, tham số truyền vào theo thứ tự đầu tiên là value, thứ 2 là điều
    *              kiện select, thứ 3 là key, thứ 4 là các field
    * Ex: getObject(2) // lấy thông tin user có UserID = 2 
    *-------------------------------------------------------------------------------------------------------*/

    public function getObject($value = '0', $condition = '1>0', $key = 'id', $fields = '*')
    {
        $result = $this->select($fields, "{$key} = {$value} AND {$condition}");
        if ($result) {
            $object = new PermissionDTO(
                $result[0]['id'],
                $result[0]['name'],
                $result[0]['slug'],
                $result[0]['description'],
                $result[0]['created_at'],
                $result[0]['deleted_at']
            );
            return $object;
        }
        return 0;
    }


    /*-------------------------------------------------------------------------------------------------------*
    * public function: getObjects
    * Parameter: WHERE condition, fields
    * Return: Objects
    * Description: Hàm lấy thông tin danh sách user, tham số truyền vào theo thứ tự đầu tiên là condition, thứ 2     
    *              là các field
    * Ex: getObjects("UserType = 'admin'") // lấy thông tin danh sách user là admin 
    *-------------------------------------------------------------------------------------------------------*/

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
                $objects[] = new PermissionDTO(
                    $result['id'],
                    $result['name'],
                    $result['slug'],
                    $result['description'],
                    $result['created_at'],
                    $result['deleted_at']
                );
            }
            return $objects;
        }
        return 0;
    }

    function getPermissionByGroup(){
        $result = $this->select();
        $data = array();
        foreach($result as $item){
            $parts = explode('.', $item['slug']); // Tách tiền tố từ trường slug
            $groupPerfix = $parts[0]; // Lấy tiền tố
            // Thêm dữ liệu vào mảng theo nhóm
            // $data[$group][] = $item;
            $data[$groupPerfix][] = new PermissionDTO(
                $item['id'],
                $item['name'],
                $item['slug'],
                $item['description'],
                $item['created_at'],
                $item['deleted_at']
            );
        }
        return $data;
    }

    public function addPermission(PermissionDTO $permissionDTO)
    {
        $data = [
            'id' => 'NULL',
            'name' => $permissionDTO->getName(),
            'slug' => $permissionDTO->getSlug(),
            'description' => $permissionDTO->getDescription(),
            'created_at' => $permissionDTO->getCreatedAt()
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updatePermission(PermissionDTO $permissionDTO)
    {
        $data = array(
            'name' => $permissionDTO->getName(),
            'slug' => $permissionDTO->getSlug(),
            'description' => $permissionDTO->getDescription(),
            'created_at' => $permissionDTO->getCreatedAt(),
            'deleted_at' => $permissionDTO->getDeletedAt()
        );
        $result = $this->update($data, "id = {$permissionDTO->getId()}");
        if ($result)
            return $result;
        return 0;
    }

    public function deletePermission($id)
    {
        return $this->delete($this->table, "id = {$id}");
    }
}

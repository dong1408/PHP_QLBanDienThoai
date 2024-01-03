<?php

// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/roleDTO.php';

class RoleDAL extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'roles';
        $this->fields = array(
            'id',
            'name',
            'description'
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
            $object = new RoleDTO(
                $result[0]['id'],
                $result[0]['name'],
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
                $objects[] = new RoleDTO(
                    $result['id'],
                    $result['name'],
                    $result['description'],
                    $result['created_at'],
                    $result['deleted_at']
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addRole(RoleDTO $roleDTO)
    {
        $data = [
            'id' => 'NULL',
            'name' => $roleDTO->getName(),
            'description' => $roleDTO->getDescription(),
            'created_at' => $roleDTO->getCreatedAt()
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updateRole(RoleDTO $roleDTO)
    {
        $data = array(
            'name' => $roleDTO->getName(),
            'description' => $roleDTO->getDescription(),
            'created_at' => $roleDTO->getCreatedAt(),
            'deleted_at' => $roleDTO->getDeletedAt()
        );
        $result = $this->update($data, "id = {$roleDTO->getId()}");
        if ($result)
            return $result;
        return 0;
    }

    public function addPermissions($roleId, $listPermissionId)
    {
        $this->table = "role_permission";
        if (is_array($listPermissionId)) {
            foreach ($listPermissionId as $permissionId) {
                $data = array(
                    'role_id' => $roleId,
                    'permission_id' => $permissionId
                );
                $this->add($data);
            }
        }
        $this->table = "roles";
    }

    function getPermissionIdsByRoleId($roleId)
    {
        $this->table = "role_permission";
        $results = $this->select('permission_id', "role_id = {$roleId}");
        if ($results) {
            $data = array();
            foreach ($results as $result) {
                $data[] = $result['permission_id'];
            }
            $this->table = "roles";
            return $data;
        }
        $this->table = "roles";
        return 0;
    }

    function deletePermissionsIdByRoleId($roleId)
    {
        $this->table = "role_permission";
        $this->delete("role_id = {$roleId}");
        $this->table = "roles";
    }
}

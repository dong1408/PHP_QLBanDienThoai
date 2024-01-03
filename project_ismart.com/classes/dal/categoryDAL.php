<?php

// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/userDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/roleDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/permissionDAL.php';

class CategoryDAL extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'categories';
        $this->fields = array(
            'id',
            'name',
            'status_id',
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
            $object = new CategoryDTO(
                $result[0]['id'],
                $result[0]['name'],
                $result[0]['status_id'],
                $result[0]['created_at'],
                $result[0]['deleted_at'],
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
                $objects[] = new CategoryDTO(
                    $result['id'],
                    $result['name'],
                    $result['status_id'],
                    $result['created_at'],
                    $result['deleted_at']
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addCategory(CategoryDTO $categoryDTO)
    {
        $data = [
            'id' => 'NULL',
            'name' => $categoryDTO->getName(),
            'status_id' => $categoryDTO->getStatusId()
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updateCategory(CategoryDTO $categoryDTO)
    {
        $data = array(
            'username' => $categoryDTO->getName(),
            'password' => $categoryDTO->getStatusId()
        );
        $result = $this->update($data, "id = {$categoryDTO->getId()}");
        if ($result)
            return $result;
        return 0;
    }

    public function deleteCategory(CategoryDTO $categoryDTO)
    {
        $timeCurrent = Date('Y-m-d H:i:s', time());
        $categoryDTO->setDeletedAt($timeCurrent);
        return $this->updateCategory($categoryDTO);
    }

    public function deleteAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $categoryDTO = $this->getObject($id);
                $this->deleteCategory($categoryDTO);
            }
        }
    }

    public function restore(CategoryDTO $categoryDTO)
    {
        $categoryDTO->setDeletedAt(NULL);
        $this->updateCategory($categoryDTO);
    }

    public function restoreAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $categoryDTO = $this->getObject($id);
                $this->restore($categoryDTO);
            }
        }
    }

    public function forceDelete($id)
    {
        return $this->delete("id = {$id}");
    }

    public function forceDeleteAll($list_id)
    {
        foreach ($list_id as $id) {
            $this->forceDelete($id);
        }
    }
}

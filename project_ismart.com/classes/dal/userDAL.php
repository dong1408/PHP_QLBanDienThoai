<?php

// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/userDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/roleDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/permissionDAL.php';

class UserDAL extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->fields = array(
            'id',
            'username',
            'password',
            'email',
            'created_at',
            'user_type'
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
            $object = new UserDTO(
                $result[0]['id'],
                $result[0]['username'],
                $result[0]['password'],
                $result[0]['email'],
                $result[0]['created_at'],
                $result[0]['deleted_at'],
                $result[0]['user_type'],
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
                $objects[] = new UserDTO(
                    $result['id'],
                    $result['username'],
                    $result['password'],
                    $result['email'],
                    $result['created_at'],
                    $result['deleted_at'],
                    $result['user_type'],
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addUser(UserDTO $userDTO)
    {
        $data = [
            'id' => 'NULL',
            'fullname' => 'NULL',
            'username' => $userDTO->getUsername(),
            'password' => $userDTO->getPassword(),
            'email' => $userDTO->getEmail(),
            'created_at' => $userDTO->getCreatedAt(),
            'user_type' => $userDTO->getUserType(),
            'active_token' => $userDTO->getActiveToken(),
            'is_active' => $userDTO->getIsActive()
        ];

        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updateUser(UserDTO $userDTO)
    {
        $data = array(
            'username' => $userDTO->getUsername(),
            'password' => $userDTO->getPassword(),
            'email' => $userDTO->getEmail(),
            'created_at' => $userDTO->getCreatedAt(),
            'deleted_at' => $userDTO->getDeletedAt(),
            'user_type' => $userDTO->getUserType()
        );
        $result = $this->update($data, "id = {$userDTO->getId()}");
        if ($result)
            return $result;
        return 0;
    }

    public function deleteUser(UserDTO $userDTO)
    {
        $timeCurrent = Date('Y-m-d H:i:s', time());
        $userDTO->setDeletedAt($timeCurrent);
        return $this->updateUser($userDTO);
    }

    public function deleteAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $userDTO = $this->getObject($id);
                $this->deleteUser($userDTO);
            }
        }
    }

    public function restore(UserDTO $userDTO)
    {
        $userDTO->setDeletedAt(NULL);
        $this->updateUser($userDTO);
    }

    public function restoreAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $userDTO = $this->getObject($id);
                $this->restore($userDTO);
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


    public function checkUsernameExist($username, $condition = "1>0")
    {
        return $this->countItems('id', "`username` = '{$username}' AND {$condition}")[0];
    }


    public function checkEmailExist($email)
    {
        return $this->countItems('id', "`email` = '{$email}'")[0];
    }


    public function getRolesOfUser($userId)
    {
        $roleDAL = new RoleDAL();
        $listRolesIdOfUser = $this->getRolesIdOfUser($userId);
        if (is_array($listRolesIdOfUser)) {
            $objects = array();
            foreach ($listRolesIdOfUser as $roleId) {
                $objects[] = $roleDAL->getObject($roleId);
            }
            return $objects;
        }
        return 0;
    }

    public function getRolesIdOfUser($userId)
    {
        $this->table = "user_role";
        $results = $this->select('role_id', "user_id = {$userId}");
        if ($results) {
            $data = array();
            foreach ($results as $result) {
                $data[] = $result['role_id'];
            }
            $this->table = "users";
            return $data;
        }
        $this->table = "users";
        return 0;
    }

    function addRoles($userId, $listRoleId)
    {
        $this->table = "user_role";
        if (is_array($listRoleId)) {
            foreach ($listRoleId as $roleId) {
                $data = array(
                    'user_id' => $userId,
                    'role_id' => $roleId
                );
                $this->add($data);
            }
        }
        $this->table = "users";
    }

    function deleteRoleIdByUserId($userId)
    {
        $this->table = "user_role";
        $this->delete("user_id = {$userId}");
        $this->table = "users";
    }

    public function hasPermission($permissionSlug)
    {
        $permissionDAL = new PermissionDAL();
        $listPermissionIdOfUser = $_SESSION['list_permission'];
        foreach ($listPermissionIdOfUser as $permissionId) {
            $permission = $permissionDAL->getObject($permissionId);
            if ($permissionSlug == $permission->getSlug()) {
                return true;
            }
        }
        return false;
    }

    function check_login($username, $password)
    {
        $num_row = $this->countItems('id', "`username` = '{$username}' AND `password` = '{$password}' AND `is_active` = '1'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }

    function check_permission_admin($userID)
    {
        $num_row = $this->countItems('id', "id = {$userID} AND user_type = 'Admin'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }

    function user_exist($username, $email)
    {
        $num_row = $this->countItems('id', "`username` = '{$username}' OR `email` = '{$email}'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }


    function check_active_token($active_token)
    {
        $num_row = $this->countItems('id', "`active_token` = '{$active_token}' AND `is_active` = '0'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }


    function active_user($active_token)
    {
        return $this->update(array('is_active' => 1), "`active_token` = '{$active_token}'");
    }


    function update_resert_token($data, $email)
    {
        return $this->update($data, "`email` = '{$email}'");
        // db_update('users', $data, "`email` = '{$email}'");
    }


    function check_resert_token($reset_token)
    {
        $num_row = $this->countItems('id', "`reset_token` = '{$reset_token}'")[0];
        if ($num_row > 0) {
            return true;
        }
        return false;
    }

    function update_pass($data, $reset_token)
    {
        // db_update('users', $data, "`reset_token` = '{$reset_token}'");
        return $this->update($data, "`reset_token` = '{$reset_token}'");
    }

    function compareStringsWithSpecialChars($string1, $string2)
    {
        $len1 = strlen($string1);
        $len2 = strlen($string2);

        if ($len1 !== $len2) {
            return false; // Độ dài của hai chuỗi không giống nhau, chắc chắn khác nhau.
        }

        for ($i = 0; $i < $len1; $i++) {
            if ($string1[$i] !== $string2[$i]) {
                return false; // Tìm thấy ký tự khác nhau, hai chuỗi khác nhau.
            }
        }

        return true; // Hai chuỗi giống nhau.
    }


    function get_userid_by_username($username)
    {
        return $this->select('id', "username = '{$username}'")[0]['id'];
    }

    // function get_permissions_by_userId($userId)
    // {
    //     $data = db_fetch_array("SELECT role_permission.permission_id AS id FROM `user_role`, `role_permission` WHERE user_role.role_id = role_permission.role_id AND user_role.user_id = '{$userId}'");
    //     $result = array();
    //     foreach ($data as $val) {
    //         $result[] = $val['id'];
    //     }                
    //     return $result;
    // }




}

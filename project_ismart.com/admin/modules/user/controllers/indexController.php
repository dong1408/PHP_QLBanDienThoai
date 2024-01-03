<?php

use WindowsAzure\ServiceManagement\Models\Location;

function construct()
{
    // Dùng chung, load đầu tiên
    load_model('index');
}

function indexAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.view')) {
        header("Location: {$config['base_url']}");
        exit;
    }

    $status = isset($_GET['status']) ? $_GET['status'] : 'active';

    $countUserActive = $userDAL->countItems('id', 'deleted_at IS null')[0];
    $countUserTrash = $userDAL->countItems('id', 'deleted_at IS NOT null')[0];

    $itemPerPage = 5;
    $pageCurrent = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($status == 'active') {
        $totalRow = $userDAL->countItems('id', 'deleted_at IS NULL')[0];
        $numPage = ceil($totalRow / $itemPerPage);
        $users = $userDAL->getObjects($pageCurrent, 'deleted_at IS NULL', $itemPerPage);
        $list_act = [
            'delete' => 'Xóa',
        ];
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $search = $_GET['q'];
            $users = $userDAL->getObjects($pageCurrent, "`username` LIKE '%{$search}%' AND deleted_at IS NULL", $itemPerPage);
            $totalRow = $userDAL->countItems('id', "`username` LIKE '%{$search}%'")[0];
            $numPage = ceil($totalRow / $itemPerPage);
        }
    } else {
        $totalRow = $userDAL->countItems('id', 'deleted_at IS NOT NULL')[0];
        $numPage = ceil($totalRow / $itemPerPage);
        $users = $userDAL->getObjects($pageCurrent, 'deleted_at IS NOT NULL', $itemPerPage);
        $list_act = [
            'restore' => 'Khôi phục',
            'forceDelete' => 'Xóa vĩnh viên'
        ];
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $search = $_GET['q'];
            $users = $userDAL->getObjects($pageCurrent, "`username` LIKE '%{$search}%' AND deleted_at IS NOT NULL", $itemPerPage);
            $totalRow = $userDAL->countItems('id', "`username` LIKE '%{$search}%'")[0];
            $numPage = ceil($totalRow / $itemPerPage);
        }
    }
    $data = [
        'users' => $users,
        'numPage' => $numPage,
        'page' => $pageCurrent,
        'countUserActive' => $countUserActive,
        'countUserTrash' => $countUserTrash,
        'status' => $status,
        'list_act' => $list_act,
        'userDAL' => $userDAL
    ];
    if (!empty($search)) {
        $data['search'] = $search;
    }
    load_view('show', $data);
}

function addAction()
{
    $userDAL = new UserDAL();
    $roleDAL = new RoleDAL();
    $roles = $roleDAL->getObjects();
    global $config;
    if (!$userDAL->hasPermission('user.add')) {
        header("Location: {$config['base_url']}");
        exit;
    }

    load('helper', 'validation');
    global $error, $email, $username, $password;
    if (isset($_POST['btn_add'])) {
        // Kiểm tra username
        if (empty($_POST['username'])) {
            $error['username'] = "Vui lòng nhập username";
        } else {
            $username = $_POST['username'];
            if (!checkValidateUsername($username)) {
                $error['username'] = "Username không đúng định dạng";
            } else if ($userDAL->checkUsernameExist($username) > 0) {
                $error['username'] = "Username đã tồn tại trên hệ thống!";
            }
        }

        // Kiểm tra email
        if (empty($_POST['email'])) {
            $error['email'] = "Vui lòng nhập email";
        } else {
            $email = $_POST['email'];
            if (!checkValidateEmail($email)) {
                $error['email'] = "Email không đúng định dạng";
            } else if ($userDAL->checkEmailExist($email) > 0) {
                $error['email'] = "Email đã tồn tại trên hệ thống!";
            }
        }

        // Kiểm tra mật khẩu
        if (empty($_POST['password'])) {
            $error['password'] = "Vui lòng nhập password";
        } else {
            if (!checkValidatePassword($_POST['password'])) {
                $error['password'] = "Password không đúng định dạng";
            } else {
                $password = md5($_POST['password']);
            }
        }

        // Thực hiện thêm khi không có lỗi nhập
        if (empty($error)) {
            $userDTO = new UserDTO(NULL, $username, $password, $email, Date('Y-m-d H:i:s', time()), NULL, 'admin');
            $userDTO->setIsActive(1);
            $idUserAddRecently = $userDAL->addUser($userDTO);
            if ($idUserAddRecently != 0) {
                if (!empty($_POST['roles_id'])) {
                    $listRoleId = $_POST['roles_id'];
                    $userDAL->addRoles($idUserAddRecently, $listRoleId);
                }
                echo "<script type='text/javascript'>alert('Thêm thành công!');</script>";
                header("Refresh: 0.01; URL=?mod=user");
            }
        }
    }
    $data = [
        'error' => $error,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'roles' => $roles
    ];
    load_view('add', $data);
}

function editAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.edit')) {
        header("Location: {$config['base_url']}");
        exit;
    }

    load('helper', 'validation');
    $id = (int)$_GET['id'];
    $userDAL = new UserDAL();
    $roleDAL = new RoleDAL();
    $user = $userDAL->getObject($id);
    if (is_object($user)) {
        $roles = $roleDAL->getObjects();
        $rolesOfUser = $userDAL->getRolesIdOfUser($user->getId());
        global $error, $username;
        if (isset($_POST['btn_update'])) {
            // check username
            if (empty($_POST['username'])) {
                $error['username'] = "Vui lòng nhập username";
            } else {
                $username = $_POST['username'];
                $user->setUsername($username);
                if (!checkValidateUsername($username)) {
                    $error['username'] = "Username không đúng định dạng";
                } else if ($userDAL->checkUsernameExist($username, "`id` != {$user->getId()}")) {
                    $error['username'] = "Username đã tồn tại trên hệ thống";
                }
            }

            // update khi không còn lỗi
            if (empty($error)) {

                $userDAL->updateUser($user);
                if (!empty($_POST['roles_id'])) {
                    $userDAL->deleteRoleIdByUserId($user->getId());
                    $listRoleId = $_POST['roles_id'];
                    $userDAL->addRoles($user->getId(), $listRoleId);
                } else {
                    $userDAL->deleteRoleIdByUserId($user->getId());
                }
                echo "<script type='text/javascript'>alert('Cập nhật thành công!');</script>";
                // header("Refresh: 0.01; URL=?mod=user");
                header("Refresh:0.01");
            }
        }

        $data = [
            'user' => $user,
            'error' => $error,
            'username' => $username,
            'roles' => $roles,
            'rolesOfUser' => $rolesOfUser
        ];
        load_view('edit', $data);
    } else {
        header("location:?mod=user");
    }
}

function deleteAction()
{
    // $userDAL = new UserDAL();
    // global $config;
    // if (!$userDAL->hasPermission('user.delete')) {
    //     header("Location: {$config['base_url']}");
    // } else {
    //     $id = (int)$_GET['id'];
    //     $userDAL = new UserDAL();
    //     $user = $userDAL->getObject($id);
    //     if (is_object($user) && $user->getDeletedAt() == NULL) {
    //         if ($userDAL->deleteUser($user)) {
    //             echo "<script type='text/javascript'>alert('Xóa thành công!');</script>";
    //             header("Refresh: 0.01; URL=?mod=user");
    //         } else {
    //             header("location:?mod=user");
    //         }
    //     } else {
    //         header("location:?mod=user");
    //     }
    // }


    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.delete')) {
        header("Location: {$config['base_url']}");
        exit;
    }
    $id = (int)$_GET['id'];
    $userDAL = new UserDAL();
    $user = $userDAL->getObject($id);
    if (is_object($user) && $user->getDeletedAt() == NULL) {
        if ($userDAL->deleteUser($user)) {
            echo "<script type='text/javascript'>alert('Xóa thành công!');</script>";
            header("Refresh: 0.01; URL=?mod=user");
        } else {
            header("location:?mod=user");
        }
    } else {
        header("location:?mod=user");
    }
}


function restoreAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.delete')) {
        header("Location: {$config['base_url']}");
        exit;
    }
    $id = (int) $_GET['id'];
    $userDTO = $userDAL->getObject($id);
    if (is_object($userDTO)) {
        $userDAL->restore($userDTO);
        echo "<script type='text/javascript'>alert('Khôi phục thành công!');</script>";
        header("Refresh: 0.01; URL=?mod=user");
    } else {
        header("Location:?mod=user");
    }
}

function forceDeleteAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.delete')) {
        header("Location: {$config['base_url']}");
        exit;
    }
    $id = (int) $_GET['id'];
    $userDTO = $userDAL->getObject($id);
    if (is_object($userDTO)) {
        $userDAL->forceDelete($id);
        echo "<script type='text/javascript'>alert('Đã xóa vĩnh viễn user khỏi hệ thống!');</script>";
        header("Refresh: 0.01; URL=?mod=user");
    } else {
        header("Location:?mod=user");
    }
}


function handlerTasksSametimeAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!$userDAL->hasPermission('user.delete')) {
        echo "<script type='text/javascript'>alert('Bạn không có quyền thực hiện tác vụ này!');</script>";
        header("Refresh: 0.0001; URL=?mod=user");
        exit;
    }
    if (!empty($_POST['list_check'])) {
        $list_check = $_POST['list_check'];
        $act = $_POST['action'];
        if ($act == 'delete') {
            $userDAL->deleteAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã xóa thành công!');</script>";
            header("Refresh: 0.0001; URL=?mod=user");
        } elseif ($act == 'restore') {
            $userDAL->restoreAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã khôi phục thành công!');</script>";
            header("Refresh: 0.0001; URL=?mod=user");
        } elseif ($act == 'forceDelete') {
            $userDAL->forceDeleteAll($list_check);
            echo "<script type='text/javascript'>alert('Bạn đã xóa vĩnh viễn user khỏi hệ thống!');</script>";
            header("Refresh: 0.0001; URL=?mod=user");
        } else {
            echo "<script type='text/javascript'>alert('Vui lòng chọn thao tác để thực hiện!');</script>";
            header("Refresh: 0.0001; URL=?mod=user");
        }
    } else {
        echo "<script type='text/javascript'>alert('Vui lòng chọn phần tử để thực hiện thao tác!');</script>";
        header("Refresh: 0.0001; URL=?mod=user");
    }
}

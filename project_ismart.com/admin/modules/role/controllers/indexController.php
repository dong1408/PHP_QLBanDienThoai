<?php

function construct()
{
    
}

function indexAction()
{
    $roleDAL = new RoleDAL();
    $roles = $roleDAL->getObjects();
    $data = [
        'roles' => $roles
    ];
    load_view('show', $data);
}


function addAction()
{
    $permissionDAL = new PermissionDAL();
    $roleDAL = new RoleDAL();
    $permissions = $permissionDAL->getPermissionByGroup();
    global $error, $nameRole, $description;
    if (isset($_POST['btn_add'])) {

        // Kiểm tra tên quyền
        if (empty($_POST['nameRole'])) {
            $error['nameRole'] = "Không được để trống trường này!";
        } else {
            $nameRole = $_POST['nameRole'];
        }

        // Kiểm tra miêu tả
        if (empty($_POST['description'])) {
            $error['description'] = "Không được để trống trường này!";
        } else {
            $description = $_POST['description'];
        }

        if (!empty($_POST['list_permission_id'])) {
            $listPermissionId = $_POST['list_permission_id'];
        }

        // Them vai tro khi khong con loi
        if (empty($error)) {
            $roleDTO = new RoleDTO(NULL, $nameRole, $description, Date('Y-m-d H:i:s', time()), NULL);
            $roleIdInsert = $roleDAL->addRole($roleDTO);
            if (!empty($_POST['list_permission_id'])) {
                $listPermissionId = $_POST['list_permission_id'];
                $roleDAL->addPermissions($roleIdInsert, $listPermissionId);
            }
            echo "<script type='text/javascript'>alert('Thêm thành công!');</script>";
            header("Refresh: 0.01; URL=?mod=role");
        }
    }
    $data = [
        'permissions' => $permissions,
        'error' => $error,
        'nameRole' => $nameRole,
        'description' => $description
    ];
    load_view('add', $data);
}

function editAction()
{
    $id = (int)$_GET['id'];
    $roleDAL = new RoleDAL();
    $permissionDAL = new PermissionDAL();
    $role = $roleDAL->getObject($id);
    if (is_object($role)) {
        $permissions = $permissionDAL->getPermissionByGroup();
        $listPermissionIdByRole = $roleDAL->getPermissionIdsByRoleId($role->getId());
        global $error, $nameRole, $description;
        if (isset($_POST['btn_update'])) {
            // Kiểm tra tên quyền
            if (empty($_POST['nameRole'])) {
                $error['nameRole'] = "Không được để trống trường này!";
            } else {
                // $nameRole = $_POST['nameRole'];
                $role->setName($_POST['nameRole']);
            }

            // Kiểm tra miêu tả
            if (empty($_POST['description'])) {
                $error['description'] = "Không được để trống trường này!";
            } else {
                // $description = $_POST['description'];
                $role->setDescription($_POST['description']);
            }

            if (empty($error)) {

                $roleDAL->updateRole($role);
                if (!empty($_POST['list_permission_id'])) {
                    $roleDAL->deletePermissionsIdByRoleId($role->getId());
                    $listPermissionId = $_POST['list_permission_id'];
                    $roleDAL->addPermissions($role->getId(), $listPermissionId);
                } else {
                    $roleDAL->deletePermissionsIdByRoleId($role->getId());
                }
                echo "<script type='text/javascript'>alert('Cập nhật thành công!');</script>";
                header("Refresh: 0.01; URL=?mod=role");
            }
        }

        // echo "<pre>";
        // print_r($listPermissionIdByRole);
        // echo "</pre>";

        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'listPermissionIdByRole' => $listPermissionIdByRole,
            'error' => $error,
            'nameRole' => $nameRole,
            'description' => $description
        ];
        load_view('edit', $data);
    } else {
        header("Location:?mod=role");
    }
}

function deleteAction()
{
}

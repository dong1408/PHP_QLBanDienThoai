<?php

function construct()
{
    
}

function indexAction()
{
    $permissionDAL = new PermissionDAL();
    $permissions = $permissionDAL->getPermissionByGroup();
    $data = [
        'permissions' => $permissions
    ];
    // global $name;
    // echo $name;
    load_view('show', $data);
}

function addAction()
{
    $permissionDAL = new PermissionDAL();
    $permissions = $permissionDAL->getPermissionByGroup();
    global $error, $namePermission, $slug, $description;
    if (isset($_POST['btn_add'])) {
        // Kiểm tra tên quyền
        if (empty($_POST['namePermission'])) {
            $error['namePermission'] = "Vui lòng nhập tên quyền!";
        } else {
            $namePermission = $_POST['namePermission'];
        }

        // Kiểm tra slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "Vui lòng nhập slug";
        } else {
            $slug = $_POST['slug'];
        }

        // Kiểm tra mô tả
        if (empty($_POST['description'])) {
            $description = NULL;
        } else {
            $description = $_POST['description'];
        }

        // Add permission khi không còn lỗi
        if (empty($error)) {
            $permissionDTO = new PermissionDTO(NULL, $namePermission, $slug, $description, Date('Y-m-d H:i:s', time()), NULL);
            if ($permissionDAL->addPermission($permissionDTO)) {
                echo "<script type='text/javascript'>alert('Thêm thành công!');</script>";
                header("Refresh: 0.01; URL=?mod=permission&action=add");
            }
        }
    }
    $data = [
        'error' => $error,
        'permissions' => $permissions,
        'namePermission' => $namePermission,
        'slug' => $slug,
        'description' => $description
    ];
    load_view('add', $data);
}


function editAction()
{
    $id = (int)$_GET['id'];
    $permissionDAL = new PermissionDAL();
    $permissions = $permissionDAL->getPermissionByGroup();
    $permission = $permissionDAL->getObject($id);
    global $error, $namePermission, $slug, $description;
    if (isset($_POST['btn_update'])) {
        // Kiểm tra tên quyền
        if (empty($_POST['namePermission'])) {
            $error['namePermission'] = "Vui lòng nhập tên quyền!";
        } else {
            $permission->setName($_POST['namePermission']);
        }

        // Kiểm tra slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "Vui lòng nhập slug";
        } else {
            $permission->setSlug($_POST['slug']);
        }

        // Kiểm tra mô tả
        if (empty($_POST['description'])) {
            $description = NULL;
        } else {
            $permission->setDescription($_POST['description']);
        }

        // Update permission khi không còn lỗi
        if (empty($error)) {
            if ($permissionDAL->updatePermission($permission)) {
                echo "<script type='text/javascript'>alert('Cập nhật thành công!');</script>";
                header("Refresh: 0.01; URL=?mod=permission&action=edit&id={$id}");
            }
        }

    }
    $data = [
        'permissions' => $permissions,
        'permission' => $permission
    ];
    load_view('edit', $data);
}

function deleteAction(){
    $id = (int)$_GET['id'];
    $permissionDAL = new PermissionDAL();
    if(is_object($permissionDAL->getObject($id))){
        $permissionDAL->deletePermission($id);
        header("Location:?mod=permission");
    }else{
        header("Location:?mod=permission");
    }
}


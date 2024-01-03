<?php

function construct()
{
    // Dùng chung, load đầu tiên
    load_model('index');
}


// Đăng nhập
function loginAction()
{
    $userDAL = new UserDAL();
    global $config;
    if (!isset($_SESSION['is_login'])) {
        global $error, $username, $password;
        if (isset($_POST['btn-login'])) {

            // Kiểm tra định dạng username
            if (empty($_POST['username'])) {
                $error['username'] = "Vui lòng nhập username!";
            } else {
                $username = $_POST['username'];
            }

            // Kiểm tra định dạng password
            if (empty($_POST['password'])) {
                $error['password'] = "Vui lòng nhập mật khẩu!";
            } else {
                $password = md5($_POST['password']);
            }

            //Đăng nhập khi đúng định dạng
            if (empty($error)) {
                if ($userDAL->check_login($username, $password)) {
                    // Lưu trữ phiên đăng nhập
                    $_SESSION['is_login'] = TRUE;
                    $_SESSION['user_login'] = $username;
                    $userID = $userDAL->get_userid_by_username($username);
                    $_SESSION['userID'] = $userID;
                    if ($userDAL->check_permission_admin($userID)) {
                        $_SESSION['is_admin'] = TRUE;
                        $_SESSION['list_permission'] = get_permissions_by_userId($userID);
                        // print_r($_SESSION['list_permission']);
                    }
                    header("Location:{$config['base_url']}");
                } else {
                    $password = "";
                    $error['username'] = "Tài khoản mật khẩu không chính xác";
                }
            }
        }

        global $error;
        $data = [
            'error' => $error,
            'username' => $username,
            'password' => $password
        ];
        load_view('login', $data);
    } else {
        header("Location:{$config['base_url']}");
    }
}


// Đăng ký tài khoản
function registerAction()
{
    load('helper', 'validation');
    load('helper', 'url');
    $userDAL = new UserDAL();
    global $error, $username, $fullname, $email;
    if (isset($_POST['btn-register'])) {

        // Kiểm tra tên đăng nhập
        if (empty($_POST['username'])) {
            $error['username'] = 'Tên đăng nhập không được để trống!';
        } else {
            $username = $_POST['username'];
            if (!checkValidateUsername($_POST['username'])) {
                $error['username'] = 'Tên đăng nhập không đúng định dạng!';
            }
        }

        // Kiểm tra password
        if (empty($_POST['password'])) {
            $error['password'] = 'Mật khẩu không được để trống!';
        } else {
            $password = md5($_POST['password']);
            if (!checkValidatePassword($_POST['password'])) {
                $error['password'] = 'Mật khẩu không đúng định dạng!';
            }
        }

        // Kiểm tra email
        if (empty($_POST['email'])) {
            $error['email'] = 'Email không được để trống!';
        } else {
            $email = $_POST['email'];
            if (!checkValidateEmail($_POST['email'])) {
                $error['email'] = 'Email không đúng định dạng!';
            }
        }


        // Đăng ký khi đúng tất cả các thông tin
        if (empty($error)) {
            if ($userDAL->user_exist($username, $email)) {
                echo "<script type='text/javascript'>alert('username hoặc email đã tồn tại trong hệ thống');</script>";
            } else {
                $active_token = md5($username . time());
                $userDTO = new UserDTO(NULL, $username, $password, $email, Date('Y-m-d H:i:s', time()), NULL, 'Guest');
                $userDTO->setActiveToken($active_token);
                $userDAL->addUser($userDTO);
                $link_active = base_url("?mod=user&action=active&active_token={$active_token}");
                $content = "<p>Chào bạn {$username}</p>
                <p>Bạn vui lòng click vào đường link này để kích hoạt tài khoản: $link_active";
                send_mail($email, $username, 'Kích hoạt tài khoản', $content);
                echo "<script type='text/javascript'>alert('Bạn đã đăng ký tài khoản thành công! Vui lòng check email để kích hoạt tài khoản.');</script>";
            }
        }
    }
    $data = [
        'error' => $error,
        'username' => $username,
        'email' => $email
    ];
    load_view('register', $data);
}


// Xử lý kích hoạt tài khoản đăng ký
function activeAction()
{
    $userDAL = new UserDAL();
    load('helper', 'url');
    $active_token = $_GET['active_token'];
    if ($userDAL->check_active_token($active_token)) {
        $userDAL->active_user($active_token);
        $link_login = base_url("?mod=user&action=login");
        echo "Bạn đã kích hoạt tài khoản thành công. Vui lòng click vào link sau để đăng nhập: <a href='{$link_login}'>Đăng nhập</a>";
    } else {
        echo "Yêu cầu kích hoạt không hợp lệ hoặc tài khoản đã được kích hoạt trước đó";
    }
}



// Đăng xuất
function logoutAction()
{
    global $config;
    unset($_SESSION['is_login']);
    unset($_SESSION['user_login']);
    unset($_SESSION['is_admin']);
    unset($_SESSION['list_permission']);

    header("Location:{$config['base_url']}");
}



// Quên mặt khẩu
function forgetPasswordAction()
{
    load('helper', 'validation');
    load('helper', 'url');
    $userDAL = new UserDAL();
    global $error, $email;
    if (isset($_POST['btn_reset_pass'])) {

        // Kiểm tra email
        if (empty($_POST['email'])) {
            $error['email'] = "Vui lòng nhập email";
        } else {
            $email = $_POST['email'];
            if (!checkValidateEmail($email)) {
                $error['email'] = "Email không đúng định dạng";
            }
        }

        // Tiếp tục xử lý khi không còn lỗi
        if (empty($error)) {
            if (email_exist($email)) {  // Kiểm tra email có tồn tại trên hệ thống hay không
                $reset_token = md5($email . time());
                $data = array(
                    'reset_token' => $reset_token
                );
                // Cập nhật mã resert pass cho user cần khôi phục mật khẩu
                $userDAL->update_resert_token($data, $email);
                // Gửi link khôi phục vào email của người dùng
                $link = base_url("?mod=user&action=handleForgetPassword&reset_token={$reset_token}&email={$email}");
                $content = "<p>Xin chào</p><p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
                <p>Bạn vui lòng click vào link sau để khôi phục mật khẩu: {$link} </p>
                <p>Đường link này có hiệu lực trong vòng 60 phút.</p>
                <p>Nếu bạn không yêu cầu lấy lại mật khẩu, bạn vui lòng bỏ qua email này.</p>";
                send_mail($email, 'ABC', 'Khôi phục mật khẩu', $content);
                echo "<script type='text/javascript'>alert('Chúng tôi đã gửi một đường link đặt lại mật khẩu tới gmail của bạn. Vui lòng kiểm tra mail để tiếp tục!');</script>";
            } else {
                $error['email'] = "Địa chỉ email không tồn tại trên hệ thống";
            }
        }
    }
    $data = [
        'error' => $error,
        'email' => $email
    ];
    load_view('forgetPassword', $data);
}


// Xử lý quên mật khẩu
function handleForgetPasswordAction()
{
    load('helper', 'validation');
    load('helper', 'url');
    $userDAL = new UserDAL();
    global $email;
    if (isset($_GET['reset_token'])) {
        $reset_token = $_GET['reset_token'];
    }
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    }
    if (!empty($reset_token)) {
        if ($userDAL->check_resert_token($reset_token)) {
            global $error;
            if (isset($_POST['btn_reset_pass'])) {

                // Kiểm tra định dạng password
                if (empty($_POST['password'])) {
                    $error['password'] = "Vui lòng nhập mật khẩu!";
                } else {
                    if (empty($_POST['confirmPass'])) {
                        $error['confirmPass'] = 'Vui lòng xác nhận lại mật khẩu!';
                    } else {
                        if (checkValidatePassword($_POST['password'])) {
                            $password = $_POST['password'];
                            $confirmPass = $_POST['confirmPass'];
                            if (!$userDAL->compareStringsWithSpecialChars($password, $confirmPass)) {
                                $error['password'] = 'Trường mật khẩu xác nhận không khớp';
                            }
                        } else {
                            $error['password'] = "Password không đúng định dạng";
                        }
                    }
                }

                if (empty($error)) {
                    $data = array(
                        'password' => md5($password)
                    );
                    $userDAL->update_pass($data, $reset_token);
                    echo "<script type='text/javascript'>alert('Mật khẩu đã được đặt lại thành công! Hệ thống sẽ chuyển hướng bạn tới trang đăng nhập trong vài giây.');</script>";
                    // header("Location:?mod=user&action=login");
                    header("Refresh: 2; URL=?mod=user&action=login");
                }
            }
            $data = array(
                'error' => $error,
                'email' => $email
            );
            load_view('newPass', $data);
        } else {
            echo "Yêu cầu lấy lại mật khẩu không hợp lệ";
        }
    }
}


function orderAction()
{
    if (isset($_SESSION['is_login'])) {
        $type = isset($_GET['type']) ? $_GET['type'] : "0";
        $orderDAL = new OrderDAL();
        $orderDetailDAL = new OrderDetailDAL();
        $productDAL = new ProductDAL();
        $orderStatusDAL = new OrderStatusDAL();
        $list_orderStatus = $orderStatusDAL->getObjects();
        $flag = false;
        foreach ($list_orderStatus as $orderStatus) {
            if ($orderStatus->getId() == $type) {
                $flag = true;
            }
        }
        if ($flag) {
            $orders = $orderDAL->getObjects(NULL, "user_id = {$_SESSION['userID']} AND status_id = '{$type}'");
        }else{
            $orders = $orderDAL->getObjects(NULL, "user_id = {$_SESSION['userID']}");
            $type = 0;
        }
        $data = [
            'orders' => $orders,
            'orderDetailDAL' => $orderDetailDAL,
            'productDAL' => $productDAL,
            'list_orderStatus' => $list_orderStatus,
            'orderStatusDAL' => $orderStatusDAL,
            'type' => $type
        ];
        load_view('order', $data);
    } else {
        header("Location:?");
    }
}

<?php
// Kiểm tra xem hằng số APPPATH có tồn tại hay không
defined('APPPATH') or exit('Không được quyền truy cập phần này');

// Include file config/database
require CONFIGPATH . DIRECTORY_SEPARATOR . 'database.php';

// Include file config/config
require CONFIGPATH . DIRECTORY_SEPARATOR . 'config.php';

// Include file config/email
require CONFIGPATH . DIRECTORY_SEPARATOR . 'email.php';

// Include file config/autoload
require CONFIGPATH . DIRECTORY_SEPARATOR . 'autoload.php';

// Include core database
require LIBPATH . DIRECTORY_SEPARATOR . 'database.php';


// ======================== Include DTO =========================== //
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/userDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/roleDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/permissionDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/productDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/categoryDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/ramDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/romDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/colorDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/orderDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/orderDetailDTO.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/orderStatusDTO.php';

// ======================= Include DAL ============================== //
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/userDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/permissionDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/roleDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/productDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/categoryDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/ramDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/romDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/colorDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/orderDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/orderDetailDAL.php';
require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/orderStatusDAL.php';


// Include core base
require COREPATH . DIRECTORY_SEPARATOR . 'base.php';




if (is_array($autoload)) {
    foreach ($autoload as $type => $list_auto) {
        if (!empty($list_auto)) {
            foreach ($list_auto as $name) {
                load($type, $name);
            }
        }
    }
}



//
//connect db
db_connect($db);

require COREPATH . DIRECTORY_SEPARATOR . 'router.php';

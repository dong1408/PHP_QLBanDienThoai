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

// Include file includes/constant.inc
require INCLUDESPATH . DIRECTORY_SEPARATOR . 'constant.inc.php';

// Include core database
require LIBPATH . DIRECTORY_SEPARATOR . 'database.php';

// ======================== Include DTO =========================== //
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/userDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/roleDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/permissionDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/ProductDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/CategoryDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/RamDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/RomDTO.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dto/ColorDTO.php';

require '../classes/dto/userDTO.php';
require '../classes/dto/roleDTO.php';
require '../classes/dto/permissionDTO.php';
require '../classes/dto/productDTO.php';
require '../classes/dto/CategoryDTO.php';
require '../classes/dto/RamDTO.php';
require '../classes/dto/RomDTO.php';
require '../classes/dto/ColorDTO.php';
require '../classes/dto/orderDTO.php';
require '../classes/dto/orderDetailDTO.php';
require '../classes/dto/orderStatusDTO.php';

// ======================= Include DAL ============================== //
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/userDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/permissionDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/roleDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/productDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/categoryDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/ramDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/romDAL.php';
// require APPPATH . DIRECTORY_SEPARATOR . 'classes/dal/colorDAL.php';

require '../classes/dal/userDAL.php';
require '../classes/dal/permissionDAL.php';
require '../classes/dal/roleDAL.php';
require '../classes/dal/productDAL.php';
require '../classes/dal/categoryDAL.php';
require '../classes/dal/ramDAL.php';
require '../classes/dal/romDAL.php';
require '../classes/dal/colorDAL.php';
require '../classes/dal/orderDAL.php';
require '../classes/dal/orderDetailDAL.php';
require '../classes/dal/orderStatusDAL.php';


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




// connect db
// db_connect($db);

require COREPATH . DIRECTORY_SEPARATOR . 'router.php';

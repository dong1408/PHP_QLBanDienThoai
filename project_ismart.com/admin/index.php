<?php
session_start();
ob_start();

/*
 * --------------------------------------------------------------------
 * app path
 * --------------------------------------------------------------------
 */
$app_path = dirname(__FILE__);
define('APPPATH', $app_path);
// var_dump($app_path);
// echo ($app_path);
/*
 * --------------------------------------------------------------------
 * core path
 * --------------------------------------------------------------------
 */
$core_folder = 'core';
define('COREPATH', APPPATH . DIRECTORY_SEPARATOR . $core_folder);


/*
 * --------------------------------------------------------------------
 * includes path
 * --------------------------------------------------------------------
 */
$includes_folder = 'includes';
define('INCLUDESPATH', APPPATH . DIRECTORY_SEPARATOR . $includes_folder);

/*
 * --------------------------------------------------------------------
 * modules path
 * --------------------------------------------------------------------
 */
$modules_folder = 'modules';
define('MODULESPATH', APPPATH . DIRECTORY_SEPARATOR . $modules_folder);

/*
 * --------------------------------------------------------------------
 * helper path
 * --------------------------------------------------------------------
 */

$helper_folder = 'helper';
define('HELPERPATH', APPPATH . DIRECTORY_SEPARATOR . $helper_folder);


/*
 * --------------------------------------------------------------------
 * library path
 * --------------------------------------------------------------------
 */
$lib_folder = 'libraries';
define('LIBPATH', APPPATH . DIRECTORY_SEPARATOR . $lib_folder);


/*
 * --------------------------------------------------------------------
 * layout path
 * --------------------------------------------------------------------
 */
$layout_folder = 'layout';
define('LAYOUTPATH', APPPATH . DIRECTORY_SEPARATOR . $layout_folder);

/*
 * --------------------------------------------------------------------
 * config path
 * --------------------------------------------------------------------
 */
$config_folder = 'config';
define('CONFIGPATH', APPPATH . DIRECTORY_SEPARATOR . $config_folder);

require COREPATH . DIRECTORY_SEPARATOR . 'appload.php';

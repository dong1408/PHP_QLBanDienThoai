<?php
defined('APPPATH') OR exit('Không được quyền truy cập phần này');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| Đây là những phần (file) được load tự động khi ứng dụng khởi động
|
| 1. Libraries
| 2. Helper file
|
*/

/*
 * ------------------------------------------------------------------
 * Autoload Libraries
 * ------------------------------------------------------------------
 * Ví dụ: 
 * $autoload['lib'] = array('validation', 'pagging');
 */


$autoload['lib'] = array();

/*
 * ------------------------------------------------------------------
 * Autoload Helper
 * ------------------------------------------------------------------
 * Ví dụ:
 * $autoload['helper'] = array('data','string');
 */


$autoload['helper'] = array('data','permission','pagging', 'url', 'format');








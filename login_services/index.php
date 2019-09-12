<?php 
/**
 *  index.php 飞天系统后台模拟入口
 *
 * @copyright			(C) 2005-2014 EDI
 * @license				http://www.05273.com/index.php?app=license
 * @lastmodify			2014-5-16
 */
define('SHUYANG_PATH', realpath(dirname(__FILE__) . '/..') . '/'); 
include SHUYANG_PATH . '/languages/feitian.php'; 
// shy_base::creat_app(); 
$session_storage = 'session_' . shy_base :: load_config('system', 'session_storage'); 
shy_base :: load_sys_class($session_storage); 
session_start(); 
$_SESSION['right_enter'] = 1; 
   
unset($session_storage); 
header('location:../index.php?app=admin'); 
?>

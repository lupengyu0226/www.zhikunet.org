<?php
/**
 *  大海哪蓝-WY-2018-07-07
 */
$_filename = basename(__FILE__, '.php');
list(, $method, $driver) = explode("_", $_filename);
define('_PAYMENT_', $driver);
$_GET['app'] = 'pay';
$_GET['controller'] = 'respond';
$_GET['view'] = 'd'.$method;
include dirname(__FILE__).'/../index.php';
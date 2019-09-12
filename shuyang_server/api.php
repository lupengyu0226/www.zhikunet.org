<?php 
/**
 *  index.php API 入口
 *
 * @copyright			(C) 2005-2010 SHUYANG
 * @license				http://www.05273.com/license/
 * @lastmodify			2010-7-26
 */
define('SHUYANG_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include './templates/feitian.php';
$param = shy_base::load_sys_class('param');

$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : exit('Operation can not be empty');
if (!preg_match('/([^a-z_]+)/i',$op) && file_exists('api'.DIRECTORY_SEPARATOR.$op.'.php')) {
	include 'api'.DIRECTORY_SEPARATOR.$op.'.php';
} else {
	exit('API handler does not exist');
}
?>

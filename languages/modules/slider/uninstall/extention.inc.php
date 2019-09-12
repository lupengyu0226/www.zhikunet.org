 <?php 
defined('IN_SHUYANG') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');
$type_db = shy_base::load_model('type_model');
$typeid = $type_db->delete(array('module'=>'slider'));
if(!$typeid) return FALSE;
 ?>
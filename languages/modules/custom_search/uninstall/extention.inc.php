 <?php 
defined('IN_SHUYANG') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');
$type_db = shy_base::load_model('type_model');
$typeid = $type_db->delete(array('module'=>'custom_search'));
if(!$typeid) return FALSE;
 ?>
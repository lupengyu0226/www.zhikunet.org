<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
/**
 *  沭阳号页面统计功能
 *
 * @copyright			(C) 2007-2015 05273.com
 * @license				http://www.05273.com/index.php?app=license
 * @lastmodify			2010-7-26
 */
//$db = '';
$db = shy_base::load_model('zhuanlan_model');
$id = intval($_GET['id']);
$domain = new_html_special_chars($_GET['domain']);
if($id) {
	$r = $db->get_one(array('id'=>$id,'domain'=>$domain));
	$db->update(array('total'=>'+=1'),array('id'=>$id,'status'=>'1','domain'=>$domain));
	} else {
	$r['total'] = 'ID parameters do not exist';
}
?>
$('#hits').html('<?php echo $r['total']?>');

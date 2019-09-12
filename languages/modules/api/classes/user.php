<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
/**
 * 用户积分调用
 */
$db = '';
$db = shy_base::load_model('member_model');
if(empty($_GET['uid'])) {
	$point = '-0';
} else {
	$uid = safe_replace(addslashes(urldecode($_GET['uid'])));
	$r = $db->get_one(array('userid'=>$uid));  
	if(!empty($r)){
		$uid = $r['userid'];
	}else{
		$r['point'] = '-1';
	}
	$point = $r['point'];
	if ($r['vip']==1) {
		$vip = '<p class="authormp"></p>';
	}
} 
?>
$('#point').html('<?php echo $point?>'),$('#authormp').html('<?php echo $vip?>');
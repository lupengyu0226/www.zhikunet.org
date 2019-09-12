<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
/**
 * 点击统计
 */
$db = '';
$db = shy_base::load_model('hits_model');
if($_GET['modelid'] && $_GET['id']) {
	$model_arr = array();
	$model_arr = getcache('model','commons');
	$modelid = intval($_GET['modelid']);
	$hitsid = 'c-'.$modelid.'-'.intval($_GET['id']);
	$r = get_count($hitsid);
	if(!$r) exit;
    extract($r);
    hits($hitsid);
} elseif($_GET['module'] && $_GET['id']) {
	$module = $_GET['module'];
	if((preg_match('/([^a-z0-9_\-]+)/i',$module))) exit('1');
	$hitsid = $module.'-'.intval($_GET['id']);
	$r = get_count($hitsid);
	if(!$r) exit;
    extract($r);
    hits($hitsid);
}


/**
 * 获取点击数量
 * @param $hitsid
 */
function get_count($hitsid) {
	$db = shy_base::load_model('hits_model');
    $r = $db->get_one(array('hitsid'=>$hitsid));  
    if(!$r) return false;	
	return $r;	
}

/**
 * 点击次数统计
 * @param $contentid
 */
function hits($hitsid) {
	$db = shy_base::load_model('hits_model');
	$r = $db->get_one(array('hitsid'=>$hitsid));
	if(!$r) return false;
	$weixinview = $r['weixinview'] + 1;
	$sql = array('weixinview'=>$weixinview,'updatetime'=>SYS_TIME);
    return $db->update($sql, array('hitsid'=>$hitsid));
}

?>
$('#hits').html('<?php echo $weixinview?>');
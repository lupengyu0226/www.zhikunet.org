<?php
/**
 * 稿件统计
 *
 * @copyright			(C) 2007-2015 05273.cn
 * @license				http://www.05273.cn/index.php?app=license
 * @lastmodify			2010-6-1
 */

/**
 * 更新管理员管理统计信息
 * @param  $field 需要更新的字段
 */
function m_stats($field,$title = '',$catid = 0, $hitsid = '',$url = '',$username = '') {
	if(!$field) return false;
	$manage_stats = shy_base::load_model('manage_stats_model');
	if($username==null){
		$username = param::get_cookie('admin_username');
	}
	$stat_time = date('Ymd',SYS_TIME);
	$manage_stats->update("`$field`=`$field`+1",array('stat_time'=>$stat_time,'username'=>$username));
	if($manage_stats->affected_rows()==0) {
		$manage_stats->insert(array($field=>1,'stat_time'=>$stat_time,'username'=>$username));
	}
	if($field == 'add' && $title) {
		$manage_stats_add = shy_base::load_model('manage_stats_add_model');
		$manage_stats_add->insert(array('title'=>$title,'catid'=>$catid,'hitsid'=>$hitsid,'url'=>$url,'inputtime'=>SYS_TIME,'username'=>$username));
	}
}
?>

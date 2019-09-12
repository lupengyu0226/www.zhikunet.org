<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	
	function __construct() {
		shy_base::load_app_func('global');
		$this->db = shy_base::load_model('announce_model');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}
	
	public function init() {
		cache_page_start();
		$SEO = seo(SITEID, '', $subject, $description, $subject);
		$siteid = SITEID;
		$title='网站公告';
		$description='发布沭阳网网站公告!';
		$keywords='沭阳公告,沭阳网站公告,通知公告';
		$SEO = seo($siteid,0, $title, $description, $keywords);
		$urlrule = '/announce.shtml~/announce-l{$page}.shtml';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		include template('announce', 'index');
		cache_page(120);
	}
	/**
	 * 展示公告
	 */
	public function show() {
		cache_page_start();
		if(!isset($_GET['aid'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['aid'] = intval($_GET['aid']);
		$where = '';
		$where .= "`aid`='".$_GET['aid']."'";
		$where .= " AND `passed`='1' AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')";
		$r = $this->db->get_one($where);
		if($r['aid']) {
			$this->db->update(array('hits'=>'+=1'), array('aid'=>$r['aid']));
			$template = $r['show_template'] ? $r['show_template'] : 'show';
			extract($r);
			$SEO = seo(get_siteid(), '', $title);
			include template('announce', $template, $r['style']);
		} else {
			showmessage(L('no_exists'));	
		}
		cache_page(120);
	}
}
?>

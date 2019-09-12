<?php 
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	function __construct() {
		$this->db = shy_base::load_model('license_model');
	}
	public function init() {
		$siteid = 'SITEID';
 		$setting = getcache('license', 'commons');
		$SEO = seo('SITEID', '', L('license'), '', '');
		include template('license', 'index');
        }
	public function certificate() {	
	if(!isset($_GET['domain'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['aid'] =trim($_GET['aid']);
                $type_data = getcache('type_content_'.$license,'commons');
		$where = '';
		$where .= "`domain`='".$_GET['domain']."'";
		$where .= " AND `passed`='1' AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')";
		$r = $this->db->get_one($where);
		if($r['domain']) {
			$template = $r['show_template'] ? $r['show_template'] : 'show';
			extract($r);
			include template('license', $template, $r['style']);
		} else {
			showmessage(L('no_exists'));	
		}

	}
	public function notice() {	
	if(!isset($_GET['domain'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['aid'] =trim($_GET['aid']);
                $type_data = getcache('type_content_'.$license,'commons');
		$where = '';
		$where .= "`domain`='".$_GET['domain']."'";
		$where .= " AND `passed`='1' AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')";
		$r = $this->db->get_one($where);
		if($r['domain']) {
			$template = $r['show_template'] ? $r['show_template'] : 'notice';
			extract($r);
			include template('license', $template, $r['style']);
		} else {
			showmessage(L('no_exists'));	
		}

	}
}
?>

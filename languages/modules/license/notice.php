<?php 
defined('IN_SHUYANG') or exit('No permission resources.');
class notice {
	function __construct() {
		$this->db = shy_base::load_model('license_model');
	}
	public function init() {	
	if(!isset($_GET['domain'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['aid'] =trim($_GET['aid']);
                $type_data = getcache('type_content_'.$license,'commons');
		$where = '';
		$where .= "`domain`='".$_GET['domain']."'";
		$where .= " AND `passed`='1' AND (`shouquanend` >= '".date('Y-m-d')."' or `shouquanend`='0000-00-00')";
		$r = $this->db->get_one($where);
		if($r['domain']) {
			$template = $r['show_template'] ? $r['show_template'] : 'notice';
			extract($r);
			include template('license', 'notice');
		} else {
			include template('license', 'nonotice');
		}

	}
}
?>

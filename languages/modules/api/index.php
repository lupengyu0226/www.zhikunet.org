<?php 
/**
 *  index.php 飞天系统API接口
 *
 * @copyright			(C) 2005-2010 沭阳网
 * @license				http://www.05273.com/index.php?app=license
 * @lastmodify			2018-10-18
 */
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	private $_userid,$modules;
	public function __construct(){
		$param = shy_base::load_sys_class('param');
		$this->_userid = param::get_cookie('_userid');
	}
	public function init(){
		if($_userid) {
			$member_db = shy_base::load_model('member_model');
			$_userid = intval($_userid);
			$memberinfo = $member_db->get_one(array('userid'=>$_userid),'islock');
			if($memberinfo['islock']) halt('<h1>Bad Request!</h1>');
		}
		$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : halt('您无权访问本API接口');
		if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
		if(!preg_match('/([^a-z_]+)/i',$op) && file_exists(SHY_PATH.'modules'.DIRECTORY_SEPARATOR.ROUTE_M.DIRECTORY_SEPARATOR.'classes/'.$op.'.php')) {
			include SHY_PATH.'modules'.DIRECTORY_SEPARATOR.ROUTE_M.DIRECTORY_SEPARATOR.'classes/'.$op.'.php';
		} else {
			halt('您访问的API不存在');
		}

	}
}
?>
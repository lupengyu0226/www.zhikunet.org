<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('hook','','0');
class shenhe extends hook{
	Final static function admin_top_left_menu(){
		$sql = '';
		$siteid = get_siteid();
		$categorys = getcache('category_content_'.$siteid,'commons');
		if (in_array($_SESSION['roleid'], array('1'))) {
			$super_admin = 1;
			$status = isset($_GET['status']) ? $_GET['status'] : -1;
		} else {
			$super_admin = 0;
			$status = isset($_GET['status']) ? $_GET['status'] : 1;
			if($status==-1) $status = 1;
		}
		if($status>4) $status = 4;
		$priv_db = shy_base::load_model('category_priv_model');;
		$admin_username = param::get_cookie('admin_username');
		if($status==-1) {
			$sql = "`status` NOT IN (99,0,-2)";
		} else {
			$sql = "`status` = '$status' ";
		}
		if($status!=0 && !$super_admin) {
			//以栏目进行循环
			foreach ($categorys as $catid => $cat) {
				if($cat['type']!=0) continue;
				//查看管理员是否有这个栏目的查看权限。
				if (!$priv_db->get_one(array('catid'=>$catid, 'siteid'=>$siteid, 'roleid'=>$_SESSION['roleid'], 'is_admin'=>'1'))) {
					continue;
				}
				//如果栏目有设置工作流，进行权限检查。
				$workflow = array();
				$cat['setting'] = string2array($cat['setting']);
				if (isset($cat['setting']['workflowid']) && !empty($cat['setting']['workflowid'])) {
					$workflow = $workflows[$cat['setting']['workflowid']];
					$workflow['setting'] = string2array($workflow['setting']);
					$usernames = $workflow['setting'][$status];
					if (empty($usernames) || !in_array($admin_username, $usernames)) {//判断当前管理，在工作流中可以审核几审
						continue;
					}
				}
				$priv_catid[] = $catid;
			}
			if(empty($priv_catid)) {
				$sql .= " AND catid = -1";
			} else {
				$priv_catid = implode(',', $priv_catid);
				$sql .= " AND catid IN ($priv_catid)";
			}
		}
		$content_check_db = shy_base::load_model('content_check_model');
		$num = $content_check_db->count($sql);
		$num = $num <= 100 ? $num : '100+';
		if($num > 0 ) {
			include template('plugin/shenhe','index');
		} else {
			return '';
		}
	}

}
?>

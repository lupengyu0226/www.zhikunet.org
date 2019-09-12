<?php
/**
 * 飞天系统前台免登录投稿
 */

defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('baoliaoclass');
shy_base::load_sys_class('format', '', 0);
shy_base::load_sys_class('form', '', 0);
shy_base::load_app_func('global', 'member');

class baoliao extends baoliaoclass {
	private $times_db;
	function __construct() {
		parent::__construct();
	}
	public function publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		$priv_db = shy_base::load_model('category_priv_model'); //加载栏目权限表数据模型
		
		//判断会员组是否允许投稿
		if(!$grouplist[$memberinfo['groupid']]['allowpost']) {
			showmessage(L('member_group').L('publish_deny'), HTTP_REFERER);
		}
		//判断每日投稿数
		$this->content_check_db = shy_base::load_model('content_check_model');
		$todaytime = strtotime(date('y-m-d',SYS_TIME));
		$_username = $this->memberinfo['username'];
		$allowpostnum = $this->content_check_db->count("`inputtime` > $todaytime AND `username`='$_username'");
		if($grouplist[$memberinfo['groupid']]['allowpostnum'] > 0 && $allowpostnum >= $grouplist[$memberinfo['groupid']]['allowpostnum']) {
			showmessage(L('allowpostnum_deny').$grouplist[$memberinfo['groupid']]['allowpostnum'], HTTP_REFERER);
		}
		$siteids = getcache('category_content', 'commons');
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			
			$catid = intval($_POST['info']['catid']);
			//判断此类型用户是否有权限在此栏目下提交投稿
			if (!$priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?app=member'); 
			
			
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];
			$modelid = $category['modelid'];
			if(!$modelid) showmessage(L('illegal_parameters'), HTTP_REFERER);
			$this->content_db = shy_base::load_model('content_model');
			$this->content_db->set_model($modelid);
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields();
			$this->content_db->table_name = $table_name.'_data';
			
			$fields_attr = $this->content_db->get_fields();
			$fields = array_merge($fields_sys,$fields_attr);
			$fields = array_keys($fields);
			$info = array();
			foreach($_POST['info'] as $_k=>$_v) {
				if($_k == 'content') {
					$info[$_k] = remove_xss(strip_tags($_v, '<p><a><br><img><ul><li><div>'));
				} elseif(in_array($_k, $fields)) {
					$info[$_k] = new_html_special_chars(trim_script($_v));
				}
			}
			$_POST['linkurl'] = str_replace(array('"','(',')',",",' ','%'),'',new_html_special_chars(strip_tags($_POST['linkurl'])));
			$post_fields = array_keys($_POST['info']);
			$post_fields = array_intersect_assoc($fields,$post_fields);
			$setting = string2array($category['setting']);
			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?app=pay&controller=deposit&view=pay&exchange=point',3000);
			
			//判断会员组投稿是否需要审核
			if($grouplist[$memberinfo['groupid']]['allowpostverify'] || !$setting['workflowid']) {
				$info['status'] = 99;
			} else {
				$info['status'] = 1;
			}
			$info['username'] = $memberinfo['username'];
			if(isset($info['title'])) $info['title'] = safe_replace($info['title']);
			$this->content_db->siteid = $siteid;
			
			$id = $this->content_db->add_content($info);
			//检查投稿奖励或扣除积分
			if ($info['status']==99) {
				$flag = $catid.'_'.$id;
				if($setting['presentpoint']>0) {
					shy_base::load_app_class('receipts','pay',0);
					receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
				} else {
					shy_base::load_app_class('spend','pay',0);
					spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
				}
			}
			//缓存结果
			$model_cache = getcache('model','commons');
			$infos = array();
			foreach ($model_cache as $modelid=>$model) {
				if($model['siteid']==$siteid) {
					$datas = array();
					$this->content_db->set_model($modelid);
					$datas = $this->content_db->select(array('username'=>$memberinfo['username'],'sysadd'=>0),'id,catid,title,url,username,sysadd,inputtime,status',100,'id DESC');
					if($datas) $infos = array_merge($infos,$datas);
				}
			}
			setcache('member_'.$memberinfo['userid'].'_'.$siteid, $infos,'content');
			//缓存结果 END
			if($info['status']==99) {
				showmessage(L('contributors_success'), APP_PATH.'baoliao/submit.html');
			} else {
				showmessage(L('contributors_checked'), APP_PATH.'baoliao/submit.html');
			}
			
		} else {		
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L('news','','content');
			$sitelist = getcache('sitelist','commons');
			if(!isset($_GET['siteid']) && count($sitelist)>1) {
				include template('member', 'content_publish_select_model');
				exit;
			}
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			$siteid = intval($_GET['siteid']);
			if(!$siteid) $siteid = 1;
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons'); 
			foreach ($CATEGORYS as $catid=>$cat) {
				if($cat['siteid']==$siteid && $cat['child']==0 && $cat['type']==0 && $priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) break;
			}
			$catid = $_GET['catid'] ? intval($_GET['catid']) : $catid;
			if (!$catid) showmessage(L('category').L('publish_deny'), PASSPORT_PATH.'member-login.html');

			//判断本栏目是否允许投稿
			if (!$priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?app=member');
			$category = $CATEGORYS[$catid];
			if($category['siteid']!=$siteid) showmessage(L('site_no_category'),'baoliao/submit.html');
			$setting = string2array($category['setting']);

			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?app=pay&controller=deposit&view=pay&exchange=point',3000);
			if($category['type']!=0) showmessage(L('illegal_operation'));
			$modelid = $category['modelid'];
			$model_arr = getcache('model', 'commons');
			$MODEL = $model_arr[$modelid];
			unset($model_arr);
	
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid, $catid, $CATEGORYS);
			$forminfos_data = $content_form->get();
			$forminfos = array();
 			foreach($forminfos_data as $_fk=>$_fv) {
				if($_fv['isomnipotent']) continue;
				if($_fv['formtype']=='omnipotent') {
					foreach($forminfos_data as $_fm=>$_fm_value) {
						if($_fm_value['isomnipotent']) {
							$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
						}
					}
				}
				$forminfos[$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			//去掉栏目id
			unset($forminfos['catid']);
			$workflowid = $setting['workflowid'];
			header("Cache-control: private");
			$template = $MODEL['member_add_template'] ? $MODEL['member_add_template'] : 'baoliao_publish';
			include template('member', $template);
		}
	}

}
?>

<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class EDI_index extends index{
    function __construct() {
        parent::__construct();
    }
	//列表页
	public function lists() {
		$catid = $_GET['catid'] = isset($_GET['catdir'])&&!empty($_GET['catdir'])? dir2catid($_GET['catdir']): intval($_GET['catid']);
		$_priv_data = $this->_category_priv($catid);
		if($_priv_data=='-1') {
			$forward = urlencode(get_url());
			showmessage(L('login_website'),PASSPORT_PATH.'index.php?app=member&controller=index&view=login&forward='.$forward);
		} elseif($_priv_data=='-2') {
			showmessage(L('no_priv'));
		}
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
        cache_page_start();
		if(!$catid) showmessage(L('category_not_exists'),'blank');
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'),'blank');
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$setting = string2array($setting);
		//SEO
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		define('STYLE',$setting['template_list']);
		$page = intval($_GET['page']);

		$template = $setting['category_template'] ? $setting['category_template'] : 'category';
		$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
		$this->page_db = shy_base::load_model('page_model');
		if($type==0) {
			if ($catid == 6) {
				# 院校列表
				$this->linkage_db = shy_base::load_model('linkage_model');
				$yx_type = $this->linkage_db->query("SELECT `linkageid`,`name` FROM `v9_linkage` WHERE `keyid` = 39 AND `parentid` = 0");
				$yx_type_list = $this->linkage_db->fetch_array($yx_type);

				// 查询所有院校
				$yx_list_arr = $this->page_db->query("SELECT `catid`,`catname`,`url`,`area_id` FROM `v9_category` WHERE `parentid` = 6");
				$yx_list = $this->page_db->fetch_array($yx_list_arr);
				
				$yuanxi_data = array();
				foreach ($yx_list as $key => $value) {
					foreach ($yx_type_list as $k => $v) {
						if ($value['area_id'] == $v['linkageid']) {
							$yuanxi_data[$v['name']]['value'][] = $value;
							$yuanxi_data[$v['name']]['linkageid'] = $v['linkageid'];
						}
						
					}
				}
				
			}
			$template = $child ? $template : $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			//获取一级栏目ids
			foreach ($self_array as $arr) {
				if($arr!=$catid && $CATEGORYS[$arr]['parentid']==$catid) {
					$array_child[] = $arr;
				}
			}
			$arrchildid = implode(',', $array_child);
			//URL规则
			$urlrules = getcache('urlrules_detail','commons');//change 去读urlrules_detail
			$urlrules = str_replace('|', '~',$urlrules[$category_ruleid]);
			$tmp_urls = explode('~',$urlrules['urlrule']);//change
			$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
			preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
			if(!empty($_urls[1])) {
				foreach($_urls[1] as $_v) {
					$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
				}
			}
			define('URLRULE',$urlrules['urlrule']);//change
			$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
			$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
			$GLOBALS['URL_ARRAY']['catid'] = $catid;
			#新增S
			$GLOBALS['URL_ARRAY']['url'] 			=$CAT['url'];
			$GLOBALS['URL_ARRAY']['realpath'] 		=$CAT['parentdir'].$CAT['catdir'];
			$GLOBALS['URL_ARRAY']['parentdir'] 		=$CAT['parentdir'];
			$GLOBALS['URL_ARRAY']['urlruleishtml'] 	=$urlrules['ishtml'];
			// var_dump($template);
			#新增E
			include template('content',$template);
		} else {
		//单网页
			
			if ($catid == 3640) {
				# 专业列表
				$this->linkage_db = shy_base::load_model('linkage_model');
				$zy_type = $this->linkage_db->query("SELECT `linkageid`,`name` FROM `v9_linkage` WHERE `keyid` = 510 AND `parentid` = 0");
				$zy_type_list = $this->linkage_db->fetch_array($zy_type);

				// 查询所有专业
				$zy_list_arr = $this->page_db->query("SELECT `catid`,`catname`,`url`,`major_id` FROM `v9_category` WHERE `parentid` = 3640");
				$zy_list = $this->page_db->fetch_array($zy_list_arr);

				$zhuanye_data = array();
				foreach ($zy_list as $key => $value) {
					foreach ($zy_type_list as $k => $v) {
						if ($value['major_id'] == $v['linkageid']) {
							$zhuanye_data[$v['name']]['value'][] = $value;
							$zhuanye_data[$v['name']]['linkageid'] = $v['linkageid'];
						}
						
					}
				}
				// var_dump($zhuanye_data);
			}
			$r = $this->page_db->get_one(array('catid'=>$catid));
			// echo "<pre>";
			// print_r($r);
			// exit;
			if($r) extract($r);
			$template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $setting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
			include template('content',$template);
		}
		// cache_page(180);
	}
 }

?>
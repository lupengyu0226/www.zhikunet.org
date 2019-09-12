<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
shy_base::load_app_func('util');
shy_base::load_app_func('global');
class index {
	private $db;
	function __construct() {
		$this->db = shy_base::load_model('content_model');
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');
		$this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
		param::set_cookie('siteid',$this->siteid);	
		$this->mobile_site = getcache('mobile_site','mobile');
		$this->mobile = $this->mobile_site[$this->siteid];
		define('MOBILE_SITEURL', $this->mobile['domain'] ? $this->mobile['domain'].'/' : APP_PATH.'index.php?app=mobile&siteid='.$this->siteid);
		if($this->mobile['status']!=1) mobilemsg(L('mobile_close_status'));
	}
	//首页
	public function init() {
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$MOBILE = $this->mobile;
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		//cache_page_start();
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('mobile_site','mobile');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		include template('mobile','index',$default_style);
		//cache_page(120);
	}
	//MIP首页
	public function mipinit() {
		//cache_page_start();
		$MOBILE = $this->mobile;
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('mobile_site','mobile');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		include template('mip','index',$default_style);
		//cache_page(120);
	}
	//内容页
	public function show() {
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$catid = $_GET['catid'] = isset($_GET['catdir'])&&!empty($_GET['catdir'])? dir2catid($_GET['catdir']): intval($_GET['catid']);
		$id = intval($_GET['id']);
        $stime =  intval($_GET['tid']);
		$MOBILE = $this->mobile;
		if(!$catid || !$id) mobilemsg(L('information_does_not_exist'),'blank');
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		$page = intval($_GET['page']);
		$page = max($page,1);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$forward = urlencode(get_url());
		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) mobilemsg(L('information_does_not_exist'),'blank');
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['mobilesetting'] = string2array($this->category['mobilesetting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		$etime = date('md', $r['inputtime']); 
		if(!$r || $r['status'] != 99){
			header('HTTP/1.1 404 Not Found');
			header('status: 404 Not Found');
			mobilemsg(L('info_does_not_exists'),'blank');
			exit();
		}	
		$this->db->table_name = $tablename.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		//最顶级栏目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		$template = $template ? $template : $CAT['mobilesetting']['show_template'];
		if(!$template) $template = 'show';
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		
		define('STYLE',$CAT['mobilesetting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = shy_base::load_app_class('contentpage', 'mobile');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = shy_base::load_app_class('urls', 'mobile');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->mobileshow($id, $i, $catid, $rs['inputtime']);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//当不存在 [/page]时，则使用下面分页
				$pages = content_pages($pagenumber,$page, $pageurls);
				//判断[page]出现的位置是否在第一位 
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
		$this->db->table_name = $tablename;
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99");

		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page').'\');');
		}

		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page').'\');');
		}
		//cache_page_start();
		$content = str_replace("src",'src="'.IMG_PATH.'grey.gif" data-original',$content);
		include template('mobile',$template);
		//cache_page(120);
	}

	//内容页
	public function mip() {
		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);
		$MOBILE = $this->mobile;
		if(!$catid || !$id) mobilemsg(L('information_does_not_exist'),'blank');
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;

		$page = intval($_GET['page']);
		$page = max($page,1);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$forward = urlencode(get_url());
		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) mobilemsg(L('information_does_not_exist'),'blank');
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['mobilesetting'] = string2array($this->category['mobilesetting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		//if(!$r || $r['status'] != 99) showmessage(L('info_does_not_exists'),'blank');
		if(!$r || $r['status'] != 99){
			header('HTTP/1.1 404 Not Found');
			header('status: 404 Not Found');
			mobilemsg(L('info_does_not_exists'),'blank');
			exit();
		}	
		$this->db->table_name = $tablename.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		//最顶级栏目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		$template = $template ? $template : $CAT['mobilesetting']['show_template'];
		if(!$template) $template = 'show';
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		
		define('STYLE',$CAT['mobilesetting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = shy_base::load_app_class('contentpage', 'mobile');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = shy_base::load_app_class('urls', 'mobile');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->mipmobileshow($id, $i, $catid, $rs['inputtime']);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//当不存在 [/page]时，则使用下面分页
				$pages = mip_pages($pagenumber,$page, $pageurls);
				//判断[page]出现的位置是否在第一位 
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
		$this->db->table_name = $tablename;
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99");

		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page').'\');');
		}

		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page').'\');');
		}
		if(!preg_match_all("/(src)=([\"|']?)([^ \"'>]+)\\2/is", $content, $showimg));
		foreach($showimg as $images) {
			$showimg = $images;
		}
		include template('mip',$template);
	}

	//列表页
	public function miplists() {
		$MOBILE = $this->mobile;
		$catid = $_GET['catid'] = intval($_GET['catid']);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		if(!$catid) mobilemsg(L('category_not_exists'),'blank');
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(!isset($CATEGORYS[$catid])){
			header('HTTP/1.1 404 Not Found');
			header('status: 404 Not Found');
			mobilemsg(L('category_not_exists'),'blank');
			exit();
		}	
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$mobilesetting = string2array($mobilesetting);
		//SEO
		if(!$mobilesetting['meta_title']) $mobilesetting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$mobilesetting['meta_title'],$mobilesetting['meta_description'],$mobilesetting['meta_keywords']);
		define('STYLE',$mobilesetting['template_list']);
		$page = intval($_GET['page']);

		$template = $mobilesetting['category_template'] ? $mobilesetting['category_template'] : 'category';
		$template_list = $mobilesetting['list_template'] ? $mobilesetting['list_template'] : 'list';
		
		if($type==0) {
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
			$urlrules = getcache('urlrules','commons');
			$urlrules = str_replace('|', '~',$urlrules[43]);
			$tmp_urls = explode('~',$urlrules);
			$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
			preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
			if(!empty($_urls[1])) {
				foreach($_urls[1] as $_v) {
					$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
				}
			}
			define('URLRULE', $urlrules);
			$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
			$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
			$GLOBALS['URL_ARRAY']['catid'] = $catid;
			include template('mip',$template);
		} else {
		//单网页
			$this->page_db = shy_base::load_model('page_model');
			$r = $this->page_db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			$template = $mobilesetting['page_template'] ? $mobilesetting['page_template'] : 'page';
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $mobilesetting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$mobilesetting['meta_description'],$keywords);
			include template('mip',$template);
		}
	}
	//列表页
	public function lists() {
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$MOBILE = $this->mobile;
		$catid = $_GET['catid'] = isset($_GET['catdir'])&&!empty($_GET['catdir'])? dir2catid($_GET['catdir']): intval($_GET['catid']);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//cache_page_start();
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(!isset($CATEGORYS[$catid])){
			header('HTTP/1.1 404 Not Found');
			header('status: 404 Not Found');
			mobilemsg(L('category_not_exists'),'blank');
			exit();
		}
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$mobilesetting = string2array($mobilesetting);
		
		//SEO
		if(!$mobilesetting['meta_title']) $mobilesetting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$mobilesetting['meta_title'],$mobilesetting['meta_description'],$mobilesetting['meta_keywords']);
		define('STYLE',$mobilesetting['template_list']);
		$page = intval($_GET['page']);

		$template = $mobilesetting['category_template'] ? $mobilesetting['category_template'] : 'category';
		$template_list = $mobilesetting['list_template'] ? $mobilesetting['list_template'] : 'list';
		
		if($type==0) {
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
			$urlrules = str_replace('|', '~',$urlrules[$mobilesetting['category_ruleid']]);
			$tmp_urls = explode('~',$urlrules['urlrule']);//change
			$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
			preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
			if(!empty($_urls[1])) {
				foreach($_urls[1] as $_v) {
					$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
				}
			}
			define('URLRULE',$urlrules['urlrule']);//change
			$_URL = shy_base::load_app_class('urls','mobile');
			$categorydir = $_URL->get_categorydir($catid);
			$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
			$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
			$GLOBALS['URL_ARRAY']['catid'] = $catid;
			#新增S
			$GLOBALS['URL_ARRAY']['url'] 			=$CAT['url'];
			$GLOBALS['URL_ARRAY']['realpath'] 		=$CAT['parentdir'].$CAT['catdir'];
			$GLOBALS['URL_ARRAY']['parentdir'] 		=$CAT['parentdir'];
			$GLOBALS['URL_ARRAY']['urlruleishtml'] 	=$urlrules['ishtml'];
			#新增E
			include template('mobile',$template);
			//cache_page(120);
		} else {
		//单网页
			$this->page_db = shy_base::load_model('page_model');
			$r = $this->page_db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			$template = $mobilesetting['page_template'] ? $mobilesetting['page_template'] : 'page';
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $mobilesetting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$mobilesetting['meta_description'],$keywords);
			include template('mobile',$template);
		}
	}
	//JSON 输出
	public function json_list() {
		if($_GET['type']=='keyword' && $_GET['modelid'] && $_GET['keywords']) {
		//根据关键字搜索
			$modelid = intval($_GET['modelid']);
			$id = intval($_GET['id']);

			$MODEL = getcache('model','commons');
			if(isset($MODEL[$modelid])) {
				$keywords = safe_replace(htmlspecialchars($_GET['keywords']));
				$keywords = addslashes(iconv('utf-8','gbk',$keywords));
				$this->db->set_model($modelid);
				$result = $this->db->select("keywords LIKE '%$keywords%'",'id,title,url',10);
				if(!empty($result)) {
					$data = array();
					foreach($result as $rs) {
						if($rs['id']==$id) continue;
						if(CHARSET=='gbk') {
							foreach($rs as $key=>$r) {
								$rs[$key] = iconv('gbk','utf-8',$r);
							}
						}
						$data[] = $rs;
					}
					if(count($data)==0) exit('0');
					echo json_encode($data);
				} else {
					//没有数据
					exit('0');
				}
			}
		}

	}

		//提交评论
	function comment() {
		if($_POST['dosumbit']) {
			$comment = shy_base::load_app_class('comment','comment');
			shy_base::load_app_func('global','comment');
			if(strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")) {
			$username = $this->mobile['sitename'].L('weixin_friends');
			}else{
			$username = $this->mobile['sitename'].L('shuyang_friends');
			}
			$userid = param::get_cookie('_userid');		
			$catid = intval($_POST['catid']);		
			$contentid = intval($_POST['id']);		
			$msg = trim($_POST['msg']);
			$commentid = remove_xss(safe_replace(trim($_POST['commentid'])));
			$title = $_POST['title'];
			$url = $_POST['url'];	
			
			//通过API接口调用数据的标题、URL地址
			if (!$data = get_comment_api($commentid)) {
				exit(L('parameter_error'));
			} else {
				$title = $data['title'];
				$url = $data['url'];
				unset($data);
			} 		
			$content = isset($_POST['msg']) && trim($_POST['msg']) ? trim($_POST['msg']) : $this->_show_msg(L('please_enter_content'), HTTP_REFERER);
			$data = array('userid'=>$userid, 'username'=>$username, 'content'=>$content);
			$comment->add($commentid, $this->siteid, $data, $id, $title, $url);
		$this->_show_msg($comment->get_error()."<iframe width='0' id='top_src' height='0' src='$domain/Apsaras.html?200'></iframe>", (in_array($comment->msg_code, array(0,7)) ? HTTP_REFERER : ''), (in_array($comment->msg_code, array(0,7)) ? 1 : 0));
		}
	}
	
	//评论列表页
	function comment_list() {
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$comment = shy_base::load_app_class('comment','comment');
		shy_base::load_app_func('global','comment');	
		$GLOBALS['siteid'] = max($this->siteid,1);
		$commentid = isset($_GET['commentid']) && trim(addslashes(urldecode($_GET['commentid']))) ? trim(addslashes(urldecode($_GET['commentid']))) : showmsg(L('illegal_parameters'));
		if(!preg_match("/^[a-z0-9_\-]+$/i",$commentid)) showmsg(L('illegal_parameters'));
		list($modules, $contentid, $siteid) = decode_commentid($commentid);	
		list($module, $catid) = explode('_', $modules);
		$comment_setting_db = shy_base::load_model('comment_setting_model');
		$setting = $comment_setting_db->get_one(array('siteid'=>$this->siteid));	
		
		//通过API接口调用数据的标题、URL地址
		if (!$data = get_comment_api($commentid)) {
			showmsg(L('illegal_parameters'));
		} else {
			$title = $data['title'];
			$url = $data['url'];
			unset($data);
		}
					
		include template('mobile', 'comment_list');
	}
    //获取更多内容,话题专用
	public function more() {
		$catid = intval($_POST['catid']);	
        $page = intval($_POST['page']);
        $page++;
		ob_start();
        include template('mobile', 'get_more');
        $html = ob_get_contents();
        ob_end_clean();
        echo json_encode(array('data'=>$html,'page'=>$page));
        exit();
	}
    //获取更多内容,新闻内容专用
	public function newsmore() {
		$catid = intval($_POST['catid']);	
        $page = intval($_POST['page']);
        $page++;
		ob_start();
        include template('mobile', 'get_newsmore');
        $html = ob_get_contents();
        ob_end_clean();
        echo json_encode(array('data'=>$html,'page'=>$page));
        exit();
	}
    //获取更多内容,电视新闻内容专用
	public function tvmore() {
		$catid = intval($_POST['catid']);	
        $page = intval($_POST['page']);
        $page++;
		ob_start();
        include template('mobile', 'get_tvmore');
        $html = ob_get_contents();
        ob_end_clean();
        echo json_encode(array('data'=>$html,'page'=>$page));
        exit();
	}

	//提示信息处理
	protected function _show_msg($msg, $url = '', $status = 0) {
		
		switch ($this->format) {
			case 'json':
				$msg = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('gbk', 'utf-8', $msg) : $msg;
				echo json_encode(array('msg'=>$msg, 'status'=>$status));
				exit;
			break;
			
			case 'jsonp':
				$msg = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('gbk', 'utf-8', $msg) : $msg;
				echo strip_tags($this->callback).'('.json_encode(array('msg'=>$msg, 'status'=>$status)).')';
				exit;
			break;
			
			default:
				showmsg($msg, $url);
			break;
		}
	}
}
?>

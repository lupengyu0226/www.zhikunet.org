<?php
defined('IN_SHUYANG') or exit('No permission resources.');
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
shy_base::load_app_func('util');
shy_base::load_app_func('global');
class hot {
	public function __construct(){
		$this->db = shy_base::load_model('hot_model');
		$this->db_content = shy_base::load_model('hot_content_model');
		$this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
		$this->mobile_site = getcache('mobile_site','mobile');
		$this->mobile = $this->mobile_site[$this->siteid];
		define('MOBILE_SITEURL', $this->mobile['domain'] ? $this->mobile['domain'].'/' : APP_PATH.'index.php?app=mobile&siteid='.$this->siteid);
	}
	public function init(){
		$MOBILE = $this->mobile;
		$tag = $_GET['tag'];
		$models = getcache('model', 'commons');
		$sitelist = getcache('sitelist', 'commons');
		$i=0;
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$SEO = seo($siteid);
		$siteid = intval($_GET['siteid']);
		$modelid = intval($_GET['modelid']);
		$orderby = intval($_GET['orderby']);
		foreach($models as $model_v){
			$model_arr .= 'model_arr['.$i++.'] = new Array("'.$model_v['modelid'].'","'.$model_v['name'].'","'.$model_v['siteid'].'");'."\n";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		if($tag){
			if($this->db->get_one(array('tag'=>$tag))){
				$sql_arr = array('tag'=>$tag);
				if($siteid){
					$sql_arr['siteid'] = $siteid;

				}
				if($modelid){
					$sql_arr['modelid'] = $modelid;
				}
				if($orderby){
					$sql_ord = 'updatetime asc';
				}else{
					$sql_ord = 'updatetime desc';
				}
				$urlrule = '/hot/'.urlencode($tag).'.html'.'~/hot/'.urlencode($tag).'-{$page}.html';
				$tagdata = $this->db_content->listinfo($sql_arr,$sql_ord, $page, 20, '', 5, $urlrule);
				$datas = $this->db->listinfo($sql_arr,$order = 'tagid DESC');
				$this->db->update(array('hits'=>'+=1'), array('tag'=>$tag));
				foreach($datas as $v){
					$v = $v;
				}
				$pages = $this->db_content->pages;
				$total = $this->db_content->number;
			}else{
				showmessage('标签不存在！');
			}
			$CATEGORYS = getcache('category_content_1','commons');
			include template('mobile', 'hot_hot',$default_style);
		}else{
			$urlrule = '/hot.html~/hot_{$page}.html';
			$tagdata = $this->db->listinfo('','usetimes desc', $page, 10, '', 5, $urlrule);
			$pages = $this->db->pages;
			$total = $this->db->number;
			include template('mobile', 'hot_index',$default_style);
		}
		
	}

}

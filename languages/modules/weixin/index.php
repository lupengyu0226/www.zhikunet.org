<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
shy_base::load_app_func('util','mobile');
shy_base::load_app_func('global','mobile');
class index {
	private $event;
	public function __construct() {
		$this->dbarticle = shy_base::load_model('weixin_article_model');
		$this->weixin_sent_group_news = shy_base::load_model('weixin_sent_group_news_model');
		shy_base::load_app_func('global','weixin');
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
	public function init(){
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$MOBILE = $this->mobile;
		if(!isset($_GET['id']) || empty($_GET['id'])){
			return false;
		}
		$id = intval($_GET['id']);
		$infos = $this->dbarticle->get_one(array('id'=>$id));
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
		include template('weixin','show');
	}
	public function groupnews(){
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$MOBILE = $this->mobile;
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
		if(!isset($_GET['id']) || empty($_GET['id'])){
			return false;
		}
		$id = intval($_GET['id']);
		$infos = $this->weixin_sent_group_news->get_one(array('id'=>$id));
		
		include template('weixin','groupnews');
	}
}
?>
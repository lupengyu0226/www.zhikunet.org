<?php
	defined('IN_SHUYANG') or exit('The resource access forbidden.');
	shy_base::load_sys_class('form','',0);
	shy_base::load_sys_class('format','',0);
	shy_base::load_sys_func('global');
	class index{
		private $db,$member_db,$siteid,$urlrules,$setting;
		function __construct() {
			$this->db =shy_base::load_model('zhuanlan_model');
			$this->member_db = shy_base::load_model('member_model');
			$this->urlrules = getcache('urlrules','commons');
			if(isset($_GET['siteid'])) {
				$this->siteid = intval($_GET['siteid']);
			} else {
				$this->siteid = 1;
			}
			$this->siteid = $GLOBALS['siteid'] = max($this->siteid,1);
			$this->setting=getcache('zhuanlan_setting','zhuanlan');
			if($this->setting[$this->siteid]['status']!=1) showmessage('zhuanlan_close_status');
		}
	public function init() {
		$seo_keywords = '沭阳专栏,沭阳网专栏';
		$title = '沭阳网专栏';
        $total_zhuanlan = $this->db->count();
		include template('zhuanlan', 'index');
	}
	public function test() {
		$seo_keywords = '沭阳专栏,沭阳网专栏';
		$title = '沭阳网专栏';
        $total_zhuanlan = $this->db->count();
		include template('zhuanlan', 'test');
	}
    //获取更多内容,新闻内容专用
	public function more() {
        $page = intval($_POST['page']);
        $page++;
		ob_start();
        include template('zhuanlan', 'get_more');
        $html = ob_get_contents();
        ob_end_clean();
        echo json_encode(array('data'=>$html,'page'=>$page));
        exit();
	}
	public function show() {
		$siteid=$this->siteid;
		$domain=safe_replace($_GET['domain']);
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$setting=$this->setting;
		$zhuanlan=getcache('zhuanlan','zhuanlan');
		$info =	$this->db->_getinfo(array('domain'=>$domain));
		if(!empty($info) && $info['status']==1){
			$page = intval($_GET['page']);
			$page = max($page,1);
			$info=array_merge($info,$zhuanlan[$info['username']]);
			$cuserid = get_memberinfo_buyusername($info['username'],'userid');
			extract($info);
			$urlrules =$this->urlrules[$setting[$siteid]['show_urlruleid']];
			define('URLRULE',str_replace('|','~',$urlrules));
			$SEO = seo($siteid);
			$GLOBALS['URL_ARRAY']['domain'] 		=$info['domain'];
			$GLOBALS['URL_ARRAY']['username'] 		=$info['username'];
			$GLOBALS['URL_ARRAY']['page'] 			=$page;		
			include template('zhuanlan','show');
		}else{
			showmessage(L('zhuanlan_close_status'), HTTP_REFERER);
		}
	}
}
?>
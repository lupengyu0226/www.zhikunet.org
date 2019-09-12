<?php
defined('IN_SHUYANG') or exit('No permission resources.');

class rank {
	private $db;
	function __construct() {
		$this->db = shy_base::load_model('content_model');
		//shy_base::load_app_class('rssbuilder','','','0');
		$this->siteid = $_GET['siteid'] ? intval($_GET['siteid']) : '1';
		$this->rssid = intval($_GET['rssid']);
		define('SITEID', $this->siteid);
	}

	public function init() {
		$siteurl = siteurl(SITEID);
			//$catid = $_GET['catid'] ? intval($_GET['catid']) : '0';

			//$catid = $_GET['catid'] ? intval($_GET['catid']) : '0';
				
			$order = $_GET['order'] ? $_GET['order'] : 'views';
			
			if(!in_array($order,array('yesterdayviews','dayviews','weekviews','monthviews','views'))) return false;		
			
			cache_page_start();
			//$siteids = getcache('category_content','commons');
			$siteid = $_GET['siteid'] ? intval($_GET['siteid']) : '1';
			$CATEGORYS = getcache('category_content_'.$siteid,'commons');
			$catdir = $_GET['catdir'] ? $_GET['catdir'] : '';
			if(!$catdir){
				$catid=0;
			}else{
				foreach($CATEGORYS as $cat){
					if($cat['catdir']==$catdir&&$cat["parentid"]==0){
						$catid=$cat['catid'];break;
						}
					}
				
				}			
			
			//print_r($catid);
			$subcats = subcat($catid,0,1,$siteid);
			
			$SEO = seo($siteid,$catid);
			foreach ($CATEGORYS as $r) if($r['parentid'] == 0) $channel[] = $r;
			
			include template('content','rank');
			cache_page(14400);
				
	}
}
?>

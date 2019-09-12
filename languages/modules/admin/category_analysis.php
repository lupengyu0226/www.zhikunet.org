<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class category_analysis extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('category_model');
		$this->m_db = shy_base::load_model('sitemodel_model');
		$this->siteid = $this->get_siteid();
	}
	/**
	 * 管理栏目
	 */
	public function init () {

		include $this->admin_tpl('category_analysis');
	}
	/**
	 * 数据模型的柱状图
	 */
	public function public_load_model_stat() {
		$categorys = getcache('category_content_'.$this->siteid,'commons');
		$datas = $this->m_db->listinfo(array('siteid'=>$this->siteid,'type'=>0,'disabled'=>0),'',1,30);
		//模型文章数array('模型id'=>数量);
		$items = array();
		foreach ($datas as $k=>$r) {
			foreach ($categorys as $catid=>$cat) {
				if(intval($cat['modelid']) == intval($r['modelid'])) {
					$items[$r['modelid']] += intval($cat['items']);
				} else {
					$items[$r['modelid']] += 0;
				}
			}
			$datas[$k]['items'] = $items[$r['modelid']];
		}
		$pie_title = iconv(CHARSET,'utf-8','模型数据量分析');
		foreach($datas as $r) {
			//$pie_chart->addSlice("model-$n", iconv(CHARSET,'utf-8',$r['name']), $r['items']);
			$name[] = iconv(CHARSET,'utf-8',$r['name']);
			$items;
		}
		$name = implode("','", $name);
		$items = implode(',', $items);		
		include $this->admin_tpl('main_bingtu');
	}
	/**
	 * 三十天数据波动图
	 */
	public function public_load_cat_stat() {
		$range = intval($_GET['range']) ? intval($_GET['range']) : 0;
		$eday= $_GET['st'] ? $_GET['st'] : date('Y-m-d',SYS_TIME);
		$sday  = date('Y-m-d',strtotime("$eday -$range day"));
		$localupload = iconv(CHARSET,'utf-8','智库网30天数据波动图');
		for($i=1;$i<=$range;$i++) {;
			$day = date('Y-m-d',strtotime("$sday +$i day"));
			$days[$i] =  date('m/d',strtotime("$sday +$i day"));
			$localnum[$i] = $this->_stat_cat_items($day);
		}
		$days = implode('","', $days);
		$localnum = implode(',', $localnum);
		include $this->admin_tpl('main_tubiao');	
	}
	/**
	 * 后台首页数据波动图
	 */
	public function public_load_cat_stat_main() {
		$range = intval($_GET['range']) ? intval($_GET['range']) : 0;
		$eday= $_GET['st'] ? $_GET['st'] : date('Y-m-d',SYS_TIME);
		$sday  = date('Y-m-d',strtotime("$eday -$range day"));
		$localupload = iconv(CHARSET,'utf-8','智库网十天数据波动图');
		for($i=1;$i<=$range;$i++) {;
			$day = date('Y-m-d',strtotime("$sday +$i day"));
			$days[$i] =  date('m/d',strtotime("$sday +$i day"));
			$localnum[$i] = $this->_stat_cat_items($day);
		}
		$days = implode('","', $days);
		$localnum = implode(',', $localnum);
		include $this->admin_tpl('main_tubiao');
	}

	private function _stat_cat_items($datetime) {
		$content_db = shy_base::load_model('content_model');
		$categorys = getcache('category_content_'.$this->siteid,'commons');
		
		$datas = $this->m_db->listinfo(array('siteid'=>$this->siteid,'type'=>0,'disabled'=>0),'',$_GET['page'],30);
		foreach($datas as $n=>$r) {
			$content_db->set_model($r['modelid']);
			$s = strtotime($datetime.' 00:00:00');
			$e = strtotime($datetime.' 23:59:59');
			$num[] = $content_db->count("`inputtime`>='$s' && `inputtime`<='$e'");
		}
		return array_sum($num) ? array_sum($num) : 0;
	}
}
?>

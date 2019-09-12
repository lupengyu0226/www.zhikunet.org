<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	private $db;
	function __construct() {
	}
	//首页
	public function init() {
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		//SEO
		$SEO = seo($siteid);
		include template('weather','index',$default_style);
	}
	//aqi
	public function cityaqi() {
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		//SEO
		$SEO = seo($siteid);
		include template('weather','cityaqi',$default_style);
	}
	//一周天气
	public function yztqcx() {
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		//SEO
		$SEO = seo($siteid);
		include template('weather','yztqcx',$default_style);
	}
	//一周天气
	public function mobile() {
		$url = 'https://www.05273.cn/caches/weather.json';
		$str = https_curl($url);
		$arr = json_decode($str,true);
		//SEO
		$SEO = seo($siteid);
		include template('weather','mobile',$default_style);
	}
}
?>
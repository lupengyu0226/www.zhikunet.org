<?php
defined('IN_SHUYANG') or exit('No permission resources.');
/*function spider_keywords($data) {
	$http = shy_base::load_sys_class('http');
	if(CHARSET == 'utf-8') {
		$data = iconv('utf-8', 'gbk', $data);
	}
	$http->post('http://tool.phpcms.cn/api/get_keywords.php', array('siteurl'=>APP_PATH, 'charset'=>CHARSET, 'data'=>$data, 'number'=>5));
	if($http->is_ok()) {
		if(CHARSET != 'utf-8') {
			return $http->get_data();
		} else {
			return iconv('gbk', 'utf-8', $http->get_data());
		}
	} else {
		return $data;
	}
}*/


function spider_keywords($data){
	$segment = shy_base::load_sys_class('segment');
	$fulltext_data = $segment->get_keyword($segment->split_result($data));
	return $fulltext_data;
}
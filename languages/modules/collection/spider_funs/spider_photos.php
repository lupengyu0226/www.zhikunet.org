<?php
defined('IN_SHUYANG') or exit('No permission resources.');
function spider_photos($str) {
	$field = $GLOBALS['field'];
	$_POST[$field.'_url'] = array();
	preg_match_all('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $str, $out);
	$array = array();
	if (isset($out[1]))foreach ($out[1] as $v) {
		$_POST[$field.'_url'][] = $v;
	}
	return '1';
}

function spider_images($str) {
	$field = $GLOBALS['field'];
	$array = array();
	if(empty($str)) return $array;
	$array[$field.'_url'] = array();
	//preg_match_all('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $str, $out);
	
	//preg_match_all('/(http:|https:|rtsp:).*?(\.jpg|\.jepg|\.png|\.bmp|\.gif)/i', $str, $out);

	preg_match_all('/(?:(http:|https:|rtsp:))((?!thumb)\S)*?(?:\.jpg|\.jpeg|\.png|\.bmp|\.gif)/i', $str, $out);//不含有thumb的url
	if (isset($out[0]))foreach ($out[0] as $v) {
		$array[$field.'_url'][] = $v;
	}
	return $array;
}
function spider_downurls($str) {
	$field = $GLOBALS['field'];
	$_POST[$field.'_fileurl'] = array();
	preg_match_all('/<a[^>]*href=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $str, $out);
	$array = array();
	if (isset($out[1]))foreach ($out[1] as $v) {
		$_POST[$field.'_fileurl'][] = $v;
	}
	return '1';
}

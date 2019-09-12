<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
$str = $_GET['pinyinstr'];
if(!$str) exit(0);
shy_base::load_sys_func('iconv');
$str = utf8_to_gbk($str);
$pinyin = gbk_to_pinyin($str);
if(is_array($pinyin)) {
      $pinyin = implode('', $pinyin);
      exit($pinyin);
      }
	 else{
	 exit('0');
	 }
?>

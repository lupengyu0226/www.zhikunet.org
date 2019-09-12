<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name' => 'search_word_count', 'parentid' => 29, 'm' => 'custom_search', 'c' => 'search_word_list', 'a' => 'init', 'data' => '', 'listorder' => 0, 'display' => '1'), true);
$language = array('search_word_count' => '搜索感知');


?>
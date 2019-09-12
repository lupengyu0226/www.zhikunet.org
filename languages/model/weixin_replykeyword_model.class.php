<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class weixin_replykeyword_model extends model {
	function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'weixin_replykeyword';
		parent::__construct();
	} 
	public function keyword_lists(){
		//'type'=>1表示关键词图文自动回复，2,3表示文本回复
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos =$this->listinfo('','',$page, $pages = '20');
		$pages = $this->pages;
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		$datas=array('infos'=>$infos,'pages'=>$pages,'picicos'=>$thumb);
		return $datas;
		
	}
}
?>
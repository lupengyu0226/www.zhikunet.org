<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class weixin_article_model extends model {
	function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->pre=$this->db_config['default']['tablepre'];
		$this->db_setting = 'default';
		$this->table_name = 'weixin_article';
		parent::__construct();
	} 
	//从缓存中获取表名
	public function get_tabname($catid=0){
		$model_arr = getcache('model','commons');
		$this->category_db = shy_base::load_model('category_model');
		$data = $this->category_db->get_one(array('catid'=>$catid));
		$modelid=$data['modelid'];
		if(is_array($model_arr) && $modelid>0){
		foreach($model_arr as $modelinfo){
			 if(in_array($modelid, $modelinfo)){
			  return $this->pre.$modelinfo['tablename'];
			 }
		}
	   }
	}
	public function get_artlists(){
		$tabname=$this->get_tabname($catid);
		$sql="select id,title,url,thumb,description,wxreplyid from ".$tabname." where wxreplyid=".$id."";
		$result=$this->query($sql);
        $infos=$this->fetch_array($result);
		return $infos;
	}
}
?>
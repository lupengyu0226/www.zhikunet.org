<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class model_model extends model {
	public $table_name = '';
	function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->pre=$this->db_config['default']['tablepre'];
		$this->db_setting = 'default';
		$this->table_name = 'model';
		$this->category_db = shy_base::load_model('category_model');
		parent::__construct();
	}
	function get_pre(){
		return $this->pre;
	}
	function get_modelid($catid=0){
		$data = $this->category_db->get_one(array('catid'=>$catid));
		return $data['modelid'];
	}
	function get_tabname($modelid=0){
		$data = $this->get_one(array('modelid'=>$modelid));
		return $data['tablename'];
	}
	
	
		//未选择的关键词图文列表
	/*
	replyid为关键词的ID，需要在系统的文章模型表中添加该字段
	replyid'=>0表示该图文未被选择或者已被取消
	*/
	function get_lists($catid,$replyid=0){
		
		$this->table_name = $this->get_model($catid);
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$lists=$this->listinfo(array('catid'=>$catid,'wxreplyid'=>$replyid),'id DESC',$page, $pagesize = '20');
		$pages = $this->pages;
		$datas=array('lists'=>$lists,'pages'=>$pages);
		return $datas;
	}
	//获取栏目列表
	function get_categorylists(){
		
		$datas = $this->category_db->select();				
		return $datas;
	}
	//获取某栏目下的数据列表
	function get_catlists($catid=0){
		
		$this->table_name = $this->get_model($catid);
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$lists=$this->listinfo(array('catid'=>$catid),'id DESC',$page, $pagesize = '20');
		$pages = $this->pages;
		$datas=array('lists'=>$lists,'pages'=>$pages);
		return $datas;
	}
	function get_numrs($catid=0,$num=3){
		
		$this->table_name = $this->get_model($catid);
		
		
		$lists=$this->select(array('catid'=>$catid),'`id`,`catid`,`title`,`description`,`thumb`,`url`',$num, 'id DESC');
		
		
		return $lists;
	}
	function soaech_cate_lists($catid=0,$sql=''){
		$this->table_name = $this->get_model($catid);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$lists=$this->listinfo($sql,'id DESC',$page, $pagesize = '20');
		$pages = $this->pages;
		$datas=array('lists'=>$lists,'pages'=>$pages);
		return $datas;
	}
	function get_single($catid,$id){
		$modelid = $this->get_modelid($catid);
		$modelid = $modelid?$modelid:0;
		$tabname =$this->get_tabname($modelid);
		$tabname = $tabname?$tabname:'';
		$tb = $this->get_pre().$tabname;
		$tb_data = $tb.'_data';
		$sql="select a.id,a.catid,b.id,a.title,a.url,a.thumb,a.description,b.content,b.copyfrom from ".$tb." a,".$tb_data." b where a.id=b.id and a.id=".$id." and b.id=".$id."";
		$result=$this->query($sql);
        $info=$this->fetch_array($result);
		return $info[0];
	}
	/*$array提交的文章ID数组，$replyid关键词ID*/
	public function update_art_wxreplyid($catid,$array,$replyid){
	    $this->table_name = $this->get_model($catid);
		if(is_array($array)){
				foreach($array as $id) {
 					$this->update(array('wxreplyid'=>$replyid),array('id'=>$id));
				}
				
		}
		
	}
	//获取模型，如news等
	public function get_model($catid){
		$modelid = $this->get_modelid($catid);
		$modelid = $modelid?$modelid:0;
		$tabname =$this->get_tabname($modelid);
		$tabname = $tabname?$tabname:'';
		$this->table_name = $this->get_pre().$tabname;
		return $this->table_name;
	}
}
?>
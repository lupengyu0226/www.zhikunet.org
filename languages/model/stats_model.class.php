<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.');
shy_base::load_sys_class('model','', 0);

class stats_model extends model {
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';//数据库连接池
		$this->table_name = 'stats';//数据表名称
		
		parent::__construct();
	}
	/**
	 * 重建stats稿件统计API
	 * @param $pagesize 每页条数
	 * @param $page 当前页
	 */
	
	public function stats_api(){
		$this->db->delete();
	}
	/**
	 * 说明: 添加统计信息
	 * @param $data 数组
	 * 参数示例 $data(array('aid'=>$id,'title'=>$title,'username'=>$username,'inputtime'=>SYS_TIME,$catid=>$catid,
	 * 'hitsid'=>$hitsid,
	 * 'url'=>$url))
	 */
	
	function _add($data){
		if(!$data) return false;
		if(!$data['title']) return false;
		$data=shy_addslashes($data);
		#print_r($data);exit;
		$ins=array();
		$ins['aid']=$data['aid'];
		$ins['siteid']=$data['siteid'];
		$ins['catid']=$data['catid'];
		$ins['image']=$data['image'];
		if(isset($data['username'])) $ins['username']=$data['username'];
		$ins['title']=$data['title'];
		if(isset($data['status'])){
			$ins['status']=$data['status'];
		}
		$ins['hitsid']=$data['hitsid'];
		list($module,$modelid,$docid)=explode('-',$data['hitsid']);
		$ins['modelid']=$modelid;
		$ins['data']=array2string($data['data']);
		$ins['inputtime']=$data['inputtime'];
		$ins['rurl']=$data['url'];
		$ins['url']=preg_replace('/'.str_replace('/', '\/', APP_PATH).'/i','',$data['url']);
		$r=$this->get_one(array('hitsid'=>$ins['hitsid'],'catid'=>$ins['catid'],'aid'=>$ins['aid'],'siteid'=>$ins['siteid']),'`id`');
		//var_dump($r);exit;
		if(empty($r)){
			return $this->insert($ins);
		}else{
			return $this->update($ins,array('hitsid'=>$ins['hitsid'],'catid'=>$ins['catid'],'aid'=>$ins['aid'],'siteid'=>$ins['siteid']));
		}
	}
	
	function _delete($data){
		if(empty($data)) return false;
		$del=array();
		$del['hitsid']=$data['hitsid'];
		$del['catid']=$data['catid'];
		$del['aid']=$data['aid'];
		$del['siteid']=$data['siteid'];
		return $this->delete($del);
	}
	
	function _getinfo($data){
		if(empty($data)) return false;
		return $this->get_one($data,'*');
	
	}
}
?>
<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.');
 shy_base::load_sys_class('model','', 0);

class zhuanlan_model extends model {
	public $db_setting,$table_name;
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'zhuanlan';//数据表名称
		parent::__construct();

	}
	/**
	 * 说明: 添加专栏
	 * @param $data 数组
	 */
	public function _add($data)
	{
		if(!$data) return FALSE;
		return $this->insert($data,true);
	}
	
	/**
	 * 说明: 删除专栏作者
	 * @param $id 数组
	 */
	public function _delete($username)
	{
		if(!$username) return FALSE;
		return $this->delete(array('username'=>$username));
	}
	
	/**
	 * 说明: 删除专栏作者
	 * @param $id 数组
	 */
	public function _edit($data,$username)
	{
		if(!$username) return FALSE;
		return $this->update($data,array('username'=>$username));
	}
	
	/**
	 * 说明: 获取作者信息
	 * @param $data('username'=>$username,'domain'=>$domain,$id=>$id) 数组
	 */
	public function _getinfo($data)
	{
		if(!$data) return FALSE;
		return $this->get_one($data);
	}
}

?>
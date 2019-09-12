<?php
class book_tag {
	public function __construct() {
		$this->db = shy_base::load_model('book_model');
		$this->db_reply = shy_base::load_model('book_reply_model');
	}
	/**
	 * 
	 * 留言列表
	 * @param $data 数组参数
	 */
	public function lists($data){
		$order = $data['order'] ? $data['order'] : 'ID desc';
		$sql = array('view_password'=>'');
		return $this->db->select($sql, '*', $data['limit'], $order);
	}
	/**
	 * 
	 * 热门留言
	 * @param $data 数组参数
	 */
	public function hot($data){
		$result = $this->db_reply->select('','*',$data['limit'],'count(*) desc','gid');
		foreach ($result as $k=>$v){
			$id = $v['gid'];
			$sql = array('id'=>$id,'view_password'=>'');
			$re = $this->db->get_one($sql);
			$result[$k] = $re;
		}
		return $result;
	}
	/**
	 * pc 标签调用
	 */
	public function shy_tag() {
		$sites = shy_base::load_app_class('sites','admin');
		$sitelist = $sites->shy_tag_list();
		return array(
			'action'=>array('lists'=>L('lists','','book'),'hot'=>L('hot','','book')),
			'lists'=>array(
							'order'=>array('name'=>L('listorder','','book'),'htmltype'=>'select','data'=>array('id desc'=>L('id desc','','book'), 'id asc'=>L('id asc','','book'))),
						),
		);
	}
}
?>

<?php 
/**
 *  member pc标签
 *
 * @copyright			(C) 2005-2010 SHUYANG
 * @license				http://www.05273.cn/license/
 * @lastmodify			2010-8-3
 */

defined('IN_SHUYANG') or exit('No permission resources.');

class member_tag {
	private $db, $favorite_db, $jubao_db;
	
	public function __construct() {
		$this->db = shy_base::load_model('member_model');
		$this->favorite_db = shy_base::load_model('favorite_model');
		$this->comment_data_db = shy_base::load_model('mycomment_model');
		$this->jubao_db = shy_base::load_model('jubao_model');
	}
	
	/**
	 * 获取收藏列表
	 * @param array $data 数据信息{userid:用户id;limit:读取数;order:排序字段}
	 * @return array 收藏列表数组
	 */
	public function favoritelist($data) {
		$userid = intval($data['userid']);
		$limit = $data['limit'];
		$order = $data['order'];
		$favoritelist = $this->favorite_db->select(array('userid'=>$userid), "*", $limit, $order);
		return $favoritelist;
	}
	/**
	 * 获取评论列表
	 * @param array $data 数据信息{userid:用户id;limit:读取数;order:排序字段}
	 * @return array 收藏列表数组
	 */
	public function commentlist($data) {
		$userid = intval($data['userid']);
		$limit = $data['limit'];
		$order = $data['order'];
		$commentlist = $this->comment_data_db->select(array('userid'=>$userid), "*", $limit, $order);
		return $commentlist;
	}
	/**
	 * 获取投诉建议
	 * @param array $data 数据信息{userid:用户id;limit:读取数;order:排序字段}
	 * @return array 收藏列表数组
	 */
	public function jubaolist($data) {
		$userid = intval($data['userid']);
		$limit = $data['limit'];
		$order = $data['order'];
		$jubaolist = $this->jubao_db->select(array('userid'=>$userid), "*", $limit, $order);
		return $jubaolist;
	}
	/**
	 * 读取收藏文章数
	 * @param array $data 数据信息{userid:用户id;limit:读取数;order:排序字段}
	 * @return int 收藏数
	 */
	public function count($data) {
		$userid = intval($data['userid']);
		return $this->favorite_db->count(array('userid'=>$userid));
	}
	
	public function shy_tag() {
		return array(
			'action'=>array('favoritelist'=>L('favorite_list', '', 'member')),
			'favoritelist'=>array(
				'userid'=>array('name'=>L('uid'),'htmltype'=>'input'),
			),
		);
	}
}
?>

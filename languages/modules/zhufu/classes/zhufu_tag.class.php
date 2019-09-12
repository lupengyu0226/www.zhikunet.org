<?php 
/**
 * 
 * 祝福的类
 *
 */

defined('IN_SHUYANG') or exit('No permission resources.');

class zhufu_tag {
	private $db;
	
	public function __construct() {
		$this->db = shy_base::load_model('zhufu_model');
	}
	
	/**
	 * 祝福列表方法
	 * @param array $data 传递过来的参数
	 * @param return array 数据库中取出的数据数组
	 */
	public function lists($data) {
		$where = '1';
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		if ($siteid) $where .= " AND `siteid`='".$siteid."'";
		$where .= ' AND `passed`=\'0\'';
		return $this->db->select($where, '*', $data['limit'], 'edi_id DESC');
	}
	
	public function count() {
		
	}
	
	/**
	 * pc标签初始方法
	 */
	public function shy_tag() {
		//获取站点
		$sites = shy_base::load_app_class('sites','admin');
		$sitelist = $sites->shy_tag_list();
		$result = getcache('special', 'commons');
		if(is_array($result)) {
			$specials = array(L('please_select', '', 'zhufu'));
			foreach($result as $r) {
				if($r['siteid']!=get_siteid()) continue;
				$specials[$r['id']] = $r['title'];
			}
		}
		return array(
			'action'=>array('lists'=>L('lists', '', 'zhufu')),
			'lists'=>array(
				'siteid'=>array('name'=>L('sitename', '', 'zhufu'),'htmltype'=>'input_select', 'defaultvalue'=>get_siteid(), 'data'=>$sitelist),
			),
		);
	}
}
?>

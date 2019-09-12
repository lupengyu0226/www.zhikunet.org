<?php 
/**
 * 
 * 公告类
 *
 */

defined('IN_SHUYANG') or exit('No permission resources.');

class announce_tag {
	private $db;
	
	public function __construct() {
		$this->db = shy_base::load_model('announce_model');
	}
	
	/**
	 * 公告列表方法
	 * @param array $data 传递过来的参数
	 * @param return array 数据库中取出的数据数组
	 */
	public function lists($data) {
		$where = '1';
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		if ($siteid) $where .= " AND `siteid`='".$siteid."'";
		$where .= ' AND `passed`=\'1\' AND (`endtime` >= \''.date('Y-m-d').'\' or `endtime`=\'0000-00-00\')';
		return $this->db->select($where, '*', $data['limit'], 'aid DESC');
	}
	/**
	 * 公告列表方法
	 * @param array $data 传递过来的参数
	 * @param return array 数据库中取出的数据数组
	 */
	public function memberlists($data) {
		$where = '1';
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		if ($siteid) $where .= " AND `siteid`='".$siteid."'";
		$where .= ' AND `mpass`=\'1\' AND (`endtime` >= \''.date('Y-m-d').'\' or `endtime`=\'0000-00-00\')';
		return $this->db->select($where, '*', $data['limit'], 'aid DESC');
		var_dump($where);
	}
	public function count($data) {
		if(isset($data['where'])) {
			$sql = $data['where'];
		} else {
				$siteid = intval($data['siteid']);
				$endtime = $data['endtime']?$data['endtime'] : '0000-00-00';
				$passed = $data['passed']?$data['passed'] : 1;//状态:是否审核
				if (empty($siteid)){
					$siteid = get_siteid();
				}
				switch ($passed) {
					case 'all'://不限
						$sql = array('siteid'=>$siteid); 
						break; 
					default://默认按选择项
						$sql = array('siteid'=>$siteid,'passed'=>$passed,'endtime'=>$endtime);
				}
		 		return $this->db->count($sql); 
		}		 		
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
			$specials = array(L('please_select', '', 'announce'));
			foreach($result as $r) {
				if($r['siteid']!=get_siteid()) continue;
				$specials[$r['id']] = $r['title'];
			}
		}
		return array(
			'action'=>array('lists'=>L('lists', '', 'announce')),
			'lists'=>array(
				'siteid'=>array('name'=>L('sitename', '', 'announce'),'htmltype'=>'input_select', 'defaultvalue'=>get_siteid(), 'data'=>$sitelist),
			),
		);
	}
}
?>

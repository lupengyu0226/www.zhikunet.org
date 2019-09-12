<?php
class license_tag {
	private $db;
	public function __construct() {
		$this->db = shy_base::load_model('license_notice_model');
	}
	/**
	 * 列表页标签
	 * @param $data
	 */
	public function lists($data) {
		if(isset($data['where'])) {
			$sql = $data['where'];
		} else {
			$thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
			if($this->category[$catid]['child']) {
				$catids_str = $this->category[$catid]['arrchildid'];
				$pos = strpos($catids_str,',')+1;
				$catids_str = substr($catids_str, $pos);
				$sql = "tui=1 AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')".$thumb;
			} else {
				$sql = "tui=1 AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')".$thumb;
			}
		}
		$return = $this->db->select($sql, '*', $data['limit'], $order, '', 'aid');				
		return $return;
	}

}

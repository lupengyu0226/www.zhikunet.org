<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class tansuo {
	function __construct() {
		$this->db = shy_base::load_model('user_search_word_model');
	}
	
	/**
	 * 关键词录入
	 */
	public function init() {
		$data = array();
		$search_word = !empty($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$search_word = safe_replace($search_word);
		$search_word = new_html_special_chars(strip_tags($search_word));
		$data['search_word'] = $search_word;
		$data['search_from'] = !empty($_GET['search_from']) ? safe_replace(trim($_GET['search_from'])) : '';
		$time = time();
		if(!empty($data['search_word']) && !empty($data['search_from'])){
			$search_word = $this->db->get_one($data,'id,search_times');
			if($search_word){
				$this->db->update( array('search_times'=>$search_word['search_times']+1, 'last_search_time'=>$time) ,array('id'=>$search_word['id']) );
			}else{
				$data['last_search_time'] = $time;
				$this->db->insert($data);
			}
		}
	}
}
?>
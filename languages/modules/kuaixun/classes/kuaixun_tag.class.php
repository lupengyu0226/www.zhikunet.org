<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class kuaixun_tag {
 	private $kuaixun_db,$type_db;
	
	public function __construct() {
		$this->kuaixun_db = shy_base::load_model('kuaixun_model');
		$this->type_db = shy_base::load_model('type_model');
 	}
	
 	/**
 	 * 取出该分类的详细 信息
  	 * @param $typeid 分类ID 
 	 */
 	  
 	public function get_type($data){
 		$typeid = intval($data['typeid']);
 		if($typeid=='0'){
 			$arr = array();
 			$arr['name'] = '默认分类';
 			return $arr;
 		}else {
		$r = $this->type_db->get_one(array('typeid'=>$typeid));
  		return new_html_special_chars($r);	
 		}
 		
		
 	}
 	
	/**
	 * 快讯列表
	 * @param  $data 
	 */
	public function lists($data) {
		$typeid = intval($data['typeid']);//分类ID
 		$kuaixuntype = $data['kuaixuntype']? $data['kuaixuntype'] : 0;
		$siteid = $data['siteid'];
		if (empty($siteid)){ 
			$siteid = get_siteid();
		}
  		if($typeid!='' || $typeid=='0'){
 				$sql = array('typeid'=>$typeid,'kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
			}else {
				$sql = array('kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
		}
  		$r = $this->kuaixun_db->select($sql, '*', $data['limit'], 'listorder '.$data['order']);
		return new_html_special_chars($r);
	}
	
	/**
	 * 返回该分类下的友情链接 ...
	 * @param  $data 传入数组参数
	 */
	public function type_list($data) {
 		$siteid = $data['siteid'];
		$kuaixuntype = $data['kuaixuntype']? $data['kuaixuntype'] : 0;
		$typeid = $data['typeid'];
 		if (empty($siteid)){
			$siteid = get_siteid();
		}
 		if($typeid){
				if(is_int($typeid)) return false;
				$sql = array('typeid'=>$typeid,'kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
			}else {
				$sql = array('kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
		}
		$r = $this->kuaixun_db->select($sql, '*', $data['limit'], $data['order']);
		return new_html_special_chars($r);
	}
	
	/**
	 * 首页  友情链接分类 循环 .
	 * @param  $data
	 */
	public function type_lists($data) {
			if (!in_array($data['listorder'], array('desc', 'asc'))) {
					$data ['listorder'] = 'desc';
				}
 			$sql = array('module'=>ROUTE_M,'siteid'=>$data['siteid']);
 			$r = $this->type_db->select($sql, '*', $data['limit'], 'listorder '.$data['listorder']);
			return new_html_special_chars($r);
	}
	 
	/**
	 * 
	 * 传入的站点ID,读取站点下的友情链接分类 ...
	 * @param $siteid 选择的站点ID 
	 */ 
	public function get_typelist($siteid='1', $value = '', $id = '') {
   			$data = $arr = array();
			$data = $this->type_db->select(array('module'=>'kuaixun', 'siteid'=>$siteid));
			shy_base::load_sys_class('form', '', 0);
			foreach($data as $r) {
				$arr[$r['typeid']] = $r['name'];
			}
			$html = $id ? ' id="typeid" onchange="$(\'#'.$id.'\').val(this.value);"' : 'name="typeid", id="typeid"';
  			return form::select($arr, $value, $html, L('please_select')); 
	}
	
	public function count($data) {
		if($data['action'] == 'lists') {
 			$typeid = intval($data['typeid']);//分类ID
			$kuaixuntype = $data['kuaixuntype']? $data['kuaixuntype'] : 0;
			$siteid = $data['siteid'];
			if (empty($siteid)){ 
				$siteid = get_siteid();
			}
			if($typeid!='' || $typeid=='0'){
					$sql = array('typeid'=>$typeid,'kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
				}else {
					$sql = array('kuaixuntype'=>$kuaixuntype,'siteid'=>$siteid,'passed'=>'1');
			}
 			return $this->kuaixun_db->count($sql); 
		}
	}

	
	/**
	 * pc 标签调用
	 */
	public function shy_tag() {
		$sites = shy_base::load_app_class('sites','admin');
		$sitelist = $sites->shy_tag_list();
		return array(
			'action'=>array('type_list'=>L('kuaixun_list', '', 'kuaixun')),
			'type_list'=>array(
				'siteid'=>array('name'=>L('site_id','','comment'),'htmltype'=>'input_select', 'data'=>$sitelist, 'ajax'=>array('name'=>L('for_type','','special'), 'action'=>'get_typelist', 'id'=>'typeid')),
				'kuaixuntype'=>array('name'=>L('kuaixun_type','','kuaixun'), 'htmltype'=>'select', 'data'=>array('0'=>L('word_kuaixun','','kuaixun'), '1'=>L('logo_kuaixun','','kuaixun'))),
				'order'=>array('name'=>L('sort', '', 'comment'), 'htmltype'=>'select','data'=>array('listorder DESC'=>L('listorder_desc', '', 'content'),'listorder ASC'=>L('listorder_asc', '', 'content'))),
			),				
		 
		);
	}

}

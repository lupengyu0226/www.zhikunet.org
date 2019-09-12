<?php
/**
 * special_tag.class.php 专题标签调用类
 * @author 
 *
 */
class today_tag {
	private $db, $c;
	
	public function __construct() {
		$this->db = shy_base::load_model('shuyangtoday_model');
	}
	
	/**
	 * lists调用方法
	 * @param array $data 标签配置传递过来的配置数组，根据配置生成sql
	 */
	public function lists($data) {
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		$where .= "`siteid`='".$siteid."'";
		if ($data['elite']) $where .= " AND `elite`='1'";
		if ($data['thumb']) $where .= " AND `thumb`!=''"; 
		if ($data['disable']) {
			$where .= " AND `disabled`='".$data['disable']."'";
		}else{
			$where .= " AND `disabled`='0'";//默认显示，正常显示的专题。
		}
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC, `id` DESC', '`listorder` DESC, `id` DESC');
		return $this->db->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
	}
	/**
	 * 内容列表调用方法
	 * @param array $data 标签配置数组
	 */
	public function content_list($data) {
		$where = '1';
		if ($data['specialid']) $where .= " AND `specialid`='".$data['specialid']."'";
		if ($data['typeid']) $where .= " AND `typeid`='".$data['typeid']."'";
		if ($data['thumb']) $where .= " AND `thumb`!=''";
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC', '`listorder` DESC');
		$result = $this->c->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
		if (is_array($result)) {
			foreach($result as $k => $r) {
				if ($r['curl']) {
					$content_arr = explode('|', $r['curl']);
					$r['url'] = go($content_arr['1'], $content_arr['0']);
				}
				$res[$k] = $r;
			}
		} else {
			$res = array();
		}
		return $res;
	}
	
	/**
	 * 标签生成方法
	 */
	public function shy_tag() {
		//获取站点
		$sites = shy_base::load_app_class('sites','admin');
		$sitelist = $sites->shy_tag_list();
		
		$result = getcache('shuyangtoday', 'commons');
		if(is_array($result)) {
			$todays = array(L('please_select'));
			foreach($result as $r) {
				if($r['siteid']!=get_siteid()) continue;
				$shuyangtodays[$r['id']] = $r['title'];
			}
		}
		return array(
			'action'=>array('lists'=>L('shuyangtoday_list', '', 'today'), 'content_list'=>L('content_list', '', 'today'), 'hits'=>L('hits_order','','today')),
			'lists'=>array(
				'siteid'=>array('name'=>L('site_id','','comment'), 'htmltype'=>'input_select', 'data'=>$sitelist),
				'elite'=>array('name'=>L('iselite', '', 'today'), 'htmltype'=>'radio', 'defaultvalue'=>'0', 'data'=>array(L('no'), L('yes'))),
				'thumb'=>array('name'=>L('get_thumb', '', 'today'), 'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'today'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'today'), L('id_desc', '','today'), L('order_asc','','today'), L('order_desc', '','today'))),
			),
			'content_list'=>array(
				'id'=>array('name'=>L('id','','today'),'htmltype'=>'input_select', 'data'=>$todays, 'ajax'=>array('name'=>L('for_type','','today'), 'action'=>'get_type', 'id'=>'typeid')),
				'thumb'=>array('name'=>L('content_thumb','','today'),'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'today'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'today'), L('id_desc', '','today'), L('order_asc','','today'), L('order_desc', '','today'))),
			),
			'hits' => array(
				'id' => array('name'=>L('id','','today'), 'htmltype'=>'input_select', 'data'=>$todays),
				'listorder' => array('name' => L('order_type', '', 'today'), 'htmltype' => 'select', 'data'=>array(L('total','','today'), L('yesterday', '','today'), L('today','','today'), L('week','','today'), L('month','','today'))),
			),
		);
	}
}
?>

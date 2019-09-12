<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	private $setting, $catid, $contentid, $siteid, $lichang_id;
	public function __construct() {
		$this->setting = getcache('lichang_program', 'commons');
		
		
		$this->lichang_id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!preg_match("/^[a-z0-9_\-]+$/i",$this->lichang_id)) showmessage((L('illegal_parameters')));
		if (empty($this->lichang_id)) {
			showmessage(L('id_cannot_be_empty'));
		}
		list($this->catid, $this->contentid, $this->siteid) = id_decode($this->lichang_id);
		
		$this->setting = isset($this->setting[$this->siteid]) ? $this->setting[$this->siteid] : array();
		
		foreach ($this->setting as $k=>$v) {
			if (empty($v['use'])) unset($this->setting[$k]);
		}
		
		define('SITEID', $this->siteid);
	}
	
	//显示心情
	public function init() {
		$lichang_id =& $this->lichang_id;
		$setting =& $this->setting;
		$lichang_db = shy_base::load_model('lichang_model');
		$data = $lichang_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid));
		foreach ($setting as $k=>$v) {
			$setting[$k]['fields'] = 'n'.$k;
			if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
			if (isset($data['total']) && !empty($data['total'])) {
				$setting[$k]['per'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 60);
			} else {
				$setting[$k]['per'] = 0;
			}
		}
		ob_start();
		include template('lichang', 'index');
		$html = ob_get_contents();
		ob_clean();
		echo format_js($html);
	}
	
	//提交选中
	public function post() {
		if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
		$lichang_id =& $this->lichang_id;
		$setting =& $this->setting;
		$cookies = param::get_cookie('lichang_id');
		$cookie = explode(',', $cookies);
		if (in_array($this->lichang_id, $cookie)) {
			$this->_show_result(0, L('expressed'));
		} else {
			$lichang_db = shy_base::load_model('lichang_model');
			$key = isset($_GET['k']) && intval($_GET['k']) ? intval($_GET['k']) : '';
			$fields = 'n'.$key;
			if ($data = $lichang_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid))) {
				$lichang_db->update(array('total'=>'+=1', $fields=>'+=1', 'lastupdate'=>SYS_TIME), array('id'=>$data['id']));
				$data['total']++;
				$data[$fields]++;
			} else {
				$lichang_db->insert(array('total'=>'1', $fields=>'1', 'catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid,'
				lastupdate'=>SYS_TIME));
				$data['total'] = 1;
				$data[$fields] = 1;
			}
			param::set_cookie('lichang_id', $cookies.','.$lichang_id);
			foreach ($setting as $k=>$v) {
				$setting[$k]['fields'] = 'n'.$k;
				if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
				if (isset($data['total']) && !empty($data['total'])) {
					$setting[$k]['per'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 60);
				} else {
					$setting[$k]['per'] = 0;
				}
			}
			ob_start();
			include template('lichang', 'index');
			$html = ob_get_contents();
			ob_clean();
			$this->_show_result(1,$html);
		}
	}
	
	//显示AJAX结果
	protected function _show_result($status = 0, $msg = '') {
		if(CHARSET != 'utf-8') {
			$msg = iconv(CHARSET, 'utf-8', $msg);
		}
		exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>$status, 'data'=>$msg)).')');
	}
}

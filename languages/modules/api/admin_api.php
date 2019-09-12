<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class admin_api extends admin {

	private $db; public $username;
	public function __construct() {
		parent::__construct();
		$this->config = SHY_PATH.'modules'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR;
		$this->filepath = SHY_PATH.'modules'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR;
		if (file_exists($this->config.'config.php')) {
			$this->style_info = include $this->config.'config.php';
		}
	}
	
	public function init() {
		$filepath = $this->filepath.$dir;
		$list = glob($filepath.DIRECTORY_SEPARATOR.'*');
		$file_explan = $this->style_info['file_explan'];
		$local = str_replace(array(SHY_PATH, DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), $this->config);
		if (substr($local, -1, 1) == '.') {
			$local = substr($local, 0, (strlen($local)-1));
		}
		$encode_local = str_replace(array('/', '\\'), '|', $local);
		$big_menu = array('javascript:;', L('API列表'));
		include $this->admin_tpl('list');
	}
	public function update() {
		$file_explan = isset($_POST['file_explan']) ? $_POST['file_explan'] : '';
		if (!isset($this->style_info['file_explan'])) $this->style_info['file_explan'] = array();
		$this->style_info['file_explan'] = array_merge($this->style_info['file_explan'], $file_explan);
		@file_put_contents($this->config.'config.php', '<?php return '.var_export($this->style_info, true).';?>');
		showmessage(L('operation_success'), HTTP_REFERER);
	}
}
?>

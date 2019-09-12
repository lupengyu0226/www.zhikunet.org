<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_func('dir');
class ssihtml {
	private $siteid,$url,$html_root;
	public function __construct() {
		define('HTML',true);
		self::set_siteid();
		$this->html_root = shy_base::load_config('system','html_root');
		$this->sitelist = getcache('sitelist','commons');
	}
	/**
	 * SSI碎片
	 */
	public function ssi($posid=11,$name='') {
		if($name==''){$name=$posid;}
		$file = SHUYANG_PATH.'/caches/posid/'.$name.'.html';
		
		$style = $this->sitelist[$siteid]['default_style'];
		ob_start();
		include template('ssi','ssi_'.$posid,$style);
		return $this->createhtml($file, 1);
	}	

	/**
	* 写入文件
	* @param $file 文件路径
	* @param $copyjs 是否复制js，跨站调用评论时，需要该js
	*/
	private function createhtml($file, $copyjs = '') {
		$data = ob_get_contents();
		ob_clean();
		$dir = dirname($file);
		if(!is_dir($dir)) {
			mkdir($dir, 0777,1);
		}
		if ($copyjs && !file_exists($dir.'/Apsaras.html')) {
			@copy(SHY_PATH.'modules/content/templates/Apsaras.html', $dir.'/Apsaras.html');
		}
		$strlen = file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) {
			$file = str_replace(SHUYANG_PATH,'',$file);
			showmessage(L('file').'：'.$file.'<br>'.L('not_writable'));
		}
		return $strlen;
	}

	/**
	 * 设置当前站点id
	 */
	private function set_siteid() {
		if(defined('IN_ADMIN')) {
			$this->siteid = $GLOBALS['siteid'] = get_siteid();
		} else {
			if (param::get_cookie('siteid')) {
				$this->siteid = $GLOBALS['siteid'] = param::get_cookie('siteid');
			} else {
				$this->siteid = $GLOBALS['siteid'] = 1;
			}
		}
	}

}

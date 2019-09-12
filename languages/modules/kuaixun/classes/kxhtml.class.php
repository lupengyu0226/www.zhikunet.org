<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_func('util','content');
shy_base::load_sys_func('dir');
class kxhtml {
	private $siteid,$url,$html_root,$queue,$categorys;
	public function __construct() {
		$this->queue = shy_base::load_model('queue_model');
		define('HTML',true);
		self::set_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->url = shy_base::load_app_class('url', 'content');
		$this->html_root = shy_base::load_config('system','html_root');
		$this->sitelist = getcache('sitelist','commons');
	}
	/**
	 * 更新快讯
	 */
	 public function  kuaixun_js() {
		if($this->siteid==1) {
			$file = SHUYANG_PATH.'caches/kuaixun.js';
			//添加到发布点队列
			$this->queue->add_queue('edit','/caches/kuaixun.js',$this->siteid);
		} else {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			$file = $this->html_root.'/'.$site_dir.'/caches/kuaixun.js';
			//添加到发布点队列
			$this->queue->add_queue('edit',$file,$this->siteid);
			$file = SHUYANG_PATH.$file;
		}
		define('SITEID', $this->siteid);
		//SEO
		$SEO = seo($this->siteid);
		$siteid = $this->siteid;
		$CATEGORYS = $this->categorys;
		$style = $this->sitelist[$siteid]['default_style'];
		ob_start();
		include template('kuaixun','index',$style);
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
}
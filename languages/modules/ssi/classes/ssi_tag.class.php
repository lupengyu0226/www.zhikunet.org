<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
class ssi_tag {
	
	private $db;
	
	public function __construct() {
		$this->db = shy_base::load_model('ssi_model');

	}
	
	/**
	 * PC标签中调用数据
	 * @param array $data 配置数据
	 */
	public function shy_tag($data) {
		$siteid = isset($data['siteid']) && intval($data['siteid']) ? intval($data['siteid']) : get_siteid();
		$r = $this->db->select(array('pos'=>$data['pos'], 'siteid'=>$siteid));
		$str = '';
		if (!empty($r) && is_array($r)) foreach ($r as $v) {
			if (defined('IN_ADMIN') && !defined('HTML')) $str .= '<div id="block_id_'.$v['id'].'" class="admin_block" blockid="'.$v['id'].'">';
			if ($v['type'] == '2') {
				extract($v, EXTR_OVERWRITE);
				$data = string2array($data);
				if (!defined('HTML'))  {
					ob_start();
					include $this->template_url($id);
					$str .= ob_get_contents();
					ob_clean();
				} else {
					include $this->template_url($id);
				}
				
			} else {
				$str .= $v['data'];
			}
			if (defined('IN_ADMIN')  && !defined('HTML')) $str .= '</div>';
		}
		return $str;
	}
	
	/**
	 * 生成模板返回路径
	 * @param integer $id 碎片ID号
	 * @param string $template 风格
	 */
	public function template_url($id, $template = '') {
		$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.'block'.DIRECTORY_SEPARATOR.$id.'.php';
		$dir = dirname($filepath);
		if ($template) {
			if(!is_dir($dir)) {
				mkdir($dir, 0777, true);
		    }
		    $tpl = shy_base::load_sys_class('template_cache');
			$str = $tpl->template_parse(new_stripslashes($template));
			@file_put_contents($filepath, $str);
		} else {
			if (!file_exists($filepath)) {
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true);
			    }
			    $tpl = shy_base::load_sys_class('template_cache');
				$str = $this->db->get_one(array('id'=>$id), 'template');
				$str = $tpl->template_parse($str['template']);
				@file_put_contents($filepath, $str);
			}
		}
		return $filepath;
	}
	
	/**
	* 写入文件
	* @param $file 文件路径
	* @param $copyjs 是否复制js，跨站调用评论时，需要该js
	*/
	public function createhtml($file, $data = '') {
		
		$dir = dirname($file);
		if(!is_dir($dir)) {
			mkdir($dir, 0777,1);
		}

		$strlen = shy_base::load_config('system','lock_ex') ? file_put_contents($file, $data, LOCK_EX) : file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) {
			$file = str_replace(SHUYANG_PATH,'',$file);
			return '0';
		}
		return '1';
	}
}
?>

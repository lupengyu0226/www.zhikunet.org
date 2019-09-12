<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class plugin extends admin {
	private $db,$db_var;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('plugin_model');
		$this->db_var = shy_base::load_model('plugin_var_model');
		shy_base::load_app_func('global');
	}
	
	/**
	 * 应用配置信息
	 */
	public function init() {
		$show_validator = true;
		$show_dialog = true;
		if($pluginfo = $this->db->select('','*','','disable DESC,listorder DESC')) {
			foreach ($pluginfo as $_k=>$_r) {
				if(file_exists(SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$_r['dir'].DIRECTORY_SEPARATOR.$_r['dir'].'.class.php')){
					$pluginfo[$_k]['url'] = 'plugin.php?id='.$_r['dir'];
				} else {
					$pluginfo[$_k]['url'] = '';
				}
  			 	$pluginfo[$_k]['dir'] = $_r['dir'].'/';	
			}		
		}
		
		include $this->admin_tpl('plugin_list');
	}
	
	/**
	 * 应用导入\安装
	 */
	 
	public function import() {
		if(!isset($_GET['dir'])) {
			$plugnum = 1;
			$installsdir = array();
			if($installs_pluginfo = $this->db->select()) {
				foreach ($installs_pluginfo as $_r) {
	  			 	$installsdir[] = $_r['dir'];	
				}		
			}	
			$pluginsdir = dir(SHY_PATH.'plugin');
			while (false !== ($entry = $pluginsdir->read())) {
				$config_file = '';
				$plugin_data = array();
				if(!in_array($entry, array('.', '..')) && is_dir(SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$entry) && !in_array($entry, $installsdir) && !$this->db->get_one(array('identification'=>$entry))) {
					$config_file = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$entry.DIRECTORY_SEPARATOR.'plugin_'.$entry.'.cfg.php';
					if(file_exists($config_file)) {
						$plugin_data = @require($config_file);					
		  			 	$pluginfo[$plugnum]['name'] = $plugin_data['plugin']['name'];
		  			 	$pluginfo[$plugnum]['version'] = $plugin_data['plugin']['version'];
		  			 	$pluginfo[$plugnum]['copyright'] = $plugin_data['plugin']['copyright'];
		  			 	$pluginfo[$plugnum]['dir'] = $entry;
		  			 	$plugnum++;
					}
				}
			}		
			include $this->admin_tpl('plugin_list_import');
		} else {
			$dir = trim($_GET['dir']);
			$license = 0;
			$config_file = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';
			if(file_exists($config_file)) {
				$plugin_data = @require($config_file);
				$license = ($plugin_data['license'] == '' || !isset($plugin_data['license'])) ? 0 : 1;
			}
			if(empty($_GET['license']) && $license) {
				$submit_url = '?app=admin&controller=plugin&view=import&dir='.$dir.'&license=1&safe_edi='. $_SESSION['safe_edi'].'&menuid='.$_GET['menuid'];
			} else {
				$submit_url = '?app=admin&controller=plugin&view=install&dir='.$dir.'&safe_edi='. $_SESSION['safe_edi'].'&menuid='.$_GET['menuid'];
			}	
				$show_header = 0;
			include $this->admin_tpl('plugin_import_confirm');
		}
	}
	/**
	 * 应用删除程序
	 */
	public function delete() {
		if(isset($_POST['dosubmit'])) {
			$pluginid = intval($_POST['pluginid']);
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			$op_status = FALSE;	
			$dir = $plugin_data['dir'];
			$config_file = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';	
			if(file_exists($config_file)) {
				$plugin_data = @require($config_file);
			}		
			$filename = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$plugin_data['plugin']['uninstallfile'];
			if(file_exists($filename)) {
				@include_once $filename;
			} else {
				showmessage(L('plugin_lacks_uninstall_file','','plugin'),HTTP_REFERER);
			}
			if($op_status) {
				$this->db->delete(array('pluginid'=>$pluginid));
				$this->db_var->delete(array('pluginid'=>$pluginid));
				delcache($dir,'plugins');
				delcache($dir.'_var','plugins');
				$this->set_hook_cache();
				if($plugin_data['plugin']['iframe']) {
					shy_base::load_sys_func('dir');
					if(!dir_delete(SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir)) {
						showmessage(L('plugin_uninstall_success_no_delete','','plugin'),'?app=admin&controller=plugin');
					}
				}
				showmessage(L('plugin_uninstall_success','','plugin'),'?app=admin&controller=plugin');
			} else {
				showmessage(L('plugin_uninstall_fail','','plugin'),'?app=admin&controller=plugin');
			}	
		} else {
			$show_header = 0;
			$pluginid = intval($_GET['pluginid']);
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			include $this->admin_tpl('plugin_delete_confirm');			
		}

	}
	
	/**
	 * 应用安装
	 */	
	public function install() {
		$op_status = FALSE;
		$dir = trim($_GET['dir']);
		$config_file = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';		
		if(file_exists($config_file)) {
			$plugin_data = @require($config_file);
		} else {
			showmessage(L('plugin_config_not_exist','','plugin'));
		}
		if($plugin_data['version'] && $plugin_data['version']!=shy_base::load_config('version', 'shy_version')) {
			showmessage(L('plugin_incompatible','','plugin'));
		}
		
		if($plugin_data['dir'] == '' || $plugin_data['identification'] == '' || $plugin_data['identification']!=$plugin_data['dir']) {
			showmessage(L('plugin_lack_of_necessary_configuration_items','','plugin'));
		}
		
		if(is_array($plugin_data['plugin_var'])) {
			foreach($plugin_data['plugin_var'] as $config) {
				if(!pluginkey_check($config['fieldname'])) {
					showmessage(L('plugin_illegal_variable','','plugin'));
				}
			}
		}
		if($this->db->get_one(array('identification'=>$plugin_data['identification']))) {
			showmessage(L('plugin_duplication_name','','plugin'));
		};				
		$filename = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$plugin_data['plugin']['installfile'];
		
		if(file_exists($filename)) {
			@include_once $filename;
		} 
		
		if($op_status) {	
			//向插件表中插入数据
			
			$plugin = array('name'=>new_addslashes($plugin_data['plugin']['name']),'identification'=>$plugin_data['identification'],'appid'=>$plugin_data['appid'],'description'=>new_addslashes($plugin_data['plugin']['description']),'dir'=>$plugin_data['dir'],'copyright'=>new_addslashes($plugin_data['plugin']['copyright']),'setting'=>array2string($plugin_data['plugin']['setting']),'iframe'=>array2string($plugin_data['plugin']['iframe']),'version'=>$plugin_data['plugin']['version'],'disable'=>'0');
			
			$pluginid = $this->db->insert($plugin,TRUE);
			
			//向插件变量表中插入数据
			if(is_array($plugin_data['plugin_var'])) {
				foreach($plugin_data['plugin_var'] as $config) {
					$plugin_var = array();
					$plugin_var['pluginid'] = $pluginid;
					foreach($config as $_k => $_v) {
						if(!in_array($_k, array('title','description','fieldname','fieldtype','setting','listorder','value','formattribute'))) continue;
						if($_k == 'setting') $_v = array2string($_v);
						$plugin_var[$_k] = $_v;
					}
					$this->db_var->insert($plugin_var);				
				}
			}		
			setcache($plugin_data['identification'], $plugin,'plugins');
			$this->set_var_cache($pluginid);
			showmessage(L('plugin_install_success','','plugin'),'?app=admin&controller=plugin');
		} else {
			showmessage(L('plugin_install_fail','','plugin'),'?app=admin&controller=plugin');
		}
	}	
	
	/**
	 * 应用升级
	 */		
	public function upgrade() {
		//TODO		
	}
	
	/**
	 * 应用排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $pluginid => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('pluginid'=>$pluginid));
			}
			$this->set_hook_cache();
			showmessage(L('operation_success'),'?app=admin&controller=plugin');
		} else {
			showmessage(L('operation_failure'),'?app=admin&controller=plugin');
		}
	}
	

	public function design() {
		
	    if(isset($_POST['dosubmit'])) {
			$data['identification'] = $_POST['info']['identification'];
			$data['realease'] = date('YMd',SYS_TIME);
			$data['dir'] = $_POST['info']['identification'];
			$data['appid'] = '';
			$data['plugin'] = array(
							'version' => '0.0.2',
							'name' => $_POST['info']['name'],
							'copyright' => $_POST['info']['copyright'],
							'description' => "",
							'installfile' => 'install.php',
							'uninstallfile' => 'uninstall.php',
						);

			
			$filepath = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$data['identification'].DIRECTORY_SEPARATOR.'plugin_'.$data['identification'].'.cfg.php';
			shy_base::load_sys_func('dir');
			dir_create(dirname($filepath));	
		    $data = "<?php\nreturn ".var_export($data, true).";\n?>";			
			if(shy_base::load_config('system', 'lock_ex')) {
				$file_size = file_put_contents($filepath, $data, LOCK_EX);
			} else {
				$file_size = file_put_contents($filepath, $data);
			}
			echo 'success';
		} else {
			include $this->admin_tpl('plugin_design');
		}
	}

	/**
	 * 配置应用.
	 */
	public function config() {
		if(isset($_POST['dosubmit'])) {
			$pluginid = intval($_POST['pluginid']);
			foreach ($_POST['info'] as $_k => $_v) {
				 $this->db_var->update(array('value'=>$_v),array('pluginid'=>$pluginid,'fieldname'=>$_k));
			}
			$this->set_var_cache($pluginid);
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$pluginid = intval($_GET['pluginid']);
			$plugin_menus = array();
			$info = $this->db->get_one(array('pluginid'=>$pluginid));
			extract($info);
			if(!isset($_GET['module'])) {	
				$plugin_menus[] =array('name'=>L('plugin_desc','','plugin'),'url'=>'','status'=>'1');
				if($disable){
					if($info_var = $this->db_var->select(array('pluginid'=>$pluginid),'*','','listorder ASC,id DESC')) {
						$plugin_menus[] =array('name'=>L('plugin_config','','plugin'),'url'=>'','status'=>'0');
						$form = $this->creatconfigform($info_var);
					}
					$meun_total = count($plugin_menus);;
					$setting = string2array($setting);
					if(is_array($setting)) {
						foreach($setting as $m) {
							$plugin_menus[] = array('name'=>$m['menu'],'extend'=>1,'url'=>$m['name']);
							$mods[] = $m['name'];
						}
					}
				}
				include $this->admin_tpl('plugin_setting');
			} else {
				define('PLUGIN_ID', $identification);
				$plugin_module = trim($_GET['module']);
				$plugin_admin_path = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'plugin_admin.class.php';
				if (file_exists($plugin_admin_path)) {
					include $plugin_admin_path;
					$plugin_admin = new plugin_admin($pluginid);
					call_user_func(array($plugin_admin, $plugin_module));
				}				
			}
		}
	}
	/**
	 * 开启/关闭插件
	 * Enter description here ...
	 */
	public function status() {
		$disable = intval($_GET['disable']);
		$pluginid = intval($_GET['pluginid']);
		$this->db->update(array('disable'=>$disable),array('pluginid'=>$pluginid));
		$this->set_cache($pluginid);
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	/**
	 * 设置字段缓存
	 * @param int $pluginid
	 */
	private function set_var_cache($pluginid) {
		if($info = $this->db_var->select(array('pluginid'=>$pluginid))) {
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			foreach ($info as $_value) {
				$plugin_vars[$_value['fieldname']] = $_value['value'];
			}
			setcache($plugin_data['identification'].'_var', $plugin_vars,'plugins');
		}
	}
	
	/**
	 * 设置缓存
	 * @param int $pluginid
	 */
	private function set_cache($pluginid) {
		if($info = $this->db->get_one(array('pluginid'=>$pluginid))) {		
			setcache($info['identification'], $info,'plugins');
		}
		$this->set_hook_cache();
	}

	/**
	 * 设置hook缓存
	 */
	function set_hook_cache() {
		if($info = $this->db->select(array('disable'=>1),'*','','listorder DESC')) {
			foreach($info as $i) {
				$id = $i['identification'];
				$hook_file = SHY_PATH.'plugin'.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.'hook.class.php';
				if(file_exists($hook_file)) {
					$hook[$i['appid']] = $i['identification'];
				}
			}			
		}
		setcache('hook',$hook,'plugins');
	}
	
	/**
	 * 创建配置表单
	 * @param array $data
	 */
	private function creatconfigform($data) {
		if(!is_array($data) || empty($data)) return false;
		foreach ($data as $r) {
			$form .= '<tr><th width="120">'.$r['title'].'</th><td class="y-bg">'.$this->creatfield($r).'</td></tr>';			
		}
		return $form;		
	}
	
	/**
	 * 创建配置表单字段
	 * @param array $data
	 */
	private function creatfield($data) {
		extract($data);
		$fielda_array = array('text','radio','checkbox','select','datetime','textarea');
		if(in_array($fieldtype, $fielda_array)) {
			if($fieldtype == 'text') {
				return '<input type="text" name="info['.$fieldname.']" id="'.$fieldname.'" value="'.$value.'" class="input-text" '.$formattribute.' > '.' '.$description;
			} elseif($fieldtype == 'checkbox') {
				return form::checkbox(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			} elseif($fieldtype == 'radio') {
				return form::radio(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			}  elseif($fieldtype == 'select') {
				return form::select(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			} elseif($fieldtype == 'datetime') {
				return form::date("info[$fieldname]",$value,$isdatetime,1).' '.$description;
			} elseif($fieldtype == 'textarea') {
				return '<textarea name="info['.$fieldname.']" id="'.$fieldname.'" '.$formattribute.'>'.$value.'</textarea>'.' '.$description;
			}
		}
	}
	/**
	 * 执行SQL
	 * @param string $sql 要执行的sql语句
	 */
 	private function _sql_execute($sql) {
	    $sqls = $this->_sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}	
	
	/**
	 * 分割SQL语句
	 * @param string $sql 要执行的sql语句
	 */	
 	private function _sql_split($sql) {
		$database = shy_base::load_config('database');
		$db_charset = $database['default']['charset'];
		if($this->db->version() > '4.1' && $db_charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$db_charset,$sql);
		}
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}
				
	private function copydir($dirfrom, $dirto, $cover='') {
	    //如果遇到同名文件无法复制，则直接退出
	    if(is_file($dirto)){
	        die(L('have_no_pri').$dirto);
	    }
	    //如果目录不存在，则建立之
	    if(!file_exists($dirto)){
	        mkdir($dirto);
	    }
	    
	    $handle = opendir($dirfrom); //打开当前目录
    
	    //循环读取文件
	    while(false !== ($file = readdir($handle))) {
	    	if($file != '.' && $file != '..'){ //排除"."和"."
		        //生成源文件名
			    $filefrom = $dirfrom.DIRECTORY_SEPARATOR.$file;
		     	//生成目标文件名
		        $fileto = $dirto.DIRECTORY_SEPARATOR.$file;
		        if(is_dir($filefrom)){ //如果是子目录，则进行递归操作
		            $this->copydir($filefrom, $fileto, $cover);
		        } else { //如果是文件，则直接用copy函数复制
		        	if(!empty($cover)) {
						if(!copy($filefrom, $fileto)) {
							$this->copyfailnum++;
						    echo L('copy').$filefrom.L('to').$fileto.L('failed')."<br />";
						}
		        	} else {
		        		if(fileext($fileto) == 'html' && file_exists($fileto)) {

		        		} else {
		        			if(!copy($filefrom, $fileto)) {
								$this->copyfailnum++;
							    echo L('copy').$filefrom.L('to').$fileto.L('failed')."<br />";
							}
		        		}
		        	}
		        }
	    	}
	    }
	}
	
	private function deletedir($dirname){
	    $result = false;
	    if(! is_dir($dirname)){
	        echo " $dirname is not a dir!";
	        exit(0);
	    }
	    $handle = opendir($dirname); //打开目录
	    while(($file = readdir($handle)) !== false) {
	        if($file != '.' && $file != '..'){ //排除"."和"."
	            $dir = $dirname.DIRECTORY_SEPARATOR.$file;
	            //$dir是目录时递归调用deletedir,是文件则直接删除
	            is_dir($dir) ? $this->deletedir($dir) : unlink($dir);
	        }
	    }
	    closedir($handle);
	    $result = rmdir($dirname) ? true : false;
	    return $result;
	}

}
?>

<?php
/*
缓存清理类
*/
defined('IN_SHUYANG') or exit('The resource access forbidden.');
class zhuanlan_cache{
	private $zhuanlan_db,$urlrules;
	
	public function __construct() {
		$this->zhuanlan_db 		   = shy_base::load_model('zhuanlan_model');
		$this->module_db           = shy_base::load_model('module_model');
		$this->urlrules = getcache('urlrules','commons');
		
	}
    /*
    缓存更新方法
    */
	public function _cache(){
			delcache('zhuanlan','zhuanlan');
			delcache('zhuanlan_setting','zhuanlan');
			$r = $this->module_db->get_one(array('module'=>'zhuanlan'));
			if(is_array($r)) {
				$siteid=get_siteid();
				$setting = string2array($r['setting']);
				setcache('zhuanlan_setting',$setting, 'zhuanlan');
			}
			if($this->zhuanlan_db->table_exists(str_replace($this->zhuanlan_db->db_tablepre, '', $this->zhuanlan_db->table_name))){
				$zhuanlan = $this->zhuanlan_db->select(array('status'=>1),'*');
				
				if(is_array($zhuanlan)){
					$array = array();
					foreach($zhuanlan as $k=>$r){
						$urlrules =$this->urlrules[$setting[$siteid]['show_urlruleid']];
						$urlrules_arr = explode('|',$urlrules);
						$url = str_replace(array('{$username}','{$id}'),array($r['username'],$r['id']),$urlrules_arr[0]);
						if($setting[$siteid]['status']){
							$r['url']=preg_match('/^(http(s)?:)?\/\//i',$setting[$siteid]['domain'])?$setting[$siteid]['domain'].$url :APP_PATH.$url;
							$r['url']=preg_replace('/([(http|https):\/\/]{0,})([^\/]*)([\/]{1,})/i', '$1$2/', $r['url'], -1);
						}
						$array[$r['username']]=$r;
					}
					setcache('zhuanlan',$array, 'zhuanlan');
					
				}

				return true;
			}
    }
}
?>
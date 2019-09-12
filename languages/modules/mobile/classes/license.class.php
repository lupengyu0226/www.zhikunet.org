<?php 
class license {
	var $modules;
	var $update_url;
	var $http;

	function __construct() {
		$this->update_url = 'https://www.05273.cn/index.php?app=license';
		$this->http = shy_base::load_sys_class('http','',1);
		$this->uuid = $this->check_uuid();
	}

	function check(){
		$url = $this->url('check');
        if(!$this->http->get($url)) return false;
		return $this->http->get_data();
	}

	function url($action = 'check') {
        $modules = '';
        $site = getcache('sitelist','commons');
        $sitename = $site['1']['name'];
		$siturl = $site['1']['domain'];
	    $siturl = str_replace('http://','',$siturl);
	    $siturl = str_replace('https://','',$siturl);
	    $siturl = str_replace('www.','',$siturl);
		$siturl = str_replace('/','',$siturl);
        foreach ($site as $list) $sitelist .= $list['domain'].',';
		$pars = array(
			'controller'=>$action,
			'domain'=>$siturl,
			);
		$data = http_build_query($pars);
		$verify = md5($this->uuid);		
		if($s = $this->module()) {
			$p = '&p='.$s;
		}
		return $this->update_url.'&'.$data.'&verify='.$verify.$p;
	}

	function notice() {
		return $this->url('notice');
	}

	function module($type = '') {
		$string = '';
		$db = shy_base::load_model('pay_payment_model');
		$result = $db->select('','pay_code');
		if(is_array($result) && count($result) > 0) {
			foreach($result as $v=>$r) {
				$string .= strtolower($r['pay_code']).'|';
			}
			return base64_encode($string);
		} else {
			return $string;
		}		
	}
	
	function check_uuid(){
		$site_db = shy_base::load_model('site_model');
		$info = $site_db->get_one(array('siteid'=>1),'uuid');
		if($info['uuid']) {
			return $info['uuid'];
		} else {;
			$uuid = $this->uuid($site_db);
			if($site_db->update(array('uuid'=>$uuid),array('siteid'=>1))) return $uuid;
		}
	}
	
	function uuid(&$db){
	   $r = $db->get_one('',"UUID() as uuid");
	   return $r['uuid'];
	}	
}
?>
<?php
defined('IN_SHUYANG') or exit('No permission resources.');
	class wxauth{
		private $app_id,$appsecret,$noncestr,$base_url,$xzh_url;
		public function __construct() {
	        $this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
			$this->mobile_site = getcache('mobile_site','mobile');
			$this->mobile = $this->mobile_site[$this->siteid];
			$MOBILE = $this->mobile;
			$WX_SETTING = string2array($MOBILE['setting']);
			$this->app_id=$WX_SETTING['wxappid'];   //公众号appid
			$this->appsecret=$WX_SETTING['wxappsecret'];//公众号appsecret
			$this->noncestr='';//公众号noncestr,可为空
			$this->base_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->app_id."&secret=".$this->appsecret;
			$this->xzh_url="https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=EO0OZLDFxUIWPOmLe1pgsSm9d9S5z8TL&client_secret=MiX5dwgfu0ERNDWKHQQLcLLKuE5zK1Qx";
			
		}
		//向https发送get请求方法
		function get_url($url){
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			$res=curl_exec($ch);
			curl_close($ch);
			// $arr=json_decode($res,true);
			return $res;
		}
        
	    function get_randstr($length = 16) {
		  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		  $str = "";
		  for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		  }
		  return $str;
		}
			  
		
		//读取缓存aceess_token
		function get_token(){
			//微信基本设置
			$setting = getcache('weixin_setting','commons');//微信access_token存放文件
			$token = getcache('weixin','commons');//微信配置文件
			$appid =$token[1]['appid'];
			$secret =$token[1]['appsecret'];
			if($setting['lasttime']<=SYS_TIME){
				$token_url=$this->get_url($this->base_url);
				$at_json = json_decode($token_url,true);
				$setting=array();
				$setting['access_token']=$at_json['access_token'];
			}
			$accesstoken=$setting['access_token'];
			return $accesstoken;
         }
		//读取缓存aceess_token
		function xzh_token(){
			//微信基本设置
			$setting = getcache('xzh_setting','commons');//微信access_token存放文件
			if($setting['lasttime']<=SYS_TIME){
				$token_url=$this->get_url($this->xzh_url);
				$at_json = json_decode($token_url,true);
				$setting=array();
				$setting['access_token']=$at_json['access_token'];
				$setting['lasttime']=SYS_TIME+7200;
				setcache('xzh_setting', $setting, 'commons');
				$setting=getcache('xzh_setting','commons');
			}
			$accesstoken=$setting['access_token'];
			return $accesstoken;
         }
		//得到ticket
		function get_ticket(){
			//微信基本设置
			$setting = getcache('weixin_setting','commons');//微信access_token存放文件
			$accesstoken = $this->get_token();
			if($setting['lasttime']<=SYS_TIME){
				$get_token_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accesstoken";
				$at_json =json_decode(file_get_contents($get_token_url),true);
				$setting=array();
				$setting['access_token']=$accesstoken;
				$setting['ticket']=$at_json['ticket'];
				$setting['lasttime']=SYS_TIME+7200;
				setcache('weixin_setting', $setting, 'commons');
				$setting=getcache('weixin_setting','commons');
			}
			$ticket=$setting['ticket'];
			return $ticket;
		}
		
		function get_sign() {
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$jsapi_ticket = $this->get_ticket();
			$xzh_ticket = $this->xzh_token();
			$timestamp = time();
			$nonceStr =$this->get_randstr();
			$string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		
			$signature = sha1($string);
		
			$signPackage = array(
			  "appId"     =>  $this->app_id,
			  "nonceStr"  => $nonceStr,
			  "timestamp" => $timestamp,
			  "url"       => $url,
			  "signature" => $signature,
			  "rawString" => $string
			);
			return $signPackage; 
	 }	 
}
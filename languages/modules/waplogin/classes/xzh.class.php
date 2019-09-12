<?php
class xzh{
	private $appid,$appkey,$callback,$access_token,$openid;
        public function __construct($appid, $appkey, $callback){
            $this->appid = $appid;
            $this->appkey = $appkey;
            $this->callback = $callback;
            $this->access_token= '';
            $this->openid = '';
        }
        public function redirect_to_login() {
            $redirect = "https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$this->appid&scope=snsapi_userinfo&redirect_uri=".rawurlencode($this->callback);
            header("Location:$redirect");
        }
        //获得登录的 openid
        public function get_openid($code){
            $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$this->appid&client_secret=$this->appkey&redirect_uri=".rawurlencode($this->callback);
            $content = https_curl($url);
            $at_json = json_decode($content,true);
            if ($at_json['access_token']) {
                $openid  = $at_json['openid'];
                $this->openid  = $at_json['openid'];
                $this->access_token=$at_json['access_token'];
            } else {
                $openid='';
            }
            return $openid;
        }
        /**
        * 返回用户信息
        * 
        */
        public function get_user_info(){
            $url = "https://openapi.baidu.com/rest/2.0/cambrian/sns/userinfo?access_token=$this->access_token&openid=$this->openid";
            $content=https_curl($url);
            $result = json_decode($content);
            return $result->nickname;
        }
}
?>
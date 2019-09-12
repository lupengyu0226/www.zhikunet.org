<?php
class wx{
	private $appid,$appkey,$callback,$access_token,$openid;
        public function __construct($appid, $appkey, $callback){
            $this->appid = $appid;
            $this->appkey = $appkey;
            $this->callback = $callback;
            $this->access_token= '';
            $this->openid = '';
        }
        public function redirect_to_login() {
            $redirect = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=".rawurlencode($this->callback)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            header("Location:$redirect");
        }
        //获得登录的 openid
        public function get_openid($code){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appkey&code=$code&grant_type=authorization_code";
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
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$this->access_token&openid=$this->openid&lang=zh_CN";
            $content=https_curl($url);
            $result = json_decode($content);
            return $result->nickname;
        }
}
?>
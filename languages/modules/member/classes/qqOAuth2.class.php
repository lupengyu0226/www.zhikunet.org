<?php

    class qqOAuth2{

        private $appid,$appkey,$callback,$access_token,$openid;

        public function __construct($appid, $appkey, $callback){
            $this->appid = $appid;
            $this->appkey = $appkey;
            $this->callback = $callback;
            $this->access_token= '';
            $this->openid = '';
        }

        public function redirect_to_login()
        {
            //璺宠浆鍒癚Q鐧诲綍椤电殑鎺ュ彛鍦板潃, 涓嶈镟存敼!!
            $redirect = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=$this->appid&scope=&redirect_uri=".rawurlencode($this->callback);
            header("Location:$redirect");
        }
        
        
        //銮峰缑鐧诲綍镄?openid
        public function get_openid($code){
            $url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=$this->appid&client_secret=$this->appkey&code=$code&redirect_uri=".rawurlencode($this->callback);
            $content = file_get_contents( $url);
            if (stristr($content,'access_token=')) {
                $params = explode('&',$content);
                $tokens = explode('=',$params[0]);
                $token  = $tokens[1];
                $this->access_token=$token;
                if ($token) {
                     $url="https://graph.qq.com/oauth2.0/me?access_token=$token";
                     $content=file_get_contents($url);
                     $content=str_replace('callback( ','',$content);
                     $content=str_replace(' );','',$content);
                     $returns = json_decode($content);
                     $openid = $returns->openid;
                     $this->openid = $openid;
                     $_SESSION["token2"]  = $openid;
                } else {
                    $openid='';
                }
            } elseif (stristr($content,'error')) {
                $openid='';
            }
            return $openid;
        }
        
        /**
        * 杩斿洖鐢ㄦ埛淇℃伅
        * 
        */
        public function get_user_info(){
            $url = "https://graph.qq.com/user/get_user_info?access_token=$this->access_token&oauth_consumer_key=$this->appid&openid=$this->openid";
            $content=file_get_contents($url);
            $result = json_decode($content);
            return $result->nickname;
        }

    }
?>
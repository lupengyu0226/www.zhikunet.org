<?php

require_once(dirname(__FILE__) . '/Client.php');
/**
 * QQSNS 涓撶敤OAuth Client
 *
 * 锲?opensns.qq.com 镄凮Auth娌℃湁瀹屽叏阆靛惊OAuth1.0鍗忚
 * 锲?瀹樻柟镄凷DK GET鏂规硶涓嶆帴鍙楀弬鏁帮紝闅鹃亾瀹樻柟镓€链夌殑GET鎺ュ彛閮戒笉镓撶畻鎺ュ弹鍙傛暟浜嗭紵
 *
 * @ignore
 * @author icehu@vip.qq.com
 *
 */

class OpenSDK_OAuth_QQSNSClient extends OpenSDK_OAuth_Client
{
	/**
	 * 缁勮鍙傛暟绛惧悕骞惰姹傛帴鍙?
	 *
	 * @param string $url
	 * @param array $params
	 * @param string $method
	 * @param false|array $multi false:鏅€歱ost array: array ( '{fieldname}' =>array('type'=>'mine','name'=>'filename','data'=>'filedata') ) 鏂囦欢涓娄紶
	 * @return string
	 */
	public function request( $url, $method, $params, $multi = false )
	{
		$oauth_signature = $this->sign($url, $method, $params, $multi);
		$params[$this->oauth_signature_key] = $oauth_signature;
		return $this->http($url, $params, $method, $multi);
	}

	/**
	 * OAuth 鍗忚镄勭鍚?
	 *
	 * @param string $url
	 * @param string $method
	 * @param array $params
	 * @return string
	 */
	protected function sign( $url , $method, $params, $multi=NULL)
	{
		if($multi && is_array($multi))
		{
			//涓娄紶锲剧墖涓撶敤绛惧悕
			//锲?锲剧墖鍐呭闇€瑕佸仛绛惧悕锛屽苟涓斿浘鐗囦笂浼犳椂 銆?
			//锲?鏁翠釜sign_parts涓嶅仛urlencode 銆?
			foreach($multi as $field => $path)
			{
				$params[$field] = file_get_contents($path);
			}
			uksort($params, 'strcmp');
			$pairs = array();
			foreach($params as $key => $value)
			{
//				$key = self::urlencode_rfc1738($key);
//		        $pairs[] = $key . '=' . self::urlencode_rfc1738($value);
				//锲?qq opensns 绔熺劧涓岖紪镰?
				$pairs[] = $key . '=' . $value;
			}
			$sign_parts = implode('&', $pairs);
			$base_string = implode('&', array( strtoupper($method) , $url , $sign_parts ));
		}
		else
		{
			uksort($params, 'strcmp');
			$pairs = array();
			foreach($params as $key => $value)
			{
//				$key = self::urlencode_rfc1738($key);
//	            $pairs[] = $key . '=' . self::urlencode_rfc1738($value);
				//锲?qq opensns 绔熺劧涓岖紪镰?
				$pairs[] = $key . '=' . $value;
			}
			$sign_parts = self::urlencode_rfc1738(implode('&', $pairs));
			$base_string = implode('&', array( strtoupper($method) , self::urlencode_rfc1738($url) , $sign_parts ));
		}

		//锲?瀹樻柟涓嶅appkey_secret 鍜?token_secret缂栫爜
		//鏄惁缂栫爜閮芥棤镓€璋掳紝锲犱负appkey_secret 鍜?token_secret 閮芥病链夐渶瑕佺紪镰佺殑瀛楃銆?
		//浣嗘槸涓岖紪镰佷笉鍚堣锣冦€备负浜嗙鍚堣锣冭缮鏄紪镰佷竴涓嬨€?
        $key_parts = array(self::urlencode_rfc1738($this->_app_secret), self::urlencode_rfc1738($this->_token_secret));

        $key = implode('&', $key_parts);
        $sign = base64_encode(OpenSDK_Util::hash_hmac('sha1', $base_string, $key, true));
		if($this->_debug)
		{
			echo 'base_string: ' , $base_string , "\n";
			echo 'sign key: ', $key , "\n";
			echo 'sign: ' , $sign , "\n";
		}
		return $sign;
	}

	/**
	 * rfc1738 缂栫爜
	 * @param string $str
	 * @return string
	 */
	protected static function urlencode_rfc1738($str)
	{
		return rawurlencode($str);
	}

}

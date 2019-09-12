<?php
require_once(dirname(__FILE__) . '/Client.php');
/**
 * OAuth1.0 SDK Interface
 *
 * 鎻愪緵缁椤叿浣撴帴鍙ｅ瓙绫讳娇鐢ㄧ殑涓€浜涘叕鍏辨柟娉?
 *
 * @author icehu@vip.qq.com
 */

class OpenSDK_OAuth_Interface
{

	/**
	 * app key
	 * @var string
	 */
	protected static $_appkey = '';
	/**
	 * app secret
	 * @var string
	 */
	protected static $_appsecret = '';

	/**
	 * OAuth 鐗堟湰
	 * @var string
	 */
	protected static $version = '1.0';
	
	const RETURN_JSON = 'json';
	const RETURN_XML = 'xml';
	/**
	 * 鍒濆鍖?
	 * @param string $appkey
	 * @param string $appsecret
	 */
	public static function init($appkey,$appsecret)
	{
		self::setAppkey($appkey, $appsecret);
	}
	/**
	 * 璁剧疆APP Key 鍜?APP Secret
	 * @param string $appkey
	 * @param string $appsecret
	 */
	protected static function setAppkey($appkey,$appsecret)
	{
		self::$_appkey = $appkey;
		self::$_appsecret = $appsecret;
	}

	protected static $timestampFunc = null;

	/**
	 * 銮峰缑链満镞堕棿鎴崇殑鏂规硶
	 * 濡傛灉链嶅姟鍣ㄦ椂阍熷瓨鍦ㄨ宸紝鍦ㄨ繖閲岃皟鏁?
	 * 
	 * @return number
	 */
	public static function getTimestamp()
	{
		if(null !== self::$timestampFunc && is_callable(self::$timestampFunc))
		{
			return call_user_func(self::$timestampFunc);
		}
		return time();
	}

	/**
	 * 璁剧疆銮峰彇镞堕棿鎴崇殑鏂规硶
	 *
	 * @param function $func
	 */
	public static function timestamp_set_save_handler( $func )
	{
		self::$timestampFunc = $func;
	}

	protected static $getParamFunc = null;

	public static function getParam( $key )
	{
		if(null !== self::$getParamFunc && is_callable(self::$getParamFunc))
		{
			return call_user_func(self::$getParamFunc, $key);
		}
		return $_SESSION[ $key ];
	}

	/**
	 *
	 * 璁剧疆Session鏁版嵁镄勫瓨鍙栨柟娉?
	 * 绫讳技浜巗ession_set_save_handler鏉ラ吨鍐橲ession镄勫瓨鍙栨柟娉?
	 * 褰扑綘镄则oken瀛桦偍鍒拌窡鐢ㄦ埛鐩稿叧镄勬暟鎹簱涓椂闱炲父链夌敤
	 * $get鏂规硶 鎺ュ弹1涓弬鏁?$key
	 * $set鏂规硶 鎺ュ弹2涓弬鏁?$key $val
	 *
	 * @param function $get
	 * @param function $set
	 */
	public static function param_set_save_handler( $get, $set)
	{
		self::$getParamFunc = $get;
		self::$setParamFunc = $set;
	}

	protected static $setParamFunc = null;

	public static function setParam( $key , $val=null)
	{
		if(null !== self::$setParamFunc && is_callable(self::$setParamFunc))
		{
			return call_user_func(self::$setParamFunc, $key, $val);
		}
		if( null === $val)
		{
			unset($_SESSION[$key]);
			return ;
		}
		$_SESSION[ $key ] = $val;
	}

}

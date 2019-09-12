<?php
require_once(dirname(__FILE__) . '/Interface.php');
require_once(dirname(__FILE__) . '/QQSNSClient.php');
/**
 * Tencent OpenSNS SDK
 *
 * 渚濊禆锛?
 * 1銆丳ECL json >= 1.2.0	no need now
 * 2銆丳HP >= 5.2.0 because json_decode no need now
 * 3銆?_SESSION
 * 4銆丳ECL hash >= 1.1 no need now
 *
 * only need PHP >= 5.0
 *
 * 濡备綍浣跨敤锛?
 * 1銆佸皢OpenSDK鏂囦欢澶规斁鍏nclude_path
 * 2銆乺equire_once 'OpenSDK/Tencent/SNS.php';
 * 3銆丱penSDK_Tencent_SNS::init($appkey,$appsecret);
 * 4銆丱penSDK_Tencent_SNS::getRequestToken(); 銮峰缑request token
 * 5銆丱penSDK_Tencent_SNS::getAuthorizeURL($token,$callback); 銮峰缑璺宠浆鎺堟潈URL
 * 6銆丱penSDK_Tencent_SNS::getAccessToken($oauth_verifier) 銮峰缑access token
 * 7銆丱penSDK_Tencent_SNS::call();璋幂敤API鎺ュ彛
 *
 * 寤鸿锛?
 * 1銆丳HP5.2 浠ヤ笅鐗堟湰锛屽彲浠ヤ娇鐢≒ear搴扑腑镄?Service_JSON 鏉ュ寸瀹筳son_decode
 * 2銆佷娇鐢?session_set_save_handler 鏉ラ吨鍐橲ESSION銆傝皟鐢ˋPI鎺ュ彛鍓嶉渶瑕佷富锷╯ession_start
 * 3銆丱penSDK镄勬枃浠跺拰绫诲悕镄勫懡鍚嶈鍒欑鍚圥ear 鍜?Zend 瑙勫垯
 *    濡傛灉浣犵殑浠ｇ爜涔熺鍚堣繖镙风殑镙囧嗳 鍙互鏂逛究镄勫姞鍏ュ埌__autoload瑙勫垯涓?
 *
 * @author icehu@vip.qq.com
 */

class OpenSDK_Tencent_SNS extends OpenSDK_OAuth_Interface
{

	private static $accessTokenURL = 'http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token';

	private static $authorizeURL = 'http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize';

	private static $requestTokenURL = 'http://openapi.qzone.qq.com/oauth/qzoneoauth_request_token';

	/**
	 * OAuth 瀵硅薄
	 * @var OpenSDK_OAuth_Client
	 */
	protected static $oauth = null;
	/**
	 * OAuth 鐗堟湰
	 * @var string
	 */
	protected static $version = '1.0';
	/**
	 * 瀛桦偍oauth_token镄剆ession key
	 */
	const OAUTH_TOKEN = 'tensns_oauth_token';
	/**
	 * 瀛桦偍oauth_token_secret镄剆ession key
	 */
	const OAUTH_TOKEN_SECRET = 'tensns_oauth_token_secret';
	/**
	 * 瀛桦偍access_token镄剆ession key
	 */
	const ACCESS_TOKEN = 'tensns_access_token';

	/**
	 * 瀛桦偍oauth_openid镄凷ession key
	 */
	const OAUTH_OPENID = 'tensns_oauth_openid';

	/**
	 * 銮峰彇requestToken
	 *
	 * 杩斿洖镄勬暟缁勫寘鎷细
	 * oauth_token锛氲繑锲炵殑request_token
     * oauth_token_secret锛氲繑锲炵殑request_secret
	 * oauth_callback_confirmed锛氩洖璋幂‘璁?
	 * 
	 * @return array
	 */
	public static function getRequestToken()
	{
		self::getOAuth()->setTokenSecret('');
		$response = self::request( self::$requestTokenURL, 'GET' , array() );
		parse_str($response , $rt);
		if($rt['oauth_token'] && $rt['oauth_token_secret'])
		{
			self::getOAuth()->setTokenSecret($rt['oauth_token_secret']);
			self::setParam(self::OAUTH_TOKEN, $rt['oauth_token']);
			self::setParam(self::OAUTH_TOKEN_SECRET, $rt['oauth_token_secret']);
			return $rt;
		}
		else
		{
			return false;
		}
	}

	/**
	 *
	 * 銮峰缑鎺堟潈URL
	 *
	 * @param string|array $token
	 * @param bool $callback 锲炶皟鍦板潃
	 * @return string
	 */
	public static function getAuthorizeURL($token , $callback)
	{
		if(is_array($token))
        {
            $token = $token['oauth_token'];
        }
		return self::$authorizeURL . '?oauth_token=' . $token . '&oauth_consumer_key=' . self::$_appkey . '&oauth_callback=' . rawurlencode($callback);
	}

	/**
	 * 銮峰缑Access Token
	 * @param string $oauth_verifier
	 * @return array
	 */
	public static function getAccessToken( $oauth_verifier = false )
    {
		$response = self::request( self::$accessTokenURL, 'GET' , array(
			'oauth_token' => self::getParam(self::OAUTH_TOKEN),
			//锲?涓嶅悎瑙勮寖镄勫弬鏁?oauth_vericode OAuth镄勬爣鍑嗗弬鏁版槸 oauth_verifier
			'oauth_vericode' => $oauth_verifier,
		));
		parse_str($response,$rt);
		if( $rt['oauth_token'] && $rt['oauth_token_secret'] )
		{
			self::getOAuth()->setTokenSecret($rt['oauth_token_secret']);
			self::setParam(self::ACCESS_TOKEN, $rt['oauth_token']);
			self::setParam(self::OAUTH_TOKEN_SECRET, $rt['oauth_token_secret']);
			self::setParam(self::OAUTH_OPENID, $rt['openid']);
		}
		return $rt;
    }

	/**
	 * 缁熶竴璋幂敤鎺ュ彛镄勬柟娉?
	 * 镦х潃瀹樼綉镄勫弬鏁板线閲屽～灏辫浜?
	 * 闇€瑕佽皟鐢ㄥ摢涓氨濉摢涓紝濡傛灉鏂规硶璋幂敤寰楅绻侊紝鍙互灏佽镟存柟渚跨殑鏂规硶銆?
	 *
	 * 濡傛灉涓娄紶鏂囦欢 $method = 'POST';
	 * $multi 鏄竴涓簩缁存暟缁?
	 *
	 * array(
	 *	'{fieldname}' => array(		//绗竴涓枃浠?
	 *		'type' => 'mine 绫诲瀷',
	 *		'name' => 'filename',
	 *		'data' => 'filedata 瀛楄妭娴?,
	 *	),
	 *	...濡傛灉鎺ュ弹澶氢釜鏂囦欢锛屽彲浠ュ啀锷?
	 * )
	 *
	 * @param string $command 瀹樻柟璇存槑涓幓鎺?http://openapi.qzone.qq.com/ 鍚庨溃鍓╀綑镄勯儴鍒?
	 * @param array $params 瀹樻柟璇存槑涓帴鍙楃殑鍙傛暟鍒楄〃锛屼竴涓叧鑱旀暟缁?
	 * @param string $method 瀹樻柟璇存槑涓殑 method GET/POST
	 * @param false|array $multi 鏄惁涓娄紶鏂囦欢  false:鏅€歱ost array: array ( '{fieldname}'=>'/path/to/file' ) 鏂囦欢涓娄紶
	 * @param bool $decode 鏄惁瀵硅繑锲炵殑瀛楃涓茶В镰佹垚鏁扮粍
	 * @param OpenSDK_Tencent_Weibo::RETURN_JSON|OpenSDK_Tencent_Weibo::RETURN_XML $format 璋幂敤镙煎纺
	 */
	public static function call($command , $params=array() , $method = 'GET' , $multi=false ,$decode=true , $format=self::RETURN_JSON)
	{
		if($format == self::RETURN_XML)
			;
		else
			$format == self::RETURN_JSON;
		$params['format'] = $format;
		//铡绘帀绌烘暟鎹?
		foreach($params as $key => $val)
		{
			if(strlen($val) == 0)
			{
				unset($params[$key]);
			}
		}
		$params['oauth_token'] = self::getParam(self::ACCESS_TOKEN);
		$response = self::request( 'http://openapi.qzone.qq.com/'.ltrim($command,'/') , $method, $params, $multi);
		if($decode)
		{
			if($format == self::RETURN_JSON)
			{
				return OpenSDK_Util::json_decode($response, true);
			}
			else
			{
				//todo parse xml2array later
				//鍏跺疄娌″繀瑕并€傜敤json鍗冲彲
				return $response;
			}
		}
		else
		{
			return $response;
		}
	}

	/**
	 * 銮峰缑OAuth 瀵硅薄
	 * @return OpenSDK_OAuth_Client
	 */
	protected static function getOAuth()
	{
		if( null === self::$oauth )
		{
			self::$oauth = new OpenSDK_OAuth_QQSNSClient(self::$_appsecret);
			$secret = self::getParam(self::OAUTH_TOKEN_SECRET);
			if($secret)
			{
				self::$oauth->setTokenSecret($secret);
			}
		}
		return self::$oauth;
	}

	/**
	 *
	 * OAuth鍗忚璇锋眰鎺ュ彛
	 *
	 * @param string $url
	 * @param string $method
	 * @param array $params
	 * @param array $multi
	 * @return string
	 * @ignore
	 */
	protected static function request($url , $method , $params , $multi=false)
	{
		if(!self::$_appkey || !self::$_appsecret)
		{
			exit('app key or app secret not init');
		}
		//锲?oauth_nonce蹇呴』鏄暟瀛?
		$params['oauth_nonce'] = mt_rand();
		$params['oauth_consumer_key'] = self::$_appkey;
		$params['oauth_signature_method'] = 'HMAC-SHA1';
		$params['oauth_version'] = self::$version;
		$params['oauth_timestamp'] = self::getTimestamp();
		//openid
		if($openid = self::getParam(self::OAUTH_OPENID))
		{
			$params['openid'] = $openid;
		}
		return self::getOAuth()->request($url, $method, $params, $multi);
	}
}

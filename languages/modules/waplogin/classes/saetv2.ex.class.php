<?php
/**
 * PHP SDK for weibo.com (using OAuth2)
 * 
 * @author Elmer Zhang <freeboy6716@gmail.com>
 */

/**
 * @ignore
 */
class OAuthException extends Exception {
	// pass
}


/**
 * 鏂版氮寰崥 OAuth 璁よ瘉绫?OAuth2)
 *
 * 鎺堟潈链哄埗璇存槑璇峰ぇ瀹跺弬钥冨井鍗氩紑鏀惧钩鍙版枃妗ｏ细{@link http://open.weibo.com/wiki/Oauth2}
 *
 * @package sae
 * @author Elmer Zhang
 * @version 1.0
 */
class SaeTOAuthV2 {
	/**
	 * @ignore
	 */
	public $client_id;
	/**
	 * @ignore
	 */
	public $client_secret;
	/**
	 * @ignore
	 */
	public $access_token;
	/**
	 * @ignore
	 */
	public $refresh_token;
	/**
	 * Contains the last HTTP status code returned. 
	 *
	 * @ignore
	 */
	public $http_code;
	/**
	 * Contains the last API call.
	 *
	 * @ignore
	 */
	public $url;
	/**
	 * Set up the API root URL.
	 *
	 * @ignore
	 */
	public $host = "https://api.weibo.com/2/";
	/**
	 * Set timeout default.
	 *
	 * @ignore
	 */
	public $timeout = 30;
	/**
	 * Set connect timeout.
	 *
	 * @ignore
	 */
	public $connecttimeout = 30;
	/**
	 * Verify SSL Cert.
	 *
	 * @ignore
	 */
	public $ssl_verifypeer = FALSE;
	/**
	 * Respons format.
	 *
	 * @ignore
	 */
	public $format = 'json';
	/**
	 * Decode returned json data.
	 *
	 * @ignore
	 */
	public $decode_json = TRUE;
	/**
	 * Contains the last HTTP headers returned.
	 *
	 * @ignore
	 */
	public $http_info;
	/**
	 * Set the useragnet.
	 *
	 * @ignore
	 */
	public $useragent = 'Sae T OAuth2 v0.1';

	/**
	 * print the debug info
	 *
	 * @ignore
	 */
	public $debug = FALSE;

	/**
	 * boundary of multipart
	 * @ignore
	 */
	public static $boundary = '';

	/**
	 * Set API URLS
	 */
	/**
	 * @ignore
	 */
	function accessTokenURL()  { return 'https://api.weibo.com/oauth2/access_token'; }
	/**
	 * @ignore
	 */
	function authorizeURL()    { return 'https://api.weibo.com/oauth2/authorize'; }

	/**
	 * construct WeiboOAuth object
	 */
	function __construct($client_id, $client_secret, $access_token = NULL, $refresh_token = NULL) {
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->access_token = $access_token;
		$this->refresh_token = $refresh_token;
	}

	/**
	 * authorize鎺ュ彛
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/Oauth2/authorize Oauth2/authorize}
	 *
	 * @param string $url 鎺堟潈鍚庣殑锲炶皟鍦板潃,绔椤搴旗敤闇€涓庡洖璋冨湴鍧€涓€镊?绔椤唴搴旗敤闇€瑕佸～鍐檆anvas page镄勫湴鍧€
	 * @param string $response_type 鏀寔镄勫€煎寘鎷?code 鍜宼oken 榛樿链间负code
	 * @param string $state 鐢ㄤ簬淇濇寔璇锋眰鍜屽洖璋幂殑钟舵€并€傚湪锲炶皟镞?浼氩湪Query Parameter涓洖浼犺鍙傛暟
	 * @param string $display 鎺堟潈椤甸溃绫诲瀷 鍙€夎寖锲? 
	 *  - default		榛樿鎺堟潈椤甸溃		
	 *  - mobile		鏀寔html5镄勬坠链?	
	 *  - popup			寮圭獥鎺堟潈椤?	
	 *  - wap1.2		wap1.2椤甸溃		
	 *  - wap2.0		wap2.0椤甸溃		
	 *  - js			js-sdk 涓撶敤 鎺堟潈椤甸溃鏄脊绐楋紝杩斿洖缁撴灉涓箦s-sdk锲炴帀鍑芥暟		
	 *  - apponweibo	绔椤唴搴旗敤涓撶敤,绔椤唴搴旗敤涓崭紶display鍙傛暟,骞朵笖response_type涓篓oken镞?榛樿浣跨敤鏀筪isplay.鎺堟潈鍚庝笉浼氲繑锲泻ccess_token锛屽彧鏄緭鍑箦s鍒锋柊绔椤唴搴旗敤鐖舵鏋?	 * @return array
	 */
	function getAuthorizeURL( $url, $response_type = 'code', $state = NULL, $display = NULL ) {
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['redirect_uri'] = $url;
		$params['response_type'] = $response_type;
		$params['state'] = $state;
		$params['display'] = $display;
		return $this->authorizeURL() . "?" . http_build_query($params);
	}

	/**
	 * access_token鎺ュ彛
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/OAuth2/access_token OAuth2/access_token}
	 *
	 * @param string $type 璇锋眰镄勭被鍨?鍙互涓?code, password, token
	 * @param array $keys 鍏朵粬鍙傛暟锛?	 *  - 褰?type涓篶ode镞讹细 array('code'=>..., 'redirect_uri'=>...)
	 *  - 褰?type涓簆assword镞讹细 array('username'=>..., 'password'=>...)
	 *  - 褰?type涓篓oken镞讹细 array('refresh_token'=>...)
	 * @return array
	 */
	function getAccessToken( $type = 'code', $keys ) {
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['client_secret'] = $this->client_secret;
		if ( $type === 'token' ) {
			$params['grant_type'] = 'refresh_token';
			$params['refresh_token'] = $keys['refresh_token'];
		} elseif ( $type === 'code' ) {
			$params['grant_type'] = 'authorization_code';
			$params['code'] = $keys['code'];
			$params['redirect_uri'] = $keys['redirect_uri'];
		} elseif ( $type === 'password' ) {
			$params['grant_type'] = 'password';
			$params['username'] = $keys['username'];
			$params['password'] = $keys['password'];
		} else {
			throw new OAuthException("wrong auth type");
		}

		$response = $this->oAuthRequest($this->accessTokenURL(), 'POST', $params);
		$token = json_decode($response, true);
		if ( is_array($token) && !isset($token['error']) ) {
			$this->access_token = $token['access_token'];
			//$this->refresh_token = $token['refresh_token'];
		} else {
			throw new OAuthException("get access token failed." . $token['error']);
		}
		return $token;
	}

	/**
	 * 瑙ｆ瀽 signed_request
	 *
	 * @param string $signed_request 搴旗敤妗嗘灦鍦ㄥ姞杞絠frame镞朵细阃氲绷鍚愠anvas URL post镄勫弬鏁皊igned_request
	 *
	 * @return array
	 */
	function parseSignedRequest($signed_request) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
		$sig = self::base64decode($encoded_sig) ;
		$data = json_decode(self::base64decode($payload), true);
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') return '-1';
		$expected_sig = hash_hmac('sha256', $payload, $this->client_secret, true);
		return ($sig !== $expected_sig)? '-2':$data;
	}

	/**
	 * @ignore
	 */
	function base64decode($str) {
		return base64_decode(strtr($str.str_repeat('=', (4 - strlen($str) % 4)), '-_', '+/'));
	}

	/**
	 * 璇诲彇jssdk鎺堟潈淇℃伅锛岀敤浜庡拰jssdk镄勫悓姝ョ橱褰?	 *
	 * @return array 鎴愬姛杩斿洖array('access_token'=>'value', 'refresh_token'=>'value'); 澶辫触杩斿洖false
	 */
	function getTokenFromJSSDK() {
		$key = "weibojs_" . $this->client_id;
		if ( isset($_COOKIE[$key]) && $cookie = $_COOKIE[$key] ) {
			parse_str($cookie, $token);
			if ( isset($token['access_token']) && isset($token['refresh_token']) ) {
				$this->access_token = $token['access_token'];
				$this->refresh_token = $token['refresh_token'];
				return $token;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * 浠庢暟缁勪腑璇诲彇access_token鍜宺efresh_token
	 * 甯哥敤浜庝粠Session鎴朇ookie涓鍙杢oken锛屾垨阃氲绷Session/Cookie涓槸鍚﹀瓨链塼oken鍒ゆ柇鐧诲綍钟舵€并€?	 *
	 * @param array $arr 瀛樻湁access_token鍜宻ecret_token镄勬暟缁?	 * @return array 鎴愬姛杩斿洖array('access_token'=>'value', 'refresh_token'=>'value'); 澶辫触杩斿洖false
	 */
	function getTokenFromArray( $arr ) {
		if (isset($arr['access_token']) && $arr['access_token']) {
			$token = array();
			$this->access_token = $token['access_token'] = $arr['access_token'];
			if (isset($arr['refresh_token']) && $arr['refresh_token']) {
				$this->refresh_token = $token['refresh_token'] = $arr['refresh_token'];
			}

			return $token;
		} else {
			return false;
		}
	}

	/**
	 * GET wrappwer for oAuthRequest.
	 *
	 * @return mixed
	 */
	function get($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'GET', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * POST wreapper for oAuthRequest.
	 *
	 * @return mixed
	 */
	function post($url, $parameters = array(), $multi = false) {
		$response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * DELTE wrapper for oAuthReqeust.
	 *
	 * @return mixed
	 */
	function delete($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'DELETE', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * Format and sign an OAuth / API request
	 *
	 * @return string
	 * @ignore
	 */
	function oAuthRequest($url, $method, $parameters, $multi = false) {

		if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
			$url = "{$this->host}{$url}.{$this->format}";
	}

	switch ($method) {
		case 'GET':
			$url = $url . '?' . http_build_query($parameters);
			return $this->http($url, 'GET');
		default:
			$headers = array();
			if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
				$body = http_build_query($parameters);
			} else {
				$body = self::build_http_query_multi($parameters);
				$headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
			}
			return $this->http($url, $method, $body, $headers);
	}
	}

	/**
	 * Make an HTTP request
	 *
	 * @return string API results
	 * @ignore
	 */
	function http($url, $method, $postfields = NULL, $headers = array()) {
		$this->http_info = array();
		$ci = curl_init();
		/* Curl settings */
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
		curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);

		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
					$this->postdata = $postfields;
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}

		if ( isset($this->access_token) && $this->access_token )
			$headers[] = "Authorization: OAuth2 ".$this->access_token;

		if ( !empty($this->remote_ip) ) {
			if ( defined('SAE_ACCESSKEY') ) {
				$headers[] = "SaeRemoteIP: " . $this->remote_ip;
			} else {
				$headers[] = "API-RemoteIP: " . $this->remote_ip;
			}
		} else {
			if ( !defined('SAE_ACCESSKEY') ) {
				$headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
			}
		}
		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

		$response = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;

		if ($this->debug) {
			echo "=====post data======\r\n";
			var_dump($postfields);

			echo "=====headers======\r\n";
			print_r($headers);

			echo '=====request info====='."\r\n";
			print_r( curl_getinfo($ci) );

			echo '=====response====='."\r\n";
			print_r( $response );
		}
		curl_close ($ci);
		return $response;
	}

	/**
	 * Get the header info to store.
	 *
	 * @return int
	 * @ignore
	 */
	function getHeader($ch, $header) {
		$i = strpos($header, ':');
		if (!empty($i)) {
			$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
			$value = trim(substr($header, $i + 2));
			$this->http_header[$key] = $value;
		}
		return strlen($header);
	}

	/**
	 * @ignore
	 */
	public static function build_http_query_multi($params) {
		if (!$params) return '';

		uksort($params, 'strcmp');

		$pairs = array();

		self::$boundary = $boundary = uniqid('------------------');
		$MPboundary = '--'.$boundary;
		$endMPboundary = $MPboundary. '--';
		$multipartbody = '';

		foreach ($params as $parameter => $value) {

			if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
				$url = ltrim( $value, '@' );
				$content = file_get_contents( $url );
				$array = explode( '?', basename( $url ) );
				$filename = $array[0];

				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
				$multipartbody .= "Content-Type: image/unknown\r\n\r\n";
				$multipartbody .= $content. "\r\n";
			} else {
				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
				$multipartbody .= $value."\r\n";
			}

		}

		$multipartbody .= $endMPboundary;
		return $multipartbody;
	}
}


/**
 * 鏂版氮寰崥鎿崭綔绫籚2
 *
 * 浣跨敤鍓嶉渶瑕佸厛镓嫔伐璋幂敤saetv2.ex.class.php <br />
 *
 * @package sae
 * @author Easy Chen, Elmer Zhang,Lazypeople
 * @version 1.0
 */
class SaeTClientV2
{
	/**
	 * 鏋勯€犲嚱鏁?	 * 
	 * @access public
	 * @param mixed $akey 寰崥寮€鏀惧钩鍙板簲鐢ˋPP KEY
	 * @param mixed $skey 寰崥寮€鏀惧钩鍙板簲鐢ˋPP SECRET
	 * @param mixed $access_token OAuth璁よ瘉杩斿洖镄则oken
	 * @param mixed $refresh_token OAuth璁よ瘉杩斿洖镄则oken secret
	 * @return void
	 */
	function __construct( $akey, $skey, $access_token, $refresh_token = NULL)
	{
		$this->oauth = new SaeTOAuthV2( $akey, $skey, $access_token, $refresh_token );
	}

	/**
	 * 寮€鍚皟璇曚俊鎭?	 *
	 * 寮€鍚皟璇曚俊鎭悗锛孲DK浼氩皢姣忔璇锋眰寰崥API镓€鍙戦€佺殑POST Data銆丠eaders浠ュ强璇锋眰淇℃伅銆佽繑锲炲唴瀹硅緭鍑哄嚭鏉ャ€?	 *
	 * @access public
	 * @param bool $enable 鏄惁寮€鍚皟璇曚俊鎭?	 * @return void
	 */
	function set_debug( $enable )
	{
		$this->oauth->debug = $enable;
	}

	/**
	 * 璁剧疆鐢ㄦ埛IP
	 *
	 * SDK榛樿灏嗕细阃氲绷$_SERVER['REMOTE_ADDR']銮峰彇鐢ㄦ埛IP锛屽湪璇锋眰寰崥API镞跺皢鐢ㄦ埛IP闄勫姞鍒癛equest Header涓€备絾镆愪簺鎯呭喌涓?_SERVER['REMOTE_ADDR']鍙栧埌镄処P骞堕潪鐢ㄦ埛IP锛岃€屾槸涓€涓浐瀹氱殑IP锛堜緥濡备娇鐢⊿AE镄凛ron鎴朤askQueue链嶅姟镞讹级锛屾镞跺氨链夊彲鑳戒细阃犳垚璇ュ浐瀹欼P杈惧埌寰崥API璋幂敤棰戠巼闄愰锛屽镊碅PI璋幂敤澶辫触銆傛镞跺彲浣跨敤链柟娉曡缃敤鎴稩P锛屼互阆垮厤姝ら棶棰朴€?	 *
	 * @access public
	 * @param string $ip 鐢ㄦ埛IP
	 * @return bool IP涓洪潪娉旾P瀛楃涓叉椂锛岃繑锲瀎alse锛屽惁鍒栾繑锲潇rue
	 */
	function set_remote_ip( $ip )
	{
		if ( ip2long($ip) !== false ) {
			$this->oauth->remote_ip = $ip;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 銮峰彇链€鏂扮殑鍏叡寰崥娑堟伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/public_timeline statuses/public_timeline}
	 *
	 * @access public
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @return array
	 */
	function public_timeline( $page = 1, $count = 50, $base_app = 0 )
	{
		$params = array();
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get('statuses/public_timeline', $params);//鍙兘鏄帴鍙ｇ殑bug涓嶈兘琛ュ叏
	}

	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛鍙婂叾镓€鍏虫敞鐢ㄦ埛镄勬渶鏂板井鍗氭秷鎭€?	 *
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛鍙婂叾镓€鍏虫敞鐢ㄦ埛镄勬渶鏂板井鍗氭秷鎭€傚拰鐢ㄦ埛鐧诲綍 http://weibo.com 鍚庡湪钬沧垜镄勯椤碘€濅腑鐪嫔埌镄勫唴瀹圭浉鍚屻€傚悓friends_timeline()
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/home_timeline statuses/home_timeline}
	 * 
	 * @access public
	 * @param int $page 鎸囧畾杩斿洖缁撴灉镄勯〉镰并€傛抵鎹綋鍓岖橱褰旷敤鎴锋墍鍏虫敞镄勭敤鎴锋暟鍙婅繖浜涜鍏虫敞鐢ㄦ埛鍙戣〃镄勫井鍗氭暟锛岀炕椤靛姛鑳芥渶澶氲兘镆ョ湅镄勬€昏褰曟暟浼氭湁镓€涓嶅悓锛岄€氩父链€澶氲兘镆ョ湅1000鏉″乏鍙炽€傞粯璁ゅ€?銆傚彲阃夈€?	 * @param int $count 姣忔杩斿洖镄勮褰曟暟銆傜己鐪佸€?0锛屾渶澶у€?00銆傚彲阃夈€?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑寰崥娑堟伅锛埚嵆姣攕ince_id鍙戣〃镞堕棿鏅氱殑寰崥娑堟伅锛夈€傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勫井鍗氭秷鎭€傚彲阃夈€?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @param int $feature 杩囨护绫诲瀷ID锛?锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氩浘鐗囥€?锛氲棰戙€?锛氶煶涔愶紝榛樿涓?銆?	 * @return array
	 */
	function home_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);

		return $this->oauth->get('statuses/home_timeline', $params);
	}

	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛鍙婂叾镓€鍏虫敞鐢ㄦ埛镄勬渶鏂板井鍗氭秷鎭€?	 *
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛鍙婂叾镓€鍏虫敞鐢ㄦ埛镄勬渶鏂板井鍗氭秷鎭€傚拰鐢ㄦ埛鐧诲綍 http://weibo.com 鍚庡湪钬沧垜镄勯椤碘€濅腑鐪嫔埌镄勫唴瀹圭浉鍚屻€傚悓home_timeline()
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/friends_timeline statuses/friends_timeline}
	 * 
	 * @access public
	 * @param int $page 鎸囧畾杩斿洖缁撴灉镄勯〉镰并€傛抵鎹綋鍓岖橱褰旷敤鎴锋墍鍏虫敞镄勭敤鎴锋暟鍙婅繖浜涜鍏虫敞鐢ㄦ埛鍙戣〃镄勫井鍗氭暟锛岀炕椤靛姛鑳芥渶澶氲兘镆ョ湅镄勬€昏褰曟暟浼氭湁镓€涓嶅悓锛岄€氩父链€澶氲兘镆ョ湅1000鏉″乏鍙炽€傞粯璁ゅ€?銆傚彲阃夈€?	 * @param int $count 姣忔杩斿洖镄勮褰曟暟銆傜己鐪佸€?0锛屾渶澶у€?00銆傚彲阃夈€?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑寰崥娑堟伅锛埚嵆姣攕ince_id鍙戣〃镞堕棿鏅氱殑寰崥娑堟伅锛夈€傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勫井鍗氭秷鎭€傚彲阃夈€?	 * @param int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?涓洪檺鍒舵湰搴旗敤寰崥锛?涓轰笉锅氶檺鍒躲€傞粯璁や负0銆傚彲阃夈€?	 * @param int $feature 寰崥绫诲瀷锛?鍏ㄩ儴锛?铡熷垱锛?锲剧墖锛?瑙嗛锛?阔充箰. 杩斿洖鎸囧畾绫诲瀷镄勫井鍗氢俊鎭唴瀹广€傝浆涓轰负0銆傚彲阃夈€?	 * @return array
	 */
	function friends_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
	{
		return $this->home_timeline( $since_id, $max_id, $count, $page, $base_app, $feature);
	}

	/**
	 * 銮峰彇鐢ㄦ埛鍙戝竷镄勫井鍗氢俊鎭垪琛?	 *
	 * 杩斿洖鐢ㄦ埛镄勫彂甯幂殑链€杩忧鏉′俊鎭紝鍜岀敤鎴峰井鍗氶〉闱㈣繑锲炲唴瀹规槸涓€镊寸殑銆傛鎺ュ彛涔熷彲浠ヨ姹傚叾浠栫敤鎴风殑链€鏂板彂琛ㄥ井鍗氥€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/user_timeline statuses/user_timeline}
	 * 
	 * @access public
	 * @param int $page 椤电爜
	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆?	 * @param mixed $uid 鎸囧畾鐢ㄦ埛UID鎴栧井鍗氭樀绉?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑寰崥娑堟伅锛埚嵆姣攕ince_id鍙戣〃镞堕棿鏅氱殑寰崥娑堟伅锛夈€傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勬彁鍒板綋鍓岖橱褰旷敤鎴峰井鍗氭秷鎭€傚彲阃夈€?	 * @param int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?涓洪檺鍒舵湰搴旗敤寰崥锛?涓轰笉锅氶檺鍒躲€傞粯璁や负0銆?	 * @param int $feature 杩囨护绫诲瀷ID锛?锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氩浘鐗囥€?锛氲棰戙€?锛氶煶涔愶紝榛樿涓?銆?	 * @param int $trim_user 杩斿洖链间腑user淇℃伅寮€鍏筹紝0锛氲繑锲炲畲鏁寸殑user淇℃伅銆?锛歶ser瀛楁浠呰繑锲潆id锛岄粯璁や负0銆?	 * @return array
	 */
	function user_timeline_by_id( $uid = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0)
	{
		$params = array();
		$params['uid']=$uid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['trim_user'] = intval($trim_user);

		return $this->oauth->get( 'statuses/user_timeline', $params );
	}
	
	
	/**
	 * 銮峰彇鐢ㄦ埛鍙戝竷镄勫井鍗氢俊鎭垪琛?	 *
	 * 杩斿洖鐢ㄦ埛镄勫彂甯幂殑链€杩忧鏉′俊鎭紝鍜岀敤鎴峰井鍗氶〉闱㈣繑锲炲唴瀹规槸涓€镊寸殑銆傛鎺ュ彛涔熷彲浠ヨ姹傚叾浠栫敤鎴风殑链€鏂板彂琛ㄥ井鍗氥€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/user_timeline statuses/user_timeline}
	 * 
	 * @access public
	 * @param string $screen_name 寰崥鏄电О锛屼富瑕佹槸鐢ㄦ潵鍖哄垎鐢ㄦ埛UID璺熷井鍗氭樀绉帮紝褰扑簩钥呬竴镙疯€屼骇鐢熸涔夌殑镞跺€欙紝寤鸿浣跨敤璇ュ弬鏁?
	 * @param int $page 椤电爜
	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑寰崥娑堟伅锛埚嵆姣攕ince_id鍙戣〃镞堕棿鏅氱殑寰崥娑堟伅锛夈€傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勬彁鍒板綋鍓岖橱褰旷敤鎴峰井鍗氭秷鎭€傚彲阃夈€?	 * @param int $feature 杩囨护绫诲瀷ID锛?锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氩浘鐗囥€?锛氲棰戙€?锛氶煶涔愶紝榛樿涓?銆?	 * @param int $trim_user 杩斿洖链间腑user淇℃伅寮€鍏筹紝0锛氲繑锲炲畲鏁寸殑user淇℃伅銆?锛歶ser瀛楁浠呰繑锲潆id锛岄粯璁や负0銆?	 * @param int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?涓洪檺鍒舵湰搴旗敤寰崥锛?涓轰笉锅氶檺鍒躲€傞粯璁や负0銆?	 * @return array
	 */
	function user_timeline_by_name( $screen_name = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['trim_user'] = intval($trim_user);

		return $this->oauth->get( 'statuses/user_timeline', $params );
	}
	
	
	
	/**
	 * 镓归噺銮峰彇鎸囧畾镄勪竴镓圭敤鎴风殑timeline
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/timeline_batch statuses/timeline_batch}
	 *
	 * @param string $screen_name  闇€瑕佹煡璇㈢殑鐢ㄦ埛鏄电О锛岀敤鍗婅阃楀佛鍒嗛殧锛屼竴娆℃渶澶?0涓?	 * @param int    $count        鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int    $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?
	 * @param int    $base_app  鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @param int    $feature   杩囨护绫诲瀷ID锛?锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氩浘鐗囥€?锛氲棰戙€?锛氶煶涔愶紝榛樿涓?銆?	 * @return array
	 */
	function timeline_batch_by_name( $screen_name, $page = 1, $count = 50, $feature = 0, $base_app = 0)
	{
		$params = array();
		if (is_array($screen_name) && !empty($screen_name)) {
			$params['screen_name'] = join(',', $screen_name);
		} else {
			$params['screen_name'] = $screen_name;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page); 
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		return $this->oauth->get('statuses/timeline_batch', $params);
	}

	/**
	 * 镓归噺銮峰彇鎸囧畾镄勪竴镓圭敤鎴风殑timeline
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/timeline_batch statuses/timeline_batch}
	 *
	 * @param string $uids  闇€瑕佹煡璇㈢殑鐢ㄦ埛ID锛岀敤鍗婅阃楀佛鍒嗛殧锛屼竴娆℃渶澶?0涓€?	 * @param int    $count        鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int    $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?
	 * @param int    $base_app  鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @param int    $feature   杩囨护绫诲瀷ID锛?锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氩浘鐗囥€?锛氲棰戙€?锛氶煶涔愶紝榛樿涓?銆?	 * @return array
	 */
	function timeline_batch_by_id( $uids, $page = 1, $count = 50, $feature = 0, $base_app = 0)
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page); 
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		return $this->oauth->get('statuses/timeline_batch', $params);
	}


	/**
	 * 杩斿洖涓€鏉″师鍒涘井鍗氭秷鎭殑链€鏂皀鏉¤浆鍙戝井鍗氭秷鎭€傛湰鎺ュ彛镞犳硶瀵归潪铡熷垱寰崥杩涜镆ヨ銆?
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/repost_timeline statuses/repost_timeline}
	 * 
	 * @access public
	 * @param int $sid 瑕佽幏鍙栬浆鍙戝井鍗氩垪琛ㄧ殑铡熷垱寰崥ID銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰并€?
	 * @param int $count 鍗曢〉杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆傚彲阃夈€?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑璁板綍锛堟瘮since_id鍙戣〃镞堕棿鏅泛级銆傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮褰曘€傚彲阃夈€?	 * @param int $filter_by_author 浣滆€呯瓫阃夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭垜鍏虫敞镄勪汉銆?锛氶檶鐢熶汉锛岄粯璁や负0銆?	 * @return array
	 */
	function repost_timeline( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
	{
		$this->id_format($sid);

		$params = array();
		$params['id'] = $sid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['filter_by_author'] = intval($filter_by_author);

		return $this->request_with_pager( 'statuses/repost_timeline', $page, $count, $params );
	}

	/**
	 * 銮峰彇褰揿墠鐢ㄦ埛链€鏂拌浆鍙戠殑n鏉″井鍗氭秷鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/repost_by_me statuses/repost_by_me}
	 * 
	 * @access public
	 * @param int $page 杩斿洖缁撴灉镄勯〉镰并€?
	 * @param int $count  姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆傚彲阃夈€?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑璁板綍锛堟瘮since_id鍙戣〃镞堕棿鏅泛级銆傚彲阃夈€?	 * @param int $max_id  鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮褰曘€傚彲阃夈€?	 * @return array
	 */
	function repost_by_me( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager('statuses/repost_by_me', $page, $count, $params );
	}

	/**
	 * 銮峰彇@褰揿墠鐢ㄦ埛镄勫井鍗氩垪琛?	 *
	 * 杩斿洖链€鏂皀鏉℃彁鍒扮橱褰旷敤鎴风殑寰崥娑堟伅锛埚嵆鍖呭惈@username镄勫井鍗氭秷鎭级
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/mentions statuses/mentions}
	 * 
	 * @access public
	 * @param int $page 杩斿洖缁撴灉镄勯〉搴忓佛銆?	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛埚嵆椤甸溃澶у皬锛夛紝涓嶅ぇ浜?00锛岄粯璁や负50銆?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑寰崥娑堟伅锛埚嵆姣攕ince_id鍙戣〃镞堕棿鏅氱殑寰崥娑堟伅锛夈€傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勬彁鍒板綋鍓岖橱褰旷敤鎴峰井鍗氭秷鎭€傚彲阃夈€?	 * @param int $filter_by_author 浣滆€呯瓫阃夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭垜鍏虫敞镄勪汉銆?锛氶檶鐢熶汉锛岄粯璁や负0銆?	 * @param int $filter_by_source 鏉ユ簮绛涢€夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭潵镊井鍗氥€?锛氭潵镊井缇わ紝榛樿涓?銆?	 * @param int $filter_by_type 铡熷垱绛涢€夌被鍨嬶紝0锛氩叏閮ㄥ井鍗氥€?锛氩师鍒涚殑寰崥锛岄粯璁や负0銆?	 * @return array
	 */
	function mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0, $filter_by_type = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		$params['filter_by_type'] = $filter_by_type;

		return $this->request_with_pager( 'statuses/mentions', $page, $count, $params );
	}


	/**
	 * 镙规嵁ID銮峰彇鍗曟浔寰崥淇℃伅鍐呭
	 *
	 * 銮峰彇鍗曟浔ID镄勫井鍗氢俊鎭紝浣滆€呬俊鎭皢鍚屾椂杩斿洖銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/show statuses/show}
	 * 
	 * @access public
	 * @param int $id 瑕佽幏鍙栧凡鍙戣〃镄勫井鍗欼D, 濡局D涓嶅瓨鍦ㄨ繑锲炵┖
	 * @return array
	 */
	function show_status( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->get('statuses/show', $params);
	}

	/**
	 * 镙规嵁寰崥id鍙疯幏鍙栧井鍗氱殑淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/show_batch statuses/show_batch}
	 *
	 * @param string $ids 闇€瑕佹煡璇㈢殑寰崥ID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷50涓€?	 * @return array
	 */
    function show_batch( $ids )
	{
		$params=array();
		if (is_array($ids) && !empty($ids)) {
			foreach($ids as $k => $v) {
				$this->id_format($ids[$k]);
			}
			$params['ids'] = join(',', $ids);
		} else {
			$params['ids'] = $ids;
		}
		return $this->oauth->get('statuses/show_batch', $params);
	}

	/**
	 * 阃氲绷寰崥锛堣瘎璁恒€佺淇★级ID銮峰彇鍏禡ID
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/querymid statuses/querymid}
	 *
	 * @param int|string $id  闇€瑕佹煡璇㈢殑寰崥锛堣瘎璁恒€佺淇★级ID锛屾壒閲忔ā寮忎笅锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷20涓€?	 * @param int $type  銮峰彇绫诲瀷锛?锛氩井鍗氥€?锛氲瘎璁恒€?锛氱淇★紝榛樿涓?銆?	 * @param int $is_batch 鏄惁浣跨敤镓归噺妯″纺锛?锛氩惁銆?锛氭槸锛岄粯璁や负0銆?	 * @return array
	 */
	function querymid( $id, $type = 1, $is_batch = 0 )
	{
		$params = array();
		$params['id'] = $id;
		$params['type'] = intval($type);
		$params['is_batch'] = intval($is_batch);
		return $this->oauth->get( 'statuses/querymid',  $params);
	}

	/**
	 * 阃氲绷寰崥锛堣瘎璁恒€佺淇★级MID銮峰彇鍏禝D
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/queryid statuses/queryid}
	 *
	 * @param int|string $mid  闇€瑕佹煡璇㈢殑寰崥锛堣瘎璁恒€佺淇★级MID锛屾壒閲忔ā寮忎笅锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷20涓€?	 * @param int $type  銮峰彇绫诲瀷锛?锛氩井鍗氥€?锛氲瘎璁恒€?锛氱淇★紝榛樿涓?銆?	 * @param int $is_batch 鏄惁浣跨敤镓归噺妯″纺锛?锛氩惁銆?锛氭槸锛岄粯璁や负0銆?	 * @param int $inbox  浠呭绉佷俊链夋晥锛屽綋MID绫诲瀷涓虹淇℃椂鐢ㄦ鍙傛暟锛?锛氩彂浠剁銆?锛氭敹浠剁锛岄粯璁や负0 銆?	 * @param int $isBase62 MID鏄惁鏄痓ase62缂栫爜锛?锛氩惁銆?锛氭槸锛岄粯璁や负0銆?	 * @return array
	 */
	function queryid( $mid, $type = 1, $is_batch = 0, $inbox = 0, $isBase62 = 0)
	{
		$params = array();
		$params['mid'] = $mid;
		$params['type'] = intval($type);
		$params['is_batch'] = intval($is_batch);
		$params['inbox'] = intval($inbox);
		$params['isBase62'] = intval($isBase62);
		return $this->oauth->get('statuses/queryid', $params);
	}

	/**
	 * 鎸夊ぉ杩斿洖鐑棬寰崥杞彂姒灭殑寰崥鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/hot/repost_daily statuses/hot/repost_daily}
	 *
	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝链€澶т笉瓒呰绷50锛岄粯璁や负20銆?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @return array
	 */
	function repost_daily( $count = 20, $base_app = 0)
	{
		$params = array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get('statuses/hot/repost_daily',  $params);
	}

	/**
	 * 鎸夊懆杩斿洖鐑棬寰崥杞彂姒灭殑寰崥鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/hot/repost_weekly statuses/hot/repost_weekly}
	 *
	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝链€澶т笉瓒呰绷50锛岄粯璁や负20銆?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @return array
	 */
	function repost_weekly( $count = 20,  $base_app = 0)
	{
		$params = array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/repost_weekly',  $params);
	}

	/**
	 * 鎸夊ぉ杩斿洖鐑棬寰崥璇勮姒灭殑寰崥鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/hot/comments_daily statuses/hot/comments_daily}
	 *
	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝链€澶т笉瓒呰绷50锛岄粯璁や负20銆?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @return array
	 */
	function comments_daily( $count = 20,  $base_app = 0)
	{
		$params =  array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/comments_daily',  $params);
	}

	/**
	 * 鎸夊懆杩斿洖鐑棬寰崥璇勮姒灭殑寰崥鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/hot/comments_weekly statuses/hot/comments_weekly}
	 *
	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝链€澶т笉瓒呰绷50锛岄粯璁や负20銆?	 * @param int $base_app 鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * @return array
	 */
	function comments_weekly( $count = 20, $base_app = 0)
	{
		$params =  array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/comments_weekly', $params);
	}


	/**
	 * 杞彂涓€鏉″井鍗氢俊鎭€?	 *
	 * 鍙姞璇勮銆备负阒叉閲嶅锛屽彂甯幂殑淇℃伅涓庢渶鏂颁俊鎭竴镙疯瘽锛屽皢浼氲蹇界暐銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/repost statuses/repost}
	 * 
	 * @access public
	 * @param int $sid 杞彂镄勫井鍗欼D
	 * @param string $text 娣诲姞镄勮瘎璁轰俊鎭€傚彲阃夈€?	 * @param int $is_comment 鏄惁鍦ㄨ浆鍙戠殑鍚屾椂鍙戣〃璇勮锛?锛氩惁銆?锛氲瘎璁虹粰褰揿墠寰崥銆?锛氲瘎璁虹粰铡熷井鍗氥€?锛氶兘璇勮锛岄粯璁や负0銆?	 * @return array
	 */
	function repost( $sid, $text = NULL, $is_comment = 0 )
	{
		$this->id_format($sid);

		$params = array();
		$params['id'] = $sid;
		$params['is_comment'] = $is_comment;
		if( $text ) $params['status'] = $text;

		return $this->oauth->post( 'statuses/repost', $params  );
	}

	/**
	 * 鍒犻櫎涓€鏉″井鍗?	 * 
	 * 镙规嵁ID鍒犻櫎寰崥娑堟伅銆傛敞镒忥细鍙兘鍒犻櫎镊繁鍙戝竷镄勪俊鎭€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/destroy statuses/destroy}
	 * 
	 * @access public
	 * @param int $id 瑕佸垹闄ょ殑寰崥ID
	 * @return array
	 */
	function delete( $id )
	{
		return $this->destroy( $id );
	}

	/**
	 * 鍒犻櫎涓€鏉″井鍗?	 *
	 * 鍒犻櫎寰崥銆傛敞镒忥细鍙兘鍒犻櫎镊繁鍙戝竷镄勪俊鎭€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/destroy statuses/destroy}
	 * 
	 * @access public
	 * @param int $id 瑕佸垹闄ょ殑寰崥ID
	 * @return array
	 */
	function destroy( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'statuses/destroy',  $params );
	}

	
	/**
	 * 鍙戣〃寰崥
	 *
	 * 鍙戝竷涓€鏉″井鍗氢俊鎭€?	 * <br />娉ㄦ剰锛歭at鍜宭ong鍙傛暟闇€閰嶅悎浣跨敤锛岀敤浜庢爣璁板彂琛ㄥ井鍗氭秷鎭椂镓€鍦ㄧ殑鍦扮悊浣岖疆锛屽彧链夌敤鎴疯缃腑geo_enabled=true镞跺€椤湴鐞嗕綅缃俊鎭墠链夋晥銆?	 * <br />娉ㄦ剰锛氢负阒叉閲嶅鎻愪氦锛屽綋鐢ㄦ埛鍙戝竷镄勫井鍗氭秷鎭笌涓婃鎴愬姛鍙戝竷镄勫井鍗氭秷鎭唴瀹逛竴镙锋椂锛屽皢杩斿洖400阌栾锛岀粰鍑洪敊璇彁绀猴细钬?0025:Error: repeated weibo text!钬溿€?
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/update statuses/update}
	 * 
	 * @access public
	 * @param string $status 瑕佹洿鏂扮殑寰崥淇℃伅銆备俊鎭唴瀹逛笉瓒呰绷140涓眽瀛? 涓虹┖杩斿洖400阌栾銆?	 * @param float $lat 绾害锛屽彂琛ㄥ綋鍓嶅井鍗氭墍鍦ㄧ殑鍦扮悊浣岖疆锛屾湁鏁堣寖锲?-90.0鍒?90.0, +琛ㄧず鍖楃含銆傚彲阃夈€?	 * @param float $long 缁忓害銆傛湁鏁堣寖锲?180.0鍒?180.0, +琛ㄧず涓灭粡銆傚彲阃夈€?	 * @param mixed $annotations 鍙€夊弬鏁般€傚厓鏁版嵁锛屼富瑕佹槸涓轰简鏂逛究绗笁鏂瑰簲鐢ㄨ褰曚竴浜涢€傚悎浜庤嚜宸变娇鐢ㄧ殑淇℃伅銆傛疮鏉″井鍗氩彲浠ュ寘鍚竴涓垨钥呭涓厓鏁版嵁銆傝浠son瀛椾覆镄勫舰寮忔彁浜わ紝瀛椾覆闀垮害涓嶈秴杩?12涓瓧绗︼紝鎴栬€呮暟缁勬柟寮忥紝瑕佹眰json_encode鍚庡瓧涓查昵搴︿笉瓒呰绷512涓瓧绗︺€傚叿浣揿唴瀹瑰彲浠ヨ嚜瀹氥€备緥濡傦细'[{"type2":123}, {"a":"b", "c":"d"}]'鎴朼rray(array("type2"=>123), array("a"=>"b", "c"=>"d"))銆?	 * @return array
	 */
	function update( $status, $lat = NULL, $long = NULL, $annotations = NULL )
	{
		$params = array();
		$params['status'] = $status;
		if ($lat) {
			$params['lat'] = floatval($lat);
		}
		if ($long) {
			$params['long'] = floatval($long);
		}
		if (is_string($annotations)) {
			$params['annotations'] = $annotations;
		} elseif (is_array($annotations)) {
			$params['annotations'] = json_encode($annotations);
		}

		return $this->oauth->post( 'statuses/update', $params );
	}

	/**
	 * 鍙戣〃锲剧墖寰崥
	 *
	 * 鍙戣〃锲剧墖寰崥娑堟伅銆傜洰鍓崭笂浼犲浘鐗囧ぇ灏忛檺鍒朵负<5M銆?
	 * <br />娉ㄦ剰锛歭at鍜宭ong鍙傛暟闇€閰嶅悎浣跨敤锛岀敤浜庢爣璁板彂琛ㄥ井鍗氭秷鎭椂镓€鍦ㄧ殑鍦扮悊浣岖疆锛屽彧链夌敤鎴疯缃腑geo_enabled=true镞跺€椤湴鐞嗕綅缃俊鎭墠链夋晥銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/upload statuses/upload}
	 * 
	 * @access public
	 * @param string $status 瑕佹洿鏂扮殑寰崥淇℃伅銆备俊鎭唴瀹逛笉瓒呰绷140涓眽瀛? 涓虹┖杩斿洖400阌栾銆?	 * @param string $pic_path 瑕佸彂甯幂殑锲剧墖璺缎, 鏀寔url銆俒鍙敮鎸乸ng/jpg/gif涓夌镙煎纺, 澧炲姞镙煎纺璇蜂慨鏀筭et_image_mime鏂规硶]
	 * @param float $lat 绾害锛屽彂琛ㄥ綋鍓嶅井鍗氭墍鍦ㄧ殑鍦扮悊浣岖疆锛屾湁鏁堣寖锲?-90.0鍒?90.0, +琛ㄧず鍖楃含銆傚彲阃夈€?	 * @param float $long 鍙€夊弬鏁帮紝缁忓害銆傛湁鏁堣寖锲?180.0鍒?180.0, +琛ㄧず涓灭粡銆傚彲阃夈€?	 * @return array
	 */
	function upload( $status, $pic_path, $lat = NULL, $long = NULL )
	{
		$params = array();
		$params['status'] = $status;
		$params['pic'] = '@'.$pic_path;
		if ($lat) {
			$params['lat'] = floatval($lat);
		}
		if ($long) {
			$params['long'] = floatval($long);
		}

		return $this->oauth->post( 'statuses/upload', $params, true );
	}


	/**
	 * 鎸囧畾涓€涓浘鐗嘦RL鍦板潃鎶揿彇鍚庝笂浼犲苟鍚屾椂鍙戝竷涓€鏉℃柊寰崥
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/upload_url_text statuses/upload_url_text}
	 *
	 * @param string $status  瑕佸彂甯幂殑寰崥鏂囨湰鍐呭锛屽唴瀹逛笉瓒呰绷140涓眽瀛椼€?	 * @param string $url    锲剧墖镄刄RL鍦板潃锛屽繀椤讳互http寮€澶淬€?	 * @return array
	 */
	function upload_url_text( $status,  $url )
	{
		$params = array();
		$params['status'] = $status;
		$params['url'] = $url;
		return $this->oauth->post( 'statuses/upload', $params, true );
	}


	/**
	 * 銮峰彇琛ㄦ儏鍒楄〃
	 *
	 * 杩斿洖鏂版氮寰崥瀹樻柟镓€链夎〃鎯呫€侀瓟娉曡〃鎯呯殑鐩稿叧淇℃伅銆傚寘鎷煭璇€佽〃鎯呯被鍨嬨€佽〃鎯呭垎绫伙紝鏄惁鐑棬绛夈€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/emotions emotions}
	 * 
	 * @access public
	 * @param string $type 琛ㄦ儏绫诲埆銆?face":鏅€氲〃鎯咃紝"ani"锛氶瓟娉曡〃鎯咃紝"cartoon"锛氩姩婕〃鎯呫€傞粯璁や负"face"銆傚彲阃夈€?	 * @param string $language 璇█绫诲埆锛?cnname"绠€浣掳紝"twname"绻佷綋銆傞粯璁や负"cnname"銆傚彲阃?	 * @return array
	 */
	function emotions( $type = "face", $language = "cnname" )
	{
		$params = array();
		$params['type'] = $type;
		$params['language'] = $language;
		return $this->oauth->get( 'emotions', $params );
	}


	/**
	 * 镙规嵁寰崥ID杩斿洖镆愭浔寰崥镄勮瘎璁哄垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/show comments/show}
	 *
	 * @param int $sid 闇€瑕佹煡璇㈢殑寰崥ID銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID姣攕ince_id澶х殑璇勮锛埚嵆姣攕ince_id镞堕棿鏅氱殑璇勮锛夛紝榛樿涓?銆?	 * @param int $max_id  鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮瘎璁猴紝榛樿涓?銆?	 * @param int $filter_by_author 浣滆€呯瓫阃夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭垜鍏虫敞镄勪汉銆?锛氶檶鐢熶汉锛岄粯璁や负0銆?	 * @return array
	 */
	function get_comments_by_sid( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
	{
		$params = array();
		$this->id_format($sid);
		$params['id'] = $sid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		return $this->oauth->get( 'comments/show',  $params );
	}


	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镓€鍙戝嚭镄勮瘎璁哄垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/by_me comments/by_me}
	 *
	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID姣攕ince_id澶х殑璇勮锛埚嵆姣攕ince_id镞堕棿鏅氱殑璇勮锛夛紝榛樿涓?銆?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮瘎璁猴紝榛樿涓?銆?	 * @param int $count  鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $filter_by_source 鏉ユ簮绛涢€夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭潵镊井鍗氱殑璇勮銆?锛氭潵镊井缇ょ殑璇勮锛岄粯璁や负0銆?	 * @return array
	 */
	function comments_by_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0,  $filter_by_source = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/by_me', $params );
	}

	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镓€鎺ユ敹鍒扮殑璇勮鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/to_me comments/to_me}
	 *
	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID姣攕ince_id澶х殑璇勮锛埚嵆姣攕ince_id镞堕棿鏅氱殑璇勮锛夛紝榛樿涓?銆?	 * @param int $max_id  鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮瘎璁猴紝榛樿涓?銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $filter_by_author 浣滆€呯瓫阃夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭垜鍏虫敞镄勪汉銆?锛氶檶鐢熶汉锛岄粯璁や负0銆?	 * @param int $filter_by_source 鏉ユ簮绛涢€夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭潵镊井鍗氱殑璇勮銆?锛氭潵镊井缇ょ殑璇勮锛岄粯璁や负0銆?	 * @return array
	 */ 
	function comments_to_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/to_me', $params );
	}

	/**
	 * 链€鏂拌瘎璁?鎸夋椂闂?
	 *
	 * 杩斿洖链€鏂皀鏉″彂阃佸强鏀跺埌镄勮瘎璁恒€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/timeline comments/timeline}
	 * 
	 * @access public
	 * @param int $page 椤电爜
	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯鍙繑锲滨D姣攕ince_id澶х殑璇勮锛堟瘮since_id鍙戣〃镞堕棿鏅泛级銆傚彲阃夈€?	 * @param int $max_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮瘎璁恒€傚彲阃夈€?	 * @return array
	 */
	function comments_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'comments/timeline', $page, $count, $params );
	}


	/**
	 * 銮峰彇链€鏂扮殑鎻愬埌褰揿墠鐧诲綍鐢ㄦ埛镄勮瘎璁猴紝鍗矦鎴戠殑璇勮
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/mentions comments/mentions}
	 *
	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID姣攕ince_id澶х殑璇勮锛埚嵆姣攕ince_id镞堕棿鏅氱殑璇勮锛夛紝榛樿涓?銆?	 * @param int $max_id  鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勮瘎璁猴紝榛樿涓?銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $filter_by_author  浣滆€呯瓫阃夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭垜鍏虫敞镄勪汉銆?锛氶檶鐢熶汉锛岄粯璁や负0銆?	 * @param int $filter_by_source 鏉ユ簮绛涢€夌被鍨嬶紝0锛氩叏閮ㄣ€?锛氭潵镊井鍗氱殑璇勮銆?锛氭潵镊井缇ょ殑璇勮锛岄粯璁や负0銆?	 * @return array
	 */ 
	function comments_mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
	{
		$params = array();
		$params['since_id'] = $since_id;
		$params['max_id'] = $max_id;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/mentions', $params );
	}


	/**
	 * 镙规嵁璇勮ID镓归噺杩斿洖璇勮淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/show_batch comments/show_batch}
	 *
	 * @param string $cids 闇€瑕佹煡璇㈢殑镓归噺璇勮ID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶?0
	 * @return array
	 */
	function comments_show_batch( $cids )
	{
		$params = array();
		if (is_array( $cids) && !empty( $cids)) {
			foreach($cids as $k => $v) {
				$this->id_format($cids[$k]);
			}
			$params['cids'] = join(',', $cids);
		} else {
			$params['cids'] = $cids;
		}
		return $this->oauth->get( 'comments/show_batch', $params );
	}


	/**
	 * 瀵逛竴鏉″井鍗氲繘琛岃瘎璁?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/create comments/create}
	 *
	 * @param string $comment 璇勮鍐呭锛屽唴瀹逛笉瓒呰绷140涓眽瀛椼€?	 * @param int $id 闇€瑕佽瘎璁虹殑寰崥ID銆?	 * @param int $comment_ori 褰撹瘎璁鸿浆鍙戝井鍗氭椂锛屾槸鍚﹁瘎璁虹粰铡熷井鍗泛紝0锛氩惁銆?锛氭槸锛岄粯璁や负0銆?	 * @return array
	 */
	function send_comment( $id , $comment , $comment_ori = 0)
	{
		$params = array();
		$params['comment'] = $comment;
		$this->id_format($id);
		$params['id'] = $id;
		$params['comment_ori'] = $comment_ori;
		return $this->oauth->post( 'comments/create', $params );
	}

	/**
	 * 鍒犻櫎褰揿墠鐢ㄦ埛镄勫井鍗氲瘎璁轰俊鎭€?	 *
	 * 娉ㄦ剰锛氩彧鑳藉垹闄よ嚜宸卞彂甯幂殑璇勮锛屽彂閮ㄥ井鍗氱殑鐢ㄦ埛涓嶅彲浠ュ垹闄ゅ叾浠栦汉镄勮瘎璁恒€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/statuses/comment_destroy statuses/comment_destroy}
	 * 
	 * @access public
	 * @param int $cid 瑕佸垹闄ょ殑璇勮id
	 * @return array
	 */
	function comment_destroy( $cid )
	{
		$params = array();
		$params['cid'] = $cid;
		return $this->oauth->post( 'comments/destroy', $params);
	}


	/**
	 * 镙规嵁璇勮ID镓归噺鍒犻櫎璇勮
	 *
	 * 娉ㄦ剰锛氩彧鑳藉垹闄よ嚜宸卞彂甯幂殑璇勮锛屽彂閮ㄥ井鍗氱殑鐢ㄦ埛涓嶅彲浠ュ垹闄ゅ叾浠栦汉镄勮瘎璁恒€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/destroy_batch comments/destroy_batch}
	 *
	 * @access public
	 * @param string $ids 闇€瑕佸垹闄ょ殑璇勮ID锛岀敤鍗婅阃楀佛闅斿紑锛屾渶澶?0涓€?	 * @return array
	 */
	function comment_destroy_batch( $ids )
	{
		$params = array();
		if (is_array($ids) && !empty($ids)) {
			foreach($ids as $k => $v) {
				$this->id_format($ids[$k]);
			}
			$params['cids'] = join(',', $ids);
		} else {
			$params['cids'] = $ids;
		}
		return $this->oauth->post( 'comments/destroy_batch', $params);
	}


	/**
	 * 锲炲涓€鏉¤瘎璁?	 *
	 * 涓洪槻姝㈤吨澶嶏紝鍙戝竷镄勪俊鎭笌链€鍚庝竴鏉¤瘎璁?锲炲淇℃伅涓€镙疯瘽锛屽皢浼氲蹇界暐銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/comments/reply comments/reply}
	 * 
	 * @access public
	 * @param int $sid 寰崥id
	 * @param string $text 璇勮鍐呭銆?	 * @param int $cid 璇勮id
	 * @param int $without_mention 1锛氩洖澶崭腑涓嶈嚜锷ㄥ姞鍏モ€滃洖澶岪鐢ㄦ埛鍚嵝€濓紝0锛氩洖澶崭腑镊姩锷犲叆钬滃洖澶岪鐢ㄦ埛鍚嵝€?榛樿涓?.
     * @param int $comment_ori	  褰撹瘎璁鸿浆鍙戝井鍗氭椂锛屾槸鍚﹁瘎璁虹粰铡熷井鍗泛紝0锛氩惁銆?锛氭槸锛岄粯璁や负0銆?	 * @return array
	 */
	function reply( $sid, $text, $cid, $without_mention = 0, $comment_ori = 0 )
	{
		$this->id_format( $sid );
		$this->id_format( $cid );
		$params = array();
		$params['id'] = $sid;
		$params['comment'] = $text;
		$params['cid'] = $cid;
		$params['without_mention'] = $without_mention;
		$params['comment_ori'] = $comment_ori;

		return $this->oauth->post( 'comments/reply', $params );

	}

	/**
	 * 镙规嵁鐢ㄦ埛UID鎴栨樀绉拌幏鍙栫敤鎴疯祫鏂?	 *
	 * 鎸夌敤鎴稶ID鎴栨樀绉拌繑锲炵敤鎴疯祫鏂欙紝鍚屾椂涔熷皢杩斿洖鐢ㄦ埛镄勬渶鏂板彂甯幂殑寰崥銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/users/show users/show}
	 * 
	 * @access public
	 * @param int  $uid 鐢ㄦ埛UID銆?	 * @return array
	 */
	function show_user_by_id( $uid )
	{
		$params=array();
		if ( $uid !== NULL ) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}

		return $this->oauth->get('users/show', $params );
	}
	
	/**
	 * 镙规嵁鐢ㄦ埛UID鎴栨樀绉拌幏鍙栫敤鎴疯祫鏂?	 *
	 * 鎸夌敤鎴稶ID鎴栨樀绉拌繑锲炵敤鎴疯祫鏂欙紝鍚屾椂涔熷皢杩斿洖鐢ㄦ埛镄勬渶鏂板彂甯幂殑寰崥銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/users/show users/show}
	 * 
	 * @access public
	 * @param string  $screen_name 鐢ㄦ埛UID銆?	 * @return array
	 */
	function show_user_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;

		return $this->oauth->get( 'users/show', $params );
	}

	/**
	 * 阃氲绷涓€у寲鍩熷悕銮峰彇鐢ㄦ埛璧勬枡浠ュ强鐢ㄦ埛链€鏂扮殑涓€鏉″井鍗?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/users/domain_show users/domain_show}
	 * 
	 * @access public
	 * @param mixed $domain 鐢ㄦ埛涓€у烟鍚嶃€备緥濡傦细lazypeople锛岃€屼笉鏄痟ttp://weibo.com/lazypeople
	 * @return array
	 */
	function domain_show( $domain )
	{
		$params = array();
		$params['domain'] = $domain;
		return $this->oauth->get( 'users/domain_show', $params );
	}

	 /**
	 * 镓归噺銮峰彇鐢ㄦ埛淇℃伅鎸塽ids
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/users/show_batch users/show_batch}
	 *
	 * @param string $uids 闇€瑕佹煡璇㈢殑鐢ㄦ埛ID锛岀敤鍗婅阃楀佛鍒嗛殧锛屼竴娆℃渶澶?0涓€?	 * @return array
	 */
	function users_show_batch_by_id( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach( $uids as $k => $v ) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'users/show_batch', $params );
	}
	
	/**
	 * 镓归噺銮峰彇鐢ㄦ埛淇℃伅鎸塻creen_name
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/users/show_batch users/show_batch}
	 *
	 * @param string  $screen_name 闇€瑕佹煡璇㈢殑鐢ㄦ埛鏄电О锛岀敤鍗婅阃楀佛鍒嗛殧锛屼竴娆℃渶澶?0涓€?	 * @return array
	 */
	function users_show_batch_by_name( $screen_name )
	{
		$params = array();
		if (is_array( $screen_name ) && !empty( $screen_name )) {
			$params['screen_name'] = join(',', $screen_name);
		} else {
			$params['screen_name'] = $screen_name;
		}
		return $this->oauth->get( 'users/show_batch', $params );
	}


	/**
	 * 銮峰彇鐢ㄦ埛镄勫叧娉ㄥ垪琛?	 *
	 * 濡傛灉娌℃湁鎻愪緵cursor鍙傛暟锛屽皢鍙繑锲炴渶鍓嶉溃镄?000涓叧娉╥d
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends friendships/friends}
	 * 
	 * @access public
	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param int $uid  瑕佽幏鍙栫殑鐢ㄦ埛镄処D銆?	 * @return array
	 */
	function friends_by_id( $uid, $cursor = 0, $count = 50 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['uid'] = $uid;

		return $this->oauth->get( 'friendships/friends', $params );
	}
	
	
	/**
	 * 銮峰彇鐢ㄦ埛镄勫叧娉ㄥ垪琛?	 *
	 * 濡傛灉娌℃湁鎻愪緵cursor鍙傛暟锛屽皢鍙繑锲炴渶鍓嶉溃镄?000涓叧娉╥d
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends friendships/friends}
	 * 
	 * @access public
	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param string $screen_name  瑕佽幏鍙栫殑鐢ㄦ埛镄?screen_name
	 * @return array
	 */
	function friends_by_name( $screen_name, $cursor = 0, $count = 50 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['screen_name'] = $screen_name;
		return $this->oauth->get( 'friendships/friends', $params );
	}


	/**
	 * 銮峰彇涓や釜鐢ㄦ埛涔嬮棿镄勫叡鍚屽叧娉ㄤ汉鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/in_common friendships/friends/in_common}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栧叡鍚屽叧娉ㄥ叧绯荤殑鐢ㄦ埛UID
	 * @param int $suid  闇€瑕佽幏鍙栧叡鍚屽叧娉ㄥ叧绯荤殑鐢ㄦ埛UID锛岄粯璁や负褰揿墠鐧诲綍鐢ㄦ埛銆?	 * @param int $count  鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @return array
	 */
	function friends_in_common( $uid, $suid = NULL, $page = 1, $count = 50 )
	{
		$params = array();
		$params['uid'] = $uid;
		$params['suid'] = $suid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'friendships/friends/in_common', $params  );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勫弻鍚戝叧娉ㄥ垪琛紝鍗充簰绮夊垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/bilateral friendships/friends/bilateral}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栧弻鍚戝叧娉ㄥ垪琛ㄧ殑鐢ㄦ埛UID銆?	 * @param int $count  鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $sort  鎺掑簭绫诲瀷锛?锛氭寜鍏虫敞镞堕棿链€杩戞帓搴忥紝榛樿涓?銆?	 * @return array
	 **/
	function bilateral( $uid, $page = 1, $count = 50, $sort = 0 )
	{
		$params = array();
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['sort'] = $sort;
		return $this->oauth->get( 'friendships/friends/bilateral', $params  );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勫弻鍚戝叧娉╱id鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/bilateral/ids friendships/friends/bilateral/ids}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栧弻鍚戝叧娉ㄥ垪琛ㄧ殑鐢ㄦ埛UID銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $sort  鎺掑簭绫诲瀷锛?锛氭寜鍏虫敞镞堕棿链€杩戞帓搴忥紝榛樿涓?銆?	 * @return array
	 **/
	function bilateral_ids( $uid, $page = 1, $count = 50, $sort = 0)
	{
		$params = array();
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['sort'] = $sort;
		return $this->oauth->get( 'friendships/friends/bilateral/ids',  $params  );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勫叧娉ㄥ垪琛╱id
	 *
	 * 濡傛灉娌℃湁鎻愪緵cursor鍙傛暟锛屽皢鍙繑锲炴渶鍓嶉溃镄?000涓叧娉╥d
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/ids friendships/friends/ids}
	 * 
	 * @access public
	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛埚嵆椤甸溃澶у皬锛夛紝涓嶅ぇ浜?000, 榛樿杩斿洖500銆?	 * @param int $uid 瑕佽幏鍙栫殑鐢ㄦ埛 UID锛岄粯璁や负褰揿墠鐢ㄦ埛
	 * @return array
	 */
	function friends_ids_by_id( $uid, $cursor = 0, $count = 500 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		return $this->oauth->get( 'friendships/friends/ids', $params );
	}
	
	/**
	 * 銮峰彇鐢ㄦ埛镄勫叧娉ㄥ垪琛╱id
	 *
	 * 濡傛灉娌℃湁鎻愪緵cursor鍙傛暟锛屽皢鍙繑锲炴渶鍓嶉溃镄?000涓叧娉╥d
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/ids friendships/friends/ids}
	 * 
	 * @access public
	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛埚嵆椤甸溃澶у皬锛夛紝涓嶅ぇ浜?000, 榛樿杩斿洖500銆?	 * @param string $screen_name 瑕佽幏鍙栫殑鐢ㄦ埛镄?screen_name锛岄粯璁や负褰揿墠鐢ㄦ埛
	 * @return array
	 */
	function friends_ids_by_name( $screen_name, $cursor = 0, $count = 500 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['screen_name'] = $screen_name;
		return $this->oauth->get( 'friendships/friends/ids', $params );
	}


	/**
	 * 镓归噺銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镄勫叧娉ㄤ汉镄勫娉ㄤ俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends/remark_batch friendships/friends/remark_batch}
	 *
	 * @param string $uids  闇€瑕佽幏鍙栧娉ㄧ殑鐢ㄦ埛UID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷50涓€?	 * @return array
	 **/
	function friends_remark_batch( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach( $uids as $k => $v) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'friendships/friends/remark_batch', $params  );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勭蒙涓濆垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param int $uid  闇€瑕佹煡璇㈢殑鐢ㄦ埛UID
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param int $cursor false 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @return array
	 **/
	function followers_by_id( $uid , $cursor = 0 , $count = 50)
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers', $params  );
	}
	
	/**
	 * 銮峰彇鐢ㄦ埛镄勭蒙涓濆垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param string $screen_name  闇€瑕佹煡璇㈢殑鐢ㄦ埛镄勬樀绉?	 * @param int  $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param int  $cursor false 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @return array
	 **/
	function followers_by_name( $screen_name, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers', $params  );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勭蒙涓濆垪琛╱id
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param int $uid 闇€瑕佹煡璇㈢殑鐢ㄦ埛UID
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @return array
	 **/
	function followers_ids_by_id( $uid, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers/ids', $params  );
	}
	
	/**
	 * 銮峰彇鐢ㄦ埛镄勭蒙涓濆垪琛╱id
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param string $screen_name 闇€瑕佹煡璇㈢殑鐢ㄦ埛screen_name
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @return array
	 **/
	function followers_ids_by_name( $screen_name, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers/ids', $params  );
	}

	/**
	 * 銮峰彇浼樿川绮変笣
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/followers/active friendships/followers/active}
	 *
	 * @param int $uid 闇€瑕佹煡璇㈢殑鐢ㄦ埛UID銆?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0锛屾渶澶т笉瓒呰绷200銆?     * @return array
	 **/
	function followers_active( $uid,  $count = 20)
	{
		$param = array();
		$this->id_format($uid);
		$param['uid'] = $uid;
		$param['count'] = $count;
		return $this->oauth->get( 'friendships/followers/active', $param);
	}


	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镄勫叧娉ㄤ汉涓张鍏虫敞浜嗘寚瀹氱敤鎴风殑鐢ㄦ埛鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/friends_chain/followers friendships/friends_chain/followers}
	 *
	 * @param int $uid 鎸囧畾镄勫叧娉ㄧ洰镙囩敤鎴稶ID銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @return array
	 **/
	function friends_chain_followers( $uid, $page = 1, $count = 50 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'friendships/friends_chain/followers',  $params );
	}

	/**
	 * 杩斿洖涓や釜鐢ㄦ埛鍏崇郴镄勮缁嗘儏鍐?	 *
	 * 濡傛灉婧愮敤鎴锋垨鐩殑鐢ㄦ埛涓嶅瓨鍦紝灏呜繑锲瀐ttp镄?00阌栾
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/show friendships/show}
	 * 
	 * @access public
	 * @param mixed $target_id 鐩爣鐢ㄦ埛UID
	 * @param mixed $source_id 婧愮敤鎴稶ID锛屽彲阃夛紝榛樿涓哄綋鍓岖殑鐢ㄦ埛
	 * @return array
	 */
	function is_followed_by_id( $target_id, $source_id = NULL )
	{
		$params = array();
		$this->id_format($target_id);
		$params['target_id'] = $target_id;

		if ( $source_id != NULL ) {
			$this->id_format($source_id);
			$params['source_id'] = $source_id;
		}

		return $this->oauth->get( 'friendships/show', $params );
	}

	/**
	 * 杩斿洖涓や釜鐢ㄦ埛鍏崇郴镄勮缁嗘儏鍐?	 *
	 * 濡傛灉婧愮敤鎴锋垨鐩殑鐢ㄦ埛涓嶅瓨鍦紝灏呜繑锲瀐ttp镄?00阌栾
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/show friendships/show}
	 * 
	 * @access public
	 * @param mixed $target_name 鐩爣鐢ㄦ埛镄勫井鍗氭樀绉?	 * @param mixed $source_name 婧愮敤鎴风殑寰崥鏄电О锛屽彲阃夛紝榛樿涓哄綋鍓岖殑鐢ㄦ埛
	 * @return array
	 */
	function is_followed_by_name( $target_name, $source_name = NULL )
	{
		$params = array();
		$params['target_screen_name'] = $target_name;

		if ( $source_name != NULL ) {
			$params['source_screen_name'] = $source_name;
		}

		return $this->oauth->get( 'friendships/show', $params );
	}

	/**
	 * 鍏虫敞涓€涓敤鎴枫€?	 *
	 * 鎴愬姛鍒栾繑锲炲叧娉ㄤ汉镄勮祫鏂欙紝鐩墠链€澶氩叧娉?000浜猴紝澶辫触鍒栾繑锲炰竴鏉″瓧绗︿覆镄勮鏄庛€傚鏋滃凡缁忓叧娉ㄤ简姝や汉锛屽垯杩斿洖http 403镄勭姸镐并€傚叧娉ㄤ笉瀛桦湪镄処D灏呜繑锲?00銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/create friendships/create}
	 * 
	 * @access public
	 * @param int $uid 瑕佸叧娉ㄧ殑鐢ㄦ埛UID
	 * @return array
	 */
	function follow_by_id( $uid )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		return $this->oauth->post( 'friendships/create', $params );
	}
	
	/**
	 * 鍏虫敞涓€涓敤鎴枫€?	 *
	 * 鎴愬姛鍒栾繑锲炲叧娉ㄤ汉镄勮祫鏂欙紝鐩墠镄勬渶澶氩叧娉?000浜猴紝澶辫触鍒栾繑锲炰竴鏉″瓧绗︿覆镄勮鏄庛€傚鏋滃凡缁忓叧娉ㄤ简姝や汉锛屽垯杩斿洖http 403镄勭姸镐并€傚叧娉ㄤ笉瀛桦湪镄処D灏呜繑锲?00銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/create friendships/create}
	 * 
	 * @access public
	 * @param string $screen_name 瑕佸叧娉ㄧ殑鐢ㄦ埛鏄电О
	 * @return array
	 */
	function follow_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		return $this->oauth->post( 'friendships/create', $params);
	}


	/**
	 * 镙规嵁鐢ㄦ埛UID镓归噺鍏虫敞鐢ㄦ埛
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/create_batch friendships/create_batch}
	 *
	 * @param string $uids 瑕佸叧娉ㄧ殑鐢ㄦ埛UID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷20涓€?	 * @return array
	 */
	function follow_create_batch( $uids )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->post( 'friendships/create_batch', $params);
	}

	/**
	 * 鍙栨秷鍏虫敞镆愮敤鎴?	 *
	 * 鍙栨秷鍏虫敞镆愮敤鎴枫€傛垚锷熷垯杩斿洖琚彇娑埚叧娉ㄤ汉镄勮祫鏂欙紝澶辫触鍒栾繑锲炰竴鏉″瓧绗︿覆镄勮鏄庛€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/destroy friendships/destroy}
	 * 
	 * @access public
	 * @param int $uid 瑕佸彇娑埚叧娉ㄧ殑鐢ㄦ埛UID
	 * @return array
	 */
	function unfollow_by_id( $uid )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		return $this->oauth->post( 'friendships/destroy', $params);
	}
	
	/**
	 * 鍙栨秷鍏虫敞镆愮敤鎴?	 *
	 * 鍙栨秷鍏虫敞镆愮敤鎴枫€傛垚锷熷垯杩斿洖琚彇娑埚叧娉ㄤ汉镄勮祫鏂欙紝澶辫触鍒栾繑锲炰竴鏉″瓧绗︿覆镄勮鏄庛€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/destroy friendships/destroy}
	 * 
	 * @access public
	 * @param string $screen_name 瑕佸彇娑埚叧娉ㄧ殑鐢ㄦ埛鏄电О
	 * @return array
	 */
	function unfollow_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		return $this->oauth->post( 'friendships/destroy', $params);
	}

	/**
	 * 镟存柊褰揿墠鐧诲綍鐢ㄦ埛镓€鍏虫敞镄勬煇涓ソ鍙嬬殑澶囨敞淇℃伅
	 *
	 * 鍙兘淇敼褰揿墠鐧诲綍鐢ㄦ埛镓€鍏虫敞镄勭敤鎴风殑澶囨敞淇℃伅銆傚惁鍒椤皢缁椤嚭400阌栾銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/friendships/remark/update friendships/remark/update}
	 * 
	 * @access public
	 * @param int $uid 闇€瑕佷慨鏀瑰娉ㄤ俊鎭殑鐢ㄦ埛ID銆?	 * @param string $remark 澶囨敞淇℃伅銆?	 * @return array
	 */
	function update_remark( $uid, $remark )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['remark'] = $remark;
		return $this->oauth->post( 'friendships/remark/update', $params);
	}

	/**
	 * 銮峰彇褰揿墠鐢ㄦ埛链€鏂扮淇″垪琛?	 *
	 * 杩斿洖鐢ㄦ埛镄勬渶鏂皀鏉＄淇★紝骞跺寘鍚彂阃佽€呭拰鎺ュ弹钥呯殑璇︾粏璧勬枡銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages direct_messages}
	 * 
	 * @access public
	 * @param int $page 椤电爜
	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆?	 * @param int64 $since_id 杩斿洖ID姣旀暟链约ince_id澶э纸姣攕ince_id镞堕棿鏅氱殑锛夌殑绉佷俊銆傚彲阃夈€?	 * @param int64 $max_id 杩斿洖ID涓嶅ぇ浜漓ax_id(镞堕棿涓嶆櫄浜漓ax_id)镄勭淇°€傚彲阃夈€?	 * @return array
	 */
	function list_dm( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'direct_messages', $page, $count, $params );
	}

	/**
	 * 銮峰彇褰揿墠鐢ㄦ埛鍙戦€佺殑链€鏂扮淇″垪琛?	 *
	 * 杩斿洖鐧诲綍鐢ㄦ埛宸插彂阃佹渶鏂?0鏉＄淇°€傚寘鎷彂阃佽€呭拰鎺ュ弹钥呯殑璇︾粏璧勬枡銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/sent direct_messages/sent}
	 * 
	 * @access public
	 * @param int $page 椤电爜
	 * @param int $count 姣忔杩斿洖镄勬渶澶ц褰曟暟锛屾渶澶氲繑锲?00鏉★紝榛樿50銆?	 * @param int64 $since_id 杩斿洖ID姣旀暟链约ince_id澶э纸姣攕ince_id镞堕棿鏅氱殑锛夌殑绉佷俊銆傚彲阃夈€?	 * @param int64 $max_id 杩斿洖ID涓嶅ぇ浜漓ax_id(镞堕棿涓嶆櫄浜漓ax_id)镄勭淇°€傚彲阃夈€?	 * @return array
	 */
	function list_dm_sent( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'direct_messages/sent', $page, $count, $params );
	}


	/**
	 * 銮峰彇涓庡綋鍓岖橱褰旷敤鎴锋湁绉佷俊寰€鏉ョ殑鐢ㄦ埛鍒楄〃锛屼笌璇ョ敤鎴峰线鏉ョ殑链€鏂扮淇?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/user_list direct_messages/user_list}
	 *
	 * @param int $count  鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $cursor 杩斿洖缁撴灉镄勬父镙囷紝涓嬩竴椤电敤杩斿洖链奸噷镄刵ext_cursor锛屼笂涓€椤电敤previous_cursor锛岄粯璁や负0銆?	 * @return array
	 */
	function dm_user_list( $count = 20, $cursor = 0)
	{
		$params = array();
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'direct_messages/user_list', $params );
	} 

	/**
	 * 銮峰彇涓庢寚瀹氱敤鎴风殑寰€鏉ョ淇″垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/conversation direct_messages/conversation}
	 *
	 * @param int $uid 闇€瑕佹煡璇㈢殑鐢ㄦ埛镄刄ID銆?	 * @param int $since_id 鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID姣攕ince_id澶х殑绉佷俊锛埚嵆姣攕ince_id镞堕棿鏅氱殑绉佷俊锛夛紝榛樿涓?銆?	 * @param int $max_id  鑻ユ寚瀹氭鍙傛暟锛屽垯杩斿洖ID灏忎簬鎴栫瓑浜漓ax_id镄勭淇★紝榛樿涓?銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page  杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @return array
	 */
	function dm_conversation( $uid, $page = 1, $count = 50, $since_id = 0, $max_id = 0)
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'direct_messages/conversation', $params );
	}

	/**
	 * 镙规嵁绉佷俊ID镓归噺銮峰彇绉佷俊鍐呭
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/show_batch direct_messages/show_batch}
	 *
	 * @param string  $dmids 闇€瑕佹煡璇㈢殑绉佷俊ID锛岀敤鍗婅阃楀佛鍒嗛殧锛屼竴娆℃渶澶?0涓?	 * @return array
	 */
	function dm_show_batch( $dmids )
	{
		$params = array();
		if (is_array($dmids) && !empty($dmids)) {
			foreach($dmids as $k => $v) {
				$this->id_format($dmids[$k]);
			}
			$params['dmids'] = join(',', $dmids);
		} else {
			$params['dmids'] = $dmids;
		}
		return $this->oauth->get( 'direct_messages/show_batch',  $params );
	}

	/**
	 * 鍙戦€佺淇?	 *
	 * 鍙戦€佷竴鏉＄淇°€傛垚锷熷皢杩斿洖瀹屾暣镄勫彂阃佹秷鎭€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/new direct_messages/new}
	 * 
	 * @access public
	 * @param int $uid 鐢ㄦ埛UID
	 * @param string $text 瑕佸彂鐢熺殑娑堟伅鍐呭锛屾枃链ぇ灏忓繀椤诲皬浜?00涓眽瀛椼€?	 * @param int $id 闇€瑕佸彂阃佺殑寰崥ID銆?	 * @return array
	 */
	function send_dm_by_id( $uid, $text, $id = NULL )
	{
		$params = array();
		$this->id_format( $uid );
		$params['text'] = $text;
		$params['uid'] = $uid;
		if ($id) {
			$this->id_format( $id );
			$params['id'] = $id;
		}
		return $this->oauth->post( 'direct_messages/new', $params );
	}
	
	/**
	 * 鍙戦€佺淇?	 *
	 * 鍙戦€佷竴鏉＄淇°€傛垚锷熷皢杩斿洖瀹屾暣镄勫彂阃佹秷鎭€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/new direct_messages/new}
	 * 
	 * @access public
	 * @param string $screen_name 鐢ㄦ埛鏄电О
	 * @param string $text 瑕佸彂鐢熺殑娑堟伅鍐呭锛屾枃链ぇ灏忓繀椤诲皬浜?00涓眽瀛椼€?	 * @param int $id 闇€瑕佸彂阃佺殑寰崥ID銆?	 * @return array
	 */
	function send_dm_by_name( $screen_name, $text, $id = NULL )
	{
		$params = array();
		$params['text'] = $text;
		$params['screen_name'] = $screen_name;
		if ($id) {
			$this->id_format( $id );
			$params['id'] = $id;
		}
		return $this->oauth->post( 'direct_messages/new', $params);
	}

	/**
	 * 鍒犻櫎涓€鏉＄淇?	 *
	 * 鎸塈D鍒犻櫎绉佷俊銆傛搷浣灭敤鎴峰繀椤讳负绉佷俊镄勬帴鏀朵汉銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/destroy direct_messages/destroy}
	 * 
	 * @access public
	 * @param int $did 瑕佸垹闄ょ殑绉佷俊涓婚敭ID
	 * @return array
	 */
	function delete_dm( $did )
	{
		$this->id_format($did);
		$params = array();
		$params['id'] = $did;
		return $this->oauth->post('direct_messages/destroy', $params);
	}

	/**
	 * 镓归噺鍒犻櫎绉佷俊
	 *
	 * 镓归噺鍒犻櫎褰揿墠鐧诲綍鐢ㄦ埛镄勭淇°€傚嚭鐜板纾甯告椂锛岃繑锲?00阌栾銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/direct_messages/destroy_batch direct_messages/destroy_batch}
	 * 
	 * @access public
	 * @param mixed $dids 娆插垹闄ょ殑涓€缁勭淇D锛岀敤鍗婅阃楀佛闅斿紑锛屾垨钥呯敱涓€缁勮瘎璁篒D缁勬垚镄勬暟缁勩€傛渶澶?0涓€备緥濡傦细"4976494627, 4976262053"鎴朼rray(4976494627,4976262053);
	 * @return array
	 */
	function delete_dms( $dids )
	{
		$params = array();
		if (is_array($dids) && !empty($dids)) {
			foreach($dids as $k => $v) {
				$this->id_format($dids[$k]);
			}
			$params['ids'] = join(',', $dids);
		} else {
			$params['ids'] = $dids;
		}

		return $this->oauth->post( 'direct_messages/destroy_batch', $params);
	}
	


	/**
	 * 銮峰彇鐢ㄦ埛鍩烘湰淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/basic account/profile/basic}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栧熀链俊鎭殑鐢ㄦ埛UID锛岄粯璁や负褰揿墠鐧诲綍鐢ㄦ埛銆?	 * @return array
	 */
	function account_profile_basic( $uid = NULL  )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/basic', $params );
	}

	/**
	 * 銮峰彇鐢ㄦ埛镄勬暀镶蹭俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/education account/profile/education}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栨暀镶蹭俊鎭殑鐢ㄦ埛UID锛岄粯璁や负褰揿墠鐧诲綍鐢ㄦ埛銆?	 * @return array
	 */
	function account_education( $uid = NULL )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/education', $params );
	}

	/**
	 * 镓归噺銮峰彇鐢ㄦ埛镄勬暀镶蹭俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/education_batch account/profile/education_batch}
	 *
	 * @param string $uids 闇€瑕佽幏鍙栨暀镶蹭俊鎭殑鐢ㄦ埛UID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷20銆?	 * @return array
	 */
	function account_education_batch( $uids  )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}

		return $this->oauth->get( 'account/profile/education_batch', $params );
	}


	/**
	 * 銮峰彇鐢ㄦ埛镄勮亴涓氢俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/career account/profile/career}
	 *
	 * @param int $uid  闇€瑕佽幏鍙栨暀镶蹭俊鎭殑鐢ㄦ埛UID锛岄粯璁や负褰揿墠鐧诲綍鐢ㄦ埛銆?	 * @return array
	 */
	function account_career( $uid = NULL )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/career', $params );
	}

	/**
	 * 镓归噺銮峰彇鐢ㄦ埛镄勮亴涓氢俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/career_batch account/profile/career_batch}
	 *
	 * @param string $uids 闇€瑕佽幏鍙栨暀镶蹭俊鎭殑鐢ㄦ埛UID锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷20銆?	 * @return array
	 */
	function account_career_batch( $uids )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}

		return $this->oauth->get( 'account/profile/career_batch', $params );
	}

	/**
	 * 銮峰彇闅愮淇℃伅璁剧疆鎯呭喌
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/get_privacy account/get_privacy}
	 * 
	 * @access public
	 * @return array
	 */
	function get_privacy()
	{
		return $this->oauth->get('account/get_privacy');
	}

	/**
	 * 銮峰彇镓€链夌殑瀛︽牎鍒楄〃
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/school_list account/profile/school_list}
	 *
	 * @param array $query 鎼灭储阃夐」銆傛牸寮忥细array('key0'=>'value0', 'key1'=>'value1', ....)銆傛敮鎸佺殑key:
	 *  - province	int		鐪佷唤锣冨洿锛岀渷浠绌D銆?	 *  - city		int		鍩庡竞锣冨洿锛屽煄甯局D銆?	 *  - area		int		鍖哄烟锣冨洿锛屽尯ID銆?	 *  - type		int		瀛︽牎绫诲瀷锛?锛氩ぇ瀛︺€?锛氶佩涓€?锛氢腑涓撴妧镙°€?锛氩垵涓€?锛氩皬瀛︼紝榛樿涓?銆?	 *  - capital	string	瀛︽牎棣栧瓧姣嶏紝榛樿涓篈銆?	 *  - keyword	string	瀛︽牎鍚岖О鍏抽敭瀛椼€?	 *  - count		int		杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * 鍙傛暟keyword涓巆apital浜岃€呭繀阃夊叾涓€锛屼笖鍙兘阃夊叾涓€銆傛寜棣栧瓧姣峜apital镆ヨ镞讹紝蹇呴』鎻愪緵province鍙傛暟銆?	 * @access public
	 * @return array
	 */
	function school_list( $query )
	{
		$params = $query;

		return $this->oauth->get( 'account/profile/school_list', $params );
	}

	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镄凙PI璁块棶棰戠巼闄愬埗鎯呭喌
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/rate_limit_status account/rate_limit_status}
	 * 
	 * @access public
	 * @return array
	 */
	function rate_limit_status()
	{
		return $this->oauth->get( 'account/rate_limit_status' );
	}

	/**
	 * OAuth鎺堟潈涔嫔悗锛岃幏鍙栨巿鏉幂敤鎴风殑UID
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/get_uid account/get_uid}
	 * 
	 * @access public
	 * @return array
	 */
	function get_uid()
	{
		return $this->oauth->get( 'account/get_uid' );
	}


	/**
	 * 镟存敼鐢ㄦ埛璧勬枡
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/basic_update account/profile/basic_update}
	 * 
	 * @access public
	 * @param array $profile 瑕佷慨鏀圭殑璧勬枡銆傛牸寮忥细array('key1'=>'value1', 'key2'=>'value2', .....)銆?	 * 鏀寔淇敼镄勯」锛?	 *  - screen_name		string	鐢ㄦ埛鏄电О锛屼笉鍙负绌恒€?	 *  - gender	i		string	鐢ㄦ埛镐у埆锛宫锛氱敺銆乫锛氩コ锛屼笉鍙负绌恒€?	 *  - real_name			string	鐢ㄦ埛鐪熷疄濮揿悕銆?	 *  - real_name_visible	int		鐪熷疄濮揿悕鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - province	true	int		鐪佷唤浠ｇ爜ID锛屼笉鍙负绌恒€?	 *  - city	true		int		鍩庡竞浠ｇ爜ID锛屼笉鍙负绌恒€?	 *  - birthday			string	鐢ㄦ埛鐢熸棩锛屾牸寮忥细yyyy-mm-dd銆?	 *  - birthday_visible	int		鐢熸棩鍙锣冨洿锛?锛氢缭瀵嗐€?锛氩彧鏄剧ず链堟棩銆?锛氩彧鏄剧ず鏄熷骇銆?锛氭墍链変汉鍙銆?	 *  - qq				string	鐢ㄦ埛QQ鍙风爜銆?	 *  - qq_visible		int		鐢ㄦ埛QQ鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - msn				string	鐢ㄦ埛MSN銆?	 *  - msn_visible		int		鐢ㄦ埛MSN鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - url				string	鐢ㄦ埛鍗氩鍦板潃銆?	 *  - url_visible		int		鐢ㄦ埛鍗氩鍦板潃鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - credentials_type	int		璇佷欢绫诲瀷锛?锛氲韩浠借瘉銆?锛氩鐢熻瘉銆?锛氩啗瀹樿瘉銆?锛氭姢镦с€?	 *  - credentials_num	string	璇佷欢鍙风爜銆?	 *  - email				string	鐢ㄦ埛甯哥敤闾鍦板潃銆?	 *  - email_visible		int		鐢ㄦ埛甯哥敤闾鍦板潃鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - lang				string	璇█鐗堟湰锛寊h_cn锛氱亩浣扑腑鏂囥€亃h_tw锛氱箒浣扑腑鏂囥€?	 *  - description		string	鐢ㄦ埛鎻忚堪锛屾渶闀夸笉瓒呰绷70涓眽瀛椼€?	 * 濉啓birthday鍙傛暟镞讹紝锅氩涓嬬害瀹泛细
	 *  - 鍙～骞翠唤镞讹紝閲囩敤1986-00-00镙煎纺锛?	 *  - 鍙～链堜唤镞讹紝閲囩敤0000-08-00镙煎纺锛?	 *  - 鍙～镆愭棩镞讹紝閲囩敤0000-00-28镙煎纺銆?	 * @return array
	 */
	function update_profile( $profile )
	{
		return $this->oauth->post( 'account/profile/basic_update',  $profile);
	}


	/**
	 * 璁剧疆鏁栾偛淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/edu_update account/profile/edu_update}
	 * 
	 * @access public
	 * @param array $edu_update 瑕佷慨鏀圭殑瀛︽牎淇℃伅銆傛牸寮忥细array('key1'=>'value1', 'key2'=>'value2', .....)銆?	 * 鏀寔璁剧疆镄勯」锛?	 *  - type			int		瀛︽牎绫诲瀷锛?锛氩ぇ瀛︺€?锛氶佩涓€?锛氢腑涓撴妧镙°€?锛氩垵涓€?锛氩皬瀛︼紝榛樿涓?銆傚繀濉弬鏁?	 *  - school_id	`	int		瀛︽牎浠ｇ爜锛屽繀濉弬鏁?	 *  - id			string	闇€瑕佷慨鏀圭殑鏁栾偛淇℃伅ID锛屼笉浼犲垯涓烘柊寤猴紝浼犲垯涓烘洿鏂般€?	 *  - year			int		鍏ュ骞翠唤锛屾渶灏忎负1900锛屾渶澶т笉瓒呰绷褰揿墠骞翠唤
	 *  - department	string	闄㈢郴鎴栬€呯彮鍒€?	 *  - visible		int		寮€鏀剧瓑绾э紝0锛氢粎镊繁鍙銆?锛氩叧娉ㄧ殑浜哄彲瑙并€?锛氭墍链変汉鍙銆?	 * @return array
	 */
	function edu_update( $edu_update )
	{
		return $this->oauth->post( 'account/profile/edu_update',  $edu_update);
	}

	/**
	 * 镙规嵁瀛︽牎ID鍒犻櫎鐢ㄦ埛镄勬暀镶蹭俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/edu_destroy account/profile/edu_destroy}
	 * 
	 * @param int $id 鏁栾偛淇℃伅閲岀殑瀛︽牎ID銆?	 * @return array
	 */
	function edu_destroy( $id )
	{
		$this->id_format( $id );
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'account/profile/edu_destroy', $params);
	}

	/**
	 * 璁剧疆鑱屼笟淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/car_update account/profile/car_update}
	 * 
	 * @param array $car_update 瑕佷慨鏀圭殑鑱屼笟淇℃伅銆傛牸寮忥细array('key1'=>'value1', 'key2'=>'value2', .....)銆?	 * 鏀寔璁剧疆镄勯」锛?	 *  - id			string	闇€瑕佹洿鏂扮殑鑱屼笟淇℃伅ID銆?	 *  - start			int		杩涘叆鍏徃骞翠唤锛屾渶灏忎负1900锛屾渶澶т负褰揿勾骞翠唤銆?	 *  - end			int		绂诲紑鍏徃骞翠唤锛岃呖浠婂～0銆?	 *  - department	string	宸ヤ綔閮ㄩ棬銆?	 *  - visible		int		鍙锣冨洿锛?锛氲嚜宸卞彲瑙并€?锛氩叧娉ㄤ汉鍙銆?锛氭墍链変汉鍙銆?	 *  - province		int		鐪佷唤浠ｇ爜ID锛屼笉鍙负绌哄€笺€?	 *  - city			int		鍩庡竞浠ｇ爜ID锛屼笉鍙负绌哄€笺€?	 *  - company		string	鍏徃鍚岖О锛屼笉鍙负绌哄€笺€?	 * 鍙傛暟province涓巆ity浜岃€呭繀阃夊叾涓€<br />
	 * 鍙傛暟id涓虹┖锛屽垯涓烘柊寤鸿亴涓氢俊鎭紝鍙傛暟company鍙树负蹇呭～椤癸紝鍙傛暟id闱炵┖锛屽垯涓烘洿鏂帮紝鍙傛暟company鍙€?	 * @return array
	 */
	function car_update( $car_update )
	{
		return $this->oauth->post( 'account/profile/car_update', $car_update);
	}

	/**
	 * 镙规嵁鍏徃ID鍒犻櫎鐢ㄦ埛镄勮亴涓氢俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/profile/car_destroy account/profile/car_destroy}
	 * 
	 * @access public
	 * @param int $id  鑱屼笟淇℃伅閲岀殑鍏徃ID
	 * @return array
	 */
	function car_destroy( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'account/profile/car_destroy', $params);
	}

	/**
	 * 镟存敼澶村儚
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/avatar/upload account/avatar/upload}
	 *
	 * @param string $image_path 瑕佷笂浼犵殑澶村儚璺缎, 鏀寔url銆俒鍙敮鎸乸ng/jpg/gif涓夌镙煎纺, 澧炲姞镙煎纺璇蜂慨鏀筭et_image_mime鏂规硶] 蹇呴』涓哄皬浜?00K镄勬湁鏁堢殑GIF, JPG锲剧墖. 濡傛灉锲剧墖澶т簬500镀忕礌灏嗘寜姣斾緥缂╂斁銆?	 * @return array
	 */
	function update_profile_image( $image_path )
	{
		$params = array();
		$params['image'] = "@{$image_path}";

		return $this->oauth->post('account/avatar/upload', $params);
	}

	/**
	 * 璁剧疆闅愮淇℃伅
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/account/update_privacy account/update_privacy}
	 * 
	 * @param array $privacy_settings 瑕佷慨鏀圭殑闅愮璁剧疆銆傛牸寮忥细array('key1'=>'value1', 'key2'=>'value2', .....)銆?	 * 鏀寔璁剧疆镄勯」锛?	 *  - comment	int	鏄惁鍙互璇勮鎴戠殑寰崥锛?锛氭墍链変汉銆?锛氩叧娉ㄧ殑浜猴紝榛樿涓?銆?	 *  - geo		int	鏄惁寮€鍚湴鐞嗕俊鎭紝0锛氢笉寮€鍚€?锛氩紑鍚紝榛樿涓?銆?	 *  - message	int	鏄惁鍙互缁欐垜鍙戠淇★紝0锛氭墍链変汉銆?锛氩叧娉ㄧ殑浜猴紝榛樿涓?銆?	 *  - realname	int	鏄惁鍙互阃氲绷鐪熷悕鎼灭储鍒版垜锛?锛氢笉鍙互銆?锛氩彲浠ワ紝榛樿涓?銆?	 *  - badge		int	鍕嬬珷鏄惁鍙锛?锛氢笉鍙銆?锛氩彲瑙侊紝榛樿涓?銆?	 *  - mobile	int	鏄惁鍙互阃氲绷镓嬫満鍙风爜鎼灭储鍒版垜锛?锛氢笉鍙互銆?锛氩彲浠ワ紝榛樿涓?銆?	 * 浠ヤ笂鍙傛暟鍏ㄩ儴阃夊～
	 * @return array
	 */
	function update_privacy( $privacy_settings )
	{
		return $this->oauth->post( 'account/update_privacy', $privacy_settings);
	}


	/**
	 * 銮峰彇褰揿墠鐢ㄦ埛镄勬敹钘忓垪琛?	 *
	 * 杩斿洖鐢ㄦ埛镄勫彂甯幂殑链€杩?0鏉℃敹钘忎俊鎭紝鍜岀敤鎴锋敹钘忛〉闱㈣繑锲炲唴瀹规槸涓€镊寸殑銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites favorites}
	 * 
	 * @access public
	 * @param  int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param  int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @return array
	 */
	function get_favorites( $page = 1, $count = 50 )
	{
		$params = array();
		$params['page'] = intval($page);
		$params['count'] = intval($count);

		return $this->oauth->get( 'favorites', $params );
	}


	/**
	 * 镙规嵁鏀惰棌ID銮峰彇鎸囧畾镄勬敹钘忎俊鎭?	 *
	 * 镙规嵁鏀惰棌ID銮峰彇鎸囧畾镄勬敹钘忎俊鎭€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/show favorites/show}
	 * 
	 * @access public
	 * @param int $id 闇€瑕佹煡璇㈢殑鏀惰棌ID銆?	 * @return array
	 */
	function favorites_show( $id )
	{
		$params = array();
		$this->id_format($id);
		$params['id'] = $id;
		return $this->oauth->get( 'favorites/show', $params );
	}


	/**
	 * 镙规嵁镙囩銮峰彇褰揿墠鐧诲綍鐢ㄦ埛璇ユ爣绛句笅镄勬敹钘忓垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/by_tags favorites/by_tags}
	 *
	 * 
	 * @param int $tid  闇€瑕佹煡璇㈢殑镙囩ID銆?
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @return array
	 */
	function favorites_by_tags( $tid, $page = 1, $count = 50)
	{
		$params = array();
		$params['tid'] = $tid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'favorites/by_tags', $params );
	}


	/**
	 * 銮峰彇褰揿墠鐧诲綍鐢ㄦ埛镄勬敹钘忔爣绛惧垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/tags favorites/tags}
	 * 
	 * @access public
	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @return array
	 */
	function favorites_tags( $page = 1, $count = 50)
	{
		$params = array();
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'favorites/tags', $params );
	}


	/**
	 * 鏀惰棌涓€鏉″井鍗氢俊鎭?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/create favorites/create}
	 * 
	 * @access public
	 * @param int $sid 鏀惰棌镄勫井鍗歩d
	 * @return array
	 */
	function add_to_favorites( $sid )
	{
		$this->id_format($sid);
		$params = array();
		$params['id'] = $sid;

		return $this->oauth->post( 'favorites/create', $params );
	}

	/**
	 * 鍒犻櫎寰崥鏀惰棌銆?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/destroy favorites/destroy}
	 * 
	 * @access public
	 * @param int $id 瑕佸垹闄ょ殑鏀惰棌寰崥淇℃伅ID.
	 * @return array
	 */
	function remove_from_favorites( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'favorites/destroy', $params);
	}


	/**
	 * 镓归噺鍒犻櫎寰崥鏀惰棌銆?	 *
	 * 镓归噺鍒犻櫎褰揿墠鐧诲綍鐢ㄦ埛镄勬敹钘忋€傚嚭鐜板纾甯告椂锛岃繑锲潍TTP400阌栾銆?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/destroy_batch favorites/destroy_batch}
	 * 
	 * @access public
	 * @param mixed $fids 娆插垹闄ょ殑涓€缁勭淇D锛岀敤鍗婅阃楀佛闅斿紑锛屾垨钥呯敱涓€缁勮瘎璁篒D缁勬垚镄勬暟缁勩€傛渶澶?0涓€备緥濡傦细"231101027525486630,201100826122315375"鎴朼rray(231101027525486630,201100826122315375);
	 * @return array
	 */
	function remove_from_favorites_batch( $fids )
	{
		$params = array();
		if (is_array($fids) && !empty($fids)) {
			foreach ($fids as $k => $v) {
				$this->id_format($fids[$k]);
			}
			$params['ids'] = join(',', $fids);
		} else {
			$params['ids'] = $fids;
		}

		return $this->oauth->post( 'favorites/destroy_batch', $params);
	}


	/**
	 * 镟存柊涓€鏉℃敹钘忕殑鏀惰棌镙囩
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/tags/update favorites/tags/update}
	 * 
	 * @access public
	 * @param int $id 闇€瑕佹洿鏂扮殑鏀惰棌ID銆?	 * @param string $tags 闇€瑕佹洿鏂扮殑镙囩鍐呭锛岀敤鍗婅阃楀佛鍒嗛殧锛屾渶澶氢笉瓒呰绷2鏉°€?	 * @return array
	 */
	function favorites_tags_update( $id,  $tags )
	{
		$params = array();
		$params['id'] = $id;
		if (is_array($tags) && !empty($tags)) {
			foreach ($tags as $k => $v) {
				$this->id_format($tags[$k]);
			}
			$params['tags'] = join(',', $tags);
		} else {
			$params['tags'] = $tags;
		}
		return $this->oauth->post( 'favorites/tags/update', $params );
	}

	/**
	 * 镟存柊褰揿墠鐧诲綍鐢ㄦ埛镓€链夋敹钘忎笅镄勬寚瀹氭爣绛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/tags/update_batch favorites/tags/update_batch}
	 *
	 * @param int $tid  闇€瑕佹洿鏂扮殑镙囩ID銆傚繀濉?	 * @param string $tag  闇€瑕佹洿鏂扮殑镙囩鍐呭銆傚繀濉?	 * @return array
	 */
	function favorites_update_batch( $tid, $tag )
	{
		$params = array();
		$params['tid'] = $tid;
		$params['tag'] = $tag;
		return $this->oauth->post( 'favorites/tags/update_batch', $params);
	}

	/**
	 * 鍒犻櫎褰揿墠鐧诲綍鐢ㄦ埛镓€链夋敹钘忎笅镄勬寚瀹氭爣绛?	 *
	 * 鍒犻櫎镙囩鍚庯紝璇ョ敤鎴锋墍链夋敹钘忎腑锛屾坊锷犱简璇ユ爣绛剧殑鏀惰棌鍧囱В闄や笌璇ユ爣绛剧殑鍏宠仈鍏崇郴
	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/favorites/tags/destroy_batch favorites/tags/destroy_batch}
	 *
	 * @param int $tid  闇€瑕佹洿鏂扮殑镙囩ID銆傚繀濉?	 * @return array
	 */
	function favorites_tags_destroy_batch( $tid )
	{
		$params = array();
		$params['tid'] = $tid;
		return $this->oauth->post( 'favorites/tags/destroy_batch', $params);
	}

	/**
	 * 銮峰彇镆愮敤鎴风殑璇濋
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends trends}
	 * 
	 * @param int $uid 镆ヨ鐢ㄦ埛镄処D銆傞粯璁や负褰揿墠鐢ㄦ埛銆傚彲阃夈€?	 * @param int $page 鎸囧畾杩斿洖缁撴灉镄勯〉镰并€傚彲阃夈€?	 * @param int $count 鍗曢〉澶у皬銆傜己鐪佸€?0銆傚彲阃夈€?	 * @return array
	 */
	function get_trends( $uid = NULL, $page = 1, $count = 10 )
	{
		$params = array();
		if ($uid) {
			$params['uid'] = $uid;
		} else {
			$user_info = $this->get_uid();
			$params['uid'] = $user_info['uid'];
		}
		$this->id_format( $params['uid'] );
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'trends', $params );
	}


	/**
	 * 鍒ゆ柇褰揿墠鐢ㄦ埛鏄惁鍏虫敞镆愯瘽棰?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/is_follow trends/is_follow}
	 * 
	 * @access public
	 * @param string $trend_name 璇濋鍏抽敭瀛椼€?	 * @return array
	 */
	function trends_is_follow( $trend_name )
	{
		$params = array();
		$params['trend_name'] = $trend_name;
		return $this->oauth->get( 'trends/is_follow', $params );
	}

	/**
	 * 杩斿洖链€杩戜竴灏忔椂鍐呯殑鐑棬璇濋
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/hourly trends/hourly}
	 * 
	 * @param  int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?琛ㄧず鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹紝榛樿涓?銆傚彲阃夈€?	 * @return array
	 */
	function hourly_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/hourly', $params );
	}

	/**
	 * 杩斿洖链€杩戜竴澶╁唴镄勭儹闂ㄨ瘽棰?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/daily trends/daily}
	 * 
	 * @param int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?琛ㄧず鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹紝榛樿涓?銆傚彲阃夈€?	 * @return array
	 */
	function daily_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/daily', $params );
	}

	/**
	 * 杩斿洖链€杩戜竴锻ㄥ唴镄勭儹闂ㄨ瘽棰?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/weekly trends/weekly}
	 * 
	 * @access public
	 * @param int $base_app 鏄惁鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹€?琛ㄧず鍩轰簬褰揿墠搴旗敤鏉ヨ幏鍙栨暟鎹紝榛樿涓?銆傚彲阃夈€?	 * @return array
	 */
	function weekly_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/weekly', $params );
	}

	/**
	 * 鍏虫敞镆愯瘽棰?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/follow trends/follow}
	 * 
	 * @access public
	 * @param string $trend_name 瑕佸叧娉ㄧ殑璇濋鍏抽敭璇嶃€?	 * @return array
	 */
	function follow_trends( $trend_name )
	{
		$params = array();
		$params['trend_name'] = $trend_name;
		return $this->oauth->post( 'trends/follow', $params );
	}

	/**
	 * 鍙栨秷瀵规煇璇濋镄勫叧娉?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/trends/destroy trends/destroy}
	 * 
	 * @access public
	 * @param int $tid 瑕佸彇娑埚叧娉ㄧ殑璇濋ID銆?	 * @return array
	 */
	function unfollow_trends( $tid )
	{
		$this->id_format($tid);

		$params = array();
		$params['trend_id'] = $tid;

		return $this->oauth->post( 'trends/destroy', $params );
	}

	/**
	 * 杩斿洖鎸囧畾鐢ㄦ埛镄勬爣绛惧垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags tags}
	 * 
	 * @param int $uid 镆ヨ鐢ㄦ埛镄処D銆傞粯璁や负褰揿墠鐢ㄦ埛銆傚彲阃夈€?	 * @param int $page 鎸囧畾杩斿洖缁撴灉镄勯〉镰并€傚彲阃夈€?	 * @param int $count 鍗曢〉澶у皬銆傜己鐪佸€?0锛屾渶澶у€?00銆傚彲阃夈€?	 * @return array
	 */
	function get_tags( $uid = NULL, $page = 1, $count = 20 )
	{
		$params = array();
		if ( $uid ) {
			$params['uid'] = $uid;
		} else {
			$user_info = $this->get_uid();
			$params['uid'] = $user_info['uid'];
		}
		$this->id_format( $params['uid'] );
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'tags', $params );
	}

	/**
	 * 镓归噺銮峰彇鐢ㄦ埛镄勬爣绛惧垪琛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags/tags_batch tags/tags_batch}
	 * 
	 * @param  string $uids 瑕佽幏鍙栨爣绛剧殑鐢ㄦ埛ID銆傛渶澶?0锛岄€楀佛鍒嗛殧銆傚繀濉?	 * @return array
	 */
	function get_tags_batch( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach ($uids as $k => $v) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'tags/tags_batch', $params );
	}

	/**
	 * 杩斿洖鐢ㄦ埛镒熷叴瓒ｇ殑镙囩
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags/suggestions tags/suggestions}
	 * 
	 * @access public
	 * @param int $count 鍗曢〉澶у皬銆傜己鐪佸€?0锛屾渶澶у€?0銆傚彲阃夈€?	 * @return array
	 */
	function get_suggest_tags( $count = 10)
	{
		$params = array();
		$params['count'] = intval($count);
		return $this->oauth->get( 'tags/suggestions', $params );
	}

	/**
	 * 涓哄綋鍓岖橱褰旷敤鎴锋坊锷犳柊镄勭敤鎴锋爣绛?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags/create tags/create}
	 * 
	 * @access public
	 * @param mixed $tags 瑕佸垱寤虹殑涓€缁勬爣绛撅紝姣忎釜镙囩镄勯昵搴︿笉鍙秴杩?涓眽瀛楋紝14涓崐瑙掑瓧绗︺€傚涓爣绛句箣闂寸敤阃楀佛闂撮殧锛屾垨鐢卞涓爣绛炬瀯鎴愮殑鏁扮粍銆傚锛?abc,drf,efgh,tt"鎴朼rray("abc", "drf", "efgh", "tt")
	 * @return array
	 */
	function add_tags( $tags )
	{
		$params = array();
		if (is_array($tags) && !empty($tags)) {
			$params['tags'] = join(',', $tags);
		} else {
			$params['tags'] = $tags;
		}
		return $this->oauth->post( 'tags/create', $params);
	}

	/**
	 * 鍒犻櫎镙囩
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags/destroy tags/destroy}
	 * 
	 * @access public
	 * @param int $tag_id 镙囩ID锛屽繀濉弬鏁?	 * @return array
	 */
	function delete_tag( $tag_id )
	{
		$params = array();
		$params['tag_id'] = $tag_id;
		return $this->oauth->post( 'tags/destroy', $params );
	}

	/**
	 * 镓归噺鍒犻櫎镙囩
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/tags/destroy_batch tags/destroy_batch}
	 * 
	 * @access public
	 * @param mixed $ids 蹇呴€夊弬鏁帮紝瑕佸垹闄ょ殑tag id锛屽涓猧d鐢ㄥ崐瑙掗€楀佛鍒嗗壊锛屾渶澶?0涓€傛垨鐢卞涓猼ag id鏋勬垚镄勬暟缁勩€傚锛气€?53,554,555"鎴朼rray(553, 554, 555)
	 * @return array
	 */
	function delete_tags( $ids )
	{
		$params = array();
		if (is_array($ids) && !empty($ids)) {
			$params['ids'] = join(',', $ids);
		} else {
			$params['ids'] = $ids;
		}
		return $this->oauth->post( 'tags/destroy_batch', $params );
	}


	/**
	 * 楠岃瘉鏄电О鏄惁鍙敤锛屽苟缁欎篑寤鸿鏄电О
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/register/verify_nickname register/verify_nickname}
	 *
	 * @param string $nickname 闇€瑕侀獙璇佺殑鏄电О銆?-20涓瓧绗︼紝鏀寔涓嫳鏂囥€佹暟瀛椼€?_"鎴栧噺鍙枫€傚繀濉?	 * @return array
	 */
	function verify_nickname( $nickname )
	{
		$params = array();
		$params['nickname'] = $nickname;
		return $this->oauth->get( 'register/verify_nickname', $params );
	}



	/**
	 * 鎼灭储鐢ㄦ埛镞剁殑鑱旀兂鎼灭储寤鸿
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/suggestions/users search/suggestions/users}
	 *
	 * @param string $q 鎼灭储镄勫叧阌瓧锛屽繀椤诲仛URLencoding銆傚繀濉?涓棿链€濂戒笉瑕佸嚭鐜扮┖镙?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @return array
	 */
	function search_users( $q,  $count = 10 )
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/users',  $params );
	}


	/**
	 * 鎼灭储寰崥镞剁殑鑱旀兂鎼灭储寤鸿
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/suggestions/statuses search/suggestions/statuses}
	 *
	 * @param string $q 鎼灭储镄勫叧阌瓧锛屽繀椤诲仛URLencoding銆傚繀濉?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @return array
	 */
	function search_statuses( $q,  $count = 10)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/statuses', $params );
	}


	/**
	 * 鎼灭储瀛︽牎镞剁殑鑱旀兂鎼灭储寤鸿
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/suggestions/schools search/suggestions/schools}
	 *
	 * @param string $q 鎼灭储镄勫叧阌瓧锛屽繀椤诲仛URLencoding銆傚繀濉?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int type 瀛︽牎绫诲瀷锛?锛氩叏閮ㄣ€?锛氩ぇ瀛︺€?锛氶佩涓€?锛氢腑涓撴妧镙°€?锛氩垵涓€?锛氩皬瀛︼紝榛樿涓?銆傞€夊～
	 * @return array
	 */
	function search_schools( $q,  $count = 10,  $type = 1)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		$params['type'] = $type;
		return $this->oauth->get( 'search/suggestions/schools', $params );
	}

	/**
	 * 鎼灭储鍏徃镞剁殑鑱旀兂鎼灭储寤鸿
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/suggestions/companies search/suggestions/companies}
	 *
	 * @param string $q 鎼灭储镄勫叧阌瓧锛屽繀椤诲仛URLencoding銆傚繀濉?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @return array
	 */
	function search_companies( $q, $count = 10)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/companies', $params );
	}


	/**
	 * 锛犵敤鎴锋椂镄勮仈鎯冲缓璁?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/suggestions/at_users search/suggestions/at_users}
	 *
	 * @param string $q 鎼灭储镄勫叧阌瓧锛屽繀椤诲仛URLencoding銆傚繀濉?	 * @param int $count 杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @param int $type 鑱旀兂绫诲瀷锛?锛氩叧娉ㄣ€?锛氱蒙涓濄€傚繀濉?	 * @param int $range 鑱旀兂锣冨洿锛?锛氩彧鑱旀兂鍏虫敞浜恒€?锛氩彧鑱旀兂鍏虫敞浜虹殑澶囨敞銆?锛氩叏閮紝榛樿涓?銆傞€夊～
	 * @return array
	 */
	function search_at_users( $q, $count = 10, $type=0, $range = 2)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		$params['type'] = $type;
		$params['range'] = $range;
		return $this->oauth->get( 'search/suggestions/at_users', $params );
	}


	


	/**
	 * 鎼灭储涓庢寚瀹氱殑涓€涓垨澶氢釜鏉′欢鐩稿尮閰岖殑寰崥
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/statuses search/statuses}
	 *
	 * @param array $query 鎼灭储阃夐」銆傛牸寮忥细array('key0'=>'value0', 'key1'=>'value1', ....)銆傛敮鎸佺殑key:
	 *  - q				string	鎼灭储镄勫叧阌瓧锛屽繀椤昏繘琛孶RLencode銆?	 *  - filter_ori	int		杩囨护鍣紝鏄惁涓哄师鍒涳紝0锛氩叏閮ㄣ€?锛氩师鍒涖€?锛氲浆鍙戯紝榛樿涓?銆?	 *  - filter_pic	int		杩囨护鍣ㄣ€傛槸鍚﹀寘鍚浘鐗囷紝0锛氩叏閮ㄣ€?锛氩寘鍚€?锛氢笉鍖呭惈锛岄粯璁や负0銆?	 *  - fuid			int		鎼灭储镄勫井鍗氢綔钥呯殑鐢ㄦ埛UID銆?	 *  - province		int		鎼灭储镄勭渷浠借寖锲达紝鐪佷唤ID銆?	 *  - city			int		鎼灭储镄勫煄甯傝寖锲达紝鍩庡竞ID銆?	 *  - starttime		int		寮€濮嬫椂闂达紝Unix镞堕棿鎴炽€?	 *  - endtime		int		缁撴潫镞堕棿锛孶nix镞堕棿鎴炽€?	 *  - count			int		鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 *  - page			int		杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 *  - needcount		boolean	杩斿洖缁撴灉涓槸鍚﹀寘鍚繑锲炶褰曟暟锛宼rue锛氲繑锲炪€乫alse锛氢笉杩斿洖锛岄粯璁や负false銆?	 *  - base_app		int		鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * needcount鍙傛暟涓嶅悓锛屼细瀵艰嚧鐩稿簲镄勮繑锲炲€肩粨鏋勪笉鍚?	 * 浠ヤ笂鍙傛暟鍏ㄩ儴阃夊～
	 * @return array
	 */
	function search_statuses_high( $query )
	{
		return $this->oauth->get( 'search/statuses', $query );
	}



	/**
	 * 阃氲绷鍏抽敭璇嶆悳绱㈢敤鎴?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/search/users search/users}
	 *
	 * @param array $query 鎼灭储阃夐」銆傛牸寮忥细array('key0'=>'value0', 'key1'=>'value1', ....)銆傛敮鎸佺殑key:
	 *  - q			string	鎼灭储镄勫叧阌瓧锛屽繀椤昏繘琛孶RLencode銆?	 *  - snick		int		鎼灭储锣冨洿鏄惁鍖呭惈鏄电О锛?锛氢笉鍖呭惈銆?锛氩寘鍚€?	 *  - sdomain	int		鎼灭储锣冨洿鏄惁鍖呭惈涓€у烟鍚嶏紝0锛氢笉鍖呭惈銆?锛氩寘鍚€?	 *  - sintro	int		鎼灭储锣冨洿鏄惁鍖呭惈绠€浠嬶紝0锛氢笉鍖呭惈銆?锛氩寘鍚€?	 *  - stag		int		鎼灭储锣冨洿鏄惁鍖呭惈镙囩锛?锛氢笉鍖呭惈銆?锛氩寘鍚€?	 *  - province	int		鎼灭储镄勭渷浠借寖锲达紝鐪佷唤ID銆?	 *  - city		int		鎼灭储镄勫煄甯傝寖锲达紝鍩庡竞ID銆?	 *  - gender	string	鎼灭储镄勬€у埆锣冨洿锛宫锛氱敺銆乫锛氩コ銆?	 *  - comorsch	string	鎼灭储镄勫叕鍙稿镙″悕绉般€?	 *  - sort		int		鎺掑簭鏂瑰纺锛?锛氭寜镟存柊镞堕棿銆?锛氭寜绮変笣鏁帮紝榛樿涓?銆?	 *  - count		int		鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 *  - page		int		杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 *  - base_app	int		鏄惁鍙幏鍙栧綋鍓嶅簲鐢ㄧ殑鏁版嵁銆?涓哄惁锛堟墍链夋暟鎹级锛?涓烘槸锛堜粎褰揿墠搴旗敤锛夛紝榛樿涓?銆?	 * 浠ヤ笂镓€链夊弬鏁板叏閮ㄩ€夊～
	 * @return array
	 */
	function search_users_keywords( $query )
	{
		return $this->oauth->get( 'search/users', $query );
	}



	/**
	 * 銮峰彇绯荤粺鎺ㄨ崘鐢ㄦ埛
	 *
	 * 杩斿洖绯荤粺鎺ㄨ崘镄勭敤鎴峰垪琛ㄣ€?	 * <br />瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/suggestions/users/hot suggestions/users/hot}
	 * 
	 * @access public
	 * @param string $category 鍒嗙被锛屽彲阃夊弬鏁帮紝杩斿洖镆愪竴绫诲埆镄勬帹钻愮敤鎴凤紝榛樿涓?default銆傚鏋滀笉鍦ㄤ互涓嫔垎绫讳腑锛岃繑锲炵┖鍒楄〃锛?br />
	 *  - default:浜烘皵鍏虫敞
	 *  - ent:褰辫鍚嶆槦
	 *  - hk_famous:娓彴鍚崭汉
	 *  - model:妯＄壒
	 *  - cooking:缇庨&锅ュ悍
	 *  - sport:浣撹偛鍚崭汉
	 *  - finance:鍟嗙晫鍚崭汉
	 *  - tech:IT浜掕仈缃?	 *  - singer:姝屾坠
	 *  - writer锛氢綔瀹?	 *  - moderator:涓绘寔浜?	 *  - medium:濯掍綋镐荤紪
	 *  - stockplayer:镣掕偂楂樻坠
	 * @return array
	 */
	function hot_users( $category = "default" )
	{
		$params = array();
		$params['category'] = $category;

		return $this->oauth->get( 'suggestions/users/hot', $params );
	}

	/**
	 * 銮峰彇鐢ㄦ埛鍙兘镒熷叴瓒ｇ殑浜?	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/suggestions/users/may_interested suggestions/users/may_interested}
	 * 
	 * @access public
	 * @param int $page 杩斿洖缁撴灉镄勯〉镰侊紝榛樿涓?銆?	 * @param int $count 鍗曢〉杩斿洖镄勮褰曟浔鏁帮紝榛樿涓?0銆?	 * @return array
	 * @ignore
	 */
	function suggestions_may_interested( $page = 1, $count = 10 )
	{   
		$params = array();
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'suggestions/users/may_interested', $params);
	}

	/**
	 * 镙规嵁涓€娈靛井鍗氭鏂囨帹钻愮浉鍏冲井鍗氱敤鎴枫€?
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/suggestions/users/by_status suggestions/users/by_status}
	 * 
	 * @access public
	 * @param string $content 寰崥姝ｆ枃鍐呭銆?	 * @param int $num 杩斿洖缁撴灉鏁扮洰锛岄粯璁や负10銆?	 * @return array
	 */
	function suggestions_users_by_status( $content, $num = 10 )
	{
		$params = array();
		$params['content'] = $content;
		$params['num'] = $num;
		return $this->oauth->get( 'suggestions/users/by_status', $params);
	}

	/**
	 * 鐑棬鏀惰棌
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/suggestions/favorites/hot suggestions/favorites/hot}
	 *
	 * @param int $count 姣忛〉杩斿洖缁撴灉鏁帮紝榛樿20銆傞€夊～
	 * @param int $page 杩斿洖椤电爜锛岄粯璁?銆傞€夊～
	 * @return array
	 */
	function hot_favorites( $page = 1, $count = 20 )
	{
		$params = array();
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'suggestions/favorites/hot', $params);
	}

	/**
	 * 鎶婃煇浜烘爣璇嗕负涓嶆劅鍏磋叮镄勪汉
	 *
	 * 瀵瑰簲API锛殁@link http://open.weibo.com/wiki/2/suggestions/users/not_interested suggestions/users/not_interested}
	 *
	 * @param int $uid 涓嶆劅鍏磋叮镄勭敤鎴风殑UID銆?	 * @return array
	 */
	function put_users_not_interested( $uid )
	{
		$params = array();
		$params['uid'] = $uid;
		return $this->oauth->post( 'suggestions/users/not_interested', $params);
	}



	// =========================================

	/**
	 * @ignore
	 */
	protected function request_with_pager( $url, $page = false, $count = false, $params = array() )
	{
		if( $page ) $params['page'] = $page;
		if( $count ) $params['count'] = $count;

		return $this->oauth->get($url, $params );
	}

	/**
	 * @ignore
	 */
	protected function request_with_uid( $url, $uid_or_name, $page = false, $count = false, $cursor = false, $post = false, $params = array())
	{
		if( $page ) $params['page'] = $page;
		if( $count ) $params['count'] = $count;
		if( $cursor )$params['cursor'] =  $cursor;

		if( $post ) $method = 'post';
		else $method = 'get';

		if ( $uid_or_name !== NULL ) {
			$this->id_format($uid_or_name);
			$params['id'] = $uid_or_name;
		}

		return $this->oauth->$method($url, $params );

	}

	/**
	 * @ignore
	 */
	protected function id_format(&$id) {
		if ( is_float($id) ) {
			$id = number_format($id, 0, '', '');
		} elseif ( is_string($id) ) {
			$id = trim($id);
		}
	}

}

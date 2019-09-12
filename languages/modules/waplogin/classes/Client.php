<?php

require_once(dirname(__FILE__) . '/Util.php');
/**
 * OAuth鍗忚鎺ュ彛
 *
 * 渚濊禆锛?
 * PHP 5 >= 5.1.2, PECL hash >= 1.1 (no need now)
 * 
 * @ignore
 * @author icehu@vip.qq.com
 *
 */

class OpenSDK_OAuth_Client
{
	/**
	 * 绛惧悕镄剈rl镙囩
	 * @var string
	 */
	public $oauth_signature_key = 'oauth_signature';

	/**
	 * app secret
	 * @var string
	 */
	protected $_app_secret = '';

	/**
	 * token secret
	 * @var string
	 */
	protected $_token_secret = '';

	/**
	 * 涓娄竴娆¤姹傝繑锲炵殑Httpcode
	 * @var number
	 */
	protected $_httpcode = null;

	/**
	 * 鏄惁debug
	 * @var bool
	 */
	protected $_debug = false;

	public function  __construct( $appsecret='' , $debug=false)
	{
		$this->_app_secret = $appsecret;
		$this->_debug = $debug;
	}
	/**
	 * 璁剧疆App secret
	 * @param string $appsecret
	 */
	public function setAppSecret($appsecret)
	{
		$this->_app_secret = $appsecret;
	}

	/**
	 * 璁剧疆token secret
	 * @param string $tokensecret
	 */
	public function setTokenSecret($tokensecret)
	{
		$this->_token_secret = $tokensecret;
	}

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
		$oauth_signature = $this->sign($url, $method, $params);
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
	protected function sign( $url , $method, $params )
	{
		uksort($params, 'strcmp');
		$pairs = array();
        foreach($params as $key => $value)
        {
			$key = OpenSDK_Util::urlencode_rfc3986($key);
            if(is_array($value))
            {
                // If two or more parameters share the same name, they are sorted by their value
                // Ref: Spec: 9.1.1 (1)
                natsort($value);
                foreach($value as $duplicate_value)
                {
                    $pairs[] = $key . '=' . OpenSDK_Util::urlencode_rfc3986($duplicate_value);
                }
            }
            else
            {
                $pairs[] = $key . '=' . OpenSDK_Util::urlencode_rfc3986($value);
            }
        }
		
        $sign_parts = OpenSDK_Util::urlencode_rfc3986(implode('&', $pairs));
		
		$base_string = implode('&', array( strtoupper($method) , OpenSDK_Util::urlencode_rfc3986($url) , $sign_parts ));

        $key_parts = array(OpenSDK_Util::urlencode_rfc3986($this->_app_secret), OpenSDK_Util::urlencode_rfc3986($this->_token_secret));

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
	 * Http璇锋眰鎺ュ彛
	 * 
	 * @param string $url
	 * @param array $params
	 * @param string $method 鏀寔 GET / POST / DELETE
	 * @param false|array $multi false:鏅€歱ost array: array ( '{fieldname}'=>'/path/to/file' ) 鏂囦欢涓娄紶
	 * @return string
	 */
	protected function http( $url , $params , $method='GET' , $multi=false )
	{
		$method = strtoupper($method);
		$postdata = '';
		$urls = @parse_url($url);
		$httpurl = $urlpath = $urls['path'] . ($urls['query'] ? '?' . $urls['query'] : '');
		if( !$multi )
		{
			$parts = array();
			foreach ($params as $key => $val)
			{
				$parts[] = urlencode($key) . '=' . urlencode($val);
			}
			if ($parts)
			{
				$postdata = implode('&', $parts);
				$httpurl = $httpurl . (strpos($httpurl, '?') ? '&' : '?') . $postdata;
			}
			else
			{
			}
		}
		
		$host = $urls['host'];
		$port = $urls['port'] ? $urls['port'] : 80;
		$version = '1.1';
		if($urls['scheme'] === 'https')
        {
            $port = 443;
        }
		$headers = array();
		if($method == 'GET')
		{
			$headers[] = "GET $httpurl HTTP/$version";
		}
		else if($method == 'DELETE')
		{
			$headers[] = "DELETE $httpurl HTTP/$version";
		}
		else
		{
			$headers[] = "POST $urlpath HTTP/$version";
		}
		$headers[] = 'Host: ' . $host;
		$headers[] = 'User-Agent: OpenSDK-OAuth';
		$headers[] = 'Connection: Close';

		if($method == 'POST')
		{
			if($multi)
			{
				$boundary = uniqid('------------------');
				$MPboundary = '--' . $boundary;
				$endMPboundary = $MPboundary . '--';
				$multipartbody = '';
				$headers[]= 'Content-Type: multipart/form-data; boundary=' . $boundary;
				foreach($params as $key => $val)
				{
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'Content-Disposition: form-data; name="' . $key . "\"\r\n\r\n";
					$multipartbody .= $val . "\r\n";
				}
				foreach($multi as $key => $path)
				{
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'Content-Disposition: form-data; name="' . $key . '"; filename="' . pathinfo($path, PATHINFO_BASENAME) . '"' . "\r\n";
					$multipartbody .= 'Content-Type: ' . self::get_image_mime($path) . "\r\n\r\n";
					$multipartbody .= file_get_contents($path) . "\r\n";
				}
				$multipartbody .= $endMPboundary . "\r\n";
				$postdata = $multipartbody;
			}
			else
			{
				$headers[]= 'Content-Type: application/x-www-form-urlencoded';
			}
		}
        $ret = '';
        $fp = fsockopen($host, $port, $errno, $errstr, 5);

        if(! $fp)
        {
            $error = 'Open Socket Error';
			return '';
        }
        else
        {
			if( $method != 'GET' && $postdata )
			{
				$headers[] = 'Content-Length: ' . strlen($postdata);
			}
            $this->fwrite($fp, implode("\r\n", $headers));
			$this->fwrite($fp, "\r\n\r\n");
			if( $method != 'GET' && $postdata )
			{
				$this->fwrite($fp, $postdata);
			}
			//skip headers
            while(! feof($fp))
            {
                $ret .= fgets($fp, 1024);
            }
			if($this->_debug)
			{
				echo $ret;
			}
			fclose($fp);
			$pos = strpos($ret, "\r\n\r\n");
			if($pos)
			{
				$rt = trim(substr($ret , $pos+1));
				$responseHead = trim(substr($ret, 0 , $pos));
				$responseHeads = explode("\r\n", $responseHead);
				$httpcode = explode(' ', $responseHeads[0]);
				$this->_httpcode = $httpcode[1];
				if(strpos( substr($ret , 0 , $pos), 'Transfer-Encoding: chunked'))
				{
					$response = explode("\r\n", $rt);
					$t = array_slice($response, 1, - 1);

					return implode('', $t);
				}
				return $rt;
			}
			return '';
        }
	}

	public static function get_image_mime( $file )
    {
    	$ext = strtolower(pathinfo( $file , PATHINFO_EXTENSION ));
    	switch( $ext )
    	{
    		case 'jpg':
    		case 'jpeg':
    			$mime = 'image/jpg';
    			break;
    		case 'png';
    			$mime = 'image/png';
    			break;
    		case 'gif';
    		default:
    			$mime = 'image/gif';
    			break;
    	}
    	return $mime;
    }

	/**
	 * 杩斿洖涓娄竴娆¤姹傜殑httpCode
	 * @return number 
	 */
	public function getHttpCode()
	{
		return $this->_httpcode;
	}

	protected function fwrite($handle,$data)
	{
		fwrite($handle, $data);
		if($this->_debug)
		{
			echo $data;
		}
	}
}

<?php
/**
 * 生成流水号
 */
function create_sn(){
	mt_srand((double )microtime() * 1000000 );
	return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}

function return_url($code, $method = 'notify') {
    return PASSPORT_PATH.'api/pay_'.$method.'_'.$code.'.shtml';
}

/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

/**
 * 页面地址跳转
 * @param type $url 目标地址
 * @param type $name 倒计时
 * @return type
 */
function redirect($url, $time = 0) {
    if (!headers_sent()) {
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
        }
        exit();
    } else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        exit($str);
    }
}

/**
 * URL生成
 * @param string $name 路由地址（[模块名]/[控制器名]/方法名）
 * @param mixed $param 附加参数
 * @return string
 */
function url($name, $param = '') {
    $url = (is_ssl() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'];
    $vars = explode("/", $name);
    $params['view'] = array_pop($vars);
    $params['controller'] = array_pop($vars);
    $params['app'] = array_pop($vars);
    krsort($params);
    if ($param && is_string($param)) parse_str($param,$param);
    if ($param) $params = array_merge($params, $param);
    return $url.'/index.php?'.http_build_query($params);
}

/**
 * 
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return 产生的随机字符串
 */
function getNonceStr($length = 32) 
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {  
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
    } 
    return $str;
}

function unserialize_config($cfg){
    if (is_string($cfg) ) {
        $arr = string2array($cfg);
		$config = array();
		foreach ($arr AS $key => $val) {
			$config[$key] = $val['value'];
		}
		return $config;
	} else {
		return false;
	}
}
/**
 * 返回订单状态
 */
function return_status($status) {
	$trade_status = array('0'=>'succ', '1'=>'failed', '2'=>'timeout', '3'=>'progress', '4'=>'unpay', '5'=>'cancel','6'=>'error');
	return $trade_status[$status];
}
/**
 * 返回订单手续费
 * @param  $amount 订单价格
 * @param  $fee 手续费比率
 * @param  $method 手续费方式
 */
function pay_fee($amount, $fee=0, $method=0) {
    $pay_fee = 0;
    if($method == 0) {
    	$val = floatval($fee) / 100;
    	$pay_fee = $val > 0 ? $amount * $val : 0;
    } elseif($method == 1) {
        $pay_fee = $fee;
    }
    return round($pay_fee, 2);
}

/**
 * 生成支付按钮
 * @param $data 按钮数据
 * @param $attr 按钮属性 如样式等
 * @param $ishow 是否显示描述
 */
function mk_pay_btn($data,$attr='class="payment-show"',$ishow='1') {
	$pay_type = '';
	if(is_array($data)){
		foreach ($data as $v) {
			$pay_type .= '<label '.$attr.'>';
			$pay_type .='<input name="pay_type" type="radio" value="'.$v['pay_id'].'"> <em>'.$v['name'].'</em>';
			$pay_type .=$ishow ? '<span class="payment-desc">'.$v['pay_desc'].'</span>' :'';
			$pay_type .= '</label>';
		}
	}
	return $pay_type;
}


/*WY add at 2018-07-08*/
/**
 * 生成签名结果
 * @param $array要加密的数组
 * @param return 签名结果字符串
*/
function build_mysign($sort_array,$security_code,$sign_type = "MD5", $issort = TRUE) {
    if($issort == TRUE) {
        $sort_array = arg_sort($sort_array);
    }
    $security_code = ltrim($security_code);
    $prestr = create_linkstring($sort_array);
    $prestr = $prestr.$security_code;
    $mysgin = sign($prestr,$sign_type);
    return $mysgin;
}


/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $array 需要拼接的数组
 * @param return 拼接完成以后的字符串
*/
function create_linkstring($array, $encode = FALSE) {
        $arg  = "";
        $quotes = '';
        if($encode){
            $quotes = '"';
        }
        foreach ($array as $key => $val) {
            if($arg == ''){
                $arg = $key.'='.$quotes.$val.$quotes;
            }else{
                $arg = $arg.'&'.$key.'='.$quotes.$val.$quotes;
            }
        }
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
}

/********************************************************************************/

/**除去数组中的空值和签名参数
 * @param $parameter 加密参数组
 * @param return 去掉空值与签名参数后的新加密参数组
 */
function para_filter($parameter) {
    $para = array();
        foreach ($parameter as $key => $val) { 
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else    $para[$key] = $parameter[$key];
    }
    return $para;
}

/********************************************************************************/

/**对数组排序
 * @param $array 排序前的数组
 * @param return 排序后的数组
 */
function arg_sort($array) {
    $array = para_filter($array);
    ksort($array);
    reset($array);
    return $array;
}

/********************************************************************************/

/**加密字符串
 * @param $prestr 需要加密的字符串
 * @param return 加密结果
 */
function sign($prestr,$sign_type) {
    return md5($prestr);
}

/*
*xml to array
*/
function xmlToArray($xml) {
    $array_data = json_decode(json_encode((array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

/*
*array to xml
*/
function arrayToXml($arr) {
    $xml = "<xml>";
    foreach ($arr as $key=>$val) {
         $xml.="<".$key.">".$val."</".$key.">";
    }
    $xml.="</xml>";
    return $xml;
}


function getHttpResponsePOST($url, $para, $input_charset = 'utf-8') {
    if (trim($input_charset) != '') {
        $url = $url."_input_charset=".$input_charset;
    }
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//严格认证
    curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
    curl_setopt($curl,CURLOPT_POST,true); // post传输数据
    curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
    $responseText = curl_exec($curl);
    //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    return $responseText;
}
?>
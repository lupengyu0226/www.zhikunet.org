<?php
feitian_error();
//防护脚本版本号
define("FEITIAN_VERSION", '0.1.3.4');
//防护脚本MD5值
define("FEITIAN_MD5", md5(@file_get_contents(__FILE__)));
//get拦截规则
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//post拦截规则
$postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//cookie拦截规则
$cookiefilter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//获取指令
$feitian_action  = isset($_POST['feitian_act'])&&feitian_cheack() ? trim($_POST['feitian_act']) : '';
//referer获取
$feitian_referer = empty($_SERVER['HTTP_REFERER']) ? array() : array('HTTP_REFERER'=>$_SERVER['HTTP_REFERER']);

class feitian_http {

  var $method;
  var $post;
  var $header;
  var $ContentType;

  function __construct() {
    $this->method = '';
    $this->cookie = '';
    $this->post = '';
    $this->header = '';
    $this->errno = 0;
    $this->errstr = '';
  }

  function post($url, $data = array(), $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $this->method = 'POST';
    $this->ContentType = "Content-Type: application/x-www-form-urlencoded\r\n";
    if($data) {
      $post = '';
      foreach($data as $k=>$v) {
        $post .= $k.'='.rawurlencode($v).'&';
      }
      $this->post .= substr($post, 0, -1);
    }
    return $this->request($url, $referer, $limit, $timeout, $block);
  }

  function request($url, $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : ($matches['scheme']=='https' ? 443 : 80);
    if($referer == '') $referer = URL;
    $out = "$this->method $path HTTP/1.1\r\n";
    $out .= "Accept: */*\r\n";
    $out .= "Referer: $referer\r\n";
    $out .= "Accept-Language: zh-cn\r\n";
    $out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
    $out .= "Host: $host\r\n";
    if($this->method == 'POST') {
      $out .= $this->ContentType;
      $out .= "Content-Length: ".strlen($this->post)."\r\n";
      $out .= "Cache-Control: no-cache\r\n";
      $out .= "Connection: Close\r\n\r\n";
      $out .= $this->post;
    } else {
      $out .= "Connection: Close\r\n\r\n";
    }
    if($timeout > ini_get('max_execution_time')) @set_time_limit($timeout);
    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
    $this->post = '';
    if(!$fp) {
      return false;
    } else {
      stream_set_blocking($fp, $block);
      stream_set_timeout($fp, $timeout);
      fwrite($fp, $out);
      $this->data = '';
      $status = stream_get_meta_data($fp);
      if(!$status['timed_out']) {
        $maxsize = min($limit, 1024000);
        if($maxsize == 0) $maxsize = 1024000;
        $start = false;
        while(!feof($fp)) {
          if($start) {
            $line = fread($fp, $maxsize);
            if(strlen($this->data) > $maxsize) break;
            $this->data .= $line;
          } else {
            $line = fgets($fp);
            $this->header .= $line;
            if($line == "\r\n" || $line == "\n") $start = true;
          }
        }
      }
      fclose($fp);
      return "200";
    }
  }

}

/**
 *   关闭用户错误提示
 */
function feitian_error() {
  if (ini_get('display_errors')) {
    ini_set('display_errors', '0');
  }
}

/**
 *  验证是否是官方发出的请求
 */
function feitian_cheack() {
  if($_POST['feitian_rkey']==FEITIAN_KEY){
    return true;
  }
  return false;
}
/**
 *  数据统计回传
 */
function feitian_slog($logs) {
  if(! function_exists('curl_init')) {
    $http=new feitian_http();
    $http->post(FEITIAN_API,$logs);
  }
  else{
    feitian_curl(FEITIAN_API,$logs);
  }
}
/**
 *  参数拆分
 */
function feitian_arr_foreach($arr) {
  static $str;
  static $keystr;
  if (!is_array($arr)) {
    return $arr;
  }
  foreach ($arr as $key => $val ) {
    $keystr=$keystr.$key;
    if (is_array($val)) {

      feitian_arr_foreach($val);
    } else {

      $str[] = $val.$keystr;
    }
  }
  return implode($str);
}
/**
 *  新版文件md5值效验
 */
function feitian_updateck($ve) {
  if($ve!=FEITIAN_MD5)
  {
    return true;
  }
  return false;
}

/**
 *  防护提示页
 */
function feitian_pape(){
  $pape=<<<HTML
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>提示信息</title>
<style type="text/css">
*{padding:0; margin:0; font:12px/1.5 Microsoft Yahei;}
a:link,a:visited{text-decoration:none;color:#000}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{background: #fff; zoom:1; width:450px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px;border-radius: 2px;box-shadow: 1px 1px 50px rgba(0,0,0,.3);}
.showMsg h5{padding: 17px 15px;color:#fff;background: #3B4658;font-size:14px;border-radius: 2px;}
.showMsg .content{padding: 45px;line-height: 24px;word-break: break-all;overflow: hidden;font-size: 14px;overflow-x: hidden;overflow-y: auto;}
.showMsg .bottom{padding: 10px;text-align: center;border-top: 1px solid #E9E7E7;}
.showMsg .ok,.showMsg .guery{background: url(//statics.zhikunet.org/statics/images/msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
</style>
<script type="text/javaScript" src="//statics.zhikunet.org/statics/js/jquery.js"></script>
<script language="JavaScript" src="//statics.zhikunet.org/statics/js/admin_common.js"></script>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5>提示信息</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px">你输入的参数已被飞天系统拦截</div>
    <div class="bottom">
    	如果你的浏览器没有自动跳转，<a href="https://www.zhikunet.org/">请点击这里</a>
			<script language="javascript">setTimeout("redirect('https://www.zhikunet.org/');",1250);</script> 
			        </div>
</div>
<script style="text/javascript">
	function close_dialog() {
		window.top.location.reload();window.top.art.dialog({id:""}).close();
	}
</script>
</body>
</html>
HTML;
  echo $pape;
}

/**
 *  攻击检查拦截
 */
function feitian_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq,$method) {
  $StrFiltValue=feitian_arr_foreach($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
    feitian_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'wangzhi' =>$_SERVER["HTTP_HOST"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltValue,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    exit(feitian_pape());
  }
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
    feitian_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'wangzhi' =>$_SERVER["HTTP_HOST"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltKey,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    exit(feitian_pape());
  }

}
/**
 *  拦截目录白名单
 */
function feitian_white($feitian_white_name,$feitian_white_url=array()) {
  $url_path=$_SERVER['SCRIPT_NAME'];
  //拼接获取
  foreach($_GET as $key=>$value){
    $url_var.=$key."=".$value."&";
  }

  if (preg_match("/".$feitian_white_name."/is",$url_path)==1&&!empty($feitian_white_name)) {
    return false;
  }
  foreach ($feitian_white_url as $key => $value) {
    if(!empty($url_var)&&!empty($value)){
      if (stristr($url_path,$key)&&stristr($url_var,$value)) {
        return false;
      }
    }
    elseif (empty($url_var)&&empty($value)) {
      if (stristr($url_path,$key)) {
        return false;
      }
    }

  }

  return true;
}

/**
 *  curl方式提交
 */
function feitian_curl($url , $postdata = array()){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  $response = curl_exec($ch);
  $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
  curl_close($ch);
  return array('httpcode'=>$httpcode,'response'=>$response);
}
if ($feitian_switch&&feitian_white($feitian_white_directory,$feitian_white_url)) {
  if ($feitian_get) {
    foreach($_GET as $key=>$value) {
      feitian_StopAttack($key,$value,$getfilter,"GET");
    }
  }
  if ($feitian_post) {
    foreach($_POST as $key=>$value) {
      feitian_StopAttack($key,$value,$postfilter,"POST");
    }
  }
  if ($feitian_cookie) {
    foreach($_COOKIE as $key=>$value) {
      feitian_StopAttack($key,$value,$cookiefilter,"COOKIE");
    }
  }
  if ($feitian_referre) {
    foreach($feitian_referer as $key=>$value) {
      feitian_StopAttack($key,$value,$postfilter,"REFERRER");
    }
  }
}

?>
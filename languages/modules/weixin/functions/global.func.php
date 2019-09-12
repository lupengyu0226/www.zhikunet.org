<?php
/**************************************************************
 *
 *	微信接口处理函数，可以根据微信的不同接口存取数据
 *	@access public
 *
 *************************************************************/
function https_request($url,$data = null){
	  $curl = curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	  if (!empty($data)){
		  curl_setopt($curl, CURLOPT_POST, 1);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	  }
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  $output = curl_exec($curl);
	  curl_close($curl);
	  return $output;
}

//获取菜单接口密匙$access_token
function get_access_token(){
		//微信基本设置
		$setting = getcache('weixin_setting','commons');//微信access_token存放文件
		//$token = getcache('weixin','commons');//微信配置文件
		//$appid =$token[1]['appid'];
        //$secret =$token[1]['appsecret'];
		//if($setting['lasttime']<=SYS_TIME){
		//	$get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
		//	$ch = curl_init();
		//	curl_setopt($ch,CURLOPT_URL,$get_token_url);
		//	curl_setopt($ch,CURLOPT_HEADER,0);
		//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		//	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		//	$res = curl_exec($ch);
		//	curl_close($ch);
		//	$at_json = json_decode($res,true);
		//	$setting=array();
        //   $setting['access_token']=$at_json['access_token'];
        //    $setting['ticket']=$ticket;
		//	$setting['lasttime']=SYS_TIME+7150;
		//	setcache('weixin_setting', $setting, 'commons');
		//	$setting=getcache('weixin_setting','commons');
        //}
        $yixin = get_yixin_access_token();
		$accesstoken=$setting['access_token'];
		return $accesstoken;
  }
function get_xzh_token(){
		//获取熊掌号 token 缓存文件
		$setting = getcache('xzh_setting','commons');
		$accesstoken=$setting['access_token'];
		return $accesstoken;
  }
//获取菜单接口密匙$access_token
function get_yixin_access_token(){
            //易信基本设置
		$setting = getcache('yixin_setting','commons');//微信access_token存放文件
		$yixintoken = getcache('weixin','commons');
        $yixin_appid =$yixintoken[1]['yixin_appid'];
        $yixin_secret =$yixintoken[1]['yixin_appsecret'];
		if($setting['lasttime']<=SYS_TIME){
            $get_token_url = 'https://api.yixin.im/cgi-bin/token?grant_type=client_credential&appid='.$yixin_appid.'&secret='.$yixin_secret;            
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$get_token_url);
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			$res = curl_exec($ch);
			curl_close($ch);
			$at_json = json_decode($res,true);
			$setting=array();
           $setting['access_token']=$at_json['access_token'];
			$setting['lasttime']=SYS_TIME+7200;
            setcache('yixin_setting', $setting, 'commons');
            $setting=getcache('yixin_setting','commons');
        }
		$accesstoken=$setting['access_token'];
		return $accesstoken;
  }

  function get_json_result($url,$jsondata){
	  if(is_access_token()){
		 $result = https_request($url,$jsondata);
	  }
	  return $result?$result:false;
  }
 /**************************************************************
 *
 *	微信
 *	获取用户分组列表
 *  array
 *************************************************************/
  function get_group_arr(){
	 $access_token=get_access_token();
	 if($access_token){
	   $url="https://api.weixin.qq.com/cgi-bin/groups/get?access_token=".$access_token;
	   $result = https_request($url);
	   $group_info_arr=json_decode($result, true);
		$group_arr=$group_info_arr['groups'];
	   return $group_arr;
    }else{
	   return false;	
	}
 }
 /**************************************************************
 *
 *	微信
 *	获取用户openid列表
 *  array
 *************************************************************/
 function get_openid_arr(){
	 $access_token=get_access_token();
	 if($access_token){
	   $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token;
	   $result = https_request($url);
	   $userlist_arr=json_decode($result, true);
	   $openid_arr=$userlist_arr['data']['openid'];
	   return $openid_arr;
    }else{
	   return false;	
	}
 }
/**************************************************************
 *
 *	微信
 *	获取(单个)用户信息
 *
 *************************************************************/
 function get_userinfo($openid){
	 $access_token=get_access_token();
	 if($access_token){
	  $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
	   $result = https_request($url);
       $userinfo_arr=json_decode($result, true);
	   return $userinfo_arr;
    }else{
	   return false;	
	}
 }
 /**************************************************************
 *
 *	熊掌号
 *	获取(单个)用户信息
 *
 *************************************************************/
 function get_xzh_userinfo($openid){
        $access_token=get_xzh_token();
        if($access_token){
        $url="https://openapi.baidu.com/rest/2.0/cambrian/user/info?access_token=".$access_token;
        $json = sprintf('{"user_list":[{"openid":"%s"}]}',$openid);
        $result = https_request($url,$json);
        $userinfo_arr=json_decode($result, true);
        return $userinfo_arr;
    }else{
	    return false;	
	}
 }
/**************************************************************
 *
 *	易信
 *	获取(单个)用户信息
 *
 *************************************************************/
 function get_yixin_userinfo($openid){
	 $access_token=get_yixin_access_token();
	 if($access_token){
	  $url="https://api.yixin.im/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
	   $result = https_request($url);
	   $userinfo_arr=json_decode($result, true);
	   
	   return $userinfo_arr;
    }else{
	   return false;	
	}
 }
function weixindump($vars, $label = '', $return = false){

    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}
/**************************************************************
 *
 *	使用特定function对数组中所有元素做处理
 *	@param	string	&$array	 要处理的字符串
 *	@param	string	$function	要执行的函数
 *	@return boolean	$apply_to_keys_also	 是否也应用到key上
 *	@access public
 *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
 
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}
 
/**************************************************************
 *
 *	将数组转换为JSON字符串（兼容中文）
 *	@param	array	$array	 要转换的数组
 *	@return string	 转换得到的json字符串
 *	@access public
 *
 *************************************************************/
function JSON($array) {
 arrayRecursive($array, 'urlencode', true);
 $json = json_encode($array);
 return urldecode($json);
}
/**************************************************************
 *
 *	判断客服工作时间
 *	@param	工作时间1，非工作时间0
 *
 *************************************************************/
function get_time_section(){
    $kefuwork = getcache('weixin','commons');//微信配置文件
    $kefus =$kefuwork[1]['kefus'];//客服上班时间
    $kefux =$kefuwork[1]['kefux'];//客服下班时间
    $checkDayStr = date('Y-m-d ',time());
    $timeBegin1 = strtotime($checkDayStr.$kefus.":00");
    $timeEnd1 = strtotime($checkDayStr.$kefux.":00");
    $curr_time = time();
	if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1){
	return "1";
	}
	return "0";
}
/**************************************************************
 *
 *	输出树状无限分类列表
 *
 *************************************************************/
function showCate($array){
    $tree = array();
    if( $array ){
        foreach ( $array as $v ){
            $pid = $v['pid'];
            $list = @$tree[$pid] ?$tree[$pid] : array();
            array_push( $list, $v );
            $tree[$pid] = $list;
        }
    }

    //遍历输出根分类
    foreach((array)$tree[0] as $k=>$v)
    {
        echo "$v[name]<br />";
        //遍历输出根分类相应的子分类
        if($tree[$v['id']]) getdrawTree($tree[$v['id']],$tree,0);
        echo "<div style='height:10px;'></div>";
    }
}
/**************************************************************
 *
 *	获取出树状形式
 *
 *************************************************************/
function getdrawTree($arr,$tree,$level){

    $level++;
    $prefix = str_pad("|",$level+1,'-',STR_PAD_RIGHT);
    foreach($arr as $k2=>$v2)
    {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;$prefix$v2[name]<br />";
        if(isset($tree[$v2['id']])) getdrawTree($tree[$v2['id']],$tree,$level);

    }
}
//获取图片在根目录uploadfile里的绝对路径
function get_imageurl($url){	
    $path=parse_url($url);
    $absolute_path=str_replace('\\','/',$_SERVER['DOCUMENT_ROOT'].'/uploadfile'.$path['path']);	
	return $absolute_path;
}
//获取上传到微信服务器的媒体media_id
function get_media_id($mediaurl,$type){
	  $access_token = get_access_token();
	if($access_token){
	  $filepath=get_imageurl($mediaurl);
	  $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
	  $data=array('media' => new CURLFile(realpath($filepath)));
	  $result = https_request($url,$data);
	  $data_arr=json_decode($result,true);	
	 if($data_arr ['errcode']){
	   return $data_arr;//返回错误类型对应的编号
	 }else{
		$media_id=($type=='thumb')?'thumb_media_id':'media_id'; //用来判断群发的是图片
		return $data_arr[$media_id]; 
	  }
	}else{
		return 'access_token获取失败';
	}
}
function is_nothumb($thumb){//如果缩略图为空，则使用默认图替代
    if(!$thumb){
    $thumb = get_defaultthumb();
    }else{
    $thumb=$thumb;
    }
    return $thumb;
}
function is_wxthumb($thumb,$catid){//判断视频新闻
    if($catid=='3369'){
    $thumb='https://statics.05273.cn/statics/images/videobg.jpg';
    }elseif(!$thumb){    
    $thumb = get_defaultthumb();
    }else{
    $thumb=$thumb;
    }
    return $thumb;
}
function get_wxthumb($imgurl){//如果缩略图太大，裁剪缩略图
 $imgurl=is_nothumb($imgurl);
 $thumbsize=is_wxsize($imgurl);
 if($thumbsize>70){
  $imgurl=thumb($imgurl, $width = 500, $height = 300);
 }
  return	$imgurl;
}
function zhaiyao_bfb($string){
	 $search = array("%");
	 $replace = array("");
	 return str_replace($search, $replace, $string);
}
function is_wxsize($imgfile){//判断缩略图的大小
   $imgfile=get_imageurl($imgfile);
   if(is_file($imgfile)){
  $filesize=ceil(filesize($imgfile)/1024);
  return $filesize;
   }else{//如果文件路径错误则启用默认图片
	 $imgfile = get_defaultthumb();  
	 $imgfile=get_imageurl($imgfile);
     $filesize=ceil(filesize($imgfile)/1024);
     return $filesize;
   }
   
   }
function get_defaultthumb(){
	$setting = getcache('weixin','commons');
    $thumb = $setting[1]['thumb'];
	return $thumb;
}
function is_pmenu($id){
	$dbmenuevent = shy_base::load_model('weixin_menuevent_model');
	$smenu=$dbmenuevent->get_one(array('pid'=>$id));
	return $smenu;
}
//菜单针测
function is_pevent($id){
	$dbmenuevent = shy_base::load_model('weixin_menuevent_model');
	$event=$dbmenuevent->get_one(array('id'=>$id));
	$smenu=$dbmenuevent->get_one(array('pid'=>$id));
	if($event['type']==''){
	    if($smenu==''){
		$result=0;
		
		}elseif($smenu!=''){
		$result=2;
		}
		
	}elseif($event['type']!=''){
		$result=1;
		
	}
	return $result;
	
}
function getSHA1($strToken, $intTimeStamp, $strNonce, $strEncryptMsg = ''){
    $arrParams = array($strToken,$intTimeStamp,$strNonce);
    if (!empty($strEncryptMsg)) {
        array_unshift($arrParams, $strEncryptMsg);
    }
    sort($arrParams, SORT_STRING);
    $strParam = implode($arrParams);
    return sha1($strParam);
}
function globalreturncode($code){
$globalcode=array(
'-1'=>'系统繁忙，此时请开发者稍候再试',
'0'=>'请求成功',
'40001'=>'获取access_token时AppSecret错误，或者access_token无效。请开发者认真比对AppSecret的正确性，或查看是否正在为恰当的公众号调用接口',
'40002'=>'不合法的凭证类型',
'40003'=>'不合法的OpenID，请开发者确认OpenID（该用户）是否已关注公众号，或是否是其他公众号的OpenID',
'40004'=>'不合法的媒体文件类型',
'40005'=>'不合法的文件类型',
'40006'=>'不合法的文件大小',
'40007'=>'不合法的媒体文件id',
'40008'=>'不合法的消息类型',
'40009'=>'不合法的图片文件大小',
'40010'=>'不合法的语音文件大小',
'40011'=>'不合法的视频文件大小',
'40012'=>'不合法的缩略图文件大小',
'40013'=>'不合法的AppID，请开发者检查AppID的正确性，避免异常字符，注意大小写',
'40014'=>'不合法的access_token，请开发者认真比对access_token的有效性（如是否过期），或查看是否正在为恰当的公众号调用接口',
'40015'=>'不合法的菜单类型',
'40016'=>'不合法的按钮个数',
'40017'=>'不合法的按钮个数',
'40018'=>'不合法的按钮名字长度',
'40019'=>'不合法的按钮KEY长度',
'40020'=>'不合法的按钮URL长度',
'40021'=>'不合法的菜单版本号',
'40022'=>'不合法的子菜单级数',
'40023'=>'不合法的子菜单按钮个数',
'40024'=>'不合法的子菜单按钮类型',
'40025'=>'不合法的子菜单按钮名字长度',
'40026'=>'不合法的子菜单按钮KEY长度',
'40027'=>'不合法的子菜单按钮URL长度',
'40028'=>'不合法的自定义菜单使用用户',
'40029'=>'不合法的oauth_code',
'40030'=>'不合法的refresh_token',
'40031'=>'不合法的openid列表',
'40032'=>'不合法的openid列表长度',
'40033'=>'不合法的请求字符，不能包含\uxxxx格式的字符',
'40035'=>'不合法的参数',
'40038'=>'不合法的请求格式',
'40039'=>'不合法的URL长度',
'40050'=>'不合法的分组id',
'40051'=>'分组名字不合法',
'41001'=>'缺少access_token参数',
'41002'=>'缺少appid参数',
'41003'=>'缺少refresh_token参数',
'41004'=>'缺少secret参数',
'41005'=>'缺少多媒体文件数据',
'41006'=>'缺少media_id参数',
'41007'=>'缺少子菜单数据',
'41008'=>'缺少oauth code',
'41009'=>'缺少openid',
'42001'=>'access_token超时，请检查access_token的有效期，请参考基础支持-获取access_token中，对access_token的详细机制说明',
'42002'=>'refresh_token超时',
'42003'=>'oauth_code超时',
'43001'=>'需要GET请求',
'43002'=>'需要POST请求',
'43003'=>'需要HTTPS请求',
'43004'=>'需要接收者关注',
'43005'=>'需要好友关系',
'44001'=>'多媒体文件为空',
'44002'=>'POST的数据包为空',
'44003'=>'图文消息内容为空',
'44004'=>'文本消息内容为空',
'45001'=>'多媒体文件大小超过限制',
'45002'=>'消息内容超过限制',
'45003'=>'标题字段超过限制',
'45004'=>'描述字段超过限制',
'45005'=>'链接字段超过限制',
'45006'=>'图片链接字段超过限制',
'45007'=>'语音播放时间超过限制',
'45008'=>'图文消息超过限制',
'45009'=>'接口调用超过限制',
'45010'=>'创建菜单个数超过限制',
'45015'=>'回复时间超过限制',
'45016'=>'系统分组，不允许修改',
'45017'=>'分组名字过长',
'45018'=>'分组数量超过上限',
'46001'=>'不存在媒体数据',
'46002'=>'不存在的菜单版本',
'46003'=>'不存在的菜单数据',
'46004'=>'不存在的用户',
'47001'=>'解析JSON/XML内容错误',
'48001'=>'api功能未授权，请确认公众号已获得该接口，可以在公众平台官网-开发者中心页中查看接口权限',
'50001'=>'用户未授权该api',
'6'=>'没有权限获取该数据',
'110'=>'access_token非法',
'111'=>'access_token过期',
'306001'=>'参数错误',
'306025'=>'内部错误',
'306033'=>'API接口调用超出配额限制',
'306034'=>'配额控制策略配置错误',
'306035'=>'配额控制策略，无法匹配到依赖的业务数据',
'306042'=>'熊掌号数据为空',
'306203'=>'参数错误：%s',
'306208'=>'数据库繁忙',
'306229'=>'消息发送IM错误',
'61451'=>'参数错误(invalid parameter)',
'61452'=>'无效客服账号(invalid kf_account)',
'61453'=>'客服帐号已存在(kf_account exsited)',
'61454'=>'客服帐号名长度超过限制(仅允许10个英文字符，不包括@及@后的公众号的微信号)(invalid kf_acount length)',
'61455'=>'客服帐号名包含非法字符(仅允许英文+数字)(illegal character in kf_account)',
'61456'=>'客服帐号个数超过限制(10个客服账号)(kf_account count exceeded)',
'61457'=>'无效头像文件类型(invalid file type)',
'61450'=>'系统错误(system error)',
'61500'=>'日期格式错误',
'61501'=>'日期范围错误',
'default'=>'未知错误码'
);
if (array_key_exists($code, $globalcode)) {
  return $globalcode[$code];
}else{
  return $globalcode['default'];
}
}
function decom_cid($commentid){
 $arr=explode("_",$commentid);
 $data=explode("-",$arr[1]);
 return $data; 
}

function get_content_media($imgurl){
  $access_token = get_access_token();
  if($access_token){
$filepath=get_imageurl($imgurl);
$url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$access_token;
$data=array('media' => new CURLFile(realpath($filepath)));
$result = https_request($url,$data);
$data_arr=json_decode($result,true);
return $data_arr['url'];	

  }else{
  return false;
  }
}
function replacewximg ($text){

    preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i', $text, $match);
    foreach($match[1] as $imgurl){
    
        $imgurl= $imgurl;

        if(is_int(strpos($imgurl, 'http'))){
        
            $arcurl= $imgurl;
        }
        else{
        
            $arcurl= APP_PATH. $imgurl;
        }
     
 
        if(!empty($arcurl)){
        
     
                     
         $wxpicurl=get_content_media($arcurl);
 
            $text= str_replace($imgurl, $wxpicurl, $text);
        }
    }
    return $text;

}
function get_rank($data,$score){
 
   $data = array_unique($data);
             
   rsort($data);
   $rand=array_keys($data,$score);
      $ranking = $rand[0] + 1;
   return $ranking;
 
}
?>
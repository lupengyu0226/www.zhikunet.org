<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 SHUYANG
 * @license				http://www.05273.cn/license/
 * @lastmodify			2010-10-27
 */
/**
* inputtime_zone函数说明
* 7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
* @ 2013-06-04增加人性化时间显示
* @
*/
function inputtime_zone($inputtime) {
    $format=array('秒钟前','分钟前','小时前','天前','周内','一月内','一年内','从前');
    if(is_numeric($inputtime)){
         $i=SYS_TIME-$inputtime;
         switch($i){
            case 60>$i: $str=$i.$format[0];break;  
            case 3600>$i: $str=round ($i/60).$format[1];break;
            case 86400>$i: $str=round ($i/3600).$format[2];break;
			case 259200>$i:$str=round ($i/86400).$format[3];break;
			case 604800>$i:$str=round ($i/259200).$format[4];break;
			case 2592000>$i:$str=$format[5];break;
			case 31536000>$i:$str=$format[6];break;
			
            case $i>31536000: $str=$format[7];break;//$str=date('m-d', $timestamp);break;
        }
     }
     return $str;           		
}

function tgo($catid,$id, $allurl = 0) {
	static $category;
	if(empty($category)) {
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$category = getcache('category_content_'.$siteid,'commons');
	}
	$id = intval($id);
	if(!$id || !isset($category[$catid])) return '';
	$modelid = $category[$catid]['modelid'];
	if(!$modelid) return '';
	$db = shy_base::load_model('content_model');
	$db->set_model($modelid);
	$r = $db->get_one(array('id'=>$id), '`title`');
	return $r['title'];
}


function inputtime_zhuce($inputtime) {
	$input_now=time();
	$input_time = $input_now-$inputtime;
	$input_hour = (int)($input_time/(60*60));    //小时
	$input_day = (int)($input_time/(60*60*24));  //天
	$input_min = (int)($input_time%(60*60)/60);  //分钟
	$input_week = (int)($input_time/(7*24*60*60));  //星期
	$input_moon = (int)($input_time/(30*24*60*60));  //月份
    if ($input_time < 300) {
		return '刚刚';
	} elseif ($input_hour < 1) {
		return $input_min.'分钟前';
	} elseif ($input_hour < 24 && $input_hour >= 1) {
		return $input_hour.'小时前';
	} elseif ($input_hour >= 24 && $input_day <= 7) {
		return $input_day.'天前';
	} elseif ($input_day > 7 && $input_day <= 30) {
		return $input_week.'个星期前';
	} elseif ($input_day > 30 && $input_day <= 365) {
		return $input_moon.'个月前';
	} else {
		return date('Y-m-d',$inputtime);
	}
}
/**
 * 采集附件无http协议改造
 * @zhoutao			2017-03-02 15:48
 */
if (!function_exists('IsDomain')) :	
function IsDomain($domain) {  
    return !empty($domain)&& strpos($domain, '--')=== false&& preg_match('/^([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?[a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?(\.us|\.tv|\.org\.cn|\.org|\.net\.cn|\.net|\.mobi|\.me|\.la|\.info|\.hk|\.gov\.cn|\.edu|\.com\.cn|\.com|\.co\.jp|\.co|\.cn|\.cc|\.biz)$/i', $domain) ? true : false;
 }
endif;

/**
 * 弹幕评论系统专用提示页
 * @zhoutao			2014-07-22 19:08
 */
function minimsg($msg, $url_forward = 'goback', $ms = 5250, $dialog = '', $returnjs = '') {
	if(defined('IN_ADMIN')) {
		include(admin::admin_tpl('showmessage', 'admin'));
	} else {
		include(template('content', 'minimessage'));
	}
	exit;
}
/**
 * 内容调用所属专题
 * @param $catid 栏目ID
 * @param $id 文章ID
 * @param $num 调用数量，默认20条
 * @param $order 排序
*/
function relation_special($catid = 0, $id = 0, $num = 20, $order = 'id desc'){
	if(!$catid || !$id) return false;
	$special_db = shy_base::load_model('special_model');
	$special_content_db = shy_base::load_model('special_content_model');
	$curl = $id.'|'.$catid;
	$res = $special_content_db->select(array('curl'=>$curl),'*', $num, 'id desc');
	$datas = array();
	if(is_array($res)){
		foreach($res as $k=>$r){
			$info = $special_db->get_one(array('id'=>$r['specialid']));
			$datas[] = $info;
		}
	}
	return count($datas)>0 ? $datas : false;
}
/**
 * 百度站长平台链接推送
 * @param $bdurls url数组
 * @date 2016.7.8 15:19
 */
function push_baidu($bdurls){
    $api = 'http://data.zz.baidu.com/urls?site=https://www.05273.cn&token=eoGd7YblWzIp7vUe';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}
/**
 * 原创推送
 * @param $bdurls url数组
 * @date 2016.7.8 15:19
 */
function push_yuanchuang($bdurls){
    $api = 'http://data.zz.baidu.com/urls?appid=1595008503131425&token=tfTG1GqCalrVeMnD&type=original';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}
/**
 * 百度站长平台官方号增量链接推送
 * @param $bdurls url数组
 * @date 2017.09.06 21:44
 */
 function guanfanghao_zengliang($bdurls){
    $api = 'http://data.zz.baidu.com/urls?appid=1595008503131425&token=tfTG1GqCalrVeMnD&type=realtime';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}

/**
 * 百度站长平台官方号存量链接推送
 * @param $bdurls url数组
 * @date 2017.09.06 21:44
 */
 function guanfanghao_cunliang($bdurls){
    $api = 'http://data.zz.baidu.com/urls?appid=1595008503131425&token=tfTG1GqCalrVeMnD&type=batch';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}
/**
 * 百度站长平台MIP链接推送
 * @param $bdurls url数组
 * @date 2016.12.10 12:26
 */
function push_mip($bdurls){
    $api = 'http://data.zz.baidu.com/urls?site=wap.05273.cn&token=eoGd7YblWzIp7vUe&type=mip';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}

/**
 * 百度站长平台MIP链接推送更新
 * @param $bdurls url数组
 * @date 2016.12.12 13:28
 */
function push_mip_update($bdurls){
    $api = 'http://data.zz.baidu.com/update?site=wap.05273.cn&token=eoGd7YblWzIp7vUe&type=mip';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}

/**
 * 百度站长平台MIP链接推送删除
 * @param $bdurls url数组
 * @date 2016.12.12 15:19
 */
function push_mip_del($bdurls){
    $api = 'http://data.zz.baidu.com/del?site=wap.05273.cn&token=eoGd7YblWzIp7vUe&type=mip';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $bdurls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return $result;
}
function rankweek($gdate = "", $first = 0){
	 if(!$gdate) $gdate = date("Y-m-d");
		 $w = date("w", strtotime($gdate));//取得一周的第几天,星期天开始0-6
		 $dn = $w ? $w - $first : 6;//要减去的天数
		 //本周开始日期
		 $st = date("Y-m-d", strtotime("$gdate -".$dn." days"));
		 //本周结束日期
		 $en = date("Y-m-d", strtotime("$st +6 days"));
		 //上周开始日期
		 $last_st = date('Y-m-d',strtotime("$st - 7 days"));
		 //上周结束日期
		 $last_en = date('Y-m-d',strtotime("$st - 1 days"));
	 return array($st, $en,$last_st,$last_en);//返回开始和结束日期
}
/**
 * hot_description TAG调用描述
 * @zhoutao			2013-12-26
 */
function hot_description($modelid,$contentid){
        if(empty($modelid) && $modelid == 0) return false;
        if(empty($contentid) && $contentid == 0) return false;
        $db = shy_base::load_model('content_model');
        $models = getcache('model', 'commons');
        $db->table_name = $db->db_tablepre.$models[$modelid]['tablename'];
        $res = $db->get_one("`id`='$contentid'", 'description');
        if($res) return $res['description'];
        else return false;
}
/**
 * 对锁屏的密码进行加密
 * @param $lockscreen
 * @param $lockscreenencrypt //传入加密串，在修改密码时做认证
 * @return array/lockscreen
 */
function lockscreen($lockscreen, $lockscreenencrypt='') {
	$pwd = array();
	$pwd['lockscreenencrypt'] =  $lockscreenencrypt ? $lockscreenencrypt : create_randomstr();
	$pwd['lockscreen'] = md5(md5(trim($lockscreen)).$pwd['lockscreenencrypt']);
	return $lockscreenencrypt ? $pwd['lockscreen'] : $pwd;
}
function is_lockscreen($lockscreen) {
	$strlen = strlen($lockscreen);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

 /**
 * 字符串查找
 * @param $string 源字符串
 * @param $array  需要查找的字符串
 * return 找到返回true 没找到返回false
 */

function multineedle_stripos($string,$array){
   if(is_array($array)){
       foreach($array as $key => $val){
           if(stripos($string,$val)!==false && !is_array($val)){
               return true;
           }
       }
   }
   else{
       return stripos($string,$array)===false?false:true;
   }
}

/**
* 跨模型 跨栏目调用最新数据
*
* @param    $modelid        模型ID 可以有多个用,隔开
* @param    $limit     		要调用的数量
* @param    $siteid        	站点ID 默认为1
* @return     array 			返回一个数组
*/
function news($modelid="1,2", $limit="20", $siteid=1){
	$db = shy_base::load_model('content_model');
	$mdb = shy_base::load_model('sitemodel_model');
	$mid = explode(',', $modelid);
	$msid = $mdb->select("siteid = $siteid","modelid");
	$modelid = array();
	foreach ($msid as $v) {
		$modelid[]= $v['modelid'];
	}
	foreach ($mid as $v) {
		if(!in_array($v, $modelid)){
			echo $v."不存在,请联系网站管理员!";
			exit();
		}
	}
	$lists = array();
	foreach ($mid as $v) {
		$db->set_model($v);
		$tablename = $db->table_name;
		$lists = array_merge($lists, $db->select('status=99', 'id,catid,title,thumb,url,inputtime,description,username,quanzhong', $limit, 'inputtime DESC'));
	}
	return array_slice(array_sort($lists, 'inputtime'), 0, $limit);
}

/**
* 跨模型 跨栏目调用最新只含有图片的数据
*
* @param    $modelid        模型ID 可以有多个用,隔开
* @param    $limit     		要调用的数量
* @param    $siteid        	站点ID 默认为1
* @return     array 			返回一个数组
*/
function news_img($modelid="1,2", $limit="20", $siteid=1){
	$db = shy_base::load_model('content_model');
	$mdb = shy_base::load_model('sitemodel_model');
	$mid = explode(',', $modelid);
	$msid = $mdb->select("siteid = $siteid","modelid");
	$modelid = array();
	foreach ($msid as $v) {
		$modelid[]= $v['modelid'];
	}
	foreach ($mid as $v) {
		if(!in_array($v, $modelid)){
			echo $v."不存在,请联系网站管理员!";
			exit();
		}
	}
	$lists = array();
	foreach ($mid as $v) {
		$db->set_model($v);
		$tablename = $db->table_name;
		$lists = array_merge($lists, $db->select('status=99 and thumb<> ""', 'id,catid,title,url,inputtime,thumb,description,username,quanzhong', $limit, 'inputtime DESC'));
	}
	return array_slice(array_sort($lists, 'inputtime'), 0, $limit);
}

/**
*	@param 在数组中使用strpos
*	@param $needle数组，用于附件上传，2015年08月08日增加，用于附件CDN域名
*/
function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = stripos($haystack, $what))!==false) return $pos;
    }
    return false;
} 


/**
 * 通过 username 值，获取用户所有信息,包括附表信息
 * 获取用户信息
 * 不传入$field返回用户所有信息,
 * 传入field，取用户$field字段信息
 */
function get_memberinfo_all($userid, $field='') {
	if(!is_numeric($userid)) {
	return false;
	} else {
	static $memberinfo;
	if (!isset($memberinfo[$userid])) {
	$member_db = shy_base::load_model('member_model');
	$member_detail_db = shy_base::load_model('member_detail_model');
	$member_detail_fields=$member_detail_db->get_fields();
	$memberinfo[$userid] = $member_db->get_one(array('userid'=>$userid));
	$member_detail_info= $member_detail_db->get_one(array('userid'=>$userid));
	foreach($member_detail_fields as $key=>$value){
		$memberinfo[$userid][$key]=$member_detail_info[$key];
		}
	}
	if(!empty($field) && !empty($memberinfo[$userid][$field])) {
		return $memberinfo[$userid][$field];
		} else {
		return $memberinfo[$userid];
		}
	}
}

/**
 * PHP 过滤HTML代码空格,回车换行符的函数
 * echo deletehtml()
 */
	function deletehtml($str){
		$str = trim($str);
		$str=strip_tags($str,"");
		$str=preg_replace("{\t}","",$str);
		$str=preg_replace("{\r\n}","",$str);
		$str=preg_replace("{\r}","",$str);
		$str=preg_replace("{\n}","",$str);
		$str=preg_replace("{ }","",$str);
		return $str;
	}
/**
 * PHP 过滤UBB代码
 * echo deletehtml()
 */
  function deleteubb($str) {
        $str=nl2br($str);
        $str=stripslashes($str);
        $str=preg_replace("/\\t/is"," ",$str);
        $str=preg_replace("/\<br \/>/is","",$str);
        $str=preg_replace("/\[(.+?)=(.+?)\]/is","",$str);
        $str=preg_replace("/\[(.+?)\](.+?)\[\/(.+?)\]/is","\\2",$str);
        $str=preg_replace("/\[(.+?)=(.+?)\](.+?)\[\/(.+?)\]/is","\\3",$str);
        return $str;
  }
/**
 * 生成二维码函数
 * qrcode($code)
 */
function qrcode($code) {
        $annex = shy_base::load_config('system','cdnws');
        $filename=md5($code.'|4|4').'.png';
        $dir=substr($filename,0,1).DIRECTORY_SEPARATOR.substr($filename,0,4);
        shy_base::load_sys_class('QRcode', '', 0);
        shy_base::load_sys_func('dir');
        $upload_path = shy_base::load_config('system','upload_path');
        $file=$upload_path.'qrcode'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$filename;
        dir_create(dirname($file));
        if(file_exists($file)) return $annex[array_rand($annex)].'qrcode'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$filename;
        QRcode::png($code,$file,'H',4,2);
        $QR=$file;
        $logo = 'http://www.05273.cn/statics/images/icon.png';//准备好的logo图片  
                
        if ($logo !== FALSE&&file_exists($QR)) {   
            $QR = imagecreatefromstring(file_get_contents($QR));   
            $logo = imagecreatefromstring(file_get_contents($logo));   
            $QR_width = imagesx($QR);//二维码图片宽度   
            $QR_height = imagesy($QR);//二维码图片高度   
            $logo_width = imagesx($logo);//logo图片宽度   
            $logo_height = imagesy($logo);//logo图片高度   
            $logo_qr_width = $QR_width / 5;   
            $scale = $logo_width/$logo_qr_width;   
            $logo_qr_height = $logo_height/$scale;   
            $from_width = ($QR_width - $logo_qr_width) / 2;   
            //重新组合图片并调整大小   
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);   
            imagepng($QR,$file);
        }   
        //输出图片   
        return $annex[array_rand($annex)].'qrcode'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$filename;

}
/**
 * 获取点击数量
 * @param $hitsid
 */
function hits_views($hitsid) {
    global $db;
    if(!$hitsid){ return false;}
    $db = shy_base::load_model('hits_model');
        $r = $db->get_one(array('hitsid'=>$hitsid));    
    if($r){
        return $r['views'];
    }else{
        return '0';
    }
}
function https_curl($url,$data = null){
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
/**
* 跨模型 跨栏目调用最新数据
*
* @param    $arr       		要排序的数组
* @param    $keys     		排序的字段
* @param    $type        	排序方式
* @return     array 			返回一个数组
*/
function array_sort($arr, $keys, $type = 'desc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

function isMobile() {
	  $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
      $mobile_browser = '0';
      if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
      if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
      if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
      if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
      $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
      $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-'
            );
      if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;
      if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;
      // Pre-final check to reset everything if the user is on Windows
      if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        $mobile_browser=0;
      // But WP7 is also Windows, with a slightly different characteristic
      if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
        $mobile_browser++;
      if($mobile_browser>0)
        return true;
      else
        return false;
}

//判断是否是手机端
function is_mobile(){
  $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
  $mobile_browser = '0';
  if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
  $mobile_browser++;
  if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
  $mobile_browser++;
  if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
  $mobile_browser++;
  if(isset($_SERVER['HTTP_PROFILE']))
  $mobile_browser++;
  $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
  $mobile_agents = array(
  'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
  'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
  'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
  'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
  'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
  'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
  'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
  'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
  'wapr','webc','winw','winw','xda','xda-'
  );
  if(in_array($mobile_ua, $mobile_agents))
  $mobile_browser++;
  if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
  $mobile_browser++;
  // Pre-final check to reset everything if the user is on Windows
  if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
  $mobile_browser=0;
  // But WP7 is also Windows, with a slightly different characteristic
  if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
  $mobile_browser++;
  if($mobile_browser>0)
  return true;
  else
  return false;
}

//判断是否在微信中
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
        return true;
    }else{
        return false;
    }
}
?>
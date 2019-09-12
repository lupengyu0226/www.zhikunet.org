<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class preview extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->dbmember_group= shy_base::load_model('weixin_member_group_model');
		$this->dbsent_group_news= shy_base::load_model('weixin_sent_group_news_model');
		$this->sites = shy_base::load_app_class('sites','admin');
		shy_base::load_app_func('global','weixin');
		$this->setting = getcache('weixin','commons');
	}
   public function init() {
	     $setting=$this->setting;
		 if(isset($_POST['dosubmit'])) {
		if((!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} 
		   $catid=intval($_POST['catid']);
			if(is_array($_POST['id'])){
				if(count($_POST['id']) >9){
			      showmessage('发送的图文不能多于9条,请重选！', HTTP_REFERER);
		         } 
				 $num=1;
				foreach($_POST['id'] as $id_arr) {
					$info = $this->dbsent_group_news->get_one(array('id'=>$id_arr));
				     if($num==1){
					  $show_cover_pic=1;
						
					  }else{
					  $show_cover_pic=0;
					  }
					  $news_data[] = array(
					    'thumb_media_id'=>$info['thumb_media_id'],
						'author'=>$info['author'],
						'title'=>$info['title'],
						'content_source_url'=>$url = $info['url'],
						'content'=>addslashes(replacewximg($info['content'])),
						'digest'=>$info['description'],
						'show_cover_pic'=>$show_cover_pic
						);	
					  $num++;
				}
				$array_message=array('articles'=>$news_data);
			}
	        $group_id = intval($_POST['group_id']);
		    $jsondata=JSON($array_message);
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$result_arr=json_decode($result,true);
			if (array_key_exists('errcode',$result_arr)){  
					   echo '获取上传媒体media_id错误，'.globalreturncode($result_arr['errcode']);
					   exit;
					}
			$media_id = $result_arr['media_id'];
			$arr_group_messages=array('touser'=>$setting[1]['openid'],'mpnews'=>array('media_id'=>$media_id),'msgtype'=>'mpnews');	
		    $jsondatas=JSON($arr_group_messages);
			$url="https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$access_token;
			$results = https_request($url,$jsondatas);
			$arr_result=json_decode($results, true); 
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				echo globalreturncode($arr_result['errcode']);
				}			
		}
	 }
	}
	public function sent_group_message(){
		$setting=$this->setting;
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['group']['content'])) {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			} 
			$content = safe_replace($_POST['group']['content']);	
			$jsongroup=array();
			$json_group_message=array('touser'=>$setting[1]['openid'],'text'=>array('content'=>$content),'msgtype'=>'text');	
		    $jsondata=JSON($json_group_message);
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$arr_result=json_decode($result, true); 
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
	}
	public function dhtmlspecialchars($string, $flags = null) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val, $flags);
        }
    } else {
        if($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if(strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if(PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if(strtolower(CHARSET) == 'utf-8') {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }
    return $string;
}
public function safe_replace2($string) {
    $string = str_replace('&amp;','&',$string);
	$string = str_replace('&lt;','<',$string);
	$string = str_replace('&gt;','>',$string);
	$string = str_replace('&nbsp;',' ',$string);
	$string = str_replace('&quot;','"',$string);
	$string = str_replace('&middot;','.',$string);
	$string = str_replace('&ldquo;','',$string);
	$string = str_replace('&rdquo;','',$string);
	return $string;
}
}
?>
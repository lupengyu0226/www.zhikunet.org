<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
class EDI_index extends index { 
    private $times_db;
    public function __construct() { 
        parent::__construct(); 

    } 
	public function top_mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		$jsoncallback=isset($_GET['jsoncallback']) ? $_GET['jsoncallback'] : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		if($_username){
			$res["success"]=1;
			$res["message"]='<a href="http://www.05273.cn/index.php?app=waplogin&amp;controller=index"><img style="display:inline;vertical-align: middle;padding:1px; width:16px; height:16px;border-radius:100%;border:1px solid #dedede;" src="'.is_avatar(get_memberavatar($_userid,1,30)).'" width="16" height="16" onerror="this.src=\''.IMG_PATH.'member/nophoto.gif\'">&nbsp;'.get_nickname().'</a> | <a href="http://www.05273.cn/index.php?app=waplogin&controller=index">个人中心</a> | <a href="http://www.05273.cn/index.php?app=waplogin&controller=index&view=logout&forward='.urlencode($_GET['forward']).'">'.L('logout').'</a>';
			$res["message"] = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'utf-8', $res["message"]) : $res["message"];
			//get_nickname();//,
			
			}
		else{
			$res["success"]=0;
			}
			
		if($jsoncallback){
      		echo $jsoncallback . "({\"items\":[".json_encode($res)."]})";
		}else{
			echo json_encode($res);
		}
		//echo json_encode($res);
	}	
	public function blog_mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		$jsoncallback=isset($_GET['jsoncallback']) ? $_GET['jsoncallback'] : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		if($_username){
			$res["success"]=1;
			$res["message"]='<a href="http://www.05273.cn/index.php?app=waplogin&amp;controller=index"><img style="float: right;margin: -37px 15px 0 0;display:inline;vertical-align: middle;padding:1px; width:25px; height:25px;border-radius:100%;border:1px solid #dedede;" src="'.is_avatar(get_memberavatar($_userid,1,30)).'" width="25" height="25" onerror="this.src=\''.IMG_PATH.'member/nophoto.gif\'">';
			$res["message"] = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'utf-8', $res["message"]) : $res["message"];
			//get_nickname();//,
			
			}
		else{
			$res["success"]=0;
			}
			
		if($jsoncallback){
      		echo $jsoncallback . "({\"items\":[".json_encode($res)."]})";
		}else{
			echo json_encode($res);
		}
		//echo json_encode($res);
	}	
} 
?>

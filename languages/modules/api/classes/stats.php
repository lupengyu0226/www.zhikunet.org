<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
if  (isCrawler()){
$session_storage = 'session_'.shy_base::load_config('system','session_storage');
shy_base::load_sys_class($session_storage);
}
/**
 *  stats.php 栏目统计功能
 *
 * @copyright			(C) 2007-2015 05273.com
 * @license				http://www.05273.com/index.php?app=license
 * @lastmodify			2010-7-26
 */
//$db = '';
$db = shy_base::load_model('c_stats_model');

$edi = trim($_GET['edi']);
$catid = intval($_GET['catid']);
if($catid) {
	$adddate = date('Y-m-d',SYS_TIME);
	if(in_array($edi,array('pc','mobile'))){
		switch($edi){
			case 'pc':
				$db->update(array('hits'=>'+=1'),array('adddate'=>$adddate,'catid'=>$catid));
	            if($db->affected_rows()==0) {
	         	$db->insert(array('adddate'=>$adddate,'catid'=>$catid));
	            }
				break;
			case 'mobile':
				$db->update("`mhits`=`mhits`+1",array('adddate'=>$adddate,'catid'=>$catid));
	            if($db->affected_rows()==0) {
	         	$db->insert(array('adddate'=>$adddate,'catid'=>$catid));
	            }
				break;		
			}
	}

}
function isCrawler() {
        $agent= strtolower($_SERVER['HTTP_USER_AGENT']);
        if (!empty($agent)) {
                $spiderSite= array(
                        "TencentTraveler",
                        "Baiduspider+",
                        "BaiduGame",
                        "Googlebot",
                        "Sosospider+",
                        "Sogou web spider",
                        "Baiduspider-render",
                        "Yahoo! Slurp",
                        "YoudaoBot",
                        "Yahoo Slurp",
                        "MSNBot",
                        "Sogou News Spider",
                        "BaiDuSpider",
                        "Yisouspider",
                        "Yandex bot",
                        "Sogou Spider",
                        "Google AdSense",
                );
                foreach($spiderSite as $val) {
                        $str = strtolower($val);
                        if (strpos($agent, $str) !== false) {
                                return true;
                        }
                }
        } else {
                return false;
        }
}
?>
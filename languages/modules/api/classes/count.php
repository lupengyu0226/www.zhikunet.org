<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.'); 
/**
 * 点击统计
 */
$db = '';
$db = shy_base::load_model('hits_model');
if($_GET['modelid'] && $_GET['id']) {
	$model_arr = array();
	$model_arr = getcache('model','commons');//文件缓存
	$modelid = intval($_GET['modelid']);
	$hitsid = 'c-'.$modelid.'-'.intval($_GET['id']);
	$r = get_count($hitsid);
	if(!$r) exit;
	if(!is_array($r)){
		$r=unserialize($r);
		my_error_handler(1,hitsid.'不是数组'.$r,'api/count.php',15);
	}
    extract($r);
	$views=$views>0?$views:rand(1,5);
    hits($hitsid);
	//print_r($r);
	$r['todaydowns']=$dayviews;
	$r['hits']=$hits=$views>40000 ?round($views/10000,1)."万":$views;
	unset($r['hitsid'],$r['catid'],$r['updatetime'],$r['createtime']);
		echo "\$('#hits').html('$hits');";
}
/**
 * 获取点击数量
 * @param $hitsid
 */
function get_count($hitsid,$arr=[] ) {
	$db = shy_base::load_model('hits_model');
	$r=getcache($hitsid,'count','file');//反序列化
	if(!$r){//若不存在，则重新写入
		$r = $db->get_one(array('hitsid'=>$hitsid),'`hitsid`,`catid`,`views`,`yesterdayviews`,`dayviews`,`weekviews`,`monthviews`,`updatetime`');
		if(!$r){
            $r= ['hitsid'=>$hitsid,'updatetime'=>SYS_TIME,'views'=>0,'yesterdayviews'=>0,'dayviews'=>0,'weekviews'=>0,'monthviews'=>0];
			if(isset( $arr['modelid'] ))
				$r['modelid'] = $arr['modelid'];
			if(isset( $arr['cid'] ))
				$r['cid'] = $arr['cid'];
			$db->insert( $r );
		}
		unset($db);
		$r['createtime']=SYS_TIME;//仅用于创建set
		setcache($hitsid,$r,'count', 'file');
		$r=getcache($hitsid,'count','file');//反序列化
	}
	if(!$r) return false;
	return is_array($r)?$r:unserialize($r);
}

/**
 * 点击次数统计
 * @param $contentid
 */
function hits($hitsid) {
	$db = shy_base::load_model('hits_model');
	$r=getcache($hitsid,'count','file');
	if(!$r||$r['createtime']+180<=SYS_TIME){//该键值在memcache中未找到或者缓存期已经过期，需要写入数据库
		$rand_nums=rand(59,156);
		$views=$r['views'] = intval($r['views']) + 1 + $rand_nums;
		$yesterdayviews=$r['yesterdayviews'] = (date('Ymd', intval($r['updatetime'])) == date('Ymd', strtotime('-1 day'))) ? intval($r['dayviews']) : intval($r['yesterdayviews']);
		$dayviews=$r['dayviews'] = (date('Ymd', intval($r['updatetime'])) == date('Ymd', SYS_TIME)) ? intval(($r['dayviews']) + 1+$rand_nums) : 1;
		$weekviews=$r['weekviews'] = (date('YW', intval($r['updatetime'])) == date('YW', SYS_TIME)) ? intval(($r['weekviews']) + 1+$rand_nums) : 1;
		$monthviews=$r['monthviews'] = (date('Ym', intval($r['updatetime'])) == date('Ym', SYS_TIME)) ? intval(($r['monthviews']) + 1+$rand_nums) : 1;
		$updatetime=$r['updatetime']=SYS_TIME;
		$r['createtime']=SYS_TIME;//仅用于创建set
		$sql = array('views'=>$views,'yesterdayviews'=>$yesterdayviews,'dayviews'=>$dayviews,'weekviews'=>$weekviews,'monthviews'=>$monthviews,'updatetime'=>SYS_TIME);
		setcache($hitsid,$r,'count', 'file');
		return $db->update($sql, array('hitsid'=>$hitsid));
        unset($db);
	}else{
		$rand_nums=rand(59,156);
		$r['views'] = intval($r['views']) + 1 + $rand_nums;
		$r['yesterdayviews'] = (date('Ymd', intval($r['updatetime'])) == date('Ymd', strtotime('-1 day'))) ? intval($r['dayviews']) : intval($r['yesterdayviews']);
		$r['dayviews'] = (date('Ymd', intval($r['updatetime'])) == date('Ymd', SYS_TIME)) ? intval(($r['dayviews']) + 1+$rand_nums) : 1;
		$r['weekviews'] = (date('YW', intval($r['updatetime'])) == date('YW', SYS_TIME)) ? intval(($r['weekviews']) + 1+$rand_nums) : 1;
		$r['monthviews'] = (date('Ym', intval($r['updatetime'])) == date('Ym', SYS_TIME)) ? intval(($r['monthviews']) + 1+$rand_nums) : 1;
		$r['updatetime']=SYS_TIME;		
		setcache($hitsid,$r,'count', 'file');
	}
}
?>
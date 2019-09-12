<?php
function crontypes() {
	return array('index'=>'生成首页','create_relation_html'=>'生成相关页面','public_collection'=>'采集任务','gundong'=>'滚动新闻','weiwei'=>'微信新闻','wzdt'=>'手机网站地图','bddt'=>'百度地图','bdmaps'=>'XML地图','bofangtj'=>'播放器推荐','rssdy'=>'RSS订阅','weatherjs'=>'更新天气','weatherjson'=>'更新JSON天气');
}
function crontype($crontype) {
	$arr= array('index'=>'生成首页','create_relation_html'=>'生成相关页面','public_collection'=>'采集任务','gundong'=>'滚动新闻','weiwei'=>'微信新闻','wzdt'=>'手机网站地图','bddt'=>'百度地图','bdmaps'=>'XML地图','bofangtj'=>'播放器推荐','rssdy'=>'RSS订阅','weatherjs'=>'更新天气','weatherjson'=>'更新JSON天气');
	return $arr[$crontype];
}
function selcrontypes($cronid) {
	$cron_db = shy_base::load_model('cron_model');
	$rs = $cron_db->get_one(array('cronid'=>$cronid),'crontype');
	$arr= array('index'=>'生成首页','create_relation_html'=>'生成相关页面','public_collection'=>'采集任务','gundong'=>'滚动新闻','weiwei'=>'微信新闻','wzdt'=>'手机网站地图','bddt'=>'百度地图','bdmaps'=>'XML地图','bofangtj'=>'播放器推荐','rssdy'=>'RSS订阅','weatherjs'=>'更新天气','weatherjson'=>'更新JSON天气');
	return $arr[$rs['crontype']];
}
?>
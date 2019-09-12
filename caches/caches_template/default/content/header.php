<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-transform" />
        <title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
		<script type="text/javascript">
			if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
			  if(window.location.href.indexOf("?mobile")<0){
				try{
				  if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
					window.location.href="https://wap.zhikunet.org/";
				  }else if(/iPad/i.test(navigator.userAgent)){
					window.location.href="https://mip.zhikunet.org/"
				  }else{
					window.location.href="https://wap.zhikunet.org/"
				  }
				}catch(e){}
			  }
			}
		</script>
        <meta name="description" content="<?php echo $SEO['description'];?>">
        <meta name="keywords" content="<?php echo $SEO['keyword'];?>">
		<meta name="applicable-device" content="pc">
		<meta name="mobile-agent" content="format=html5;url=https://wap.zhikunet.org/">
		<link rel="stylesheet" href="<?php echo CSS_PATH;?>2019style/css/float.css" />
		<link rel="stylesheet" href="<?php echo CSS_PATH;?>2019style/css/index-layout.css" />
		<script src="<?php echo CSS_PATH;?>2019style/js/jquery-1.8.3.min.js"></script>	
			<script src="<?php echo CSS_PATH;?>2019style/js/jquery-1.2.6.pack.js"></script>
			<script src="<?php echo CSS_PATH;?>2019style/js/inde.select.js"></script>
		<script src="<?php echo CSS_PATH;?>2019style/js/global.js"></script>
		
		

</head>

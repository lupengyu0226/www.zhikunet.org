<?php 
        header('Content-type: application/json');
		$wxauth = shy_base::load_app_class('mipwx', 'mips');
		$wxconfig=$wxauth->get_sign();
		$jsoncallback = htmlspecialchars($_REQUEST ['callback']);
		$arr = array(
			'errno' => '0',
			'errmsg' => 'SUCCESS',
			'data' => array('appId' => $wxconfig['appId'], 'nonceStr' => $wxconfig['nonceStr'], 'timestamp' => $wxconfig['timestamp'], 'url' => $_GET['url'], 'signature' => $wxconfig['signature'],),
			'time' => time(),
			'hasFlush' => true,
			'format' => "jsonp",
		);
		$json_data=json_encode($arr);
		echo $jsoncallback . "(" . $json_data . ")";
?>
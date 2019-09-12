<?php
/**
 * 生成永远唯一的激活码
 * @return string
 */
class code {

public static function create_guid() {
	static $guid = '';
	$uid = uniqid ( "", true );
	$hash = strtoupper ( hash ( 'ripemd128', $uid . $guid . md5 ( $data ) ) );
	$guid = '' . substr ( $hash, 8, 4 ) . '-' . substr ( $hash, 8, 4 ) . '-' . substr ( $hash, 12, 4 ) . '-' . substr ( $hash, 16, 4 ) . '';
	
	return $guid;
	}
}
?>
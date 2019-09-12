<?php
/*
*安全防御系统 KEY 生成
*$domain 以当前使用协议开头，如 https:// 以/结尾
*#pwd 为站点auth_key
*生成后的字符串放到 caches/configs/system.php的safe_key节点内
*/
$key = check_key('https://www.05273.cn/','P6ABX0XA11OS8WCS');
echo $key;
function check_key($domain,$pwd){
    $sqdomain = $domain;
    $passworda_domain = $pwd;
    $passworda_yan = 'qwertyuiop123456789';
    $passworda_md5 = '123456789qwertyuiop';
    $sqdomain_md5 = md5($sqdomain . $passworda_domain);
    $shouquana = hash_hmac('sha1', $sqdomain_md5, $passworda_yan);
    $ab = md5($shouquana . $passworda_md5);
    return $ab;
}
?>
<?php
/**
 *  index.php 
 *
 * @copyright			(C) 2005-2014 EDI
 * @license				http://www.05273.com/index.php?app=license
 * @lastmodify			2014-5-20
 */
session_start();
if(isset($_GET['key']) && !empty($_GET['key'])){
	$domain = $_GET['domain'];
	$pwd = $_GET['pwd'];
	if($_GET['key'] == check_key($domain,$pwd)){
		$ip=$_POST['ip'];
		$wangzhi=$_POST['wangzhi'];
		$ttime=date("Y-m-d H:i:s");
		$page=$_POST['page'];
		$method=$_POST['method'];
		$rkey=$_POST['rkey'];
		$user_agent=$_POST['user_agent'];
		$request_url=$_POST['request_url'];
		$rdata=$_POST['rdata'];
		$host="localhost";
		$user="shuyangwang";
		$pwd="bwwGCU5XSxHDFVvF";
		$mydb="shuyangwang";
		$db=mysqli_connect($host, $user, $pwd,$mydb) or die('Could not connect: ' . mysqli_connect_error());
		$sql="insert into v9_fanghu (ip,wangzhi,ttime,page,method,rkey,rdata,user_agent,request_url) values ('$ip','$wangzhi','$ttime','$page','$method','$rkey','$rdata','$user_agent','$request_url')";
		$result = $db -> query($sql);
	}else echo '你的KEY无效';
}else echo '你的KEY无效';

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
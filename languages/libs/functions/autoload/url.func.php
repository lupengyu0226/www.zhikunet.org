<?php
/**
 * 
 * @param $catdir 完整目录
 * @param $siteid
 * @return $catid
 */
function dir2catid($catdir){
		if(!$catdir){
			$catid=0;
		}else{
			
		$CATEGORYS=getcache('category_content_mini','commons');
			if(!$CATEGORYS){
				$CATEGORYS=array();
				$siteids=array_unique(getcache('category_content','commons'));
				
				foreach($siteids as $k=>$value){
					$CATEGORYS=array_merge_recursive($CATEGORYS,getcache('category_content_'.$value,'commons'))	;
				}
				foreach($CATEGORYS as $k=>$value){
					$_CATEGORYS[$k]['url']=$value['url'];
					$_CATEGORYS[$k]['parentdir']=$value['parentdir'];
					$_CATEGORYS[$k]['catdir']=$value['catdir'];
					$_CATEGORYS[$k]['catid']=$value['catid'];
					$_CATEGORYS[$k]['catname']=$value['catname'];
				}
				setcache('category_content_mini',$_CATEGORYS,'commons');
			}
			foreach($CATEGORYS as $cat){
				if($cat['parentdir'].$cat['catdir']==$catdir){
					$catid=$cat['catid'];break;
				}
			}
			
			
		}
		return $catid;
}
/**
 * SSI调用
 * 
 * @param $filepath 文件路径
 * @return 
 */
function include_ssi($filepath) {
	if(defined('CACHE_PAGE_ID')){//缓存页面
		require SHUYANG_PATH.$filepath;//动态调用
		}
	elseif(defined('PREVIEW')){//预览页面
		require SHUYANG_PATH.$filepath;
		}
	elseif(!defined('HTML')&&defined('IN_ADMIN')){
		require SHUYANG_PATH.$filepath;
		}
	elseif(!defined('HTML')){
		require SHUYANG_PATH.$filepath;//动态调用
		}						
	else{//静态调用
		echo "<!--#include virtual=\"".$filepath."\"-->  ";
	}
}	
/**
* 
* @param [route] 路由结构 content/index/show or array('content','index','show')
* @param [vars]  附加参数 catid=1&id=1&page=3'or array('catid'=>1,'id'=>1,'page'=>3)
* @return [$rewrite] 地址重写 默认写入token
**/
function U($route=array(),$vars=array(),$rewrite='',$path='_') {	
		static $model,$controller,$action;
		if(is_null($route)||!$route) return false;
		if(!$ROUTE = shy_base::load_config('route', SITE_URL)){
			$ROUTE = shy_base::load_config('route', 'default');
		}
		if(isset($ROUTE['data'])) unset($ROUTE['data']);
		
		list($model,$controller,$action)=array_keys($ROUTE);
		
		if(!is_array($route)&&!empty($route)){	
			if(stripos($route,'@')!==false){
				list($route,$host)= explode("@",$route);
					if(stripos($route,'/')!==false){
						$route=explode("/",$route);
					}else{
					$route=array($route);	
					}
			}else{
				
				if(stripos($route,'/')!==false){
						$route=explode("/",$route);
					}else{
					$route=array($route);	
				}
			}
		}	
		if(isset($route['domain'])) $host=$route['domain'];
		switch(sizeof($route)){
			case 1:
			  $route=array($model=>$route[0]);
			  break;
			case 2:
			  $route=array($model=>$route[0],$controller=>$route[1]);
			  break;
			default:
			  $route=array($model=>$route[0],$controller=>$route[1],$action=>$route[2]);
			  break;
		  }
		//print_r($route);
		if(!$vars&&$vars=="") $vars=array();
		//print_r($vars);
		if(!is_array($vars) && !empty($vars)) parse_str($vars,$vars);
		if(defined('IN_ADMIN')&&!array_key_exists('safe_edi',$vars)&&!array_key_exists('token',$vars)) $vars['safe_edi'] = $_SESSION['safe_edi'];
		if(defined('IN_ADMIN')&&array_key_exists('token',$vars)) unset($vars['token']);
		
		if($rewrite!=""){
			$route=implode('/',$route);
			return $host.$route.(!empty($vars)?'/'.str_replace('=',$path,http_build_query($vars,'',$path)):'').".".$rewrite;//构造URL
		
		}else{
			$vars = array_merge($route,$vars);
			$rurl=http_build_query($vars);
			if(stripos($rurl,'%24')!==false||stripos($rurl,'%5C')!==false||stripos($rurl,'%5B')!==false||stripos($rurl,'%5D')!==false||stripos($rurl,'%7B')!==false||stripos($rurl,'%7D')!==false){//$
				$rurl=str_replace(array('%24','%5C','%5B','%5D','%7B','%7D'),array('$','\\','[',']','{','}'),$rurl);
			}
			return $host.'?'.$rurl;
		}
}
?>
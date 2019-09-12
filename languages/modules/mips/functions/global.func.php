<?php
/**
 * 输出xml头部信息
 */
function wmlHeader() {
	echo "<?xml version=\"1.0\" encoding=\"".CHARSET."\"?>\n";
}
/**
 * 解析分类url路径
 */
function list_url($catid) {
    return mips_SITEURL."list-$catid-1.html";
}

/**
 * 解析内容url路径
 * $catid 栏目id
 * $id 文章id
 */
function show_url($catid, $id) {
    return mips_SITEURL."show-$catid-$id-1.html";
}
/**
 * 解析分类MIPurl路径
 */
function miplist_url($catid) {
    return mips_SITEURL."miplist-$catid-1.html";
}
/**
 * 解析内容 MIP url路径
 * $catid 栏目id
 * $id 文章id
 */
function mip_url($catid, $id) {
    return mips_SITEURL."mip-$catid-$id-1.html";
}

/**
 * 替换为 MIP 需要的格式
 *
 * @param $str
 * @return mixed
 */
 function trim_mip($str) {
	if(is_array($str)){
		foreach ($str as $key => $val){
			$str[$key] = trim_mip($val);
		}
 	}else{
 		$str = str_replace("div",'p',$str);
		$str = str_replace("<img",'<mip-img popup',$str);
		$str = str_replace("<IMG",'<mip-img popup',$str);
		$str = preg_replace("/ class=\"(\/?.*?)\"/si","",$str);
        $str = preg_replace("/ style=\"(\/?.*?)\"/si","",$str);
		$str = preg_replace("/.(jpg|png|gif|jpeg|bmp)\"(\/?.*?)>/si",".$1\"/></mip-img>",$str);
		$str = preg_replace("/<span (\/?id.*?)>/si","<span>",$str);
		$str = preg_replace("/<span (\/?onmouseover.*?)>/si","<span>",$str);
		$str = preg_replace("/<strong (\/?style.*?)>/si","<strong>",$str);
		$str = preg_replace("/<a(\/?.*?)href/si","<a target=\"_blank\" href",$str);
        $str = preg_replace("/<INPUT(\/?.*?)>/si","",$str);
		$str = preg_replace("/ onerror=\"(\/?.*?)\"/si","",$str);
		$str = preg_replace("/ onload=\"(\/?.*?)\"/si","",$str);
		$str = str_replace("<a name=\"_GoBack\"></a>",'',$str);
 	}
	return $str;
}

function mip_pos($catid, $symbol=' > '){
	$category_arr = array();
	$siteids = getcache('category_content','commons');
	$siteid = $siteids[$catid];
	$category_arr = getcache('category_content_'.$siteid,'commons');
	if(!isset($category_arr[$catid])) return '';
	$pos = '';
	$siteurl = siteurl($category_arr[$catid]['siteid']);
	if(!$patent){
	$arrparentid = array_filter(explode(',', $category_arr[$catid]['arrparentid'].','.$catid));
	foreach($arrparentid as $catid) {
		$url = $category_arr[$catid]['url'];
		if(!preg_match('/^(http(s)?:)?\/\//', $url)) $url = $siteurl.$url;
		$pos .= '<a href="'.is_mips($url).'">'.$category_arr[$catid]['catname'].'</a>'.$symbol;
		}
	}else{
		$url=$category_arr[$category_arr[$catid]["parentid"]]['url'];
		$pos .= '<a href="'.is_mips($url).'">'.$category_arr[$category_arr[$catid]["parentid"]]['catname'].'</a>';

		}
	return $pos;
}

function showmsg($msg, $url_forward = 'goback', $ms = 5250, $dialog = '', $returnjs = '') {
	if(defined('IN_ADMIN')) {
		include(admin::admin_tpl('showmessage', 'admin'));
	} else {
		include(template('mips', 'minimessage'));
	}
	exit;
}

function license($data) {
		$update = shy_base::load_app_class('license');
		$notice_url = $update->notice();
		$string = base64_decode('PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPiQoIiNtYWluX2ZyYW1laWQiKS5yZW1vdmVDbGFzcygiZGlzcGxheSIpOzwvc2NyaXB0PjxkaXYgaWQ9InBocGNtc19ub3RpY2UiPjwvZGl2PjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9Ik5PVElDRV9VUkwiPjwvc2NyaXB0Pg==');
		echo $data.str_replace('NOTICE_URL',$notice_url,$string);
}

/**
 * MIP分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function mip_pages($num, $curr_page,$pageurls) {
	$multipage .= '<p class="a1">第'.$curr_page.'页 / 共'.$num.L('页').'</p> ';
	$page = 5;
	$offset = 4;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		if($curr_page>1) {
			$multipage .= '<mip-link href="'.$pageurls[1][0].'">首页</mip-link> <mip-link class="a1" href="'.$pageurls[$perpage][0].'">'.L('previous').'</mip-link>';
		}
		if($curr_page==1) {
			//$multipage .= ' <span>1</span>';
		} elseif($curr_page>6 && $more) {
			//$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
		} else {
			//$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			//$multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			//$multipage .= ' <span>'.$i.'</span>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' <mip-link class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</mip-link>';
		} else {
			$multipage .= ' <mip-link class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</mip-link>';
		}
	} elseif($curr_page==$pages) {
		//$multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">'.L('next').'</a>';
	}
	$multipage = str_replace("show",'mip',$multipage);
	return $multipage;
}

/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page,$pageurls) {
	$multipage .= '<a class="a1">第'.$curr_page.'页</a>/<a class="a1">共'.$num.L('页').'</a> ';
	$page = 5;
	$offset = 4;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		if($curr_page>1) {
			$multipage .= '<a href="'.$pageurls[1][0].'">首页</a> <a class="a1" href="'.$pageurls[$perpage][0].'">'.L('previous').'</a>';
		}
		if($curr_page==1) {
			//$multipage .= ' <span>1</span>';
		} elseif($curr_page>6 && $more) {
			//$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
		} else {
			//$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			//$multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			//$multipage .= ' <span>'.$i.'</span>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' <a class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		} else {
			$multipage .= ' <a class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		}
	} elseif($curr_page==$pages) {
		//$multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">'.L('next').'</a>';
	}
	return $multipage;
}
?>
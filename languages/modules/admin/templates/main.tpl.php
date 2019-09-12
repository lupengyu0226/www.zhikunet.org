<?php
defined('IN_ADMIN') or exit('No permission resources.');
include SHY_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<script src="<?php echo JS_PATH?>echarts.min.js"></script>
<div id="main_frameid" class="pad-10" style="_margin-right:-12px;_width:98.9%;">
<script type="text/javascript">
$(function(){if ($.browser.msie && parseInt($.browser.version) < 7) $('#browserVersionAlert').show();}); 
</script>
<div class="explain-col mb10" style="display:none" id="browserVersionAlert">
<?php echo L('ie8_tip')?></div>
<?php if(shy_base::load_config('system','safe_off') == 0) { ?>
<div class="explain-col"><font color='#CC0000'><?php echo L('safe_off_tips','','admin')?></font></div>
<div class="bk10"></div>
<?php } ?>
<div class="col-tj lf mr10" style="width:100%">
  <div class="col-4 lf mr10" style="width:25%">
      <div class="symbol userblue"> 
       <i class="iconfont icon-3x icon-huiyuan1" style="color: white;"></i>
      </div> 
      <div class="value"> 
        <a href="?app=member&controller=member&view=manage&menuid=72&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><h1 id="total_member">0</h1></a> 
        <p>用户总量</p> 
      </div> 
  </div>
  <div class="col-4 lf mr30" style="width:22.5%">
      <div class="symbol commred"> 
         <i class="iconfont icon-3x icon-huiyuan" style="color: white;"></i>
      </div> 
      <div class="value"> 
        <a href="?app=member&controller=member&view=init&menuid=2824&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><h1 id="today_member">0</h1></a> 
        <p>今日注册,在线<?php echo $total_session_online?></p> 
      </div> 
  </div>
  <div class="col-4 lf mr10" style="width:25%">
    <section class="panel"> 
      <div class="symbol articlegreen"> 
         <i class="iconfont icon-3x icon-neirong" style="color: white;"></i>
      </div> 
      <div class="value"> 
        <a href="?app=content&controller=content_all&view=init&modelid=1&menuid=822&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><h1 id="allcount">0</h1></a> 
        <p>索引到:<?php echo $sphinx_counter['max_doc_id'];?></p> 
      </div> 
    </section> 
  </div>
  <div class="col-4 lf" style="width:24.5%">
    <section class="panel"> 
      <div class="symbol rsswet"> 
         <i class="iconfont icon-3x icon-tag" style="color: white;"></i>
      </div> 
      <div class="value"> 
        <a href="?app=hot&controller=hot&view=init&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><h1 id="total_hot_check">0</h1></a> 
        <p>ITAG总数</p> 
      </div> 
    </section> 
  </div>
  </div>

<div class="col-2 lf mr10" style="width:48%">
  <h6><?php echo L('personal_information')?></h6>
  <div class="content">
  <?php echo L('main_hello')?><?php echo $admin_username?>
  <?php echo L('main_role')?><?php echo $rolename?>
  <?php echo L('main_last_logintime')?><?php echo date('Y-m-d H:i:s',$logintime)?>
  </div></div>
<div class="col-2 rt" style="width:50%">
	<h6>服务器实时数据</h6>
	<div class="servics">
<?php
function memory_usage() 
{
	$memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
	return $memory;
}
// 计时
function microtime_float() 
{
	$mtime = microtime();
	$mtime = explode(' ', $mtime);
	return $mtime[1] + $mtime[0];
}
//单位转换
function formatsize($size) 
{
	$danwei=array(' B ',' K ',' M ',' G ',' T ');
	$allsize=array();
	$i=0;

	for($i = 0; $i <4; $i++) 
	{
		if(floor($size/pow(1024,$i))==0){break;}
	}

	for($l = $i-1; $l >=0; $l--) 
	{
		$allsize1[$l]=floor($size/pow(1024,$l));
		$allsize[$l]=$allsize1[$l]-$allsize1[$l+1]*1024;
	}

	$len=count($allsize);

	for($j = $len-1; $j >=0; $j--) 
	{
		$strlen = 4-strlen($allsize[$j]);
		if($strlen==1)
			$allsize[$j] = "<font color='#FFFFFF'>0</font>".$allsize[$j];
		elseif($strlen==2)
			$allsize[$j] = "<font color='#FFFFFF'>00</font>".$allsize[$j];
		elseif($strlen==3)
			$allsize[$j] = "<font color='#FFFFFF'>000</font>".$allsize[$j];

		$fsize=$fsize.$allsize[$j].$danwei[$j];
	}	
	return $fsize;
}
// 根据不同系统取得CPU相关信息
switch(PHP_OS)
{
	case "Linux":
		$sysReShow = (false !== ($sysInfo = sys_linux()))?"show":"none";
	break;	
	default:
	break;
}
//linux系统探测
function sys_linux()
{
    // CPU
    if (false === ($str = @file("/proc/cpuinfo"))) return false;
    $str = implode("", $str);
    @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/s", $str, $model);
    @preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
    @preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/", $str, $cache);
    @preg_match_all("/bogomips\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $bogomips);
    if (false !== is_array($model[1]))
	{
        $res['cpu']['num'] = sizeof($model[1]);
		/*
        for($i = 0; $i < $res['cpu']['num']; $i++)
        {
            $res['cpu']['model'][] = $model[1][$i].'&nbsp;('.$mhz[1][$i].')';
            $res['cpu']['mhz'][] = $mhz[1][$i];
            $res['cpu']['cache'][] = $cache[1][$i];
            $res['cpu']['bogomips'][] = $bogomips[1][$i];
        }*/
		if($res['cpu']['num']==1)
			$x1 = '';
		else
			$x1 = ' ×'.$res['cpu']['num'];
		$mhz[1][0] = ' | 频率:'.$mhz[1][0];
		$cache[1][0] = ' | 二级缓存:'.$cache[1][0];
		$bogomips[1][0] = ' | Bogomips:'.$bogomips[1][0];
		$res['cpu']['model'][] = $model[1][0].$mhz[1][0].$cache[1][0].$bogomips[1][0].$x1;
        if (false !== is_array($res['cpu']['model'])) $res['cpu']['model'] = implode("<br />", $res['cpu']['model']);
        if (false !== is_array($res['cpu']['mhz'])) $res['cpu']['mhz'] = implode("<br />", $res['cpu']['mhz']);
        if (false !== is_array($res['cpu']['cache'])) $res['cpu']['cache'] = implode("<br />", $res['cpu']['cache']);
        if (false !== is_array($res['cpu']['bogomips'])) $res['cpu']['bogomips'] = implode("<br />", $res['cpu']['bogomips']);
	}

    // NETWORK

   // UPTIME
    if (false === ($str = @file("/proc/uptime"))) return false;
    $str = explode(" ", implode("", $str));
    $str = trim($str[0]);
    $min = $str / 60;
    $hours = $min / 60;
    $days = floor($hours / 24);
    $hours = floor($hours - ($days * 24));
    $min = floor($min - ($days * 60 * 24) - ($hours * 60));
    if ($days !== 0) $res['uptime'] = $days."天";
    if ($hours !== 0) $res['uptime'] .= $hours."小时";
    $res['uptime'] .= $min."分钟";

    // MEMORY
    if (false === ($str = @file("/proc/meminfo"))) return false;
    $str = implode("", $str);
    preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
	preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);

    $res['memTotal'] = round($buf[1][0]/1024, 2);
    $res['memFree'] = round($buf[2][0]/1024, 2);
    $res['memBuffers'] = round($buffers[1][0]/1024, 2);
	$res['memCached'] = round($buf[3][0]/1024, 2);
    $res['memUsed'] = $res['memTotal']-$res['memFree'];
    $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

    $res['memRealUsed'] = $res['memTotal'] - $res['memFree'] - $res['memCached'] - $res['memBuffers']; //真实内存使用
	$res['memRealFree'] = $res['memTotal'] - $res['memRealUsed']; //真实空闲
    $res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0; //真实内存使用率

	$res['memCachedPercent'] = (floatval($res['memCached'])!=0)?round($res['memCached']/$res['memTotal']*100,2):0; //Cached内存使用率

    $res['swapTotal'] = round($buf[4][0]/1024, 2);
    $res['swapFree'] = round($buf[5][0]/1024, 2);
    $res['swapUsed'] = round($res['swapTotal']-$res['swapFree'], 2);
    $res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;

    // LOAD AVG
    if (false === ($str = @file("/proc/loadavg"))) return false;
    $str = explode(" ", implode("", $str));
    $str = array_chunk($str, 4);
    $res['loadAvg'] = implode(" ", $str[0]);

    return $res;
}
$uptime = $sysInfo['uptime'];
$stime = date("Y-n-j H:i:s");
$df = round(@disk_free_space(".")/(1024*1024*1024),3);
$dt = round(@disk_total_space(".")/(1024*1024*1024),3);
$load = $sysInfo['loadAvg'];	//系统负载
//判断内存如果小于1GB，就显示M，否则显示GB单位
if($sysInfo['memTotal']<1024)
{
	$memTotal = $sysInfo['memTotal']." MB";
	$mt = $sysInfo['memTotal']." MB";
	$mu = $sysInfo['memUsed']." MB";
	$mf = $sysInfo['memFree']." MB";
	$mc = $sysInfo['memCached']." MB";	//cache化内存
	$mb = $sysInfo['memBuffers']." MB";	//缓冲
	$st = $sysInfo['swapTotal']." MB";
	$su = $sysInfo['swapUsed']." MB";
	$sf = $sysInfo['swapFree']." MB";
	$swapPercent = $sysInfo['swapPercent'];
	$memRealUsed = $sysInfo['memRealUsed']." MB"; //真实内存使用
	$memRealFree = $sysInfo['memRealFree']." MB"; //真实内存空闲
	$memRealPercent = $sysInfo['memRealPercent']; //真实内存使用比率
	$memPercent = $sysInfo['memPercent']; //内存总使用率
	$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
}
else
{
	$memTotal = round($sysInfo['memTotal']/1024,3)." GB";
	$mt = round($sysInfo['memTotal']/1024,3)." GB";
	$mu = round($sysInfo['memUsed']/1024,3)." GB";
	$mf = round($sysInfo['memFree']/1024,3)." GB";
	$mc = round($sysInfo['memCached']/1024,3)." GB";
	$mb = round($sysInfo['memBuffers']/1024,3)." GB";
	$st = round($sysInfo['swapTotal']/1024,3)." GB";
	$su = round($sysInfo['swapUsed']/1024,3)." GB";
	$sf = round($sysInfo['swapFree']/1024,3)." GB";
	$swapPercent = $sysInfo['swapPercent'];
	$memRealUsed = round($sysInfo['memRealUsed']/1024,3)." GB"; //真实内存使用
	$memRealFree = round($sysInfo['memRealFree']/1024,3)." GB"; //真实内存空闲
	$memRealPercent = $sysInfo['memRealPercent']; //真实内存使用比率
	$memPercent = $sysInfo['memPercent']; //内存总使用率
	$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
}
//网卡流量
$strs = @file("/proc/net/dev"); 

for ($i = 2; $i < count($strs); $i++ )
{
	preg_match_all( "/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info );
/*	$NetInput[$i] = formatsize($info[2][0]);
	$NetOut[$i]  = formatsize($info[10][0]);
*/ 
	$tmo = round($info[2][0]/1024/1024, 5); 
	$tmo2 = round($tmo / 1024, 5);
	$NetInput[$i] = $tmo2;
	$tmp = round($info[10][0]/1024/1024, 5); 
	$tmp2 = round($tmp / 1024, 5);
	$NetOut[$i] = $tmp2;

}

?>
<style type="text/css">
<!--
tr{padding: 0; background:#FFFFFF;}
td{padding: 5px 6px; border:1px solid #CCCCCC;}
.bar {border:1px solid #999999; background:#FFFFFF; height:5px; font-size:2px; width:100%; margin:2px 0 5px 0;padding:1px;overflow: hidden;}
.bar_1 {border:1px dotted #999999; background:#FFFFFF; height:5px; font-size:2px; width:100%; margin:2px 0 5px 0;padding:1px;overflow: hidden;}
.barli_red{background:#ff6600; height:5px; margin:0px; padding:0;}
.barli_blue{background:#0099FF; height:5px; margin:0px; padding:0;}
.barli_green{background:#36b52a; height:5px; margin:0px; padding:0;}
.barli_1{background:#999999; height:5px; margin:0px; padding:0;}
.barli{background:#36b52a; height:5px; margin:0px; padding:0;}
-->
</style>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="10%">服务器时间</td>
    <td width="40%"><?php echo $stime;?> / 已运行:<?php echo $uptime;?></td>
    <td width="10%">总空间</td>
    <td width="40%" colspan="3"><?php echo $dt;?>&nbsp;GB / <font color='#CC0000'><?php echo $df;?></font>&nbsp;GB</td>
  </tr>
    <tr>
  <tr>
    <td width="10%">系统环境</td>
    <td width="40%"><i class="iconfont icon-CentOS"></i> / <i class="iconfont icon-nginx"></i> / <i class="iconfont icon-php"></i> / <i class="iconfont icon-MySQL"></i></td>
    <td width="12%">程序版本</td>
    <td width="40%" colspan="3"><i class="iconfont icon-zhongguoguoqi1"></i> 飞天系统 <?php echo SHY_VERSION?> / <?php echo SHY_RELEASE?></td>
  </tr>
  <tr>
    <td width="10%">CPU [<?php echo $sysInfo['cpu']['num'];?>核]</td>
    <td width="90%" colspan="5"><?php echo $sysInfo['cpu']['model'];?></td>
  </tr>
	  <tr>
		<td>内存<br \>使用状况</td>
		<td colspan="3">
<?php
$tmp = array(
    'memTotal', 'memUsed', 'memFree', 'memPercent',
    'memCached', 'memRealPercent',
    'swapTotal', 'swapUsed', 'swapFree', 'swapPercent'
);
foreach ($tmp AS $v) {
    $sysInfo[$v] = $sysInfo[$v] ? $sysInfo[$v] : 0;
}
?>
          物理内存：共
          <font color='#CC0000'><?php echo $memTotal;?> </font>
           , 已用
          <font color='#CC0000'><?php echo $mu;?></font>
          , 空闲
          <font color='#CC0000'><?php echo $mf;?></font>
          , 使用率
	  <font color='#CC0000'><?php echo $memPercent;?></font>
          <div class="bar"><div id="barmemPercent" class="barli_green" style="width:<?php echo $memPercent?>%">&nbsp;</div> </div>
<?php
//判断如果cache为0，不显示
if($sysInfo['memCached']>0)
{
?>		
		 虚拟化内存为 <font color='#CC0000'><?php echo $mc;?></font>
		  , 使用率 
          <font color='#CC0000'><?php echo $memCachedPercent;?></font>
		  %	| Buffers缓冲为  <font color='#CC0000'><?php echo $mb;?></font>
          <div class="bar"><div id="barmemCachedPercent" class="barli_blue" style="width:<?php echo $memCachedPercent;?>%">&nbsp;</div></div>

          真实内存使用
          <font color='#CC0000'><?php echo $memRealUsed;?></font>
		  , 真实内存空闲
          <font color='#CC0000'><?php echo $memRealFree;?></font>
		  , 使用率
          <font color='#CC0000'><?php echo $memRealPercent;?></font>
          %
          <div class="bar_1"><div id="barmemRealPercent" class="barli_1" style="width:<?php echo $memRealPercent;?>%">&nbsp;</div></div> 
<?php
}
//判断如果SWAP区为0，不显示
if($sysInfo['swapTotal']>0)
{
?>	
          SWAP区：共<?php echo $st;?>, 已使用<font color='#CC0000'><?php echo $su;?></font>, 空闲<font color='#CC0000'><?php echo $sf;?></font>, 使用率<font color='#CC0000'><?php echo $swapPercent;?></font>%<div class="bar"><div id="barswapPercent" class="barli_red" style="width:<?php echo $swapPercent;?>%">&nbsp;</div> </div>
          当前系统负载：<font color='#CC0000'><?php echo $load;?></font>
    </td>
  </tr>
<?php
}	
?>	
  <tr>
    <td width="10%">授权信息</td>
    <td width="90%" colspan="5">授权类型:<span id="phpcms_license"></span> 序列号:<span id="phpcms_sn"></span></td>
  </tr>
<?php if (false !== ($strs = @file("/proc/net/dev"))) : ?>
<?php for ($i = 2; $i < count($strs); $i++ ) : ?>
<?php preg_match_all( "/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info );?>
     <tr>
        <td width="10%"><?php echo $info[1][0]?> : </td>
        <td width="45%">已接收 : <font color='#CC0000'><?php echo $NetInput[$i]?></font> GB</td>
        <td width="45%" colspan="2">已发送 : <font color='#CC0000'><?php echo $NetOut[$i]?></font> GB</td>
    </tr>
<?php endfor; ?>
<?php endif; ?>
</table>
</div>
</div>
<div class="col-2 lf mr10" style="width:48%">
  <h6>十天数据波动图</h6>
  <div class="content" id="catstat">
    <div style="height:300px"><img src="//statics.05273.cn/statics/images/admin_img/onLoad.gif"> 加载中...</div>
  </div>
  </div>
<div class="col-2 rt" style="width:50%">
  <h6>待定</h6>
  <div class="content" id="modelstat">
<div style="height:300px"><img src="//statics.05273.cn/statics/images/admin_img/onLoad.gif"> 加载中...</div>
 </div>
</div>
<div class="col-2 lf mr10" style="width:48%">
  <h6>错误日志<span style="float:right;"><a class="baise" href="<?php echo $currentsite['domain']?>index.php?app=admin&controller=index&view=clear_error_log&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><i class="iconfont icon-shanchu"></i></a></span></h6>
  <div class="content" style="height:218px;width:96%; overflow:auto;">
        <?php
        echo file_get_contents("caches/error_log.php");
        ?>
 </div>
</div>
<script src="<?php echo JS_PATH?>odoo.js"></script>
<script>
    odoo.default({ el:'#total_member',value:'<?php echo $total_member?>' })
    odoo.default({ el:'#today_member',value:'<?php echo $today_member?>' })
    odoo.default({ el:'#allcount',value:'<?php echo $allcount;?>' })
    odoo.default({ el:'#total_hot_check',value:'<?php echo $total_hot_check?>' })
</script>
<script type="text/javascript">
$(function(){
  $.ajaxSetup ({cache: true });
  $('#catstat').load('?app=admin&controller=category_analysis&view=public_load_cat_stat_main&range=10&safe_edi=<?php echo $_SESSION['safe_edi']?>');
  $('#modelstat').load('?app=admin&controller=category_analysis&view=public_load_model_stat&safe_edi=<?php echo $_SESSION['safe_edi']?>');
})
</script>
</body></html>
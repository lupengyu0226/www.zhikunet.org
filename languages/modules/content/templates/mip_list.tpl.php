<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?app=content&controller=mip&view=init" method="get">
<input type="hidden" name="app" value="content">
<input type="hidden" name="controller" value="mip">
<input type="hidden" name="view" value="init">
<div class="pad_10">
<div class="explain-col">
 <div style="float:right;">自定义时间：
<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?> <select name="ispc">
              <option value="wap">手机端</option>
              <option value="pc" >电脑端</option>
            </select><input name="dosubmit" type="submit" value="查询"></div>
今日：<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=1&ispc=wap" class="<?php if($_GET['tab']==1) echo 'fb';?>">手机</a>/<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=2&ispc=pc" class="<?php if($_GET['tab']==2) echo 'fb';?>">电脑</a> | 
昨日：<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&tab=3&ispc=wap" class="<?php if($_GET['tab']==3) echo 'fb';?>">手机</a>/ 
<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&tab=4&ispc=pc" class="<?php if($_GET['tab']==4) echo 'fb';?>">电脑</a> | 
<?php
$week = rankweek('',1);
?>
本周：<a href="?app=content&controller=mip&view=init&start_time=<?php echo $week[0];?>&end_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=5&ispc=wap" class="<?php if($_GET['tab']==5) echo 'fb';?>">手机</a>/
<a href="?app=content&controller=mip&view=init&start_time=<?php echo $week[0];?>&end_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=6&ispc=pc" class="<?php if($_GET['tab']==6) echo 'fb';?>">电脑</a> | 
上周：<a href="?app=content&controller=mip&view=init&start_time=<?php echo $week[2];?>&end_time=<?php echo $week[3];?>&tab=7&ispc=wap" class="<?php if($_GET['tab']==7) echo 'fb';?>">手机</a>/
<a href="?app=content&controller=mip&view=init&start_time=<?php echo $week[2];?>&end_time=<?php echo $week[3];?>&tab=8&ispc=pc" class="<?php if($_GET['tab']==8) echo 'fb';?>">电脑</a> | 
本月：<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));?>&tab=9&ispc=wap" class="<?php if($_GET['tab']==9) echo 'fb';?>">手机</a>/
<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));?>&tab=10&ispc=pc" class="<?php if($_GET['tab']==10) echo 'fb';?>">电脑</a> | 
上月：<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),0,date('Y')));?>&tab=11&ispc=wap" class="<?php if($_GET['tab']==11) echo 'fb';?>">手机</a>/
<a href="?app=content&controller=mip&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),0,date('Y')));?>&tab=12&ispc=pc" class="<?php if($_GET['tab']==12) echo 'fb';?>">电脑</a> |   
<a href="?app=content&controller=mip&view=init&tab=7" class="<?php if($_GET['tab']==7) echo 'fb';?>">总推送</a>
</div>
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th align='left' width="5%">ID</th>
            <th align='left' width="5%">内容ID</th>
            <th align='left' width="30%">内容标题</th>
            <th align='left' width="10%">推送URL</th>
            <th align='left' width="10%">推送状态</th>
            <th align='left' width="15%">推送时间</th>
            <th align='left' width="30%">官方号</th>
            </tr>
        </thead>
    <tbody>
<?php
if(is_array($datas)){
    foreach($datas as $info){
        $info['log'] = string2array($info['log']);
        $info['log']['pc'] = str_replace("1",'推送成功',$info['log']['success']);
        $info['log']['success'] = str_replace("1",'推送成功',$info['log']['success_mip']);
        
        ?>
        <tr>
            <td align='left'><?php echo $info['id']?></td>
            <td align='left'><?php echo $info['contentid']?></td>
            <td align='left'><?php echo $info['title']?></td>
            <td align='left'><a class="xbtn btn-info btn-xs" href="<?php echo $info['url']?>" target="_blank">访问</a> <?php if ($info['log']['success_mip']){ echo "<a class='xbtn btn-primary btn-xs' href='https://www.mipengine.org/validator/preview?url=$info[url]' target='_blank'>校验</a>";}?></td>
            <td align='left'><?php echo $info['log']['success']?><?php echo $info['log']['pc']?>,剩余<?php echo $info['log']['remain_mip']?><?php echo $info['log']['remain']?></td>
            <td align="left"><?php echo date('Y-m-d H:i:s', $info['inputtime'])?></td>
            <td align="left"><?php 
        if (is_today($info['inputtime'])==1){
            echo '<a class="xbtn btn-warning btn-xs">今日数据</a>';
            } elseif ($info['ispush']==0){
            echo '<a class="xbtn btn-inverse btn-xs" href="?app=content&controller=content&view=pushbaiducl&safe_edi='.$_SESSION['safe_edi'].'&bdurls='.$info['url'].'">存量推送</a>';
            } elseif ($info['ispush']==1){
            echo '<a class="xbtn btn-white btn-xs">已经推送</a>';
   }?></td>
        </tr>
    <?php
    }
}
?>
    </tbody>
    </table>
<div id="pages"><?php echo $pages;?></div>
     </div>
</div>
</div>
</form>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>

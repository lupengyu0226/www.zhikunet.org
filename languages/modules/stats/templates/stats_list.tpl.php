<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript" src="//statics.05273.cn/statics/js/echarts.min.js"></script>
<form name="myform" action="?app=stats&controller=stats&view=init" method="get">
<input type="hidden" name="app" value="stats">
<input type="hidden" name="controller" value="stats">
<input type="hidden" name="view" value="init">
<div class="pad_10">
<div class="explain-col">
 <div style="float:right;">自定义时间：
<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?> <input name="dosubmit" type="submit" value="查询"></div>
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=1" class="<?php if($_GET['tab']==1) echo 'fb';?>">今日访问量</a> | 
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));?>&tab=2" class="<?php if($_GET['tab']==2) echo 'fb';?>">昨日访问量</a> | 
<?php
$week = aweek('',1);
?>
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo $week[0];?>&end_time=<?php echo date('Y-m-d',SYS_TIME);?>&tab=3" class="<?php if($_GET['tab']==3) echo 'fb';?>">本周访问量</a> | 
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo $week[2];?>&end_time=<?php echo $week[3];?>&tab=4" class="<?php if($_GET['tab']==4) echo 'fb';?>">上周访问量</a> | 
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));?>&tab=5" class="<?php if($_GET['tab']==5) echo 'fb';?>">本月访问量</a> | 
<a href="?app=stats&controller=stats&view=init&start_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));?>&end_time=<?php echo date('Y-m-d',mktime(0,0,0,date('m'),0,date('Y')));?>&tab=6" class="<?php if($_GET['tab']==6) echo 'fb';?>">上月访问量</a> | 
<a href="?app=stats&controller=stats&view=init&tab=7" class="<?php if($_GET['tab']==7) echo 'fb';?>">总访问量</a>
</div>
<div class="bk10"></div>
<div class="table-list">
   <div id="main" style="height:250px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
            option = {
            title: {
                text: '沭阳网用户访问构成',
                subtext: '数据来自统计系统'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['电脑端', '手机端']
            },
            grid: {
                left: '2%',
                right: '2%',
                bottom: '0%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                boundaryGap: [0, 0.01]
            },
            yAxis: {
                type: 'category',
                data: ['']
            },
            series: [
                {
                    name: '电脑端',
                    type: 'bar',
                    data: [<?php echo $pctotal;?>]
                },
                {
                    name: '手机端',
                    type: 'bar',
                    data: [<?php echo $mtotal;?>]
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="100">栏目ID</th>
            <th width="250">栏目名称</th>
            <th >电脑端访问次数:<?php echo $pctotal;?></th>
            <th >手机端访问次数:<?php echo $mtotal;?></th>
            <th >文章访问排行</th>
            </tr>
        </thead>
    <tbody>
    <?php echo $categorys;?>
    </tbody>
    </table>

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

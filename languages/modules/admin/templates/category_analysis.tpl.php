<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript" src="<?php echo JS_PATH?>echarts.min.js"></script>
<div class="pad_10">
<div class="explain-col">
提醒：此处提供一些网站栏目的运行数据。
</div>
<div class="bk10"></div>
<div class="table-list">
<div class="col-2">
	<h6><span style="float:right"></span>最近30天文章发布趋势分析</h6>
	<div class="content" id="catstat">
		<div style="height:200px"><img src="<?php echo IMG_PATH.'admin_img/onLoad.gif'?>"> 加载中...</div>
	</div>
</div>
<div class="bk10"></div>
<div class="col-2 col-auto">
	<h6><span style="float:right"></span>模型数据分析</h6>
	<div class="content" id="modelstat">
		<div style="height:200px"><img src="<?php echo IMG_PATH.'admin_img/onLoad.gif'?>"> 加载中...</div>
	</div>
</div>
	</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	$.ajaxSetup ({cache: true });
	$('#modelstat').load('?app=admin&controller=category_analysis&view=public_load_model_stat&safe_edi=<?php echo $_SESSION['safe_edi']?>');
	$('#catstat').load('?app=admin&controller=category_analysis&view=public_load_cat_stat&range=30&safe_edi=<?php echo $_SESSION['safe_edi']?>');
})
</script>
</body>
</html>

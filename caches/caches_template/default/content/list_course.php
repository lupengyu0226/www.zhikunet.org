<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<?php include template("content","header_top"); ?>
<?php include template("content","header_logo"); ?>
<?php include template("content","header_nav"); ?>
  <!--正文start--> 
  <div class="index-main-content"> 
   <!--热门推荐start--> 
   <div class="Hme_top">
    <span>热门推荐：</span> 
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=96e7e73f6a515db89036974a6318bf60&action=position&posid=1&order=id+DESC&num=12&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('posid'=>'1','order'=>'id DESC',)).'96e7e73f6a515db89036974a6318bf60');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'1','order'=>'id DESC','limit'=>'12',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
		<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		<a  target="_blank" href="<?php echo $r['url'];?>">{$r{title}}</a>
		<?php $n++;}unset($n); ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
   </div> 
  </div> 
 <!----轮播图--->
	<div class="wrapper"> 
		<div class="scroll" id="deskScrollData">
			<ul id="deskSlideDiv" class="scroll-data clearfix" style="margin-left: 0px; left: -980px;"> 
				<li class="item"><a href="http://xiazai.zol.com.cn/pk/327560_405221.shtml" class="pic"><img src="https://icon.zol-img.com.cn/softnew/img/banner_duibi.jpg" alt="" width="980" height="140" title=""></a></li>
				<li class="item"><a href="http://sj.zol.com.cn/xcx/" class="pic"><img src="https://icon.zol-img.com.cn/softnew/img/banner_xcx3.jpg" alt="" width="980" height="140" title=""></a></li>
				<li class="item"><a href="http://soft.zol.com.cn/photoshop/" class="pic"><img src="https://icon.zol-img.com.cn/softnew/img/banner_photoshop.jpg" alt="" width="980" height="140" title=""></a></li>
				<li class="item"><a href="http://soft.zol.com.cn/word/" class="pic"><img src="https://icon.zol-img.com.cn/softnew/img/banner_word.jpg" alt="" width="980" height="140" title=""></a></li>
				<li class="item"><a href="http://soft.zol.com.cn/flash/" class="pic"><img src="https://icon.zol-img.com.cn/softnew/img/banner_flash.jpg" alt="" width="980" height="140" title=""></a></li>
				
			</ul>
			<ul class="scroll-control clearfix"> 
				<li sid="0" class="deskSlideDiv">1</li>
				<li sid="1" class="deskSlideDiv current">2</li>
				<li sid="2" class="deskSlideDiv">3</li>
				<li sid="3" class="deskSlideDiv">4</li>
				<li sid="4" class="deskSlideDiv">5</li>
			</ul>
		</div>
		<!-- aside -->
			<!------list------->
	<div class="aside"> 
		<div class="section classification"> 
			<div class="section-header"> 
				<h3>所有课程分类</h3>
			</div>
			<!-- classification-items -->
			<div class="classification-items">
				<ul class="items-list">
                                       
                    <li class="item">
						<a target="_blank" href="/download_order/cat_33.html" class="sub-title"><span>按院校</span><em>（5969）</em></a>
						<div class="sub-links-box clearfix"> 
                                                                    
							 <a target="_blank" href="/download_order/sub_69.html">浏览器</a>  
								 
							 <a target="_blank" href="/download_order/sub_1489.html">IE浏览器</a>  
								 
							 <a target="_blank" href="/download_order/sub_107.html">浏览辅助</a>  
								 
							 <a target="_blank" href="/download_order/sub_1370.html">网购工具</a>  
								 
							 <a target="_blank" href="/download_order/sub_34.html">网络加速</a>  
								 
							 <a target="_blank" href="/download_order/sub_327.html">下载工具</a>  
								 
							 <a target="_blank" href="/download_order/sub_343.html">网络硬盘</a>  
								 
							 <a target="_blank" href="/download_order/sub_54.html">电子邮件</a>  
								 
							 <a target="_blank" href="/download_order/sub_1029.html">FTP软件</a>  
								 
							 <a target="_blank" href="/download_order/sub_1291.html">网管软件</a>  
								 
							 <a target="_blank" href="/download_order/sub_1486.html">黑客工具</a>  
								 
							 <a target="_blank" href="/download_order/sub_1492.html">资源搜索</a>  
                                                                                                             
						</div>
					</li>        
                                        
                    <li class="item">
						<a target="_blank" href="/download_order/cat_26.html" class="sub-title"><span>安全防护</span><em>（3539）</em></a>
						<div class="sub-links-box clearfix"> 
                                                                    
							 <a target="_blank" href="/download_order/sub_22.html">杀毒软件</a>  
								 
							 <a target="_blank" href="/download_order/sub_1480.html">木马专杀</a>  
								 
							 <a target="_blank" href="/download_order/sub_74.html">系统安全</a>  
								 
							 <a target="_blank" href="/download_order/sub_236.html">防火墙</a>  
								 
							 <a target="_blank" href="/download_order/sub_782.html">远程控制</a>  
								 
							 <a target="_blank" href="/download_order/sub_1452.html">监控软件</a>  
								 
							 <a target="_blank" href="/download_order/sub_49.html">加密解密</a>  
								 
							 <a target="_blank" href="/download_order/sub_361.html">数据恢复</a>  
                                                                                                             
						</div>
					</li>        
                                        
                    <li class="item">
						<a target="_blank" href="/download_order/cat_133.html" class="sub-title"><span>电脑游戏</span><em>（10020）</em></a>
						<div class="sub-links-box clearfix"> 
                                                                    
							 <a target="_blank" href="/download_order/sub_1016.html">单机游戏</a>  
								 
							 <a target="_blank" href="/download_order/sub_1442.html">网络游戏</a>
						 
						</div>
					</li>        
                                        
                    <li class="item">
						<a target="_blank" href="/download_order/cat_31.html" class="sub-title"><span>系统工具</span><em>（12624）</em></a>
						<div class="sub-links-box clearfix"> 
                                                                    
							 <a target="_blank" href="/download_order/sub_20.html">硬件检测</a>  
								 
							 <a target="_blank" href="/download_order/sub_325.html">操作系统</a>  
							 
						</div>
					</li>        
				     
                </ul>
			</div>
			<!-- //classification-items -->
		</div>
	</div>
	<!-- //aside -->
	
	<!-- main -->
	<div class="main section-list"> 
		<!-- section -->
		<div class="section"> 
			<div class="section-header">
				<h2>标题标题标题标题标题标题</h2>
			</div>
			<!-- rank-tabs -->
			<div class="rank-tabs">
				<!-- tab-panel -->
				<div class="tab-panel"> 
					<dl class="list_dl">
						<dt><a href="http://driver.zol.com.cn/detail/48/471934.shtml" target="_blank"><img src="./images/223.jpg" alt="惠普HP Smart Tank 518 驱动" width="100" height="50"></a></dt>
							<dd><strong><a href="http://driver.zol.com.cn/detail/48/471934.shtml">院校院校院校院校院校院校</a></strong></dd>
							<dd class="dlTxt02">【招生专业】惠普HP Smart &nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;【研究方向】Tank 518 打印机驱动下载统...</dd>
							<dd class="dl-Foot">类型：同等学力申博&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;学制：6.44 MB&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;上课地点：2019-06-26&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;学费：4569元</dd>
					</dl>
				</div>
				<!-- //tab-panel -->
			</div>
			<!-- rank-tabs -->
		</div>
		
		<div class="section"> 
			<div class="section-header">
				<h2>热门软件排行榜</h2>
			</div>
			<!-- rank-tabs -->
			<div class="rank-tabs">
				<!-- tab-panel -->
				<div class="tab-panel"> 
					<dl class="list_dl">
						<dt><a href="http://driver.zol.com.cn/detail/48/471934.shtml" target="_blank"><img src="./images/223.jpg" alt="惠普HP Smart Tank 518 驱动" width="100" height="50"></a></dt>
							<dd><strong><a href="http://driver.zol.com.cn/detail/48/471934.shtml">惠普HP Smart Tank 518 驱动</a></strong></dd>
							<dd class="dlTxt02">【驱动描述】惠普HP Smart Tank 518 打印机驱动下载统...</dd>
							<dd class="dl-Foot">类别：<a href="/print_drivers/page_1.html"><font style="color:#1f4f88;font-size:12px;">打印机</font></a>&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;大小：6.44 MB&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;时间：2019-06-26&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;下载量：4569</dd>
					</dl>
				</div>
				<!-- //tab-panel -->
			</div>
			<!-- rank-tabs -->
		</div>
		
 <p class="page-all"><?php echo $pages;?></p> 
    </div>
	<!-- //main -->
	<script type="text/javascript" src="<?php echo CSS_PATH;?>2019style/js/RankIndex.js"></script>
	<!-- //wrapper -js.js-->
<script> 
(function(){
	$(".rank-tabs .tab-nav li").hover(function(){
		var num = $(this).index(), p = $(this).parent().parent();
		$(this).addClass("current").siblings("li").removeClass("current");
		p.find(".tab-panel").eq(num).show().siblings(".tab-panel").hide();
	})
})()

,(function(){ 
	$(".classification-items .item").mouseover(function(){
		$(this).addClass("h-item").siblings(".item").removeClass("h-item");
	})
	$(".classification-items .item").mouseout(function(){
		$(this).removeClass("h-item"); 
	})
})()

</script>
	</div>
	<!----list-end----->
<?php include template("content","footer"); ?>
<script type="text/javascript" src="<?php echo CSS_PATH;?>2019style/js/page_Category.js?v=10561"></script>
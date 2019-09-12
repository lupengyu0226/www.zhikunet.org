<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<?php include template("content","header_top"); ?>
<?php include template("content","header_logo"); ?>
<?php include template("content","header_nav"); ?>
  <!--正文start--> 
  <div class="index-main-content"> 
   <!--热门推荐start--> 
   <div class="Hme_top">
    <span>热门推荐：</span> 
      <?php include_ssi("/caches/posid/1.html"); ?>
   </div> 
   </div>
   <!----con-stra----->
   <!----轮播图--->
<div class="wrapper"> 
	<div class="scroll" id="deskScrollData">
		<ul id="deskSlideDiv" class="scroll-data clearfix" style="margin-left: 0px; left: -980px;"> 
			<?php require SHUYANG_PATH."/caches/posid/3.html";?>
            
		</ul>
		<ul class="scroll-control clearfix"> 
			<li sid="0" class="deskSlideDiv">1</li>
			<li sid="1" class="deskSlideDiv current">2</li>
			<li sid="2" class="deskSlideDiv">3</li>
			<li sid="3" class="deskSlideDiv">4</li>
			<li sid="4" class="deskSlideDiv">5</li>
		</ul>
	</div>
</div>
<!------筛选------->
<div class="wrapper clearfix">
	<!-- main -->
	<div class="main">
		<!-- main-tabs -->
		<div class="main-tabs">
			<ul class="tab-nav clearfix" id="navList">
			<?php $n=1;if(is_array($yx_type_list)) foreach($yx_type_list AS $yx) { ?> 
				<li class="last-item <?php if($n==1) { ?> current<?php } ?>" date-id="<?php echo $yx['linkageid'];?>"><span><?php echo $yx['name'];?></span><i class="arrow-icon"></i></li>
				<?php $n++;}unset($n); ?>
				
			</ul>
			<div class="tab-panel"> 
				<div id="pnanel" class="tab-pnanel-inner" style="margin-top: 0px;"> 
					<!-- section -->
					<?php $i = 0;?>
					<?php $n=1; if(is_array($yuanxi_data)) foreach($yuanxi_data AS $k => $v) { ?>
					<div class="section" date-id="<?php echo $v['linkageid'];?>" id="pnanelChild<?php echo $v['linkageid'];?>">
						<div class="section-header">
							<h2><?php echo $k;?></h2>
						</div>
						<ul class="links">

						<li class="item">
							<?php $n=1;if(is_array($v['value'])) foreach($v['value'] AS $vv) { ?>
							<a href="<?php echo $vv['url'];?>" target="_blank" class="sub-title" title="<?php echo $vv['catname'];?>"><?php echo $vv['catname'];?></a>
							<?php $n++;}unset($n); ?>
						</li>	
							
						</ul> 
					</div>
					<?php $i++;?>
					<?php $n++;}unset($n); ?>
					<!-- //section -->
					
				
				</div>
			</div>
            
		</div>
		<!-- //main-tabs -->
	</div>
	<!-- //main -->
</div>

   <!----con-end----->
  <?php include template("content","footer"); ?>
<script type="text/javascript" src="<?php echo CSS_PATH;?>2019style/js/page_Category.js?v=10561"></script>
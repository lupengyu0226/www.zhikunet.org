<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><!--搜索框-->
<div id="ali-masthead-v6">
	<div class="ali-masthead-container fd-clr">
		<div class="ali-logo">
			<div class="main-logo logo-custom" >
				<a title="智库网" href="<?php echo siteurl($siteid);?>" class="main-logo-img">
					<img alt="智库网" src="<?php echo CSS_PATH;?>2019style/images/logo.png" width="150px" >
				</a>
				<div class="main-logo-txt">
					<a class="main-logo-url" href="<?php echo siteurl($siteid);?>">— 在职研究生招生门户 —</a>
				</div>
			</div>    
		</div>
			
		<div class="ali-search">
			<form action="<?php echo APP_PATH;?>index.php" name="soso_search_box" method="get" target="_blank">
				<fieldset>
					
					<div class="alisearch-container">
						<div class="alisearch-box">
						<div class="alisearch-type">	
							<div id="options">
								<dl>
									
										<dt>
										<input type="text" value="申博" name="sm.keyTypeStr" id="text" readonly="readonly" />
										<input id="keyType" type="hidden" value="" name="sm.keyType" readonly="readonly" />
										<b></b>
									</dt>										
										<!-- <b></b> -->
									
									<dd>
									<?php $j=0?>
									<?php $search_model = getcache('search_model_'.$siteid, 'search');?>
									<?php $n=1;if(is_array($search_model)) foreach($search_model AS $k=>$v) { ?>
									<?php $j++;?>
										<div><a href="javascript:;" id="<?php echo $j;?>" onclick="setmodel(<?php echo $v['typeid'];?>, $(this));" style="outline:medium none;" hidefocus="true" <?php if($j==1 && $typeid=$v['typeid']) { ?> class="on" <?php } ?>><?php echo $v['name'];?></a></div>
											<?php $n++;}unset($n); ?>
									<?php unset($j);?>
									</dd>
								</dl>
							</div>
						
							<div class="alisearch-keywords">
							 <input type="hidden" name="app" value="search"/>
										  <input type="hidden" name="controller" value="index"/>
										  <input type="hidden" name="view" value="init"/>
										  <input type="hidden" name="typeid" value="1">
										  <input type="hidden" name="siteid" value="1">  
								<input class="txtArea" name="q" value="请输入关键词" autocomplete="off" onfocus="if(this.value=='请输入关键词')this.value=''" type="text">
								
							</div>
						</div>	
						</div>
						<div class="alisearch-action">
						
							<button class="single" type="submit" data-header-trace="">&#337</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>	
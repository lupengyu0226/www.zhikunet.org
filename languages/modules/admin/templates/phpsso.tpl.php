<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.js"></script>
		<div id="leftMain">
		<h3 class="f14">phpsso<?php echo L('manage')?></h3>
		<ul>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=member&view=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=member&view=manage')?>" target="right"><?php echo L('member_manage')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=applications&view=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=applications&view=init')?>" target="right"><?php echo L('application')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=messagequeue&view=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=messagequeue&view=manage')?>" target="right"><?php echo L('communication')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=credit&view=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=credit&view=manage')?>" target="right"><?php echo L('redeem')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=administrator&view=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=administrator&view=init')?>" target="right"><?php echo L('administrator')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=system&view=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=system&view=init')?>" target="right"><?php echo L('system_setting')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=cache&view=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=cache&view=init')?>" target="right"><?php echo L('update_phpsso_cache')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=password&view=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=password&view=init')?>" target="right"><?php echo L('change_password')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?app=admin&controller=login&view=logout&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?app=admin&controller=member&view=manage')?>" target="right"><?php echo L('exit')?>phpsso</a>
		</li>
		</ul>
		</div>
		<script  type="text/javascript">
			$("#leftMain li").click(function() {
				var i =$(this).index() + 1;
				$("#leftMain li").removeClass();
				$("#leftMain li:nth-child("+i+")").addClass("on fb blue");
			});
		</script>

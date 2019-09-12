<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="common-form">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form contentWrap">
		<tr>
			<td width="120"><?php echo L('member_totalnum')?></td> 
			<td>
				<?php echo $memberinfo['totalnum']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_todaynum')?></td> 
			<td>
				<?php echo $memberinfo['today_member']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_verify_totalnum')?></td> 
			<td>
				<?php echo $memberinfo['verifynum']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_vip_totalnum')?></td> 
			<td>
				<?php echo $memberinfo['vipnum']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('当前在线')?></td> 
			<td>
			<a href="?app=onlines&controller=onlines&view=init&menuid=2824&safe_edi=<?php echo $_SESSION['safe_edi'];?>"><?php echo $memberinfo['online']?></a> 
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
<form name="myform" action="" method="get">
<input type="hidden" name="app" value="member" />
<input type="hidden" name="controller" value="member" />
<input type="hidden" name="view" value="search" />
<fieldset>
	<legend><?php echo L('member_search')?></legend>
<div class="bk10"></div>
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="app">
<input type="hidden" value="member" name="controller">
<input type="hidden" value="search" name="view">
<input type="hidden" value="879" name="menuid">
<table width="100%" class="table_form contentWrap">
		<tr>
			<td width="120"><?php echo L('regtime')?></td> 
			<td>
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_group')?></td> 
			<td>
				<?php echo form::select($grouplist, $_GET['groupid'], 'name="groupid"', L('nolimit'))?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('status')?></td> 
			<td>
				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo L('nolimit')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('type')?></td> 
			<td>
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('email')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('regip')?></option>
				</select>
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('amount')?></td> 
			<td>
				<input name="amount_from" type="text" value="" class="input-text" size="4"/>-
				<input name="amount_to" type="text" value="" class="input-text" size="4"/>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('point')?></td> 
			<td>
				<input name="point_from" type="text" value="" class="input-text" size="4"/>-
				<input name="point_to" type="text" value="" class="input-text" size="4"/>
			</td>
		</tr>

</table>
<div class="bk15"></div>
<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
</form>

</fieldset>
</form>

</div>
</div>
</body>
</html>

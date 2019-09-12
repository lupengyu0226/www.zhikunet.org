<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="app">
<input type="hidden" value="member" name="controller">
<input type="hidden" value="search" name="view">
<input type="hidden" value="879" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
				<?php if($_SESSION['roleid'] == 1) {?>
				<?php echo form::select($sitelist, $siteid, 'name="siteid"', L('all_site'));}?>
							
				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo L('status')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
				<?php echo form::select($modellist, $modelid, 'name="modelid"', L('member_model'))?>
				<?php echo form::select($grouplist, $groupid, 'name="groupid"', L('member_group'))?>
				<select name="isvip">
					<option value='0' <?php if(isset($_GET['isvip']) && $_GET['isvip']==0){?>selected<?php }?>>是否VIP</option>
					<option value='1' <?php if(isset($_GET['isvip']) && $_GET['isvip']==1){?>selected<?php }?>><?php echo L('yes')?></option>
					<option value='2' <?php if(isset($_GET['isvip']) && $_GET['isvip']==2){?>selected<?php }?>><?php echo L('no')?></option>
				</select>
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('email')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('regip')?></option>
					<option value='5' <?php if(isset($_GET['type']) && $_GET['type']==5){?>selected<?php }?>><?php echo L('nickname')?></option>
				</select>
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?app=member&controller=member&view=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left"></th>
			<th align="left"><?php echo L('uid')?></th>
			<th align="left"><?php echo L('username')?></th>
			<th align="left"><?php echo L('nickname')?></th>
			<th align="left"><?php echo L('email')?></th>
			<th align="left"><?php echo L('member_group')?></th>
			<th align="left"><?php echo L('regip')?></th>
			<th align="left"><?php echo L('lastlogintime')?></th>
			<th align="left"><?php echo L('注册端')?></th>
			<th align="left"><?php echo L('注册方式')?></th>
            <th align="left"><?php echo L('mp')?></th>
			<th align="left"><?php echo L('amount')?></th>
			<th align="left"><?php echo L('登录次数')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($memberlist)){
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php if($v['islock']) {?><i class="iconfont icon-suoping"></i><?php }?></td>
		<td align="left"><?php echo $v['userid']?></td>
		<td align="left"><a href="javascript:member_infomation(<?php echo $v['userid']?>, '<?php echo $v['modelid']?>', '')"><?php echo $member_model[$v['modelid']]['name']?><?php echo $v['username']?><?php if($v['vip']) {?> <i class="iconfont icon-vip"></i><?php }?></td>
		<td align="left"><?php echo new_html_special_chars($v['nickname'])?></td>
		<td align="left"><?php echo $v['email']?></td>
		<td align="left"><?php echo $grouplist[$v['groupid']]?></td>
		<td align="left"><?php echo $v['regip']?><?php echo $ip_area->get($v['regip']); ?></td>
		<td align="left"><?php echo format::date($v['lastdate'], 1);?></td>
		<td align="left"><?php echo $v['lands']?></td>
		<td align="left"><?php if ($v['from']) {?><i class="iconfont icon-<?php echo $v['from']?>"></i><?php } else {?><i class="iconfont icon-shuyang"></i><?php }?></td>
        <td align="left"><?php echo $v['mobile']?></td>
		<td align="left"><?php echo $v['amount']?></td>
		<td align="left"><?php echo $v['loginnum']?></td>
		<td align="left">
			<a class="xbtn btn-info btn-xs"  href="javascript:edit(<?php echo $v['userid']?>, '<?php echo $v['username']?>')"><?php echo L('edit')?></a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?app=member&controller=member&view=lock'" value="<?php echo L('lock')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?app=member&controller=member&view=unlock'" value="<?php echo L('unlock')?>"/>
<input type="button" class="button" name="dosubmit" onclick="move();return false;" value="<?php echo L('move')?>"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>《'+name+'》',id:'edit',iframe:'?app=member&controller=member&view=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?app=member&controller=member&view=move&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

function member_infomation(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'<?php echo L('memberinfo')?>',id:'modelinfo',iframe:'?app=member&controller=member&view=memberinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

//-->
</script>
</body>
</html>

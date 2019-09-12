<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
    </tbody>
</table>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>UID</th>
			<th>昵称</th>
			<th>总签到次数</th>
            <th>周签到次数</th>
            <th>月签到次数</th>
			<th>连续签到</th>
			<th>签到总积分</th>
            <th>最后签到</th>
            <th>操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $v){
		?>
	<tr align="center">
		<td><?php echo $v['userid']; ?></td>
		<td><?php echo get_nickname($v['userid']); ?></td>
		<td><?php echo $v['count']; ?>次</td>
        <td><?php echo $v['weekcount']; ?>次</td>
        <td><?php echo $v['monthcount']; ?>次</td>
		<td><?php echo $v['continuous']; ?>天</td>
		<td><?php echo $v['getpoint']; ?></td>
		<td><?php echo date("Y-m-d H:i:s",$v['lasttime']); ?></td>
        <td>
        <a href="###"
			onclick="edit1(<?php echo $v['userid'];?>, '<?php echo get_nickname($v['userid']);?>')"
			>本周签到</a>
        <a href="###"
			onclick="edit2(<?php echo $v['userid'];?>, '<?php echo get_nickname($v['userid']);?>')"
			>本月签到</a>
         <a href="###"
			onclick="edit3(<?php echo $v['userid'];?>, '<?php echo get_nickname($v['userid']);?>')"
			>所有签到</a></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
function edit1(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:''+name+'周签到详情',id:'edit',iframe:'?app=sign&controller=sign&view=week_time_list&userid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function edit2(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:''+name+'月签到详情',id:'edit',iframe:'?app=sign&controller=sign&view=month_time_list&userid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function edit3(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:''+name+'所有签到详情',id:'edit',iframe:'?app=sign&controller=sign&view=time_list&userid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
</body>
</html>
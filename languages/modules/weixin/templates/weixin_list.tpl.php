<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
function drawTree($arr,$tree,$level){
    $level++;
    $prefix = str_pad("┗",$level+1,'-',STR_PAD_RIGHT);
    foreach($arr as $k2=>$v2)
    {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>"."$prefix$v2[name]&nbsp;&nbsp;&nbsp;&nbsp;";?> <a href="###" style="color:#999;" onclick="addevent(<?php echo $v2['id']?>, ' ')"
			title="添加响应事件">添加事件</a>&nbsp;|&nbsp;<a href="###" style="color:#999;" onclick="editmenu(<?php echo $v2['id']?>, ' ')"
			title="修改菜单">修改</a>&nbsp;|&nbsp;<a
			href='?app=weixin&controller=weixin&view=delete&id=<?php echo $v2['id']?>'
			style="color:#999;" onClick="return confirm('<?php echo L('confirm', array('message' => $v2['name']))?>')" title="删除<?php echo $v2['name']?>">删除</a></p>
<?php
        if(isset($tree[$v2['id']])) drawTree($tree[$v2['id']],$tree,$level);

    }
}
?>
<?php
function showCategory($array){
    $tree = array();
    if( $array ){
        foreach ( $array as $v ){
            $pid = $v['pid'];
            $list = @$tree[$pid] ?$tree[$pid] : array();
            array_push( $list, $v );
            $tree[$pid] = $list;
        }
    }     
    //遍历输出根分类
    foreach($tree[0] as $k=>$v){
		?>
    <?php echo "<b>".$v['name']."</b>" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if(is_pevent($v['id'])==0){?><a href="###" style="color:#999;" onclick="addevent(<?php echo $v['id']?>, ' ')"
			title="添加响应事件">添加事件</a>&nbsp;|&nbsp;<a href="###" style="color:#999;" onclick="addsmenu(<?php echo $v['id']?>, ' ')"
			title="添加子菜单">添子菜单</a>&nbsp;|<?php }elseif(is_pevent($v['id'])==1){?><a href="###" style="color:#999;" onclick="addevent(<?php echo $v['id']?>, ' ')"
			title="添加响应事件">添加事件</a>&nbsp;|<?php }elseif(is_pevent($v['id'])==2){?><a href="###" style="color:#999;" onclick="addsmenu(<?php echo $v['id']?>, ' ')"
			title="添加子菜单">添子菜单</a>&nbsp;|<?php }?>&nbsp;<a href="###" style="color:#999;" onclick="editmenu(<?php echo $v['id']?>, ' ')"
			title="修改菜单">修改</a>&nbsp;|&nbsp;<a
			href='?app=weixin&controller=weixin&view=delete&id=<?php echo $v['id']?>'
			style="color:#999;" onClick="return confirm('<?php echo L('confirm', array('message' => $v['name']))?>')" title="删除<?php echo $v['name']?>">删除</a><br />
            <?php
        //遍历输出根分类相应的子分类
        if($tree[$v['id']]) drawTree($tree[$v['id']],$tree,0);
        echo "<div style='height:10px;'></div>";
    }
}
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="search-form" >
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
		</div>
		</td>
		</tr>
    </tbody>
</table>
<table width="100%" cellspacing="0" class="search-form" >
    <tbody>
		<tr>
		<td> 
        <div style="margin-bottom:10px; background-color:#eef3f7;height:40px;line-height:40px;"> 
            <input type="submit" name="dosubmit" id="dosubmit" onclick="addpmenu(0, '添加父菜单')" class="button" value="添加菜单"><span style="color:#999;">（添加父级菜单）</span>
		</div>
        <div> 
         <?php showCategory($showmenu); ?>
        </div>
		</td>
		</tr>
    </tbody>
</table>
<form action="?app=weixin&controller=weixin&view=fabu" method="post" name="myform" id="myform">
<table width="100%" cellspacing="0" class="search-form" style="background-color:#f6f6f6;padding:5px 0px 5px 0px;height:40px;">
    <tbody>
		<tr>
		<td>
        <input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  发布到微信  ">
        </td>
    </tr>
    </tbody>
    </table>
</form>
<form action="?app=weixin&controller=weixin&view=fabuyixin" method="post" name="myform" id="myform">
<table width="100%" cellspacing="0" class="search-form" style="background-color:#f6f6f6;padding:5px 0px 5px 0px;height:40px;">
    <tbody>
		<tr>
		<td>
        <input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  发布到易信  ">
        </td>
    </tr>
    </tbody>
    </table>
</form>
<div class="bk15"></div>
</div>
<script type="text/javascript">
function addpmenu(id, name) {
	window.top.art.dialog({id:'addpmenu'}).close();
	window.top.art.dialog({title:''+name+' ',id:'addpmenu',iframe:'?app=weixin&controller=weixin&view=addpmenu',width:'400',height:'200'}, function(){var d = window.top.art.dialog({id:'addpmenu'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'addpmenu'}).close()});
}
function addsmenu(id, name) {
	window.top.art.dialog({id:'addsmenu'}).close();
	window.top.art.dialog({title:'添加子菜单 '+name+' ',id:'addsmenu',iframe:'?app=weixin&controller=weixin&view=addsmenu&id='+id,width:'400',height:'200'}, function(){var d = window.top.art.dialog({id:'addsmenu'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'addsmenu'}).close()});
}
function addevent(id, name) {
	window.top.art.dialog({id:'addevent'}).close();
	window.top.art.dialog({title:'添加子菜单事件 '+name+' ',id:'addevent',iframe:'?app=weixin&controller=weixin&view=addevent&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'addevent'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'addevent'}).close()});
}
function editmenu(id, name) {
	window.top.art.dialog({id:'editmenu'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editmenu',iframe:'?app=weixin&controller=weixin&view=editmenu&id='+id,width:'400',height:'200'}, function(){var d = window.top.art.dialog({id:'editmenu'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editmenu'}).close()});
}
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?app=link&controller=link&view=edit&linkid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
</body>
</html>
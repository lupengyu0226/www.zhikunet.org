<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：实时查询微信公众号菜单信息。
		</div>
		</td>
		</tr>
    </tbody>
</table>

<fieldset>
	<legend>微信菜单</legend>
	<?php showCate($new_arr); ?>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend>易信菜单</legend>
	<?php showCate($new_arr); ?>
</fieldset>
<div class="bk15"></div>
</div>
</body>
</html>

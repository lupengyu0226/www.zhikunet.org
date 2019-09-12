<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<form action="?app=weixin&controller=weixin&view=setting" method="post" id="myform">
<fieldset>
	<legend><?php echo L('weixin_module_configuration')?></legend>
</table>
	<table width="100%"  class="table_form">
    
  <tr>
    <th width="120"><?php echo L('token')?>：</th>
    <td class="y-bg"><input type="input" name="setting[token]" value="<?php echo  isset($data['token']) ? $data['token'] : '0'?>" size="50" /> <?php echo L('baserequirements')?></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('appid')?>：</th>
    <td class="y-bg"><input type="input" name="setting[appid]" value="<?php echo  isset($data['appid']) ? $data['appid'] : '0'?>" size="50" /> <?php echo L('requirements')?></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('appsecret')?>：</th>
    <td class="y-bg"><input type="input" name="setting[appsecret]" value="<?php echo  isset($data['appsecret']) ? $data['appsecret'] : '0'?>"  size="50" /> <?php echo L('requirements')?></td>
  </tr>
   <tr>
    <th width="120"><?php echo L('openid')?>：</th>
    <td class="y-bg"><input type="input" name="setting[openid]" value="<?php echo  isset($data['openid']) ? $data['openid'] : ''?>"  size="50" /> 管理员的微信号openid，用于群发预览</td>
  </tr>
   <tr>
    <th width="120">缺省缩略图：</th>
    <td class="y-bg"><?php echo form::images('setting[thumb]', 'thumb',$data['thumb'], 'weixin')?> 作为无缩略图或者缩略图路径错误启用图片(必须项)</td>
  </tr>
  <tr>
    <th width="120">URL服务器地址：</th>
    <td class="y-bg"> <span style="color:#0C0;"><?php echo $url?></span><span style="margin-left:10px;color:#999;">拷贝到开发者中心的服务器URL配置地址</span></td>
  </tr>
  <tr>
    <th width="120">易信APPID：</th>
    <td class="y-bg"><input type="input" name="setting[yixin_appid]" value="<?php echo  isset($data['yixin_appid']) ? $data['yixin_appid'] : '0'?>" size="50" /> <?php echo L('requirements')?></td>
  </tr>
  <tr>
    <th width="120">易信appsecret：</th>
    <td class="y-bg"><input type="input" name="setting[yixin_appsecret]" value="<?php echo  isset($data['yixin_appsecret']) ? $data['yixin_appsecret'] : '0'?>"  size="50" /> <?php echo L('requirements')?></td>
  </tr>
  <tr>
    <th width="120">客服工作时间：</th>
    <td class="y-bg">上班时间：<input type="input" name="setting[kefus]" value="<?php echo  isset($data['kefus']) ? $data['kefus'] : '09:00'?>"  size="10" /> 下班时间：<input type="input" name="setting[kefux]" value="<?php echo  isset($data['kefux']) ? $data['kefux'] : '18:00'?>"  size="10" />   <?php echo "格式：09:00(24小时制)"?></td>
  </tr>
</table>

<div class="bk15"></div>
<input type="submit" id="dosubmit" name="dosubmit" class="button" value="<?php echo L('submit')?>" />
</fieldset>
</form>
</body>
</html>
 
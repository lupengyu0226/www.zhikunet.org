<?php 
defined('IN_ADMIN') or exit('The resource access forbidden.');
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
  <h2 class="title-1 f14 lh28">(<?php echo $r['name'];?>)<?php echo L('get_code')?></h2>
  <div class="bk10"></div>
  <div class="explain-col"> <strong><?php echo L('explain')?>：</strong> </div>
  <div class="bk10"></div>
  <fieldset>
    <legend><?php echo L('one_way')?></legend>
    <input name="jscode1" id="jscode1" value='{ssi "/caches/posid/<?php echo $r['tag']?>.html"}' style="width:410px">
  </fieldset>
  <div class="bk10"></div>
  <fieldset>
    <legend><?php echo L('two_way')?></legend>
    <input name="jscode2" id="jscode2" value='<!--#include virtual="/caches/posid/<?php echo $r['tag']?>.html"-->' style="width:410px">
  </fieldset>
  <div class="bk10"></div>
  <fieldset>
    <legend><?php echo L('three_way')?></legend>
    <input name="jscode3" id="jscode3" value='{php require SHUYANG_PATH."/caches/posid/<?php echo $r['tag']?>.html";}' style="width:410px">
  </fieldset>
</div>
</body></html>
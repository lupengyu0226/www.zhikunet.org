<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<form action="?app=template&controller=style&view=updatename" method="post">
        <div class="template_show">    
    </div>
<ul class="tpl_main">
<?php 
if(is_array($list)):
        foreach($list as $v):
?>

        <li>
            <div class="tpl_content">                
                <div class="tpl_img"><?php $source = $this->filepath.$v['dirname'].'/'.$v['images']; if(!is_file($source)) { echo '<img src="'.TPL_IMAGES_PATH.'default/default.jpg" width="160px" height="160px"/> ';} else { echo '<img src="'.TPL_IMAGES_PATH.$v['dirname'].'/'.$v['images'].'" width="160px" height="160px"/> ';} ?>
            <?php if($v['disable']){echo "<div class='tpl_call' style='background:url(".IMG_PATH."admin_img/templates_but.png) -45px -10px;  '></div>";}else{echo "<div class='tpl_call' style='background:url(".IMG_PATH."admin_img/templates_but.png) -10px -10px;  '></div> ";}?>
            </div>
            <div class="tpl_infos">
                    <p><?php echo L("style_identity")?> : <?php echo $v['dirname']?></p>
                    <p><?php echo L("author")?> : <?php if($v['homepage']) {echo  '<a href="'.$v['homepage'].'" target="_blank">';}?><?php echo $v['author']?><?php if($v['homepage']) {echo  '</a>';}?> </p>
                <p><?php echo L("style_version")?> : <?php echo $v['version']?></p>
            </div>
                <div class="tpl_info">
                    <div class="chinese_name">
                        <div class="title"><?php echo $v['name']?></div>
                    <span class="edit"  style="display:none;"><input type="text" name="name[<?php echo $v['dirname']?>]" value="<?php echo $v['name']?>" /> </span>
                </div>
                    <div class="tpl_butlist">
                        <div class="tpl_but"><a href="?app=template&controller=style&view=disable&style=<?php echo $v['dirname']?>"><?php if($v['disable']){echo L("enable");}else{echo L('disable');}?></a> </div>
                        <div class="tpl_but"><a href="?app=template&controller=file&view=init&style=<?php echo $v['dirname']?>"><?php echo L("detail")?></a></div>
                    <div class="tpl_but" style=" border:none; width:54px;"><a href="?app=template&controller=style&view=export&style=<?php echo $v['dirname']?>"><?php echo L('export')?></a></div>
                    <div class="clear"></div>
                </div>
            </div>        
        </div>    
    </li>
<?php 
        endforeach;
endif;
?>
<div class="clear"></div>
</ul>
</tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" /></div> 
</form>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>

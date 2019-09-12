<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?>	<!--导航 start-->
<div class="community-nav community-business">
            		<div class="community-990">
            			<div class="nav-box">
            				<ul>
            					<li class="n-t-2">
            						<a href="<?php echo siteurl($siteid);?>" title="智库网" target="_self" class="<?php if(!$catid) { ?> current <?php } ?>">首页</a>
            					</li>
								<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=7f225ed97e9b124670350ca309e423cc&action=category&catid=0&num=21&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'21',));}?>
									<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
            					<li class="<?php if($n < 8) { ?> n-t-2  t-2-4 <?php } else { ?> n-t-4 t-4-4<?php } ?>">
            						<a href="<?php echo $r['url'];?>" title="<?php if($n >5) { ?>在职研究生招生<?php } ?><?php echo $r['catname'];?>" target="_self" class="<?php if($r['catid']==$catid) { ?> current <?php } ?>"><?php echo $r['catname'];?><?php if($n ==7 ) { ?><sup style="color: red;font-style: italic;position:absolute;top:-10px;">hot!</sup><?php } ?></a>
            					</li>
								<?php $n++;}unset($n); ?>
								<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            					
            					<li class="n-t-3 t-4-4">
            						<a href="/" title="在职研究生招生专题" target="_self" class="">专题<sup style="color: yellow;font-style: italic;position:absolute;top:-10px;">new!</sup></a>
            					</li>
									
            					
            					<!--<li class="n-t-2 t-2-3">
            						<a href="https://view.1688.com/cms/baike/baike_help/index.html" title="" target="_self" class="">帮助</a>
            					</li>-->
            				</ul>
                          <span class= "last-item"> 
                        <a href="https://club.zhikunet.org" title="" target="_self" class="">去校友圈看看&nbsp;&nbsp;&gt</a>
                </span>
            			</div>
            		</div>
            	</div>
	<!--导航end-->

<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin'); ?>
<div id="closeParentTime" style="display:none"></div>

<div class="pad-10">
    <div id="searchid">
        <form name="searchform" action="" method="get">
            <input type="hidden" value="custom_search" name="app">
            <input type="hidden" value="search_word_list" name="controller">
            <input type="hidden" value="search_word_list" name="view">
            <input type="hidden" value="1" name="search">

            <table width="100%" cellspacing="0" class="search-form">
                <tbody>
                <tr>
                    <td>
                        <div class="explain-col">
                            来源：
                            <select name="search_from">
                                <option value="all">全部</option>
                                <option value="pc" <?php if($_GET['search_from']=='pc') echo 'selected'; ?> >电脑</option>
                                <option value="wap" <?php if($_GET['search_from']=='wap') echo 'selected'; ?> >手机</option>
                                <option value="weixin" <?php if($_GET['search_from']=='weixin') echo 'selected'; ?> >微信</option>
                            </select>
                            搜索时间：
                            <?php echo form::date('start_time', $_GET['start_time'], 0, 0, 'false'); ?>-
                            &nbsp;<?php echo form::date('end_time', $_GET['end_time'], 0, 0, 'false'); ?>


                            搜索词：
                            <input name="search_word" type="text" value="<?php if (isset($search_word)) echo $search_word; ?>"
                                   class="input-text"/>
                            <input type="submit" name="search" class="button" value="<?php echo L('search'); ?>"/>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <form name="myform" id="myform" action="" method="post">
        <div class="table-list">
            <table width="100%">
                <thead>
                <tr>
                    <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
                    <th width="40">ID</th>
                    <th>关键词</th>
                    <th>搜索次数
                        <div class="tab-use">
                            <div style="position:relative">
                                <div class="arrows cu" onmouseover="hoverUse('use-div');" onmouseout="hoverUse();" onmouseover="this.style.display='block'"></div>
                                <ul id="use-div" class="tab-web-panel" onmouseover="this.style.display='block'"  onmouseout="hoverUse('use-div');">
                                    <li><a class="xbtn btn-info btn-xs" href="index.php?app=custom_search&controller=search_word_list&view=search_word_list&order_by=desc<?php if(!empty($search_from))echo '&search_from='.$search_from;if(!empty($start_time))echo '&start_time='.date('Y-m-d',$start_time);if(!empty($end_time))echo '&end_time='.date('Y-m-d',$end_time);if(!empty($search_word))echo '&search_word='.$search_word;?>">从多到少</a></li>
                                    <li><a class="xbtn btn-primary btn-xs" href="index.php?app=custom_search&controller=search_word_list&view=search_word_list&order_by=asc<?php if(!empty($search_from))echo '&search_from='.$search_from;if(!empty($start_time))echo '&start_time='.date('Y-m-d',$start_time);if(!empty($end_time))echo '&end_time='.date('Y-m-d',$end_time);if(!empty($search_word))echo '&search_word='.$search_word;?>">从少到多</a></li>
                                </ul>
                            </div>
                        </div>
                    </th>
                    <th>来源</th>
                    <th>最后一次搜索时间</th>
                    <th>搜索者IP</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $r){?>
                <tr>
                    <td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
                    <td align='center' ><?php echo $r['id'];?></td>
                    <td align='center' ><?php echo $r['search_word'];?></td>
                    <td align='center' ><?php echo $r['search_times'];?></td>
                    <?php
                        switch($r['search_from']){
                            case 'pc':
                                $word_from = '电脑';
                                break;
                            case 'wap':
                                $word_from = '手机';
                                break;
                            case 'weixin':
                                $word_from = '微信';
                                break;
                            default:
                                $word_from = '未知';
                        }
                    ?>
                    <td align='center' ><?php echo $word_from; ?></td>
                    <td align='center' ><?php echo date('Y-m-d H:i:s', $r['last_search_time']);?></td>
                    <td align='center' ><?php echo $r['ip'];?> <?php echo $ip_area->get($r['ip']); ?></td>
                </tr>
                <?php }?>
                </tbody>
            </table>
            <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
                <label><?php echo "总共:<span style='color:#ff00ff; font-weight:bold;'>".$total."</span>条"; ?></label>
                <input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?app=custom_search&controller=search_word_list&view=delete';return confirm_delete()"/>
            </div>
            <div id="pages"><?php echo $pages;?></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    function confirm_delete(){
        if(confirm('<?php echo L('确认删除？', array('message' => L('selected')));?>')) $('#myform').submit();
    }
    function hoverUse(target){
        if($("#"+target).css("display") == "none"){
            $("#"+target).show();
        }else{
            $("#"+target).hide();
        }
    }
</script>
</body>
</html>
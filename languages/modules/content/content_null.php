<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定义在单独操作内容的时候，同时更新相关栏目页面
define('RELATION_HTML',true);

shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
shy_base::load_app_func('util');
shy_base::load_sys_class('format','',0);

class content_null extends admin {
    private $db,$priv_db;
    public $siteid,$categorys;
    public function __construct() {
        parent::__construct();
        $this->db = shy_base::load_model('content_model');
        $this->caiji_db = shy_base::load_model('collection_content_model');
        $this->siteid = $this->get_siteid();
        $this->categorys = getcache('category_content_'.$this->siteid,'commons');
        //权限判断
        if(isset($_GET['catid']) && $_SESSION['roleid'] != 1 && ROUTE_A !='pass' && strpos(ROUTE_A,'public_')===false) {
            $catid = intval($_GET['catid']);
            $this->priv_db = shy_base::load_model('category_priv_model');
            $action = $this->categorys[$catid]['type']==0 ? ROUTE_A : 'init';
            $priv_datas = $this->priv_db->get_one(array('catid'=>$catid,'is_admin'=>1,'action'=>$action));
            if(!$priv_datas) showmessage(L('permission_to_operate'),'blank');
        }
    }
    
    public function init() {
         $show_header = $show_dialog  = $show_safe_edi = '';
        $modelid = 1;
            $admin_username = param::get_cookie('admin_username');
            //查询当前的工作流
            $setting = string2array($category['setting']);
            $workflowid = $setting['workflowid'];
            $workflows = getcache('workflow_'.$this->siteid,'commons');
            $workflows = $workflows[$workflowid];
            $workflows_setting = string2array($workflows['setting']);

            //将有权限的级别放到新数组中
            $admin_privs = array();
            foreach($workflows_setting as $_k=>$_v) {
                if(empty($_v)) continue;
                foreach($_v as $_value) {
                    if($_value==$admin_username) $admin_privs[$_k] = $_k;
                }
            }
            //工作流审核级别
            $workflow_steps = $workflows['steps'];
            $workflow_menu = '';
            $steps = isset($_GET['steps']) ? intval($_GET['steps']) : 0;
            //工作流权限判断
            if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
            $this->db->set_model($modelid);
            if($this->db->table_name==$this->db->db_tablepre) showmessage(L('model_table_not_exists'));;
            $status = $steps ? $steps : 1;
            if(isset($_GET['reject'])) $status = 0;
            $where = 'status='.$status;
            //搜索
            
            if(isset($_GET['start_time']) && $_GET['start_time']) {
                $start_time = strtotime($_GET['start_time']);
                $where .= " AND `inputtime` > '$start_time'";
            }
            if(isset($_GET['end_time']) && $_GET['end_time']) {
                $end_time = strtotime($_GET['end_time']);
                $where .= " AND `inputtime` < '$end_time'";
            }
            if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
            if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                $type_array = array('title','description','username');
                $searchtype = intval($_GET['searchtype']);
                if($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $keyword = strip_tags(trim($_GET['keyword']));
                    $where .= " AND `$searchtype` like '%$keyword%'";
                } elseif($searchtype==3) {
                    $keyword = intval($_GET['keyword']);
                    $where .= " AND `id`='$keyword'";
                }
            }
            if(isset($_GET['posids']) && !empty($_GET['posids'])) {
                $posids = $_GET['posids']==1 ? intval($_GET['posids']) : 0;
                $where .= " AND `posids` = '$posids'";
            }
            $wheresql = '`siteid`=\''.$this->get_siteid().'\'';
            $datas = $this->db->listinfo($where,'id desc',$_GET['page']);
            $caijidatas = $this->caiji_db->listinfo($wheresql,'id desc',$_GET['page'],10);
            $pages = $this->db->pages;
            $safe_edi = $_SESSION['safe_edi'];
            for($i=1;$i<=$workflow_steps;$i++) {
                if($_SESSION['roleid']!=1 && !in_array($i,$admin_privs)) continue;
                $current = $steps==$i ? 'class=on' : '';
                $r = $this->db->get_one(array('catid'=>$catid,'status'=>$i));
                $newimg = $r ? '<img src="'.IMG_PATH.'icon/new.png" style="padding-bottom:2px" onclick="window.location.href=\'?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&safe_edi='.$safe_edi.'\'">' : '';
                $workflow_menu .= '<a href="?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&safe_edi='.$safe_edi.'" '.$current.' ><em>1'.L('workflow_'.$i).$newimg.'</em></a><span>|</span>';
            }
            if($workflow_menu) {
                $current = isset($_GET['reject']) ? 'class=on' : '';
                $workflow_menu .= '<a href="?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&safe_edi='.$safe_edi.'&reject=1" '.$current.' ><em>'.L('reject').'</em></a><span>|</span>';
            }
            include $this->admin_tpl('content_null_list');
    }

    /**
     * 删除
     */
    public function delete() {
        if(isset($_GET['dosubmit'])) {
            $status = intval($_GET['status']);
            if(!$status) showmessage(L('missing_part_parameters'));
            $modelid = 1;
            //$sethtml = $this->categorys[$catid]['sethtml'];
            //$siteid = $this->categorys[$catid]['siteid'];
            $this->db->set_model($modelid);
            $this->hits_db = shy_base::load_model('hits_model');
            $this->queue = shy_base::load_model('queue_model');
            $this->search_db = shy_base::load_model('search_model');

            $search_model = getcache('search_model_1','search');
            $typeid = $search_model[$modelid]['typeid'];
            $catid = 0;
            foreach($_POST['ids'] as $id) {
                $r = $this->db->get_one(array('id'=>$id));
                //删除内容
                $this->db->delete_content($id,$catid,$status);
                //删除统计表数据
                $this->hits_db->delete(array('hitsid'=>'c-1-'.$id));
                //删除全站搜索中数据
                $this->search_db->delete_search($typeid,$id);
            }
            //更新栏目统计
            $this->db->cache_items();
            showmessage(L('operation_success'),HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'));
        }
    }
              
}
?>



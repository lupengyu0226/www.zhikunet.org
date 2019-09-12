<?php
/*
SELECT  catid, sum( hits )AS total
FROM`v9_c_stats` 
GROUPBY catid
LIMIT 0 , 30
*/
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
shy_base::load_app_func('global');
class stats extends admin {
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('c_stats_model');
		$this->siteid = $this->get_siteid();
		$this->category_db = shy_base::load_model('category_model');
	}
	
	public function init () {
		$where = '';
		$start_time = $_GET['start_time'];
		$end_time = $_GET['end_time'];
		if($start_time && preg_match('/^20([0-9]{2}-[0-9]{2}-[0-9]{2})/',$start_time)) {
			$where = "WHERE adddate>='$start_time'";
		}
		if($end_time && preg_match('/^20([0-9]{2}-[0-9]{2}-[0-9]{2})/',$end_time)) {
			if($where) {
				$where .= " AND adddate<='$end_time'";
			} else {
				$where = "WHERE adddate<='$end_time'";
			}
		}
		//echo "SELECT  catid, sum( hits ) AS total FROM `shuyang_c_stats` $where GROUP BY catid LIMIT 0,1000";
		$query = $this->db->query("SELECT  catid, sum( hits ) AS total ,sum( mhits ) AS tsotal FROM `shuyang_c_stats` $where GROUP BY catid LIMIT 0,1000");
		$datas = $this->db->fetch_array();
		$hitsdb = array();
		$pctotal=0;
		foreach( $datas as $r ){
			$hitsdb[$r['catid']] = $r['total'];
			$pctotal+=$r['total'];
		}
		$mhitsdb = array();
		$mtotal=0;
		foreach( $datas as $r ){
			$mhitsdb[$r['catid']] = $r['tsotal'];
			$mtotal+=$r['tsotal'];
		}
		$siteid = $this->siteid;
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		$tree = shy_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		$this->catids_string = array();
		foreach($this->categorys as $r) {
			if($r['siteid']!=$siteid || $r['type']==2) continue;
			if($r['child']) {
				$r['style'] = 'color:#8A8A8A;';
			} else {
				$r['style'] = '';
			}
			$r['views'] = $r['type']==1 ? '' : '点击查看';
			$r['hits'] = $hitsdb[$r['catid']];
			$r['mhits'] = $mhitsdb[$r['catid']];
			if(!$r['hits']) $r['hits'] = 0;
			if(!$r['mhits']) $r['mhits'] = 0;
			$categorys[$r['catid']] = $r;
		}
		$str  = "<tr>
					<td align='center'>\$catid</td>
					<td style='\$style'>\$spacer\$catname</td>
					<td align='center'>\$hits</td>
					<td align='center'>\$mhits</td>
					<td align='center'><a class='xbtn btn-info btn-xs' href='?app=stats&controller=stats&view=hits&catid=\$catid'>\$views</a></td>
				</tr>";
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		include $this->admin_tpl('stats_list');
	}
	function hits() {
		$show_header = $show_dialog  = '';
		shy_base::load_sys_class('format','',0);
		$catid = $_GET['catid'];
		$content_tag = shy_base::load_app_class("content_tag", "content");
		$datas = $content_tag->hits(array('catid'=>$catid,'order'=>'views DESC','limit'=>'100'));
		//print_r($datas);
		$siteid = $this->siteid;
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		$catname = $this->categorys[$catid]['catname'];
		$category = $this->categorys[$catid];
		include $this->admin_tpl('hits');
	}

}

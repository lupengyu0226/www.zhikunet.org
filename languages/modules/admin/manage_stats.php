<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_app_func('admin');
shy_base::load_sys_class('form');
class manage_stats extends admin {
	private $db,$role_db;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('admin_model');
		$this->role_db = shy_base::load_model('admin_role_model');
		$this->siteid =  $this->get_siteid();
	}
	
	/**
	 * 统计
	 */
	 public function init() {
		 return $this->viewByTime();
	 }
	/**
	 * 多用户统计
	 */
	public function viewByTime() {//总体查看	
		$manage_stats = shy_base::load_model('manage_stats_model');
		$admin_username = param::get_cookie('admin_username');
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d',SYS_TIME);
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d',SYS_TIME);
		$start_time_sql =  str_replace("-","",$start_time);
		$end_time_sql = str_replace("-","",$end_time);
		$manage_stats->query("select username,stat_time,SUM(`add`) as `add`,SUM(`edit`) as `edit`,SUM(`delete`) as `delete`,SUM(`check`) as `check`,SUM(`position`) as `position`,SUM(`push`) as `push`,SUM(`listorder`) as `listorder`,SUM(`check_comment`) as `check_comment`,SUM(`delete_comment`) as `delete_comment`,SUM(`delete_attachment`) as `delete_attachment` from shuyang_manage_stats where stat_time>='$start_time_sql' and  stat_time<='$end_time_sql' group BY username");
		$infos = $manage_stats->fetch_array();
		$pages = $manage_stats->pages;
		$roles = getcache('role','commons');
		include $this->admin_tpl('dstats_view');
	}
	/**
	 * 单用户统计用户列表
	 */
	public function viewByUser() {
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$infos = $this->db->listinfo('', '', $page, 20);
		$pages = $this->db->pages;
		$roles = getcache('role','commons');
		include $this->admin_tpl('manage_stats');
	}
	/**
	 * 单用户统计
	 */
	public function viewOneUser() {
		$manage_stats = shy_base::load_model('manage_stats_model');
		$username = $_GET['username'];
		$admin_username = param::get_cookie('admin_username');
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d',SYS_TIME);
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d',SYS_TIME);
		$start_time_sql =  str_replace("-","",$start_time);
		$end_time_sql = str_replace("-","",$end_time);
		$manage_stats->query("select * from shuyang_manage_stats where username='$username' and stat_time>='$start_time_sql' and  stat_time<='$end_time_sql' order by stat_time");
		$infos = $manage_stats->fetch_array();
		$pages = $manage_stats->pages;
		$roles = getcache('role','commons');
		include $this->admin_tpl('stats_view');
	}
	/**
	 * 查看添加的文章列表
	 */
	public function detail_add() {
		$show_header = 1;
		$username = $_GET['username'];
		$sitelist  = getcache('sitelist','commons');
		$CATEGORYS = getcache('category_content_'.$this->siteid,'commons');
		$manage_stats_add = shy_base::load_model('manage_stats_add_model');
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$infos = $manage_stats_add->listinfo("username='$username'",'id DESC', $page,25);
		$pages = $manage_stats_add->pages;
		$this->hits_db = shy_base::load_model('hits_model');
		include $this->admin_tpl('detail_add');
	}
}
?>

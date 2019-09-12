<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',SHUYANG_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
set_time_limit(0);
shy_base::load_app_class('admin', 'admin', 0);
shy_base::load_sys_class('form', '', 0);

class nodes{

	private $db,$siteid;
	
	//HTML标签
	private static $html_tag = array("<p([^>]*)>(.*)</p>[|]"=>'<p>', "<a([^>]*)>(.*)</a>[|]"=>'<a>',"<script([^>]*)>(.*)</script>[|]"=>'<script>', "<iframe([^>]*)>(.*)</iframe>[|]"=>'<iframe>', "<table([^>]*)>(.*)</table>[|]"=>'<table>', "<span([^>]*)>(.*)</span>[|]"=>'<span>', "<b([^>]*)>(.*)</b>[|]"=>'<b>', "<img([^>]*)>[|]"=>'<img>', "<object([^>]*)>(.*)</object>[|]"=>'<object>', "<embed([^>]*)>(.*)</embed>[|]"=>'<embed>', "<param([^>]*)>(.*)</param>[|]"=>'<param>', '<div([^>]*)>[|]'=>'<div>', '</div>[|]'=>'</div>', '<!--([^>]*)-->[|]'=>'<!-- -->');
	
	//网址类型
	private $url_list_type = array();
	
	function __construct() {
		$this->db = shy_base::load_model('collection_node_model');
		$this->siteid = get_siteid();
		$this->url_list_type = array('1'=>L('sequence'), '2'=>L('multiple_pages'), '3'=>L('single_page'), '4'=>'RSS');
		
	}

	//采集网址
	public function col_url_list() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			//print_r($data);
			shy_base::load_app_class('collection','collection', 0);

			$urls = collection::url_list($data);
			$total_page = (is_array( $urls ) && !empty( $urls ))?count( $urls ):0;
			//print_r($urls);
			//exit;
			$attach_status = false;
			
			if(shy_base::load_config('system','attachment_stat')) {
				$this->attachment_db = shy_base::load_model('attachment_model');
				$att_index_db = shy_base::load_model('attachment_index_model');
				$attach_status = true;
			}			
			$funcs_file_list = glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'spider_funs'.DIRECTORY_SEPARATOR.'*.php');
				foreach ($funcs_file_list as $v_function) {
					include_once $v_function;
			}

			for ($x=0; $x<=$total_page; $x++) {
				$url_list = $urls[$x];
				$url = collection::get_url_lists($url_list, $data);
				//print_r($url);
				//exit;
				$history_db = shy_base::load_model('collection_history_model');
				$collection_content_db = shy_base::load_model('collection_content_model');
				$total = (is_array( $url ) && !empty( $url ))?count( $url ):0;
				$re = 0;

				if (is_array($url) && !empty($url))
				{	
					foreach ($url as $v) {

					if (empty($v['url']) || empty($v['title'])) continue;
					$v = new_addslashes($v);
					$v['title'] = strip_tags($v['title']);
					$md5 = md5($v['url']);
					if (!$history_db->get_one(array('md5'=>$md5, 'siteid'=>get_siteid()))) {//历史中不存在该md5值得就插入
						$history_db->insert(array('md5'=>$md5, 'siteid'=>get_siteid()));
						$collid=$collection_content_db->insert(array('nodeid'=>$nodeid, 'status'=>0, 'url'=>$v['url'], 'title'=>$v['title'], 'siteid'=>get_siteid()),true);
						$GLOBALS['downloadfiles'] = array();
						$html = collection::get_content($v['url'],$data);
						if($attach_status) {
							$this->attachment_db->api_update($GLOBALS['downloadfiles'],'cj-'.$collid,1);
						}
						$collection_content_db->update(array('status'=>1, 'data'=>array2string($html)), array('id'=>$collid));
		
						//采集结束
						//开始导入
						$programid = isset($_GET['programid']) ? intval($_GET['programid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
						$program_db = shy_base::load_model('collection_program_model');
						$content_db = shy_base::load_model('content_model');
						
						//通过collid来查询
							$content_data = $collection_content_db->get_one(array('siteid'=>get_siteid(), 'nodeid'=>$nodeid, 'status'=>1,'id'=>$collid));
							
							$program = $program_db->get_one(array('id'=>$programid));
							$program['config'] = string2array($program['config']);
							$_POST['add_introduce'] = $program['config']['add_introduce'];
							$_POST['introcude_length'] = $program['config']['introcude_length'];
							$_POST['auto_thumb'] = $program['config']['auto_thumb'];
							$_POST['auto_thumb_no'] = $program['config']['auto_thumb_no'];
							$_POST['spider_img'] = 0;
							$content_db->set_model($program['modelid']);
	
							$sql = array('catid'=>$program['catid'], 'status'=>$program['config']['content_status']);
							$content_data['data'] = string2array($content_data['data']);
										
										foreach ($program['config']['map'] as $a=>$b) {
											if (isset($program['config']['funcs'][$a]) && function_exists($program['config']['funcs'][$a])) {
												$GLOBALS['field'] = $a;
												$sql[$a] = $program['config']['funcs'][$a]($content_data['data'][$b]);
											} else {
												$sql[$a] = $content_data['data'][$b];
											}
										}
										if ($data['content_page'] == 1) $sql['paginationtype'] = 2;
										$contentid = $content_db->add_content($sql, 1);
										if ($contentid) {
											$coll_contentid[] = $content_data['id'];
											//$i++;
											//更新附件状态,将采集关联重置到内容关联
											if($attach_status) {
												$datas = $att_index_db->select(array('keyid'=>'cj-'.$content_data['id']),'*',100,'','','aid');
												if(!empty($datas)) {
													$datas = array_keys($datas);
													$datas = implode(',',$datas);
													$att_index_db->update(array('keyid'=>'c-'.$program['catid'].'-'.$contentid),array('keyid'=>'cj-'.$content_data['id']));
													$this->attachment_db->update(array('module'=>'content')," aid IN ($datas)");
												}
											}
											$collection_content_db->update(array('status'=>2),array('id'=>$content_data['id']));
										} else {
											$collection_content_db->delete(array('id'=>$content_data['id']));
										}							
							
						
						//导入结束
						
					} else {
						$re++;
						}
					}
				}
				if ($total_page <= $page) {
					$this->db->update(array('lastdate'=>SYS_TIME), array('nodeid'=>$nodeid));
				}
			} 
		} 
	}
	


	
}
?>
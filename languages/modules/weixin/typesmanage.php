<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class typesmanage extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->dbmember_group= shy_base::load_model('weixin_member_group_model');
		$this->dbsent_group_news= shy_base::load_model('weixin_sent_group_news_model');
		$this->sites = shy_base::load_app_class('sites','admin');

		$this->model_db = shy_base::load_model('model_model');
		$this->sites = shy_base::load_app_class('sites','admin');//20141211
		shy_base::load_app_func('global','weixin');
	}
   public function init() {
		
	}
	public function catlist(){
		$big_menu = array('javascript:;', L('群发'));
		$group_news=$this->dbsent_group_news->select(array('havedsent'=>0),'*',100,'id DESC');	
		$grouplist =$this->dbmember_group->listinfo();
		$thumb = '<i class="iconfont icon-img" style="color:green"></i>';
		$warning='<i class="iconfont icon-wailian"></i>';
		include $this->admin_tpl('weixin_type_lists');
	}
	public function havedset(){
		if(isset($_POST['dosubmit'])){
			if((!isset($_POST['id']) || empty($_POST['id']))) {
			  showmessage(L('illegal_parameters'), HTTP_REFERER);
		    } 
			  foreach($_POST['id'] as $overid) {
						  $this->dbsent_group_news->update(array('havedsent'=>0),array('id'=>$overid));
					  }
			   showmessage(L('operation_success'), HTTP_REFERER);	
			}else{
				//已发送的文章
			  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			  $group_news= $this->dbsent_group_news->listinfo(array('havedsent'=>1),'id DESC',$page, $pagesize = '20');
			  $pages = $this->dbsent_group_news->pages;	
			}
		include $this->admin_tpl('weixin_group_sented_list');
	}
	public function selfromcate(){//get
		$big_menu = array('javascript:;', L('站内内容'));
	    $sql =  "";
		if(isset($_GET['dosubmit'])&& $_GET['catid']!=0){
 		$catid = intval($_GET['catid']);//栏目ID
		$sql .= $sql."`catid`='$catid'";
		$starttime = isset($_GET['starttime']) && trim($_GET['starttime']) ? trim($_GET['starttime']) : '';
		$endtime = isset($_GET['endtime'])  &&  trim($_GET['endtime']) ? trim($_GET['endtime']) : '';
		$s_starttime=strtotime(trim($_GET['starttime']));
		$s_endtime=strtotime(trim($_GET['endtime']));
		if (!empty($s_starttime) && empty($s_endtime)) {
				$s_endtime = SYS_TIME;
			}
			if (!empty($s_starttime) && !empty($s_endtime) && $s_endtime < $s_starttime) {
				showmessage(L('时间错误：开始时间大于结束时间'));
			}
			if (!empty($s_starttime)) {
				$sql .= $sql ? " AND `inputtime` BETWEEN '$s_starttime' AND '$s_endtime' " : " `inputtime` BETWEEN '$s_starttime' AND '$s_endtime' ";
			}
		$datas = $this->model_db->soaech_cate_lists($catid,$sql);
		}else{
			
			$datas = $this->model_db->get_catlists(26);//默认选择栏目ID=6
			$catid =26;
		}
		//栏目列表
		$thumb = '<i class="iconfont icon-img" style="color:green"></i>';
		$warning='<i class="iconfont icon-wailian"></i>';
		include $this->admin_tpl('weixin_selfrom_cate');
	}
	//选择文章
	public function addsselect(){
		if(isset($_POST['dosubmit'])) {
			$replyid = intval($_POST['replyid']);
			$siteid = intval($_POST['siteid']);
			$catid = intval($_POST['catid']);
			if(!is_array($_POST['id'])){
				showmessage(L('parameter_error'),HTTP_REFERER);
			}	
				foreach($_POST['id'] as $id_arr) {
					$info=$this->model_db->get_single($catid,$id_arr);
					$data=array();
					$data['aid']=$id_arr;
					$data['title']=$info['title'];
					$data['catid']=$info['catid'];
					$data['url']=S($info['url']);
					if(empty($info['thumb'])) {
				         $info['thumb']=get_defaultthumb();
						 $info['thumb']=thumb($info['thumb'],500,0);
						 
			        }else{
						$info['thumb']=thumb(trim($info['thumb']),500,0);
					}
					$media_data=get_media_id($info['thumb'],'image');
					if (isset($media_data['errcode'])){
					   echo '上传媒体错误类型：'.globalreturncode($media_data['errcode']);
					   break; 
					}
					$data['thumb']=$info['thumb'];
					$data['thumb_media_id']=$media_data;
					$data['description']=str_cut($info['description'], 210);
					$data['content']=$info['content'];
					$data['author']=$info['copyfrom'];
					$data['isselect']=1;
					$data['inputtime']=time();
					$data['updatetime']=time();
					$ids=array();
					$isrepeat=$this->dbsent_group_news->get_one(array('aid'=>$id_arr,'catid'=>$data['catid']));
					if($isrepeat){
						continue; 
					}
					$ids=array();
 					$ids[]=$this->dbsent_group_news->insert($data,true);
				}
				showmessage(L('operation_success'), HTTP_REFERER);	
		}
	}
	//分组群发(文本消息)
	public function sent_group_message(){
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['group']['content'])||$_POST['group_id']=='') {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			} 
				$content = safe_replace($_POST['group']['content']);
			    $group_id=$_POST['group_id'];
			$jsongroup=array();
		    $json_group_message=array('filter'=>array('group_id'=>$group_id),'text'=>array('content'=>$content),'msgtype'=>'text');
		    $jsondata=JSON($json_group_message);
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			//var_dump($result);
			$arr_result=json_decode($result, true); 
			if($arr_result['errcode']==0){
				$_POST['group']['havedsent']=1;
				$this->dbsent_group_news->insert($_POST['group']);
			  showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
		 $array =$this->dbmember_group->listinfo();	
         include $this->admin_tpl('weixin_addgroupmessage');
	}
	public function cancelsel(){
		if(!isset($_GET['id']) &&!$_GET['id']){
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		$id = intval($_GET['id']);
		$result=$this->dbsent_group_news->update(array('isselect'=>0),array('id'=>$id));
		if($result){
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	//选取栏目内容向分组发送图文消息
	public function sent_colnews_togroup(){
	 if(isset($_POST['dosubmit'])) {
		if((!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} 
		   $catid=intval($_POST['catid']);
			if(is_array($_POST['id'])){
				if(count($_POST['id']) >9){
			      showmessage('发送的图文不能多于9条,请重选！', HTTP_REFERER);
		         } 
				 $num=1;
				foreach($_POST['id'] as $id_arr) {
					$info = $this->dbsent_group_news->get_one(array('id'=>$id_arr));
				     if($num==1){
					  $show_cover_pic=1;
						
					  }else{
					  $show_cover_pic=0;
					  }
					  
					  $news_data[] = array(
					    'thumb_media_id'=>$info['thumb_media_id'],
						'author'=>$info['author'],
						'title'=>$info['title'],
						'content_source_url'=>$url = $info['url'],
						'content'=>addslashes(replacewximg($info['content'])),
						'digest'=>$info['description'],
						'show_cover_pic'=>$show_cover_pic
						);	
					  $num++;
				}
				//组成多图文数组
				$array_message=array('articles'=>$news_data);					  
					  									                								            											           																						
			}
	        $group_id = intval($_POST['group_id']);
		    $jsondata=JSON($array_message);
			$access_token = get_access_token();
			if($access_token){	
			$url="https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$result_arr=json_decode($result,true);
			if (array_key_exists('errcode',$result_arr)){  
					   echo '获取传媒体media_id错误，'.globalreturncode($result_arr['errcode']);
					   exit;
					}
			$media_id = $result_arr['media_id'];
			$arr_group_messages=array('filter'=>array('group_id'=>$group_id),'mpnews'=>array('media_id'=>$media_id),'msgtype'=>'mpnews');
		    $jsondatas=JSON($arr_group_messages);
			$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$access_token;
			$results = https_request($url,$jsondatas);
			$arr_result=json_decode($results, true); 
			if($arr_result['errcode']==0){
				foreach($_POST['id'] as $overid) {
					$this->dbsent_group_news->update(array('havedsent'=>1),array('id'=>$overid));
				}
			  showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				echo globalreturncode($arr_result['errcode']);
				}
		}
	 }
	}
	//手动添加群分图文消息,上传图片获取临时素材media_id，保存在本地，有效期3天。
	public function addarticle(){
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['inputtime'] = SYS_TIME;
			$siteid=$this->get_siteid()?$this->get_siteid():1;
			$_POST['weixin']['siteid'] = $siteid;
			if(empty($_POST['weixin']['title'])) {
				showmessage(L("operation_failure"),HTTP_REFERER);
			}
			if(empty($_POST['weixin']['thumb'])) {
				showmessage(L("缩略图不能为空！"),HTTP_REFERER);
			}
			$thumb=get_wxthumb(trim($_POST['weixin']['thumb']));	
			$media_data=get_media_id($thumb,'image');
			if (isset($media_data['errcode'])){
			   echo '上传媒体错误类型：'.globalreturncode($media_data['errcode']);
			   exit();
			}
			$_POST['weixin']['thumb_media_id']=$media_data;
			$data =$_POST['weixin'];
			$resultid = $this->dbsent_group_news->insert($data,true);
			if($resultid){
				$url = MOBILE_PATH.'weixin_news_'.$resultid.'.html';
			    $this->dbsent_group_news->update(array('url'=>$url),array('id'=>$resultid));	
			//下面的这语句必要，否则添加成功后，窗口无法关闭
			showmessage(L('operation_success'),'?app=weixin&controller=typesmanage&view=catlist');
			}
		}
		include $this->admin_tpl('weixin_group_addarticle');
	}
	public function edit_groupnews(){
		if(!isset($_GET['id']) &&!$_GET['id']){
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		$id = intval($_GET['id']);
		$info=$this->dbsent_group_news->get_one(array('id'=>$id));
		if(isset($_POST['dosubmit'])){
			$_POST['weixin']['updatetime'] = SYS_TIME;
			if(empty($_POST['weixin']['title'])) {
				showmessage(L("operation_failure"),HTTP_REFERER);
			}
			if(empty($_POST['weixin']['thumb'])) {
				showmessage(L("缩略图不能为空！"),HTTP_REFERER);
			}
			$thumb=get_wxthumb(trim($_POST['weixin']['thumb']));	
			$media_data=get_media_id($thumb,'image');
			if (isset($media_data['errcode'])){
			   echo '上传媒体错误类型：'.globalreturncode($media_data['errcode']);
			   exit();
			}
			$_POST['weixin']['thumb_media_id']=$media_data;
			$data =$_POST['weixin'];
			$result=$this->dbsent_group_news->update($data,array('id'=>$id));
			if(!$result) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=typesmanage&view=edit_groupnews','', 'edit_groupnews');
		}
		include $this->admin_tpl('weixin_group_editnews');
	}
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
					$this->dbsent_group_news->delete(array('id'=>$id_arr));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				$result = $this->dbsent_group_news->delete(array('id'=>$id));
				if($result){
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
}
?>

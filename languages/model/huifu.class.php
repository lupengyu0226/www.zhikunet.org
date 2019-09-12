<?php
class huifu {
	private $db;
	/*** 构造函数*/
	public function __construct() {
		$this->vip_db = shy_base::load_model('weixin_member_model');//微信会员表
		$this->hf_db = shy_base::load_model('weixin_huifu_model');
		$this->db = shy_base::load_model('content_model');
		$this->message_db = shy_base::load_model('weixin_message_model');
	}
	/**关注*/
	public function hf($keyword,$openid){
		//关键字匹配
		if($keyword=='XX'){
			$where="keyword='".$keyword."' or keyword2='".$keyword."' or keyword3='".$keyword."'";
			$count_num=count($huifu=$this->huifu=$this->hf_db->select($where));
			if($count_num<>'0'){
				foreach ($huifu as $v) {
					$title=$v['title'];
					if($v['link']==''){
						$link=$APP_PATH.'index.php?app=weixin&controller=content&view=show&id='.$v['id'];
					}else{
						$links=stripos($v['link'],'?');
						if($links==false){
							$link=$v['link'].'?openid='.$openid;
						}else{
							$link=$v['link'].'&openid='.$openid;
						}
					}
					$thumb=$v['thumb'];
					if($v['description']==''){$excerpt=$v['title'];}else{$excerpt=$v['description'];}
					$items = $items . $this->get_item($title, $excerpt, $thumb, $link); 
				}
			}
			if($v['type'] =='0' and $count_num !='0'){//文字回复
				$contentStr = "{$excerpt}";
				return array('content'=>$contentStr,'type'=>$v['type']);
			}else if($v['type'] =='1' and $count_num !='0'){//图文回复
				return array('items'=>$items,'type'=>$v['type'],'count_num'=>$count_num);
			}
            }elseif(trim($keywords[0] == '绑定')){

					//$insert_sql="INSERT INTO v9_weixin_test(from_user, account, password, update_time) VALUES('$fromUsername','$keywords[1]','$keywords[2]','$nowtime')";
					$this->wall_db->insert((from_user, account, password, update_time) VALUES('$fromUsername','$_POST['keywords']','$keywords[2]','$nowtime'));//消息记录(无回复)

					$res = _insert_data($this->wall_db);
					if($res == 1){
						$contentStr = "绑定成功";
					}elseif($res == 0){
                		$contentStr = "绑定失败";
                    }
            	}
		}elseif(!empty($keyword)){//暂未
			$where="keyword='".$keyword."' or keyword2='".$keyword."' or keyword3='".$keyword."'";
			$count_num=count($huifu=$this->huifu=$this->hf_db->select($where));
			if($count_num<>'0'){
				foreach ($huifu as $v) {
					$title=$v['title'];
					if($v['link']==''){
						$link=$APP_PATH.'index.php?app=weixin&controller=content&view=show&id='.$v['id'];
					}else{
						$links=stripos($v['link'],'?');
						if($links==false){
							$link=$v['link'].'?openid='.$openid;
						}else{
							$link=$v['link'].'&openid='.$openid;
						}
					}
					$thumb=$v['thumb'];
					if($v['description']==''){$excerpt=$v['title'];}else{$excerpt=$v['description'];}
					$items = $items . $this->get_item($title, $excerpt, $thumb, $link); 
				}
				if($v['type'] =='0' and $count_num !='0'){//文字回复
					$contentStr = "{$excerpt}";
					return array('content'=>$contentStr,'type'=>$v['type']);
				}else if($v['type'] =='1' and $count_num !='0'){//图文回复
					return array('items'=>$items,'type'=>$v['type'],'count_num'=>$count_num);
				}
			}else{//自定义回复没有对应内容
				$setting=getcache('setting', 'weixin');
				$this->db->table_name='v9_'.$setting[models];//读取信息表
				$list=$this->list=$this->db->select("title like '%".$keyword."%' or description like '%".$keyword."%' or keywords like '%".$keyword."%' order by id desc LIMIT 0, 10");
				$count_num=count($list);
				if($count_num!='0'){
					foreach ($list as $v) {
						$title=$v['title'];
						$link=$v['url'];	
						$thumb=$v['thumb'];
						if($v['description']==''){$excerpt=$v['title'];}else{$excerpt=$v['description'];}
						$items = $items . $this->get_item($title, $excerpt, $thumb, $link); 
					}
					return array('items'=>$items,'type'=>'1','count_num'=>$count_num);
				}else{
					$count_num=count($null=$this->null=$this->hf_db->select(array('keyword'=>'null')));
					foreach ($null as $v) {
						$title=$v['title'];
						if($v['link']==''){
							$link=$APP_PATH.'index.php?app=weixin&controller=content&view=show&id='.$v['id'];
						}else{
							$links=stripos($v['link'],'?');
							if($links==false){
								$link=$v['link'].'?openid='.$openid;
							}else{
								$link=$v['link'].'&openid='.$openid;
							}
						}
						$thumb=$v['thumb'];
						if($v['description']==''){$excerpt=$v['title'];}else{$excerpt=$v['description'];}
						$items = $items . $this->get_item($title, $excerpt, $thumb, $link); 
					}
					if($v['type'] =='0' and $count_num !='0'){//文字回复
						$contentStr = "{$excerpt}";
						return array('content'=>$contentStr,'type'=>$v['type']);
					}else if($v['type'] =='1' and $count_num !='0'){//图文回复
						return array('items'=>$items,'type'=>$v['type'],'count_num'=>$count_num);
					}
				}
			}
		}
		
	}
	//图文回复
	private function get_item($title,$description, $picUrl, $url){
        if(!$description) $description = $title;
        return
        '
        <item>
            <Title><![CDATA['.$title.']]></Title>
            <Description><![CDATA['.$description.']]></Description>
            <PicUrl><![CDATA['.$picUrl.']]></PicUrl>
            <Url><![CDATA['.$url.']]></Url>
        </item>
        ';
    }

	
}
<?php 
class xzh{ 
private $db; 
public function __construct() { 
$this->db = shy_base::load_model('weixin_menuevent_model');
		$this->keyworddb = shy_base::load_model('weixin_replykeyword_model');
		$this->replyword = shy_base::load_model('weixin_keyword_model');
		$this->dbarticle = shy_base::load_model('weixin_article_model');
		$this->dbfocusreply = shy_base::load_model('weixin_focusreply_model');
		$this->dbmember= shy_base::load_model('weixin_member_model');
		$this->modeldb= shy_base::load_model('model_model');
		shy_base::load_app_func('global','weixin');
} 


public function init(){ 
	if (!isset($_GET['echostr'])) { 
    $this->responseMsg(); 
	}else{ 
        
	$this->valid(); 
	} 
} 

public function get_tokens(){ 
	$tokens = getcache('weixin','commons'); 
	$token = $tokens[1]['token']; 
	return $token; 
} 
public function valid(){ 
	$echoStr = $_GET["echostr"]; 
    $tokens = getcache('weixin','commons'); 
    $token = $tokens[1]['token']; 
    $strSignature = $this->getSHA1($token, $_GET['timestamp'], $_GET['nonce']);
    if ($strSignature == $_GET['signature']) {
        echo $_GET['echostr'];
    }
} 


private function getSHA1($strToken, $intTimeStamp, $strNonce, $strEncryptMsg = '')
{
    $arrParams = array(
        $strToken, 
        $intTimeStamp, 
        $strNonce,
    );
    if (!empty($strEncryptMsg)) {
        array_unshift($arrParams, $strEncryptMsg);
    }
    sort($arrParams, SORT_STRING);
    $strParam = implode($arrParams);
    return sha1($strParam);
}

public function responseMsg(){
        $postStr = file_get_contents('php://input');
       
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE){
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
				case "image":
                    $resultStr = $this->receiveImage($postObj);
                    break;
				case "location":
                    $resultStr = $this->receiveLocation($postObj);
					break;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj);
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            echo $resultStr;
        }else {
			echo "";
            exit;
        }
    }
    private function receiveText($object){
		$funcFlag = 0;
		$keyword = trim($object->Content);
		$openid = $object->FromUserName;
		if($articles){
			return $articles;
		}
        if($keyword == "版本"){
            $articles = '当前接口版本为:沭阳网专用接口1.09';
			$resultStr = $this->transmitText($object, $articles, $funcFlag);
			return $resultStr;
		}
        if($keyword == "天气"){
			$data = $this->weather();
					$contentStr[] = array(
						        "Title" =>"以下是".$data['HeWeather6'][0]['basic']['location']."今日天气预报",
								"Description" =>"今日:".$data['HeWeather6'][0]['daily_forecast'][0]['cond_txt_d']."转".$data['HeWeather6'][0]['daily_forecast'][0]['cond_txt_n'].","."最低温度:".$data['HeWeather6'][0]['daily_forecast'][0]['tmp_min'].","."最高温度:".$data['HeWeather6'][0]['daily_forecast'][0]['tmp_max'].",".$data['HeWeather6'][0]['daily_forecast'][0]['wind_dir'].$data['HeWeather6'][0]['daily_forecast'][0]['wind_sc']."级,湿度:".$data['HeWeather6'][0]['daily_forecast'][0]['hum'].","."发布时间:".$data['HeWeather6'][0]['update']['loc'],
								"PicUrl" =>"https://statics.05273.cn/images/weather.jpg",
								"Url" =>"https://wap.05273.cn/weather.html");
			$resultStr = $this->transmitNews($object, $contentStr, $funcFlag);
			return $resultStr;
		}
		$where = " `keyword` LIKE '%$keyword%' ";
		$data=@$this->keyworddb->get_one($where);
		if($data){
			$views=$data['views']+1;
			$this->keyworddb->update(array('views'=>$views), array('id'=>$data['id']));
			$type=intval($data['type']);
			switch ($type) {
                case 1:
				    $articles = $this->dbarticle->select(array('replyid'=>$data['id']));
                    
                    break;
                case 3:
                    $articles=$data['content'];
                    break;
                case 5:
				    $articles=$this->get_lists($data);
                  
                    break;
				case 6:
                    $articles=$this->get_tag($data,$keyword);
                    break;
				case 8:
				  $articles=$this->part_vote($keyword,$openid);
				  break;
				
			}
			if(in_array($type,array(1,5,6))){
				foreach((array)$articles as $a){
					$contentStr[] = array(
								"Title" =>$a['title'],
								"Description" =>str_cut($a['description'],100),
								"PicUrl" =>$a['thumb'],
								"Url" =>$a['url']); 
				}
				$resultStr = $this->transmitNews($object, $contentStr);
				
			}elseif($type==3){
				$resultStr = $this->transmitText($object, $articles, $funcFlag);
			}elseif($type==8){
				if(is_array($articles)){
					$resultStr = $this->transmitNews($object, $articles);
				}else{
					$resultStr = $this->transmitText($object, $articles);
				}
			}elseif($type==9){
				$result = get_time_section();
				if ($result=="1") {
					$resultStr = $this->transmitService($object);
				} else {
					$kefuwork = getcache('weixin','commons');//微信配置文件
					$kefus =$kefuwork[1]['kefus'];//客服上班时间
					$kefux =$kefuwork[1]['kefux'];//客服下班时间
					$resultStr = $this->transmitText($object,"尊敬的用户您好！现在是下班时间，我们的客服尚未上班，请在".$kefus."点到".$kefux."点之间呼叫客服！");
				}
			}													
	  }else{
		    $setting = getcache('reply_setting','commons');
			$contentStr=$setting['noreply'];
			$resultStr = $this->transmitText($object, $contentStr);
	  }
		$memberdata=get_xzh_userinfo($openid);
		$addtime = date('Y-m-d H:i:s',SYS_TIME);
        $this->replyword->insert(array('siteid'=>'1','keyword'=>$keyword,'name'=>'熊掌','inputtime'=>$addtime,'username'=>$memberdata['user_info_list'][0]['nickname'],'type'=>$object->MsgType,'passed'=>'0'));
		return $resultStr;
    }
   //接收位置消息
    private function receiveLocation($object){
		$openid = $object->FromUserName; //获取用户的openID 
		$content = "你所在的位置经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；位置为：".$object->Label."；昵称：".get_userinfo($object->FromUserName)['nickname']."，已经更新到数据中心";
		$result = $this->transmitText($object, $content);
		$this->dbmember->update(array('gps'=>$object->Label),array('openid'=>$openid));
        return $result;
	}
   //接收图片消息
    private function receiveImage($object){
		$openid = $object->FromUserName;
		$contentStr[] = array(
					"Title" =>"这是您发的图片",
					"Description" =>"小沭妹暂时还无法处理图片数据哦，但我已经 帮你保存下来了，你可以随时来看哦",
					"PicUrl" =>$object->PicUrl,
					"Url" =>$object->PicUrl);
		$resultStr = $this->transmitNews($object, $contentStr, $funcFlag);
		$memberdata=get_xzh_userinfo($openid);
		$addtime = date('Y-m-d H:i:s',SYS_TIME);
        $this->replyword->insert(array('siteid'=>'1','keyword'=>$keyword,'name'=>'熊掌','inputtime'=>$addtime,'username'=>$memberdata['user_info_list'][0]['nickname'],'photo'=>$object->PicUrl,'type'=>$object->MsgType,'passed'=>'0'));
        return $resultStr;
	}
     //接收语音消息
     private function receiveVoice($object){
        $content = "小沭妹暂时听不懂你说的语音哦";
        $result = $this->transmitText($object, $content);
         return $result;
     }
	public function get_lists($data){
		$catid=intval($data['catid']);
		$lists = $this->modeldb->get_numrs($catid,$data['num']);				
		if($lists){
		$articles=array();
		foreach($lists as $ca){
			//$url =MOBILE_PATH.'show-'.$catid.'-'.$ca['id'].'-1.html';
			$url = m_show($catid,$ca['id']);
			
			$articles[]=array('title'=>$ca['title'],'description'=>$ca['description'],'thumb'=>is_wxthumb($ca['thumb'],$catid),'url'=>$url);
		}
		
		if($data['name']){
		  $articles[]=array('title'=>$data['name'],'description'=>'','thumb'=>$data['picurl'],'url'=>$data['url']);
		}
		
		return $articles;
		}else{
			return false;
		}
	}
	private function weather(){
		$url = 'https://www.05273.cn/caches/weather.json';
		$str = https_request($url);
		$arr = json_decode($str,true);
		return $arr;
	}
    private function receiveEvent($object){
        $contentStr = "";
        switch ($object->Event){
			case "subscribe":
			//保存关注用户信息
			$contentStr = array(); 
			$openid = $object->FromUserName; //获取用户的openID
			  $memberdata=get_xzh_userinfo($openid);//根据用户的openID获取用户的详细信息  
			  $info = $this->dbmember->get_one(array('openid'=>$openid)); 
			  
			  if($info){ 
				$this->dbmember->update(array('subscribe'=>"1",'status'=>"1",'sex'=>$memberdata['user_info_list'][0]['sex'],'language'=>"中文",'nickname'=>$memberdata['user_info_list'][0]['nickname'],'platform'=>"熊掌",'province'=>$memberdata['user_info_list'][0]['province'],'country'=>$memberdata['user_info_list'][0]['country'],'headimgurl'=>$memberdata['user_info_list'][0]['headimgurl'],'subscribe_time'=>$memberdata['user_info_list'][0]['subscribe_time'],'remark'=>$memberdata['user_info_list'][0]['remark'],'groupid'=>$memberdata['user_info_list'][0]['groupid']),array('openid'=>$memberdata['user_info_list'][0]['openid'])); 
			  }else{ 
				$sql = array('subscribe'=>$memberdata['user_info_list'][0]['subscribe'],'openid'=>$memberdata['user_info_list'][0]['openid'],'status'=>"1",'sex'=>$memberdata['user_info_list'][0]['sex'],'language'=>"中文",'nickname'=>$memberdata['user_info_list'][0]['nickname'],'platform'=>"熊掌",'province'=>$memberdata['user_info_list'][0]['province'],'country'=>$memberdata['user_info_list'][0]['country'],'headimgurl'=>$memberdata['user_info_list'][0]['headimgurl'],'subscribe_time'=>$memberdata['user_info_list'][0]['subscribe_time'],'remark'=>$memberdata['user_info_list'][0]['remark'],'groupid'=>$memberdata['user_info_list'][0]['groupid']);
				$this->dbmember->insert($sql,true);//保存用户的信息到本地数据表 
			  } 
			    $info=$this->dbfocusreply->get_one(array('id'=>1));
				if($info['replyid'] == 0){
					$contentStr = $info['content'];
				}else{
				$articles = $this->dbarticle->listinfo(array('replyid'=>$info['replyid']));
				foreach($articles as $a){
					$contentStr[] = array(
								"Title" =>$a['title'],
								"Description" =>$a['description'],
								"PicUrl" =>$a['thumb'],
								"Url" =>$a['url']);
				}
				}
				break;
			case "unsubscribe":
				$contentStr = array(); 
				$openid = $object->FromUserName; //获取用户的openID 
				$memberdata=get_xzh_userinfo($openid); 
				$memberdata['openid']=$memberdata['user_info_list'][0]['openid']; 
				$this->dbmember->update(array('subscribe'=>"0",'status'=>"0"),array('openid'=>$memberdata['user_info_list'][0]['openid'])); 
					$contentStr[] = array(
								"Title" =>"您已取消关注沭阳网熊掌号",
								"Description" =>"您已经在".date('Y-m-d H:i:s', time())."取消关注了我们的熊掌号，欢迎您点击顶部的关注再次关注我们！",
								"PicUrl" =>"https://statics.05273.cn/images/qiuguanzhu.jpg",
								"Url" =>"https://wap.05273.cn/");
                break;
           case "CLICK":
				$data =$this->db->select();	
				$even=array();
				foreach($data as $k=>$v){
					$event[]=array('key'=>$v['key'],'replyid'=>$v['replyid']);
				}
								
				foreach($event as $e){
					if($e['key']==$object->EventKey){
						
						$keyword = $this->keyworddb->get_one(array('id'=>$e['replyid']));
						if($keyword){
						  if(intval($keyword['type'])==1){
							$news_data = $this->dbarticle->listinfo(array('replyid'=>$e['replyid']));
								foreach($news_data as $value){								
										$contentStr[] = array(
													"Title" =>$value['title'],
													"Description" =>$value['description'],
													"PicUrl" =>$value['thumb'],
													"Url" =>$value['url']
												   );
								  }
						  }elseif(intval($keyword['type']) == 5 && intval($keyword['catid'] != 0)){
							  $catid = intval($keyword['catid']);
								  $lists = $this->modeldb->get_numrs($catid, $keyword['num']);
										  $contentStr = array();
										  foreach ($lists as $s) {
											  //$url = MOBILE_PATH.'show-'.$catid.'-'.$s['id'].'-1.html';
											  $url = m_show($catid,$s['id']);
											  $contentStr[] = array(
												  'Title' => $s['title'],
												  'Description' => $s['description'],
												  'PicUrl' => is_wxthumb($s['thumb'],$catid),
												  'Url' => $url
											  );
										  }
										  if ($keyword['name']) {
											  $contentStr[] = array(
												  'Title' => $keyword['name'],
												  'Description' => '',
												  'PicUrl' => $keyword['picurl'],
												  'Url' => $keyword['url']
											  );
										  }  
									  
						  }elseif(intval($keyword['type']) == 3){
							     $contentStr =$keyword['content'];
						  }
						}
					}
					  
				}
                break;
        }
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }
	
    private function transmitText($object, $content){
    
        $textTpl = "<xml>
				  <ToUserName><![CDATA[%s]]></ToUserName>
				  <FromUserName><![CDATA[%s]]></FromUserName>
				  <CreateTime>%s</CreateTime>
				  <MsgType><![CDATA[text]]></MsgType>
				  <Content><![CDATA[%s]]></Content>
				  <MsgId><![CDATA[%s]]></MsgId>
				  </xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $MsgId);
		
        return $resultStr;
    }
    private function transmitNews($object, $arr_item){
    
        //首条标题28字，其他标题39字
        if(!is_array($arr_item))
            return;
        $itemTpl = " <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], zhaiyao_bfb($item['Description']), $item['PicUrl'], $item['Url']);
        $newsTpl = "<xml>
		  <ToUserName><![CDATA[%s]]></ToUserName>
		  <FromUserName><![CDATA[%s]]></FromUserName>
		  <CreateTime>%s</CreateTime>
		  <MsgType><![CDATA[news]]></MsgType>
		  <Content><![CDATA[]]></Content>
		  <ArticleCount>%s</ArticleCount>
		  <Articles>
		  $item_str</Articles>
		  </xml>";
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $resultStr;
	}
     //回复语音消息
     private function transmitVoice($object, $voiceArray){
		$itemTpl = "<Voice>
		<MediaId><![CDATA[%s]]></MediaId>
		</Voice>";
		$item_str = sprintf($itemTpl, $voiceArray['MediaId']);
		$xmlTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[voice]]></MsgType>
		$item_str
		</xml>";
         $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
         return $result;
     }
	//回复多客服消息
    private function transmitService($object){
		$xmlTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[transfer_customer_service]]></MsgType>
		</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
   private function transmitImage($object, $imageArray){
			$itemTpl = "<Image>
			<MediaId><![CDATA[%s]]></MediaId>
			</Image>";
			$item_str = sprintf($itemTpl, $imageArray['MediaId']);
			$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			$item_str
			</xml>";
			$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
			return $result;
		}
}
?>
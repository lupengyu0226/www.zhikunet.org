<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
  define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
  shy_base::load_app_func('util','content');
  class type {
  private $db;
  function __construct() {
    $this->db = shy_base::load_model('content_model');
  }
/**
  * 按照模型搜索
  */
public function init() {
    $catid = $_GET['catid'] = isset($_GET['catdir'])&&!empty($_GET['catdir'])? dir2catid($_GET['catdir']): intval($_GET['catid']);
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $this->categorys = getcache('category_content_'.$siteid,'commons');
    if(!isset($this->categorys[$catid])) showmessage(L('missing_part_parameters'));
    if(isset($_GET['info']['catid']) && $_GET['info']['catid']) {
     $catid = intval($_GET['info']['catid']);
    } else {
     $_GET['info']['catid'] = 0;
    }
    if(isset($_GET['typeid']) && trim($_GET['typeid']) != '') {
     $typeid = intval($_GET['typeid']);
    } else {
     showmessage(L('illegal_operation'));
    }
    $catdir = $_GET['catdir'];
    $TYPE = getcache('type_content','commons');
    $modelid = $this->categorys[$catid]['modelid'];
    $modelid = intval($modelid);
    if(!$modelid) showmessage(L('illegal_parameters'));
    $CATEGORYS = $this->categorys;
    $siteid = $this->categorys[$catid]['siteid'];
    $siteurl = siteurl($siteid);
    $this->db->set_model($modelid);
      //URL规则
      $urlrules = getcache('urlrules_detail','commons');//change 去读urlrules_detail
      $urlrules = str_replace('|', '~',$urlrules[40]);
      $tmp_urls = explode('~',$urlrules['urlrule']);//change
      $tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
      preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
      if(!empty($_urls[1])) {
        foreach($_urls[1] as $_v) {
          $GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
        }
      }
      define('URLRULE',$urlrules['urlrule']);//change
      $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
      $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
      $GLOBALS['URL_ARRAY']['catid'] = $catid;
      #新增S
      $GLOBALS['URL_ARRAY']['url']      =$CAT['url'];
      $GLOBALS['URL_ARRAY']['realpath']     =$CAT['parentdir'].$CAT['catdir'];
      $GLOBALS['URL_ARRAY']['parentdir']    =$CAT['parentdir'];
      $GLOBALS['URL_ARRAY']['urlruleishtml']  =$urlrules['ishtml'];
      #新增E
    $page = $_GET['page'];

    $datas = $infos = array();

    //$infos = $this->db->listinfo("`typeid` = '$typeid'",'id DESC',$page,20);//读取整个模型下同类别文章
    $infos = $this->db->listinfo("`typeid` = '$typeid' AND catid = '$catid'",'id DESC',$page,20,'','9',$urlrule);//仅仅读取当前栏目下的同类别文章,如果要启用此模式,请去掉上一行代码并将本行开头的// 两斜杠去掉.
    $total = $this->db->number;
    if($total>0) {
     $pages = $this->db->pages;
     foreach($infos as $_v) {
      if(strpos($_v['url'],'://')===false) $_v['url'] = $siteurl.$_v['url'];
      $datas[] = $_v;
     }
    }
    $SEO = seo($siteid, $catid, $TYPE[$typeid]['name'],'这里包含了所有沭阳县'.$TYPE[$typeid]['name'].'的新闻信息的汇总',$TYPE[$typeid]['name'].'新闻汇总');
    include template('content','type');
  }
}
?>

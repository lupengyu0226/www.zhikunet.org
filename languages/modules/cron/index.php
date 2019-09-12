<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
    function __construct() {
        shy_base::load_app_func('global');
        $this->cron_db = shy_base::load_model('cron_model');
        $this->cron_log_db = shy_base::load_model('cron_log_model');
        $siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
        define("SITEID", $siteid);
    }
    public function edi_cron() {
        set_time_limit(0);
        $corn=getcache('cron','cron');
        $html = shy_base::load_app_class('cronhtml','cron',1);
        foreach($corn as $k=>$_r){
            if(intval($_r['cronon'])==1&&intval($_r['cronwitch'])==1){//任务已经启动
                if(((int)$_r['crontime']*60+(int)$_r['excutetime']<SYS_TIME)&& (int)$_r['start_time']<= SYS_TIME &&SYS_TIME<=(int)$_r['end_time']){//判断当前时间是否能执行任务
                    //echo $_r['crontype'];
                    if(!is_null($_r['parm'])){
                        $array=array();
                        $array=explode(',',$_r['parm']);
                        call_user_func_array(array($html,$_r['crontype']),$array); 
                        $filesize="100000";
                    }else{
                        $filesize=call_user_func(array($html,$_r['crontype']));     
                    }
                    $lsize = sizecount ($filesize);
                    $corn[$k]['excutetime']=SYS_TIME;
                    $this->cron_log_db->insert(array('logcronid'=>$_r['cronid'],'loginfo'=>'成功','logtime'=>SYS_TIME,'logsize'=>$lsize));
                    //sleep(1); 
                }
                //if(defined('CRON_PATH'))sleep(1); 
            }
        }
        setcache('cron',$corn, 'cron');
        
    }   
}
?>
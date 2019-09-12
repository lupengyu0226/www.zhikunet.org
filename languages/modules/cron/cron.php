<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin', 'admin', 0);
shy_base::load_sys_class('format', '', 0);
shy_base::load_sys_class('form', '', 0);
shy_base::load_app_func('unit', 'cron');
shy_base::load_app_class('utility', 'cron', 0);

class cron extends admin
{
    function __construct() {
        parent::__construct();
        $this->db = shy_base::load_model('module_model');
        $this->cron_db = shy_base::load_model('cron_model');
        $this->cron_log_db = shy_base::load_model('cron_log_model');
    }
    public function init() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $show_header = true;
        $show_validator = true;
        $where = '';
        $cron = $this->cron_db->listinfo($where, 'cronid DESC', $page, 40);
        $pages = $this->cron_db->pages;
        include $this->admin_tpl('cron_manage');
    }

    public function add() {
        if (isset($_POST['dosubmit'])) {
            $info = $_POST['info'];
            if ($info['cronname'] == '') showmessage('任务名称不能为空', HTTP_REFERER);
            if ($info['crontime'] == '') showmessage('任务时间不能为空', HTTP_REFERER);
            $info = $_POST['info'];
            $info['cronon'] = 0;
            $info['cronwitch'] = 0;
            $info['cronflag'] = SYS_TIME;
            $info['addtime'] = SYS_TIME;
            $info['excutetime'] = SYS_TIME;
            $info['start_time'] = strtotime($info['start_time']);
            $info['end_time'] = strtotime($info['end_time']);
            $this->cron_db->insert($info);
            if ($this->cron_db->insert_id()) {
                $this->cache();
                showmessage('添加成功', '?app=cron&controller=cron&view=init');
            }
        } else {
            $show_header = true;
            $show_validator = true;
            include $this->admin_tpl('cron_add');
        }
    }
    public function edit() {
        if (isset($_POST['dosubmit'])) {
            $info = array();
            $info = $_POST['info'];
            if ($info['cronname'] == '') showmessage('任务名称不能为空', HTTP_REFERER);
            if ($info['crontime'] == '') showmessage('任务时间不能为空', HTTP_REFERER);
            $info['excutetime'] = SYS_TIME;
            $info['start_time'] = strtotime($info['start_time']);
            $info['end_time'] = strtotime($info['end_time']);
            $this->cron_db->update($info, array('cronid' => $_POST['cronid']));
            $this->cache();

            showmessage('修改成功', '?app=cron&controller=cron&view=init');
        } else {
            $show_header = true;
            $show_validator = true;
            $cronid = $_GET['cronid'];
            $croninfo = $this->cron_db->get_one(array('cronid' => $cronid));

            include $this->admin_tpl('cron_edit');
        }
    }
    public function start() {
        $cronid = $_GET['cronid'];
        if (!preg_match('/^[0-9.-]+$/', $cronid)) {
            showmessage('参数无效！请勿提交非法url', HTTP_REFERER);
        }
        $result = $this->cron_db->get_one(array('cronid' => $cronid));
        if (!$result) showmessage('任务不存在', HTTP_REFERER);

        //检测任务状态是否已经开始，0为未开始，1为已经开始
        if ($result["cronon"] == 1) {
            showmessage("任务还在进行中，请等待任务结束", '?app=cron&controller=cron&view=init');
        } else {
            $newtime = SYS_TIME;

            //标记当前任务已经开始，做状态保护
            $this->cron_db->update(array('cronwitch' => 1, 'cronon' => 1, 'addtime' => $newtime), array('cronid' => $cronid));

            //记录开始任务的时间并写入日志
            $logcronid = $cronid;
            $ltime = SYS_TIME;
            $rs = $this->cron_db->get_one(array('cronid' => $cronid), 'crontype');

            $crontype = $rs['crontype'];
            $this->cron_log_db->insert(array('logcronid' => $logcronid, 'loginfo' => '启动', 'logtime' => $ltime, 'logsize' => 'NONE'));
            $this->cache();
            include $this->admin_tpl('cron_start');
        }
    }

    public function stop() {
        $cronid = $_GET['cronid'];
        if (!preg_match('/^[0-9.-]+$/', $cronid)) {
            showmessage('参数无效！请勿提交非法url', HTTP_REFERER);
        }
        $this->cron_db->update(array('cronwitch' => 0,'cronon'=>0), array('cronid' => $cronid));
        $this->cron_log_db->insert(array('logcronid' => $cronid, 'loginfo' => '等待', 'logtime' => SYS_TIME, 'logsize' => 'NONE'));
        $this->cache();
        showmessage('任务将在下一次执行时结束', '?app=cron&controller=cron&view=init');
    }

    public function log() {
        $logcronid = $_GET['cronid'];
        if (!preg_match('/^[0-9.-]+$/', $logcronid)) {
            showmessage('参数无效！请勿提交非法url', HTTP_REFERER);
        }
        $page = $_GET['page'] ? $_GET['page'] : '1';
        $cron = $this->cron_log_db->listinfo(array('logcronid' => $logcronid), $order = 'logid desc', $page, $pagesize = '20');
        $pages = $this->cron_log_db->pages;

        $runtimes = $this->countlog("logcronid=" . $logcronid . " AND loginfo != '启动' AND loginfo != '等待'");
        $runok = $this->countlog("logcronid=" . $logcronid . " AND loginfo = '成功'");
        $runerr = $this->countlog("logcronid=" . $logcronid . " AND loginfo = '结束'");

        $logs = $this->findlog("logcronid=" . $logcronid . " AND loginfo = '启动' ORDER BY logtime ASC");
        if (is_array($logs)) $begtime = $logs['logtime'];
        $logs = $this->findlog("logcronid=" . $logcronid . " AND loginfo = '成功' ORDER BY logtime DESC");
        if (is_array($logs)) $endtime = $logs['logtime'];

        $logs = $this->listedit($logcronid);
        if (is_array($logs)) {
            $cronname = $logs['cronname'];
            $crontime = $logs['crontime'];
            $runtime = $logs['runtime'];
            $cronwitch = $logs['cronwitch'];
        }
        $counttime = 0;
        $alltime = $endtime - $begtime;
        if ($cronwitch > 0) {
	$maxtime = 5; //设置报警阀值
            $maxtime = $maxtime * $runok;
            $counttime = SYS_TIME - ($endtime + $crontime * 60 + $maxtime);
            $countmin = ceil($counttime / 60);
        }
        $show_dialog = true;
        include $this->admin_tpl('cron_log');
    }

	public function logdel() {
		$logcronid = isset($_GET['logcronid'])? intval($_GET['logcronid']):'all';
		
		$deltype = isset($_GET['deltype']) ? intval($_GET['deltype']):SYS_TIME;
		
		if (!preg_match ( '/^[0-9.-]+$/', $logcronid)&&$logcronid!='all'){
			showmessage ( '参数无效！请勿提交非法url', HTTP_REFERER);
		}
		if($logcronid=='all'){
			$this->cron_log_db->delete("logtime<$deltype AND loginfo='成功'" );
			}else{
			$this->cron_log_db->delete("logcronid=$logcronid AND logtime<$deltype AND loginfo='成功'" );
			}
        showmessage('删除成功', '?app=cron&controller=cron&view=init');
	}
    public function loglist() {
        $logid = $_GET['logid'];
        if (!preg_match('/^[0-9.-]+$/', $logid)) {
            showmessage('参数无效！请勿提交非法url', HTTP_REFERER);
        }
        $this->cron_log_db->delete("logid=$logid AND loginfo='成功'");
        showmessage('删除成功', '?app=cron&controller=cron&view=init');
    }
    public function listedit($cronid) {
        $array = array();
        $result = $this->cron_db->get_one(array('cronid' => $cronid));
        return $result;
    }

    public function countlog($where = "") {
        $number = $this->cron_log_db->count($where);
        return $number;
    }

    public function findlog($where = "") {
        $array = array();
        $result = $this->cron_log_db->get_one($where);
        return $result;
    }

    /**
     * 删除
     */
    public function delete() {
        $cronidarr = isset($_POST['cronid']) ? $_POST['cronid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
        $where = to_sqls($cronidarr, '', 'cronid');
        if ($this->cron_db->delete($where)) {
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'), HTTP_REFERER);
        }
    }

    private function cache() {
        $cron = $this->cron_db->listinfo('', 'cronid DESC', $page, 20000);
        if (is_array($cron)) {
            $array = array();
            foreach ($cron as $k => $r) {
                $array[$r['cronid']] = $r;
            }
            setcache('cron', $array, 'cron');
        }
    }
}
?>

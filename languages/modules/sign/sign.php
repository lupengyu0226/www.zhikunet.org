<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin', 'admin', 0);
class sign extends admin {
    function __construct() {
        parent::__construct();
        $this->sign_set_db = shy_base::load_model('sign_set_model');
        $this->sign_count_db = shy_base::load_model('sign_count_model');
        $this->sign_db = shy_base::load_model('sign_model');
    }
    public function init() {
        $where = array('siteid' => $this->get_siteid());
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->sign_count_db->listinfo($where, $order = 'count DESC', $page, $pages = '10');
        $pages = $this->sign_count_db->pages;
        include $this->admin_tpl('count_list');
    }
    public function time_list() {
        $userid = intval($_GET['userid']);
        if ($userid < 1) {
            return false;
        }
        $where = array('siteid' => $this->get_siteid(), 'userid' => $userid);
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->sign_db->listinfo($where, $order = 'id DESC', $page, $pages = '10');
        $pages = $this->sign_db->pages;
        include $this->admin_tpl('time_list');
    }
    public function week_time_list() {
        $userid = intval($_GET['userid']);
        if ($userid < 1) {
            return false;
        }
        $week_start_time = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
        // 创建本周开始时间
        $week_end_time = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));
        // 创建本周结束时间
        $siteid = $this->get_siteid();
        $where = " `siteid`='{$siteid}' AND  `userid`='{$userid}' AND `signtime` > '{$week_start_time}' AND `signtime` < '{$week_end_time}'";
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->sign_db->listinfo($where, $order = 'id DESC', $page, $pages = '10');
        $pages = $this->sign_db->pages;
        include $this->admin_tpl('week_time_list');
    }
    public function month_time_list() {
        $userid = intval($_GET['userid']);
        if ($userid < 1) {
            return false;
        }
        $month_start_time = mktime(0, 0, 0, date("m"), 1, date("Y"));
        // 创建本月开始时间
        $month_end_time = mktime(23, 59, 59, date("m"), date("t"), date("Y"));
        // 创建本月结束时间
        $siteid = $this->get_siteid();
        $where = " `siteid`='{$siteid}' AND  `userid`='{$userid}' AND `signtime` > '{$month_start_time}' AND `signtime` < '{$month_end_time}'";
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->sign_db->listinfo($where, $order = 'id DESC', $page, $pages = '10');
        $pages = $this->sign_db->pages;
        include $this->admin_tpl('month_time_list');
    }
    public function set() {
        if (isset($_POST['dosubmit'])) {
            if ($_POST['starttime']) {
                $starttime = strtotime($_POST['starttime']);
                $data['starttime'] = date("H:i:s", $starttime);
            } else {
                $data['starttime'] = '00:00:00';
            }
            if ($_POST['endtime']) {
                $endtime = strtotime($_POST['endtime']);
                $data['endtime'] = date("H:i:s", $endtime);
            } else {
                $data['endtime'] = '23:59:59';
            }
            if ($endtime < $starttime) {
                showmessage('结束时间必须大于开始时间', HTTP_REFERER);
            }
            $data['setpoint'] = intval($_POST['setpoint']);
            if (intval($_POST['limit']) > 0) {
                $data['limit'] = intval($_POST['limit']);
            } else {
                $data['limit'] = 1;
            }
            $siteid = intval($_GET['siteid']);
            if ($siteid < 1) {
                $data['siteid'] = $this->get_siteid();
                $this->sign_set_db->insert($data, true);
            } else {
                $this->sign_set_db->update($data, array('siteid' => $siteid));
            }
            showmessage(L('operation_success'), HTTP_REFERER);
        } else {
            $info = $this->sign_set_db->get_one(array('siteid' => $this->get_siteid()));
            extract($info);
            include $this->admin_tpl('sign_set');
        }
    }
    public function now_day_sign() {
        $y = date("Y", time());
        $m = date("m", time());
        $d = date("d", time());
        $day_start_time = mktime(0, 0, 0, $m, $d, $y);
        // 创建当日开始时间
        $day_end_time = mktime(23, 59, 59, $m, $d, $y);
        // 创建当日结束时间
        $siteid = $this->get_siteid();
        $where = " `siteid`='{$siteid}' AND `signtime` > '{$day_start_time}' AND `signtime` < '{$day_end_time}'";
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->sign_db->listinfo($where, $order = 'id DESC', $page, $pages = '10');
        $pages = $this->sign_db->pages;
        include $this->admin_tpl('now_day_sign');
    }
}
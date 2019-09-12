<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('receipts', 'pay', 0);
class wap {
    function __construct() {
        $this->sign_db = shy_base::load_model('sign_model');
        $this->sign_count_db = shy_base::load_model('sign_count_model');
        $this->sign_set_db = shy_base::load_model('sign_set_model');
        $this->member_db = shy_base::load_model('member_model');
        $siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
        define("SITEID", $siteid);
    }
    public function init() {
        $y = date("Y", time());
        $m = date("m", time());
        $d = date("d", time());
        $t = date('t');
        // 本月一共有几天
        $month_start_time = mktime(0, 0, 0, $m, 1, $y);
        // 创建本月开始时间
        $month_end_time = mktime(23, 59, 59, $m, $t, $y);
        // 创建本月结束时间
        $day_start_time = mktime(0, 0, 0, $m, $d, $y);
        // 创建当日开始时间
        $day_end_time = mktime(23, 59, 59, $m, $d, $y);
        // 创建当日结束时间
        $userid = param::get_cookie('_userid');
        $siteid = SITEID;
        $month_where = " `userid`='{$userid}' AND `signtime` > '{$month_start_time}' AND `signtime` < '{$month_end_time}'";
        $month_sign_list = $this->sign_db->select($month_where, '*', '', 'id ASC');
        $day_where = " `userid`='{$userid}' AND `signtime` > '{$day_start_time}' AND `signtime` < '{$day_end_time}'";
        $day_sign = $this->sign_db->get_one($day_where);
        $day_array = array();
        foreach ($month_sign_list as $k => $v) {
            $day_array[$k] = date("d", $v['signtime']) - 1;
        }
        $count = $this->sign_count_db->get_one(array('userid' => $userid));
        $set = $this->sign_set_db->get_one(array('siteid' => SITEID));
        $limitpoint = $set['setpoint'] * $set['limit'];
        include template('sign', 'wap_index');
    }
    public function sign() {
        $siteid = SITEID;
        $userid = param::get_cookie('_userid');
        $username = param::get_cookie('_username');
        if (!$userid) {
            mobilemsg('请登录', PASSPORT_PATH . 'member-login.html');
        }
        $now_time = time();
        $set = $this->sign_set_db->get_one(array('siteid' => $siteid));
        $todayBegin = strtotime(date('Y-m-d') . ' ' . $set['starttime']);
        $todayEnd = strtotime(date('Y-m-d') . ' ' . $set['endtime']);
        if ($now_time < $todayBegin || $now_time > $todayEnd) {
            mobilemsg('不在签到时间范围', HTTP_REFERER);
        }
        $today_where = " `userid`='{$userid}' AND `signtime` > '{$todayBegin}' AND `signtime` < '{$todayEnd}'";
        $sign_time_check_today = $this->sign_db->get_one($today_where);
        if (empty($sign_time_check_today)) {
            $sign_count_check = $this->sign_count_db->get_one(array('userid' => $userid));
            if (empty($sign_count_check)) {
                $this->sign_count_db->insert(array('userid' => $userid, 'siteid' => $siteid, 'continuous' => 1, 'lasttime' => $now_time, 'getpoint' => $set['setpoint'], 'weekcount' => 1, 'monthcount' => 1, 'count' => 1), true);
                $this->sign_db->insert(array('userid' => $userid, 'siteid' => $siteid, 'continuous' => 1, 'signpoint' => $set['setpoint'], 'signtime' => $now_time, 'signip' => ip()), true);
                receipts::point($set['setpoint'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] . '积分');
            } else {
                $last_day = date("d", $sign_count_check['lasttime']);
                $now_day = date("d", $now_time);
                if ($last_day != $now_day && $now_time > $sign_count_check['lasttime']) {
                    if ($last_day + 1 != $now_day) {
                        $sign_count_check['continuous'] = 0;
                    }
                    $this->sign_count_db->update(array('continuous' => $sign_count_check['continuous'] + 1), array('userid' => $userid));
                    $count_info = $this->sign_count_db->get_one(array('userid' => $userid), 'continuous');
                    if ($count_info['continuous'] > $set['limit']) {
                        $user_point = $sign_count_check['getpoint'] + $set['setpoint'] * $set['limit'];
                    } else {
                        $user_point = $sign_count_check['getpoint'] + $set['setpoint'] * $count_info['continuous'];
                    }
                    $user_count = $sign_count_check['count'] + 1;
                    $weekcount = date('YW', $sign_count_check['lasttime']) == date('YW', $now_time) ? $sign_count_check['weekcount'] + 1 : 1;
                    $monthcount = date('Ym', $sign_count_check['lasttime']) == date('Ym', $now_time) ? $sign_count_check['monthcount'] + 1 : 1;
                    $this->sign_count_db->update(array('getpoint' => $user_point, 'lasttime' => $now_time, 'weekcount' => $weekcount, 'monthcount' => $monthcount, 'count' => $user_count), array('userid' => $userid));
                    if ($count_info['continuous'] > $set['limit']) {
                        $this->sign_db->insert(array('userid' => $userid, 'continuous' => $count_info['continuous'], 'siteid' => $siteid, 'signpoint' => $set['setpoint'] * $set['limit'], 'signtime' => $now_time, 'signip' => ip()), true);
                        receipts::point($set['setpoint'] * $set['limit'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] * $set['limit'] . '积分');
                    } else {
                        $this->sign_db->insert(array('userid' => $userid, 'continuous' => $count_info['continuous'], 'siteid' => $siteid, 'signpoint' => $set['setpoint'] * $count_info['continuous'], 'signtime' => $now_time, 'signip' => ip()), true);
                        receipts::point($set['setpoint'] * $count_info['continuous'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] * $count_info['continuous'] . '积分');
                    }
                }
            }
            mobilemsg('签到成功', HTTP_REFERER);
        } else {
            mobilemsg('已签到', HTTP_REFERER);
        }
    }
    /**
     * AJAX 签到接口
     * @return {1:成功;0:已签到;-1:未登录;-2:没到签到时间}
     */
    public function sign_ajax() {
        $siteid = SITEID;
        $userid = param::get_cookie('_userid');
        $username = param::get_cookie('_username');
        if (!$userid) {
           exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>-1)).')');
        }
        $now_time = time();
        $set = $this->sign_set_db->get_one(array('siteid' => $siteid));
        $todayBegin = strtotime(date('Y-m-d') . ' ' . $set['starttime']);
        $todayEnd = strtotime(date('Y-m-d') . ' ' . $set['endtime']);
        if ($now_time < $todayBegin || $now_time > $todayEnd) {
           exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>-2)).')');
        }
        $today_where = " `userid`='{$userid}' AND `signtime` > '{$todayBegin}' AND `signtime` < '{$todayEnd}'";
        $sign_time_check_today = $this->sign_db->get_one($today_where);
        if (empty($sign_time_check_today)) {
            $sign_count_check = $this->sign_count_db->get_one(array('userid' => $userid));
            if (empty($sign_count_check)) {
                $this->sign_count_db->insert(array('userid' => $userid, 'siteid' => $siteid, 'continuous' => 1, 'lasttime' => $now_time, 'getpoint' => $set['setpoint'], 'weekcount' => 1, 'monthcount' => 1, 'count' => 1), true);
                $this->sign_db->insert(array('userid' => $userid, 'siteid' => $siteid, 'continuous' => 1, 'signpoint' => $set['setpoint'], 'signtime' => $now_time, 'signip' => ip()), true);
                receipts::point($set['setpoint'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] . '积分');
            } else {
                $last_day = date("d", $sign_count_check['lasttime']);
                $now_day = date("d", $now_time);
                if ($last_day != $now_day && $now_time > $sign_count_check['lasttime']) {
                    if ($last_day + 1 != $now_day) {
                        $sign_count_check['continuous'] = 0;
                    }
                    $this->sign_count_db->update(array('continuous' => $sign_count_check['continuous'] + 1), array('userid' => $userid));
                    $count_info = $this->sign_count_db->get_one(array('userid' => $userid), 'continuous');
                    if ($count_info['continuous'] > $set['limit']) {
                        $user_point = $sign_count_check['getpoint'] + $set['setpoint'] * $set['limit'];
                    } else {
                        $user_point = $sign_count_check['getpoint'] + $set['setpoint'] * $count_info['continuous'];
                    }
                    $user_count = $sign_count_check['count'] + 1;
                    $weekcount = date('YW', $sign_count_check['lasttime']) == date('YW', $now_time) ? $sign_count_check['weekcount'] + 1 : 1;
                    $monthcount = date('Ym', $sign_count_check['lasttime']) == date('Ym', $now_time) ? $sign_count_check['monthcount'] + 1 : 1;
                    $this->sign_count_db->update(array('getpoint' => $user_point, 'lasttime' => $now_time, 'weekcount' => $weekcount, 'monthcount' => $monthcount, 'count' => $user_count), array('userid' => $userid));
                    if ($count_info['continuous'] > $set['limit']) {
                        $this->sign_db->insert(array('userid' => $userid, 'continuous' => $count_info['continuous'], 'siteid' => $siteid, 'signpoint' => $set['setpoint'] * $set['limit'], 'signtime' => $now_time, 'signip' => ip()), true);
                        receipts::point($set['setpoint'] * $set['limit'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] * $set['limit'] . '积分');
                    } else {
                        $this->sign_db->insert(array('userid' => $userid, 'continuous' => $count_info['continuous'], 'siteid' => $siteid, 'signpoint' => $set['setpoint'] * $count_info['continuous'], 'signtime' => $now_time, 'signip' => ip()), true);
                        receipts::point($set['setpoint'] * $count_info['continuous'], $userid, $username, '', 'selfincome', '签到奖励得' . $set['setpoint'] * $count_info['continuous'] . '积分');
                    }
                }
            }
            if ($count_info['continuous'] > $set['limit']) {
                exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>1,'signpoint'=>$set['setpoint'] * $set['limit'])).')');
            } else {
                exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>1,'signpoint'=>$set['setpoint'] * $count_info['continuous'])).')');
            }
        }
    }
}
<?php
defined('IN_SHUYANG') or exit('No permission resources.');
$session_storage = 'session_'.shy_base::load_config('system','session_storage');
shy_base::load_sys_class($session_storage);
shy_base::load_app_class('foreground','member');
shy_base::load_sys_class('format', '', 0);
shy_base::load_sys_class('form', '', 0);
shy_base::load_app_func('global');

class deposit extends foreground {
	private $pay_db,$member_db,$account_db;
	function __construct() {
		if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		parent::__construct();
		$this->pay_db = shy_base::load_model('pay_payment_model');
		$this->account_db = shy_base::load_model('pay_account_model');
		$this->_username = param::get_cookie('_username');
		$this->_userid = intval(param::get_cookie('_userid'));
		$this->handle = shy_base::load_app_class('pay_deposit');
	}

	public function init() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		shy_base::load_app_class('pay_factory','',0);
		$where = '';
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$where = "AND `userid` = '$this->_userid'";
		$start = $end = $status = '';
		if($_GET['dosubmit']){
			$start_addtime = $_GET['info']['start_addtime'];
			$end_addtime = $_GET['info']['end_addtime'];
			$status = safe_replace($_GET['info']['status']);
			if($start_addtime && $end_addtime) {
				$start = strtotime($start_addtime.' 00:00:00');
				$end = strtotime($end_addtime.' 23:59:59');
				$where .= "AND `addtime` >= '$start' AND  `addtime` <= '$end'";
			}
			if($status) $where .= "AND `status` LIKE '%$status%' ";
		}
		if($where) $where = substr($where, 3);
		$infos = $this->account_db->listinfo($where, 'addtime DESC', $page, '15');
		foreach(L('select') as $key=>$value) {
			$trade_status[$key] = $value;
		}
		$pages = $this->account_db->pages;
		include template('pay', 'pay_list');
	}

	public function pay() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		$pay_types = $this->handle->get_paytype();
		$trade_sn = create_sn();
		param::set_cookie('trade_sn',$trade_sn);
		$show_validator = 1;
		include template('pay', 'deposit');
	}

	/*
	 * 充值方式支付
	 */
	public function pay_recharge() {
			$memberinfo = $this->memberinfo;
			$grouplist = getcache('grouplist','member');
			$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
			$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
        if(isset($_POST['dosubmit'])) {
            $code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
            if ($_SESSION['code'] != strtolower($code)) {
                    showmessage(L('code_error'), HTTP_REFERER);
			}
            $pay_id = $_POST['pay_type'];
            if(!$pay_id) showmessage(L('illegal_pay_method'));
            $_POST['info']['name'] = safe_replace($_POST['info']['name']);
            $payment = $this->handle->get_payment($pay_id);
            $cfg = unserialize_config($payment['config']);
            $pay_name = ucwords($payment['pay_code']);
            if(!param::get_cookie('trade_sn')) {showmessage(L('illegal_creat_sn'));}
            $trade_sn   = param::get_cookie('trade_sn');
            if(preg_match('![^a-zA-Z0-9/+=]!', $trade_sn)) showmessage(L('illegal_creat_sn'));
            $usernote = $_POST['info']['usernote'] ? $_POST['info']['name'].'['.$trade_sn.']'.'-'.new_html_special_chars(trim($_POST['info']['usernote'])) : $_POST['info']['name'].'['.$trade_sn.']';

            $surplus = array(
                    'userid'      => $this->_userid,
                    'username'    => $this->_username,
                    'money'       => trim(floatval($_POST['info']['price'])),
                    'quantity'    => $_POST['quantity'] ? trim(intval($_POST['quantity'])) : 1,
                    'telephone'   => preg_match('/[^0-9\-]+/', $_POST['info']['telephone']) ? '' : trim($_POST['info']['telephone']),
                    'contactname' => $_POST['info']['name'] ? trim($_POST['info']['name']).L('recharge') : $this->_username.L('recharge'),
                    'email'       => is_email($_POST['info']['email']) ? trim($_POST['info']['email']) : '',
                    'addtime'     => SYS_TIME,
                    'ip'          => ip(),
                    'pay_type'    => 'recharge',
                    'pay_id'      => $payment['pay_id'],
                    'payment'     => trim($payment['pay_name']),
                    'ispay'       => '1',
                    'usernote'    => $usernote,
                    'trade_sn'    => $trade_sn,
            );

            $recordid = $this->handle->set_record($surplus);

            $factory_info = $this->handle->get_record($recordid);
            if(!$factory_info) showmessage(L('order_closed_or_finish'));
            $pay_fee = pay_fee($factory_info['money'],$payment['pay_fee'],$payment['pay_method']);
            $logistics_fee = $factory_info['logistics_fee'];
            $discount = $factory_info['discount'];

            // calculate amount
            $factory_info['price'] = $factory_info['money'] + $pay_fee + $logistics_fee + $discount;

            // add order info
            $product_info['trade_sn']   = $factory_info['trade_sn'];
            $product_info['total_fee'] = $factory_info['price'];
            $product_info['subject'] = '用户充值：'.$factory_info['price'];

            shy_base::load_app_class('pay_factory','',0);
            $payment_handler = new pay_factory($pay_name, $cfg);
            $gateway = $payment_handler->set_productinfo($product_info)->gateway();
            if($gateway === false) {
				showmessage("支付请求创建失败!");
			}
			if ($gateway['gateway_type'] == 'redirect') {
				redirect($gateway['gateway_url']);
			}
			$gateway['order_sn'] = $factory_info['trade_sn'];
            $gateway['trade_no'] = $factory_info['trade_sn'];
			$gateway['total_fee'] = $factory_info['price'];
			$gateway['url_forward'] = U('member/index/init');

		}
		else{
			showmessage("支付请求创建失败!");
		}
		include template('pay', 'payment_cofirm');
	}

	public function public_checkcode() {
		$code = $_GET['code'];
		if($_SESSION['code'] != strtolower($code)) {
			exit('0');
		} else {
			exit('1');
		}
	}

	public function ajax_check() {
		$order_sn = new_html_special_chars($_GET['order_sn']);
		if(empty($order_sn)) {
			exit(0);
		}

		$trade_exist = $this->account_db->get_one(array('trade_sn'=>$order_sn,'status'=>"succ"));
		if($trade_exist) {
			//showmessage("支付成功！", U('member/index/init'));
            $returndata = array('status'=>1,'message'=>'支付成功！','rel'=>'index.php?app=pay&controller=deposit&view=init');
            exit(json_encode($returndata));
		}else{
			exit(0);
		}
	}

	public function wechat() {
		$m_order = $this->account_db->get_one(array('trade_sn'=>$_GET['trade_no']));
		if (!$m_order || $this->_userid != $m_order['userid']) {
			showmessage("操作失败，没有权限！");
		}
		if ($m_order['status'] == "succ") {
			showmessage("订单已支付！");
		}

		$payment = $this->handle->get_payment($m_order['pay_id']);
        $cfg = unserialize_config($payment['config']);

		$pay_info['trade_sn']  = $m_order['trade_sn'];
		$pay_info['total_fee'] = $m_order['money'];
		$pay_info['subject']   = '订单号：'.$m_order['trade_sn'];
		//回调链接
		$success_url = U('pay/deposit/init');
		$error_url = U('pay/deposit/pay');
		/* 请求支付 */
		shy_base::load_app_class('pay_factory','',0);
        $payment_handler = new pay_factory(ucwords($_GET['pay_code']), $cfg);
        $gateway = $payment_handler->set_productinfo($pay_info)->gateway();
        if($gateway === false) {
			showmessage("支付请求创建失败!");
		}
		include template('pay', 'wxjspay');
	}
}
?>
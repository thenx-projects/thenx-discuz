<?php
/*
 *
 *  * Copyright 2012-2020 the original author or authors.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License");
 *  * you may not use this file except in compliance with the License.
 *  * You may obtain a copy of the License at
 *  *
 *  *      https://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * Unless required by applicable law or agreed to in writing, software
 *  * distributed under the License is distributed on an "AS IS" BASIS,
 *  * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  * See the License for the specific language governing permissions and
 *  * limitations under the License.
 *
 */

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: misc_buyinvitecode.php 31572 2012-09-10 08:59:03Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(submitcheck('buysubmit')) {
	if($_G['setting']['ec_tenpay_bargainor'] || $_G['setting']['ec_tenpay_opentrans_chnid'] || $_G['setting']['ec_account']) {
		$language = lang('forum/misc');
		$amount = intval($_GET['amount']);
		$email = dhtmlspecialchars($_GET['email']);
		if(empty($amount)) {
			showmessage('buyinvitecode_no_count');
		}
		if(strlen($email) < 6 || !preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email)) {
			showmessage('buyinvitecode_email_error');
		}

		$price = round($amount * $_G['setting']['inviteconfig']['invitecodeprice'], 2);
		$orderid = '';

		$apitype = is_numeric($_GET['bank_type']) ? 'tenpay' : $_GET['bank_type'];
		if(empty($apitype)) {
			showmessage('parameters_error');
		}
		require_once libfile('function/trade');
		$requesturl = invite_payurl($amount, $price, $orderid, $_GET['bank_type']);

		if(C::t('forum_order')->fetch($orderid)) {
			showmessage('credits_addfunds_order_invalid');
		}
		C::t('forum_order')->insert(array(
			'orderid' => $orderid,
			'status' => '1',
			'uid' => 0,
			'amount' => $amount,
			'price' => $price,
			'submitdate' => $_G['timestamp'],
			'email' => $email,
			'ip' => $_G['clientip'],
			'port' => $_G['remoteport'],
		));
		include template('common/header_ajax');
		echo '<form id="payform" action="'.$requesturl.'" method="post"></form><script type="text/javascript" reload="1">$(\'payform\').submit();</script>';
		include template('common/footer_ajax');
		dexit();
	} else {
		showmessage('action_closed', NULL);
	}

}
if($_GET['action'] == 'paysucceed' && $_GET['orderid']) {
	$orderid = $_GET['orderid'];
	$order = C::t('forum_order')->fetch($orderid);
	if(!$order) {
		showmessage('parameters_error');
	}
	$codes = array();
	foreach(C::t('common_invite')->fetch_all_orderid($orderid) as $code) {
		$codes[] = $code['code'];
	}
	if(empty($codes)) {
		showmessage('buyinvitecode_no_id');
	}
	$codetext = implode("\r\n", $codes);
}

if($_G['group']['maxinviteday']) {
	$maxinviteday = time() + 86400 * $_G['group']['maxinviteday'];
} else {
	$maxinviteday = time() + 86400 * 10;
}
$maxinviteday = dgmdate($maxinviteday, 'Y-m-d H:i');
$_G['setting']['inviteconfig']['invitecodeprompt'] = nl2br($_G['setting']['inviteconfig']['invitecodeprompt']);

include template('common/buyinvitecode');
?>
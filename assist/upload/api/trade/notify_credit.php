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
 *      $Id: notify_credit.php 34251 2013-11-25 03:10:11Z nemohou $
 */

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);

require '../../source/class/class_core.php';
require '../../source/function/function_forum.php';

$discuz = C::app();
$discuz->init();

$apitype = empty($_GET['attach']) || !preg_match('/^[a-z0-9]+$/i', $_GET['attach']) ? 'alipay' : $_GET['attach'];
require_once DISCUZ_ROOT.'./api/trade/api_'.$apitype.'.php';
$PHP_SELF = $_SERVER['PHP_SELF'];
$_G['siteurl'] = dhtmlspecialchars($_G['scheme'].'://'.$_SERVER['HTTP_HOST'].preg_replace("/\/+(api\/trade)?\/*$/i", '', substr($PHP_SELF, 0, strrpos($PHP_SELF, '/'))).'/');
$notifydata = trade_notifycheck('credit');

if($notifydata['validator']) {

	$orderid = $notifydata['order_no'];
	$postprice = $notifydata['price'];
	$order = C::t('forum_order')->fetch($orderid);
	$order = array_merge($order, C::t('common_member')->fetch_by_username($order['uid']));
	if($order && floatval($postprice) == floatval($order['price']) && ($apitype == 'tenpay' || strtolower($_G['setting']['ec_account']) == strtolower($_REQUEST['seller_email']))) {

		if($order['status'] == 1) {
			C::t('forum_order')->update($orderid, array('status' => '2', 'buyer' => "$notifydata[trade_no]\t$apitype", 'confirmdate' => $_G['timestamp']));
			updatemembercount($order['uid'], array($_G['setting']['creditstrans'] => $order['amount']), 1, 'AFD', $order['uid']);
			updatecreditbyaction($action, $uid = 0, $extrasql = array(), $needle = '', $coef = 1, $update = 1, $fid = 0);
			C::t('forum_order')->delete_by_submitdate($_G['timestamp']-60*86400);
			$submitdate = dgmdate($order['submitdate']);
			$confirmdate = dgmdate(TIMESTAMP);

			notification_add($order['uid'], 'credit', 'addfunds', array(
				'orderid' => $order['orderid'],
				'price' => $order['price'],
				'value' => $_G['setting']['extcredits'][$_G['setting']['creditstrans']]['title'].' '.$order['amount'].' '.$_G['setting']['extcredits'][$_G['setting']['creditstrans']]['unit']
			), 1);
		}

	}

}

if($notifydata['location']) {
	$url = rawurlencode('home.php?mod=spacecp&ac=credit');
	if($apitype == 'tenpay') {
		echo <<<EOS
<meta name="TENCENT_ONLINE_PAYMENT" content="China TENCENT">
<html>
<body>
<script language="javascript" type="text/javascript">
window.location.href='$_G[siteurl]forum.php?mod=misc&action=paysucceed';
</script>
</body>
</html>
EOS;
	} else {
		dheader('location: '.$_G['siteurl'].'forum.php?mod=misc&action=paysucceed');
	}
} else {
	exit($notifydata['notify']);
}

?>
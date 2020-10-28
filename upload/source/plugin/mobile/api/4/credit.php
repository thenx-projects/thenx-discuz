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
 *      $Id: credit.php 34983 2014-09-22 06:16:09Z nemohou $
 */

if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

include_once 'misc.php';

class mobile_api {

	function common() {
		global $_G;
		if (!$_G['uid'] || !in_array('wechat', $_G['setting']['plugins']['available'])) {
			mobile_core::result(mobile_core::variable(array()));
		}
		$_G['wechat']['setting'] = unserialize($_G['setting']['mobilewechat']);
		if (!$_G['wechat']['setting']['wsq_apicredit']) {
			mobile_core::result(mobile_core::variable(array()));
		}
		$extcredit = 'extcredits'.$_G['wechat']['setting']['wsq_apicredit'];
		$ac = $_GET['ac'];
		$return = array();
		if(submitcheck('creditsubmit') && ($ac == 'inc' || $ac == 'dec') && $_GET['value'] > 0) {
			$v = $ac == 'inc' ? $_GET['value'] : -$_GET['value'];
			$log = lang('plugin/wechat', 'wsq_apicredit_log_'.$ac);
			updatemembercount(array($_G['uid']), array($extcredit => $v), true, '', 0, '', $log);
			$data = C::t('common_member_count')->fetch($_G['uid']);
			$return['extcredit'] = $data[$extcredit];
		} elseif($ac == 'get') {
			$return['extcredit'] = getuserprofile($extcredit);
		}
		mobile_core::result(mobile_core::variable($return));
	}

	function output() {
	}

}

?>
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
 *      $Id: member_connect_logging.php 33543 2013-07-03 06:01:33Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!empty($_POST)) {
	if($result['member']['conisbind']) {
		showmessage('qqconnect:connect_register_bind_already');
	}
	if($result['member']['groupid'] == 8) {
		showmessage('qqconnect:connect_register_bind_need_inactive');
	}

	$conuin = $this->connect_guest['conuin'];
	$conuinsecret = $this->connect_guest['conuinsecret'];
	$conopenid = $this->connect_guest['conopenid'];
	$conuintoken = $this->connect_guest['conuintoken'];

	$user_auth_fields = 1;
	$conispublishfeed = 0;
	$conispublisht = 0;

	$is_use_qqshow = 0;

	if ($conopenid) {
		C::t('#qqconnect#common_member_connect')->insert(array('uid' => $uid, 'conuin' => $conuin, 'conuinsecret' => $conuinsecret, 'conuintoken' => $conuintoken, 'conopenid' => $conopenid, 'conispublishfeed' => $conispublishfeed, 'conispublisht' => $conispublisht, 'conisregister' => '0', 'conisqzoneavatar' => '0', 'conisfeed' => $user_auth_fields, 'conisqqshow' => $is_use_qqshow), false, true);
		C::t('common_member')->update($uid, array('conisbind' => '1'));
		C::t('#qqconnect#connect_memberbindlog')->insert(array('uid' => $uid, 'uin' => $conopenid, 'type' => '1', 'dateline' => $_G['timestamp']));

		C::t('#qqconnect#common_connect_guest')->delete($conopenid);

		dsetcookie('connect_js_name', 'user_bind', 86400);
		dsetcookie('connect_js_params', base64_encode(serialize(array('type' => 'registerbind'))), 86400);

		dsetcookie('connect_login', 1, 31536000);
		dsetcookie('connect_is_bind', '1', 31536000);
		dsetcookie('connect_uin', $conopenid, 31536000);
		dsetcookie('stats_qc_reg', 2, 86400);
		if ($_GET['is_feed']) {
			dsetcookie('connect_synpost_tip', 1, 31536000);
		}

	} else {
		showmessage('qqconnect:connect_get_access_token_failed', dreferer());
	}
}

?>
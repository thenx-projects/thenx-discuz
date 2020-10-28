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
 *      $Id: connect_user.php 29265 2012-03-31 06:03:26Z yexinhao $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

include template('common/header');

$op = !empty($_GET['op']) ? trim($_GET['op'], '/') : '';
if(!in_array($op, array('get'))) {
	connect_error_output('undefined_action');
}

if($_GET['hash'] != formhash()) {
	connect_error_output('submit_invalid');
}

if($op == 'get') {

	$conopenid = authcode($_G['cookie']['con_auth_hash']);
	$connect_guest = C::t('#qqconnect#common_connect_guest')->fetch($conopenid);
	if(!$connect_guest) {
		dsetcookie('con_auth_hash');
		connect_error_output('qqconnect:connect_login_first');
	}

	$conuin = $connect_guest['conuin'];
	$conuinsecret = $connect_guest['conuinsecret'];

	if($conuin && $conuinsecret && $conopenid) {
		try {
			require_once DISCUZ_ROOT.'/source/plugin/qqconnect/lib/ConnectOAuth.php';
			$connectOAuthClient = new Cloud_Service_Client_ConnectOAuth();
			$connect_user_info = $connectOAuthClient->connectGetUserInfo($conopenid, $conuin, $conuinsecret);
		} catch(Exception $e) {
			connect_error_output();
		}
		if ($connect_user_info['nickname']) {
			$qq_nick = $connect_user_info['nickname'];
			$connect_nickname = $connectService->connectFilterUsername($qq_nick);
		}

		loaducenter();
		$ucresult = uc_user_checkname($connect_nickname);
		$first_available_username = '';
		if($ucresult >= 0) {
			$first_available_username = $connect_nickname;
		}
		echo $first_available_username;
	}
}

include template('common/footer');

function connect_error_output($error = '') {
	include template('common/footer');
	exit;
}
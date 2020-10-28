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
 *      $Id: login.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'logging';
$_GET['action'] = !empty($_GET['action']) ? $_GET['action'] : 'login';
include_once 'member.php';

class mobile_api {

	function common() {
		if(!empty($_GET['mlogout'])) {
			if($_GET['hash'] == formhash()) {			
				clearcookies();
			}
			mobile_core::result(array());
		}
	}

	function output() {
		global $_G;
		parse_str($_G['messageparam'][1], $p);
		$variable = array('auth' => $p['auth']);
		if($_G['uid']) {
			require_once DISCUZ_ROOT.'./source/plugin/wechat/wsq.class.php';
			if(method_exists('wsq', 'userloginUrl')) {
				$_source = isset($_GET['_source']) ? $_GET['_source'] : '';
				if(!$_source && !empty($_GET['openid']) && !empty($_GET['openidsign'])) {
					$variable['loginUrl'] = wsq::userloginUrl($_G['uid'], $_GET['openid'], $_GET['openidsign']);
					if(!C::t('#wechat#common_member_wechatmp')->fetch($_G['uid'])) {
						C::t('#wechat#common_member_wechatmp')->insert(array('uid' => $_G['uid'], 'openid' => $_GET['openid'], 'status' => 1), false, true);
					}
				} else {
					$variable['loginUrl'] = wsq::userloginUrl2($_G['uid']);
				}
			}
		}
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>
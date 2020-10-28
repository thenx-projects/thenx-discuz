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
 *      $Id: register.php 32489 2013-01-29 03:57:16Z monkey $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

include_once 'member.php';

class mobile_api {

	function common() {
		global $_G;
		if(empty($_POST['regsubmit'])) {
			$_G['mobile_version'] = intval($_GET['version']);
		}
		require_once libfile('class/member');
		$ctl_obj = new register_ctl();
		$ctl_obj->setting = $_G['setting'];
		$ctl_obj->template = 'mobile:register';
		$ctl_obj->on_register();
		if(empty($_POST['regsubmit'])) {
			exit;
		}
	}

	function output() {
		mobile_core::result(mobile_core::variable());
	}

}

?>
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
 *	  [Discuz!] (C)2001-2009 Comsenz Inc.
 *	  This is NOT a freeware, use is subject to license terms
 *
 *	  $Id: connect_check.php 31305 2012-08-09 06:36:16Z liudongdong $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'/source/plugin/qqconnect/lib/Util.php';
$utilService = new Cloud_Service_Util();

$op = !empty($_GET['op']) ? $_GET['op'] : '';
if (!in_array($op, array('cookie'))) {
	$connectService->connectAjaxOuputMessage('0', '1');
}

if ($op == 'cookie') {
	loadcache('connect_login_report_date');
	$cookieLogins = C::t('common_setting')->fetch('connect_login_times');
	if (dgmdate(TIMESTAMP, 'Y-m-d') != $_G['cache']['connect_login_report_date']) {
		if (!discuz_process::islocked('connect_login_report', 600)) {
			$result = $connectService->connectCookieLoginReport($cookieLogins);
			if (isset($result['status']) && $result['status'] == 0) {
				$date = dgmdate(TIMESTAMP, 'Y-m-d');
				C::t('common_setting')->update('connect_login_times', 0);
				C::t('common_setting')->update('connect_login_report_date', $date);
				savecache('connect_login_report_date', $date);
			}
		}
		discuz_process::unlock('connect_login_report');
	}
}

include template('common/header_ajax');
include template('common/footer_ajax');
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
 *      $Id: optimizer_dbbackup.php 33488 2013-06-24 01:48:20Z jeffjzhang $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class optimizer_dbbackup {

	public function __construct() {

	}

	public function check() {
		global $_G;
		$dateline = C::t('common_cache')->fetch('db_export');
		$dateline = dunserialize($dateline['cachevalue']);
		$dateline = $dateline['dateline'];
		if(($_G['timestamp'] - $dateline) > 86400 * 90) {
			$return = array('status' => 1, 'type' => 'header', 'lang' => lang('optimizer', 'optimizer_dbbackup_advice'));
		} else {
			$return = array('status' => 0, 'type' => 'header', 'lang' => lang('optimizer', 'optimizer_dbbackup_lastback').dgmdate($dateline));
		}
		return $return;
	}

	public function optimizer() {
		global $_G;
		$adminfile = defined(ADMINSCRIPT) ? ADMINSCRIPT : 'admin.php';
		dheader('Location: '.$_G['siteurl'].$adminfile.'?action=db&operation=export');
	}
}

?>
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
 *      $Id: cron_publish_halfhourly.php 31463 2012-08-30 08:59:17Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/forum');
require_once libfile('function/post');

loadcache('cronpublish');

$dataChanged = false;
$cron_publish_ids = array();
$cron_publish_ids = getglobal('cache/cronpublish');
if (count($cron_publish_ids) > 0) {
	$threadall = C::t('forum_thread')->fetch_all_by_tid($cron_publish_ids);

	foreach ($cron_publish_ids as $tid) {
		if(!$threadall[$tid]) {
			unset($cron_publish_ids[$tid]);
			$dataChanged = true;
		}
	}

	foreach ($threadall as $stid=>$sdata) {
		if ($sdata['dateline'] <= getglobal('timestamp')) {
			threadpubsave($stid, true);
			unset($cron_publish_ids[$stid]);
			$dataChanged = true;
		}
	}

	if ($dataChanged === true) {
		savecache('cronpublish', $cron_publish_ids);
	}
}

?>
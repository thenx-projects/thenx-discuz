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
 *      $Id: cache_announcements.php 24152 2011-08-26 10:04:08Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_announcements() {
	$data = C::t('forum_announcement')->fetch_all_by_date(TIMESTAMP);

	foreach ($datarow as $data) {
		if($datarow['type'] == 2) {
			$datarow['pmid'] = $datarow['id'];
			unset($datarow['id']);
			unset($datarow['message']);
			$datarow['subject'] = cutstr($datarow['subject'], 60);
		}
		$datarow['groups'] = empty($datarow['groups']) ? array() : explode(',', $datarow['groups']);
		$data[] = $datarow;
	}

	savecache('announcements', $data);
}

?>
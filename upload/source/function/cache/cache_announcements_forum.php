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
 *      $Id: cache_announcements_forum.php 26271 2011-12-07 09:15:53Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_announcements_forum() {
	$data = array();

	$data = C::t('forum_announcement')->fetch_by_displayorder(TIMESTAMP);
	if($data) {
		$memberdata = C::t('common_member')->fetch_uid_by_username($data['author']);
		$data['authorid'] = $memberdata['uid'];
		$data['authorid'] = intval($data['authorid']);
		if(empty($data['type'])) {
			unset($data['message']);
		}
	} else {
		$data = array();
	}
	savecache('announcements_forum', $data);
}

?>
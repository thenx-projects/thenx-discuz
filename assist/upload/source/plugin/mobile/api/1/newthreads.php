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
 *      $Id: newthreads.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

include_once 'forum.php';

class mobile_api {

	function common() {
		global $_G;
		$start = !empty($_GET['start']) ? $_GET['start'] : 0;
		$limit = !empty($_GET['limit']) ? $_GET['limit'] : 20;
		$variable['data'] = C::t('forum_newthread')->fetch_all_by_fids(dintval(explode(',', $_GET['fids']), true), $start, $limit);
		foreach(C::t('forum_thread')->fetch_all_by_tid(array_keys($variable['data']), 0, $limit) as $thread) {
			$thread['dbdateline'] = $thread['dateline'];
			$thread['dblastpost'] = $thread['lastpost'];
			$thread['dateline'] = dgmdate($thread['dateline'], 'u');
			$thread['lastpost'] = dgmdate($thread['lastpost'], 'u');
			$variable['data'][$thread['tid']] = mobile_core::getvalues($thread, array('tid', 'author', 'authorid', 'subject', 'subject', 'dbdateline', 'dateline', 'dblastpost', 'lastpost', 'lastposter', 'attachment', 'replies', 'readperm', 'views', 'digest'));
		}
		$variable['data'] = array_values($variable['data']);
		mobile_core::result(mobile_core::variable($variable));
	}

	function output() {}

}

?>
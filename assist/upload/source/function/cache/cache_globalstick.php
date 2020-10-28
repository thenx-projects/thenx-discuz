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
 *      $Id: cache_globalstick.php 24152 2011-08-26 10:04:08Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_globalstick() {
	$data = array();
	$query = C::t('forum_forum')->fetch_all_valid_forum();
	$fuparray = $threadarray = array();
	foreach($query as $forum) {
		switch($forum['type']) {
			case 'forum':
				$fuparray[$forum['fid']] = $forum['fup'];
				break;
			case 'sub':
				$fuparray[$forum['fid']] = $fuparray[$forum['fup']];
				break;
		}
	}
	foreach(C::t('forum_thread')->fetch_all_by_displayorder(array(2, 3)) as $thread) {
		switch($thread['displayorder']) {
			case 2:
				$threadarray[$fuparray[$thread['fid']]][] = $thread['tid'];
				break;
			case 3:
				$threadarray['global'][] = $thread['tid'];
				break;
		}
	}
	foreach(array_unique($fuparray) as $gid) {
		if(!empty($threadarray[$gid])) {
			$data['categories'][$gid] = array(
				'tids'	=> dimplode($threadarray[$gid]),
				'count'	=> intval(@count($threadarray[$gid]))
			);
		}
	}
	$data['global'] = array(
		'tids'	=> empty($threadarray['global']) ? '' : dimplode($threadarray['global']),
		'count'	=> intval(@count($threadarray['global']))
	);

	savecache('globalstick', $data);
}

?>
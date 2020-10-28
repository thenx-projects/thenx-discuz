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
 *      $Id: cache_forumrecommend.php 24152 2011-08-26 10:04:08Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_forumrecommend() {
	$data = array();
	$fids = C::t('forum_forum')->fetch_all_fids();
	foreach($fids as $row) {
		require_once libfile('function/group');
		$recommendlist = C::t('forum_forum')->fetch_all_recommend_by_fid($row['fid']);
		foreach($recommendlist as $info) {
			$group = array('fid' => $info['fid'], 'name' => $info['name'], 'threads' => $info['threads'], 'lastpost' => $info['lastpost'], 'icon' => $info['icon'], 'membernum' => $info['membernum'], 'description' => $info['description']);
			$group['icon'] = get_groupimg($group['icon'], 'icon');
			$lastpost = array(0, 0, '', '');
			$group['lastpost'] = is_string($group['lastpost']) ? explode("\t", $group['lastpost']) : $group['lastpost'];
			$group['lastpost'] =count($group['lastpost']) != 4 ? $lastpost : $group['lastpost'];
			list($lastpost['tid'], $lastpost['subject'], $lastpost['dateline'], $lastpost['author']) = $group['lastpost'];
			if($lastpost['tid']) {
				$lastpost['dateline'] = dgmdate($lastpost['dateline'], 'Y-m-d H:i:s');
				if($lastpost['author']) {
					$lastpost['encode_author'] = rawurlencode($lastpost['author']);
				}
				$group['lastpost'] = $lastpost;
			} else {
				$group['lastpost'] = '';
			}
			$data[$row['fid']][] = $group;
		}
	}

	savecache('forumrecommend', $data);
}

?>
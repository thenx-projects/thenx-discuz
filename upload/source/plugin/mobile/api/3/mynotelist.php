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
*      $Id: mynotelist.php 34236 2013-11-21 01:13:12Z nemohou $
*/

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'notice';
include_once 'home.php';

class mobile_api {
	function common() {

	}

	function output() {
		global $_G;

		$noticelang = lang('notification', 'reppost_noticeauthor');
		$noticepreg = '/^'.str_replace(array('\{actor\}', '\{subject\}', '\{tid\}', '\{pid\}'), array('(.+?)', '(.+?)', '(\d+)', '(\d+)'), preg_quote($noticelang, '/')).'$/';
		$actorlang = '<a href="home.php?mod=space&uid={actoruid}">{actorusername}</a>';
		$actorpreg = '/^'.str_replace(array('\{actoruid\}', '\{actorusername\}'), array('(\d+)', '(.+?)'), preg_quote($actorlang, '/')).'$/';

		foreach($GLOBALS['list'] as $_k => $_v) {
			if(preg_match($noticepreg, $_v['note'], $_r)) {
				list(, $actor, $tid, $pid, $subject) = $_r;
				if(preg_match($actorpreg, $actor, $_r)) {
					list(, $actoruid, $actorusername) = $_r;
				}
				$GLOBALS['list'][$_k]['notevar'] = array(
					'tid' => $tid,
					'pid' => $pid,
					'subject' => $subject,
					'actoruid' => $actoruid,
					'actorusername' => $actorusername,
				);
			}
		}
		$variable = array(
			'list' => mobile_core::getvalues(array_values($GLOBALS['list']), array('/^\d+$/'), array('id', 'uid', 'type', 'new', 'authorid', 'author', 'note', 'dateline', 'from_id', 'from_idtype', 'from_num', 'style', 'rowid', 'notevar')),
			'count' => $GLOBALS['count'],
			'perpage' => $GLOBALS['perpage'],
			'page' => intval($GLOBALS['page']),
		);
		mobile_core::result(mobile_core::variable($variable));
	}
}
?>
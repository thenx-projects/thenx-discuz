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
 *      $Id: myfavforum.php 34236 2013-11-21 01:13:12Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'favorite';
$_GET['type'] = 'forum';
include_once 'home.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$fids = array();
		foreach($GLOBALS['list'] as $_k => $_v) {
			$fids[$_v['id']] = $_k;
		}
		if($fids) {
			$favforumlist = C::t('forum_forum')->fetch_all(array_keys($fids));
			foreach($favforumlist as $_fid => $_v) {
				$GLOBALS['list'][$fids[$_fid]]['threads'] = $_v['threads'];
				$GLOBALS['list'][$fids[$_fid]]['posts'] = $_v['posts'];
				$GLOBALS['list'][$fids[$_fid]]['todayposts'] = $_v['todayposts'];
				$GLOBALS['list'][$fids[$_fid]]['yesterdayposts'] = $_v['yesterdayposts'];
			}
		}
		$variable = array(
			'list' => array_values($GLOBALS['list']),
			'perpage' => $GLOBALS['perpage'],
			'count' => $GLOBALS['count'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>
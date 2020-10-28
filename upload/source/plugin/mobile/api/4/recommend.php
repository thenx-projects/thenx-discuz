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
 *      $Id: recommend.php 34398 2014-04-14 07:11:22Z nemohou $
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'misc';
$_GET['action'] = 'recommend';
$_GET['do'] = 'add';
include_once 'forum.php';

class mobile_api {

	function common() {

	}

	function output() {
		mobile_core::result(mobile_core::variable(array()));
	}

	function misc_mobile_message($message) {
		global $_G, $thread;
		if (!in_array($message, array('recommend_succed', 'recommend_daycount_succed'))) {
			return;
		}
		$thaquote = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);
		$quote = $thaquote['message'];
		$quote = messagecutstr($quote, 100);
		$quote = implode("\n", array_slice(explode("\n", $quote), 0, 3));
	}

}

?>
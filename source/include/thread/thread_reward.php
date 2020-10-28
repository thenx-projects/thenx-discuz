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
 *      $Id: thread_reward.php 24359 2011-09-14 07:54:47Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$bapid = 0;
$rewardprice = abs($_G['forum_thread']['price']);
$dateline = $_G['forum_thread']['dateline'] + 1;
$bestpost = array();
if($_G['forum_thread']['price'] < 0 && $page == 1) {
	foreach($postlist as $key => $post) {
		if($post['dbdateline'] == $dateline) {
			$bapid = $key;
			break;
		}
	}
}

if($bapid) {
	$bestpost = C::t('forum_post')->fetch($posttableid, $bapid);
	$bestpost['message'] = messagecutstr($bestpost['message'], 400);
	$bestpost['avatar'] = avatar($bestpost['authorid'], 'small');
}

?>
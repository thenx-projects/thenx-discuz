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
 *      $Id: forum_announcement.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/discuzcode');

$announcedata = C::t('forum_announcement')->fetch_all_by_date($_G['timestamp']);

if(!count($announcedata)) {
	showmessage('announcement_nonexistence');
}

$announcelist = array();
foreach ($announcedata as $announce) {
	$announce['authorenc'] = rawurlencode($announce['author']);
	$tmp = explode('.', dgmdate($announce['starttime'], 'Y.m'));
	$months[$tmp[0].$tmp[1]] = $tmp;
	if(!empty($_GET['m']) && $_GET['m'] != dgmdate($announce['starttime'], 'Ym')) {
		continue;
	}
	$announce['starttime'] = dgmdate($announce['starttime'], 'd');
	$announce['endtime'] = $announce['endtime'] ? dgmdate($announce['endtime'], 'd') : '';
	$announce['message'] = $announce['type'] == 1 ? "[url]{$announce[message]}[/url]" : $announce['message'];
	$announce['message'] = nl2br(discuzcode($announce['message'], 0, 0, 1, 1, 1, 1, 1));
	$announcelist[] = $announce;
}
$annid = isset($_GET['id']) ? intval($_GET['id']) : 0;

include template('forum/announcement');

?>
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
 *      $Id: topicadmin_stamp.php 33825 2013-08-19 08:32:40Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowstampthread']) {
	showmessage('no_privilege_stampthread');
}

loadcache('stamps');

if(!submitcheck('modsubmit')) {

	include template('forum/topicadmin_action');

} else {

	$modaction = $_GET['stamp'] !== '' ? 'SPA' : 'SPD';
	$_GET['stamp'] = $_GET['stamp'] !== '' ? $_GET['stamp'] : -1;
	$reason = checkreasonpm();

	C::t('forum_thread')->update($_G['tid'], array('moderated'=>1, 'stamp'=>$_GET['stamp']));
	if($modaction == 'SPA' && $_G['cache']['stamps'][$_GET['stamp']]['icon']) {
		C::t('forum_thread')->update($_G['tid'], array('icon'=>$_G['cache']['stamps'][$_GET['stamp']]['icon']));
		C::t('forum_threadhidelog')->delete_by_tid($_G['tid']);
	} elseif($modaction == 'SPD' && $_G['cache']['stamps'][$thread['stamp']]['icon'] == $thread['icon']) {
		C::t('forum_thread')->update($_G['tid'], array('icon'=>-1));
	}

	C::t('common_member_secwhite')->add($thread['authorid']);

	$resultarray = array(
	'redirect'	=> "forum.php?mod=viewthread&tid=$_G[tid]&page=$page",
	'reasonpm'	=> ($sendreasonpm ? array('data' => array($thread), 'var' => 'thread', 'notictype' => 'post', 'item' => $_GET['stamp'] !== '' ? 'reason_stamp_update' : 'reason_stamp_delete') : array()),
	'reasonvar'	=> array('tid' => $thread['tid'], 'subject' => $thread['subject'], 'modaction' => $modaction, 'reason' => $reason, 'stamp' => $_G['cache']['stamps'][$stamp]['text']),
	'modaction'	=> $modaction,
	'modlog'	=> $thread
	);
	$modpostsnum = 1;

	updatemodlog($_G['tid'], $modaction, 0, 0, '', $modaction == 'SPA' ? $_GET['stamp'] : 0);

}

?>
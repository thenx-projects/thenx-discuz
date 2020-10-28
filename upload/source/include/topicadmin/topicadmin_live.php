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
 *      $Id: topicadmin_live.php 32028 2012-10-31 10:12:22Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowlivethread']) {
	showmessage('no_privilege_livethread');
}

if(!submitcheck('modsubmit')) {

	include template('forum/topicadmin_action');

} else {

	$modaction = $_GET['live'] ? 'LIV' : 'LIC';
	$reason = checkreasonpm();
	$expiration = $_GET['expirationlive'] ? dintval($_GET['expirationlive']) : 0;

	if($modaction == 'LIV') {
		C::t('forum_forumfield')->update($_G['fid'], array('livetid' => $_G['tid']));
	} elseif($modaction == 'LIC') {
		if($_G['tid'] != $_G['forum']['livetid']) {
			showmessage('topicadmin_live_noset_error');
		}
		C::t('forum_forumfield')->update($_G['fid'], array('livetid' => 0));
	}

	$resultarray = array(
	'redirect'	=> "forum.php?mod=viewthread&tid=$_G[tid]&page=$page",
	'reasonpm'	=> ($sendreasonpm ? array('data' => array($thread), 'var' => 'thread', 'notictype' => 'post', 'item' => $_GET['live'] ? 'reason_live_update' : 'reason_live_cancle') : array()),
	'reasonvar'	=> array('tid' => $thread['tid'], 'subject' => $thread['subject'], 'modaction' => $modaction, 'reason' => $reason),
	'modaction'	=> $modaction,
	'modlog'	=> $thread
	);
	$modpostsnum = 1;

	updatemodlog($_G['tid'], $modaction, $expiration, 0, '', $modaction == 'LIV' ? 1 : 0);

}

?>
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
 *      $Id: topicadmin_split.php 30872 2012-06-27 10:11:44Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowsplitthread']) {
	showmessage('no_privilege_splitthread');
}

$thread = C::t('forum_thread')->fetch($_G['tid']);
$posttableid = $thread['posttableid'];
if(!submitcheck('modsubmit')) {

	require_once libfile('function/discuzcode');

	$replies = $thread['replies'];
	if($replies <= 0) {
		showmessage('admin_split_invalid');
	}

	$postlist = array();
	foreach(C::t('forum_post')->fetch_all_by_tid('tid:'.$_G['tableid'], $_G['tid'], 'ASC') as $post) {
		$post['message'] = discuzcode($post['message'], $post['smileyoff'], $post['bbcodeoff'], sprintf('%00b', $post['htmlon']), $_G['forum']['allowsmilies'], $_G['forum']['allowbbcode'], $_G['forum']['allowimgcode'], $_G['forum']['allowhtml']);
		$postlist[] = $post;
	}
	include template('forum/topicadmin_action');

} else {

	if(!trim($_GET['subject'])) {
		showmessage('admin_split_subject_invalid');
	} elseif(!($nos = explode(',', $_GET['split']))) {
		showmessage('admin_split_new_invalid');
	}

	sort($nos);
	foreach(C::t('forum_post')->fetch_all_by_tid_position($thread['posttableid'], $_G['tid'], $nos) as $post) {
		$pids[] = $post['pid'];
	}
	if(!($pids = implode(',',$pids))) {
		showmessage('admin_split_new_invalid');
	}

	$modaction = 'SPL';

	$reason = checkreasonpm();

	$subject = dhtmlspecialchars($_GET['subject']);

	$newtid = C::t('forum_thread')->insert(array('fid'=>$_G['fid'], 'posttableid'=>$posttableid, 'subject'=>$subject), true);

	C::t('forum_post')->update('tid:'.$_G['tid'], explode(',', $pids), array('tid' => $newtid));
	updateattachtid('pid', (array)explode(',', $pids), $_G['tid'], $newtid);

	$splitauthors = array();
	foreach(C::t('forum_post')->fetch_all_visiblepost_by_tid_groupby_authorid('tid:'.$_G['tid'], $newtid) as $splitauthor) {
		$splitauthor['subject'] = $subject;
		$splitauthors[] = $splitauthor;
	}

	C::t('forum_post')->update('tid:'.$_G['tid'], $splitauthors[0]['pid'], array('first' => 1, 'subject' => $subject), true);

	$query = C::t('forum_post')->fetch_all_by_tid('tid:'.$_G['tid'], $_G['tid'], false, 'ASC', 0, 1);
	foreach($query as $row) {
		$fpost = $row;
	}
	C::t('forum_thread')->update($_G['tid'], array('author'=>$fpost['author'], 'authorid'=>$fpost['authorid'],'dateline'=>$fpost['dateline'], 'moderated'=>1));
	C::t('forum_post')->update('tid:'.$_G['post'], $fpost['pid'], array('first' => 1, 'subject' => $thread['subject']));

	$query = C::t('forum_post')->fetch_all_by_tid('tid:'.$_G['tid'], $newtid, false, 'ASC', 0, 1);
	foreach($query as $row) {
		$fpost = $row;
	}
	$maxposition = 1;
	foreach(C::t('forum_post')->fetch_all_by_tid('tid:'.$_G['tid'], $_G['tid'], false, 'ASC') as $row) {
		if($row['position'] != $maxposition) {
			C::t('forum_post')->update('tid:'.$_G['tid'], $row['pid'], array('position' => $maxposition));
		}
		$maxposition ++;
	}
	C::t('forum_thread')->update($_G['tid'], array('maxposition' => $maxposition));
	$maxposition = 1;
	foreach(C::t('forum_post')->fetch_all_by_tid('tid:'.$_G['tid'], $newtid, false, 'ASC') as $row) {
		if($row['position'] != $maxposition) {
			C::t('forum_post')->update('tid:'.$_G['tid'], $row['pid'], array('position' => $maxposition));
		}
		$maxposition ++;
	}
	C::t('forum_thread')->update($newtid, array('author'=>$fpost['author'], 'authorid'=>$fpost['authorid'], 'dateline'=>$fpost['dateline'], 'rate'=>intval(@($fpost['rate'] / abs($fpost['rate']))), 'maxposition' => $maxposition));
	updatethreadcount($_G['tid']);
	updatethreadcount($newtid);
	updateforumcount($_G['fid']);

	$_G['forum']['threadcaches'] && deletethreadcaches($thread['tid']);

	$modpostsnum++;
	$resultarray = array(
	'redirect'	=> "forum.php?mod=forumdisplay&fid=$_G[fid]",
	'reasonpm'	=> ($sendreasonpm ? array('data' => $splitauthors, 'var' => 'thread', 'item' => 'reason_moderate', 'notictype' => 'post') : array()),
	'reasonvar'	=> array('tid' => $thread['tid'], 'subject' => $thread['subject'], 'modaction' => $modaction, 'reason' => $reason),
	'modtids'	=> $thread['tid'].','.$newtid,
	'modlog'	=> array($thread, array('tid' => $newtid, 'subject' => $subject))
	);

}

?>
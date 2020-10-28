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
 *      $Id: topicadmin_repair.php 24573 2011-09-26 10:31:21Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowrepairthread']) {
	showmessage('no_privilege_repairthread');
}

$posttable = getposttablebytid($_G['tid']);

$replies = C::t('forum_post')->count_visiblepost_by_tid($_G['tid']) - 1;

$attachcount = C::t('forum_attachment_n')->count_by_id('tid:'.$_G['tid'], 'tid', $_G['tid']);
$attachment = $attachcount ? (C::t('forum_attachment_n')->count_image_by_id('tid:'.$_G['tid'], 'tid', $_G['tid']) ? 2 : 1) : 0;

$firstpost = C::t('forum_post')->fetch_visiblepost_by_tid('tid:'.$_G['tid'], $_G['tid'], 0);
$firstpost['subject'] = addslashes(cutstr($firstpost['subject'], 79));
@$firstpost['rate'] = $firstpost['rate'] / abs($firstpost['rate']);

$lastpost = C::t('forum_post')->fetch_visiblepost_by_tid('tid:'.$_G['tid'], $_G['tid'], 0, 1);

C::t('forum_thread')->update($_G['tid'], array('subject'=>$firstpost['subject'], 'replies'=>$replies, 'lastpost'=>$lastpost['dateline'], 'lastposter'=>$lastpost['author'], 'rate'=>$firstpost['rate'], 'attachment'=>$attachment), true);
C::t('forum_post')->update_by_tid('tid:'.$_G['tid'], $_G['tid'], array('first' => 0), true);
C::t('forum_post')->update('tid:'.$_G['tid'], $firstpost['pid'], array('first' => 1, 'subject' => $firstpost['subject']), true);

showmessage('admin_repair_succeed', '', array(), array('alert' => 'right'));

?>
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
 *      $Id: topicadmin_getip.php 33709 2013-08-06 09:06:56Z andyzheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowviewip']) {
	showmessage('no_privilege_viewip');
}

$pid = $_GET['pid'];
$member = array();
$post = C::t('forum_post')->fetch('tid:'.$_G['tid'], $pid, false);
if($post && $post['tid'] == $_G['tid']) {
	$member = getuserbyuid($post['authorid']);
	$member = array_merge($post, $member);
}
if(!$member) {
	showmessage('thread_nonexistence', NULL);
} elseif(($member['adminid'] == 1 && $_G['adminid'] > 1) || ($member['adminid'] == 2 && $_G['adminid'] > 2)) {
	showmessage('admin_getip_nopermission', NULL);
}

$member['iplocation'] = convertip($member['useip']);

$member['useip'] = ip::to_display($member['useip']);

include template('forum/topicadmin_getip');

?>